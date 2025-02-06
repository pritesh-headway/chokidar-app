define([], function () {

	"use strict";
	var rmsPrefix = /^-ms-/,
		rdashAlpha = /-([a-z])/g;
	function fcamelCase(_all, letter) {
		return letter.toUpperCase();
	}
	function camelCase(string) {
		return string.replace(rmsPrefix, "ms-").replace(rdashAlpha, fcamelCase);
	}

	return camelCase;

});
