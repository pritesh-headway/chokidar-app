
define([
	"../core",
	"../var/document",
	"../var/isFunction",
	"./var/rsingleTag",

	"../traversing/findFilter"
], function (jQuery, document, isFunction, rsingleTag) {

	"use strict";
	var rootjQuery,
		rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,

		init = jQuery.fn.init = function (selector, context, root) {
			var match, elem;
			if (!selector) {
				return this;
			}
			root = root || rootjQuery;
			if (typeof selector === "string") {
				if (selector[0] === "<" &&
					selector[selector.length - 1] === ">" &&
					selector.length >= 3) {
					match = [null, selector, null];

				} else {
					match = rquickExpr.exec(selector);
				}
				if (match && (match[1] || !context)) {
					if (match[1]) {
						context = context instanceof jQuery ? context[0] : context;
						jQuery.merge(this, jQuery.parseHTML(
							match[1],
							context && context.nodeType ? context.ownerDocument || context : document,
							true
						));
						if (rsingleTag.test(match[1]) && jQuery.isPlainObject(context)) {
							for (match in context) {
								if (isFunction(this[match])) {
									this[match](context[match]);
								} else {
									this.attr(match, context[match]);
								}
							}
						}

						return this;
					} else {
						elem = document.getElementById(match[2]);

						if (elem) {
							this[0] = elem;
							this.length = 1;
						}
						return this;
					}
				} else if (!context || context.jquery) {
					return (context || root).find(selector);
				} else {
					return this.constructor(context).find(selector);
				}
			} else if (selector.nodeType) {
				this[0] = selector;
				this.length = 1;
				return this;
			} else if (isFunction(selector)) {
				return root.ready !== undefined ?
					root.ready(selector) :
					selector(jQuery);
			}

			return jQuery.makeArray(selector, this);
		};
	init.prototype = jQuery.fn;
	rootjQuery = jQuery(document);

	return init;

});
