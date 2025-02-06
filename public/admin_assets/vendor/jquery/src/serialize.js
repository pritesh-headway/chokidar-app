define([
	"./core",
	"./core/toType",
	"./var/rcheckableType",
	"./var/isFunction",
	"./core/init",
	"./traversing",
	"./attributes/prop"
], function (jQuery, toType, rcheckableType, isFunction) {

	"use strict";

	var
		rbracket = /\[\]$/,
		rCRLF = /\r?\n/g,
		rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
		rsubmittable = /^(?:input|select|textarea|keygen)/i;

	function buildParams(prefix, obj, traditional, add) {
		var name;

		if (Array.isArray(obj)) {
			jQuery.each(obj, function (i, v) {
				if (traditional || rbracket.test(prefix)) {
					add(prefix, v);

				} else {
					buildParams(
						prefix + "[" + (typeof v === "object" && v != null ? i : "") + "]",
						v,
						traditional,
						add
					);
				}
			});

		} else if (!traditional && toType(obj) === "object") {
			for (name in obj) {
				buildParams(prefix + "[" + name + "]", obj[name], traditional, add);
			}

		} else {
			add(prefix, obj);
		}
	}
	jQuery.param = function (a, traditional) {
		var prefix,
			s = [],
			add = function (key, valueOrFunction) {
				var value = isFunction(valueOrFunction) ?
					valueOrFunction() :
					valueOrFunction;

				s[s.length] = encodeURIComponent(key) + "=" +
					encodeURIComponent(value == null ? "" : value);
			};

		if (a == null) {
			return "";
		}
		if (Array.isArray(a) || (a.jquery && !jQuery.isPlainObject(a))) {
			jQuery.each(a, function () {
				add(this.name, this.value);
			});

		} else {
			for (prefix in a) {
				buildParams(prefix, a[prefix], traditional, add);
			}
		}
		return s.join("&");
	};

	jQuery.fn.extend({
		serialize: function () {
			return jQuery.param(this.serializeArray());
		},
		serializeArray: function () {
			return this.map(function () {
				var elements = jQuery.prop(this, "elements");
				return elements ? jQuery.makeArray(elements) : this;
			}).filter(function () {
				var type = this.type;
				return this.name && !jQuery(this).is(":disabled") &&
					rsubmittable.test(this.nodeName) && !rsubmitterTypes.test(type) &&
					(this.checked || !rcheckableType.test(type));
			}).map(function (_i, elem) {
				var val = jQuery(this).val();

				if (val == null) {
					return null;
				}

				if (Array.isArray(val)) {
					return jQuery.map(val, function (val) {
						return { name: elem.name, value: val.replace(rCRLF, "\r\n") };
					});
				}

				return { name: elem.name, value: val.replace(rCRLF, "\r\n") };
			}).get();
		}
	});

	return jQuery;
});
