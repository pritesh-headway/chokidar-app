define([
	"../core"
], function (jQuery) {

	"use strict";

	var
		_jQuery = window.jQuery,
		_$ = window.$;

	jQuery.noConflict = function (deep) {
		if (window.$ === jQuery) {
			window.$ = _$;
		}

		if (deep && window.jQuery === jQuery) {
			window.jQuery = _jQuery;
		}

		return jQuery;
	};
	if (typeof noGlobal === "undefined") {
		window.jQuery = window.$ = jQuery;
	}

});
