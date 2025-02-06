define([
	"../core",
	"../core/camelCase",
	"../var/rnothtmlwhite",
	"./var/acceptData"
], function (jQuery, camelCase, rnothtmlwhite, acceptData) {

	"use strict";

	function Data() {
		this.expando = jQuery.expando + Data.uid++;
	}

	Data.uid = 1;

	Data.prototype = {

		cache: function (owner) {
			var value = owner[this.expando];
			if (!value) {
				value = {};
				if (acceptData(owner)) {
					if (owner.nodeType) {
						owner[this.expando] = value;
					} else {
						Object.defineProperty(owner, this.expando, {
							value: value,
							configurable: true
						});
					}
				}
			}

			return value;
		},
		set: function (owner, data, value) {
			var prop,
				cache = this.cache(owner);
			if (typeof data === "string") {
				cache[camelCase(data)] = value;
			} else {
				for (prop in data) {
					cache[camelCase(prop)] = data[prop];
				}
			}
			return cache;
		},
		get: function (owner, key) {
			return key === undefined ?
				this.cache(owner) :
				owner[this.expando] && owner[this.expando][camelCase(key)];
		},
		access: function (owner, key, value) {
			//
			//
			//
			//
			if (key === undefined ||
				((key && typeof key === "string") && value === undefined)) {

				return this.get(owner, key);
			}
			//
			//
			this.set(owner, key, value);
			return value !== undefined ? value : key;
		},
		remove: function (owner, key) {
			var i,
				cache = owner[this.expando];

			if (cache === undefined) {
				return;
			}

			if (key !== undefined) {
				if (Array.isArray(key)) {
					key = key.map(camelCase);
				} else {
					key = camelCase(key);
					key = key in cache ?
						[key] :
						(key.match(rnothtmlwhite) || []);
				}

				i = key.length;

				while (i--) {
					delete cache[key[i]];
				}
			}
			if (key === undefined || jQuery.isEmptyObject(cache)) {
				if (owner.nodeType) {
					owner[this.expando] = undefined;
				} else {
					delete owner[this.expando];
				}
			}
		},
		hasData: function (owner) {
			var cache = owner[this.expando];
			return cache !== undefined && !jQuery.isEmptyObject(cache);
		}
	};

	return Data;
});
