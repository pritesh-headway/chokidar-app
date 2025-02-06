
Prism.languages.bicep = {
	'comment': [
		{

			pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,
			lookbehind: true,
			greedy: true
		},
		{

			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true,
			greedy: true
		}
	],

	'property': [
		{
			pattern: /([\r\n][ \t]*)[a-z_]\w*(?=[ \t]*:)/i,
			lookbehind: true
		},
		{
			pattern: /([\r\n][ \t]*)'(?:\\.|\$(?!\{)|[^'\\\r\n$])*'(?=[ \t]*:)/,
			lookbehind: true,
			greedy: true
		}
	],
	'string': [
		{
			pattern: /'''[^'][\s\S]*?'''/,
			greedy: true
		},
		{
			pattern: /(^|[^\\'])'(?:\\.|\$(?!\{)|[^'\\\r\n$])*'/,
			lookbehind: true,
			greedy: true,
		}
	],
	'interpolated-string': {
		pattern: /(^|[^\\'])'(?:\\.|\$(?:(?!\{)|\{[^{}\r\n]*\})|[^'\\\r\n$])*'/,
		lookbehind: true,
		greedy: true,
		inside: {
			'interpolation': {
				pattern: /\$\{[^{}\r\n]*\}/,
				inside: {
					'expression': {
						pattern: /(^\$\{)[\s\S]+(?=\}$)/,
						lookbehind: true
					},
					'punctuation': /^\$\{|\}$/,
				}
			},
			'string': /[\s\S]+/
		}
	},

	'datatype': {
		pattern: /(\b(?:output|param)\b[ \t]+\w+[ \t]+)\w+\b/,
		lookbehind: true,
		alias: 'class-name'
	},

	'boolean': /\b(?:false|true)\b/,

	'keyword': /\b(?:existing|for|if|in|module|null|output|param|resource|targetScope|var)\b/,

	'decorator': /@\w+\b/,
	'function': /\b[a-z_]\w*(?=[ \t]*\()/i,

	'number': /(?:\b\d+(?:\.\d*)?|\B\.\d+)(?:E[+-]?\d+)?/i,
	'operator': /--|\+\+|\*\*=?|=>|&&=?|\|\|=?|[!=]==|<<=?|>>>?=?|[-+*/%&|^!=<>]=?|\.{3}|\?\?=?|\?\.?|[~:]/,
	'punctuation': /[{}[\];(),.:]/,
};

Prism.languages.bicep['interpolated-string'].inside['interpolation'].inside['expression'].inside = Prism.languages.bicep;
