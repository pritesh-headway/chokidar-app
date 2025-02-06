define([
	"./core",
	"./core/access",
	"./core/camelCase",
	"./core/nodeName",
	"./var/rcssNum",
	"./css/var/rnumnonpx",
	"./css/var/rcustomProp",
	"./css/var/cssExpand",
	"./css/var/getStyles",
	"./css/var/swap",
	"./css/curCSS",
	"./css/adjustCSS",
	"./css/addGetHookIf",
	"./css/support",
	"./css/finalPropName",

	"./core/init",
	"./core/ready",
	"./selector"
], function (jQuery, access, camelCase, nodeName, rcssNum, rnumnonpx,
	rcustomProp, cssExpand, getStyles, swap, curCSS, adjustCSS, addGetHookIf,
	support, finalPropName) {

	"use strict";

	var
		rdisplayswap = /^(none|table(?!-c[ea]).+)/,
		cssShow = { position: "absolute", visibility: "hidden", display: "block" },
		cssNormalTransform = {
			letterSpacing: "0",
			fontWeight: "400"
		};

	function setPositiveNumber(_elem, value, subtract) {
		var matches = rcssNum.exec(value);
		return matches ?
			Math.max(0, matches[2] - (subtract || 0)) + (matches[3] || "px") :
			value;
	}

	function boxModelAdjustment(elem, dimension, box, isBorderBox, styles, computedVal) {
		var i = dimension === "width" ? 1 : 0,
			extra = 0,
			delta = 0;
		if (box === (isBorderBox ? "border" : "content")) {
			return 0;
		}

		for (; i < 4; i += 2) {
			if (box === "margin") {
				delta += jQuery.css(elem, box + cssExpand[i], true, styles);
			}
			if (!isBorderBox) {
				delta += jQuery.css(elem, "padding" + cssExpand[i], true, styles);
				if (box !== "padding") {
					delta += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
				} else {
					extra += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
				}
			} else {
				if (box === "content") {
					delta -= jQuery.css(elem, "padding" + cssExpand[i], true, styles);
				}
				if (box !== "margin") {
					delta -= jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
				}
			}
		}
		if (!isBorderBox && computedVal >= 0) {
			delta += Math.max(0, Math.ceil(
				elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] -
				computedVal -
				delta -
				extra -
				0.5
			)) || 0;
		}

		return delta;
	}

	function getWidthOrHeight(elem, dimension, extra) {
		var styles = getStyles(elem),
			boxSizingNeeded = !support.boxSizingReliable() || extra,
			isBorderBox = boxSizingNeeded &&
				jQuery.css(elem, "boxSizing", false, styles) === "border-box",
			valueIsBorderBox = isBorderBox,

			val = curCSS(elem, dimension, styles),
			offsetProp = "offset" + dimension[0].toUpperCase() + dimension.slice(1);
		if (rnumnonpx.test(val)) {
			if (!extra) {
				return val;
			}
			val = "auto";
		}
		if ((!support.boxSizingReliable() && isBorderBox ||
			!support.reliableTrDimensions() && nodeName(elem, "tr") ||
			val === "auto" ||
			!parseFloat(val) && jQuery.css(elem, "display", false, styles) === "inline") &&
			elem.getClientRects().length) {

			isBorderBox = jQuery.css(elem, "boxSizing", false, styles) === "border-box";
			valueIsBorderBox = offsetProp in elem;
			if (valueIsBorderBox) {
				val = elem[offsetProp];
			}
		}
		val = parseFloat(val) || 0;
		return (val +
			boxModelAdjustment(
				elem,
				dimension,
				extra || (isBorderBox ? "border" : "content"),
				valueIsBorderBox,
				styles,
				val
			)
		) + "px";
	}

	jQuery.extend({
		cssHooks: {
			opacity: {
				get: function (elem, computed) {
					if (computed) {
						var ret = curCSS(elem, "opacity");
						return ret === "" ? "1" : ret;
					}
				}
			}
		},
		cssNumber: {
			"animationIterationCount": true,
			"columnCount": true,
			"fillOpacity": true,
			"flexGrow": true,
			"flexShrink": true,
			"fontWeight": true,
			"gridArea": true,
			"gridColumn": true,
			"gridColumnEnd": true,
			"gridColumnStart": true,
			"gridRow": true,
			"gridRowEnd": true,
			"gridRowStart": true,
			"lineHeight": true,
			"opacity": true,
			"order": true,
			"orphans": true,
			"widows": true,
			"zIndex": true,
			"zoom": true
		},
		cssProps: {},
		style: function (elem, name, value, extra) {
			if (!elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style) {
				return;
			}
			var ret, type, hooks,
				origName = camelCase(name),
				isCustomProp = rcustomProp.test(name),
				style = elem.style;
			if (!isCustomProp) {
				name = finalPropName(origName);
			}
			hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
			if (value !== undefined) {
				type = typeof value;
				if (type === "string" && (ret = rcssNum.exec(value)) && ret[1]) {
					value = adjustCSS(elem, name, ret);
					type = "number";
				}
				if (value == null || value !== value) {
					return;
				}
				if (type === "number" && !isCustomProp) {
					value += ret && ret[3] || (jQuery.cssNumber[origName] ? "" : "px");
				}
				if (!support.clearCloneStyle && value === "" && name.indexOf("background") === 0) {
					style[name] = "inherit";
				}
				if (!hooks || !("set" in hooks) ||
					(value = hooks.set(elem, value, extra)) !== undefined) {

					if (isCustomProp) {
						style.setProperty(name, value);
					} else {
						style[name] = value;
					}
				}

			} else {
				if (hooks && "get" in hooks &&
					(ret = hooks.get(elem, false, extra)) !== undefined) {

					return ret;
				}
				return style[name];
			}
		},

		css: function (elem, name, extra, styles) {
			var val, num, hooks,
				origName = camelCase(name),
				isCustomProp = rcustomProp.test(name);
			if (!isCustomProp) {
				name = finalPropName(origName);
			}
			hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
			if (hooks && "get" in hooks) {
				val = hooks.get(elem, true, extra);
			}
			if (val === undefined) {
				val = curCSS(elem, name, styles);
			}
			if (val === "normal" && name in cssNormalTransform) {
				val = cssNormalTransform[name];
			}
			if (extra === "" || extra) {
				num = parseFloat(val);
				return extra === true || isFinite(num) ? num || 0 : val;
			}

			return val;
		}
	});

	jQuery.each(["height", "width"], function (_i, dimension) {
		jQuery.cssHooks[dimension] = {
			get: function (elem, computed, extra) {
				if (computed) {
					return rdisplayswap.test(jQuery.css(elem, "display")) &&
						(!elem.getClientRects().length || !elem.getBoundingClientRect().width) ?
						swap(elem, cssShow, function () {
							return getWidthOrHeight(elem, dimension, extra);
						}) :
						getWidthOrHeight(elem, dimension, extra);
				}
			},

			set: function (elem, value, extra) {
				var matches,
					styles = getStyles(elem),
					scrollboxSizeBuggy = !support.scrollboxSize() &&
						styles.position === "absolute",
					boxSizingNeeded = scrollboxSizeBuggy || extra,
					isBorderBox = boxSizingNeeded &&
						jQuery.css(elem, "boxSizing", false, styles) === "border-box",
					subtract = extra ?
						boxModelAdjustment(
							elem,
							dimension,
							extra,
							isBorderBox,
							styles
						) :
						0;
				if (isBorderBox && scrollboxSizeBuggy) {
					subtract -= Math.ceil(
						elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] -
						parseFloat(styles[dimension]) -
						boxModelAdjustment(elem, dimension, "border", false, styles) -
						0.5
					);
				}
				if (subtract && (matches = rcssNum.exec(value)) &&
					(matches[3] || "px") !== "px") {

					elem.style[dimension] = value;
					value = jQuery.css(elem, dimension);
				}

				return setPositiveNumber(elem, value, subtract);
			}
		};
	});

	jQuery.cssHooks.marginLeft = addGetHookIf(support.reliableMarginLeft,
		function (elem, computed) {
			if (computed) {
				return (parseFloat(curCSS(elem, "marginLeft")) ||
					elem.getBoundingClientRect().left -
					swap(elem, { marginLeft: 0 }, function () {
						return elem.getBoundingClientRect().left;
					})
				) + "px";
			}
		}
	);
	jQuery.each({
		margin: "",
		padding: "",
		border: "Width"
	}, function (prefix, suffix) {
		jQuery.cssHooks[prefix + suffix] = {
			expand: function (value) {
				var i = 0,
					expanded = {},
					parts = typeof value === "string" ? value.split(" ") : [value];

				for (; i < 4; i++) {
					expanded[prefix + cssExpand[i] + suffix] =
						parts[i] || parts[i - 2] || parts[0];
				}

				return expanded;
			}
		};

		if (prefix !== "margin") {
			jQuery.cssHooks[prefix + suffix].set = setPositiveNumber;
		}
	});

	jQuery.fn.extend({
		css: function (name, value) {
			return access(this, function (elem, name, value) {
				var styles, len,
					map = {},
					i = 0;

				if (Array.isArray(name)) {
					styles = getStyles(elem);
					len = name.length;

					for (; i < len; i++) {
						map[name[i]] = jQuery.css(elem, name[i], false, styles);
					}

					return map;
				}

				return value !== undefined ?
					jQuery.style(elem, name, value) :
					jQuery.css(elem, name);
			}, name, value, arguments.length > 1);
		}
	});

	return jQuery;
});
