(function () {

	if (typeof Prism === 'undefined' || typeof document === 'undefined') {
		return;
	}
	if (!Element.prototype.matches) {
		Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
	}
	Prism.plugins.UnescapedMarkup = true;

	Prism.hooks.add('before-highlightall', function (env) {
		env.selector += ', [class*="lang-"] script[type="text/plain"]'
			+ ', [class*="language-"] script[type="text/plain"]'
			+ ', script[type="text/plain"][class*="lang-"]'
			+ ', script[type="text/plain"][class*="language-"]';
	});

	Prism.hooks.add('before-sanity-check', function (env) {
		/** @type {HTMLElement} */
		var element = env.element;

		if (element.matches('script[type="text/plain"]')) {
			var code = document.createElement('code');
			var pre = document.createElement('pre');
			pre.className = code.className = element.className;
			var dataset = element.dataset;
			Object.keys(dataset || {}).forEach(function (key) {
				if (Object.prototype.hasOwnProperty.call(dataset, key)) {
					pre.dataset[key] = dataset[key];
				}
			});

			code.textContent = env.code = env.code.replace(/&lt;\/script(?:>|&gt;)/gi, '</scri' + 'pt>');
			pre.appendChild(code);
			element.parentNode.replaceChild(pre, element);
			env.element = code;
			return;
		}

		if (!env.code) {

			var childNodes = element.childNodes;
			if (childNodes.length === 1 && childNodes[0].nodeName == '#comment') {

				element.textContent = env.code = childNodes[0].textContent;
			}
		}
	});
}());
