define(function () {

	"use strict";

	/**
	 * Determines whether an object can have data
	 */
	return function (owner) {
		return owner.nodeType === 1 || owner.nodeType === 9 || !(+owner.nodeType);
	};

});
