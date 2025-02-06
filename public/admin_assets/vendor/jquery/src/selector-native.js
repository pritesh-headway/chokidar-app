define([
	"./core",
	"./var/document",
	"./var/documentElement",
	"./var/hasOwn",
	"./var/indexOf"
], function (jQuery, document, documentElement, hasOwn, indexOf) {

	"use strict";

	/*
	 * Optional (non-Sizzle) selector module for custom builds.
	 *
	 * Note that this DOES NOT SUPPORT many documented jQuery
	 * features in exchange for its smaller size:
	 *
	 * Attribute not equal selector
	 * Positional selectors (:first; :eq(n); :odd; etc.)
	 * Type selectors (:input; :checkbox; :button; etc.)
	 * State-based selectors (:animated; :visible; :hidden; etc.)
	 * :has(selector)
	 * :not(complex selector)
	 * custom selectors via Sizzle extensions
	 * Leading combinators (e.g., $collection.find("> *"))
	 * Reliable functionality on XML fragments
	 * Requiring all parts of a selector to match elements under context
	 *   (e.g., $div.find("div > *") now matches children of $div)
	 * Matching against non-elements
	 * Reliable sorting of disconnected nodes
	 * querySelectorAll bug fixes (e.g., unreliable :focus on WebKit)
	 *
	 * If any of these are unacceptable tradeoffs, either use Sizzle or
	 * customize this stub for the project's specific needs.
	 */

	var hasDuplicate, sortInput,
		rhtmlSuffix = /HTML$/i,
		sortStable = jQuery.expando.split("").sort(sortOrder).join("") === jQuery.expando,
		matches = documentElement.matches ||
			documentElement.webkitMatchesSelector ||
			documentElement.mozMatchesSelector ||
			documentElement.oMatchesSelector ||
			documentElement.msMatchesSelector,
		rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g,
		fcssescape = function (ch, asCodePoint) {
			if (asCodePoint) {
				if (ch === "\0") {
					return "\uFFFD";
				}
				return ch.slice(0, -1) + "\\" + ch.charCodeAt(ch.length - 1).toString(16) + " ";
			}
			return "\\" + ch;
		};

	function sortOrder(a, b) {
		if (a === b) {
			hasDuplicate = true;
			return 0;
		}
		var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
		if (compare) {
			return compare;
		}
		compare = (a.ownerDocument || a) === (b.ownerDocument || b) ?
			a.compareDocumentPosition(b) :
			1;
		if (compare & 1) {
			if (a === document || a.ownerDocument === document &&
				jQuery.contains(document, a)) {
				return -1;
			}
			if (b === document || b.ownerDocument === document &&
				jQuery.contains(document, b)) {
				return 1;
			}
			return sortInput ?
				(indexOf.call(sortInput, a) - indexOf.call(sortInput, b)) :
				0;
		}

		return compare & 4 ? -1 : 1;
	}

	function uniqueSort(results) {
		var elem,
			duplicates = [],
			j = 0,
			i = 0;

		hasDuplicate = false;
		sortInput = !sortStable && results.slice(0);
		results.sort(sortOrder);

		if (hasDuplicate) {
			while ((elem = results[i++])) {
				if (elem === results[i]) {
					j = duplicates.push(i);
				}
			}
			while (j--) {
				results.splice(duplicates[j], 1);
			}
		}
		sortInput = null;

		return results;
	}

	function escape(sel) {
		return (sel + "").replace(rcssescape, fcssescape);
	}

	jQuery.extend({
		uniqueSort: uniqueSort,
		unique: uniqueSort,
		escapeSelector: escape,
		find: function (selector, context, results, seed) {
			var elem, nodeType,
				i = 0;

			results = results || [];
			context = context || document;
			if (!selector || typeof selector !== "string") {
				return results;
			}
			if ((nodeType = context.nodeType) !== 1 && nodeType !== 9) {
				return [];
			}

			if (seed) {
				while ((elem = seed[i++])) {
					if (jQuery.find.matchesSelector(elem, selector)) {
						results.push(elem);
					}
				}
			} else {
				jQuery.merge(results, context.querySelectorAll(selector));
			}

			return results;
		},
		text: function (elem) {
			var node,
				ret = "",
				i = 0,
				nodeType = elem.nodeType;

			if (!nodeType) {
				while ((node = elem[i++])) {
					ret += jQuery.text(node);
				}
			} else if (nodeType === 1 || nodeType === 9 || nodeType === 11) {
				return elem.textContent;
			} else if (nodeType === 3 || nodeType === 4) {
				return elem.nodeValue;
			}
			return ret;
		},
		contains: function (a, b) {
			var bup = b && b.parentNode;
			return a === bup || !!(bup && bup.nodeType === 1 && a.contains(bup));
		},
		isXMLDoc: function (elem) {
			var namespace = elem.namespaceURI,
				documentElement = (elem.ownerDocument || elem).documentElement;
			return !rhtmlSuffix.test(namespace ||
				documentElement && documentElement.nodeName ||
				"HTML");
		},
		expr: {
			attrHandle: {},
			match: {
				bool: new RegExp("^(?:checked|selected|async|autofocus|autoplay|controls|defer" +
					"|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped)$", "i"),
				needsContext: /^[\x20\t\r\n\f]*[>+~]/
			}
		}
	});

	jQuery.extend(jQuery.find, {
		matches: function (expr, elements) {
			return jQuery.find(expr, null, null, elements);
		},
		matchesSelector: function (elem, expr) {
			return matches.call(elem, expr);
		},
		attr: function (elem, name) {
			var fn = jQuery.expr.attrHandle[name.toLowerCase()],
				value = fn && hasOwn.call(jQuery.expr.attrHandle, name.toLowerCase()) ?
					fn(elem, name, jQuery.isXMLDoc(elem)) :
					undefined;
			return value !== undefined ? value : elem.getAttribute(name);
		}
	});

});
