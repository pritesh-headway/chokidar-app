define([
	"../core",
	"../var/document",
	"../core/readyException",
	"../deferred"
], function (jQuery, document) {

	"use strict";
	var readyList = jQuery.Deferred();

	jQuery.fn.ready = function (fn) {

		readyList
			.then(fn)
			.catch(function (error) {
				jQuery.readyException(error);
			});

		return this;
	};

	jQuery.extend({
		isReady: false,
		readyWait: 1,
		ready: function (wait) {
			if (wait === true ? --jQuery.readyWait : jQuery.isReady) {
				return;
			}
			jQuery.isReady = true;
			if (wait !== true && --jQuery.readyWait > 0) {
				return;
			}
			readyList.resolveWith(document, [jQuery]);
		}
	});

	jQuery.ready.then = readyList.then;
	function completed() {
		document.removeEventListener("DOMContentLoaded", completed);
		window.removeEventListener("load", completed);
		jQuery.ready();
	}
	if (document.readyState === "complete" ||
		(document.readyState !== "loading" && !document.documentElement.doScroll)) {
		window.setTimeout(jQuery.ready);

	} else {
		document.addEventListener("DOMContentLoaded", completed);
		window.addEventListener("load", completed);
	}

});
