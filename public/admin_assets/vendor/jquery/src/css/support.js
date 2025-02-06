define([
	"../core",
	"../var/document",
	"../var/documentElement",
	"../var/support"
], function (jQuery, document, documentElement, support) {

	"use strict";

	(function () {
		function computeStyleTests() {
			if (!div) {
				return;
			}

			container.style.cssText = "position:absolute;left:-11111px;width:60px;" +
				"margin-top:1px;padding:0;border:0";
			div.style.cssText =
				"position:relative;display:block;box-sizing:border-box;overflow:scroll;" +
				"margin:auto;border:1px;padding:1px;" +
				"width:60%;top:1%";
			documentElement.appendChild(container).appendChild(div);

			var divStyle = window.getComputedStyle(div);
			pixelPositionVal = divStyle.top !== "1%";
			reliableMarginLeftVal = roundPixelMeasures(divStyle.marginLeft) === 12;
			div.style.right = "60%";
			pixelBoxStylesVal = roundPixelMeasures(divStyle.right) === 36;
			boxSizingReliableVal = roundPixelMeasures(divStyle.width) === 36;
			div.style.position = "absolute";
			scrollboxSizeVal = roundPixelMeasures(div.offsetWidth / 3) === 12;

			documentElement.removeChild(container);
			div = null;
		}

		function roundPixelMeasures(measure) {
			return Math.round(parseFloat(measure));
		}

		var pixelPositionVal, boxSizingReliableVal, scrollboxSizeVal, pixelBoxStylesVal,
			reliableTrDimensionsVal, reliableMarginLeftVal,
			container = document.createElement("div"),
			div = document.createElement("div");
		if (!div.style) {
			return;
		}
		div.style.backgroundClip = "content-box";
		div.cloneNode(true).style.backgroundClip = "";
		support.clearCloneStyle = div.style.backgroundClip === "content-box";

		jQuery.extend(support, {
			boxSizingReliable: function () {
				computeStyleTests();
				return boxSizingReliableVal;
			},
			pixelBoxStyles: function () {
				computeStyleTests();
				return pixelBoxStylesVal;
			},
			pixelPosition: function () {
				computeStyleTests();
				return pixelPositionVal;
			},
			reliableMarginLeft: function () {
				computeStyleTests();
				return reliableMarginLeftVal;
			},
			scrollboxSize: function () {
				computeStyleTests();
				return scrollboxSizeVal;
			},
			//
			reliableTrDimensions: function () {
				var table, tr, trChild, trStyle;
				if (reliableTrDimensionsVal == null) {
					table = document.createElement("table");
					tr = document.createElement("tr");
					trChild = document.createElement("div");

					table.style.cssText = "position:absolute;left:-11111px;border-collapse:separate";
					tr.style.cssText = "border:1px solid";
					tr.style.height = "1px";
					trChild.style.height = "9px";
					trChild.style.display = "block";

					documentElement
						.appendChild(table)
						.appendChild(tr)
						.appendChild(trChild);

					trStyle = window.getComputedStyle(tr);
					reliableTrDimensionsVal = (parseInt(trStyle.height, 10) +
						parseInt(trStyle.borderTopWidth, 10) +
						parseInt(trStyle.borderBottomWidth, 10)) === tr.offsetHeight;

					documentElement.removeChild(table);
				}
				return reliableTrDimensionsVal;
			}
		});
	})();

	return support;

});
