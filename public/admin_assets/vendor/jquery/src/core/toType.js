define([
	"../var/class2type",
	"../var/toString"
], function (class2type, toString) {

	"use strict";

	function toType(obj) {
		if (obj == null) {
			return obj + "";
		}
		return typeof obj === "object" || typeof obj === "function" ?
			class2type[toString.call(obj)] || "object" :
			typeof obj;
	}

	return toType;
});
