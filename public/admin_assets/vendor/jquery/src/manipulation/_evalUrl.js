define([
	"../ajax"
], function (jQuery) {

	"use strict";

	jQuery._evalUrl = function (url, options, doc) {
		return jQuery.ajax({
			url: url,
			type: "GET",
			dataType: "script",
			cache: true,
			async: false,
			global: false,
			converters: {
				"text script": function () { }
			},
			dataFilter: function (response) {
				jQuery.globalEval(response, options, doc);
			}
		});
	};

	return jQuery._evalUrl;

});
