Prism.languages.mermaid = {
	'comment': {
		pattern: /%%.*/,
		greedy: true
	},

	'style': {
		pattern: /^([ \t]*(?:classDef|linkStyle|style)[ \t]+[\w$-]+[ \t]+)\w.*[^\s;]/m,
		lookbehind: true,
		inside: {
			'property': /\b\w[\w-]*(?=[ \t]*:)/,
			'operator': /:/,
			'punctuation': /,/
		}
	},

	'inter-arrow-label': {
		pattern: /([^<>ox.=-])(?:-[-.]|==)(?![<>ox.=-])[ \t]*(?:"[^"\r\n]*"|[^\s".=-](?:[^\r\n.=-]*[^\s.=-])?)[ \t]*(?:\.+->?|--+[->]|==+[=>])(?![<>ox.=-])/,
		lookbehind: true,
		greedy: true,
		inside: {
			'arrow': {
				pattern: /(?:\.+->?|--+[->]|==+[=>])$/,
				alias: 'operator'
			},
			'label': {
				pattern: /^([\s\S]{2}[ \t]*)\S(?:[\s\S]*\S)?/,
				lookbehind: true,
				alias: 'property'
			},
			'arrow-head': {
				pattern: /^\S+/,
				alias: ['arrow', 'operator']
			}
		}
	},

	'arrow': [
		{

			pattern: /(^|[^{}|o.-])[|}][|o](?:--|\.\.)[|o][|{](?![{}|o.-])/,
			lookbehind: true,
			alias: 'operator'
		},
		{
			pattern: /(^|[^<>ox.=-])(?:[<ox](?:==+|--+|-\.*-)[>ox]?|(?:==+|--+|-\.*-)[>ox]|===+|---+|-\.+-)(?![<>ox.=-])/,
			lookbehind: true,
			alias: 'operator'
		},
		{

			pattern: /(^|[^<>()x-])(?:--?(?:>>|[x>)])(?![<>()x])|(?:<<|[x<(])--?(?!-))/,
			lookbehind: true,
			alias: 'operator'
		},
		{

			pattern: /(^|[^<>|*o.-])(?:[*o]--|--[*o]|<\|?(?:--|\.\.)|(?:--|\.\.)\|?>|--|\.\.)(?![<>|*o.-])/,
			lookbehind: true,
			alias: 'operator'
		},
	],

	'label': {
		pattern: /(^|[^|<])\|(?:[^\r\n"|]|"[^"\r\n]*")+\|/,
		lookbehind: true,
		greedy: true,
		alias: 'property'
	},

	'text': {
		pattern: /(?:[(\[{]+|\b>)(?:[^\r\n"()\[\]{}]|"[^"\r\n]*")+(?:[)\]}]+|>)/,
		alias: 'string'
	},
	'string': {
		pattern: /"[^"\r\n]*"/,
		greedy: true
	},

	'annotation': {
		pattern: /<<(?:abstract|choice|enumeration|fork|interface|join|service)>>|\[\[(?:choice|fork|join)\]\]/i,
		alias: 'important'
	},

	'keyword': [

		{
			pattern: /(^[ \t]*)(?:action|callback|class|classDef|classDiagram|click|direction|erDiagram|flowchart|gantt|gitGraph|graph|journey|link|linkStyle|pie|requirementDiagram|sequenceDiagram|stateDiagram|stateDiagram-v2|style|subgraph)(?![\w$-])/m,
			lookbehind: true,
			greedy: true
		},
		{
			pattern: /(^[ \t]*)(?:activate|alt|and|as|autonumber|deactivate|else|end(?:[ \t]+note)?|loop|opt|par|participant|rect|state|note[ \t]+(?:over|(?:left|right)[ \t]+of))(?![\w$-])/im,
			lookbehind: true,
			greedy: true
		}
	],

	'entity': /#[a-z0-9]+;/,

	'operator': {
		pattern: /(\w[ \t]*)&(?=[ \t]*\w)|:::|:/,
		lookbehind: true
	},
	'punctuation': /[(){};]/
};
