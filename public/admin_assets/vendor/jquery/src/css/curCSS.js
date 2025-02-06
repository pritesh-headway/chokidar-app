define([
	"../core",
	"../core/isAttached",
	"./var/rboxStyle",
	"./var/rnumnonpx",
	"./var/getStyles",
	"./var/rcustomProp",
	"../var/rtrimCSS",
	"./support"
], function (jQuery, isAttached, rboxStyle, rnumnonpx, getStyles,
	rcustomProp, rtrimCSS, support) {

	"use strict";

	function curCSS(elem, name, computed) {
		var width, minWidth, maxWidth, ret,
			isCustomProp = rcustomProp.test(name),
			style = elem.style;

		computed = computed || getStyles(elem);
		if (computed) {
			ret = computed.getPropertyValue(name) || computed[name];

			if (isCustomProp && ret) {
				//
				//
				ret = ret.replace(rtrimCSS, "$1") || undefined;
			}

			if (ret === "" && !isAttached(elem)) {
				ret = jQuery.style(elem, name);
			}
			if (!support.pixelBoxStyles() && rnumnonpx.test(ret) && rboxStyle.test(name)) {
				width = style.width;
				minWidth = style.minWidth;
				maxWidth = style.maxWidth;
				style.minWidth = style.maxWidth = style.width = ret;
				ret = computed.width;
				style.width = width;
				style.minWidth = minWidth;
				style.maxWidth = maxWidth;
			}
		}

		return ret !== undefined ?
			ret + "" :
			ret;
	}

	return curCSS;
});
