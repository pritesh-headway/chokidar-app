(function (Prism) {
	var aggregations = [
		'sum',
		'min',
		'max',
		'avg',
		'group',
		'stddev',
		'stdvar',
		'count',
		'count_values',
		'bottomk',
		'topk',
		'quantile'
	];
	var vectorMatching = [
		'on',
		'ignoring',
		'group_right',
		'group_left',
		'by',
		'without',
	];
	var offsetModifier = ['offset'];

	var keywords = aggregations.concat(vectorMatching, offsetModifier);

	Prism.languages.promql = {
		'comment': {
			pattern: /(^[ \t]*)#.*/m,
			lookbehind: true
		},
		'vector-match': {

			pattern: new RegExp('((?:' + vectorMatching.join('|') + ')\\s*)\\([^)]*\\)'),
			lookbehind: true,
			inside: {
				'label-key': {
					pattern: /\b[^,]+\b/,
					alias: 'attr-name',
				},
				'punctuation': /[(),]/
			},
		},
		'context-labels': {
			pattern: /\{[^{}]*\}/,
			inside: {
				'label-key': {
					pattern: /\b[a-z_]\w*(?=\s*(?:=|![=~]))/,
					alias: 'attr-name',
				},
				'label-value': {
					pattern: /(["'`])(?:\\[\s\S]|(?!\1)[^\\])*\1/,
					greedy: true,
					alias: 'attr-value',
				},
				'punctuation': /\{|\}|=~?|![=~]|,/,
			},
		},
		'context-range': [
			{
				pattern: /\[[\w\s:]+\]/,
				inside: {
					'punctuation': /\[|\]|:/,
					'range-duration': {
						pattern: /\b(?:\d+(?:[smhdwy]|ms))+\b/i,
						alias: 'number',
					},
				},
			},
			{
				pattern: /(\boffset\s+)\w+/,
				lookbehind: true,
				inside: {
					'range-duration': {
						pattern: /\b(?:\d+(?:[smhdwy]|ms))+\b/i,
						alias: 'number',
					},
				},
			},
		],
		'keyword': new RegExp('\\b(?:' + keywords.join('|') + ')\\b', 'i'),
		'function': /\b[a-z_]\w*(?=\s*\()/i,
		'number': /[-+]?(?:(?:\b\d+(?:\.\d+)?|\B\.\d+)(?:e[-+]?\d+)?\b|\b(?:0x[0-9a-f]+|nan|inf)\b)/i,
		'operator': /[\^*/%+-]|==|!=|<=|<|>=|>|\b(?:and|or|unless)\b/i,
		'punctuation': /[{};()`,.[\]]/,
	};
}(Prism));
