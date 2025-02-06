define([
	"./arr"
], function (arr) {

	"use strict";
	return arr.flat ? function (array) {
		return arr.flat.call(array);
	} : function (array) {
		return arr.concat.apply([], array);
	};

});
