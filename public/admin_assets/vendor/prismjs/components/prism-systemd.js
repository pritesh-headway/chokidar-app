(function (Prism) {

	var comment = {
		pattern: /^[;#].*/m,
		greedy: true
	};

	var quotesSource = /"(?:[^\r\n"\\]|\\(?:[^\r]|\r\n?))*"(?!\S)/.source;

	Prism.languages.systemd = {
		'comment': comment,

		'section': {
			pattern: /^\[[^\n\r\[\]]*\](?=[ \t]*$)/m,
			greedy: true,
			inside: {
				'punctuation': /^\[|\]$/,
				'section-name': {
					pattern: /[\s\S]+/,
					alias: 'selector'
				},
			}
		},

		'key': {
			pattern: /^[^\s=]+(?=[ \t]*=)/m,
			greedy: true,
			alias: 'attr-name'
		},
		'value': {
			pattern: RegExp(
				/(=[ \t]*(?!\s))/.source +

				'(?:' + quotesSource + '|(?=[^"\r\n]))' +

				'(?:' + (
					/[^\s\\]/.source +

					'|' + '[ \t]+(?:(?![ \t"])|' + quotesSource + ')' +

					'|' + /\\[\r\n]+(?:[#;].*[\r\n]+)*(?![#;])/.source
				) +
				')*'
			),
			lookbehind: true,
			greedy: true,
			alias: 'attr-value',
			inside: {
				'comment': comment,
				'quoted': {
					pattern: RegExp(/(^|\s)/.source + quotesSource),
					lookbehind: true,
					greedy: true,
				},
				'punctuation': /\\$/m,

				'boolean': {
					pattern: /^(?:false|no|off|on|true|yes)$/,
					greedy: true
				}
			}
		},

		'punctuation': /=/
	};

}(Prism));
