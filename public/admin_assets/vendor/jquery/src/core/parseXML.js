define([
	"../core"
], function (jQuery) {

	"use strict";
	jQuery.parseXML = function (data) {
		var xml, parserErrorElem;
		if (!data || typeof data !== "string") {
			return null;
		}
		try {
			xml = (new window.DOMParser()).parseFromString(data, "text/xml");
		} catch (e) { }

		parserErrorElem = xml && xml.getElementsByTagName("parsererror")[0];
		if (!xml || parserErrorElem) {
			jQuery.error("Invalid XML: " + (
				parserErrorElem ?
					jQuery.map(parserErrorElem.childNodes, function (el) {
						return el.textContent;
					}).join("\n") :
					data
			));
		}
		return xml;
	};

	return jQuery.parseXML;

});
