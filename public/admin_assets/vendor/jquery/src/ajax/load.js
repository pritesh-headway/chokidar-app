define([
	"../core",
	"../core/stripAndCollapse",
	"../var/isFunction",
	"../core/parseHTML",
	"../ajax",
	"../traversing",
	"../manipulation",
	"../selector"
], function (jQuery, stripAndCollapse, isFunction) {

	"use strict";

	/**
	 * Load a url into a page
	 */
	jQuery.fn.load = function (url, params, callback) {
		var selector, type, response,
			self = this,
			off = url.indexOf(" ");

		if (off > -1) {
			selector = stripAndCollapse(url.slice(off));
			url = url.slice(0, off);
		}
		if (isFunction(params)) {
			callback = params;
			params = undefined;
		} else if (params && typeof params === "object") {
			type = "POST";
		}
		if (self.length > 0) {
			jQuery.ajax({
				url: url,
				type: type || "GET",
				dataType: "html",
				data: params
			}).done(function (responseText) {
				response = arguments;

				self.html(selector ?
					jQuery("<div>").append(jQuery.parseHTML(responseText)).find(selector) :
					responseText);
			}).always(callback && function (jqXHR, status) {
				self.each(function () {
					callback.apply(this, response || [jqXHR.responseText, status, jqXHR]);
				});
			});
		}

		return this;
	};

});
