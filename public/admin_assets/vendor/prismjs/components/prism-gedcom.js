Prism.languages.gedcom = {
	'line-value': {

		pattern: /(^[\t ]*\d+ +(?:@\w[\w!"$%&'()*+,\-./:;<=>?[\\\]^`{|}~\x80-\xfe #]*@ +)?\w+ ).+/m,
		lookbehind: true,
		inside: {
			'pointer': {
				pattern: /^@\w[\w!"$%&'()*+,\-./:;<=>?[\\\]^`{|}~\x80-\xfe #]*@$/,
				alias: 'variable'
			}
		}
	},
	'record': {

		pattern: /(^[\t ]*\d+ +(?:@\w[\w!"$%&'()*+,\-./:;<=>?[\\\]^`{|}~\x80-\xfe #]*@ +)?)\w+/m,
		lookbehind: true,
		alias: 'tag'
	},
	'level': {
		pattern: /(^[\t ]*)\d+/m,
		lookbehind: true,
		alias: 'number'
	},
	'pointer': {
		pattern: /@\w[\w!"$%&'()*+,\-./:;<=>?[\\\]^`{|}~\x80-\xfe #]*@/,
		alias: 'variable'
	}
};
