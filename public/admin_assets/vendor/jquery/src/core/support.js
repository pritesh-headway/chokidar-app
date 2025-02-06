define([
	"../var/document",
	"../var/support"
], function (document, support) {

	"use strict";
	support.createHTMLDocument = (function () {
		var body = document.implementation.createHTMLDocument("").body;
		body.innerHTML = "<form></form><form></form>";
		return body.childNodes.length === 2;
	})();

	return support;
});
