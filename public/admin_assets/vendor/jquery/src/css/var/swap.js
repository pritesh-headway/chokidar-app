define(function () {

	"use strict";
	return function (elem, options, callback) {
		var ret, name,
			old = {};
		for (name in options) {
			old[name] = elem.style[name];
			elem.style[name] = options[name];
		}

		ret = callback.call(elem);
		for (name in options) {
			elem.style[name] = old[name];
		}

		return ret;
	};

});
