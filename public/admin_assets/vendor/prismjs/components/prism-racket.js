Prism.languages.racket = Prism.languages.extend('scheme', {
	'lambda-parameter': {
		pattern: /([(\[]lambda\s+[(\[])[^()\[\]'\s]+/,
		lookbehind: true
	}
});

Prism.languages.insertBefore('racket', 'string', {
	'lang': {
		pattern: /^#lang.+/m,
		greedy: true,
		alias: 'keyword'
	}
});

Prism.languages.rkt = Prism.languages.racket;
