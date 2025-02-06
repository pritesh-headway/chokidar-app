/*!
 * Sizzle CSS Selector Engine v2.3.10
 * https://sizzlejs.com/
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://js.foundation/
 *
 * Date: 2023-02-14
 */
(function (window) {
	var i,
		support,
		Expr,
		getText,
		isXML,
		tokenize,
		compile,
		select,
		outermostContext,
		sortInput,
		hasDuplicate,
		setDocument,
		document,
		docElem,
		documentIsHTML,
		rbuggyQSA,
		rbuggyMatches,
		matches,
		contains,
		expando = "sizzle" + 1 * new Date(),
		preferredDoc = window.document,
		dirruns = 0,
		done = 0,
		classCache = createCache(),
		tokenCache = createCache(),
		compilerCache = createCache(),
		nonnativeSelectorCache = createCache(),
		sortOrder = function (a, b) {
			if (a === b) {
				hasDuplicate = true;
			}
			return 0;
		},
		hasOwn = ({}).hasOwnProperty,
		arr = [],
		pop = arr.pop,
		pushNative = arr.push,
		push = arr.push,
		slice = arr.slice,
		indexOf = function (list, elem) {
			var i = 0,
				len = list.length;
			for (; i < len; i++) {
				if (list[i] === elem) {
					return i;
				}
			}
			return -1;
		},

		booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|" +
			"ismap|loop|multiple|open|readonly|required|scoped",
		whitespace = "[\\x20\\t\\r\\n\\f]",
		identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace +
			"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
		attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace +
			"*([*^$|!~]?=)" + whitespace +
			"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" +
			whitespace + "*\\]",

		pseudos = ":(" + identifier + ")(?:\\((" +
			"('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" +
			"((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" +
			".*" +
			")\\)|)",
		rwhitespace = new RegExp(whitespace + "+", "g"),
		rtrim = new RegExp("^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" +
			whitespace + "+$", "g"),

		rcomma = new RegExp("^" + whitespace + "*," + whitespace + "*"),
		rleadingCombinator = new RegExp("^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace +
			"*"),
		rdescend = new RegExp(whitespace + "|>"),

		rpseudo = new RegExp(pseudos),
		ridentifier = new RegExp("^" + identifier + "$"),

		matchExpr = {
			"ID": new RegExp("^#(" + identifier + ")"),
			"CLASS": new RegExp("^\\.(" + identifier + ")"),
			"TAG": new RegExp("^(" + identifier + "|[*])"),
			"ATTR": new RegExp("^" + attributes),
			"PSEUDO": new RegExp("^" + pseudos),
			"CHILD": new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
				whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" +
				whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i"),
			"bool": new RegExp("^(?:" + booleans + ")$", "i"),
			"needsContext": new RegExp("^" + whitespace +
				"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace +
				"*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i")
		},

		rhtml = /HTML$/i,
		rinputs = /^(?:input|select|textarea|button)$/i,
		rheader = /^h\d$/i,

		rnative = /^[^{]+\{\s*\[native \w/,
		rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,

		rsibling = /[+~]/,
		runescape = new RegExp("\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g"),
		funescape = function (escape, nonHex) {
			var high = "0x" + escape.slice(1) - 0x10000;

			return nonHex ?
				nonHex :
				high < 0 ?
					String.fromCharCode(high + 0x10000) :
					String.fromCharCode(high >> 10 | 0xD800, high & 0x3FF | 0xDC00);
		},
		rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
		fcssescape = function (ch, asCodePoint) {
			if (asCodePoint) {
				if (ch === "\0") {
					return "\uFFFD";
				}
				return ch.slice(0, -1) + "\\" +
					ch.charCodeAt(ch.length - 1).toString(16) + " ";
			}
			return "\\" + ch;
		},
		unloadHandler = function () {
			setDocument();
		},

		inDisabledFieldset = addCombinator(
			function (elem) {
				return elem.disabled === true && elem.nodeName.toLowerCase() === "fieldset";
			},
			{ dir: "parentNode", next: "legend" }
		);
	try {
		push.apply(
			(arr = slice.call(preferredDoc.childNodes)),
			preferredDoc.childNodes
		);
		arr[preferredDoc.childNodes.length].nodeType;
	} catch (e) {
		push = {
			apply: arr.length ?
				function (target, els) {
					pushNative.apply(target, slice.call(els));
				} :
				function (target, els) {
					var j = target.length,
						i = 0;
					while ((target[j++] = els[i++])) { }
					target.length = j - 1;
				}
		};
	}

	function Sizzle(selector, context, results, seed) {
		var m, i, elem, nid, match, groups, newSelector,
			newContext = context && context.ownerDocument,
			nodeType = context ? context.nodeType : 9;

		results = results || [];
		if (typeof selector !== "string" || !selector ||
			nodeType !== 1 && nodeType !== 9 && nodeType !== 11) {

			return results;
		}
		if (!seed) {
			setDocument(context);
			context = context || document;

			if (documentIsHTML) {
				if (nodeType !== 11 && (match = rquickExpr.exec(selector))) {
					if ((m = match[1])) {
						if (nodeType === 9) {
							if ((elem = context.getElementById(m))) {
								if (elem.id === m) {
									results.push(elem);
									return results;
								}
							} else {
								return results;
							}
						} else {
							if (newContext && (elem = newContext.getElementById(m)) &&
								contains(context, elem) &&
								elem.id === m) {

								results.push(elem);
								return results;
							}
						}
					} else if (match[2]) {
						push.apply(results, context.getElementsByTagName(selector));
						return results;
					} else if ((m = match[3]) && support.getElementsByClassName &&
						context.getElementsByClassName) {

						push.apply(results, context.getElementsByClassName(m));
						return results;
					}
				}
				if (support.qsa &&
					!nonnativeSelectorCache[selector + " "] &&
					(!rbuggyQSA || !rbuggyQSA.test(selector)) &&
					(nodeType !== 1 || context.nodeName.toLowerCase() !== "object")) {

					newSelector = selector;
					newContext = context;
					if (nodeType === 1 &&
						(rdescend.test(selector) || rleadingCombinator.test(selector))) {
						newContext = rsibling.test(selector) && testContext(context.parentNode) ||
							context;
						if (newContext !== context || !support.scope) {
							if ((nid = context.getAttribute("id"))) {
								nid = nid.replace(rcssescape, fcssescape);
							} else {
								context.setAttribute("id", (nid = expando));
							}
						}
						groups = tokenize(selector);
						i = groups.length;
						while (i--) {
							groups[i] = (nid ? "#" + nid : ":scope") + " " +
								toSelector(groups[i]);
						}
						newSelector = groups.join(",");
					}

					try {
						push.apply(results,
							newContext.querySelectorAll(newSelector)
						);
						return results;
					} catch (qsaError) {
						nonnativeSelectorCache(selector, true);
					} finally {
						if (nid === expando) {
							context.removeAttribute("id");
						}
					}
				}
			}
		}
		return select(selector.replace(rtrim, "$1"), context, results, seed);
	}

	/**
	 * Create key-value caches of limited size
	 * @returns {function(string, object)} Returns the Object data after storing it on itself with
	 *	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
	 *	deleting the oldest entry
	 */
	function createCache() {
		var keys = [];

		function cache(key, value) {
			if (keys.push(key + " ") > Expr.cacheLength) {
				delete cache[keys.shift()];
			}
			return (cache[key + " "] = value);
		}
		return cache;
	}

	/**
	 * Mark a function for special use by Sizzle
	 * @param {Function} fn The function to mark
	 */
	function markFunction(fn) {
		fn[expando] = true;
		return fn;
	}

	/**
	 * Support testing using an element
	 * @param {Function} fn Passed the created element and returns a boolean result
	 */
	function assert(fn) {
		var el = document.createElement("fieldset");

		try {
			return !!fn(el);
		} catch (e) {
			return false;
		} finally {
			if (el.parentNode) {
				el.parentNode.removeChild(el);
			}
			el = null;
		}
	}

	/**
	 * Adds the same handler for all of the specified attrs
	 * @param {String} attrs Pipe-separated list of attributes
	 * @param {Function} handler The method that will be applied
	 */
	function addHandle(attrs, handler) {
		var arr = attrs.split("|"),
			i = arr.length;

		while (i--) {
			Expr.attrHandle[arr[i]] = handler;
		}
	}

	/**
	 * Checks document order of two siblings
	 * @param {Element} a
	 * @param {Element} b
	 * @returns {Number} Returns less than 0 if a precedes b, greater than 0 if a follows b
	 */
	function siblingCheck(a, b) {
		var cur = b && a,
			diff = cur && a.nodeType === 1 && b.nodeType === 1 &&
				a.sourceIndex - b.sourceIndex;
		if (diff) {
			return diff;
		}
		if (cur) {
			while ((cur = cur.nextSibling)) {
				if (cur === b) {
					return -1;
				}
			}
		}

		return a ? 1 : -1;
	}

	/**
	 * Returns a function to use in pseudos for input types
	 * @param {String} type
	 */
	function createInputPseudo(type) {
		return function (elem) {
			var name = elem.nodeName.toLowerCase();
			return name === "input" && elem.type === type;
		};
	}

	/**
	 * Returns a function to use in pseudos for buttons
	 * @param {String} type
	 */
	function createButtonPseudo(type) {
		return function (elem) {
			var name = elem.nodeName.toLowerCase();
			return (name === "input" || name === "button") && elem.type === type;
		};
	}

	/**
	 * Returns a function to use in pseudos for :enabled/:disabled
	 * @param {Boolean} disabled true for :disabled; false for :enabled
	 */
	function createDisabledPseudo(disabled) {
		return function (elem) {
			if ("form" in elem) {
				if (elem.parentNode && elem.disabled === false) {
					if ("label" in elem) {
						if ("label" in elem.parentNode) {
							return elem.parentNode.disabled === disabled;
						} else {
							return elem.disabled === disabled;
						}
					}
					return elem.isDisabled === disabled ||
						/* jshint -W018 */
						elem.isDisabled !== !disabled &&
						inDisabledFieldset(elem) === disabled;
				}

				return elem.disabled === disabled;
			} else if ("label" in elem) {
				return elem.disabled === disabled;
			}
			return false;
		};
	}

	/**
	 * Returns a function to use in pseudos for positionals
	 * @param {Function} fn
	 */
	function createPositionalPseudo(fn) {
		return markFunction(function (argument) {
			argument = +argument;
			return markFunction(function (seed, matches) {
				var j,
					matchIndexes = fn([], seed.length, argument),
					i = matchIndexes.length;
				while (i--) {
					if (seed[(j = matchIndexes[i])]) {
						seed[j] = !(matches[j] = seed[j]);
					}
				}
			});
		});
	}

	/**
	 * Checks a node for validity as a Sizzle context
	 * @param {Element|Object=} context
	 * @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
	 */
	function testContext(context) {
		return context && typeof context.getElementsByTagName !== "undefined" && context;
	}
	support = Sizzle.support = {};

	/**
	 * Detects XML nodes
	 * @param {Element|Object} elem An element or a document
	 * @returns {Boolean} True iff elem is a non-HTML XML node
	 */
	isXML = Sizzle.isXML = function (elem) {
		var namespace = elem && elem.namespaceURI,
			docElem = elem && (elem.ownerDocument || elem).documentElement;
		return !rhtml.test(namespace || docElem && docElem.nodeName || "HTML");
	};

	/**
	 * Sets document-related variables once based on the current document
	 * @param {Element|Object} [doc] An element or document object to use to set the document
	 * @returns {Object} Returns the current document
	 */
	setDocument = Sizzle.setDocument = function (node) {
		var hasCompare, subWindow,
			doc = node ? node.ownerDocument || node : preferredDoc;
		if (doc == document || doc.nodeType !== 9 || !doc.documentElement) {
			return document;
		}
		document = doc;
		docElem = document.documentElement;
		documentIsHTML = !isXML(document);
		if (preferredDoc != document &&
			(subWindow = document.defaultView) && subWindow.top !== subWindow) {
			if (subWindow.addEventListener) {
				subWindow.addEventListener("unload", unloadHandler, false);
			} else if (subWindow.attachEvent) {
				subWindow.attachEvent("onunload", unloadHandler);
			}
		}
		support.scope = assert(function (el) {
			docElem.appendChild(el).appendChild(document.createElement("div"));
			return typeof el.querySelectorAll !== "undefined" &&
				!el.querySelectorAll(":scope fieldset div").length;
		});
		support.cssHas = assert(function () {
			try {
				document.querySelector(":has(*,:jqfake)");
				return false;
			} catch (e) {
				return true;
			}
		});

		/* Attributes
		---------------------------------------------------------------------- */
		support.attributes = assert(function (el) {
			el.className = "i";
			return !el.getAttribute("className");
		});

		/* getElement(s)By*
		---------------------------------------------------------------------- */
		support.getElementsByTagName = assert(function (el) {
			el.appendChild(document.createComment(""));
			return !el.getElementsByTagName("*").length;
		});
		support.getElementsByClassName = rnative.test(document.getElementsByClassName);
		support.getById = assert(function (el) {
			docElem.appendChild(el).id = expando;
			return !document.getElementsByName || !document.getElementsByName(expando).length;
		});
		if (support.getById) {
			Expr.filter["ID"] = function (id) {
				var attrId = id.replace(runescape, funescape);
				return function (elem) {
					return elem.getAttribute("id") === attrId;
				};
			};
			Expr.find["ID"] = function (id, context) {
				if (typeof context.getElementById !== "undefined" && documentIsHTML) {
					var elem = context.getElementById(id);
					return elem ? [elem] : [];
				}
			};
		} else {
			Expr.filter["ID"] = function (id) {
				var attrId = id.replace(runescape, funescape);
				return function (elem) {
					var node = typeof elem.getAttributeNode !== "undefined" &&
						elem.getAttributeNode("id");
					return node && node.value === attrId;
				};
			};
			Expr.find["ID"] = function (id, context) {
				if (typeof context.getElementById !== "undefined" && documentIsHTML) {
					var node, i, elems,
						elem = context.getElementById(id);

					if (elem) {
						node = elem.getAttributeNode("id");
						if (node && node.value === id) {
							return [elem];
						}
						elems = context.getElementsByName(id);
						i = 0;
						while ((elem = elems[i++])) {
							node = elem.getAttributeNode("id");
							if (node && node.value === id) {
								return [elem];
							}
						}
					}

					return [];
				}
			};
		}
		Expr.find["TAG"] = support.getElementsByTagName ?
			function (tag, context) {
				if (typeof context.getElementsByTagName !== "undefined") {
					return context.getElementsByTagName(tag);
				} else if (support.qsa) {
					return context.querySelectorAll(tag);
				}
			} :

			function (tag, context) {
				var elem,
					tmp = [],
					i = 0,
					results = context.getElementsByTagName(tag);
				if (tag === "*") {
					while ((elem = results[i++])) {
						if (elem.nodeType === 1) {
							tmp.push(elem);
						}
					}

					return tmp;
				}
				return results;
			};
		Expr.find["CLASS"] = support.getElementsByClassName && function (className, context) {
			if (typeof context.getElementsByClassName !== "undefined" && documentIsHTML) {
				return context.getElementsByClassName(className);
			}
		};

		/* QSA/matchesSelector
		---------------------------------------------------------------------- */
		rbuggyMatches = [];
		rbuggyQSA = [];

		if ((support.qsa = rnative.test(document.querySelectorAll))) {
			assert(function (el) {

				var input;
				docElem.appendChild(el).innerHTML = "<a id='" + expando + "'></a>" +
					"<select id='" + expando + "-\r\\' msallowcapture=''>" +
					"<option selected=''></option></select>";
				if (el.querySelectorAll("[msallowcapture^='']").length) {
					rbuggyQSA.push("[*^$]=" + whitespace + "*(?:''|\"\")");
				}
				if (!el.querySelectorAll("[selected]").length) {
					rbuggyQSA.push("\\[" + whitespace + "*(?:value|" + booleans + ")");
				}
				if (!el.querySelectorAll("[id~=" + expando + "-]").length) {
					rbuggyQSA.push("~=");
				}
				input = document.createElement("input");
				input.setAttribute("name", "");
				el.appendChild(input);
				if (!el.querySelectorAll("[name='']").length) {
					rbuggyQSA.push("\\[" + whitespace + "*name" + whitespace + "*=" +
						whitespace + "*(?:''|\"\")");
				}
				if (!el.querySelectorAll(":checked").length) {
					rbuggyQSA.push(":checked");
				}
				if (!el.querySelectorAll("a#" + expando + "+*").length) {
					rbuggyQSA.push(".#.+[+~]");
				}
				el.querySelectorAll("\\\f");
				rbuggyQSA.push("[\\r\\n\\f]");
			});

			assert(function (el) {
				el.innerHTML = "<a href='' disabled='disabled'></a>" +
					"<select disabled='disabled'><option/></select>";
				var input = document.createElement("input");
				input.setAttribute("type", "hidden");
				el.appendChild(input).setAttribute("name", "D");
				if (el.querySelectorAll("[name=d]").length) {
					rbuggyQSA.push("name" + whitespace + "*[*^$|!~]?=");
				}
				if (el.querySelectorAll(":enabled").length !== 2) {
					rbuggyQSA.push(":enabled", ":disabled");
				}
				docElem.appendChild(el).disabled = true;
				if (el.querySelectorAll(":disabled").length !== 2) {
					rbuggyQSA.push(":enabled", ":disabled");
				}
				el.querySelectorAll("*,:x");
				rbuggyQSA.push(",.*:");
			});
		}

		if ((support.matchesSelector = rnative.test((matches = docElem.matches ||
			docElem.webkitMatchesSelector ||
			docElem.mozMatchesSelector ||
			docElem.oMatchesSelector ||
			docElem.msMatchesSelector)))) {

			assert(function (el) {
				support.disconnectedMatch = matches.call(el, "*");
				matches.call(el, "[s!='']:x");
				rbuggyMatches.push("!=", pseudos);
			});
		}

		if (!support.cssHas) {
			rbuggyQSA.push(":has");
		}

		rbuggyQSA = rbuggyQSA.length && new RegExp(rbuggyQSA.join("|"));
		rbuggyMatches = rbuggyMatches.length && new RegExp(rbuggyMatches.join("|"));

		/* Contains
		---------------------------------------------------------------------- */
		hasCompare = rnative.test(docElem.compareDocumentPosition);
		contains = hasCompare || rnative.test(docElem.contains) ?
			function (a, b) {
				var adown = a.nodeType === 9 && a.documentElement || a,
					bup = b && b.parentNode;
				return a === bup || !!(bup && bup.nodeType === 1 && (
					adown.contains ?
						adown.contains(bup) :
						a.compareDocumentPosition && a.compareDocumentPosition(bup) & 16
				));
			} :
			function (a, b) {
				if (b) {
					while ((b = b.parentNode)) {
						if (b === a) {
							return true;
						}
					}
				}
				return false;
			};

		/* Sorting
		---------------------------------------------------------------------- */
		sortOrder = hasCompare ?
			function (a, b) {
				if (a === b) {
					hasDuplicate = true;
					return 0;
				}
				var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
				if (compare) {
					return compare;
				}
				compare = (a.ownerDocument || a) == (b.ownerDocument || b) ?
					a.compareDocumentPosition(b) :
					1;
				if (compare & 1 ||
					(!support.sortDetached && b.compareDocumentPosition(a) === compare)) {
					if (a == document || a.ownerDocument == preferredDoc &&
						contains(preferredDoc, a)) {
						return -1;
					}
					if (b == document || b.ownerDocument == preferredDoc &&
						contains(preferredDoc, b)) {
						return 1;
					}
					return sortInput ?
						(indexOf(sortInput, a) - indexOf(sortInput, b)) :
						0;
				}

				return compare & 4 ? -1 : 1;
			} :
			function (a, b) {
				if (a === b) {
					hasDuplicate = true;
					return 0;
				}

				var cur,
					i = 0,
					aup = a.parentNode,
					bup = b.parentNode,
					ap = [a],
					bp = [b];
				if (!aup || !bup) {
					/* eslint-disable eqeqeq */
					return a == document ? -1 :
						b == document ? 1 :
							/* eslint-enable eqeqeq */
							aup ? -1 :
								bup ? 1 :
									sortInput ?
										(indexOf(sortInput, a) - indexOf(sortInput, b)) :
										0;
				} else if (aup === bup) {
					return siblingCheck(a, b);
				}
				cur = a;
				while ((cur = cur.parentNode)) {
					ap.unshift(cur);
				}
				cur = b;
				while ((cur = cur.parentNode)) {
					bp.unshift(cur);
				}
				while (ap[i] === bp[i]) {
					i++;
				}

				return i ?
					siblingCheck(ap[i], bp[i]) :
					/* eslint-disable eqeqeq */
					ap[i] == preferredDoc ? -1 :
						bp[i] == preferredDoc ? 1 :
							/* eslint-enable eqeqeq */
							0;
			};

		return document;
	};

	Sizzle.matches = function (expr, elements) {
		return Sizzle(expr, null, null, elements);
	};

	Sizzle.matchesSelector = function (elem, expr) {
		setDocument(elem);

		if (support.matchesSelector && documentIsHTML &&
			!nonnativeSelectorCache[expr + " "] &&
			(!rbuggyMatches || !rbuggyMatches.test(expr)) &&
			(!rbuggyQSA || !rbuggyQSA.test(expr))) {

			try {
				var ret = matches.call(elem, expr);
				if (ret || support.disconnectedMatch ||
					elem.document && elem.document.nodeType !== 11) {
					return ret;
				}
			} catch (e) {
				nonnativeSelectorCache(expr, true);
			}
		}

		return Sizzle(expr, document, null, [elem]).length > 0;
	};

	Sizzle.contains = function (context, elem) {
		if ((context.ownerDocument || context) != document) {
			setDocument(context);
		}
		return contains(context, elem);
	};

	Sizzle.attr = function (elem, name) {
		if ((elem.ownerDocument || elem) != document) {
			setDocument(elem);
		}

		var fn = Expr.attrHandle[name.toLowerCase()],
			val = fn && hasOwn.call(Expr.attrHandle, name.toLowerCase()) ?
				fn(elem, name, !documentIsHTML) :
				undefined;

		return val !== undefined ?
			val :
			support.attributes || !documentIsHTML ?
				elem.getAttribute(name) :
				(val = elem.getAttributeNode(name)) && val.specified ?
					val.value :
					null;
	};

	Sizzle.escape = function (sel) {
		return (sel + "").replace(rcssescape, fcssescape);
	};

	Sizzle.error = function (msg) {
		throw new Error("Syntax error, unrecognized expression: " + msg);
	};

	/**
	 * Document sorting and removing duplicates
	 * @param {ArrayLike} results
	 */
	Sizzle.uniqueSort = function (results) {
		var elem,
			duplicates = [],
			j = 0,
			i = 0;
		hasDuplicate = !support.detectDuplicates;
		sortInput = !support.sortStable && results.slice(0);
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
	};

	/**
	 * Utility function for retrieving the text value of an array of DOM nodes
	 * @param {Array|Element} elem
	 */
	getText = Sizzle.getText = function (elem) {
		var node,
			ret = "",
			i = 0,
			nodeType = elem.nodeType;

		if (!nodeType) {
			while ((node = elem[i++])) {
				ret += getText(node);
			}
		} else if (nodeType === 1 || nodeType === 9 || nodeType === 11) {
			if (typeof elem.textContent === "string") {
				return elem.textContent;
			} else {
				for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
					ret += getText(elem);
				}
			}
		} else if (nodeType === 3 || nodeType === 4) {
			return elem.nodeValue;
		}
		return ret;
	};

	Expr = Sizzle.selectors = {
		cacheLength: 50,

		createPseudo: markFunction,

		match: matchExpr,

		attrHandle: {},

		find: {},

		relative: {
			">": { dir: "parentNode", first: true },
			" ": { dir: "parentNode" },
			"+": { dir: "previousSibling", first: true },
			"~": { dir: "previousSibling" }
		},

		preFilter: {
			"ATTR": function (match) {
				match[1] = match[1].replace(runescape, funescape);
				match[3] = (match[3] || match[4] ||
					match[5] || "").replace(runescape, funescape);

				if (match[2] === "~=") {
					match[3] = " " + match[3] + " ";
				}

				return match.slice(0, 4);
			},

			"CHILD": function (match) {

				/* matches from matchExpr["CHILD"]
					1 type (only|nth|...)
					2 what (child|of-type)
					3 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
					4 xn-component of xn+y argument ([+-]?\d*n|)
					5 sign of xn-component
					6 x of xn-component
					7 sign of y-component
					8 y of y-component
				*/
				match[1] = match[1].toLowerCase();

				if (match[1].slice(0, 3) === "nth") {
					if (!match[3]) {
						Sizzle.error(match[0]);
					}
					match[4] = +(match[4] ?
						match[5] + (match[6] || 1) :
						2 * (match[3] === "even" || match[3] === "odd"));
					match[5] = +((match[7] + match[8]) || match[3] === "odd");
				} else if (match[3]) {
					Sizzle.error(match[0]);
				}

				return match;
			},

			"PSEUDO": function (match) {
				var excess,
					unquoted = !match[6] && match[2];

				if (matchExpr["CHILD"].test(match[0])) {
					return null;
				}
				if (match[3]) {
					match[2] = match[4] || match[5] || "";
				} else if (unquoted && rpseudo.test(unquoted) &&
					(excess = tokenize(unquoted, true)) &&
					(excess = unquoted.indexOf(")", unquoted.length - excess) - unquoted.length)) {
					match[0] = match[0].slice(0, excess);
					match[2] = unquoted.slice(0, excess);
				}
				return match.slice(0, 3);
			}
		},

		filter: {

			"TAG": function (nodeNameSelector) {
				var nodeName = nodeNameSelector.replace(runescape, funescape).toLowerCase();
				return nodeNameSelector === "*" ?
					function () {
						return true;
					} :
					function (elem) {
						return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
					};
			},

			"CLASS": function (className) {
				var pattern = classCache[className + " "];

				return pattern ||
					(pattern = new RegExp("(^|" + whitespace +
						")" + className + "(" + whitespace + "|$)")) && classCache(
							className, function (elem) {
								return pattern.test(
									typeof elem.className === "string" && elem.className ||
									typeof elem.getAttribute !== "undefined" &&
									elem.getAttribute("class") ||
									""
								);
							});
			},

			"ATTR": function (name, operator, check) {
				return function (elem) {
					var result = Sizzle.attr(elem, name);

					if (result == null) {
						return operator === "!=";
					}
					if (!operator) {
						return true;
					}

					result += "";

					/* eslint-disable max-len */

					return operator === "=" ? result === check :
						operator === "!=" ? result !== check :
							operator === "^=" ? check && result.indexOf(check) === 0 :
								operator === "*=" ? check && result.indexOf(check) > -1 :
									operator === "$=" ? check && result.slice(-check.length) === check :
										operator === "~=" ? (" " + result.replace(rwhitespace, " ") + " ").indexOf(check) > -1 :
											operator === "|=" ? result === check || result.slice(0, check.length + 1) === check + "-" :
												false;
					/* eslint-enable max-len */

				};
			},

			"CHILD": function (type, what, _argument, first, last) {
				var simple = type.slice(0, 3) !== "nth",
					forward = type.slice(-4) !== "last",
					ofType = what === "of-type";

				return first === 1 && last === 0 ?
					function (elem) {
						return !!elem.parentNode;
					} :

					function (elem, _context, xml) {
						var cache, uniqueCache, outerCache, node, nodeIndex, start,
							dir = simple !== forward ? "nextSibling" : "previousSibling",
							parent = elem.parentNode,
							name = ofType && elem.nodeName.toLowerCase(),
							useCache = !xml && !ofType,
							diff = false;

						if (parent) {
							if (simple) {
								while (dir) {
									node = elem;
									while ((node = node[dir])) {
										if (ofType ?
											node.nodeName.toLowerCase() === name :
											node.nodeType === 1) {

											return false;
										}
									}
									start = dir = type === "only" && !start && "nextSibling";
								}
								return true;
							}

							start = [forward ? parent.firstChild : parent.lastChild];
							if (forward && useCache) {
								node = parent;
								outerCache = node[expando] || (node[expando] = {});
								uniqueCache = outerCache[node.uniqueID] ||
									(outerCache[node.uniqueID] = {});

								cache = uniqueCache[type] || [];
								nodeIndex = cache[0] === dirruns && cache[1];
								diff = nodeIndex && cache[2];
								node = nodeIndex && parent.childNodes[nodeIndex];

								while ((node = ++nodeIndex && node && node[dir] ||
									(diff = nodeIndex = 0) || start.pop())) {
									if (node.nodeType === 1 && ++diff && node === elem) {
										uniqueCache[type] = [dirruns, nodeIndex, diff];
										break;
									}
								}

							} else {
								if (useCache) {
									node = elem;
									outerCache = node[expando] || (node[expando] = {});
									uniqueCache = outerCache[node.uniqueID] ||
										(outerCache[node.uniqueID] = {});

									cache = uniqueCache[type] || [];
									nodeIndex = cache[0] === dirruns && cache[1];
									diff = nodeIndex;
								}
								if (diff === false) {
									while ((node = ++nodeIndex && node && node[dir] ||
										(diff = nodeIndex = 0) || start.pop())) {

										if ((ofType ?
											node.nodeName.toLowerCase() === name :
											node.nodeType === 1) &&
											++diff) {
											if (useCache) {
												outerCache = node[expando] ||
													(node[expando] = {});
												uniqueCache = outerCache[node.uniqueID] ||
													(outerCache[node.uniqueID] = {});

												uniqueCache[type] = [dirruns, diff];
											}

											if (node === elem) {
												break;
											}
										}
									}
								}
							}
							diff -= last;
							return diff === first || (diff % first === 0 && diff / first >= 0);
						}
					};
			},

			"PSEUDO": function (pseudo, argument) {
				var args,
					fn = Expr.pseudos[pseudo] || Expr.setFilters[pseudo.toLowerCase()] ||
						Sizzle.error("unsupported pseudo: " + pseudo);
				if (fn[expando]) {
					return fn(argument);
				}
				if (fn.length > 1) {
					args = [pseudo, pseudo, "", argument];
					return Expr.setFilters.hasOwnProperty(pseudo.toLowerCase()) ?
						markFunction(function (seed, matches) {
							var idx,
								matched = fn(seed, argument),
								i = matched.length;
							while (i--) {
								idx = indexOf(seed, matched[i]);
								seed[idx] = !(matches[idx] = matched[i]);
							}
						}) :
						function (elem) {
							return fn(elem, 0, args);
						};
				}

				return fn;
			}
		},

		pseudos: {
			"not": markFunction(function (selector) {
				var input = [],
					results = [],
					matcher = compile(selector.replace(rtrim, "$1"));

				return matcher[expando] ?
					markFunction(function (seed, matches, _context, xml) {
						var elem,
							unmatched = matcher(seed, null, xml, []),
							i = seed.length;
						while (i--) {
							if ((elem = unmatched[i])) {
								seed[i] = !(matches[i] = elem);
							}
						}
					}) :
					function (elem, _context, xml) {
						input[0] = elem;
						matcher(input, null, xml, results);
						input[0] = null;
						return !results.pop();
					};
			}),

			"has": markFunction(function (selector) {
				return function (elem) {
					return Sizzle(selector, elem).length > 0;
				};
			}),

			"contains": markFunction(function (text) {
				text = text.replace(runescape, funescape);
				return function (elem) {
					return (elem.textContent || getText(elem)).indexOf(text) > -1;
				};
			}),
			"lang": markFunction(function (lang) {
				if (!ridentifier.test(lang || "")) {
					Sizzle.error("unsupported lang: " + lang);
				}
				lang = lang.replace(runescape, funescape).toLowerCase();
				return function (elem) {
					var elemLang;
					do {
						if ((elemLang = documentIsHTML ?
							elem.lang :
							elem.getAttribute("xml:lang") || elem.getAttribute("lang"))) {

							elemLang = elemLang.toLowerCase();
							return elemLang === lang || elemLang.indexOf(lang + "-") === 0;
						}
					} while ((elem = elem.parentNode) && elem.nodeType === 1);
					return false;
				};
			}),
			"target": function (elem) {
				var hash = window.location && window.location.hash;
				return hash && hash.slice(1) === elem.id;
			},

			"root": function (elem) {
				return elem === docElem;
			},

			"focus": function (elem) {
				return elem === document.activeElement &&
					(!document.hasFocus || document.hasFocus()) &&
					!!(elem.type || elem.href || ~elem.tabIndex);
			},
			"enabled": createDisabledPseudo(false),
			"disabled": createDisabledPseudo(true),

			"checked": function (elem) {
				var nodeName = elem.nodeName.toLowerCase();
				return (nodeName === "input" && !!elem.checked) ||
					(nodeName === "option" && !!elem.selected);
			},

			"selected": function (elem) {
				if (elem.parentNode) {

					elem.parentNode.selectedIndex;
				}

				return elem.selected === true;
			},
			"empty": function (elem) {
				for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
					if (elem.nodeType < 6) {
						return false;
					}
				}
				return true;
			},

			"parent": function (elem) {
				return !Expr.pseudos["empty"](elem);
			},
			"header": function (elem) {
				return rheader.test(elem.nodeName);
			},

			"input": function (elem) {
				return rinputs.test(elem.nodeName);
			},

			"button": function (elem) {
				var name = elem.nodeName.toLowerCase();
				return name === "input" && elem.type === "button" || name === "button";
			},

			"text": function (elem) {
				var attr;
				return elem.nodeName.toLowerCase() === "input" &&
					elem.type === "text" &&
					((attr = elem.getAttribute("type")) == null ||
						attr.toLowerCase() === "text");
			},
			"first": createPositionalPseudo(function () {
				return [0];
			}),

			"last": createPositionalPseudo(function (_matchIndexes, length) {
				return [length - 1];
			}),

			"eq": createPositionalPseudo(function (_matchIndexes, length, argument) {
				return [argument < 0 ? argument + length : argument];
			}),

			"even": createPositionalPseudo(function (matchIndexes, length) {
				var i = 0;
				for (; i < length; i += 2) {
					matchIndexes.push(i);
				}
				return matchIndexes;
			}),

			"odd": createPositionalPseudo(function (matchIndexes, length) {
				var i = 1;
				for (; i < length; i += 2) {
					matchIndexes.push(i);
				}
				return matchIndexes;
			}),

			"lt": createPositionalPseudo(function (matchIndexes, length, argument) {
				var i = argument < 0 ?
					argument + length :
					argument > length ?
						length :
						argument;
				for (; --i >= 0;) {
					matchIndexes.push(i);
				}
				return matchIndexes;
			}),

			"gt": createPositionalPseudo(function (matchIndexes, length, argument) {
				var i = argument < 0 ? argument + length : argument;
				for (; ++i < length;) {
					matchIndexes.push(i);
				}
				return matchIndexes;
			})
		}
	};

	Expr.pseudos["nth"] = Expr.pseudos["eq"];
	for (i in { radio: true, checkbox: true, file: true, password: true, image: true }) {
		Expr.pseudos[i] = createInputPseudo(i);
	}
	for (i in { submit: true, reset: true }) {
		Expr.pseudos[i] = createButtonPseudo(i);
	}
	function setFilters() { }
	setFilters.prototype = Expr.filters = Expr.pseudos;
	Expr.setFilters = new setFilters();

	tokenize = Sizzle.tokenize = function (selector, parseOnly) {
		var matched, match, tokens, type,
			soFar, groups, preFilters,
			cached = tokenCache[selector + " "];

		if (cached) {
			return parseOnly ? 0 : cached.slice(0);
		}

		soFar = selector;
		groups = [];
		preFilters = Expr.preFilter;

		while (soFar) {
			if (!matched || (match = rcomma.exec(soFar))) {
				if (match) {
					soFar = soFar.slice(match[0].length) || soFar;
				}
				groups.push((tokens = []));
			}

			matched = false;
			if ((match = rleadingCombinator.exec(soFar))) {
				matched = match.shift();
				tokens.push({
					value: matched,
					type: match[0].replace(rtrim, " ")
				});
				soFar = soFar.slice(matched.length);
			}
			for (type in Expr.filter) {
				if ((match = matchExpr[type].exec(soFar)) && (!preFilters[type] ||
					(match = preFilters[type](match)))) {
					matched = match.shift();
					tokens.push({
						value: matched,
						type: type,
						matches: match
					});
					soFar = soFar.slice(matched.length);
				}
			}

			if (!matched) {
				break;
			}
		}
		return parseOnly ?
			soFar.length :
			soFar ?
				Sizzle.error(selector) :
				tokenCache(selector, groups).slice(0);
	};

	function toSelector(tokens) {
		var i = 0,
			len = tokens.length,
			selector = "";
		for (; i < len; i++) {
			selector += tokens[i].value;
		}
		return selector;
	}

	function addCombinator(matcher, combinator, base) {
		var dir = combinator.dir,
			skip = combinator.next,
			key = skip || dir,
			checkNonElements = base && key === "parentNode",
			doneName = done++;

		return combinator.first ?
			function (elem, context, xml) {
				while ((elem = elem[dir])) {
					if (elem.nodeType === 1 || checkNonElements) {
						return matcher(elem, context, xml);
					}
				}
				return false;
			} :
			function (elem, context, xml) {
				var oldCache, uniqueCache, outerCache,
					newCache = [dirruns, doneName];
				if (xml) {
					while ((elem = elem[dir])) {
						if (elem.nodeType === 1 || checkNonElements) {
							if (matcher(elem, context, xml)) {
								return true;
							}
						}
					}
				} else {
					while ((elem = elem[dir])) {
						if (elem.nodeType === 1 || checkNonElements) {
							outerCache = elem[expando] || (elem[expando] = {});
							uniqueCache = outerCache[elem.uniqueID] ||
								(outerCache[elem.uniqueID] = {});

							if (skip && skip === elem.nodeName.toLowerCase()) {
								elem = elem[dir] || elem;
							} else if ((oldCache = uniqueCache[key]) &&
								oldCache[0] === dirruns && oldCache[1] === doneName) {
								return (newCache[2] = oldCache[2]);
							} else {
								uniqueCache[key] = newCache;
								if ((newCache[2] = matcher(elem, context, xml))) {
									return true;
								}
							}
						}
					}
				}
				return false;
			};
	}

	function elementMatcher(matchers) {
		return matchers.length > 1 ?
			function (elem, context, xml) {
				var i = matchers.length;
				while (i--) {
					if (!matchers[i](elem, context, xml)) {
						return false;
					}
				}
				return true;
			} :
			matchers[0];
	}

	function multipleContexts(selector, contexts, results) {
		var i = 0,
			len = contexts.length;
		for (; i < len; i++) {
			Sizzle(selector, contexts[i], results);
		}
		return results;
	}

	function condense(unmatched, map, filter, context, xml) {
		var elem,
			newUnmatched = [],
			i = 0,
			len = unmatched.length,
			mapped = map != null;

		for (; i < len; i++) {
			if ((elem = unmatched[i])) {
				if (!filter || filter(elem, context, xml)) {
					newUnmatched.push(elem);
					if (mapped) {
						map.push(i);
					}
				}
			}
		}

		return newUnmatched;
	}

	function setMatcher(preFilter, selector, matcher, postFilter, postFinder, postSelector) {
		if (postFilter && !postFilter[expando]) {
			postFilter = setMatcher(postFilter);
		}
		if (postFinder && !postFinder[expando]) {
			postFinder = setMatcher(postFinder, postSelector);
		}
		return markFunction(function (seed, results, context, xml) {
			var temp, i, elem,
				preMap = [],
				postMap = [],
				preexisting = results.length,
				elems = seed || multipleContexts(
					selector || "*",
					context.nodeType ? [context] : context,
					[]
				),
				matcherIn = preFilter && (seed || !selector) ?
					condense(elems, preMap, preFilter, context, xml) :
					elems,

				matcherOut = matcher ?
					postFinder || (seed ? preFilter : preexisting || postFilter) ?
						[] :
						results :
					matcherIn;
			if (matcher) {
				matcher(matcherIn, matcherOut, context, xml);
			}
			if (postFilter) {
				temp = condense(matcherOut, postMap);
				postFilter(temp, [], context, xml);
				i = temp.length;
				while (i--) {
					if ((elem = temp[i])) {
						matcherOut[postMap[i]] = !(matcherIn[postMap[i]] = elem);
					}
				}
			}

			if (seed) {
				if (postFinder || preFilter) {
					if (postFinder) {
						temp = [];
						i = matcherOut.length;
						while (i--) {
							if ((elem = matcherOut[i])) {
								temp.push((matcherIn[i] = elem));
							}
						}
						postFinder(null, (matcherOut = []), temp, xml);
					}
					i = matcherOut.length;
					while (i--) {
						if ((elem = matcherOut[i]) &&
							(temp = postFinder ? indexOf(seed, elem) : preMap[i]) > -1) {

							seed[temp] = !(results[temp] = elem);
						}
					}
				}
			} else {
				matcherOut = condense(
					matcherOut === results ?
						matcherOut.splice(preexisting, matcherOut.length) :
						matcherOut
				);
				if (postFinder) {
					postFinder(null, results, matcherOut, xml);
				} else {
					push.apply(results, matcherOut);
				}
			}
		});
	}

	function matcherFromTokens(tokens) {
		var checkContext, matcher, j,
			len = tokens.length,
			leadingRelative = Expr.relative[tokens[0].type],
			implicitRelative = leadingRelative || Expr.relative[" "],
			i = leadingRelative ? 1 : 0,
			matchContext = addCombinator(function (elem) {
				return elem === checkContext;
			}, implicitRelative, true),
			matchAnyContext = addCombinator(function (elem) {
				return indexOf(checkContext, elem) > -1;
			}, implicitRelative, true),
			matchers = [function (elem, context, xml) {
				var ret = (!leadingRelative && (xml || context !== outermostContext)) || (
					(checkContext = context).nodeType ?
						matchContext(elem, context, xml) :
						matchAnyContext(elem, context, xml));
				checkContext = null;
				return ret;
			}];

		for (; i < len; i++) {
			if ((matcher = Expr.relative[tokens[i].type])) {
				matchers = [addCombinator(elementMatcher(matchers), matcher)];
			} else {
				matcher = Expr.filter[tokens[i].type].apply(null, tokens[i].matches);
				if (matcher[expando]) {
					j = ++i;
					for (; j < len; j++) {
						if (Expr.relative[tokens[j].type]) {
							break;
						}
					}
					return setMatcher(
						i > 1 && elementMatcher(matchers),
						i > 1 && toSelector(
							tokens
								.slice(0, i - 1)
								.concat({ value: tokens[i - 2].type === " " ? "*" : "" })
						).replace(rtrim, "$1"),
						matcher,
						i < j && matcherFromTokens(tokens.slice(i, j)),
						j < len && matcherFromTokens((tokens = tokens.slice(j))),
						j < len && toSelector(tokens)
					);
				}
				matchers.push(matcher);
			}
		}

		return elementMatcher(matchers);
	}

	function matcherFromGroupMatchers(elementMatchers, setMatchers) {
		var bySet = setMatchers.length > 0,
			byElement = elementMatchers.length > 0,
			superMatcher = function (seed, context, xml, results, outermost) {
				var elem, j, matcher,
					matchedCount = 0,
					i = "0",
					unmatched = seed && [],
					setMatched = [],
					contextBackup = outermostContext,
					elems = seed || byElement && Expr.find["TAG"]("*", outermost),
					dirrunsUnique = (dirruns += contextBackup == null ? 1 : Math.random() || 0.1),
					len = elems.length;

				if (outermost) {
					outermostContext = context == document || context || outermost;
				}
				for (; i !== len && (elem = elems[i]) != null; i++) {
					if (byElement && elem) {
						j = 0;
						if (!context && elem.ownerDocument != document) {
							setDocument(elem);
							xml = !documentIsHTML;
						}
						while ((matcher = elementMatchers[j++])) {
							if (matcher(elem, context || document, xml)) {
								results.push(elem);
								break;
							}
						}
						if (outermost) {
							dirruns = dirrunsUnique;
						}
					}
					if (bySet) {
						if ((elem = !matcher && elem)) {
							matchedCount--;
						}
						if (seed) {
							unmatched.push(elem);
						}
					}
				}
				matchedCount += i;
				if (bySet && i !== matchedCount) {
					j = 0;
					while ((matcher = setMatchers[j++])) {
						matcher(unmatched, setMatched, context, xml);
					}

					if (seed) {
						if (matchedCount > 0) {
							while (i--) {
								if (!(unmatched[i] || setMatched[i])) {
									setMatched[i] = pop.call(results);
								}
							}
						}
						setMatched = condense(setMatched);
					}
					push.apply(results, setMatched);
					if (outermost && !seed && setMatched.length > 0 &&
						(matchedCount + setMatchers.length) > 1) {

						Sizzle.uniqueSort(results);
					}
				}
				if (outermost) {
					dirruns = dirrunsUnique;
					outermostContext = contextBackup;
				}

				return unmatched;
			};

		return bySet ?
			markFunction(superMatcher) :
			superMatcher;
	}

	compile = Sizzle.compile = function (selector, match /* Internal Use Only */) {
		var i,
			setMatchers = [],
			elementMatchers = [],
			cached = compilerCache[selector + " "];

		if (!cached) {
			if (!match) {
				match = tokenize(selector);
			}
			i = match.length;
			while (i--) {
				cached = matcherFromTokens(match[i]);
				if (cached[expando]) {
					setMatchers.push(cached);
				} else {
					elementMatchers.push(cached);
				}
			}
			cached = compilerCache(
				selector,
				matcherFromGroupMatchers(elementMatchers, setMatchers)
			);
			cached.selector = selector;
		}
		return cached;
	};

	/**
	 * A low-level selection function that works with Sizzle's compiled
	 *  selector functions
	 * @param {String|Function} selector A selector or a pre-compiled
	 *  selector function built with Sizzle.compile
	 * @param {Element} context
	 * @param {Array} [results]
	 * @param {Array} [seed] A set of elements to match against
	 */
	select = Sizzle.select = function (selector, context, results, seed) {
		var i, tokens, token, type, find,
			compiled = typeof selector === "function" && selector,
			match = !seed && tokenize((selector = compiled.selector || selector));

		results = results || [];
		if (match.length === 1) {
			tokens = match[0] = match[0].slice(0);
			if (tokens.length > 2 && (token = tokens[0]).type === "ID" &&
				context.nodeType === 9 && documentIsHTML && Expr.relative[tokens[1].type]) {

				context = (Expr.find["ID"](token.matches[0]
					.replace(runescape, funescape), context) || [])[0];
				if (!context) {
					return results;
				} else if (compiled) {
					context = context.parentNode;
				}

				selector = selector.slice(tokens.shift().value.length);
			}
			i = matchExpr["needsContext"].test(selector) ? 0 : tokens.length;
			while (i--) {
				token = tokens[i];
				if (Expr.relative[(type = token.type)]) {
					break;
				}
				if ((find = Expr.find[type])) {
					if ((seed = find(
						token.matches[0].replace(runescape, funescape),
						rsibling.test(tokens[0].type) && testContext(context.parentNode) ||
						context
					))) {
						tokens.splice(i, 1);
						selector = seed.length && toSelector(tokens);
						if (!selector) {
							push.apply(results, seed);
							return results;
						}

						break;
					}
				}
			}
		}
		(compiled || compile(selector, match))(
			seed,
			context,
			!documentIsHTML,
			results,
			!context || rsibling.test(selector) && testContext(context.parentNode) || context
		);
		return results;
	};
	support.sortStable = expando.split("").sort(sortOrder).join("") === expando;
	support.detectDuplicates = !!hasDuplicate;
	setDocument();
	support.sortDetached = assert(function (el) {
		return el.compareDocumentPosition(document.createElement("fieldset")) & 1;
	});
	if (!assert(function (el) {
		el.innerHTML = "<a href='#'></a>";
		return el.firstChild.getAttribute("href") === "#";
	})) {
		addHandle("type|href|height|width", function (elem, name, isXML) {
			if (!isXML) {
				return elem.getAttribute(name, name.toLowerCase() === "type" ? 1 : 2);
			}
		});
	}
	if (!support.attributes || !assert(function (el) {
		el.innerHTML = "<input/>";
		el.firstChild.setAttribute("value", "");
		return el.firstChild.getAttribute("value") === "";
	})) {
		addHandle("value", function (elem, _name, isXML) {
			if (!isXML && elem.nodeName.toLowerCase() === "input") {
				return elem.defaultValue;
			}
		});
	}
	if (!assert(function (el) {
		return el.getAttribute("disabled") == null;
	})) {
		addHandle(booleans, function (elem, name, isXML) {
			var val;
			if (!isXML) {
				return elem[name] === true ? name.toLowerCase() :
					(val = elem.getAttributeNode(name)) && val.specified ?
						val.value :
						null;
			}
		});
	}
	var _sizzle = window.Sizzle;

	Sizzle.noConflict = function () {
		if (window.Sizzle === Sizzle) {
			window.Sizzle = _sizzle;
		}

		return Sizzle;
	};

	if (typeof define === "function" && define.amd) {
		define(function () {
			return Sizzle;
		});
	} else if (typeof module !== "undefined" && module.exports) {
		module.exports = Sizzle;
	} else {
		window.Sizzle = Sizzle;
	}
})(window);
