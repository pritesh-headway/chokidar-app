define([
	"../var/document"
], function (document) {
	"use strict";

	var preservedScriptAttributes = {
		type: true,
		src: true,
		nonce: true,
		noModule: true
	};

	function DOMEval(code, node, doc) {
		doc = doc || document;

		var i, val,
			script = doc.createElement("script");

		script.text = code;
		if (node) {
			for (i in preservedScriptAttributes) {
				val = node[i] || node.getAttribute && node.getAttribute(i);
				if (val) {
					script.setAttribute(i, val);
				}
			}
		}
		doc.head.appendChild(script).parentNode.removeChild(script);
	}

	return DOMEval;
});
