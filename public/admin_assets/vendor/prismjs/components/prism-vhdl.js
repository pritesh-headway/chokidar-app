Prism.languages.vhdl = {
	'comment': /--.+/,

	'vhdl-vectors': {
		'pattern': /\b[oxb]"[\da-f_]+"|"[01uxzwlh-]+"/i,
		'alias': 'number'
	},

	'quoted-function': {
		pattern: /"\S+?"(?=\()/,
		alias: 'function'
	},
	'string': /"(?:[^\\"\r\n]|\\(?:\r\n|[\s\S]))*"/,
	'attribute': {
		pattern: /\b'\w+/,
		alias: 'attr-name'
	},

	'keyword': /\b(?:access|after|alias|all|architecture|array|assert|attribute|begin|block|body|buffer|bus|case|component|configuration|constant|disconnect|downto|else|elsif|end|entity|exit|file|for|function|generate|generic|group|guarded|if|impure|in|inertial|inout|is|label|library|linkage|literal|loop|map|new|next|null|of|on|open|others|out|package|port|postponed|private|procedure|process|pure|range|record|register|reject|report|return|select|severity|shared|signal|subtype|then|to|transport|type|unaffected|units|until|use|variable|view|wait|when|while|with)\b/i,
	'boolean': /\b(?:false|true)\b/i,
	'function': /\w+(?=\()/,

	'number': /'[01uxzwlh-]'|\b(?:\d+#[\da-f_.]+#|\d[\d_.]*)(?:e[-+]?\d+)?/i,
	'operator': /[<>]=?|:=|[-+*/&=]|\b(?:abs|and|mod|nand|nor|not|or|rem|rol|ror|sla|sll|sra|srl|xnor|xor)\b/i,
	'punctuation': /[{}[\];(),.:]/
};
