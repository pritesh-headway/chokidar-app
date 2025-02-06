define([
	"./core",
	"./var/isFunction",
	"./var/slice",
	"./callbacks"
], function (jQuery, isFunction, slice) {

	"use strict";

	function Identity(v) {
		return v;
	}
	function Thrower(ex) {
		throw ex;
	}

	function adoptValue(value, resolve, reject, noValue) {
		var method;

		try {
			if (value && isFunction((method = value.promise))) {
				method.call(value).done(resolve).fail(reject);
			} else if (value && isFunction((method = value.then))) {
				method.call(value, resolve, reject);
			} else {
				resolve.apply(undefined, [value].slice(noValue));
			}
		} catch (value) {
			reject.apply(undefined, [value]);
		}
	}

	jQuery.extend({

		Deferred: function (func) {
			var tuples = [
				["notify", "progress", jQuery.Callbacks("memory"),
					jQuery.Callbacks("memory"), 2],
				["resolve", "done", jQuery.Callbacks("once memory"),
					jQuery.Callbacks("once memory"), 0, "resolved"],
				["reject", "fail", jQuery.Callbacks("once memory"),
					jQuery.Callbacks("once memory"), 1, "rejected"]
			],
				state = "pending",
				promise = {
					state: function () {
						return state;
					},
					always: function () {
						deferred.done(arguments).fail(arguments);
						return this;
					},
					"catch": function (fn) {
						return promise.then(null, fn);
					},
					pipe: function ( /* fnDone, fnFail, fnProgress */) {
						var fns = arguments;

						return jQuery.Deferred(function (newDefer) {
							jQuery.each(tuples, function (_i, tuple) {
								var fn = isFunction(fns[tuple[4]]) && fns[tuple[4]];
								deferred[tuple[1]](function () {
									var returned = fn && fn.apply(this, arguments);
									if (returned && isFunction(returned.promise)) {
										returned.promise()
											.progress(newDefer.notify)
											.done(newDefer.resolve)
											.fail(newDefer.reject);
									} else {
										newDefer[tuple[0] + "With"](
											this,
											fn ? [returned] : arguments
										);
									}
								});
							});
							fns = null;
						}).promise();
					},
					then: function (onFulfilled, onRejected, onProgress) {
						var maxDepth = 0;
						function resolve(depth, deferred, handler, special) {
							return function () {
								var that = this,
									args = arguments,
									mightThrow = function () {
										var returned, then;
										if (depth < maxDepth) {
											return;
										}

										returned = handler.apply(that, args);
										if (returned === deferred.promise()) {
											throw new TypeError("Thenable self-resolution");
										}
										then = returned &&
											(typeof returned === "object" ||
												typeof returned === "function") &&
											returned.then;
										if (isFunction(then)) {
											if (special) {
												then.call(
													returned,
													resolve(maxDepth, deferred, Identity, special),
													resolve(maxDepth, deferred, Thrower, special)
												);
											} else {
												maxDepth++;

												then.call(
													returned,
													resolve(maxDepth, deferred, Identity, special),
													resolve(maxDepth, deferred, Thrower, special),
													resolve(maxDepth, deferred, Identity,
														deferred.notifyWith)
												);
											}
										} else {
											if (handler !== Identity) {
												that = undefined;
												args = [returned];
											}
											(special || deferred.resolveWith)(that, args);
										}
									},
									process = special ?
										mightThrow :
										function () {
											try {
												mightThrow();
											} catch (e) {

												if (jQuery.Deferred.exceptionHook) {
													jQuery.Deferred.exceptionHook(e,
														process.stackTrace);
												}
												if (depth + 1 >= maxDepth) {
													if (handler !== Thrower) {
														that = undefined;
														args = [e];
													}

													deferred.rejectWith(that, args);
												}
											}
										};
								if (depth) {
									process();
								} else {
									if (jQuery.Deferred.getStackHook) {
										process.stackTrace = jQuery.Deferred.getStackHook();
									}
									window.setTimeout(process);
								}
							};
						}

						return jQuery.Deferred(function (newDefer) {
							tuples[0][3].add(
								resolve(
									0,
									newDefer,
									isFunction(onProgress) ?
										onProgress :
										Identity,
									newDefer.notifyWith
								)
							);
							tuples[1][3].add(
								resolve(
									0,
									newDefer,
									isFunction(onFulfilled) ?
										onFulfilled :
										Identity
								)
							);
							tuples[2][3].add(
								resolve(
									0,
									newDefer,
									isFunction(onRejected) ?
										onRejected :
										Thrower
								)
							);
						}).promise();
					},
					promise: function (obj) {
						return obj != null ? jQuery.extend(obj, promise) : promise;
					}
				},
				deferred = {};
			jQuery.each(tuples, function (i, tuple) {
				var list = tuple[2],
					stateString = tuple[5];
				promise[tuple[1]] = list.add;
				if (stateString) {
					list.add(
						function () {
							state = stateString;
						},
						tuples[3 - i][2].disable,
						tuples[3 - i][3].disable,
						tuples[0][2].lock,
						tuples[0][3].lock
					);
				}
				list.add(tuple[3].fire);
				deferred[tuple[0]] = function () {
					deferred[tuple[0] + "With"](this === deferred ? undefined : this, arguments);
					return this;
				};
				deferred[tuple[0] + "With"] = list.fireWith;
			});
			promise.promise(deferred);
			if (func) {
				func.call(deferred, deferred);
			}
			return deferred;
		},
		when: function (singleValue) {
			var
				remaining = arguments.length,
				i = remaining,
				resolveContexts = Array(i),
				resolveValues = slice.call(arguments),
				primary = jQuery.Deferred(),
				updateFunc = function (i) {
					return function (value) {
						resolveContexts[i] = this;
						resolveValues[i] = arguments.length > 1 ? slice.call(arguments) : value;
						if (!(--remaining)) {
							primary.resolveWith(resolveContexts, resolveValues);
						}
					};
				};
			if (remaining <= 1) {
				adoptValue(singleValue, primary.done(updateFunc(i)).resolve, primary.reject,
					!remaining);
				if (primary.state() === "pending" ||
					isFunction(resolveValues[i] && resolveValues[i].then)) {

					return primary.then();
				}
			}
			while (i--) {
				adoptValue(resolveValues[i], updateFunc(i), primary.reject);
			}

			return primary.promise();
		}
	});

	return jQuery;
});
