define([
	"../core",
	"../var/documentElement",
	"../selector"
], function (jQuery, documentElement) {
	"use strict";

	var isAttached = function (elem) {
		return jQuery.contains(elem.ownerDocument, elem);
	},
		composed = { composed: true };
	if (documentElement.getRootNode) {
		isAttached = function (elem) {
			return jQuery.contains(elem.ownerDocument, elem) ||
				elem.getRootNode(composed) === elem.ownerDocument;
		};
	}

	return isAttached;
});
