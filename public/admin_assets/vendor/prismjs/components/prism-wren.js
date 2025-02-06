Prism.languages.wren = {
	'comment': [
		{
			pattern: /\/\*(?:[^*/]|\*(?!\/)|\/(?!\*)|\/\*(?:[^*/]|\*(?!\/)|\/(?!\*)|\/\*(?:[^*/]|\*(?!\/)|\/(?!\*))*\*\/)*\*\/)*\*\//,
			greedy: true
		},
		{
			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true,
			greedy: true
		}
	],
	'triple-quoted-string': {
		pattern: /"""[\s\S]*?"""/,
		greedy: true,
		alias: 'string'
	},
	'string-literal': null,
	'hashbang': {
		pattern: /^#!\/.+/,
		greedy: true,
		alias: 'comment'
	},
	'attribute': {
		pattern: /#!?[ \t\u3000]*\w+/,
		alias: 'keyword'
	},
	'class-name': [
		{
			pattern: /(\bclass\s+)\w+/,
			lookbehind: true
		},
		/\b[A-Z][a-z\d_]*\b/,
	],
	'constant': /\b[A-Z][A-Z\d_]*\b/,

	'null': {
		pattern: /\bnull\b/,
		alias: 'keyword'
	},
	'keyword': /\b(?:as|break|class|construct|continue|else|for|foreign|if|import|in|is|return|static|super|this|var|while)\b/,
	'boolean': /\b(?:false|true)\b/,
	'number': /\b(?:0x[\da-f]+|\d+(?:\.\d+)?(?:e[+-]?\d+)?)\b/i,
	'function': /\b[a-z_]\w*(?=\s*[({])/i,

	'operator': /<<|>>|[=!<>]=?|&&|\|\||[-+*/%~^&|?:]|\.{2,3}/,
	'punctuation': /[\[\](){}.,;]/,
};

Prism.languages.wren['string-literal'] = {

	pattern: /(^|[^\\"])"(?:[^\\"%]|\\[\s\S]|%(?!\()|%\((?:[^()]|\((?:[^()]|\([^)]*\))*\))*\))*"/,
	lookbehind: true,
	greedy: true,
	inside: {
		'interpolation': {

			pattern: /((?:^|[^\\])(?:\\{2})*)%\((?:[^()]|\((?:[^()]|\([^)]*\))*\))*\)/,
			lookbehind: true,
			inside: {
				'expression': {
					pattern: /^(%\()[\s\S]+(?=\)$)/,
					lookbehind: true,
					inside: Prism.languages.wren
				},
				'interpolation-punctuation': {
					pattern: /^%\(|\)$/,
					alias: 'punctuation'
				},
			}
		},
		'string': /[\s\S]+/
	}
};
