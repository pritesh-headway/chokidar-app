/* FIXME :
 :extend() is not handled specifically : its highlighting is buggy.
 Mixin usage must be inside a ruleset to be highlighted.
 At-rules (e.g. import) containing interpolations are buggy.
 Detached rulesets are highlighted as at-rules.
 A comment before a mixin usage prevents the latter to be properly highlighted.
 */

Prism.languages.less = Prism.languages.extend('css', {
	'comment': [
		/\/\*[\s\S]*?\*\//,
		{
			pattern: /(^|[^\\])\/\/.*/,
			lookbehind: true
		}
	],
	'atrule': {
		pattern: /@[\w-](?:\((?:[^(){}]|\([^(){}]*\))*\)|[^(){};\s]|\s+(?!\s))*?(?=\s*\{)/,
		inside: {
			'punctuation': /[:()]/
		}
	},

	'selector': {
		pattern: /(?:@\{[\w-]+\}|[^{};\s@])(?:@\{[\w-]+\}|\((?:[^(){}]|\([^(){}]*\))*\)|[^(){};@\s]|\s+(?!\s))*?(?=\s*\{)/,
		inside: {

			'variable': /@+[\w-]+/
		}
	},

	'property': /(?:@\{[\w-]+\}|[\w-])+(?:\+_?)?(?=\s*:)/,
	'operator': /[+\-*\/]/
});

Prism.languages.insertBefore('less', 'property', {
	'variable': [

		{
			pattern: /@[\w-]+\s*:/,
			inside: {
				'punctuation': /:/
			}
		},
		/@@?[\w-]+/
	],
	'mixin-usage': {
		pattern: /([{;]\s*)[.#](?!\d)[\w-].*?(?=[(;])/,
		lookbehind: true,
		alias: 'function'
	}
});
