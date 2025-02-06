define([
	"./core",
	"./core/toType",
	"./var/isFunction",
	"./var/rnothtmlwhite"
], function (jQuery, toType, isFunction, rnothtmlwhite) {

	"use strict";
	function createOptions(options) {
		var object = {};
		jQuery.each(options.match(rnothtmlwhite) || [], function (_, flag) {
			object[flag] = true;
		});
		return object;
	}

	/*
	 * Create a callback list using the following parameters:
	 *
	 *	options: an optional list of space-separated options that will change how
	 *			the callback list behaves or a more traditional option object
	 *
	 * By default a callback list will act like an event callback list and can be
	 * "fired" multiple times.
	 *
	 * Possible options:
	 *
	 *	once:			will ensure the callback list can only be fired once (like a Deferred)
	 *
	 *	memory:			will keep track of previous values and will call any callback added
	 *					after the list has been fired right away with the latest "memorized"
	 *					values (like a Deferred)
	 *
	 *	unique:			will ensure a callback can only be added once (no duplicate in the list)
	 *
	 *	stopOnFalse:	interrupt callings when a callback returns false
	 *
	 */
	jQuery.Callbacks = function (options) {
		options = typeof options === "string" ?
			createOptions(options) :
			jQuery.extend({}, options);

		var
			firing,
			memory,
			fired,
			locked,
			list = [],
			queue = [],
			firingIndex = -1,
			fire = function () {
				locked = locked || options.once;
				fired = firing = true;
				for (; queue.length; firingIndex = -1) {
					memory = queue.shift();
					while (++firingIndex < list.length) {
						if (list[firingIndex].apply(memory[0], memory[1]) === false &&
							options.stopOnFalse) {
							firingIndex = list.length;
							memory = false;
						}
					}
				}
				if (!options.memory) {
					memory = false;
				}

				firing = false;
				if (locked) {
					if (memory) {
						list = [];
					} else {
						list = "";
					}
				}
			},
			self = {
				add: function () {
					if (list) {
						if (memory && !firing) {
							firingIndex = list.length - 1;
							queue.push(memory);
						}

						(function add(args) {
							jQuery.each(args, function (_, arg) {
								if (isFunction(arg)) {
									if (!options.unique || !self.has(arg)) {
										list.push(arg);
									}
								} else if (arg && arg.length && toType(arg) !== "string") {
									add(arg);
								}
							});
						})(arguments);

						if (memory && !firing) {
							fire();
						}
					}
					return this;
				},
				remove: function () {
					jQuery.each(arguments, function (_, arg) {
						var index;
						while ((index = jQuery.inArray(arg, list, index)) > -1) {
							list.splice(index, 1);
							if (index <= firingIndex) {
								firingIndex--;
							}
						}
					});
					return this;
				},
				has: function (fn) {
					return fn ?
						jQuery.inArray(fn, list) > -1 :
						list.length > 0;
				},
				empty: function () {
					if (list) {
						list = [];
					}
					return this;
				},
				disable: function () {
					locked = queue = [];
					list = memory = "";
					return this;
				},
				disabled: function () {
					return !list;
				},
				lock: function () {
					locked = queue = [];
					if (!memory && !firing) {
						list = memory = "";
					}
					return this;
				},
				locked: function () {
					return !!locked;
				},
				fireWith: function (context, args) {
					if (!locked) {
						args = args || [];
						args = [context, args.slice ? args.slice() : args];
						queue.push(args);
						if (!firing) {
							fire();
						}
					}
					return this;
				},
				fire: function () {
					self.fireWith(this, arguments);
					return this;
				},
				fired: function () {
					return !!fired;
				}
			};

		return self;
	};

	return jQuery;
});
