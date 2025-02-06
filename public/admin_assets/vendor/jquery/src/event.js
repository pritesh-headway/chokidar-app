define([
	"./core",
	"./var/document",
	"./var/documentElement",
	"./var/isFunction",
	"./var/rnothtmlwhite",
	"./var/rcheckableType",
	"./var/slice",
	"./data/var/acceptData",
	"./data/var/dataPriv",
	"./core/nodeName",

	"./core/init",
	"./selector"
], function (jQuery, document, documentElement, isFunction, rnothtmlwhite,
	rcheckableType, slice, acceptData, dataPriv, nodeName) {

	"use strict";

	var rtypenamespace = /^([^.]*)(?:\.(.+)|)/;

	function returnTrue() {
		return true;
	}

	function returnFalse() {
		return false;
	}
	function expectSync(elem, type) {
		return (elem === safeActiveElement()) === (type === "focus");
	}
	function safeActiveElement() {
		try {
			return document.activeElement;
		} catch (err) { }
	}

	function on(elem, types, selector, data, fn, one) {
		var origFn, type;
		if (typeof types === "object") {
			if (typeof selector !== "string") {
				data = data || selector;
				selector = undefined;
			}
			for (type in types) {
				on(elem, type, selector, data, types[type], one);
			}
			return elem;
		}

		if (data == null && fn == null) {
			fn = selector;
			data = selector = undefined;
		} else if (fn == null) {
			if (typeof selector === "string") {
				fn = data;
				data = undefined;
			} else {
				fn = data;
				data = selector;
				selector = undefined;
			}
		}
		if (fn === false) {
			fn = returnFalse;
		} else if (!fn) {
			return elem;
		}

		if (one === 1) {
			origFn = fn;
			fn = function (event) {
				jQuery().off(event);
				return origFn.apply(this, arguments);
			};
			fn.guid = origFn.guid || (origFn.guid = jQuery.guid++);
		}
		return elem.each(function () {
			jQuery.event.add(this, types, fn, data, selector);
		});
	}

	/*
	 * Helper functions for managing events -- not part of the public interface.
	 * Props to Dean Edwards' addEvent library for many of the ideas.
	 */
	jQuery.event = {

		global: {},

		add: function (elem, types, handler, data, selector) {

			var handleObjIn, eventHandle, tmp,
				events, t, handleObj,
				special, handlers, type, namespaces, origType,
				elemData = dataPriv.get(elem);
			if (!acceptData(elem)) {
				return;
			}
			if (handler.handler) {
				handleObjIn = handler;
				handler = handleObjIn.handler;
				selector = handleObjIn.selector;
			}
			if (selector) {
				jQuery.find.matchesSelector(documentElement, selector);
			}
			if (!handler.guid) {
				handler.guid = jQuery.guid++;
			}
			if (!(events = elemData.events)) {
				events = elemData.events = Object.create(null);
			}
			if (!(eventHandle = elemData.handle)) {
				eventHandle = elemData.handle = function (e) {
					return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ?
						jQuery.event.dispatch.apply(elem, arguments) : undefined;
				};
			}
			types = (types || "").match(rnothtmlwhite) || [""];
			t = types.length;
			while (t--) {
				tmp = rtypenamespace.exec(types[t]) || [];
				type = origType = tmp[1];
				namespaces = (tmp[2] || "").split(".").sort();
				if (!type) {
					continue;
				}
				special = jQuery.event.special[type] || {};
				type = (selector ? special.delegateType : special.bindType) || type;
				special = jQuery.event.special[type] || {};
				handleObj = jQuery.extend({
					type: type,
					origType: origType,
					data: data,
					handler: handler,
					guid: handler.guid,
					selector: selector,
					needsContext: selector && jQuery.expr.match.needsContext.test(selector),
					namespace: namespaces.join(".")
				}, handleObjIn);
				if (!(handlers = events[type])) {
					handlers = events[type] = [];
					handlers.delegateCount = 0;
					if (!special.setup ||
						special.setup.call(elem, data, namespaces, eventHandle) === false) {

						if (elem.addEventListener) {
							elem.addEventListener(type, eventHandle);
						}
					}
				}

				if (special.add) {
					special.add.call(elem, handleObj);

					if (!handleObj.handler.guid) {
						handleObj.handler.guid = handler.guid;
					}
				}
				if (selector) {
					handlers.splice(handlers.delegateCount++, 0, handleObj);
				} else {
					handlers.push(handleObj);
				}
				jQuery.event.global[type] = true;
			}

		},
		remove: function (elem, types, handler, selector, mappedTypes) {

			var j, origCount, tmp,
				events, t, handleObj,
				special, handlers, type, namespaces, origType,
				elemData = dataPriv.hasData(elem) && dataPriv.get(elem);

			if (!elemData || !(events = elemData.events)) {
				return;
			}
			types = (types || "").match(rnothtmlwhite) || [""];
			t = types.length;
			while (t--) {
				tmp = rtypenamespace.exec(types[t]) || [];
				type = origType = tmp[1];
				namespaces = (tmp[2] || "").split(".").sort();
				if (!type) {
					for (type in events) {
						jQuery.event.remove(elem, type + types[t], handler, selector, true);
					}
					continue;
				}

				special = jQuery.event.special[type] || {};
				type = (selector ? special.delegateType : special.bindType) || type;
				handlers = events[type] || [];
				tmp = tmp[2] &&
					new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)");
				origCount = j = handlers.length;
				while (j--) {
					handleObj = handlers[j];

					if ((mappedTypes || origType === handleObj.origType) &&
						(!handler || handler.guid === handleObj.guid) &&
						(!tmp || tmp.test(handleObj.namespace)) &&
						(!selector || selector === handleObj.selector ||
							selector === "**" && handleObj.selector)) {
						handlers.splice(j, 1);

						if (handleObj.selector) {
							handlers.delegateCount--;
						}
						if (special.remove) {
							special.remove.call(elem, handleObj);
						}
					}
				}
				if (origCount && !handlers.length) {
					if (!special.teardown ||
						special.teardown.call(elem, namespaces, elemData.handle) === false) {

						jQuery.removeEvent(elem, type, elemData.handle);
					}

					delete events[type];
				}
			}
			if (jQuery.isEmptyObject(events)) {
				dataPriv.remove(elem, "handle events");
			}
		},

		dispatch: function (nativeEvent) {

			var i, j, ret, matched, handleObj, handlerQueue,
				args = new Array(arguments.length),
				event = jQuery.event.fix(nativeEvent),

				handlers = (
					dataPriv.get(this, "events") || Object.create(null)
				)[event.type] || [],
				special = jQuery.event.special[event.type] || {};
			args[0] = event;

			for (i = 1; i < arguments.length; i++) {
				args[i] = arguments[i];
			}

			event.delegateTarget = this;
			if (special.preDispatch && special.preDispatch.call(this, event) === false) {
				return;
			}
			handlerQueue = jQuery.event.handlers.call(this, event, handlers);
			i = 0;
			while ((matched = handlerQueue[i++]) && !event.isPropagationStopped()) {
				event.currentTarget = matched.elem;

				j = 0;
				while ((handleObj = matched.handlers[j++]) &&
					!event.isImmediatePropagationStopped()) {
					if (!event.rnamespace || handleObj.namespace === false ||
						event.rnamespace.test(handleObj.namespace)) {

						event.handleObj = handleObj;
						event.data = handleObj.data;

						ret = ((jQuery.event.special[handleObj.origType] || {}).handle ||
							handleObj.handler).apply(matched.elem, args);

						if (ret !== undefined) {
							if ((event.result = ret) === false) {
								event.preventDefault();
								event.stopPropagation();
							}
						}
					}
				}
			}
			if (special.postDispatch) {
				special.postDispatch.call(this, event);
			}

			return event.result;
		},

		handlers: function (event, handlers) {
			var i, handleObj, sel, matchedHandlers, matchedSelectors,
				handlerQueue = [],
				delegateCount = handlers.delegateCount,
				cur = event.target;
			if (delegateCount &&
				cur.nodeType &&
				!(event.type === "click" && event.button >= 1)) {

				for (; cur !== this; cur = cur.parentNode || this) {
					if (cur.nodeType === 1 && !(event.type === "click" && cur.disabled === true)) {
						matchedHandlers = [];
						matchedSelectors = {};
						for (i = 0; i < delegateCount; i++) {
							handleObj = handlers[i];
							sel = handleObj.selector + " ";

							if (matchedSelectors[sel] === undefined) {
								matchedSelectors[sel] = handleObj.needsContext ?
									jQuery(sel, this).index(cur) > -1 :
									jQuery.find(sel, this, null, [cur]).length;
							}
							if (matchedSelectors[sel]) {
								matchedHandlers.push(handleObj);
							}
						}
						if (matchedHandlers.length) {
							handlerQueue.push({ elem: cur, handlers: matchedHandlers });
						}
					}
				}
			}
			cur = this;
			if (delegateCount < handlers.length) {
				handlerQueue.push({ elem: cur, handlers: handlers.slice(delegateCount) });
			}

			return handlerQueue;
		},

		addProp: function (name, hook) {
			Object.defineProperty(jQuery.Event.prototype, name, {
				enumerable: true,
				configurable: true,

				get: isFunction(hook) ?
					function () {
						if (this.originalEvent) {
							return hook(this.originalEvent);
						}
					} :
					function () {
						if (this.originalEvent) {
							return this.originalEvent[name];
						}
					},

				set: function (value) {
					Object.defineProperty(this, name, {
						enumerable: true,
						configurable: true,
						writable: true,
						value: value
					});
				}
			});
		},

		fix: function (originalEvent) {
			return originalEvent[jQuery.expando] ?
				originalEvent :
				new jQuery.Event(originalEvent);
		},

		special: {
			load: {
				noBubble: true
			},
			click: {
				setup: function (data) {
					var el = this || data;
					if (rcheckableType.test(el.type) &&
						el.click && nodeName(el, "input")) {
						leverageNative(el, "click", returnTrue);
					}
					return false;
				},
				trigger: function (data) {
					var el = this || data;
					if (rcheckableType.test(el.type) &&
						el.click && nodeName(el, "input")) {

						leverageNative(el, "click");
					}
					return true;
				},
				_default: function (event) {
					var target = event.target;
					return rcheckableType.test(target.type) &&
						target.click && nodeName(target, "input") &&
						dataPriv.get(target, "click") ||
						nodeName(target, "a");
				}
			},

			beforeunload: {
				postDispatch: function (event) {
					if (event.result !== undefined && event.originalEvent) {
						event.originalEvent.returnValue = event.result;
					}
				}
			}
		}
	};
	function leverageNative(el, type, expectSync) {
		if (!expectSync) {
			if (dataPriv.get(el, type) === undefined) {
				jQuery.event.add(el, type, returnTrue);
			}
			return;
		}
		dataPriv.set(el, type, false);
		jQuery.event.add(el, type, {
			namespace: false,
			handler: function (event) {
				var notAsync, result,
					saved = dataPriv.get(this, type);

				if ((event.isTrigger & 1) && this[type]) {
					if (!saved.length) {
						saved = slice.call(arguments);
						dataPriv.set(this, type, saved);
						notAsync = expectSync(this, type);
						this[type]();
						result = dataPriv.get(this, type);
						if (saved !== result || notAsync) {
							dataPriv.set(this, type, false);
						} else {
							result = {};
						}
						if (saved !== result) {
							event.stopImmediatePropagation();
							event.preventDefault();
							return result && result.value;
						}
					} else if ((jQuery.event.special[type] || {}).delegateType) {
						event.stopPropagation();
					}
				} else if (saved.length) {
					dataPriv.set(this, type, {
						value: jQuery.event.trigger(
							jQuery.extend(saved[0], jQuery.Event.prototype),
							saved.slice(1),
							this
						)
					});
					event.stopImmediatePropagation();
				}
			}
		});
	}

	jQuery.removeEvent = function (elem, type, handle) {
		if (elem.removeEventListener) {
			elem.removeEventListener(type, handle);
		}
	};

	jQuery.Event = function (src, props) {
		if (!(this instanceof jQuery.Event)) {
			return new jQuery.Event(src, props);
		}
		if (src && src.type) {
			this.originalEvent = src;
			this.type = src.type;
			this.isDefaultPrevented = src.defaultPrevented ||
				src.defaultPrevented === undefined &&
				src.returnValue === false ?
				returnTrue :
				returnFalse;
			this.target = (src.target && src.target.nodeType === 3) ?
				src.target.parentNode :
				src.target;

			this.currentTarget = src.currentTarget;
			this.relatedTarget = src.relatedTarget;
		} else {
			this.type = src;
		}
		if (props) {
			jQuery.extend(this, props);
		}
		this.timeStamp = src && src.timeStamp || Date.now();
		this[jQuery.expando] = true;
	};
	jQuery.Event.prototype = {
		constructor: jQuery.Event,
		isDefaultPrevented: returnFalse,
		isPropagationStopped: returnFalse,
		isImmediatePropagationStopped: returnFalse,
		isSimulated: false,

		preventDefault: function () {
			var e = this.originalEvent;

			this.isDefaultPrevented = returnTrue;

			if (e && !this.isSimulated) {
				e.preventDefault();
			}
		},
		stopPropagation: function () {
			var e = this.originalEvent;

			this.isPropagationStopped = returnTrue;

			if (e && !this.isSimulated) {
				e.stopPropagation();
			}
		},
		stopImmediatePropagation: function () {
			var e = this.originalEvent;

			this.isImmediatePropagationStopped = returnTrue;

			if (e && !this.isSimulated) {
				e.stopImmediatePropagation();
			}

			this.stopPropagation();
		}
	};
	jQuery.each({
		altKey: true,
		bubbles: true,
		cancelable: true,
		changedTouches: true,
		ctrlKey: true,
		detail: true,
		eventPhase: true,
		metaKey: true,
		pageX: true,
		pageY: true,
		shiftKey: true,
		view: true,
		"char": true,
		code: true,
		charCode: true,
		key: true,
		keyCode: true,
		button: true,
		buttons: true,
		clientX: true,
		clientY: true,
		offsetX: true,
		offsetY: true,
		pointerId: true,
		pointerType: true,
		screenX: true,
		screenY: true,
		targetTouches: true,
		toElement: true,
		touches: true,
		which: true
	}, jQuery.event.addProp);

	jQuery.each({ focus: "focusin", blur: "focusout" }, function (type, delegateType) {
		jQuery.event.special[type] = {
			setup: function () {
				leverageNative(this, type, expectSync);
				return false;
			},
			trigger: function () {
				leverageNative(this, type);
				return true;
			},
			_default: function (event) {
				return dataPriv.get(event.target, type);
			},

			delegateType: delegateType
		};
	});
	//
	jQuery.each({
		mouseenter: "mouseover",
		mouseleave: "mouseout",
		pointerenter: "pointerover",
		pointerleave: "pointerout"
	}, function (orig, fix) {
		jQuery.event.special[orig] = {
			delegateType: fix,
			bindType: fix,

			handle: function (event) {
				var ret,
					target = this,
					related = event.relatedTarget,
					handleObj = event.handleObj;
				if (!related || (related !== target && !jQuery.contains(target, related))) {
					event.type = handleObj.origType;
					ret = handleObj.handler.apply(this, arguments);
					event.type = fix;
				}
				return ret;
			}
		};
	});

	jQuery.fn.extend({

		on: function (types, selector, data, fn) {
			return on(this, types, selector, data, fn);
		},
		one: function (types, selector, data, fn) {
			return on(this, types, selector, data, fn, 1);
		},
		off: function (types, selector, fn) {
			var handleObj, type;
			if (types && types.preventDefault && types.handleObj) {
				handleObj = types.handleObj;
				jQuery(types.delegateTarget).off(
					handleObj.namespace ?
						handleObj.origType + "." + handleObj.namespace :
						handleObj.origType,
					handleObj.selector,
					handleObj.handler
				);
				return this;
			}
			if (typeof types === "object") {
				for (type in types) {
					this.off(type, selector, types[type]);
				}
				return this;
			}
			if (selector === false || typeof selector === "function") {
				fn = selector;
				selector = undefined;
			}
			if (fn === false) {
				fn = returnFalse;
			}
			return this.each(function () {
				jQuery.event.remove(this, types, fn, selector);
			});
		}
	});

	return jQuery;
});
