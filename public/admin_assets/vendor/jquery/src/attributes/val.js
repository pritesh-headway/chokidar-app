define([
	"../core",
	"../core/stripAndCollapse",
	"./support",
	"../core/nodeName",
	"../var/isFunction",

	"../core/init"
], function (jQuery, stripAndCollapse, support, nodeName, isFunction) {

	"use strict";

	var rreturn = /\r/g;

	jQuery.fn.extend({
		val: function (value) {
			var hooks, ret, valueIsFunction,
				elem = this[0];

			if (!arguments.length) {
				if (elem) {
					hooks = jQuery.valHooks[elem.type] ||
						jQuery.valHooks[elem.nodeName.toLowerCase()];

					if (hooks &&
						"get" in hooks &&
						(ret = hooks.get(elem, "value")) !== undefined
					) {
						return ret;
					}

					ret = elem.value;
					if (typeof ret === "string") {
						return ret.replace(rreturn, "");
					}
					return ret == null ? "" : ret;
				}

				return;
			}

			valueIsFunction = isFunction(value);

			return this.each(function (i) {
				var val;

				if (this.nodeType !== 1) {
					return;
				}

				if (valueIsFunction) {
					val = value.call(this, i, jQuery(this).val());
				} else {
					val = value;
				}
				if (val == null) {
					val = "";

				} else if (typeof val === "number") {
					val += "";

				} else if (Array.isArray(val)) {
					val = jQuery.map(val, function (value) {
						return value == null ? "" : value + "";
					});
				}

				hooks = jQuery.valHooks[this.type] || jQuery.valHooks[this.nodeName.toLowerCase()];
				if (!hooks || !("set" in hooks) || hooks.set(this, val, "value") === undefined) {
					this.value = val;
				}
			});
		}
	});

	jQuery.extend({
		valHooks: {
			option: {
				get: function (elem) {

					var val = jQuery.find.attr(elem, "value");
					return val != null ?
						val :
						stripAndCollapse(jQuery.text(elem));
				}
			},
			select: {
				get: function (elem) {
					var value, option, i,
						options = elem.options,
						index = elem.selectedIndex,
						one = elem.type === "select-one",
						values = one ? null : [],
						max = one ? index + 1 : options.length;

					if (index < 0) {
						i = max;

					} else {
						i = one ? index : 0;
					}
					for (; i < max; i++) {
						option = options[i];
						if ((option.selected || i === index) &&
							!option.disabled &&
							(!option.parentNode.disabled ||
								!nodeName(option.parentNode, "optgroup"))) {
							value = jQuery(option).val();
							if (one) {
								return value;
							}
							values.push(value);
						}
					}

					return values;
				},

				set: function (elem, value) {
					var optionSet, option,
						options = elem.options,
						values = jQuery.makeArray(value),
						i = options.length;

					while (i--) {
						option = options[i];

						/* eslint-disable no-cond-assign */

						if (option.selected =
							jQuery.inArray(jQuery.valHooks.option.get(option), values) > -1
						) {
							optionSet = true;
						}

						/* eslint-enable no-cond-assign */
					}
					if (!optionSet) {
						elem.selectedIndex = -1;
					}
					return values;
				}
			}
		}
	});
	jQuery.each(["radio", "checkbox"], function () {
		jQuery.valHooks[this] = {
			set: function (elem, value) {
				if (Array.isArray(value)) {
					return (elem.checked = jQuery.inArray(jQuery(elem).val(), value) > -1);
				}
			}
		};
		if (!support.checkOn) {
			jQuery.valHooks[this].get = function (elem) {
				return elem.getAttribute("value") === null ? "on" : elem.value;
			};
		}
	});

});
