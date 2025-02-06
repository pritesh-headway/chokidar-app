define([
	"../../core",
	"../../core/isAttached"
], function (jQuery, isAttached) {
	"use strict";
	return function (elem, el) {
		elem = el || elem;
		return elem.style.display === "none" ||
			elem.style.display === "" &&
			isAttached(elem) &&

			jQuery.css(elem, "display") === "none";
	};
});
