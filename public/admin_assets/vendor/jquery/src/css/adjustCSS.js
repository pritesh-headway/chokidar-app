define([
	"../core",
	"../var/rcssNum"
], function (jQuery, rcssNum) {

	"use strict";

	function adjustCSS(elem, prop, valueParts, tween) {
		var adjusted, scale,
			maxIterations = 20,
			currentValue = tween ?
				function () {
					return tween.cur();
				} :
				function () {
					return jQuery.css(elem, prop, "");
				},
			initial = currentValue(),
			unit = valueParts && valueParts[3] || (jQuery.cssNumber[prop] ? "" : "px"),
			initialInUnit = elem.nodeType &&
				(jQuery.cssNumber[prop] || unit !== "px" && +initial) &&
				rcssNum.exec(jQuery.css(elem, prop));

		if (initialInUnit && initialInUnit[3] !== unit) {
			initial = initial / 2;
			unit = unit || initialInUnit[3];
			initialInUnit = +initial || 1;

			while (maxIterations--) {
				jQuery.style(elem, prop, initialInUnit + unit);
				if ((1 - scale) * (1 - (scale = currentValue() / initial || 0.5)) <= 0) {
					maxIterations = 0;
				}
				initialInUnit = initialInUnit / scale;

			}

			initialInUnit = initialInUnit * 2;
			jQuery.style(elem, prop, initialInUnit + unit);
			valueParts = valueParts || [];
		}

		if (valueParts) {
			initialInUnit = +initialInUnit || +initial || 0;
			adjusted = valueParts[1] ?
				initialInUnit + (valueParts[1] + 1) * valueParts[2] :
				+valueParts[2];
			if (tween) {
				tween.unit = unit;
				tween.start = initialInUnit;
				tween.end = adjusted;
			}
		}
		return adjusted;
	}

	return adjustCSS;
});
