define([
	"../var/document",
	"../core"
], function (document, jQuery) {

	"use strict";

	var cssPrefixes = ["Webkit", "Moz", "ms"],
		emptyStyle = document.createElement("div").style,
		vendorProps = {};
	function vendorPropName(name) {
		var capName = name[0].toUpperCase() + name.slice(1),
			i = cssPrefixes.length;

		while (i--) {
			name = cssPrefixes[i] + capName;
			if (name in emptyStyle) {
				return name;
			}
		}
	}
	function finalPropName(name) {
		var final = jQuery.cssProps[name] || vendorProps[name];

		if (final) {
			return final;
		}
		if (name in emptyStyle) {
			return name;
		}
		return vendorProps[name] = vendorPropName(name) || name;
	}

	return finalPropName;

});
