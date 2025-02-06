define([
	"./core",
	"./core/access",
	"./var/isWindow",
	"./css"
], function (jQuery, access, isWindow) {

	"use strict";
	jQuery.each({ Height: "height", Width: "width" }, function (name, type) {
		jQuery.each({
			padding: "inner" + name,
			content: type,
			"": "outer" + name
		}, function (defaultExtra, funcName) {
			jQuery.fn[funcName] = function (margin, value) {
				var chainable = arguments.length && (defaultExtra || typeof margin !== "boolean"),
					extra = defaultExtra || (margin === true || value === true ? "margin" : "border");

				return access(this, function (elem, type, value) {
					var doc;

					if (isWindow(elem)) {
						return funcName.indexOf("outer") === 0 ?
							elem["inner" + name] :
							elem.document.documentElement["client" + name];
					}
					if (elem.nodeType === 9) {
						doc = elem.documentElement;
						return Math.max(
							elem.body["scroll" + name], doc["scroll" + name],
							elem.body["offset" + name], doc["offset" + name],
							doc["client" + name]
						);
					}

					return value === undefined ?
						jQuery.css(elem, type, extra) :
						jQuery.style(elem, type, value, extra);
				}, type, chainable ? margin : undefined, chainable);
			};
		});
	});

	return jQuery;
});
