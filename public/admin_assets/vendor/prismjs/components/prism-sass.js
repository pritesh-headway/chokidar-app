(function (Prism) {
	Prism.languages.sass = Prism.languages.extend('css', {

		'comment': {
			pattern: /^([ \t]*)\/[\/*].*(?:(?:\r?\n|\r)\1[ \t].+)*/m,
			lookbehind: true,
			greedy: true
		}
	});

	Prism.languages.insertBefore('sass', 'atrule', {

		'atrule-line': {

			pattern: /^(?:[ \t]*)[@+=].+/m,
			greedy: true,
			inside: {
				'atrule': /(?:@[\w-]+|[+=])/
			}
		}
	});
	delete Prism.languages.sass.atrule;
	var variable = /\$[-\w]+|#\{\$[-\w]+\}/;
	var operator = [
		/[+*\/%]|[=!]=|<=?|>=?|\b(?:and|not|or)\b/,
		{
			pattern: /(\s)-(?=\s)/,
			lookbehind: true
		}
	];

	Prism.languages.insertBefore('sass', 'property', {

		'variable-line': {
			pattern: /^[ \t]*\$.+/m,
			greedy: true,
			inside: {
				'punctuation': /:/,
				'variable': variable,
				'operator': operator
			}
		},

		'property-line': {
			pattern: /^[ \t]*(?:[^:\s]+ *:.*|:[^:\s].*)/m,
			greedy: true,
			inside: {
				'property': [
					/[^:\s]+(?=\s*:)/,
					{
						pattern: /(:)[^:\s]+/,
						lookbehind: true
					}
				],
				'punctuation': /:/,
				'variable': variable,
				'operator': operator,
				'important': Prism.languages.sass.important
			}
		}
	});
	delete Prism.languages.sass.property;
	delete Prism.languages.sass.important;
	Prism.languages.insertBefore('sass', 'punctuation', {
		'selector': {
			pattern: /^([ \t]*)\S(?:,[^,\r\n]+|[^,\r\n]*)(?:,[^,\r\n]+)*(?:,(?:\r?\n|\r)\1[ \t]+\S(?:,[^,\r\n]+|[^,\r\n]*)(?:,[^,\r\n]+)*)*/m,
			lookbehind: true,
			greedy: true
		}
	});

}(Prism));
