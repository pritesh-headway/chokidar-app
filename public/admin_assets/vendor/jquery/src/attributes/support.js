define([
	"../var/document",
	"../var/support"
], function (document, support) {

	"use strict";

	(function () {
		var input = document.createElement("input"),
			select = document.createElement("select"),
			opt = select.appendChild(document.createElement("option"));

		input.type = "checkbox";
		support.checkOn = input.value !== "";
		support.optSelected = opt.selected;
		input = document.createElement("input");
		input.value = "t";
		input.type = "radio";
		support.radioValue = input.value === "t";
	})();

	return support;

});
