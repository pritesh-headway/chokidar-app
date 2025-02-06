/* global Symbol */
define([
	"./var/arr",
	"./var/getProto",
	"./var/slice",
	"./var/flat",
	"./var/push",
	"./var/indexOf",
	"./var/class2type",
	"./var/toString",
	"./var/hasOwn",
	"./var/fnToString",
	"./var/ObjectFunctionString",
	"./var/support",
	"./var/isFunction",
	"./var/isWindow",
	"./core/DOMEval",
	"./core/toType"
], function (arr, getProto, slice, flat, push, indexOf,
	class2type, toString, hasOwn, fnToString, ObjectFunctionString,
	support, isFunction, isWindow, DOMEval, toType) {

	"use strict";

	var
		version = "3.6.4",
		jQuery = function (selector, context) {
			return new jQuery.fn.init(selector, context);
		};

	jQuery.fn = jQuery.prototype = {
		jquery: version,

		constructor: jQuery,
		length: 0,

		toArray: function () {
			return slice.call(this);
		},
		get: function (num) {
			if (num == null) {
				return slice.call(this);
			}
			return num < 0 ? this[num + this.length] : this[num];
		},
		pushStack: function (elems) {
			var ret = jQuery.merge(this.constructor(), elems);
			ret.prevObject = this;
			return ret;
		},
		each: function (callback) {
			return jQuery.each(this, callback);
		},

		map: function (callback) {
			return this.pushStack(jQuery.map(this, function (elem, i) {
				return callback.call(elem, i, elem);
			}));
		},

		slice: function () {
			return this.pushStack(slice.apply(this, arguments));
		},

		first: function () {
			return this.eq(0);
		},

		last: function () {
			return this.eq(-1);
		},

		even: function () {
			return this.pushStack(jQuery.grep(this, function (_elem, i) {
				return (i + 1) % 2;
			}));
		},

		odd: function () {
			return this.pushStack(jQuery.grep(this, function (_elem, i) {
				return i % 2;
			}));
		},

		eq: function (i) {
			var len = this.length,
				j = +i + (i < 0 ? len : 0);
			return this.pushStack(j >= 0 && j < len ? [this[j]] : []);
		},

		end: function () {
			return this.prevObject || this.constructor();
		},
		push: push,
		sort: arr.sort,
		splice: arr.splice
	};

	jQuery.extend = jQuery.fn.extend = function () {
		var options, name, src, copy, copyIsArray, clone,
			target = arguments[0] || {},
			i = 1,
			length = arguments.length,
			deep = false;
		if (typeof target === "boolean") {
			deep = target;
			target = arguments[i] || {};
			i++;
		}
		if (typeof target !== "object" && !isFunction(target)) {
			target = {};
		}
		if (i === length) {
			target = this;
			i--;
		}

		for (; i < length; i++) {
			if ((options = arguments[i]) != null) {
				for (name in options) {
					copy = options[name];
					if (name === "__proto__" || target === copy) {
						continue;
					}
					if (deep && copy && (jQuery.isPlainObject(copy) ||
						(copyIsArray = Array.isArray(copy)))) {
						src = target[name];
						if (copyIsArray && !Array.isArray(src)) {
							clone = [];
						} else if (!copyIsArray && !jQuery.isPlainObject(src)) {
							clone = {};
						} else {
							clone = src;
						}
						copyIsArray = false;
						target[name] = jQuery.extend(deep, clone, copy);
					} else if (copy !== undefined) {
						target[name] = copy;
					}
				}
			}
		}
		return target;
	};

	jQuery.extend({
		expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),
		isReady: true,

		error: function (msg) {
			throw new Error(msg);
		},

		noop: function () { },

		isPlainObject: function (obj) {
			var proto, Ctor;
			if (!obj || toString.call(obj) !== "[object Object]") {
				return false;
			}

			proto = getProto(obj);
			if (!proto) {
				return true;
			}
			Ctor = hasOwn.call(proto, "constructor") && proto.constructor;
			return typeof Ctor === "function" && fnToString.call(Ctor) === ObjectFunctionString;
		},

		isEmptyObject: function (obj) {
			var name;

			for (name in obj) {
				return false;
			}
			return true;
		},
		globalEval: function (code, options, doc) {
			DOMEval(code, { nonce: options && options.nonce }, doc);
		},

		each: function (obj, callback) {
			var length, i = 0;

			if (isArrayLike(obj)) {
				length = obj.length;
				for (; i < length; i++) {
					if (callback.call(obj[i], i, obj[i]) === false) {
						break;
					}
				}
			} else {
				for (i in obj) {
					if (callback.call(obj[i], i, obj[i]) === false) {
						break;
					}
				}
			}

			return obj;
		},
		makeArray: function (arr, results) {
			var ret = results || [];

			if (arr != null) {
				if (isArrayLike(Object(arr))) {
					jQuery.merge(ret,
						typeof arr === "string" ?
							[arr] : arr
					);
				} else {
					push.call(ret, arr);
				}
			}

			return ret;
		},

		inArray: function (elem, arr, i) {
			return arr == null ? -1 : indexOf.call(arr, elem, i);
		},
		merge: function (first, second) {
			var len = +second.length,
				j = 0,
				i = first.length;

			for (; j < len; j++) {
				first[i++] = second[j];
			}

			first.length = i;

			return first;
		},

		grep: function (elems, callback, invert) {
			var callbackInverse,
				matches = [],
				i = 0,
				length = elems.length,
				callbackExpect = !invert;
			for (; i < length; i++) {
				callbackInverse = !callback(elems[i], i);
				if (callbackInverse !== callbackExpect) {
					matches.push(elems[i]);
				}
			}

			return matches;
		},
		map: function (elems, callback, arg) {
			var length, value,
				i = 0,
				ret = [];
			if (isArrayLike(elems)) {
				length = elems.length;
				for (; i < length; i++) {
					value = callback(elems[i], i, arg);

					if (value != null) {
						ret.push(value);
					}
				}
			} else {
				for (i in elems) {
					value = callback(elems[i], i, arg);

					if (value != null) {
						ret.push(value);
					}
				}
			}
			return flat(ret);
		},
		guid: 1,
		support: support
	});

	if (typeof Symbol === "function") {
		jQuery.fn[Symbol.iterator] = arr[Symbol.iterator];
	}
	jQuery.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),
		function (_i, name) {
			class2type["[object " + name + "]"] = name.toLowerCase();
		});

	function isArrayLike(obj) {
		var length = !!obj && "length" in obj && obj.length,
			type = toType(obj);

		if (isFunction(obj) || isWindow(obj)) {
			return false;
		}

		return type === "array" || length === 0 ||
			typeof length === "number" && length > 0 && (length - 1) in obj;
	}

	return jQuery;
});
