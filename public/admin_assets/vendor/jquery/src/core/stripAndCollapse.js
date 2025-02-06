define([
	"../var/rnothtmlwhite"
], function (rnothtmlwhite) {
	"use strict";
	function stripAndCollapse(value) {
		var tokens = value.match(rnothtmlwhite) || [];
		return tokens.join(" ");
	}

	return stripAndCollapse;
});
