define([
	"../core",
	"../var/document",
	"../var/isFunction"
], function (jQuery, document, isFunction) {

	"use strict";

	var readyCallbacks = [],
		whenReady = function (fn) {
			readyCallbacks.push(fn);
		},
		executeReady = function (fn) {
			window.setTimeout(function () {
				fn.call(document, jQuery);
			});
		};

	jQuery.fn.ready = function (fn) {
		whenReady(fn);
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

			whenReady = function (fn) {
				readyCallbacks.push(fn);

				while (readyCallbacks.length) {
					fn = readyCallbacks.shift();
					if (isFunction(fn)) {
						executeReady(fn);
					}
				}
			};

			whenReady();
		}
	});
	jQuery.ready.then = jQuery.fn.ready;

	/**
	 * The ready event handler and self cleanup method
	 */
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
