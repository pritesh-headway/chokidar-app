define([
	"./core",
	"./core/nodeName",
	"./core/camelCase",
	"./core/toType",
	"./var/isFunction",
	"./var/isWindow",
	"./var/slice",

	"./deprecated/ajax-event-alias",
	"./deprecated/event"
], function (jQuery, nodeName, camelCase, toType, isFunction, isWindow, slice) {

	"use strict";
	var rtrim = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;
	jQuery.proxy = function (fn, context) {
		var tmp, args, proxy;

		if (typeof context === "string") {
			tmp = fn[context];
			context = fn;
			fn = tmp;
		}
		if (!isFunction(fn)) {
			return undefined;
		}
		args = slice.call(arguments, 2);
		proxy = function () {
			return fn.apply(context || this, args.concat(slice.call(arguments)));
		};
		proxy.guid = fn.guid = fn.guid || jQuery.guid++;

		return proxy;
	};

	jQuery.holdReady = function (hold) {
		if (hold) {
			jQuery.readyWait++;
		} else {
			jQuery.ready(true);
		}
	};
	jQuery.isArray = Array.isArray;
	jQuery.parseJSON = JSON.parse;
	jQuery.nodeName = nodeName;
	jQuery.isFunction = isFunction;
	jQuery.isWindow = isWindow;
	jQuery.camelCase = camelCase;
	jQuery.type = toType;

	jQuery.now = Date.now;

	jQuery.isNumeric = function (obj) {
		var type = jQuery.type(obj);
		return (type === "number" || type === "string") &&
			!isNaN(obj - parseFloat(obj));
	};

	jQuery.trim = function (text) {
		return text == null ?
			"" :
			(text + "").replace(rtrim, "$1");
	};
});
