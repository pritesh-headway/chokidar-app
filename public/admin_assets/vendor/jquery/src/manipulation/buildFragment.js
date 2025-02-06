define([
	"../core",
	"../core/toType",
	"../core/isAttached",
	"./var/rtagName",
	"./var/rscriptType",
	"./wrapMap",
	"./getAll",
	"./setGlobalEval"
], function (jQuery, toType, isAttached, rtagName, rscriptType, wrapMap, getAll, setGlobalEval) {

	"use strict";

	var rhtml = /<|&#?\w+;/;

	function buildFragment(elems, context, scripts, selection, ignored) {
		var elem, tmp, tag, wrap, attached, j,
			fragment = context.createDocumentFragment(),
			nodes = [],
			i = 0,
			l = elems.length;

		for (; i < l; i++) {
			elem = elems[i];

			if (elem || elem === 0) {
				if (toType(elem) === "object") {
					jQuery.merge(nodes, elem.nodeType ? [elem] : elem);
				} else if (!rhtml.test(elem)) {
					nodes.push(context.createTextNode(elem));
				} else {
					tmp = tmp || fragment.appendChild(context.createElement("div"));
					tag = (rtagName.exec(elem) || ["", ""])[1].toLowerCase();
					wrap = wrapMap[tag] || wrapMap._default;
					tmp.innerHTML = wrap[1] + jQuery.htmlPrefilter(elem) + wrap[2];
					j = wrap[0];
					while (j--) {
						tmp = tmp.lastChild;
					}
					jQuery.merge(nodes, tmp.childNodes);
					tmp = fragment.firstChild;
					tmp.textContent = "";
				}
			}
		}
		fragment.textContent = "";

		i = 0;
		while ((elem = nodes[i++])) {
			if (selection && jQuery.inArray(elem, selection) > -1) {
				if (ignored) {
					ignored.push(elem);
				}
				continue;
			}

			attached = isAttached(elem);
			tmp = getAll(fragment.appendChild(elem), "script");
			if (attached) {
				setGlobalEval(tmp);
			}
			if (scripts) {
				j = 0;
				while ((elem = tmp[j++])) {
					if (rscriptType.test(elem.type || "")) {
						scripts.push(elem);
					}
				}
			}
		}

		return fragment;
	}

	return buildFragment;
});
