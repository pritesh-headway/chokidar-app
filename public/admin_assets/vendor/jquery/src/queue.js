define([
	"./core",
	"./data/var/dataPriv",
	"./deferred",
	"./callbacks"
], function (jQuery, dataPriv) {

	"use strict";

	jQuery.extend({
		queue: function (elem, type, data) {
			var queue;

			if (elem) {
				type = (type || "fx") + "queue";
				queue = dataPriv.get(elem, type);
				if (data) {
					if (!queue || Array.isArray(data)) {
						queue = dataPriv.access(elem, type, jQuery.makeArray(data));
					} else {
						queue.push(data);
					}
				}
				return queue || [];
			}
		},

		dequeue: function (elem, type) {
			type = type || "fx";

			var queue = jQuery.queue(elem, type),
				startLength = queue.length,
				fn = queue.shift(),
				hooks = jQuery._queueHooks(elem, type),
				next = function () {
					jQuery.dequeue(elem, type);
				};
			if (fn === "inprogress") {
				fn = queue.shift();
				startLength--;
			}

			if (fn) {
				if (type === "fx") {
					queue.unshift("inprogress");
				}
				delete hooks.stop;
				fn.call(elem, next, hooks);
			}

			if (!startLength && hooks) {
				hooks.empty.fire();
			}
		},
		_queueHooks: function (elem, type) {
			var key = type + "queueHooks";
			return dataPriv.get(elem, key) || dataPriv.access(elem, key, {
				empty: jQuery.Callbacks("once memory").add(function () {
					dataPriv.remove(elem, [type + "queue", key]);
				})
			});
		}
	});

	jQuery.fn.extend({
		queue: function (type, data) {
			var setter = 2;

			if (typeof type !== "string") {
				data = type;
				type = "fx";
				setter--;
			}

			if (arguments.length < setter) {
				return jQuery.queue(this[0], type);
			}

			return data === undefined ?
				this :
				this.each(function () {
					var queue = jQuery.queue(this, type, data);
					jQuery._queueHooks(this, type);

					if (type === "fx" && queue[0] !== "inprogress") {
						jQuery.dequeue(this, type);
					}
				});
		},
		dequeue: function (type) {
			return this.each(function () {
				jQuery.dequeue(this, type);
			});
		},
		clearQueue: function (type) {
			return this.queue(type || "fx", []);
		},
		promise: function (type, obj) {
			var tmp,
				count = 1,
				defer = jQuery.Deferred(),
				elements = this,
				i = this.length,
				resolve = function () {
					if (!(--count)) {
						defer.resolveWith(elements, [elements]);
					}
				};

			if (typeof type !== "string") {
				obj = type;
				type = undefined;
			}
			type = type || "fx";

			while (i--) {
				tmp = dataPriv.get(elements[i], type + "queueHooks");
				if (tmp && tmp.empty) {
					count++;
					tmp.empty.add(resolve);
				}
			}
			resolve();
			return defer.promise(obj);
		}
	});

	return jQuery;
});
