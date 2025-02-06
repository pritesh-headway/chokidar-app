/*!
 * ApexCharts v3.37.2
 * (c) 2018-2023 ApexCharts
 * Released under the MIT License.
 */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.ApexCharts = factory());
})(this, (function () { 'use strict';

  function ownKeys(object, enumerableOnly) {
    var keys = Object.keys(object);

    if (Object.getOwnPropertySymbols) {
      var symbols = Object.getOwnPropertySymbols(object);

      if (enumerableOnly) {
        symbols = symbols.filter(function (sym) {
          return Object.getOwnPropertyDescriptor(object, sym).enumerable;
        });
      }

      keys.push.apply(keys, symbols);
    }

    return keys;
  }

  function _objectSpread2(target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i] != null ? arguments[i] : {};

      if (i % 2) {
        ownKeys(Object(source), true).forEach(function (key) {
          _defineProperty(target, key, source[key]);
        });
      } else if (Object.getOwnPropertyDescriptors) {
        Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
      } else {
        ownKeys(Object(source)).forEach(function (key) {
          Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
        });
      }
    }

    return target;
  }

  function _typeof(obj) {
    "@babel/helpers - typeof";

    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
      _typeof = function (obj) {
        return typeof obj;
      };
    } else {
      _typeof = function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
      };
    }

    return _typeof(obj);
  }

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  function _defineProperty(obj, key, value) {
    if (key in obj) {
      Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
      });
    } else {
      obj[key] = value;
    }

    return obj;
  }

  function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
      throw new TypeError("Super expression must either be null or a function");
    }

    subClass.prototype = Object.create(superClass && superClass.prototype, {
      constructor: {
        value: subClass,
        writable: true,
        configurable: true
      }
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
  }

  function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
      return o.__proto__ || Object.getPrototypeOf(o);
    };
    return _getPrototypeOf(o);
  }

  function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
      o.__proto__ = p;
      return o;
    };

    return _setPrototypeOf(o, p);
  }

  function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;

    try {
      Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
      return true;
    } catch (e) {
      return false;
    }
  }

  function _assertThisInitialized(self) {
    if (self === void 0) {
      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    }

    return self;
  }

  function _possibleConstructorReturn(self, call) {
    if (call && (typeof call === "object" || typeof call === "function")) {
      return call;
    } else if (call !== void 0) {
      throw new TypeError("Derived constructors may only return object or undefined");
    }

    return _assertThisInitialized(self);
  }

  function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();

    return function _createSuperInternal() {
      var Super = _getPrototypeOf(Derived),
          result;

      if (hasNativeReflectConstruct) {
        var NewTarget = _getPrototypeOf(this).constructor;

        result = Reflect.construct(Super, arguments, NewTarget);
      } else {
        result = Super.apply(this, arguments);
      }

      return _possibleConstructorReturn(this, result);
    };
  }

  function _slicedToArray(arr, i) {
    return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
  }

  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
  }

  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }

  function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr;
  }

  function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
  }

  function _iterableToArrayLimit(arr, i) {
    var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

    if (_i == null) return;
    var _arr = [];
    var _n = true;
    var _d = false;

    var _s, _e;

    try {
      for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
        _arr.push(_s.value);

        if (i && _arr.length === i) break;
      }
    } catch (err) {
      _d = true;
      _e = err;
    } finally {
      try {
        if (!_n && _i["return"] != null) _i["return"]();
      } finally {
        if (_d) throw _e;
      }
    }

    return _arr;
  }

  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
  }

  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;

    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

    return arr2;
  }

  function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }

  function _nonIterableRest() {
    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }

  /*
   ** Generic functions which are not dependent on ApexCharts
   */
  var Utils$1 = /*#__PURE__*/function () {
    function Utils() {
      _classCallCheck(this, Utils);
    }

    _createClass(Utils, [{
      key: "shadeRGBColor",
      value: function shadeRGBColor(percent, color) {
        var f = color.split(','),
            t = percent < 0 ? 0 : 255,
            p = percent < 0 ? percent * -1 : percent,
            R = parseInt(f[0].slice(4), 10),
            G = parseInt(f[1], 10),
            B = parseInt(f[2], 10);
        return 'rgb(' + (Math.round((t - R) * p) + R) + ',' + (Math.round((t - G) * p) + G) + ',' + (Math.round((t - B) * p) + B) + ')';
      }
    }, {
      key: "shadeHexColor",
      value: function shadeHexColor(percent, color) {
        var f = parseInt(color.slice(1), 16),
            t = percent < 0 ? 0 : 255,
            p = percent < 0 ? percent * -1 : percent,
            R = f >> 16,
            G = f >> 8 & 0x00ff,
            B = f & 0x0000ff;
        return '#' + (0x1000000 + (Math.round((t - R) * p) + R) * 0x10000 + (Math.round((t - G) * p) + G) * 0x100 + (Math.round((t - B) * p) + B)).toString(16).slice(1);
      }
 }, {
      key: "addXaxisAnnotationExternal",
      value: function addXaxisAnnotationExternal(params, pushToMemory, context) {
        this.addAnnotationExternal({
          params: params,
          pushToMemory: pushToMemory,
          context: context,
          type: 'xaxis',
          contextMethod: context.addXaxisAnnotation
        });
        return context;
      }
    }, {
      key: "addYaxisAnnotationExternal",
      value: function addYaxisAnnotationExternal(params, pushToMemory, context) {
        this.addAnnotationExternal({
          params: params,
          pushToMemory: pushToMemory,
          context: context,
          type: 'yaxis',
          contextMethod: context.addYaxisAnnotation
        });
        return context;
      }
    }, {
      key: "addPointAnnotationExternal",
      value: function addPointAnnotationExternal(params, pushToMemory, context) {
        if (typeof this.invertAxis === 'undefined') {
          this.invertAxis = context.w.globals.isBarHorizontal;
        }

        this.addAnnotationExternal({
          params: params,
          pushToMemory: pushToMemory,
          context: context,
          type: 'point',
          contextMethod: context.addPointAnnotation
        });
        return context;
      }
    }, {
      key: "addAnnotationExternal",
      value: function addAnnotationExternal(_ref) {
        var params = _ref.params,
            pushToMemory = _ref.pushToMemory,
            context = _ref.context,
            type = _ref.type,
            contextMethod = _ref.contextMethod;
        var me = context;
        var w = me.w;
        var parent = w.globals.dom.baseEl.querySelector(".apexcharts-".concat(type, "-annotations"));
        var index = parent.childNodes.length + 1;
        var options = new Options();
        var axesAnno = Object.assign({}, type === 'xaxis' ? options.xAxisAnnotation : type === 'yaxis' ? options.yAxisAnnotation : options.pointAnnotation);
        var anno = Utils$1.extend(axesAnno, params);

        switch (type) {
          case 'xaxis':
            this.addXaxisAnnotation(anno, parent, index);
            break;

          case 'yaxis':
            this.addYaxisAnnotation(anno, parent, index);
            break;

          case 'point':
            this.addPointAnnotation(anno, parent, index);
            break;
        }


        var axesAnnoLabel = w.globals.dom.baseEl.querySelector(".apexcharts-".concat(type, "-annotations .apexcharts-").concat(type, "-annotation-label[rel='").concat(index, "']"));
        var elRect = this.helpers.addBackgroundToAnno(axesAnnoLabel, anno);

        if (elRect) {
          parent.insertBefore(elRect.node, axesAnnoLabel);
        }

        if (pushToMemory) {
          w.globals.memory.methodsToExec.push({
            context: me,
            id: anno.id ? anno.id : Utils$1.randomId(),
            method: contextMethod,
            label: 'addAnnotation',
            params: params
          });
        }

        return context;
      }
    }, {
      key: "clearAnnotations",
      value: function clearAnnotations(ctx) {
        var w = ctx.w;
        var annos = w.globals.dom.baseEl.querySelectorAll('.apexcharts-yaxis-annotations, .apexcharts-xaxis-annotations, .apexcharts-point-annotations');

        w.globals.memory.methodsToExec.map(function (m, i) {
          if (m.label === 'addText' || m.label === 'addAnnotation') {
            w.globals.memory.methodsToExec.splice(i, 1);
          }
        });
        annos = Utils$1.listToArray(annos);

        Array.prototype.forEach.call(annos, function (a) {
          while (a.firstChild) {
            a.removeChild(a.firstChild);
          }
        });
      }
    }, {
      key: "removeAnnotation",
      value: function removeAnnotation(ctx, id) {
        var w = ctx.w;
        var annos = w.globals.dom.baseEl.querySelectorAll(".".concat(id));

        if (annos) {
          w.globals.memory.methodsToExec.map(function (m, i) {
            if (m.id === id) {
              w.globals.memory.methodsToExec.splice(i, 1);
            }
          });
          Array.prototype.forEach.call(annos, function (a) {
            a.parentElement.removeChild(a);
          });
        }
      }
    }]);

    return Annotations;
  }();

  /**
   * DateTime Class to manipulate datetime values.
   *
   * @module DateTime
   **/

  var DateTime = /*#__PURE__*/function () {
    function DateTime(ctx) {
      _classCallCheck(this, DateTime);

      this.ctx = ctx;
      this.w = ctx.w;
      this.months31 = [1, 3, 5, 7, 8, 10, 12];
      this.months30 = [2, 4, 6, 9, 11];
      this.daysCntOfYear = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    }

    _createClass(DateTime, [{
      key: "isValidDate",
      value: function isValidDate(date) {
        return !isNaN(this.parseDate(date));
      }
    }, {
      key: "getTimeStamp",
      value: function getTimeStamp(dateStr) {
        if (!Date.parse(dateStr)) {
          return dateStr;
        }

        var utc = this.w.config.xaxis.labels.datetimeUTC;
        return !utc ? new Date(dateStr).getTime() : new Date(new Date(dateStr).toISOString().substr(0, 25)).getTime();
      }
    }, {
      key: "getDate",
      value: function getDate(timestamp) {
        var utc = this.w.config.xaxis.labels.datetimeUTC;
        return utc ? new Date(new Date(timestamp).toUTCString()) : new Date(timestamp);
      }
    }, {
      key: "parseDate",
      value: function parseDate(dateStr) {
        var parsed = Date.parse(dateStr);

        if (!isNaN(parsed)) {
          return this.getTimeStamp(dateStr);
        }

        var output = Date.parse(dateStr.replace(/-/g, '/').replace(/[a-z]+/gi, ' '));
        output = this.getTimeStamp(output);
        return output;
      }


    }, {
      key: "parseDateWithTimezone",
      value: function parseDateWithTimezone(dateStr) {
        return Date.parse(dateStr.replace(/-/g, '/').replace(/[a-z]+/gi, ' '));
      }

    }, {
      key: "formatDate",
      value: function formatDate(date, format) {
        var locale = this.w.globals.locale;
        var utc = this.w.config.xaxis.labels.datetimeUTC;
        var MMMM = ['\x00'].concat(_toConsumableArray(locale.months));
        var MMM = ['\x01'].concat(_toConsumableArray(locale.shortMonths));
        var dddd = ['\x02'].concat(_toConsumableArray(locale.days));
        var ddd = ['\x03'].concat(_toConsumableArray(locale.shortDays));

        function ii(i, len) {
          var s = i + '';
          len = len || 2;

          while (s.length < len) {
            s = '0' + s;
          }

          return s;
        }

        var y = utc ? date.getUTCFullYear() : date.getFullYear();
        format = format.replace(/(^|[^\\])yyyy+/g, '$1' + y);
        format = format.replace(/(^|[^\\])yy/g, '$1' + y.toString().substr(2, 2));
        format = format.replace(/(^|[^\\])y/g, '$1' + y);
        var M = (utc ? date.getUTCMonth() : date.getMonth()) + 1;
        format = format.replace(/(^|[^\\])MMMM+/g, '$1' + MMMM[0]);
        format = format.replace(/(^|[^\\])MMM/g, '$1' + MMM[0]);
        format = format.replace(/(^|[^\\])MM/g, '$1' + ii(M));
        format = format.replace(/(^|[^\\])M/g, '$1' + M);
        var d = utc ? date.getUTCDate() : date.getDate();
        format = format.replace(/(^|[^\\])dddd+/g, '$1' + dddd[0]);
        format = format.replace(/(^|[^\\])ddd/g, '$1' + ddd[0]);
        format = format.replace(/(^|[^\\])dd/g, '$1' + ii(d));
        format = format.replace(/(^|[^\\])d/g, '$1' + d);
        var H = utc ? date.getUTCHours() : date.getHours();
        format = format.replace(/(^|[^\\])HH+/g, '$1' + ii(H));
        format = format.replace(/(^|[^\\])H/g, '$1' + H);
        var h = H > 12 ? H - 12 : H === 0 ? 12 : H;
        format = format.replace(/(^|[^\\])hh+/g, '$1' + ii(h));
        format = format.replace(/(^|[^\\])h/g, '$1' + h);
        var m = utc ? date.getUTCMinutes() : date.getMinutes();
        format = format.replace(/(^|[^\\])mm+/g, '$1' + ii(m));
        format = format.replace(/(^|[^\\])m/g, '$1' + m);
        var s = utc ? date.getUTCSeconds() : date.getSeconds();
        format = format.replace(/(^|[^\\])ss+/g, '$1' + ii(s));
        format = format.replace(/(^|[^\\])s/g, '$1' + s);
        var f = utc ? date.getUTCMilliseconds() : date.getMilliseconds();
        format = format.replace(/(^|[^\\])fff+/g, '$1' + ii(f, 3));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])ff/g, '$1' + ii(f));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])f/g, '$1' + f);
        var T = H < 12 ? 'AM' : 'PM';
        format = format.replace(/(^|[^\\])TT+/g, '$1' + T);
        format = format.replace(/(^|[^\\])T/g, '$1' + T.charAt(0));
        var t = T.toLowerCase();
        format = format.replace(/(^|[^\\])tt+/g, '$1' + t);
        format = format.replace(/(^|[^\\])t/g, '$1' + t.charAt(0));
        var tz = -date.getTimezoneOffset();
        var K = utc || !tz ? 'Z' : tz > 0 ? '+' : '-';

        if (!utc) {
          tz = Math.abs(tz);
          var tzHrs = Math.floor(tz / 60);
          var tzMin = tz % 60;
          K += ii(tzHrs) + ':' + ii(tzMin);
        }

        format = format.replace(/(^|[^\\])K/g, '$1' + K);
        var day = (utc ? date.getUTCDay() : date.getDay()) + 1;
        format = format.replace(new RegExp(dddd[0], 'g'), dddd[day]);
        format = format.replace(new RegExp(ddd[0], 'g'), ddd[day]);
        format = format.replace(new RegExp(MMMM[0], 'g'), MMMM[M]);
        format = format.replace(new RegExp(MMM[0], 'g'), MMM[M]);
        format = format.replace(/\\(.)/g, '$1');
        return format;
      }
    }, {
      key: "getTimeUnitsfromTimestamp",
      value: function getTimeUnitsfromTimestamp(minX, maxX, utc) {
        var w = this.w;

        if (w.config.xaxis.min !== undefined) {
          minX = w.config.xaxis.min;
        }

        if (w.config.xaxis.max !== undefined) {
          maxX = w.config.xaxis.max;
        }

        var tsMin = this.getDate(minX);
        var tsMax = this.getDate(maxX);
        var minD = this.formatDate(tsMin, 'yyyy MM dd HH mm ss fff').split(' ');
        var maxD = this.formatDate(tsMax, 'yyyy MM dd HH mm ss fff').split(' ');
        return {
          minMillisecond: parseInt(minD[6], 10),
          maxMillisecond: parseInt(maxD[6], 10),
          minSecond: parseInt(minD[5], 10),
          maxSecond: parseInt(maxD[5], 10),
          minMinute: parseInt(minD[4], 10),
          maxMinute: parseInt(maxD[4], 10),
          minHour: parseInt(minD[3], 10),
          maxHour: parseInt(maxD[3], 10),
          minDate: parseInt(minD[2], 10),
          maxDate: parseInt(maxD[2], 10),
          minMonth: parseInt(minD[1], 10) - 1,
          maxMonth: parseInt(maxD[1], 10) - 1,
          minYear: parseInt(minD[0], 10),
          maxYear: parseInt(maxD[0], 10)
        };
      }
    }, {
      key: "isLeapYear",
      value: function isLeapYear(year) {
        return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
      }
    }, {
      key: "calculcateLastDaysOfMonth",
      value: function calculcateLastDaysOfMonth(month, year, subtract) {
        var days = this.determineDaysOfMonths(month, year);

        return days - subtract;
      }
    }, {
      key: "determineDaysOfYear",
      value: function determineDaysOfYear(year) {
        var days = 365;

        if (this.isLeapYear(year)) {
          days = 366;
        }

        return days;
      }
    }, {
      key: "determineRemainingDaysOfYear",
      value: function determineRemainingDaysOfYear(year, month, date) {
        var dayOfYear = this.daysCntOfYear[month] + date;
        if (month > 1 && this.isLeapYear()) dayOfYear++;
        return dayOfYear;
      }
    }, {
      key: "determineDaysOfMonths",
      value: function determineDaysOfMonths(month, year) {
        var days = 30;
        month = Utils$1.monthMod(month);

        switch (true) {
          case this.months30.indexOf(month) > -1:
            if (month === 2) {
              if (this.isLeapYear(year)) {
                days = 29;
              } else {
                days = 28;
              }
            }

            break;

          case this.months31.indexOf(month) > -1:
            days = 31;
            break;

          default:
            days = 31;
            break;
        }

        return days;
      }
    }]);

    return DateTime;
  }();

  /**
   * ApexCharts Formatter Class for setting value formatters for axes as well as tooltips.
   *
   * @module Formatters
   **/

  var Formatters = /*#__PURE__*/function () {
    function Formatters(ctx) {
      _classCallCheck(this, Formatters);

      this.ctx = ctx;
      this.w = ctx.w;
      this.tooltipKeyFormat = 'dd MMM';
    }

    _createClass(Formatters, [{
      key: "xLabelFormat",
      value: function xLabelFormat(fn, val, timestamp, opts) {
        var w = this.w;

        if (w.config.xaxis.type === 'datetime') {
          if (w.config.xaxis.labels.formatter === undefined) {

            if (w.config.tooltip.x.formatter === undefined) {
              var datetimeObj = new DateTime(this.ctx);
              return datetimeObj.formatDate(datetimeObj.getDate(val), w.config.tooltip.x.format);
            }
          }
        }

        return fn(val, timestamp, opts);
      }
    }, {
      key: "defaultGeneralFormatter",
      value: function defaultGeneralFormatter(val) {
        if (Array.isArray(val)) {
          return val.map(function (v) {
            return v;
          });
        } else {
          return val;
        }
      }
    }, {
      key: "defaultYFormatter",
      value: function defaultYFormatter(v, yaxe, i) {
        var w = this.w;

        if (Utils$1.isNumber(v)) {
          if (w.globals.yValueDecimal !== 0) {
            v = v.toFixed(yaxe.decimalsInFloat !== undefined ? yaxe.decimalsInFloat : w.globals.yValueDecimal);
          } else if (w.globals.maxYArr[i] - w.globals.minYArr[i] < 5) {
            v = v.toFixed(1);
          } else {
            v = v.toFixed(0);
          }
        }

        return v;
      }
    }, {
      key: "setLabelFormatters",
      value: function setLabelFormatters() {
        var _this = this;

        var w = this.w;

        w.globals.xaxisTooltipFormatter = function (val) {
          return _this.defaultGeneralFormatter(val);
        };

        w.globals.ttKeyFormatter = function (val) {
          return _this.defaultGeneralFormatter(val);
        };

        w.globals.ttZFormatter = function (val) {
          return val;
        };

        w.globals.legendFormatter = function (val) {
          return _this.defaultGeneralFormatter(val);
        };


        if (w.config.xaxis.labels.formatter !== undefined) {
          w.globals.xLabelFormatter = w.config.xaxis.labels.formatter;
        } else {
          w.globals.xLabelFormatter = function (val) {
            if (Utils$1.isNumber(val)) {
              if (!w.config.xaxis.convertedCatToNumeric && w.config.xaxis.type === 'numeric') {
                if (Utils$1.isNumber(w.config.xaxis.decimalsInFloat)) {
                  return val.toFixed(w.config.xaxis.decimalsInFloat);
                } else {
                  var diff = w.globals.maxX - w.globals.minX;

                  if (diff > 0 && diff < 100) {
                    return val.toFixed(1);
                  }

                  return val.toFixed(0);
                }
              }

              if (w.globals.isBarHorizontal) {
                var range = w.globals.maxY - w.globals.minYArr;

                if (range < 4) {
                  return val.toFixed(1);
                }
              }

              return val.toFixed(0);
            }

            return val;
          };
        }

        if (typeof w.config.tooltip.x.formatter === 'function') {
          w.globals.ttKeyFormatter = w.config.tooltip.x.formatter;
        } else {
          w.globals.ttKeyFormatter = w.globals.xLabelFormatter;
        }

        if (typeof w.config.xaxis.tooltip.formatter === 'function') {
          w.globals.xaxisTooltipFormatter = w.config.xaxis.tooltip.formatter;
        }

        if (Array.isArray(w.config.tooltip.y)) {
          w.globals.ttVal = w.config.tooltip.y;
        } else {
          if (w.config.tooltip.y.formatter !== undefined) {
            w.globals.ttVal = w.config.tooltip.y;
          }
        }

        if (w.config.tooltip.z.formatter !== undefined) {
          w.globals.ttZFormatter = w.config.tooltip.z.formatter;
        }


        if (w.config.legend.formatter !== undefined) {
          w.globals.legendFormatter = w.config.legend.formatter;
        }


        w.config.yaxis.forEach(function (yaxe, i) {
          if (yaxe.labels.formatter !== undefined) {
            w.globals.yLabelFormatters[i] = yaxe.labels.formatter;
          } else {
            w.globals.yLabelFormatters[i] = function (val) {
              if (!w.globals.xyCharts) return val;

              if (Array.isArray(val)) {
                return val.map(function (v) {
                  return _this.defaultYFormatter(v, yaxe, i);
                });
              } else {
                return _this.defaultYFormatter(val, yaxe, i);
              }
            };
          }
        });
        return w.globals;
      }
    }, {
      key: "heatmapLabelFormatters",
      value: function heatmapLabelFormatters() {
        var w = this.w;

        if (w.config.chart.type === 'heatmap') {
          w.globals.yAxisScale[0].result = w.globals.seriesNames.slice();

          var longest = w.globals.seriesNames.reduce(function (a, b) {
            return a.length > b.length ? a : b;
          }, 0);
          w.globals.yAxisScale[0].niceMax = longest;
          w.globals.yAxisScale[0].niceMin = longest;
        }
      }
    }]);

    return Formatters;
  }();

  /**
   * ApexCharts Default Class for setting default options for all chart types.
   *
   * @module Defaults
   **/

  var getRangeValues = function getRangeValues(_ref) {
    var _w$config$series$seri;

    var isTimeline = _ref.isTimeline,
        ctx = _ref.ctx,
        seriesIndex = _ref.seriesIndex,
        dataPointIndex = _ref.dataPointIndex,
        y1 = _ref.y1,
        y2 = _ref.y2,
        w = _ref.w;
    var start = w.globals.seriesRangeStart[seriesIndex][dataPointIndex];
    var end = w.globals.seriesRangeEnd[seriesIndex][dataPointIndex];
    var ylabel = w.globals.labels[dataPointIndex];
    var seriesName = w.config.series[seriesIndex].name ? w.config.series[seriesIndex].name : '';
    var yLbFormatter = w.globals.ttKeyFormatter;
    var yLbTitleFormatter = w.config.tooltip.y.title.formatter;
    var opts = {
      w: w,
      seriesIndex: seriesIndex,
      dataPointIndex: dataPointIndex,
      start: start,
      end: end
    };

    if (typeof yLbTitleFormatter === 'function') {
      seriesName = yLbTitleFormatter(seriesName, opts);
    }

    if ((_w$config$series$seri = w.config.series[seriesIndex].data[dataPointIndex]) !== null && _w$config$series$seri !== void 0 && _w$config$series$seri.x) {
      ylabel = w.config.series[seriesIndex].data[dataPointIndex].x;
    }

    if (!isTimeline) {
      if (w.config.xaxis.type === 'datetime') {
        var xFormat = new Formatters(ctx);
        ylabel = xFormat.xLabelFormat(w.globals.ttKeyFormatter, ylabel, ylabel, {
          i: undefined,
          dateFormatter: new DateTime(ctx).formatDate,
          w: w
        });
      }
    }

    if (typeof yLbFormatter === 'function') {
      ylabel = yLbFormatter(ylabel, opts);
    }

    if (Number.isFinite(y1) && Number.isFinite(y2)) {
      start = y1;
      end = y2;
    }

    var startVal = '';
    var endVal = '';
    var color = w.globals.colors[seriesIndex];

    if (w.config.tooltip.x.formatter === undefined) {
      if (w.config.xaxis.type === 'datetime') {
        var datetimeObj = new DateTime(ctx);
        startVal = datetimeObj.formatDate(datetimeObj.getDate(start), w.config.tooltip.x.format);
        endVal = datetimeObj.formatDate(datetimeObj.getDate(end), w.config.tooltip.x.format);
      } else {
        startVal = start;
        endVal = end;
      }
    } else {
      startVal = w.config.tooltip.x.formatter(start);
      endVal = w.config.tooltip.x.formatter(end);
    }

    return {
      start: start,
      end: end,
      startVal: startVal,
      endVal: endVal,
      ylabel: ylabel,
      color: color,
      seriesName: seriesName
    };
  };

  var buildRangeTooltipHTML = function buildRangeTooltipHTML(opts) {
    var color = opts.color,
        seriesName = opts.seriesName,
        ylabel = opts.ylabel,
        start = opts.start,
        end = opts.end,
        seriesIndex = opts.seriesIndex,
        dataPointIndex = opts.dataPointIndex;
    var formatter = opts.ctx.tooltip.tooltipLabels.getFormatters(seriesIndex);
    start = formatter.yLbFormatter(start);
    end = formatter.yLbFormatter(end);
    var val = formatter.yLbFormatter(opts.w.globals.series[seriesIndex][dataPointIndex]);
    var valueHTML = '';
    var rangeValues = "<span class=\"value start-value\">\n  ".concat(start, "\n  </span> <span class=\"separator\">-</span> <span class=\"value end-value\">\n  ").concat(end, "\n  </span>");

    if (opts.w.globals.comboCharts) {
      if (opts.w.config.series[seriesIndex].type === 'rangeArea' || opts.w.config.series[seriesIndex].type === 'rangeBar') {
        valueHTML = rangeValues;
      } else {
        valueHTML = "<span>".concat(val, "</span>");
      }
    } else {
      valueHTML = rangeValues;
    }

    return '<div class="apexcharts-tooltip-rangebar">' + '<div> <span class="series-name" style="color: ' + color + '">' + (seriesName ? seriesName : '') + '</span></div>' + '<div> <span class="category">' + ylabel + ': </span> ' + valueHTML + ' </div>' + '</div>';
  };

  var Defaults = /*#__PURE__*/function () {
    function Defaults(opts) {
      _classCallCheck(this, Defaults);

      this.opts = opts;
    }

    _createClass(Defaults, [{
      key: "line",
      value: function line() {
        return {
          chart: {
            animations: {
              easing: 'swing'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 5,
            curve: 'straight'
          },
          markers: {
            size: 0,
            hover: {
              sizeOffset: 6
            }
          },
          xaxis: {
            crosshairs: {
              width: 1
            }
          }
        };
      }
    }, {
      key: "sparkline",
      value: function sparkline(defaults) {
        this.opts.yaxis[0].show = false;
        this.opts.yaxis[0].title.text = '';
        this.opts.yaxis[0].axisBorder.show = false;
        this.opts.yaxis[0].axisTicks.show = false;
        this.opts.yaxis[0].floating = true;
        var ret = {
          grid: {
            show: false,
            padding: {
              left: 0,
              right: 0,
              top: 0,
              bottom: 0
            }
          },
          legend: {
            show: false
          },
          xaxis: {
            labels: {
              show: false
            },
            tooltip: {
              enabled: false
            },
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            }
          },
          chart: {
            toolbar: {
              show: false
            },
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          }
        };
        return Utils$1.extend(defaults, ret);
      }
    }, {
      key: "bar",
      value: function bar() {
        return {
          chart: {
            stacked: false,
            animations: {
              easing: 'swing'
            }
          },
          plotOptions: {
            bar: {
              dataLabels: {
                position: 'center'
              }
            }
          },
          dataLabels: {
            style: {
              colors: ['#fff']
            },
            background: {
              enabled: false
            }
          },
          stroke: {
            width: 0,
            lineCap: 'round'
          },
          fill: {
            opacity: 0.85
          },
          legend: {
            markers: {
              shape: 'square',
              radius: 2,
              size: 8
            }
          },
          tooltip: {
            shared: false,
            intersect: true
          },
          xaxis: {
            tooltip: {
              enabled: false
            },
            tickPlacement: 'between',
            crosshairs: {
              width: 'barWidth',
              position: 'back',
              fill: {
                type: 'gradient'
              },
              dropShadow: {
                enabled: false
              },
              stroke: {
                width: 0
              }
            }
          }
        };
      }
    }, {
      key: "candlestick",
      value: function candlestick() {
        var _this = this;

        return {
          stroke: {
            width: 1,
            colors: ['#333']
          },
          fill: {
            opacity: 1
          },
          dataLabels: {
            enabled: false
          },
          tooltip: {
            shared: true,
            custom: function custom(_ref2) {
              var seriesIndex = _ref2.seriesIndex,
                  dataPointIndex = _ref2.dataPointIndex,
                  w = _ref2.w;
              return _this._getBoxTooltip(w, seriesIndex, dataPointIndex, ['Open', 'High', '', 'Low', 'Close'], 'candlestick');
            }
          },
          states: {
            active: {
              filter: {
                type: 'none'
              }
            }
          },
          xaxis: {
            crosshairs: {
              width: 1
            }
          }
        };
      }
    }, {
      key: "boxPlot",
      value: function boxPlot() {
        var _this2 = this;

        return {
          chart: {
            animations: {
              dynamicAnimation: {
                enabled: false
              }
            }
          },
          stroke: {
            width: 1,
            colors: ['#24292e']
          },
          dataLabels: {
            enabled: false
          },
          tooltip: {
            shared: true,
            custom: function custom(_ref3) {
              var seriesIndex = _ref3.seriesIndex,
                  dataPointIndex = _ref3.dataPointIndex,
                  w = _ref3.w;
              return _this2._getBoxTooltip(w, seriesIndex, dataPointIndex, ['Minimum', 'Q1', 'Median', 'Q3', 'Maximum'], 'boxPlot');
            }
          },
          markers: {
            size: 5,
            strokeWidth: 1,
            strokeColors: '#111'
          },
          xaxis: {
            crosshairs: {
              width: 1
            }
          }
        };
      }
    }, {
      key: "rangeBar",
      value: function rangeBar() {
        var handleTimelineTooltip = function handleTimelineTooltip(opts) {
          var _getRangeValues = getRangeValues(_objectSpread2(_objectSpread2({}, opts), {}, {
            isTimeline: true
          })),
              color = _getRangeValues.color,
              seriesName = _getRangeValues.seriesName,
              ylabel = _getRangeValues.ylabel,
              startVal = _getRangeValues.startVal,
              endVal = _getRangeValues.endVal;

          return buildRangeTooltipHTML(_objectSpread2(_objectSpread2({}, opts), {}, {
            color: color,
            seriesName: seriesName,
            ylabel: ylabel,
            start: startVal,
            end: endVal
          }));
        };

        var handleRangeColumnTooltip = function handleRangeColumnTooltip(opts) {
          var _getRangeValues2 = getRangeValues(opts),
              color = _getRangeValues2.color,
              seriesName = _getRangeValues2.seriesName,
              ylabel = _getRangeValues2.ylabel,
              start = _getRangeValues2.start,
              end = _getRangeValues2.end;

          return buildRangeTooltipHTML(_objectSpread2(_objectSpread2({}, opts), {}, {
            color: color,
            seriesName: seriesName,
            ylabel: ylabel,
            start: start,
            end: end
          }));
        };

        return {
          stroke: {
            width: 0,
            lineCap: 'square'
          },
          plotOptions: {
            bar: {
              borderRadius: 0,
              dataLabels: {
                position: 'center'
              }
            }
          },
          dataLabels: {
            enabled: false,
            formatter: function formatter(val, _ref4) {
              _ref4.ctx;
                  var seriesIndex = _ref4.seriesIndex,
                  dataPointIndex = _ref4.dataPointIndex,
                  w = _ref4.w;

              var getVal = function getVal() {
                var start = w.globals.seriesRangeStart[seriesIndex][dataPointIndex];
                var end = w.globals.seriesRangeEnd[seriesIndex][dataPointIndex];
                return end - start;
              };

              if (w.globals.comboCharts) {
                if (w.config.series[seriesIndex].type === 'rangeBar' || w.config.series[seriesIndex].type === 'rangeArea') {
                  return getVal();
                } else {
                  return val;
                }
              } else {
                return getVal();
              }
            },
            background: {
              enabled: false
            },
            style: {
              colors: ['#fff']
            }
          },
          tooltip: {
            shared: false,
            followCursor: true,
            custom: function custom(opts) {
              if (opts.w.config.plotOptions && opts.w.config.plotOptions.bar && opts.w.config.plotOptions.bar.horizontal) {
                return handleTimelineTooltip(opts);
              } else {
                return handleRangeColumnTooltip(opts);
              }
            }
          },
          xaxis: {
            tickPlacement: 'between',
            tooltip: {
              enabled: false
            },
            crosshairs: {
              stroke: {
                width: 0
              }
            }
          }
        };
      }
    }, {
      key: "area",
      value: function area() {
        return {
          stroke: {
            width: 4,
            fill: {
              type: 'solid',
              gradient: {
                inverseColors: false,
                shade: 'light',
                type: 'vertical',
                opacityFrom: 0.65,
                opacityTo: 0.5,
                stops: [0, 100, 100]
              }
            }
          },
          fill: {
            type: 'gradient',
            gradient: {
              inverseColors: false,
              shade: 'light',
              type: 'vertical',
              opacityFrom: 0.65,
              opacityTo: 0.5,
              stops: [0, 100, 100]
            }
          },
          markers: {
            size: 0,
            hover: {
              sizeOffset: 6
            }
          },
          tooltip: {
            followCursor: false
          }
        };
      }
    }, {
      key: "rangeArea",
      value: function rangeArea() {
        var handleRangeAreaTooltip = function handleRangeAreaTooltip(opts) {
          var _getRangeValues3 = getRangeValues(opts),
              color = _getRangeValues3.color,
              seriesName = _getRangeValues3.seriesName,
              ylabel = _getRangeValues3.ylabel,
              start = _getRangeValues3.start,
              end = _getRangeValues3.end;

          return buildRangeTooltipHTML(_objectSpread2(_objectSpread2({}, opts), {}, {
            color: color,
            seriesName: seriesName,
            ylabel: ylabel,
            start: start,
            end: end
          }));
        };

        return {
          stroke: {
            curve: 'straight',
            width: 0
          },
          fill: {
            type: 'solid',
            opacity: 0.6
          },
          markers: {
            size: 0
          },
          states: {
            hover: {
              filter: {
                type: 'none'
              }
            },
            active: {
              filter: {
                type: 'none'
              }
            }
          },
          tooltip: {
            intersect: false,
            shared: true,
            followCursor: true,
            custom: function custom(opts) {
              return handleRangeAreaTooltip(opts);
            }
          }
        };
      }
    }, {
      key: "brush",
      value: function brush(defaults) {
        var ret = {
          chart: {
            toolbar: {
              autoSelected: 'selection',
              show: false
            },
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 1
          },
          tooltip: {
            enabled: false
          },
          xaxis: {
            tooltip: {
              enabled: false
            }
          }
        };
        return Utils$1.extend(defaults, ret);
      }
    }, {
      key: "stacked100",
      value: function stacked100(opts) {
        opts.dataLabels = opts.dataLabels || {};
        opts.dataLabels.formatter = opts.dataLabels.formatter || undefined;
        var existingDataLabelFormatter = opts.dataLabels.formatter;
        opts.yaxis.forEach(function (yaxe, index) {
          opts.yaxis[index].min = 0;
          opts.yaxis[index].max = 100;
        });
        var isBar = opts.chart.type === 'bar';

        if (isBar) {
          opts.dataLabels.formatter = existingDataLabelFormatter || function (val) {
            if (typeof val === 'number') {
              return val ? val.toFixed(0) + '%' : val;
            }

            return val;
          };
        }

        return opts;
      }
    }, {
      key: "stackedBars",
      value: function stackedBars() {
        var barDefaults = this.bar();
        return _objectSpread2(_objectSpread2({}, barDefaults), {}, {
          plotOptions: _objectSpread2(_objectSpread2({}, barDefaults.plotOptions), {}, {
            bar: _objectSpread2(_objectSpread2({}, barDefaults.plotOptions.bar), {}, {
              borderRadiusApplication: 'end',
              borderRadiusWhenStacked: 'last'
            })
          })
        });
      }

    }, {
      key: "convertCatToNumeric",
      value: function convertCatToNumeric(opts) {
        opts.xaxis.convertedCatToNumeric = true;
        return opts;
      }
    }, {
      key: "convertCatToNumericXaxis",
      value: function convertCatToNumericXaxis(opts, ctx, cats) {
        opts.xaxis.type = 'numeric';
        opts.xaxis.labels = opts.xaxis.labels || {};

        opts.xaxis.labels.formatter = opts.xaxis.labels.formatter || function (val) {
          return Utils$1.isNumber(val) ? Math.floor(val) : val;
        };

        var defaultFormatter = opts.xaxis.labels.formatter;
        var labels = opts.xaxis.categories && opts.xaxis.categories.length ? opts.xaxis.categories : opts.labels;

        if (cats && cats.length) {
          labels = cats.map(function (c) {
            return Array.isArray(c) ? c : String(c);
          });
        }

        if (labels && labels.length) {
          opts.xaxis.labels.formatter = function (val) {
            return Utils$1.isNumber(val) ? defaultFormatter(labels[Math.floor(val) - 1]) : defaultFormatter(val);
          };
        }

        opts.xaxis.categories = [];
        opts.labels = [];
        opts.xaxis.tickAmount = opts.xaxis.tickAmount || 'dataPoints';
        return opts;
      }
    }, {
      key: "bubble",
      value: function bubble() {
        return {
          dataLabels: {
            style: {
              colors: ['#fff']
            }
          },
          tooltip: {
            shared: false,
            intersect: true
          },
          xaxis: {
            crosshairs: {
              width: 0
            }
          },
          fill: {
            type: 'solid',
            gradient: {
              shade: 'light',
              inverse: true,
              shadeIntensity: 0.55,
              opacityFrom: 0.4,
              opacityTo: 0.8
            }
          }
        };
      }
    }, {
      key: "scatter",
      value: function scatter() {
        return {
          dataLabels: {
            enabled: false
          },
          tooltip: {
            shared: false,
            intersect: true
          },
          markers: {
            size: 6,
            strokeWidth: 1,
            hover: {
              sizeOffset: 2
            }
          }
        };
      }
    }, {
      key: "heatmap",
      value: function heatmap() {
        return {
          chart: {
            stacked: false
          },
          fill: {
            opacity: 1
          },
          dataLabels: {
            style: {
              colors: ['#fff']
            }
          },
          stroke: {
            colors: ['#fff']
          },
          tooltip: {
            followCursor: true,
            marker: {
              show: false
            },
            x: {
              show: false
            }
          },
          legend: {
            position: 'top',
            markers: {
              shape: 'square',
              size: 10,
              offsetY: 2
            }
          },
          grid: {
            padding: {
              right: 20
            }
          }
        };
      }
    }, {
      key: "treemap",
      value: function treemap() {
        return {
          chart: {
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            style: {
              fontSize: 14,
              fontWeight: 600,
              colors: ['#fff']
            }
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
          },
          legend: {
            show: false
          },
          fill: {
            gradient: {
              stops: [0, 100]
            }
          },
          tooltip: {
            followCursor: true,
            x: {
              show: false
            }
          },
          grid: {
            padding: {
              left: 0,
              right: 0
            }
          },
          xaxis: {
            crosshairs: {
              show: false
            },
            tooltip: {
              enabled: false
            }
          }
        };
      }
    }, {
      key: "pie",
      value: function pie() {
        return {
          chart: {
            toolbar: {
              show: false
            }
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: false
                }
              }
            }
          },
          dataLabels: {
            formatter: function formatter(val) {
              return val.toFixed(1) + '%';
            },
            style: {
              colors: ['#fff']
            },
            background: {
              enabled: false
            },
            dropShadow: {
              enabled: true
            }
          },
          stroke: {
            colors: ['#fff']
          },
          fill: {
            opacity: 1,
            gradient: {
              shade: 'light',
              stops: [0, 100]
            }
          },
          tooltip: {
            theme: 'dark',
            fillSeriesColor: true
          },
          legend: {
            position: 'right'
          }
        };
      }
    }, {
      key: "donut",
      value: function donut() {
        return {
          chart: {
            toolbar: {
              show: false
            }
          },
          dataLabels: {
            formatter: function formatter(val) {
              return val.toFixed(1) + '%';
            },
            style: {
              colors: ['#fff']
            },
            background: {
              enabled: false
            },
            dropShadow: {
              enabled: true
            }
          },
          stroke: {
            colors: ['#fff']
          },
          fill: {
            opacity: 1,
            gradient: {
              shade: 'light',
              shadeIntensity: 0.35,
              stops: [80, 100],
              opacityFrom: 1,
              opacityTo: 1
            }
          },
          tooltip: {
            theme: 'dark',
            fillSeriesColor: true
          },
          legend: {
            position: 'right'
          }
        };
      }
    }, {
      key: "polarArea",
      value: function polarArea() {
        this.opts.yaxis[0].tickAmount = this.opts.yaxis[0].tickAmount ? this.opts.yaxis[0].tickAmount : 6;
        return {
          chart: {
            toolbar: {
              show: false
            }
          },
          dataLabels: {
            formatter: function formatter(val) {
              return val.toFixed(1) + '%';
            },
            enabled: false
          },
          stroke: {
            show: true,
            width: 2
          },
          fill: {
            opacity: 0.7
          },
          tooltip: {
            theme: 'dark',
            fillSeriesColor: true
          },
          legend: {
            position: 'right'
          }
        };
      }
    }, {
      key: "radar",
      value: function radar() {
        this.opts.yaxis[0].labels.offsetY = this.opts.yaxis[0].labels.offsetY ? this.opts.yaxis[0].labels.offsetY : 6;
        return {
          dataLabels: {
            enabled: false,
            style: {
              fontSize: '11px'
            }
          },
          stroke: {
            width: 2
          },
          markers: {
            size: 3,
            strokeWidth: 1,
            strokeOpacity: 1
          },
          fill: {
            opacity: 0.2
          },
          tooltip: {
            shared: false,
            intersect: true,
            followCursor: true
          },
          grid: {
            show: false
          },
          xaxis: {
            labels: {
              formatter: function formatter(val) {
                return val;
              },
              style: {
                colors: ['#a8a8a8'],
                fontSize: '11px'
              }
            },
            tooltip: {
              enabled: false
            },
            crosshairs: {
              show: false
            }
          }
        };
      }
    }, {
      key: "radialBar",
      value: function radialBar() {
        return {
          chart: {
            animations: {
              dynamicAnimation: {
                enabled: true,
                speed: 800
              }
            },
            toolbar: {
              show: false
            }
          },
          fill: {
            gradient: {
              shade: 'dark',
              shadeIntensity: 0.4,
              inverseColors: false,
              type: 'diagonal2',
              opacityFrom: 1,
              opacityTo: 1,
              stops: [70, 98, 100]
            }
          },
          legend: {
            show: false,
            position: 'right'
          },
          tooltip: {
            enabled: false,
            fillSeriesColor: true
          }
        };
      }
    }, {
      key: "_getBoxTooltip",
      value: function _getBoxTooltip(w, seriesIndex, dataPointIndex, labels, chartType) {
        var o = w.globals.seriesCandleO[seriesIndex][dataPointIndex];
        var h = w.globals.seriesCandleH[seriesIndex][dataPointIndex];
        var m = w.globals.seriesCandleM[seriesIndex][dataPointIndex];
        var l = w.globals.seriesCandleL[seriesIndex][dataPointIndex];
        var c = w.globals.seriesCandleC[seriesIndex][dataPointIndex];

        if (w.config.series[seriesIndex].type && w.config.series[seriesIndex].type !== chartType) {
          return "<div class=\"apexcharts-custom-tooltip\">\n          ".concat(w.config.series[seriesIndex].name ? w.config.series[seriesIndex].name : 'series-' + (seriesIndex + 1), ": <strong>").concat(w.globals.series[seriesIndex][dataPointIndex], "</strong>\n        </div>");
        } else {
          return "<div class=\"apexcharts-tooltip-box apexcharts-tooltip-".concat(w.config.chart.type, "\">") + "<div>".concat(labels[0], ": <span class=\"value\">") + o + '</span></div>' + "<div>".concat(labels[1], ": <span class=\"value\">") + h + '</span></div>' + (m ? "<div>".concat(labels[2], ": <span class=\"value\">") + m + '</span></div>' : '') + "<div>".concat(labels[3], ": <span class=\"value\">") + l + '</span></div>' + "<div>".concat(labels[4], ": <span class=\"value\">") + c + '</span></div>' + '</div>';
        }
      }
    }]);

    return Defaults;
  }();

  /**
   * ApexCharts Config Class for extending user options with pre-defined ApexCharts config.
   *
   * @module Config
   **/

  var Config = /*#__PURE__*/function () {
    function Config(opts) {
      _classCallCheck(this, Config);

      this.opts = opts;
    }

    _createClass(Config, [{
      key: "init",
      value: function init(_ref) {
        var responsiveOverride = _ref.responsiveOverride;
        var opts = this.opts;
        var options = new Options();
        var defaults = new Defaults(opts);
        this.chartType = opts.chart.type;
        opts = this.extendYAxis(opts);
        opts = this.extendAnnotations(opts);
        var config = options.init();
        var newDefaults = {};

        if (opts && _typeof(opts) === 'object') {
          var chartDefaults = {};
          var chartTypes = ['line', 'area', 'bar', 'candlestick', 'boxPlot', 'rangeBar', 'rangeArea', 'bubble', 'scatter', 'heatmap', 'treemap', 'pie', 'polarArea', 'donut', 'radar', 'radialBar'];

          if (chartTypes.indexOf(opts.chart.type) !== -1) {
            chartDefaults = defaults[opts.chart.type]();
          } else {
            chartDefaults = defaults.line();
          }

          if (opts.chart.stacked && opts.chart.type === 'bar') {
            chartDefaults = defaults.stackedBars();
          }

          if (opts.chart.brush && opts.chart.brush.enabled) {
            chartDefaults = defaults.brush(chartDefaults);
          }

          if (opts.chart.stacked && opts.chart.stackType === '100%') {
            opts = defaults.stacked100(opts);
          }


          this.checkForDarkTheme(window.Apex);

          this.checkForDarkTheme(opts);

          opts.xaxis = opts.xaxis || window.Apex.xaxis || {};


          if (!responsiveOverride) {
            opts.xaxis.convertedCatToNumeric = false;
          }

          opts = this.checkForCatToNumericXAxis(this.chartType, chartDefaults, opts);

          if (opts.chart.sparkline && opts.chart.sparkline.enabled || window.Apex.chart && window.Apex.chart.sparkline && window.Apex.chart.sparkline.enabled) {
            chartDefaults = defaults.sparkline(chartDefaults);
          }

          newDefaults = Utils$1.extend(config, chartDefaults);
        }




        var mergedWithDefaultConfig = Utils$1.extend(newDefaults, window.Apex);

        config = Utils$1.extend(mergedWithDefaultConfig, opts);

        config = this.handleUserInputErrors(config);
        return config;
      }
    }, {
      key: "checkForCatToNumericXAxis",
      value: function checkForCatToNumericXAxis(chartType, chartDefaults, opts) {
        var defaults = new Defaults(opts);
        var isBarHorizontal = (chartType === 'bar' || chartType === 'boxPlot') && opts.plotOptions && opts.plotOptions.bar && opts.plotOptions.bar.horizontal;
        var unsupportedZoom = chartType === 'pie' || chartType === 'polarArea' || chartType === 'donut' || chartType === 'radar' || chartType === 'radialBar' || chartType === 'heatmap';
        var notNumericXAxis = opts.xaxis.type !== 'datetime' && opts.xaxis.type !== 'numeric';
        var tickPlacement = opts.xaxis.tickPlacement ? opts.xaxis.tickPlacement : chartDefaults.xaxis && chartDefaults.xaxis.tickPlacement;

        if (!isBarHorizontal && !unsupportedZoom && notNumericXAxis && tickPlacement !== 'between') {
          opts = defaults.convertCatToNumeric(opts);
        }

        return opts;
      }
    }, {
      key: "extendYAxis",
      value: function extendYAxis(opts, w) {
        var options = new Options();

        if (typeof opts.yaxis === 'undefined' || !opts.yaxis || Array.isArray(opts.yaxis) && opts.yaxis.length === 0) {
          opts.yaxis = {};
        }


        if (opts.yaxis.constructor !== Array && window.Apex.yaxis && window.Apex.yaxis.constructor !== Array) {
          opts.yaxis = Utils$1.extend(opts.yaxis, window.Apex.yaxis);
        }



        if (opts.yaxis.constructor !== Array) {

          opts.yaxis = [Utils$1.extend(options.yAxis, opts.yaxis)];
        } else {
          opts.yaxis = Utils$1.extendArray(opts.yaxis, options.yAxis);
        }

        var isLogY = false;
        opts.yaxis.forEach(function (y) {
          if (y.logarithmic) {
            isLogY = true;
          }
        });
        var series = opts.series;

        if (w && !series) {
          series = w.config.series;
        }



        if (isLogY && series.length !== opts.yaxis.length && series.length) {
          opts.yaxis = series.map(function (s, i) {
            if (!s.name) {
              series[i].name = "series-".concat(i + 1);
            }

            if (opts.yaxis[i]) {
              opts.yaxis[i].seriesName = series[i].name;
              return opts.yaxis[i];
            } else {
              var newYaxis = Utils$1.extend(options.yAxis, opts.yaxis[0]);
              newYaxis.show = false;
              return newYaxis;
            }
          });
        }

        if (isLogY && series.length > 1 && series.length !== opts.yaxis.length) {
          console.warn('A multi-series logarithmic chart should have equal number of series and y-axes. Please make sure to equalize both.');
        }

        return opts;
      }

    }, {
      key: "extendAnnotations",
      value: function extendAnnotations(opts) {
        if (typeof opts.annotations === 'undefined') {
          opts.annotations = {};
          opts.annotations.yaxis = [];
          opts.annotations.xaxis = [];
          opts.annotations.points = [];
        }

        opts = this.extendYAxisAnnotations(opts);
        opts = this.extendXAxisAnnotations(opts);
        opts = this.extendPointAnnotations(opts);
        return opts;
      }
    }, {
      key: "extendYAxisAnnotations",
      value: function extendYAxisAnnotations(opts) {
        var options = new Options();
        opts.annotations.yaxis = Utils$1.extendArray(typeof opts.annotations.yaxis !== 'undefined' ? opts.annotations.yaxis : [], options.yAxisAnnotation);
        return opts;
      }
    }, {
      key: "extendXAxisAnnotations",
      value: function extendXAxisAnnotations(opts) {
        var options = new Options();
        opts.annotations.xaxis = Utils$1.extendArray(typeof opts.annotations.xaxis !== 'undefined' ? opts.annotations.xaxis : [], options.xAxisAnnotation);
        return opts;
      }
    }, {
      key: "extendPointAnnotations",
      value: function extendPointAnnotations(opts) {
        var options = new Options();
        opts.annotations.points = Utils$1.extendArray(typeof opts.annotations.points !== 'undefined' ? opts.annotations.points : [], options.pointAnnotation);
        return opts;
      }
    }, {
      key: "checkForDarkTheme",
      value: function checkForDarkTheme(opts) {
        if (opts.theme && opts.theme.mode === 'dark') {
          if (!opts.tooltip) {
            opts.tooltip = {};
          }

          if (opts.tooltip.theme !== 'light') {
            opts.tooltip.theme = 'dark';
          }

          if (!opts.chart.foreColor) {
            opts.chart.foreColor = '#f6f7f8';
          }

          if (!opts.chart.background) {
            opts.chart.background = '#424242';
          }

          if (!opts.theme.palette) {
            opts.theme.palette = 'palette4';
          }
        }
      }
    }, {
      key: "handleUserInputErrors",
      value: function handleUserInputErrors(opts) {
        var config = opts;

        if (config.tooltip.shared && config.tooltip.intersect) {
          throw new Error('tooltip.shared cannot be enabled when tooltip.intersect is true. Turn off any other option by setting it to false.');
        }

        if (config.chart.type === 'bar' && config.plotOptions.bar.horizontal) {

          if (config.yaxis.length > 1) {
            throw new Error('Multiple Y Axis for bars are not supported. Switch to column chart by setting plotOptions.bar.horizontal=false');
          }


          if (config.yaxis[0].reversed) {
            config.yaxis[0].opposite = true;
          }

          config.xaxis.tooltip.enabled = false;

          config.yaxis[0].tooltip.enabled = false;

          config.chart.zoom.enabled = false;
        }

        if (config.chart.type === 'bar' || config.chart.type === 'rangeBar') {
          if (config.tooltip.shared) {
            if (config.xaxis.crosshairs.width === 'barWidth' && config.series.length > 1) {
              config.xaxis.crosshairs.width = 'tickWidth';
            }
          }
        }

        if (config.chart.type === 'candlestick' || config.chart.type === 'boxPlot') {
          if (config.yaxis[0].reversed) {
            console.warn("Reversed y-axis in ".concat(config.chart.type, " chart is not supported."));
            config.yaxis[0].reversed = false;
          }
        }

        return config;
      }
    }]);

    return Config;
  }();

  var Globals = /*#__PURE__*/function () {
    function Globals() {
      _classCallCheck(this, Globals);
    }

    _createClass(Globals, [{
      key: "initGlobalVars",
      value: function initGlobalVars(gl) {
        gl.series = [];

        gl.seriesCandleO = [];
        gl.seriesCandleH = [];
        gl.seriesCandleM = [];
        gl.seriesCandleL = [];
        gl.seriesCandleC = [];
        gl.seriesRangeStart = [];
        gl.seriesRangeEnd = [];
        gl.seriesRange = [];
        gl.seriesPercent = [];
        gl.seriesGoals = [];
        gl.seriesX = [];
        gl.seriesZ = [];
        gl.seriesNames = [];
        gl.seriesTotals = [];
        gl.seriesLog = [];
        gl.seriesColors = [];
        gl.stackedSeriesTotals = [];
        gl.seriesXvalues = [];



        gl.seriesYvalues = [];


        gl.labels = [];
        gl.hasGroups = false;
        gl.groups = [];
        gl.categoryLabels = [];
        gl.timescaleLabels = [];
        gl.noLabelsProvided = false;
        gl.resizeTimer = null;
        gl.selectionResizeTimer = null;
        gl.delayedElements = [];
        gl.pointsArray = [];
        gl.dataLabelsRects = [];
        gl.isXNumeric = false;
        gl.skipLastTimelinelabel = false;
        gl.skipFirstTimelinelabel = false;
        gl.isDataXYZ = false;
        gl.isMultiLineX = false;
        gl.isMultipleYAxis = false;
        gl.maxY = -Number.MAX_VALUE;
        gl.minY = Number.MIN_VALUE;
        gl.minYArr = [];
        gl.maxYArr = [];
        gl.maxX = -Number.MAX_VALUE;
        gl.minX = Number.MAX_VALUE;
        gl.initialMaxX = -Number.MAX_VALUE;
        gl.initialMinX = Number.MAX_VALUE;
        gl.maxDate = 0;
        gl.minDate = Number.MAX_VALUE;
        gl.minZ = Number.MAX_VALUE;
        gl.maxZ = -Number.MAX_VALUE;
        gl.minXDiff = Number.MAX_VALUE;
        gl.yAxisScale = [];
        gl.xAxisScale = null;
        gl.xAxisTicksPositions = [];
        gl.yLabelsCoords = [];
        gl.yTitleCoords = [];
        gl.barPadForNumericAxis = 0;
        gl.padHorizontal = 0;
        gl.xRange = 0;
        gl.yRange = [];
        gl.zRange = 0;
        gl.dataPoints = 0;
        gl.xTickAmount = 0;
      }
    }, {
      key: "globalVars",
      value: function globalVars(config) {
        return {
          chartID: null,

          cuid: null,

          events: {
            beforeMount: [],
            mounted: [],
            updated: [],
            clicked: [],
            selection: [],
            dataPointSelection: [],
            zoomed: [],
            scrolled: []
          },
          colors: [],
          clientX: null,
          clientY: null,
          fill: {
            colors: []
          },
          stroke: {
            colors: []
          },
          dataLabels: {
            style: {
              colors: []
            }
          },
          radarPolygons: {
            fill: {
              colors: []
            }
          },
          markers: {
            colors: [],
            size: config.markers.size,
            largestSize: 0
          },
          animationEnded: false,
          isTouchDevice: 'ontouchstart' in window || navigator.msMaxTouchPoints,
          isDirty: false,

          isExecCalled: false,

          initialConfig: null,

          initialSeries: [],
          lastXAxis: [],
          lastYAxis: [],
          columnSeries: null,
          labels: [],


          timescaleLabels: [],

          noLabelsProvided: false,

          allSeriesCollapsed: false,
          collapsedSeries: [],

          collapsedSeriesIndices: [],

          ancillaryCollapsedSeries: [],

          ancillaryCollapsedSeriesIndices: [],

          risingSeries: [],

          dataFormatXNumeric: false,

          capturedSeriesIndex: -1,
          capturedDataPointIndex: -1,
          selectedDataPoints: [],
          goldenPadding: 35,

          invalidLogScale: false,

          ignoreYAxisIndexes: [],

          yAxisSameScaleIndices: [],
          maxValsInArrayIndex: 0,
          radialSize: 0,
          selection: undefined,
          zoomEnabled: config.chart.toolbar.autoSelected === 'zoom' && config.chart.toolbar.tools.zoom && config.chart.zoom.enabled,
          panEnabled: config.chart.toolbar.autoSelected === 'pan' && config.chart.toolbar.tools.pan,
          selectionEnabled: config.chart.toolbar.autoSelected === 'selection' && config.chart.toolbar.tools.selection,
          yaxis: null,
          mousedown: false,
          lastClientPosition: {},

          visibleXRange: undefined,
          yValueDecimal: 0,

          total: 0,
          SVGNS: 'httpabels.length;

            if (w.config.xaxis.tickAmount && w.config.xaxis.labels.formatter) {
              xCount = w.config.xaxis.tickAmount;
            }
          }

          this._drawXYLines({
            xCount: xCount,
            tickAmount: yTickAmount
          });
        } else {
          xCount = yTickAmount;

          yTickAmount = w.globals.xTickAmount;

          this._drawInvertedXYLines({
            xCount: xCount,
            tickAmount: yTickAmount
          });
        }

        this.drawGridBands(xCount, yTickAmount);
        return {
          el: this.elg,
          elGridBorders: this.elGridBorders,
          xAxisTickWidth: w.globals.gridWidth / xCount
        };
      }
    }, {
      key: "drawGridBands",
      value: function drawGridBands(xCount, tickAmount) {
        var w = this.w;

        if (w.config.grid.row.colors !== undefined && w.config.grid.row.colors.length > 0) {
          var x1 = 0;
          var y1 = 0;
          var y2 = w.globals.gridHeight / tickAmount;
          var x2 = w.globals.gridWidth;

          for (var i = 0, c = 0; i < tickAmount; i++, c++) {
            if (c >= w.config.grid.row.colors.length) {
              c = 0;
            }

            this._drawGridBandRect({
              c: c,
              x1: x1,
              y1: y1,
              x2: x2,
              y2: y2,
              type: 'row'
            });

            y1 = y1 + w.globals.gridHeight / tickAmount;
          }
        }


        if (w.config.grid.column.colors !== undefined && w.config.grid.column.colors.length > 0) {
          var xc = !w.globals.isBarHorizontal && (w.config.xaxis.type === 'category' || w.config.xaxis.convertedCatToNumeric) ? xCount - 1 : xCount;
          var _x5 = w.globals.padHorizontal;
          var _y5 = 0;

          var _x6 = w.globals.padHorizontal + w.globals.gridWidth / xc;

          var _y6 = w.globals.gridHeight;

          for (var _i2 = 0, _c = 0; _i2 < xCount; _i2++, _c++) {
            if (_c >= w.config.grid.column.colors.length) {
              _c = 0;
            }

            this._drawGridBandRect({
              c: _c,
              x1: _x5,
              y1: _y5,
              x2: _x6,
              y2: _y6,
              type: 'column'
            });

            _x5 = _x5 + w.globals.gridWidth / xc;
          }
        }
      }
    }]);

    return Grid;
  }();

  var Range$1 = /*#__PURE__*/function () {
    function Range(ctx) {
      _classCallCheck(this, Range);

      this.ctx = ctx;
      this.w = ctx.w;
    }



    _createClass(Range, [{
      key: "niceScale",
      value: function niceScale(yMin, yMax) {
        var ticks = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 10;
        var index = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 0;
        var NO_MIN_MAX_PROVIDED = arguments.length > 4 ? arguments[4] : undefined;
        var w = this.w;

        var range = Math.abs(yMax - yMin);
        ticks = this._adjustTicksForSmallRange(ticks, index, range);

        if (ticks === 'dataPoints') {
          ticks = w.globals.dataPoints - 1;
        }

        if (yMin === Number.MIN_VALUE && yMax === 0 || !Utils$1.isNumber(yMin) && !Utils$1.isNumber(yMax) || yMin === Number.MIN_VALUE && yMax === -Number.MAX_VALUE) {

          yMin = 0;
          yMax = ticks;
          var linearScale = this.linearScale(yMin, yMax, ticks);
          return linearScale;
        }

        if (yMin > yMax) {


          console.warn('axis.min cannot be greater than axis.max');
          yMax = yMin + 0.1;
        } else if (yMin === yMax) {



          yMin = yMin === 0 ? 0 : yMin - 0.5;

          yMax = yMax === 0 ? 2 : yMax + 0.5;
        }




        //




        var result = [];

        if (range < 1 && NO_MIN_MAX_PROVIDED && (w.config.chart.type === 'candlestick' || w.config.series[index].type === 'candlestick' || w.config.chart.type === 'boxPlot' || w.config.series[index].type === 'boxPlot' || w.globals.isRangeData)) {
          /* fix https://github.com/apexcharts/apexcharts.js/issues/430 */
          yMax = yMax * 1.01;
        }

        var tiks = ticks + 1;

        if (tiks < 2) {
          tiks = 2;
        } else if (tiks > 2) {
          tiks -= 2;
        }


        var tempStep = range / tiks;

        var mag = Math.floor(Utils$1.log10(tempStep));
        var magPow = Math.pow(10, mag);
        var magMsd = Math.round(tempStep / magPow);

        if (magMsd < 1) {
          magMsd = 1;
        }

        var stepSize = magMsd * magPow;


        var lb = stepSize * Math.floor(yMin / stepSize);
        var ub = stepSize * Math.ceil(yMax / stepSize);

        var val = lb;

        if (NO_MIN_MAX_PROVIDED && range > 2) {
          while (1) {
            result.push(val);
            val += stepSize;

            if (val > ub) {
              break;
            }
          }

          return {
            result: result,
            niceMin: result[0],
            niceMax: result[result.length - 1]
          };
        } else {
          result = [];
          var v = yMin;
          result.push(v);
          var valuesDivider = Math.abs(yMax - yMin) / ticks;

          for (var i = 0; i <= ticks; i++) {
            v = v + valuesDivider;
            result.push(v);
          }

          if (result[result.length - 2] >= yMax) {
            result.pop();
          }

          return {
            result: result,
            niceMin: result[0],
            niceMax: result[result.length - 1]
          };
        }
      }
    }, {
      key: "linearScale",
      value: function linearScale(yMin, yMax) {
        var ticks = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 10;
        var index = arguments.length > 3 ? arguments[3] : undefined;
        var range = Math.abs(yMax - yMin);
        ticks = this._adjustTicksForSmallRange(ticks, index, range);

        if (ticks === 'dataPoints') {
          ticks = this.w.globals.dataPoints - 1;
        }

        var step = range / ticks;

        if (ticks === Number.MAX_VALUE) {
          ticks = 10;
          step = 1;
        }

        var result = [];
        var v = yMin;

        while (ticks >= 0) {
          result.push(v);
          v = v + step;
          ticks -= 1;
        }

        return {
          result: result,
          niceMin: result[0],
          niceMax: result[result.length - 1]
        };
      }
    }, {
      key: "logarithmicScaleNice",
      value: function logarithmicScaleNice(yMin, yMax, base) {

        if (yMax <= 0) yMax = Math.max(yMin, base);
        if (yMin <= 0) yMin = Math.min(yMax, base);
        var logs = [];
        var logMax = Math.ceil(Math.log(yMax) / Math.log(base) + 1);

        var logMin = Math.floor(Math.log(yMin) / Math.log(base));

        for (var i = logMin; i < logMax; i++) {
          logs.push(Math.pow(base, i));
        }

        return {
          result: logs,
          niceMin: logs[0],
          niceMax: logs[logs.length - 1]
        };
      }
    }, {
      key: "logarithmicScale",
      value: function logarithmicScale(yMin, yMax, base) {

        if (yMax <= 0) yMax = Math.max(yMin, base);
        if (yMin <= 0) yMin = Math.min(yMax, base);
        var logs = [];

        var logMax = Math.log(yMax) / Math.log(base);
        var logMin = Math.log(yMin) / Math.log(base);


        var logRange = logMax - logMin;



        var ticks = Math.round(logRange);

        var logTickSpacing = logRange / ticks;

        for (var i = 0, logTick = logMin; i < ticks; i++, logTick += logTickSpacing) {
          logs.push(Math.pow(base, logTick));
        }


        logs.push(Math.pow(base, logMax));
        return {
          result: logs,
          niceMin: yMin,
          niceMax: yMax
        };
      }
    }, {
      key: "_adjustTicksForSmallRange",
      value: function _adjustTicksForSmallRange(ticks, index, range) {
        var newTicks = ticks;

        if (typeof index !== 'undefined' && this.w.config.yaxis[index].labels.formatter && this.w.config.yaxis[index].tickAmount === undefined) {
          var formattedVal = Number(this.w.config.yaxis[index].labels.formatter(1));

          if (Utils$1.isNumber(formattedVal) && this.w.globals.yValueDecimal === 0) {
            newTicks = Math.ceil(range);
          }
        }

        return newTicks < ticks ? newTicks : ticks;
      }
    }, {
      key: "setYScaleForIndex",
      value: function setYScaleForIndex(index, minY, maxY) {
        var gl = this.w.globals;
        var cnf = this.w.config;
        var y = gl.isBarHorizontal ? cnf.xaxis : cnf.yaxis[index];

        if (typeof gl.yAxisScale[index] === 'undefined') {
          gl.yAxisScale[index] = [];
        }

        var diff = Math.abs(maxY - minY);

        if (y.logarithmic && diff <= 5) {
          gl.invalidLogScale = true;
        }

        if (y.logarithmic && diff > 5) {
          gl.allSeriesCollapsed = false;
          gl.yAxisScale[index] = this.logarithmicScale(minY, maxY, y.logBase);
          gl.yAxisScale[index] = y.forceNiceScale ? this.logarithmicScaleNice(minY, maxY, y.logBase) : this.logarithmicScale(minY, maxY, y.logBase);
        } else {
          if (maxY === -Number.MAX_VALUE || !Utils$1.isNumber(maxY)) {

            gl.yAxisScale[index] = this.linearScale(0, 5, 5);
          } else {

            gl.allSeriesCollapsed = false;

            if ((y.min !== undefined || y.max !== undefined) && !y.forceNiceScale) {

              gl.yAxisScale[index] = this.linearScale(minY, maxY, y.tickAmount, index);
            } else {
              var noMinMaxProvided = cnf.yaxis[index].max === undefined && cnf.yaxis[index].min === undefined || cnf.yaxis[index].forceNiceScale;
              gl.yAxisScale[index] = this.niceScale(minY, maxY, y.tickAmount ? y.tickAmount : diff < 5 && diff > 1 ? diff + 1 : 5, index,
              noMinMaxProvided);
            }
          }
        }
      }
    }, {
      key: "setXScale",
      value: function setXScale(minX, maxX) {
        var w = this.w;
        var gl = w.globals;
        var x = w.config.xaxis;
        var diff = Math.abs(maxX - minX);

        if (maxX === -Number.MAX_VALUE || !Utils$1.isNumber(maxX)) {

          gl.xAxisScale = this.linearScale(0, 5, 5);
        } else {
          gl.xAxisScale = this.linearScale(minX, maxX, x.tickAmount ? x.tickAmount : diff < 5 && diff > 1 ? diff + 1 : 5, 0);
        }

        return gl.xAxisScale;
      }
    }, {
      key: "setMultipleYScales",
      value: function setMultipleYScales() {
        var _this = this;

        var gl = this.w.globals;
        var cnf = this.w.config;
        var minYArr = gl.minYArr.concat([]);
        var maxYArr = gl.maxYArr.concat([]);
        var scalesIndices = [];

        cnf.yaxis.forEach(function (yaxe, i) {
          var index = i;
          cnf.series.forEach(function (s, si) {



            if (s.name === yaxe.seriesName) {
              index = si;

              if (i !== si) {
                scalesIndices.push({
                  index: si,
                  similarIndex: i,
                  alreadyExists: true
                });
              } else {
                scalesIndices.push({
                  index: si
                });
              }
            }
          });
          var minY = minYArr[index];
          var maxY = maxYArr[index];

          _this.setYScaleForIndex(i, minY, maxY);
        });
        this.sameScaleInMultipleAxes(minYArr, maxYArr, scalesIndices);
      }
    }, {
      key: "sameScaleInMultipleAxes",
      value: function sameScaleInMultipleAxes(minYArr, maxYArr, scalesIndices) {
        var _this2 = this;

        var cnf = this.w.config;
        var gl = this.w.globals;

        var similarIndices = [];
        scalesIndices.forEach(function (scale) {
          if (scale.alreadyExists) {
            if (typeof similarIndices[scale.index] === 'undefined') {
              similarIndices[scale.index] = [];
            }

            similarIndices[scale.index].push(scale.index);
            similarIndices[scale.index].push(scale.similarIndex);
          }
        });

        function intersect(a, b) {
          return a.filter(function (value) {
            return b.indexOf(value) !== -1;
          });
        }

        gl.yAxisSameScaleIndices = similarIndices;
        similarIndices.forEach(function (si, i) {
          similarIndices.forEach(function (sj, j) {
            if (i !== j) {
              if (intersect(si, sj).length > 0) {
                similarIndices[i] = similarIndices[i].concat(similarIndices[j]);
              }
            }
          });
        });

        var uniqueSimilarIndices = similarIndices.map(function (item) {
          return item.filter(function (i, pos) {
            return item.indexOf(i) === pos;
          });
        });

        var sortedIndices = uniqueSimilarIndices.map(function (s) {
          return s.sort();
        });

        similarIndices = similarIndices.filter(function (s) {
          return !!s;
        });
        var indices = sortedIndices.slice();
        var stringIndices = indices.map(function (ind) {
          return JSON.stringify(ind);
        });
        indices = indices.filter(function (ind, p) {
          return stringIndices.indexOf(JSON.stringify(ind)) === p;
        });
        var sameScaleMinYArr = [];
        var sameScaleMaxYArr = [];
        minYArr.forEach(function (minYValue, yi) {
          indices.forEach(function (scale, i) {

            if (scale.indexOf(yi) > -1) {
              if (typeof sameScaleMinYArr[i] === 'undefined') {
                sameScaleMinYArr[i] = [];
                sameScaleMaxYArr[i] = [];
              }

              sameScaleMinYArr[i].push({
                key: yi,
                value: minYValue
              });
              sameScaleMaxYArr[i].push({
                key: yi,
                value: maxYArr[yi]
              });
            }
          });
        });
        var sameScaleMin = Array.apply(null, Array(indices.length)).map(Number.prototype.valueOf, Number.MIN_VALUE);
        var sameScaleMax = Array.apply(null, Array(indices.length)).map(Number.prototype.valueOf, -Number.MAX_VALUE);
        sameScaleMinYArr.forEach(function (s, i) {
          s.forEach(function (sc, j) {
            sameScaleMin[i] = Math.min(sc.value, sameScaleMin[i]);
          });
        });
        sameScaleMaxYArr.forEach(function (s, i) {
          s.forEach(function (sc, j) {
            sameScaleMax[i] = Math.max(sc.value, sameScaleMax[i]);
          });
        });
        minYArr.forEach(function (min, i) {
          sameScaleMaxYArr.forEach(function (s, si) {
            var minY = sameScaleMin[si];
            var maxY = sameScaleMax[si];

            if (cnf.chart.stacked) {

              maxY = 0;
              s.forEach(function (ind, k) {

                if (ind.value !== -Number.MAX_VALUE) {
                  maxY += ind.value;
                }

                if (minY !== Number.MIN_VALUE) {
                  minY += sameScaleMinYArr[si][k].value;
                }
              });
            }

            s.forEach(function (ind, k) {
              if (s[k].key === i) {
                if (cnf.yaxis[i].min !== undefined) {
                  if (typeof cnf.yaxis[i].min === 'function') {
                    minY = cnf.yaxis[i].min(gl.minY);
                  } else {
                    minY = cnf.yaxis[i].min;
                  }
                }

                if (cnf.yaxis[i].max !== undefined) {
                  if (typeof cnf.yaxis[i].max === 'function') {
                    maxY = cnf.yaxis[i].max(gl.maxY);
                  } else {
                    maxY = cnf.yaxis[i].max;
                  }
                }

                _this2.setYScaleForIndex(i, minY, maxY);
              }
            });
          });
        });
      }

    }, {
      key: "autoScaleY",
      value: function autoScaleY(ctx, yaxis, e) {
        if (!ctx) {
          ctx = this;
        }

        var w = ctx.w;

        if (w.globals.isMultipleYAxis || w.globals.collapsedSeries.length) {


          console.warn('autoScaleYaxis is not supported in a multi-yaxis chart.');
          return yaxis;
        }

        var seriesX = w.globals.seriesX[0];
        var isStacked = w.config.chart.stacked;
        yaxis.forEach(function (yaxe, yi) {
          var firstXIndex = 0;

          for (var xi = 0; xi < seriesX.length; xi++) {
            if (seriesX[xi] >= e.xaxis.min) {
              firstXIndex = xi;
              break;
            }
          }

          var initialMin = w.globals.minYArr[yi];
          var initialMax = w.globals.maxYArr[yi];
          var min, max;
          var stackedSer = w.globals.stackedSeriesTotals;
          w.globals.series.forEach(function (serie, sI) {
            var firstValue = serie[firstXIndex];

            if (isStacked) {
              firstValue = stackedSer[firstXIndex];
              min = max = firstValue;
              stackedSer.forEach(function (y, yI) {
                if (seriesX[yI] <= e.xaxis.max && seriesX[yI] >= e.xaxis.min) {
                  if (y > max && y !== null) max = y;
                  if (serie[yI] < min && serie[yI] !== null) min = serie[yI];
                }
              });
            } else {
              min = max = firstValue;
              serie.forEach(function (y, yI) {
                if (seriesX[yI] <= e.xaxis.max && seriesX[yI] >= e.xaxis.min) {
                  var valMin = y;
                  var valMax = y;
                  w.globals.series.forEach(function (wS, wSI) {
                    if (y !== null) {
                      valMin = Math.min(wS[yI], valMin);
                      valMax = Math.max(wS[yI], valMax);
                    }
                  });
                  if (valMax > max && valMax !== null) max = valMax;
                  if (valMin < min && valMin !== null) min = valMin;
                }
              });
            }

            if (min === undefined && max === undefined) {
              min = initialMin;
              max = initialMax;
            }

            min *= min < 0 ? 1.1 : 0.9;
            max *= max < 0 ? 0.9 : 1.1;

            if (min === 0 && max === 0) {
              min = -1;
              max = 1;
            }

            if (max < 0 && max < initialMax) {
              max = initialMax;
            }

            if (min < 0 && min > initialMin) {
              min = initialMin;
            }

            if (yaxis.length > 1) {
              yaxis[sI].min = yaxe.min === undefined ? min : yaxe.min;
              yaxis[sI].max = yaxe.max === undefined ? max : yaxe.max;
            } else {
              yaxis[0].min = yaxe.min === undefined ? min : yaxe.min;
              yaxis[0].max = yaxe.max === undefined ? max : yaxe.max;
            }
          });
        });
        return yaxis;
      }
    }]);

    return Range;
  }();

  /**
   * Range is used to generates values between min and max.
   *
   * @module Range
   **/

  var Range = /*#__PURE__*/function () {
    function Range(ctx) {
      _classCallCheck(this, Range);

      this.ctx = ctx;
      this.w = ctx.w;
      this.scales = new Range$1(ctx);
    }

    _createClass(Range, [{
      key: "init",
      value: function init() {
        this.setYRange();
        this.setXRange();
        this.setZRange();
      }
    }, {
      key: "getMinYMaxY",
      value: function getMinYMaxY(startingIndex) {
        var lowestY = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : Number.MAX_VALUE;
        var highestY = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : -Number.MAX_VALUE;
        var len = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
        var cnf = this.w.config;
        var gl = this.w.globals;
        var maxY = -Number.MAX_VALUE;
        var minY = Number.MIN_VALUE;

        if (len === null) {
          len = startingIndex + 1;
        }

        var series = gl.series;
        var seriesMin = series;
        var seriesMax = series;

        if (cnf.chart.type === 'candlestick') {
          seriesMin = gl.seriesCandleL;
          seriesMax = gl.seriesCandleH;
        } else if (cnf.chart.type === 'boxPlot') {
          seriesMin = gl.seriesCandleO;
          seriesMax = gl.seriesCandleC;
        } else if (gl.isRangeData) {
          seriesMin = gl.seriesRangeStart;
          seriesMax = gl.seriesRangeEnd;
        }

        for (var i = startingIndex; i < len; i++) {
          gl.dataPoints = Math.max(gl.dataPoints, series[i].length);

          if (gl.categoryLabels.length) {
            gl.dataPoints = gl.categoryLabels.filter(function (label) {
              return typeof label !== 'undefined';
            }).length;
          }

          for (var j = 0; j < gl.series[i].length; j++) {
            var val = series[i][j];

            if (val !== null && Utils$1.isNumber(val)) {
              if (typeof seriesMax[i][j] !== 'undefined') {
                maxY = Math.max(maxY, seriesMax[i][j]);
                lowestY = Math.min(lowestY, seriesMax[i][j]);
              }

              if (typeof seriesMin[i][j] !== 'undefined') {
                lowestY = Math.min(lowestY, seriesMin[i][j]);
                highestY = Math.max(highestY, seriesMin[i][j]);
              }

              if (this.w.config.chart.type === 'candlestick' || this.w.config.chart.type === 'boxPlot' || this.w.config.chart.type !== 'rangeArea' || this.w.config.chart.type !== 'rangeBar') {
                if (this.w.config.chart.type === 'candlestick' || this.w.config.chart.type === 'boxPlot') {
                  if (typeof gl.seriesCandleC[i][j] !== 'undefined') {
                    maxY = Math.max(maxY, gl.seriesCandleO[i][j]);
                    maxY = Math.max(maxY, gl.seriesCandleH[i][j]);
                    maxY = Math.max(maxY, gl.seriesCandleL[i][j]);
                    maxY = Math.max(maxY, gl.seriesCandleC[i][j]);

                    if (this.w.config.chart.type === 'boxPlot') {
                      maxY = Math.max(maxY, gl.seriesCandleM[i][j]);
                    }
                  }
                }


                if (cnf.series[i].type && (cnf.series[i].type !== 'candlestick' || cnf.series[i].type !== 'boxPlot' || cnf.series[i].type !== 'rangeArea' || cnf.series[i].type !== 'rangeBar')) {
                  maxY = Math.max(maxY, gl.series[i][j]);
                  lowestY = Math.min(lowestY, gl.series[i][j]);
                }

                highestY = maxY;
              }

              if (gl.seriesGoals[i] && gl.seriesGoals[i][j] && Array.isArray(gl.seriesGoals[i][j])) {
                gl.seriesGoals[i][j].forEach(function (g) {
                  if (minY !== Number.MIN_VALUE) {
                    minY = Math.min(minY, g.value);
                    lowestY = minY;
                  }

                  maxY = Math.max(maxY, g.value);
                  highestY = maxY;
                });
              }

              if (Utils$1.isFloat(val)) {
                val = Utils$1.noExponents(val);
                gl.yValueDecimal = Math.max(gl.yValueDecimal, val.toString().split('.')[1].length);
              }

              if (minY > seriesMin[i][j] && seriesMin[i][j] < 0) {
                minY = seriesMin[i][j];
              }
            } else {
              gl.hasNullValues = true;
            }
          }
        }

        if (cnf.chart.type === 'rangeBar' && gl.seriesRangeStart.length && gl.isBarHorizontal) {
          minY = lowestY;
        }

        if (cnf.chart.type === 'bar') {
          if (minY < 0 && maxY < 0) {

            maxY = 0;
          }

          if (minY === Number.MIN_VALUE) {
            minY = 0;
          }
        }

        return {
          minY: minY,
          maxY: maxY,
          lowestY: lowestY,
          highestY: highestY
        };
      }
    }, {
      key: "setYRange",
      value: function setYRange() {
        var gl = this.w.globals;
        var cnf = this.w.config;
        gl.maxY = -Number.MAX_VALUE;
        gl.minY = Number.MIN_VALUE;
        var lowestYInAllSeries = Number.MAX_VALUE;

        if (gl.isMultipleYAxis) {

          for (var i = 0; i < gl.series.length; i++) {
            var minYMaxYArr = this.getMinYMaxY(i, lowestYInAllSeries, null, i + 1);
            gl.minYArr.push(minYMaxYArr.minY);
            gl.maxYArr.push(minYMaxYArr.maxY);
            lowestYInAllSeries = minYMaxYArr.lowestY;
          }
        }


        var minYMaxY = this.getMinYMaxY(0, lowestYInAllSeries, null, gl.series.length);
        gl.minY = minYMaxY.minY;
        gl.maxY = minYMaxY.maxY;
        lowestYInAllSeries = minYMaxY.lowestY;

        if (cnf.chart.stacked) {
          this._setStackedMinMax();
        }



        if (cnf.chart.type === 'line' || cnf.chart.type === 'area' || cnf.chart.type === 'candlestick' || cnf.chart.type === 'boxPlot' || cnf.chart.type === 'rangeBar' && !gl.isBarHorizontal) {
          if (gl.minY === Number.MIN_VALUE && lowestYInAllSeries !== -Number.MAX_VALUE && lowestYInAllSeries !== gl.maxY
          ) {
            var diff = gl.maxY - lowestYInAllSeries;

            if (lowestYInAllSeries >= 0 && lowestYInAllSeries <= 10 || cnf.yaxis[0].min !== undefined || cnf.yaxis[0].max !== undefined) {

              diff = 0;
            }

            gl.minY = lowestYInAllSeries - diff * 5 / 100;
            /* fix https://github.com/apexcharts/apexcharts.js/issues/614 */

            /* fix https://github.com/apexcharts/apexcharts.js/issues/968 */

            if (lowestYInAllSeries > 0 && gl.minY < 0) {
              gl.minY = 0;
            }
            /* fix https://github.com/apexcharts/apexcharts.js/issues/426 */


            gl.maxY = gl.maxY + diff * 5 / 100;
          }
        }

        cnf.yaxis.forEach(function (yaxe, index) {

          if (yaxe.max !== undefined) {
            if (typeof yaxe.max === 'number') {
              gl.maxYArr[index] = yaxe.max;
            } else if (typeof yaxe.max === 'function') {

              gl.maxYArr[index] = yaxe.max(gl.isMultipleYAxis ? gl.maxYArr[index] : gl.maxY);
            }


            gl.maxY = gl.maxYArr[index];
          }

          if (yaxe.min !== undefined) {
            if (typeof yaxe.min === 'number') {
              gl.minYArr[index] = yaxe.min;
            } else if (typeof yaxe.min === 'function') {

              gl.minYArr[index] = yaxe.min(gl.isMultipleYAxis ? gl.minYArr[index] === Number.MIN_VALUE ? 0 : gl.minYArr[index] : gl.minY);
            }


            gl.minY = gl.minYArr[index];
          }
        });

        if (gl.isBarHorizontal) {
          var minmax = ['min', 'max'];
          minmax.forEach(function (m) {
            if (cnf.xaxis[m] !== undefined && typeof cnf.xaxis[m] === 'number') {
              m === 'min' ? gl.minY = cnf.xaxis[m] : gl.maxY = cnf.xaxis[m];
            }
          });
        }


        if (gl.isMultipleYAxis) {
          this.scales.setMultipleYScales();
          gl.minY = lowestYInAllSeries;
          gl.yAxisScale.forEach(function (scale, i) {
            gl.minYArr[i] = scale.niceMin;
            gl.maxYArr[i] = scale.niceMax;
          });
        } else {
          this.scales.setYScaleForIndex(0, gl.minY, gl.maxY);
          gl.minY = gl.yAxisScale[0].niceMin;
          gl.maxY = gl.yAxisScale[0].niceMax;
          gl.minYArr[0] = gl.yAxisScale[0].niceMin;
          gl.maxYArr[0] = gl.yAxisScale[0].niceMax;
        }

        return {
          minY: gl.minY,
          maxY: gl.maxY,
          minYArr: gl.minYArr,
          maxYArr: gl.maxYArr,
          yAxisScale: gl.yAxisScale
        };
      }
    }, {
      key: "setXRange",
      value: function setXRange() {
        var gl = this.w.globals;
        var cnf = this.w.config;
        var isXNumeric = cnf.xaxis.type === 'numeric' || cnf.xaxis.type === 'datetime' || cnf.xaxis.type === 'category' && !gl.noLabelsProvided || gl.noLabelsProvided || gl.isXNumeric;

        var getInitialMinXMaxX = function getInitialMinXMaxX() {
          for (var i = 0; i < gl.series.length; i++) {
            if (gl.labels[i]) {
              for (var j = 0; j < gl.labels[i].length; j++) {
                if (gl.labels[i][j] !== null && Utils$1.isNumber(gl.labels[i][j])) {
                  gl.maxX = Math.max(gl.maxX, gl.labels[i][j]);
                  gl.initialMaxX = Math.max(gl.maxX, gl.labels[i][j]);
                  gl.minX = Math.min(gl.minX, gl.labels[i][j]);
                  gl.initialMinX = Math.min(gl.minX, gl.labels[i][j]);
                }
              }
            }
          }
        };


        if (gl.isXNumeric) {
          getInitialMinXMaxX();
        }

        if (gl.noLabelsProvided) {
          if (cnf.xaxis.categories.length === 0) {
            gl.maxX = gl.labels[gl.labels.length - 1];
            gl.initialMaxX = gl.labels[gl.labels.length - 1];
            gl.minX = 1;
            gl.initialMinX = 1;
          }
        }

        if (gl.isXNumeric || gl.noLabelsProvided || gl.dataFormatXNumeric) {
          var ticks;

          if (cnf.xaxis.tickAmount === undefined) {
            ticks = Math.round(gl.svgWidth / 150);

            if (cnf.xaxis.type === 'numeric' && gl.dataPoints < 30) {
              ticks = gl.dataPoints - 1;
            }


            if (ticks > gl.dataPoints && gl.dataPoints !== 0) {
              ticks = gl.dataPoints - 1;
            }
          } else if (cnf.xaxis.tickAmount === 'dataPoints') {
            if (gl.series.length > 1) {
              ticks = gl.series[gl.maxValsInArrayIndex].length - 1;
            }

            if (gl.isXNumeric) {
              ticks = gl.maxX - gl.minX - 1;
            }
          } else {
            ticks = cnf.xaxis.tickAmount;
          }

          gl.xTickAmount = ticks;

          if (cnf.xaxis.max !== undefined && typeof cnf.xaxis.max === 'number') {
            gl.maxX = cnf.xaxis.max;
          }

          if (cnf.xaxis.min !== undefined && typeof cnf.xaxis.min === 'number') {
            gl.minX = cnf.xaxis.min;
          }


          if (cnf.xaxis.range !== undefined) {
            gl.minX = gl.maxX - cnf.xaxis.range;
          }

          if (gl.minX !== Number.MAX_VALUE && gl.maxX !== -Number.MAX_VALUE) {
            if (cnf.xaxis.convertedCatToNumeric && !gl.dataFormatXNumeric) {
              var catScale = [];

              for (var i = gl.minX - 1; i < gl.maxX; i++) {
                catScale.push(i + 1);
              }

              gl.xAxisScale = {
                result: catScale,
                niceMin: catScale[0],
                niceMax: catScale[catScale.length - 1]
              };
            } else {
              gl.xAxisScale = this.scales.setXScale(gl.minX, gl.maxX);
            }
          } else {
            gl.xAxisScale = this.scales.linearScale(1, ticks, ticks);

            if (gl.noLabelsProvided && gl.labels.length > 0) {
              gl.xAxisScale = this.scales.linearScale(1, gl.labels.length, ticks - 1);

              gl.seriesX = gl.labels.slice();
            }
          }


          if (isXNumeric) {
            gl.labels = gl.xAxisScale.result.slice();
          }
        }

        if (gl.isBarHorizontal && gl.labels.length) {
          gl.xTickAmount = gl.labels.length;
        }


        this._handleSingleDataPoint();


        this._getMinXDiff();

        return {
          minX: gl.minX,
          maxX: gl.maxX
        };
      }
    }, {
      key: "setZRange",
      value: function setZRange() {

        var gl = this.w.globals;
        if (!gl.isDataXYZ) return;

        for (var i = 0; i < gl.series.length; i++) {
          if (typeof gl.seriesZ[i] !== 'undefined') {
            for (var j = 0; j < gl.seriesZ[i].length; j++) {
              if (gl.seriesZ[i][j] !== null && Utils$1.isNumber(gl.seriesZ[i][j])) {
                gl.maxZ = Math.max(gl.maxZ, gl.seriesZ[i][j]);
                gl.minZ = Math.min(gl.minZ, gl.seriesZ[i][j]);
              }
            }
          }
        }
      }
    }, {
      key: "_handleSingleDataPoint",
      value: function _handleSingleDataPoint() {
        var gl = this.w.globals;
        var cnf = this.w.config;

        if (gl.minX === gl.maxX) {
          var datetimeObj = new DateTime(this.ctx);

          if (cnf.xaxis.type === 'datetime') {
            var newMinX = datetimeObj.getDate(gl.minX);

            if (cnf.xaxis.labels.datetimeUTC) {
              newMinX.setUTCDate(newMinX.getUTCDate() - 2);
            } else {
              newMinX.setDate(newMinX.getDate() - 2);
            }

            gl.minX = new Date(newMinX).getTime();
            var newMaxX = datetimeObj.getDate(gl.maxX);

            if (cnf.xaxis.labels.datetimeUTC) {
              newMaxX.setUTCDate(newMaxX.getUTCDate() + 2);
            } else {
              newMaxX.setDate(newMaxX.getDate() + 2);
            }

            gl.maxX = new Date(newMaxX).getTime();
          } else if (cnf.xaxis.type === 'numeric' || cnf.xaxis.type === 'category' && !gl.noLabelsProvided) {
            gl.minX = gl.minX - 2;
            gl.initialMinX = gl.minX;
            gl.maxX = gl.maxX + 2;
            gl.initialMaxX = gl.maxX;
          }
        }
      }
    }, {
      key: "_getMinXDiff",
      value: function _getMinXDiff() {
        var gl = this.w.globals;

        if (gl.isXNumeric) {

          gl.seriesX.forEach(function (sX, i) {
            if (sX.length === 1) {


              sX.push(gl.seriesX[gl.maxValsInArrayIndex][gl.seriesX[gl.maxValsInArrayIndex].length - 1]);
            }


            var seriesX = sX.slice();
            seriesX.sort(function (a, b) {
              return a - b;
            });
            seriesX.forEach(function (s, j) {
              if (j > 0) {
                var xDiff = s - seriesX[j - 1];

                if (xDiff > 0) {
                  gl.minXDiff = Math.min(xDiff, gl.minXDiff);
                }
              }
            });

            if (gl.dataPoints === 1 || gl.minXDiff === Number.MAX_VALUE) {

              gl.minXDiff = 0.5;
            }
          });
        }
      }
    }, {
      key: "_setStackedMinMax",
      value: function _setStackedMinMax() {
        var gl = this.w.globals;

        var stackedPoss = [];
        var stackedNegs = [];

        if (gl.series.length) {
          for (var j = 0; j < gl.series[gl.maxValsInArrayIndex].length; j++) {
            var poss = 0;
            var negs = 0;

            for (var i = 0; i < gl.series.length; i++) {
              if (gl.series[i][j] !== null && Utils$1.isNumber(gl.series[i][j])) {

                gl.series[i][j] > 0 ? poss = poss + parseFloat(gl.series[i][j]) + 0.0001 : negs = negs + parseFloat(gl.series[i][j]);
              }

              if (i === gl.series.length - 1) {

                stackedPoss.push(poss);
                stackedNegs.push(negs);
              }
            }
          }
        }


        for (var z = 0; z < stackedPoss.length; z++) {
          gl.maxY = Math.max(gl.maxY, stackedPoss[z]);
          gl.minY = Math.min(gl.minY, stackedNegs[z]);
        }
      }
    }]);

    return Range;
  }();

  /**
   * ApexCharts YAxis Class for drawing Y-Axis.
   *
   * @module YAxis
   **/

  var YAxis = /*#__PURE__*/function () {
    function YAxis(ctx, elgrid) {
      _classCallCheck(this, YAxis);

      this.ctx = ctx;
      this.elgrid = elgrid;
      this.w = ctx.w;
      var w = this.w;
      this.xaxisFontSize = w.config.xaxis.labels.style.fontSize;
      this.axisFontFamily = w.config.xaxis.labels.style.fontFamily;
      this.xaxisForeColors = w.config.xaxis.labels.style.colors;
      this.isCategoryBarHorizontal = w.config.chart.type === 'bar' && w.config.plotOptions.bar.horizontal;
      this.xAxisoffX = 0;

      if (w.config.xaxis.position === 'bottom') {
        this.xAxisoffX = w.globals.gridHeight;
      }

      this.drawnLabels = [];
      this.axesUtils = new AxesUtils(ctx);
    }

    _createClass(YAxis, [{
      key: "drawYaxis",
      value: function drawYaxis(realIndex) {
        var _this = this;

        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var yaxisStyle = w.config.yaxis[realIndex].labels.style;
        var yaxisFontSize = yaxisStyle.fontSize;
        var yaxisFontFamily = yaxisStyle.fontFamily;
        var yaxisFontWeight = yaxisStyle.fontWeight;
        var elYaxis = graphics.group({
          class: 'apexcharts-yaxis',
          rel: realIndex,
          transform: 'translate(' + w.globals.translateYAxisX[realIndex] + ', 0)'
        });

        if (this.axesUtils.isYAxisHidden(realIndex)) {
          return elYaxis;
        }

        var elYaxisTexts = graphics.group({
          class: 'apexcharts-yaxis-texts-g'
        });
        elYaxis.add(elYaxisTexts);
        var tickAmount = w.globals.yAxisScale[realIndex].result.length - 1;

        var labelsDivider = w.globals.gridHeight / tickAmount;

        var l = w.globals.translateY;
        var lbFormatter = w.globals.yLabelFormatters[realIndex];
        var labels = w.globals.yAxisScale[realIndex].result.slice();
        labels = this.axesUtils.checkForReversedLabels(realIndex, labels);
        var firstLabel = '';

        if (w.config.yaxis[realIndex].labels.show) {
          var _loop = function _loop(i) {
            var val = labels[i];
            val = lbFormatter(val, i, w);
            var xPad = w.config.yaxis[realIndex].labels.padding;

            if (w.config.yaxis[realIndex].opposite && w.config.yaxis.length !== 0) {
              xPad = xPad * -1;
            }

            var textAnchor = 'end';

            if (w.config.yaxis[realIndex].opposite) {
              textAnchor = 'start';
            }

            if (w.config.yaxis[realIndex].labels.align === 'left') {
              textAnchor = 'start';
            } else if (w.config.yaxis[realIndex].labels.align === 'center') {
              textAnchor = 'middle';
            } else if (w.config.yaxis[realIndex].labels.align === 'right') {
              textAnchor = 'end';
            }

            var yColors = _this.axesUtils.getYAxisForeColor(yaxisStyle.colors, realIndex);

            var getForeColor = function getForeColor() {
              return Array.isArray(yColors) ? yColors[i] : yColors;
            };

            var label = graphics.drawText({
              x: xPad,
              y: l + tickAmount / 10 + w.config.yaxis[realIndex].labels.offsetY + 1,
              text: val,
              textAnchor: textAnchor,
              fontSize: yaxisFontSize,
              fontFamily: yaxisFontFamily,
              fontWeight: yaxisFontWeight,
              maxWidth: w.config.yaxis[realIndex].labels.maxWidth,
              foreColor: getForeColor(),
              isPlainText: false,
              cssClass: 'apexcharts-yaxis-label ' + yaxisStyle.cssClass
            });

            if (i === tickAmount) {
              firstLabel = label;
            }

            elYaxisTexts.add(label);
            var elTooltipTitle = document.createElementNS(w.globals.SVGNS, 'title');
            elTooltipTitle.textContent = Array.isArray(val) ? val.join(' ') : val;
            label.node.appendChild(elTooltipTitle);

            if (w.config.yaxis[realIndex].labels.rotate !== 0) {
              var firstabelRotatingCenter = graphics.rotateAroundCenter(firstLabel.node);
              var labelRotatingCenter = graphics.rotateAroundCenter(label.node);
              label.node.setAttribute('transform', "rotate(".concat(w.config.yaxis[realIndex].labels.rotate, " ").concat(firstabelRotatingCenter.x, " ").concat(labelRotatingCenter.y, ")"));
            }

            l = l + labelsDivider;
          };

          for (var i = tickAmount; i >= 0; i--) {
            _loop(i);
          }
        }

        if (w.config.yaxis[realIndex].title.text !== undefined) {
          var elYaxisTitle = graphics.group({
            class: 'apexcharts-yaxis-title'
          });
          var _x = 0;

          if (w.config.yaxis[realIndex].opposite) {
            _x = w.globals.translateYAxisX[realIndex];
          }

          var elYAxisTitleText = graphics.drawText({
            x: _x,
            y: w.globals.gridHeight / 2 + w.globals.translateY + w.config.yaxis[realIndex].title.offsetY,
            text: w.config.yaxis[realIndex].title.text,
            textAnchor: 'end',
            foreColor: w.config.yaxis[realIndex].title.style.color,
            fontSize: w.config.yaxis[realIndex].title.style.fontSize,
            fontWeight: w.config.yaxis[realIndex].title.style.fontWeight,
            fontFamily: w.config.yaxis[realIndex].title.style.fontFamily,
            cssClass: 'apexcharts-yaxis-title-text ' + w.config.yaxis[realIndex].title.style.cssClass
          });
          elYaxisTitle.add(elYAxisTitleText);
          elYaxis.add(elYaxisTitle);
        }

        var axisBorder = w.config.yaxis[realIndex].axisBorder;
        var x = 31 + axisBorder.offsetX;

        if (w.config.yaxis[realIndex].opposite) {
          x = -31 - axisBorder.offsetX;
        }

        if (axisBorder.show) {
          var elVerticalLine = graphics.drawLine(x, w.globals.translateY + axisBorder.offsetY - 2, x, w.globals.gridHeight + w.globals.translateY + axisBorder.offsetY + 2, axisBorder.color, 0, axisBorder.width);
          elYaxis.add(elVerticalLine);
        }

        if (w.config.yaxis[realIndex].axisTicks.show) {
          this.axesUtils.drawYAxisTicks(x, tickAmount, axisBorder, w.config.yaxis[realIndex].axisTicks, realIndex, labelsDivider, elYaxis);
        }

        return elYaxis;
      }

    }, {
      key: "drawYaxisInversed",
      value: function drawYaxisInversed(realIndex) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var elXaxis = graphics.group({
          class: 'apexcharts-xaxis apexcharts-yaxis-inversed'
        });
        var elXaxisTexts = graphics.group({
          class: 'apexcharts-xaxis-texts-g',
          transform: "translate(".concat(w.globals.translateXAxisX, ", ").concat(w.globals.translateXAxisY, ")")
        });
        elXaxis.add(elXaxisTexts);
        var tickAmount = w.globals.yAxisScale[realIndex].result.length - 1;

        var labelsDivider = w.globals.gridWidth / tickAmount + 0.1;

        var l = labelsDivider + w.config.xaxis.labels.offsetX;
        var lbFormatter = w.globals.xLabelFormatter;
        var labels = w.globals.yAxisScale[realIndex].result.slice();
        var timescaleLabels = w.globals.timescaleLabels;

        if (timescaleLabels.length > 0) {
          this.xaxisLabels = timescaleLabels.slice();
          labels = timescaleLabels.slice();
          tickAmount = labels.length;
        }

        labels = this.axesUtils.checkForReversedLabels(realIndex, labels);
        var tl = timescaleLabels.length;

        if (w.config.xaxis.labels.show) {
          for (var i = tl ? 0 : tickAmount; tl ? i < tl : i >= 0; tl ? i++ : i--) {
            var val = labels[i];
            val = lbFormatter(val, i, w);
            var x = w.globals.gridWidth + w.globals.padHorizontal - (l - labelsDivider + w.config.xaxis.labels.offsetX);

            if (timescaleLabels.length) {
              var label = this.axesUtils.getLabel(labels, timescaleLabels, x, i, this.drawnLabels, this.xaxisFontSize);
              x = label.x;
              val = label.text;
              this.drawnLabels.push(label.text);

              if (i === 0 && w.globals.skipFirstTimelinelabel) {
                val = '';
              }

              if (i === labels.length - 1 && w.globals.skipLastTimelinelabel) {
                val = '';
              }
            }

            var elTick = graphics.drawText({
              x: x,
              y: this.xAxisoffX + w.config.xaxis.labels.offsetY + 30 - (w.config.xaxis.position === 'top' ? w.globals.xAxisHeight + w.config.xaxis.axisTicks.height - 2 : 0),
              text: val,
              textAnchor: 'middle',
              foreColor: Array.isArray(this.xaxisForeColors) ? this.xaxisForeColors[realIndex] : this.xaxisForeColors,
              fontSize: this.xaxisFontSize,
              fontFamily: this.xaxisFontFamily,
              fontWeight: w.config.xaxis.labels.style.fontWeight,
              isPlainText: false,
              cssClass: 'apexcharts-xaxis-label ' + w.config.xaxis.labels.style.cssClass
            });
            elXaxisTexts.add(elTick);
            elTick.tspan(val);
            var elTooltipTitle = document.createElementNS(w.globals.SVGNS, 'title');
            elTooltipTitle.textContent = val;
            elTick.node.appendChild(elTooltipTitle);
            l = l + labelsDivider;
          }
        }

        this.inversedYAxisTitleText(elXaxis);
        this.inversedYAxisBorder(elXaxis);
        return elXaxis;
      }
    }, {
      key: "inversedYAxisBorder",
      value: function inversedYAxisBorder(parent) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var axisBorder = w.config.xaxis.axisBorder;

        if (axisBorder.show) {
          var lineCorrection = 0;

          if (w.config.chart.type === 'bar' && w.globals.isXNumeric) {
            lineCorrection = lineCorrection - 15;
          }

          var elHorzLine = graphics.drawLine(w.globals.padHorizontal + lineCorrection + axisBorder.offsetX, this.xAxisoffX, w.globals.gridWidth, this.xAxisoffX, axisBorder.color, 0, axisBorder.height);

          if (this.elgrid && this.elgrid.elGridBorders) {
            this.elgrid.elGridBorders.add(elHorzLine);
          } else {
            parent.add(elHorzLine);
          }
        }
      }
    }, {
      key: "inversedYAxisTitleText",
      value: function inversedYAxisTitleText(parent) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);

        if (w.config.xaxis.title.text !== undefined) {
          var elYaxisTitle = graphics.group({
            class: 'apexcharts-xaxis-title apexcharts-yaxis-title-inversed'
          });
          var elYAxisTitleText = graphics.drawText({
            x: w.globals.gridWidth / 2 + w.config.xaxis.title.offsetX,
            y: this.xAxisoffX + parseFloat(this.xaxisFontSize) + parseFloat(w.config.xaxis.title.style.fontSize) + w.config.xaxis.title.offsetY + 20,
            text: w.config.xaxis.title.text,
            textAnchor: 'middle',
            fontSize: w.config.xaxis.title.style.fontSize,
            fontFamily: w.config.xaxis.title.style.fontFamily,
            fontWeight: w.config.xaxis.title.style.fontWeight,
            foreColor: w.config.xaxis.title.style.color,
            cssClass: 'apexcharts-xaxis-title-text ' + w.config.xaxis.title.style.cssClass
          });
          elYaxisTitle.add(elYAxisTitleText);
          parent.add(elYaxisTitle);
        }
      }
    }, {
      key: "yAxisTitleRotate",
      value: function yAxisTitleRotate(realIndex, yAxisOpposite) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var yAxisLabelsCoord = {
          width: 0,
          height: 0
        };
        var yAxisTitleCoord = {
          width: 0,
          height: 0
        };
        var elYAxisLabelsWrap = w.globals.dom.baseEl.querySelector(" .apexcharts-yaxis[rel='".concat(realIndex, "'] .apexcharts-yaxis-texts-g"));

        if (elYAxisLabelsWrap !== null) {
          yAxisLabelsCoord = elYAxisLabelsWrap.getBoundingClientRect();
        }

        var yAxisTitle = w.globals.dom.baseEl.querySelector(".apexcharts-yaxis[rel='".concat(realIndex, "'] .apexcharts-yaxis-title text"));

        if (yAxisTitle !== null) {
          yAxisTitleCoord = yAxisTitle.getBoundingClientRect();
        }

        if (yAxisTitle !== null) {
          var x = this.xPaddingForYAxisTitle(realIndex, yAxisLabelsCoord, yAxisTitleCoord, yAxisOpposite);
          yAxisTitle.setAttribute('x', x.xPos - (yAxisOpposite ? 10 : 0));
        }

        if (yAxisTitle !== null) {
          var titleRotatingCenter = graphics.rotateAroundCenter(yAxisTitle);
          yAxisTitle.setAttribute('transform', "rotate(".concat(yAxisOpposite ? w.config.yaxis[realIndex].title.rotate * -1 : w.config.yaxis[realIndex].title.rotate, " ").concat(titleRotatingCenter.x, " ").concat(titleRotatingCenter.y, ")"));
        }
      }
    }, {
      key: "xPaddingForYAxisTitle",
      value: function xPaddingForYAxisTitle(realIndex, yAxisLabelsCoord, yAxisTitleCoord, yAxisOpposite) {
        var w = this.w;
        var oppositeAxisCount = 0;
        var x = 0;
        var padd = 10;

        if (w.config.yaxis[realIndex].title.text === undefined || realIndex < 0) {
          return {
            xPos: x,
            padd: 0
          };
        }

        if (yAxisOpposite) {
          x = yAxisLabelsCoord.width + w.config.yaxis[realIndex].title.offsetX + yAxisTitleCoord.width / 2 + padd / 2;
          oppositeAxisCount += 1;

          if (oppositeAxisCount === 0) {
            x = x - padd / 2;
          }
        } else {
          x = yAxisLabelsCoord.width * -1 + w.config.yaxis[realIndex].title.offsetX + padd / 2 + yAxisTitleCoord.width / 2;

          if (w.globals.isBarHorizontal) {
            padd = 25;
            x = yAxisLabelsCoord.width * -1 - w.config.yaxis[realIndex].title.offsetX - padd;
          }
        }

        return {
          xPos: x,
          padd: padd
        };
      }

    }, {
      key: "setYAxisXPosition",
      value: function setYAxisXPosition(yaxisLabelCoords, yTitleCoords) {
        var w = this.w;
        var xLeft = 0;
        var xRight = 0;
        var leftOffsetX = 18;
        var rightOffsetX = 1;

        if (w.config.yaxis.length > 1) {
          this.multipleYs = true;
        }

        w.config.yaxis.map(function (yaxe, index) {
          var shouldNotDrawAxis = w.globals.ignoreYAxisIndexes.indexOf(index) > -1 || !yaxe.show || yaxe.floating || yaxisLabelCoords[index].width === 0;
          var axisWidth = yaxisLabelCoords[index].width + yTitleCoords[index].width;

          if (!yaxe.opposite) {
            xLeft = w.globals.translateX - leftOffsetX;

            if (!shouldNotDrawAxis) {
              leftOffsetX = leftOffsetX + axisWidth + 20;
            }

            w.globals.translateYAxisX[index] = xLeft + yaxe.labels.offsetX;
          } else {
            if (w.globals.isBarHorizontal) {
              xRight = w.globals.gridWidth + w.globals.translateX - 1;
              w.globals.translateYAxisX[index] = xRight - yaxe.labels.offsetX;
            } else {
              xRight = w.globals.gridWidth + w.globals.translateX + rightOffsetX;

              if (!shouldNotDrawAxis) {
                rightOffsetX = rightOffsetX + axisWidth + 20;
              }

              w.globals.translateYAxisX[index] = xRight - yaxe.labels.offsetX + 20;
            }
          }
        });
      }
    }, {
      key: "setYAxisTextAlignments",
      value: function setYAxisTextAlignments() {
        var w = this.w;
        var yaxis = w.globals.dom.baseEl.getElementsByClassName("apexcharts-yaxis");
        yaxis = Utils$1.listToArray(yaxis);
        yaxis.forEach(function (y, index) {
          var yaxe = w.config.yaxis[index];

          if (yaxe && !yaxe.floating && yaxe.labels.align !== undefined) {
            var yAxisInner = w.globals.dom.baseEl.querySelector(".apexcharts-yaxis[rel='".concat(index, "'] .apexcharts-yaxis-texts-g"));
            var yAxisTexts = w.globals.dom.baseEl.querySelectorAll(".apexcharts-yaxis[rel='".concat(index, "'] .apexcharts-yaxis-label"));
            yAxisTexts = Utils$1.listToArray(yAxisTexts);
            var rect = yAxisInner.getBoundingClientRect();

            if (yaxe.labels.align === 'left') {
              yAxisTexts.forEach(function (label, lI) {
                label.setAttribute('text-anchor', 'start');
              });

              if (!yaxe.opposite) {
                yAxisInner.setAttribute('transform', "translate(-".concat(rect.width, ", 0)"));
              }
            } else if (yaxe.labels.align === 'center') {
              yAxisTexts.forEach(function (label, lI) {
                label.setAttribute('text-anchor', 'middle');
              });
              yAxisInner.setAttribute('transform', "translate(".concat(rect.width / 2 * (!yaxe.opposite ? -1 : 1), ", 0)"));
            } else if (yaxe.labels.align === 'right') {
              yAxisTexts.forEach(function (label, lI) {
                label.setAttribute('text-anchor', 'end');
              });

              if (yaxe.opposite) {
                yAxisInner.setAttribute('transform', "translate(".concat(rect.width, ", 0)"));
              }
            }
          }
        });
      }
    }]);

    return YAxis;
  }();

  var Events = /*#__PURE__*/function () {
    function Events(ctx) {
      _classCallCheck(this, Events);

      this.ctx = ctx;
      this.w = ctx.w;
      this.documentEvent = Utils$1.bind(this.documentEvent, this);
    }

    _createClass(Events, [{
      key: "addEventListener",
      value: function addEventListener(name, handler) {
        var w = this.w;

        if (w.globals.events.hasOwnProperty(name)) {
          w.globals.events[name].push(handler);
        } else {
          w.globals.events[name] = [handler];
        }
      }
    }, {
      key: "removeEventListener",
      value: function removeEventListener(name, handler) {
        var w = this.w;

        if (!w.globals.events.hasOwnProperty(name)) {
          return;
        }

        var index = w.globals.events[name].indexOf(handler);

        if (index !== -1) {
          w.globals.events[name].splice(index, 1);
        }
      }
    }, {
      key: "fireEvent",
      value: function fireEvent(name, args) {
        var w = this.w;

        if (!w.globals.events.hasOwnProperty(name)) {
          return;
        }

        if (!args || !args.length) {
          args = [];
        }

        var evs = w.globals.events[name];
        var l = evs.length;

        for (var i = 0; i < l; i++) {
          evs[i].apply(null, args);
        }
      }
    }, {
      key: "setupEventHandlers",
      value: function setupEventHandlers() {
        var _this = this;

        var w = this.w;
        var me = this.ctx;
        var clickableArea = w.globals.dom.baseEl.querySelector(w.globals.chartClass);
        this.ctx.eventList.forEach(function (event) {
          clickableArea.addEventListener(event, function (e) {
            var opts = Object.assign({}, w, {
              seriesIndex: w.globals.capturedSeriesIndex,
              dataPointIndex: w.globals.capturedDataPointIndex
            });

            if (e.type === 'mousemove' || e.type === 'touchmove') {
              if (typeof w.config.chart.events.mouseMove === 'function') {
                w.config.chart.events.mouseMove(e, me, opts);
              }
            } else if (e.type === 'mouseleave' || e.type === 'touchleave') {
              if (typeof w.config.chart.events.mouseLeave === 'function') {
                w.config.chart.events.mouseLeave(e, me, opts);
              }
            } else if (e.type === 'mouseup' && e.which === 1 || e.type === 'touchend') {
              if (typeof w.config.chart.events.click === 'function') {
                w.config.chart.events.click(e, me, opts);
              }

              me.ctx.events.fireEvent('click', [e, me, opts]);
            }
          }, {
            capture: false,
            passive: true
          });
        });
        this.ctx.eventList.forEach(function (event) {
          w.globals.dom.baseEl.addEventListener(event, _this.documentEvent, {
            passive: true
          });
        });
        this.ctx.core.setupBrushHandler();
      }
    }, {
      key: "documentEvent",
      value: function documentEvent(e) {
        var w = this.w;
        var target = e.target.className;

        if (e.type === 'click') {
          var elMenu = w.globals.dom.baseEl.querySelector('.apexcharts-menu');

          if (elMenu && elMenu.classList.contains('apexcharts-menu-open') && target !== 'apexcharts-menu-icon') {
            elMenu.classList.remove('apexcharts-menu-open');
          }
        }

        w.globals.clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        w.globals.clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
      }
    }]);

    return Events;
  }();

  var Localization = /*#__PURE__*/function () {
    function Localization(ctx) {
      _classCallCheck(this, Localization);

      this.ctx = ctx;
      this.w = ctx.w;
    }

    _createClass(Localization, [{
      key: "setCurrentLocaleValues",
      value: function setCurrentLocaleValues(localeName) {
        var locales = this.w.config.chart.locales;


        if (window.Apex.chart && window.Apex.chart.locales && window.Apex.chart.locales.length > 0) {
          locales = this.w.config.chart.locales.concat(window.Apex.chart.locales);
        }


        var selectedLocale = locales.filter(function (c) {
          return c.name === localeName;
        })[0];

        if (selectedLocale) {

          var ret = Utils$1.extend(en, selectedLocale);

          this.w.globals.locale = ret.options;
        } else {
          throw new Error('Wrong locale name provided. Please make sure you set the correct locale name in options');
        }
      }
    }]);

    return Localization;
  }();

  var Axes = /*#__PURE__*/function () {
    function Axes(ctx) {
      _classCallCheck(this, Axes);

      this.ctx = ctx;
      this.w = ctx.w;
    }

    _createClass(Axes, [{
      key: "drawAxis",
      value: function drawAxis(type, elgrid) {
        var _this = this;

        var gl = this.w.globals;
        var cnf = this.w.config;
        var xAxis = new XAxis(this.ctx, elgrid);
        var yAxis = new YAxis(this.ctx, elgrid);

        if (gl.axisCharts && type !== 'radar') {
          var elXaxis, elYaxis;

          if (gl.isBarHorizontal) {
            elYaxis = yAxis.drawYaxisInversed(0);
            elXaxis = xAxis.drawXaxisInversed(0);
            gl.dom.elGraphical.add(elXaxis);
            gl.dom.elGraphical.add(elYaxis);
          } else {
            elXaxis = xAxis.drawXaxis();
            gl.dom.elGraphical.add(elXaxis);
            cnf.yaxis.map(function (yaxe, index) {
              if (gl.ignoreYAxisIndexes.indexOf(index) === -1) {
                elYaxis = yAxis.drawYaxis(index);
                gl.dom.Paper.add(elYaxis);

                if (_this.w.config.grid.position === 'back') {
                  var inner = gl.dom.Paper.children()[1];
                  inner.remove();
                  gl.dom.Paper.add(inner);
                }
              }
            });
          }
        }
      }
    leFormatter(label) {
            return label;
          };
        }

        return {
          yLbFormatter: yLbFormatter,
          yLbTitleFormatter: yLbTitleFormatter
        };
      }
    }, {
      key: "getSeriesName",
      value: function getSeriesName(_ref3) {
        var fn = _ref3.fn,
            index = _ref3.index,
            seriesIndex = _ref3.seriesIndex,
            j = _ref3.j;
        var w = this.w;
        return fn(String(w.globals.seriesNames[index]), {
          series: w.globals.series,
          seriesIndex: seriesIndex,
          dataPointIndex: j,
          w: w
        });
      }
    }, {
      key: "DOMHandling",
      value: function DOMHandling(_ref4) {
        _ref4.i;
            var t = _ref4.t,
            j = _ref4.j,
            ttItems = _ref4.ttItems,
            values = _ref4.values,
            seriesName = _ref4.seriesName,
            shared = _ref4.shared,
            pColor = _ref4.pColor;
        var w = this.w;
        var ttCtx = this.ttCtx;
        var val = values.val,
            goalVals = values.goalVals,
            xVal = values.xVal,
            xAxisTTVal = values.xAxisTTVal,
            zVal = values.zVal;
        var ttItemsChildren = null;
        ttItemsChildren = ttItems[t].children;

        if (w.config.tooltip.fillSeriesColor) {
          ttItems[t].style.backgroundColor = pColor;
          ttItemsChildren[0].style.display = 'none';
        }

        if (ttCtx.showTooltipTitle) {
          if (ttCtx.tooltipTitle === null) {

            ttCtx.tooltipTitle = w.globals.dom.baseEl.querySelector('.apexcharts-tooltip-title');
          }

          ttCtx.tooltipTitle.innerHTML = xVal;
        }


        if (ttCtx.isXAxisTooltipEnabled) {
          ttCtx.xaxisTooltipText.innerHTML = xAxisTTVal !== '' ? xAxisTTVal : xVal;
        }

        var ttYLabel = ttItems[t].querySelector('.apexcharts-tooltip-text-y-label');

        if (ttYLabel) {
          ttYLabel.innerHTML = seriesName ? seriesName : '';
        }

        var ttYVal = ttItems[t].querySelector('.apexcharts-tooltip-text-y-value');

        if (ttYVal) {
          ttYVal.innerHTML = typeof val !== 'undefined' ? val : '';
        }

        if (ttItemsChildren[0] && ttItemsChildren[0].classList.contains('apexcharts-tooltip-marker')) {
          if (w.config.tooltip.marker.fillColors && Array.isArray(w.config.tooltip.marker.fillColors)) {
            pColor = w.config.tooltip.marker.fillColors[t];
          }

          ttItemsChildren[0].style.backgroundColor = pColor;
        }

        if (!w.config.tooltip.marker.show) {
          ttItemsChildren[0].style.display = 'none';
        }

        var ttGLabel = ttItems[t].querySelector('.apexcharts-tooltip-text-goals-label');
        var ttGVal = ttItems[t].querySelector('.apexcharts-tooltip-text-goals-value');

        if (goalVals.length && w.globals.seriesGoals[t]) {
          var createGoalsHtml = function createGoalsHtml() {
            var gLabels = '<div >';
            var gVals = '<div>';
            goalVals.forEach(function (goal, gi) {
              gLabels += " <div style=\"display: flex\"><span class=\"apexcharts-tooltip-marker\" style=\"background-color: ".concat(goal.attrs.strokeColor, "; height: 3px; border-radius: 0; top: 5px;\"></span> ").concat(goal.attrs.name, "</div>");
              gVals += "<div>".concat(goal.val, "</div>");
            });
            ttGLabel.innerHTML = gLabels + "</div>";
            ttGVal.innerHTML = gVals + "</div>";
          };

          if (shared) {
            if (w.globals.seriesGoals[t][j] && Array.isArray(w.globals.seriesGoals[t][j])) {
              createGoalsHtml();
            } else {
              ttGLabel.innerHTML = '';
              ttGVal.innerHTML = '';
            }
          } else {
            createGoalsHtml();
          }
        } else {
          ttGLabel.innerHTML = '';
          ttGVal.innerHTML = '';
        }

        if (zVal !== null) {
          var ttZLabel = ttItems[t].querySelector('.apexcharts-tooltip-text-z-label');
          ttZLabel.innerHTML = w.config.tooltip.z.title;
          var ttZVal = ttItems[t].querySelector('.apexcharts-tooltip-text-z-value');
          ttZVal.innerHTML = typeof zVal !== 'undefined' ? zVal : '';
        }

        if (shared && ttItemsChildren[0]) {

          if (typeof val === 'undefined' || val === null || w.globals.ancillaryCollapsedSeriesIndices.indexOf(t) > -1 || w.globals.collapsedSeriesIndices.indexOf(t) > -1) {
            ttItemsChildren[0].parentNode.style.display = 'none';
          } else {
            ttItemsChildren[0].parentNode.style.display = w.config.tooltip.items.display;
          }
        }
      }
    }, {
      key: "toggleActiveInactiveSeries",
      value: function toggleActiveInactiveSeries(shared) {
        var w = this.w;

        if (shared) {

          this.tooltipUtil.toggleAllTooltipSeriesGroups('enable');
        } else {

          this.tooltipUtil.toggleAllTooltipSeriesGroups('disable');

          var firstTooltipSeriesGroup = w.globals.dom.baseEl.querySelector('.apexcharts-tooltip-series-group');

          if (firstTooltipSeriesGroup) {
            firstTooltipSeriesGroup.classList.add('apexcharts-active');
            firstTooltipSeriesGroup.style.display = w.config.tooltip.items.display;
          }
        }
      }
    }, {
      key: "getValuesToPrint",
      value: function getValuesToPrint(_ref5) {
        var i = _ref5.i,
            j = _ref5.j;
        var w = this.w;
        var filteredSeriesX = this.ctx.series.filteredSeriesX();
        var xVal = '';
        var xAxisTTVal = '';
        var zVal = null;
        var val = null;
        var customFormatterOpts = {
          series: w.globals.series,
          seriesIndex: i,
          dataPointIndex: j,
          w: w
        };
        var zFormatter = w.globals.ttZFormatter;

        if (j === null) {
          val = w.globals.series[i];
        } else {
          if (w.globals.isXNumeric && w.config.chart.type !== 'treemap') {
            xVal = filteredSeriesX[i][j];

            if (filteredSeriesX[i].length === 0) {

              var firstActiveSeriesIndex = this.tooltipUtil.getFirstActiveXArray(filteredSeriesX);
              xVal = filteredSeriesX[firstActiveSeriesIndex][j];
            }
          } else {
            xVal = typeof w.globals.labels[j] !== 'undefined' ? w.globals.labels[j] : '';
          }
        }

        var bufferXVal = xVal;

        if (w.globals.isXNumeric && w.config.xaxis.type === 'datetime') {
          var xFormat = new Formatters(this.ctx);
          xVal = xFormat.xLabelFormat(w.globals.ttKeyFormatter, bufferXVal, bufferXVal, {
            i: undefined,
            dateFormatter: new DateTime(this.ctx).formatDate,
            w: this.w
          });
        } else {
          if (w.globals.isBarHorizontal) {
            xVal = w.globals.yLabelFormatters[0](bufferXVal, customFormatterOpts);
          } else {
            xVal = w.globals.xLabelFormatter(bufferXVal, customFormatterOpts);
          }
        }


        if (w.config.tooltip.x.formatter !== undefined) {
          xVal = w.globals.ttKeyFormatter(bufferXVal, customFormatterOpts);
        }

        if (w.globals.seriesZ.length > 0 && w.globals.seriesZ[i].length > 0) {
          zVal = zFormatter(w.globals.seriesZ[i][j], w);
        }

        if (typeof w.config.xaxis.tooltip.formatter === 'function') {
          xAxisTTVal = w.globals.xaxisTooltipFormatter(bufferXVal, customFormatterOpts);
        } else {
          xAxisTTVal = xVal;
        }

        return {
          val: Array.isArray(val) ? val.join(' ') : val,
          xVal: Array.isArray(xVal) ? xVal.join(' ') : xVal,
          xAxisTTVal: Array.isArray(xAxisTTVal) ? xAxisTTVal.join(' ') : xAxisTTVal,
          zVal: zVal
        };
      }
    }, {
      key: "handleCustomTooltip",
      value: function handleCustomTooltip(_ref6) {
        var i = _ref6.i,
            j = _ref6.j,
            y1 = _ref6.y1,
            y2 = _ref6.y2,
            w = _ref6.w;
        var tooltipEl = this.ttCtx.getElTooltip();
        var fn = w.config.tooltip.custom;

        if (Array.isArray(fn) && fn[i]) {
          fn = fn[i];
        }


        tooltipEl.innerHTML = fn({
          ctx: this.ctx,
          series: w.globals.series,
          seriesIndex: i,
          dataPointIndex: j,
          y1: y1,
          y2: y2,
          w: w
        });
      }
    }]);

    return Labels;
  }();

  /**
   * ApexCharts Tooltip.Position Class to move the tooltip based on x and y position.
   *
   * @module Tooltip.Position
   **/

  var Position = /*#__PURE__*/function () {
    function Position(tooltipContext) {
      _classCallCheck(this, Position);

      this.ttCtx = tooltipContext;
      this.ctx = tooltipContext.ctx;
      this.w = tooltipContext.w;
    }
    /**
     * This will move the crosshair (the vertical/horz line that moves along with mouse)
     * Along with this, this function also calls the xaxisMove function
     * @memberof Position
     * @param {int} - cx = point's x position, wherever point's x is, you need to move crosshair
     */


    _createClass(Position, [{
      key: "moveXCrosshairs",
      value: function moveXCrosshairs(cx) {
        var j = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
        var ttCtx = this.ttCtx;
        var w = this.w;
        var xcrosshairs = ttCtx.getElXCrosshairs();
        var x = cx - ttCtx.xcrosshairsWidth / 2;
        var tickAmount = w.globals.labels.slice().length;

        if (j !== null) {
          x = w.globals.gridWidth / tickAmount * j;
        }

        if (xcrosshairs !== null && !w.globals.isBarHorizontal) {
          xcrosshairs.setAttribute('x', x);
          xcrosshairs.setAttribute('x1', x);
          xcrosshairs.setAttribute('x2', x);
          xcrosshairs.setAttribute('y2', w.globals.gridHeight);
          xcrosshairs.classList.add('apexcharts-active');
        }

        if (x < 0) {
          x = 0;
        }

        if (x > w.globals.gridWidth) {
          x = w.globals.gridWidth;
        }

        if (ttCtx.isXAxisTooltipEnabled) {
          var tx = x;

          if (w.config.xaxis.crosshairs.width === 'tickWidth' || w.config.xaxis.crosshairs.width === 'barWidth') {
            tx = x + ttCtx.xcrosshairsWidth / 2;
          }

          this.moveXAxisTooltip(tx);
        }
      }
      /**
       * This will move the crosshair (the vertical/horz line that moves along with mouse)
       * Along with this, this function also calls the xaxisMove function
       * @memberof Position
       * @param {int} - cx = point's x position, wherever point's x is, you need to move crosshair
       */

    }, {
      key: "moveYCrosshairs",
      value: function moveYCrosshairs(cy) {
        var ttCtx = this.ttCtx;

        if (ttCtx.ycrosshairs !== null) {
          Graphics.setAttrs(ttCtx.ycrosshairs, {
            y1: cy,
            y2: cy
          });
        }

        if (ttCtx.ycrosshairsHidden !== null) {
          Graphics.setAttrs(ttCtx.ycrosshairsHidden, {
            y1: cy,
            y2: cy
          });
        }
      }
      /**
       ** AxisTooltip is the small rectangle which appears on x axis with x value, when user moves
       * @memberof Position
       * @param {int} - cx = point's x position, wherever point's x is, you need to move
       */

    }, {
      key: "moveXAxisTooltip",
      value: function moveXAxisTooltip(cx) {
        var w = this.w;
        var ttCtx = this.ttCtx;

        if (ttCtx.xaxisTooltip !== null && ttCtx.xcrosshairsWidth !== 0) {
          ttCtx.xaxisTooltip.classList.add('apexcharts-active');
          var cy = ttCtx.xaxisOffY + w.config.xaxis.tooltip.offsetY + w.globals.translateY + 1 + w.config.xaxis.offsetY;
          var xaxisTTText = ttCtx.xaxisTooltip.getBoundingClientRect();
          var xaxisTTTextWidth = xaxisTTText.width;
          cx = cx - xaxisTTTextWidth / 2;

          if (!isNaN(cx)) {
            cx = cx + w.globals.translateX;
            var textRect = 0;
            var graphics = new Graphics(this.ctx);
            textRect = graphics.getTextRects(ttCtx.xaxisTooltipText.innerHTML);
            ttCtx.xaxisTooltipText.style.minWidth = textRect.width + 'px';
            ttCtx.xaxisTooltip.style.left = cx + 'px';
            ttCtx.xaxisTooltip.style.top = cy + 'px';
          }
        }
      }
    }, {
      key: "moveYAxisTooltip",
      value: function moveYAxisTooltip(index) {
        var w = this.w;
        var ttCtx = this.ttCtx;

        if (ttCtx.yaxisTTEls === null) {
          ttCtx.yaxisTTEls = w.globals.dom.baseEl.querySelectorAll('.apexcharts-yaxistooltip');
        }

        var ycrosshairsHiddenRectY1 = parseInt(ttCtx.ycrosshairsHidden.getAttribute('y1'), 10);
        var cy = w.globals.translateY + ycrosshairsHiddenRectY1;
        var yAxisTTRect = ttCtx.yaxisTTEls[index].getBoundingClientRect();
        var yAxisTTHeight = yAxisTTRect.height;
        var cx = w.globals.translateYAxisX[index] - 2;

        if (w.config.yaxis[index].opposite) {
          cx = cx - 26;
        }

        cy = cy - yAxisTTHeight / 2;

        if (w.globals.ignoreYAxisIndexes.indexOf(index) === -1) {
          ttCtx.yaxisTTEls[index].classList.add('apexcharts-active');
          ttCtx.yaxisTTEls[index].style.top = cy + 'px';
          ttCtx.yaxisTTEls[index].style.left = cx + w.config.yaxis[index].tooltip.offsetX + 'px';
        } else {
          ttCtx.yaxisTTEls[index].classList.remove('apexcharts-active');
        }
      }
      /**
       ** moves the whole tooltip by changing x, y attrs
       * @memberof Position
       * @param {int} - cx = point's x position, wherever point's x is, you need to move tooltip
       * @param {int} - cy = point's y position, wherever point's y is, you need to move tooltip
       * @param {int} - r = point's radius
       */

    }, {
      key: "moveTooltip",
      value: function moveTooltip(cx, cy) {
        var r = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
        var w = this.w;
        var ttCtx = this.ttCtx;
        var tooltipEl = ttCtx.getElTooltip();
        var tooltipRect = ttCtx.tooltipRect;
        var pointR = r !== null ? parseFloat(r) : 1;
        var x = parseFloat(cx) + pointR + 5;
        var y = parseFloat(cy) + pointR / 2;

        if (x > w.globals.gridWidth / 2) {
          x = x - tooltipRect.ttWidth - pointR - 10;
        }

        if (x > w.globals.gridWidth - tooltipRect.ttWidth - 10) {
          x = w.globals.gridWidth - tooltipRect.ttWidth;
        }

        if (x < -20) {
          x = -20;
        }

        if (w.config.tooltip.followCursor) {
          var elGrid = ttCtx.getElGrid();
          var seriesBound = elGrid.getBoundingClientRect();
          y = ttCtx.e.clientY + w.globals.translateY - seriesBound.top - tooltipRect.ttHeight / 2;
        } else {
          if (!w.globals.isBarHorizontal) {
            if (tooltipRect.ttHeight / 2 + y > w.globals.gridHeight) {
              y = w.globals.gridHeight - tooltipRect.ttHeight + w.globals.translateY;
            }
          }
        }

        if (!isNaN(x)) {
          x = x + w.globals.translateX;
          tooltipEl.style.left = x + 'px';
          tooltipEl.style.top = y + 'px';
        }
      }
    }, {
      key: "moveMarkers",
      value: function moveMarkers(i, j) {
        var w = this.w;
        var ttCtx = this.ttCtx;

        if (w.globals.markers.size[i] > 0) {
          var allPoints = w.globals.dom.baseEl.querySelectorAll(" .apexcharts-series[data\\:realIndex='".concat(i, "'] .apexcharts-marker"));

          for (var p = 0; p < allPoints.length; p++) {
            if (parseInt(allPoints[p].getAttribute('rel'), 10) === j) {
              ttCtx.marker.resetPointsSize();
              ttCtx.marker.enlargeCurrentPoint(j, allPoints[p]);
            }
          }
        } else {
          ttCtx.marker.resetPointsSize();
          this.moveDynamicPointOnHover(j, i);
        }
      }


    }, {
      key: "moveDynamicPointOnHover",
      value: function moveDynamicPointOnHover(j, capturedSeries) {
        var w = this.w;
        var ttCtx = this.ttCtx;
        var cx = 0;
        var cy = 0;
        var pointsArr = w.globals.pointsArray;
        var hoverSize = ttCtx.tooltipUtil.getHoverMarkerSize(capturedSeries);
        var serType = w.config.series[capturedSeries].type;

        if (serType && (serType === 'column' || serType === 'candlestick' || serType === 'boxPlot')) {

          return;
        }

        cx = pointsArr[capturedSeries][j][0];
        cy = pointsArr[capturedSeries][j][1] ? pointsArr[capturedSeries][j][1] : 0;
        var point = w.globals.dom.baseEl.querySelector(".apexcharts-series[data\\:realIndex='".concat(capturedSeries, "'] .apexcharts-series-markers circle"));

        if (point && cy < w.globals.gridHeight && cy > 0) {
          point.setAttribute('r', hoverSize);
          point.setAttribute('cx', cx);
          point.setAttribute('cy', cy);
        }


        this.moveXCrosshairs(cx);

        if (!ttCtx.fixedTooltip) {
          this.moveTooltip(cx, cy, hoverSize);
        }
      }


    }, {
      key: "moveDynamicPointsOnHover",
      value: function moveDynamicPointsOnHover(j) {
        var ttCtx = this.ttCtx;
        var w = ttCtx.w;
        var cx = 0;
        var cy = 0;
        var activeSeries = 0;
        var pointsArr = w.globals.pointsArray;
        var series = new Series(this.ctx);
        activeSeries = series.getActiveConfigSeriesIndex('asc', ['line', 'area', 'scatter', 'bubble']);
        var hoverSize = ttCtx.tooltipUtil.getHoverMarkerSize(activeSeries);

        if (pointsArr[activeSeries]) {
          cx = pointsArr[activeSeries][j][0];
          cy = pointsArr[activeSeries][j][1];
        }

        var points = ttCtx.tooltipUtil.getAllMarkers();

        if (points !== null) {
          for (var p = 0; p < w.globals.series.length; p++) {
            var pointArr = pointsArr[p];

            if (w.globals.comboCharts) {

              if (typeof pointArr === 'undefined') {

                points.splice(p, 0, null);
              }
            }

            if (pointArr && pointArr.length) {
              var pcy = pointsArr[p][j][1];
              var pcy2 = void 0;
              points[p].setAttribute('cx', cx);

              if (w.config.chart.type === 'rangeArea' && !w.globals.comboCharts) {
                var rangeStartIndex = j + w.globals.series[p].length;
                pcy2 = pointsArr[p][rangeStartIndex][1];
                var pcyDiff = Math.abs(pcy - pcy2) / 2;
                pcy = pcy - pcyDiff;
              }

              if (pcy !== null && !isNaN(pcy) && pcy < w.globals.gridHeight + hoverSize && pcy + hoverSize > 0) {
                points[p] && points[p].setAttribute('r', hoverSize);
                points[p] && points[p].setAttribute('cy', pcy);
              } else {
                points[p] && points[p].setAttribute('r', 0);
              }
            }
          }
        }

        this.moveXCrosshairs(cx);

        if (!ttCtx.fixedTooltip) {
          var tcy = cy || w.globals.gridHeight;
          this.moveTooltip(cx, tcy, hoverSize);
        }
      }
    }, {
      key: "moveStickyTooltipOverBars",
      value: function moveStickyTooltipOverBars(j, capturedSeries) {
        var w = this.w;
        var ttCtx = this.ttCtx;
        var barLen = w.globals.columnSeries ? w.globals.columnSeries.length : w.globals.series.length;
        var i = barLen >= 2 && barLen % 2 === 0 ? Math.floor(barLen / 2) : Math.floor(barLen / 2) + 1;

        if (w.globals.isBarHorizontal) {
          var series = new Series(this.ctx);
          i = series.getActiveConfigSeriesIndex('desc') + 1;
        }

        var jBar = w.globals.dom.baseEl.querySelector(".apexcharts-bar-series .apexcharts-series[rel='".concat(i, "'] path[j='").concat(j, "'], .apexcharts-candlestick-series .apexcharts-series[rel='").concat(i, "'] path[j='").concat(j, "'], .apexcharts-boxPlot-series .apexcharts-series[rel='").concat(i, "'] path[j='").concat(j, "'], .apexcharts-rangebar-series .apexcharts-series[rel='").concat(i, "'] path[j='").concat(j, "']"));

        if (!jBar && typeof capturedSeries == 'number') {

          jBar = w.globals.dom.baseEl.querySelector(".apexcharts-bar-series .apexcharts-series[data\\:realIndex='".concat(capturedSeries, "'] path[j='").concat(j, "'],\n        .apexcharts-candlestick-series .apexcharts-series[data\\:realIndex='").concat(capturedSeries, "'] path[j='").concat(j, "'],\n        .apexcharts-boxPlot-series .apexcharts-series[data\\:realIndex='").concat(capturedSeries, "'] path[j='").concat(j, "'],\n        .apexcharts-rangebar-series .apexcharts-series[data\\:realIndex='").concat(capturedSeries, "'] path[j='").concat(j, "']"));
        }

        var bcx = jBar ? parseFloat(jBar.getAttribute('cx')) : 0;
        var bcy = jBar ? parseFloat(jBar.getAttribute('cy')) : 0;
        var bw = jBar ? parseFloat(jBar.getAttribute('barWidth')) : 0;
        var elGrid = ttCtx.getElGrid();
        var seriesBound = elGrid.getBoundingClientRect();
        var isBoxOrCandle = jBar && (jBar.classList.contains('apexcharts-candlestick-area') || jBar.classList.contains('apexcharts-boxPlot-area'));

        if (w.globals.isXNumeric) {
          if (jBar && !isBoxOrCandle) {
            bcx = bcx - (barLen % 2 !== 0 ? bw / 2 : 0);
          }

          if (jBar &&
          isBoxOrCandle && w.globals.comboCharts) {
            bcx = bcx - bw / 2;
          }
        } else {
          if (!w.globals.isBarHorizontal) {
            bcx = ttCtx.xAxisTicksPositions[j - 1] + ttCtx.dataPointsDividedWidth / 2;

            if (isNaN(bcx)) {
              bcx = ttCtx.xAxisTicksPositions[j] - ttCtx.dataPointsDividedWidth / 2;
            }
          }
        }

        if (!w.globals.isBarHorizontal) {
          if (w.config.tooltip.followCursor) {
            bcy = ttCtx.e.clientY - seriesBound.top - ttCtx.tooltipRect.ttHeight / 2;
          } else {
            if (bcy + ttCtx.tooltipRect.ttHeight + 15 > w.globals.gridHeight) {
              bcy = w.globals.gridHeight;
            }
          }
        } else {
          bcy = bcy - ttCtx.tooltipRect.ttHeight;
        }

        if (!w.globals.isBarHorizontal) {
          this.moveXCrosshairs(bcx);
        }

        if (!ttCtx.fixedTooltip) {
          var tcy = bcy || w.globals.gridHeight;
          this.moveTooltip(bcx, tcy);
        }
      }
    }]);

    return Position;
  }();

  /**
   * ApexCharts Tooltip.Marker Class to draw texts on the tooltip.
   * This file deals with the markers that appear near tooltip in line/area charts.
   * These markers helps the user to associate the data-points and the values
   * that are shown in the tooltip
   *
   * @module Tooltip.Marker
   **/

  var Marker = /*#__PURE__*/function () {
    function Marker(tooltipContext) {
      _classCallCheck(this, Marker);

      this.w = tooltipContext.w;
      this.ttCtx = tooltipContext;
      this.ctx = tooltipContext.ctx;
      this.tooltipPosition = new Position(tooltipContext);
    }

    _createClass(Marker, [{
      key: "drawDynamicPoints",
      value: function drawDynamicPoints() {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var marker = new Markers(this.ctx);
        var elsSeries = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series');
        elsSeries = _toConsumableArray(elsSeries);

        if (w.config.chart.stacked) {
          elsSeries.sort(function (a, b) {
            return parseFloat(a.getAttribute('data:realIndex')) - parseFloat(b.getAttribute('data:realIndex'));
          });
        }

        for (var i = 0; i < elsSeries.length; i++) {
          var pointsMain = elsSeries[i].querySelector(".apexcharts-series-markers-wrap");

          if (pointsMain !== null) {

            var point = void 0;
            var PointClasses = "apexcharts-marker w".concat((Math.random() + 1).toString(36).substring(4));

            if ((w.config.chart.type === 'line' || w.config.chart.type === 'area') && !w.globals.comboCharts && !w.config.tooltip.intersect) {
              PointClasses += ' no-pointer-events';
            }

            var elPointOptions = marker.getMarkerConfig({
              cssClass: PointClasses,
              seriesIndex: Number(pointsMain.getAttribute('data:realIndex'))

            });
            point = graphics.drawMarker(0, 0, elPointOptions);
            point.node.setAttribute('default-marker-size', 0);
            var elPointsG = document.createElementNS(w.globals.SVGNS, 'g');
            elPointsG.classList.add('apexcharts-series-markers');
            elPointsG.appendChild(point.node);
            pointsMain.appendChild(elPointsG);
          }
        }
      }
    }, {
      key: "enlargeCurrentPoint",
      value: function enlargeCurrentPoint(rel, point) {
        var x = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
        var y = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
        var w = this.w;

        if (w.config.chart.type !== 'bubble') {
          this.newPointSize(rel, point);
        }

        var cx = point.getAttribute('cx');
        var cy = point.getAttribute('cy');

        if (x !== null && y !== null) {
          cx = x;
          cy = y;
        }

        this.tooltipPosition.moveXCrosshairs(cx);

        if (!this.fixedTooltip) {
          if (w.config.chart.type === 'radar') {
            var elGrid = this.ttCtx.getElGrid();
            var seriesBound = elGrid.getBoundingClientRect();
            cx = this.ttCtx.e.clientX - seriesBound.left;
          }

          this.tooltipPosition.moveTooltip(cx, cy, w.config.markers.hover.size);
        }
      }
    }, {
      key: "enlargePoints",
      value: function enlargePoints(j) {
        var w = this.w;
        var me = this;
        var ttCtx = this.ttCtx;
        var col = j;
        var points = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series:not(.apexcharts-series-collapsed) .apexcharts-marker');
        var newSize = w.config.markers.hover.size;

        for (var p = 0; p < points.length; p++) {
          var rel = points[p].getAttribute('rel');
          var index = points[p].getAttribute('index');

          if (newSize === undefined) {
            newSize = w.globals.markers.size[index] + w.config.markers.hover.sizeOffset;
          }

          if (col === parseInt(rel, 10)) {
            me.newPointSize(col, points[p]);
            var cx = points[p].getAttribute('cx');
            var cy = points[p].getAttribute('cy');
            me.tooltipPosition.moveXCrosshairs(cx);

            if (!ttCtx.fixedTooltip) {
              me.tooltipPosition.moveTooltip(cx, cy, newSize);
            }
          } else {
            me.oldPointSize(points[p]);
          }
        }
      }
    }, {
      key: "newPointSize",
      value: function newPointSize(rel, point) {
        var w = this.w;
        var newSize = w.config.markers.hover.size;
        var elPoint = rel === 0 ? point.parentNode.firstChild : point.parentNode.lastChild;

        if (elPoint.getAttribute('default-marker-size') !== '0') {
          var index = parseInt(elPoint.getAttribute('index'), 10);

          if (newSize === undefined) {
            newSize = w.globals.markers.size[index] + w.config.markers.hover.sizeOffset;
          }

          if (newSize < 0) newSize = 0;
          elPoint.setAttribute('r', newSize);
        }
      }
    }, {
      key: "oldPointSize",
      value: function oldPointSize(point) {
        var size = parseFloat(point.getAttribute('default-marker-size'));
        point.setAttribute('r', size);
      }
    }, {
      key: "resetPointsSize",
      value: function resetPointsSize() {
        var w = this.w;
        var points = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series:not(.apexcharts-series-collapsed) .apexcharts-marker');

        for (var p = 0; p < points.length; p++) {
          var size = parseFloat(points[p].getAttribute('default-marker-size'));

          if (Utils$1.isNumber(size) && size >= 0) {
            points[p].setAttribute('r', size);
          } else {
            points[p].setAttribute('r', 0);
          }
        }
      }
    }]);

    return Marker;
  }();

  /**
   * ApexCharts Tooltip.Intersect Class.
   * This file deals with functions related to intersecting tooltips
   * (tooltips that appear when user hovers directly over a data-point whether)
   *
   * @module Tooltip.Intersect
   **/

  var Intersect = /*#__PURE__*/function () {
    function Intersect(tooltipContext) {
      _classCallCheck(this, Intersect);

      this.w = tooltipContext.w;
      this.ttCtx = tooltipContext;
    }


    _createClass(Intersect, [{
      key: "getAttr",
      value: function getAttr(e, attr) {
        return parseFloat(e.target.getAttribute(attr));
      }

    }, {
      key: "handleHeatTreeTooltip",
      value: function handleHeatTreeTooltip(_ref) {
        var e = _ref.e,
            opt = _ref.opt,
            x = _ref.x,
            y = _ref.y,
            type = _ref.type;
        var ttCtx = this.ttCtx;
        var w = this.w;

        if (e.target.classList.contains("apexcharts-".concat(type, "-rect"))) {
          var i = this.getAttr(e, 'i');
          var j = this.getAttr(e, 'j');
          var cx = this.getAttr(e, 'cx');
          var cy = this.getAttr(e, 'cy');
          var width = this.getAttr(e, 'width');
          var height = this.getAttr(e, 'height');
          ttCtx.tooltipLabels.drawSeriesTexts({
            ttItems: opt.ttItems,
            i: i,
            j: j,
            shared: false,
            e: e
          });
          w.globals.capturedSeriesIndex = i;
          w.globals.capturedDataPointIndex = j;
          x = cx + ttCtx.tooltipRect.ttWidth / 2 + width;
          y = cy + ttCtx.tooltipRect.ttHeight / 2 - height / 2;
          ttCtx.tooltipPosition.moveXCrosshairs(cx + width / 2);

          if (x > w.globals.gridWidth / 2) {
            x = cx - ttCtx.tooltipRect.ttWidth / 2 + width;
          }

          if (ttCtx.w.config.tooltip.followCursor) {
            var seriesBound = w.globals.dom.elWrap.getBoundingClientRect();
            x = w.globals.clientX - seriesBound.left - (x > w.globals.gridWidth / 2 ? ttCtx.tooltipRect.ttWidth : 0);
            y = w.globals.clientY - seriesBound.top - (y > w.globals.gridHeight / 2 ? ttCtx.tooltipRect.ttHeight : 0);
          }
        }

        return {
          x: x,
          y: y
        };
      }
      /**
       * handle tooltips for line/area/scatter charts where tooltip.intersect is true
       * when user hovers over the marker directly, this function is executed
       */

    }, {
      key: "handleMarkerTooltip",
      value: function handleMarkerTooltip(_ref2) {
        var e = _ref2.e,
            opt = _ref2.opt,
            x = _ref2.x,
            y = _ref2.y;
        var w = this.w;
        var ttCtx = this.ttCtx;
        var i;
        var j;

        if (e.target.classList.contains('apexcharts-marker')) {
          var cx = parseInt(opt.paths.getAttribute('cx'), 10);
          var cy = parseInt(opt.paths.getAttribute('cy'), 10);
          var val = parseFloat(opt.paths.getAttribute('val'));
          j = parseInt(opt.paths.getAttribute('rel'), 10);
          i = parseInt(opt.paths.parentNode.parentNode.parentNode.getAttribute('rel'), 10) - 1;

          if (ttCtx.intersect) {
            var el = Utils$1.findAncestor(opt.paths, 'apexcharts-series');

            if (el) {
              i = parseInt(el.getAttribute('data:realIndex'), 10);
            }
          }

          ttCtx.tooltipLabels.drawSeriesTexts({
            ttItems: opt.ttItems,
            i: i,
            j: j,
            shared: ttCtx.showOnIntersect ? false : w.config.tooltip.shared,
            e: e
          });

          if (e.type === 'mouseup') {
            ttCtx.markerClick(e, i, j);
          }

          w.globals.capturedSeriesIndex = i;
          w.globals.capturedDataPointIndex = j;
          x = cx;
          y = cy + w.globals.translateY - ttCtx.tooltipRect.ttHeight * 1.4;

          if (ttCtx.w.config.tooltip.followCursor) {
            var elGrid = ttCtx.getElGrid();
            var seriesBound = elGrid.getBoundingClientRect();
            y = ttCtx.e.clientY + w.globals.translateY - seriesBound.top;
          }

          if (val < 0) {
            y = cy;
          }

          ttCtx.marker.enlargeCurrentPoint(j, opt.paths, x, y);
        }

        return {
          x: x,
          y: y
        };
      }
      /**
       * handle tooltips for bar/column charts
       */

    }, {
      key: "handleBarTooltip",
      value: function handleBarTooltip(_ref3) {
        var e = _ref3.e,
            opt = _ref3.opt;
        var w = this.w;
        var ttCtx = this.ttCtx;
        var tooltipEl = ttCtx.getElTooltip();
        var bx = 0;
        var x = 0;
        var y = 0;
        var i = 0;
        var strokeWidth;
        var barXY = this.getBarTooltipXY({
          e: e,
          opt: opt
        });
        i = barXY.i;
        var barHeight = barXY.barHeight;
        var j = barXY.j;
        w.globals.capturedSeriesIndex = i;
        w.globals.capturedDataPointIndex = j;

        if (w.globals.isBarHorizontal && ttCtx.tooltipUtil.hasBars() || !w.config.tooltip.shared) {
          x = barXY.x;
          y = barXY.y;
          strokeWidth = Array.isArray(w.config.stroke.width) ? w.config.stroke.width[i] : w.config.stroke.width;
          bx = x;
        } else {
          if (!w.globals.comboCharts && !w.config.tooltip.shared) {

            bx = bx / 2;
          }
        }


        if (isNaN(y)) {
          y = w.globals.svgHeight - ttCtx.tooltipRect.ttHeight;
        }

        var seriesIndex = parseInt(opt.paths.parentNode.getAttribute('data:realIndex'), 10);
        var isReversed = w.globals.isMultipleYAxis ? w.config.yaxis[seriesIndex] && w.config.yaxis[seriesIndex].reversed : w.config.yaxis[0].reversed;

        if (x + ttCtx.tooltipRect.ttWidth > w.globals.gridWidth && !isReversed) {
          x = x - ttCtx.tooltipRect.ttWidth;
        } else if (x < 0) {
          x = 0;
        }

        if (ttCtx.w.config.tooltip.followCursor) {
          var elGrid = ttCtx.getElGrid();
          var seriesBound = elGrid.getBoundingClientRect();
          y = ttCtx.e.clientY - seriesBound.top;
        }


        if (ttCtx.tooltip === null) {
          ttCtx.tooltip = w.globals.dom.baseEl.querySelector('.apexcharts-tooltip');
        }

        if (!w.config.tooltip.shared) {
          if (w.globals.comboBarCount > 0) {
            ttCtx.tooltipPosition.moveXCrosshairs(bx + strokeWidth / 2);
          } else {
            ttCtx.tooltipPosition.moveXCrosshairs(bx);
          }
        }


        if (!ttCtx.fixedTooltip && (!w.config.tooltip.shared || w.globals.isBarHorizontal && ttCtx.tooltipUtil.hasBars())) {
          if (isReversed) {
            x = x - ttCtx.tooltipRect.ttWidth;

            if (x < 0) {
              x = 0;
            }
          }

          if (isReversed && !(w.globals.isBarHorizontal && ttCtx.tooltipUtil.hasBars())) {
            y = y + barHeight - (w.globals.series[i][j] < 0 ? barHeight : 0) * 2;
          }

          y = y + w.globals.translateY - ttCtx.tooltipRect.ttHeight / 2;
          tooltipEl.style.left = x + w.globals.translateX + 'px';
          tooltipEl.style.top = y + 'px';
        }
      }
    }, {
      key: "getBarTooltipXY",
      value: function getBarTooltipXY(_ref4) {
        var e = _ref4.e,
            opt = _ref4.opt;
        var w = this.w;
        var j = null;
        var ttCtx = this.ttCtx;
        var i = 0;
        var x = 0;
        var y = 0;
        var barWidth = 0;
        var barHeight = 0;
        var cl = e.target.classList;

        if (cl.contains('apexcharts-bar-area') || cl.contains('apexcharts-candlestick-area') || cl.contains('apexcharts-boxPlot-area') || cl.contains('apexcharts-rangebar-area')) {
          var bar = e.target;
          var barRect = bar.getBoundingClientRect();
          var seriesBound = opt.elGrid.getBoundingClientRect();
          var bh = barRect.height;
          barHeight = barRect.height;
          var bw = barRect.width;
          var cx = parseInt(bar.getAttribute('cx'), 10);
          var cy = parseInt(bar.getAttribute('cy'), 10);
          barWidth = parseFloat(bar.getAttribute('barWidth'));
          var clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
          j = parseInt(bar.getAttribute('j'), 10);
          i = parseInt(bar.parentNode.getAttribute('rel'), 10) - 1;
          var y1 = bar.getAttribute('data-range-y1');
          var y2 = bar.getAttribute('data-range-y2');

          if (w.globals.comboCharts) {
            i = parseInt(bar.parentNode.getAttribute('data:realIndex'), 10);
          }







          ttCtx.tooltipLabels.drawSeriesTexts({
            ttItems: opt.ttItems,
            i: i,
            j: j,
            y1: y1 ? parseInt(y1, 10) : null,
            y2: y2 ? parseInt(y2, 10) : null,
            shared: ttCtx.showOnIntersect ? false : w.config.tooltip.shared,
            e: e
          });

          if (w.config.tooltip.followCursor) {
            if (w.globals.isBarHorizontal) {
              x = clientX - seriesBound.left + 15;
              y = cy - ttCtx.dataPointsDividedHeight + bh / 2 - ttCtx.tooltipRect.ttHeight / 2;
            } else {
              if (w.globals.isXNumeric) {
                x = cx - bw / 2;
              } else {
                x = cx - ttCtx.dataPointsDividedWidth + bw / 2;
              }

              y = e.clientY - seriesBound.top - ttCtx.tooltipRect.ttHeight / 2 - 15;
            }
          } else {
            if (w.globals.isBarHorizontal) {
              x = cx;

              if (x < ttCtx.xyRatios.baseLineInvertedY) {
                x = cx - ttCtx.tooltipRect.ttWidth;
              }

              y = cy - ttCtx.dataPointsDividedHeight + bh / 2 - ttCtx.tooltipRect.ttHeight / 2;
            } else {

              if (w.globals.isXNumeric) {
                x = cx - bw / 2;
              } else {
                x = cx - ttCtx.dataPointsDividedWidth + bw / 2;
              }

              y = cy;
            }
          }
        }

        return {
          x: x,
          y: y,
          barHeight: barHeight,
          barWidth: barWidth,
          i: i,
          j: j
        };
      }
    }]);

    return Intersect;
  }();

  /**
   * ApexCharts Tooltip.AxesTooltip Class.
   * This file deals with the x-axis and y-axis tooltips.
   *
   * @module Tooltip.AxesTooltip
   **/
  var AxesTooltip = /*#__PURE__*/function () {
    function AxesTooltip(tooltipContext) {
      _classCallCheck(this, AxesTooltip);

      this.w = tooltipContext.w;
      this.ttCtx = tooltipContext;
    }
    /**
     * This method adds the secondary tooltip which appears below x axis
     * @memberof Tooltip
     **/


    _createClass(AxesTooltip, [{
      key: "drawXaxisTooltip",
      value: function drawXaxisTooltip() {
        var w = this.w;
        var ttCtx = this.ttCtx;
        var isBottom = w.config.xaxis.position === 'bottom';
        ttCtx.xaxisOffY = isBottom ? w.globals.gridHeight + 1 : -w.globals.xAxisHeight - w.config.xaxis.axisTicks.height + 3;
        var tooltipCssClass = isBottom ? 'apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom' : 'apexcharts-xaxistooltip apexcharts-xaxistooltip-top';
        var renderTo = w.globals.dom.elWrap;

        if (ttCtx.isXAxisTooltipEnabled) {
          var xaxisTooltip = w.globals.dom.baseEl.querySelector('.apexcharts-xaxistooltip');

          if (xaxisTooltip === null) {
            ttCtx.xaxisTooltip = document.createElement('div');
            ttCtx.xaxisTooltip.setAttribute('class', tooltipCssClass + ' apexcharts-theme-' + w.config.tooltip.theme);
            renderTo.appendChild(ttCtx.xaxisTooltip);
            ttCtx.xaxisTooltipText = document.createElement('div');
            ttCtx.xaxisTooltipText.classList.add('apexcharts-xaxistooltip-text');
            ttCtx.xaxisTooltipText.style.fontFamily = w.config.xaxis.tooltip.style.fontFamily || w.config.chart.fontFamily;
            ttCtx.xaxisTooltipText.style.fontSize = w.config.xaxis.tooltip.style.fontSize;
            ttCtx.xaxisTooltip.appendChild(ttCtx.xaxisTooltipText);
          }
        }
      }
      /**
       * This method adds the secondary tooltip which appears below x axis
       * @memberof Tooltip
       **/

    }, {
      key: "drawYaxisTooltip",
      value: function drawYaxisTooltip() {
        var w = this.w;
        var ttCtx = this.ttCtx;

        var _loop = function _loop(i) {
          var isRight = w.config.yaxis[i].opposite || w.config.yaxis[i].crosshairs.opposite;
          ttCtx.yaxisOffX = isRight ? w.globals.gridWidth + 1 : 1;
          var tooltipCssClass = isRight ? "apexcharts-yaxistooltip apexcharts-yaxistooltip-".concat(i, " apexcharts-yaxistooltip-right") : "apexcharts-yaxistooltip apexcharts-yaxistooltip-".concat(i, " apexcharts-yaxistooltip-left");
          w.globals.yAxisSameScaleIndices.map(function (samescales, ssi) {
            samescales.map(function (s, si) {
              if (si === i) {
                tooltipCssClass += w.config.yaxis[si].show ? " " : " apexcharts-yaxistooltip-hidden";
              }
            });
          });
          var renderTo = w.globals.dom.elWrap;
          var yaxisTooltip = w.globals.dom.baseEl.querySelector(".apexcharts-yaxistooltip apexcharts-yaxistooltip-".concat(i));

          if (yaxisTooltip === null) {
            ttCtx.yaxisTooltip = document.createElement('div');
            ttCtx.yaxisTooltip.setAttribute('class', tooltipCssClass + ' apexcharts-theme-' + w.config.tooltip.theme);
            renderTo.appendChild(ttCtx.yaxisTooltip);
            if (i === 0) ttCtx.yaxisTooltipText = [];
            ttCtx.yaxisTooltipText[i] = document.createElement('div');
            ttCtx.yaxisTooltipText[i].classList.add('apexcharts-yaxistooltip-text');
            ttCtx.yaxisTooltip.appendChild(ttCtx.yaxisTooltipText[i]);
          }
        };

        for (var i = 0; i < w.config.yaxis.length; i++) {
          _loop(i);
        }
      }
      /**
       * @memberof Tooltip
       **/

    }, {
      key: "setXCrosshairWidth",
      value: function setXCrosshairWidth() {
        var w = this.w;
        var ttCtx = this.ttCtx;

        var xcrosshairs = ttCtx.getElXCrosshairs();
        ttCtx.xcrosshairsWidth = parseInt(w.config.xaxis.crosshairs.width, 10);

        if (!w.globals.comboCharts) {
          if (w.config.xaxis.crosshairs.width === 'tickWidth') {
            var count = w.globals.labels.length;
            ttCtx.xcrosshairsWidth = w.globals.gridWidth / count;
          } else if (w.config.xaxis.crosshairs.width === 'barWidth') {
            var bar = w.globals.dom.baseEl.querySelector('.apexcharts-bar-area');

            if (bar !== null) {
              var barWidth = parseFloat(bar.getAttribute('barWidth'));
              ttCtx.xcrosshairsWidth = barWidth;
            } else {
              ttCtx.xcrosshairsWidth = 1;
            }
          }
        } else {
          var _bar = w.globals.dom.baseEl.querySelector('.apexcharts-bar-area');

          if (_bar !== null && w.config.xaxis.crosshairs.width === 'barWidth') {
            var _barWidth = parseFloat(_bar.getAttribute('barWidth'));

            ttCtx.xcrosshairsWidth = _barWidth;
          } else {
            if (w.config.xaxis.crosshairs.width === 'tickWidth') {
              var _count = w.globals.labels.length;
              ttCtx.xcrosshairsWidth = w.globals.gridWidth / _count;
            }
          }
        }

        if (w.globals.isBarHorizontal) {
          ttCtx.xcrosshairsWidth = 0;
        }

        if (xcrosshairs !== null && ttCtx.xcrosshairsWidth > 0) {
          xcrosshairs.setAttribute('width', ttCtx.xcrosshairsWidth);
        }
      }
    }, {
      key: "handleYCrosshair",
      value: function handleYCrosshair() {
        var w = this.w;
        var ttCtx = this.ttCtx;

        ttCtx.ycrosshairs = w.globals.dom.baseEl.querySelector('.apexcharts-ycrosshairs');
        ttCtx.ycrosshairsHidden = w.globals.dom.baseEl.querySelector('.apexcharts-ycrosshairs-hidden');
      }
    }, {
      key: "drawYaxisTooltipText",
      value: function drawYaxisTooltipText(index, clientY, xyRatios) {
        var ttCtx = this.ttCtx;
        var w = this.w;
        var lbFormatter = w.globals.yLabelFormatters[index];

        if (ttCtx.yaxisTooltips[index]) {
          var elGrid = ttCtx.getElGrid();
          var seriesBound = elGrid.getBoundingClientRect();
          var hoverY = (clientY - seriesBound.top) * xyRatios.yRatio[index];
          var height = w.globals.maxYArr[index] - w.globals.minYArr[index];
          var val = w.globals.minYArr[index] + (height - hoverY);
          ttCtx.tooltipPosition.moveYCrosshairs(clientY - seriesBound.top);
          ttCtx.yaxisTooltipText[index].innerHTML = lbFormatter(val);
          ttCtx.tooltipPosition.moveYAxisTooltip(index);
        }
      }
    }]);

    return AxesTooltip;
  }();

  /**
   * ApexCharts Core Tooltip Class to handle the tooltip generation.
   *
   * @module Tooltip
   **/

  var Tooltip = /*#__PURE__*/function () {
    function Tooltip(ctx) {
      _classCallCheck(this, Tooltip);

      this.ctx = ctx;
      this.w = ctx.w;
      var w = this.w;
      this.tConfig = w.config.tooltip;
      this.tooltipUtil = new Utils(this);
      this.tooltipLabels = new Labels(this);
      this.tooltipPosition = new Position(this);
      this.marker = new Marker(this);
      this.intersect = new Intersect(this);
      this.axesTooltip = new AxesTooltip(this);
      this.showOnIntersect = this.tConfig.intersect;
      this.showTooltipTitle = this.tConfig.x.show;
      this.fixedTooltip = this.tConfig.fixed.enabled;
      this.xaxisTooltip = null;
      this.yaxisTTEls = null;
      this.isBarShared = !w.globals.isBarHorizontal && this.tConfig.shared;
      this.lastHoverTime = Date.now();
    }

    _createClass(Tooltip, [{
      key: "getElTooltip",
      value: function getElTooltip(ctx) {
        if (!ctx) ctx = this;
        if (!ctx.w.globals.dom.baseEl) return null;
        return ctx.w.globals.dom.baseEl.querySelector('.apexcharts-tooltip');
      }
    }, {
      key: "getElXCrosshairs",
      value: function getElXCrosshairs() {
        return this.w.globals.dom.baseEl.querySelector('.apexcharts-xcrosshairs');
      }
    }, {
      key: "getElGrid",
      value: function getElGrid() {
        return this.w.globals.dom.baseEl.querySelector('.apexcharts-grid');
      }
    }, {
      key: "drawTooltip",
      value: function drawTooltip(xyRatios) {
        var w = this.w;
        this.xyRatios = xyRatios;
        this.isXAxisTooltipEnabled = w.config.xaxis.tooltip.enabled && w.globals.axisCharts;
        this.yaxisTooltips = w.config.yaxis.map(function (y, i) {
          return y.show && y.tooltip.enabled && w.globals.axisCharts ? true : false;
        });
        this.allTooltipSeriesGroups = [];

        if (!w.globals.axisCharts) {
          this.showTooltipTitle = false;
        }

        var tooltipEl = document.createElement('div');
        tooltipEl.classList.add('apexcharts-tooltip');

        if (w.config.tooltip.cssClass) {
          tooltipEl.classList.add(w.config.tooltip.cssClass);
        }

        tooltipEl.classList.add("apexcharts-theme-".concat(this.tConfig.theme));
        w.globals.dom.elWrap.appendChild(tooltipEl);

        if (w.globals.axisCharts) {
          this.axesTooltip.drawXaxisTooltip();
          this.axesTooltip.drawYaxisTooltip();
          this.axesTooltip.setXCrosshairWidth();
          this.axesTooltip.handleYCrosshair();
          var xAxis = new XAxis(this.ctx);
          this.xAxisTicksPositions = xAxis.getXAxisTicksPositions();
        }


        if ((w.globals.comboCharts || this.tConfig.intersect || w.config.chart.type === 'rangeBar') && !this.tConfig.shared) {
          this.showOnIntersect = true;
        }

        if (w.config.markers.size === 0 || w.globals.markers.largestSize === 0) {

          this.marker.drawDynamicPoints(this);
        }


        if (w.globals.collapsedSeries.length === w.globals.series.length) return;
        this.dataPointsDividedHeight = w.globals.gridHeight / w.globals.dataPoints;
        this.dataPointsDividedWidth = w.globals.gridWidth / w.globals.dataPoints;

        if (this.showTooltipTitle) {
          this.tooltipTitle = document.createElement('div');
          this.tooltipTitle.classList.add('apexcharts-tooltip-title');
          this.tooltipTitle.style.fontFamily = this.tConfig.style.fontFamily || w.config.chart.fontFamily;
          this.tooltipTitle.style.fontSize = this.tConfig.style.fontSize;
          tooltipEl.appendChild(this.tooltipTitle);
        }

        var ttItemsCnt = w.globals.series.length;

        if ((w.globals.xyCharts || w.globals.comboCharts) && this.tConfig.shared) {
          if (!this.showOnIntersect) {
            ttItemsCnt = w.globals.series.length;
          } else {
            ttItemsCnt = 1;
          }
        }

        this.legendLabels = w.globals.dom.baseEl.querySelectorAll('.apexcharts-legend-text');
        this.ttItems = this.createTTElements(ttItemsCnt);
        this.addSVGEvents();
      }
    }, {
      key: "createTTElements",
      value: function createTTElements(ttItemsCnt) {
        var _this = this;

        var w = this.w;
        var ttItems = [];
        var tooltipEl = this.getElTooltip();

        var _loop = function _loop(i) {
          var gTxt = document.createElement('div');
          gTxt.classList.add('apexcharts-tooltip-series-group');
          gTxt.style.order = w.config.tooltip.inverseOrder ? ttItemsCnt - i : i + 1;

          if (_this.tConfig.shared && _this.tConfig.enabledOnSeries && Array.isArray(_this.tConfig.enabledOnSeries)) {
            if (_this.tConfig.enabledOnSeries.indexOf(i) < 0) {
              gTxt.classList.add('apexcharts-tooltip-series-group-hidden');
            }
          }

          var point = document.createElement('span');
          point.classList.add('apexcharts-tooltip-marker');
          point.style.backgroundColor = w.globals.colors[i];
          gTxt.appendChild(point);
          var gYZ = document.createElement('div');
          gYZ.classList.add('apexcharts-tooltip-text');
          gYZ.style.fontFamily = _this.tConfig.style.fontFamily || w.config.chart.fontFamily;
          gYZ.style.fontSize = _this.tConfig.style.fontSize;
          ['y', 'goals', 'z'].forEach(function (g) {
            var gValText = document.createElement('div');
            gValText.classList.add("apexcharts-tooltip-".concat(g, "-group"));
            var txtLabel = document.createElement('span');
            txtLabel.classList.add("apexcharts-tooltip-text-".concat(g, "-label"));
            gValText.appendChild(txtLabel);
            var txtValue = document.createElement('span');
            txtValue.classList.add("apexcharts-tooltip-text-".concat(g, "-value"));
            gValText.appendChild(txtValue);
            gYZ.appendChild(gValText);
          });
          gTxt.appendChild(gYZ);
          tooltipEl.appendChild(gTxt);
          ttItems.push(gTxt);
        };

        for (var i = 0; i < ttItemsCnt; i++) {
          _loop(i);
        }

        return ttItems;
      }
    }, {
      key: "addSVGEvents",
      value: function addSVGEvents() {
        var w = this.w;
        var type = w.config.chart.type;
        var tooltipEl = this.getElTooltip();
        var commonBar = !!(type === 'bar' || type === 'candlestick' || type === 'boxPlot' || type === 'rangeBar');
        var chartWithmarkers = type === 'area' || type === 'line' || type === 'scatter' || type === 'bubble' || type === 'radar';
        var hoverArea = w.globals.dom.Paper.node;
        var elGrid = this.getElGrid();

        if (elGrid) {
          this.seriesBound = elGrid.getBoundingClientRect();
        }

        var tooltipY = [];
        var tooltipX = [];
        var seriesHoverParams = {
          hoverArea: hoverArea,
          elGrid: elGrid,
          tooltipEl: tooltipEl,
          tooltipY: tooltipY,
          tooltipX: tooltipX,
          ttItems: this.ttItems
        };
        var points;

        if (w.globals.axisCharts) {
          if (chartWithmarkers) {
            points = w.globals.dom.baseEl.querySelectorAll(".apexcharts-series[data\\:longestSeries='true'] .apexcharts-marker");
          } else if (commonBar) {
            points = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series .apexcharts-bar-area, .apexcharts-series .apexcharts-candlestick-area, .apexcharts-series .apexcharts-boxPlot-area, .apexcharts-series .apexcharts-rangebar-area');
          } else if (type === 'heatmap' || type === 'treemap') {
            points = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series .apexcharts-heatmap, .apexcharts-series .apexcharts-treemap');
          }

          if (points && points.length) {
            for (var p = 0; p < points.length; p++) {
              tooltipY.push(points[p].getAttribute('cy'));
              tooltipX.push(points[p].getAttribute('cx'));
            }
          }
        }

        var validSharedChartTypes = w.globals.xyCharts && !this.showOnIntersect || w.globals.comboCharts && !this.showOnIntersect || commonBar && this.tooltipUtil.hasBars() && this.tConfig.shared;

        if (validSharedChartTypes) {
          this.addPathsEventListeners([hoverArea], seriesHoverParams);
        } else if (commonBar && !w.globals.comboCharts || chartWithmarkers && this.showOnIntersect) {
          this.addDatapointEventsListeners(seriesHoverParams);
        } else if (!w.globals.axisCharts || type === 'heatmap' || type === 'treemap') {
          var seriesAll = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series');
          this.addPathsEventListeners(seriesAll, seriesHoverParams);
        }

        if (this.showOnIntersect) {
          var lineAreaPoints = w.globals.dom.baseEl.querySelectorAll('.apexcharts-line-series .apexcharts-marker, .apexcharts-area-series .apexcharts-marker');

          if (lineAreaPoints.length > 0) {

            this.addPathsEventListeners(lineAreaPoints, seriesHoverParams);
          }


          if (this.tooltipUtil.hasBars() && !this.tConfig.shared) {
            this.addDatapointEventsListeners(seriesHoverParams);
          }
        }
      }
    }, {
      key: "drawFixedTooltipRect",
      value: function drawFixedTooltipRect() {
        var w = this.w;
        var tooltipEl = this.getElTooltip();
        var tooltipRect = tooltipEl.getBoundingClientRect();
        var ttWidth = tooltipRect.width + 10;
        var ttHeight = tooltipRect.height + 10;
        var x = this.tConfig.fixed.offsetX;
        var y = this.tConfig.fixed.offsetY;
        var fixed = this.tConfig.fixed.position.toLowerCase();

        if (fixed.indexOf('right') > -1) {
          x = x + w.globals.svgWidth - ttWidth + 10;
        }

        if (fixed.indexOf('bottom') > -1) {
          y = y + w.globals.svgHeight - ttHeight - 10;
        }

        tooltipEl.style.left = x + 'px';
        tooltipEl.style.top = y + 'px';
        return {
          x: x,
          y: y,
          ttWidth: ttWidth,
          ttHeight: ttHeight
        };
      }
    }, {
      key: "addDatapointEventsListeners",
      value: function addDatapointEventsListeners(seriesHoverParams) {
        var w = this.w;
        var points = w.globals.dom.baseEl.querySelectorAll('.apexcharts-series-markers .apexcharts-marker, .apexcharts-bar-area, .apexcharts-candlestick-area, .apexcharts-boxPlot-area, .apexcharts-rangebar-area');
        this.addPathsEventListeners(points, seriesHoverParams);
      }
    }, {
      key: "addPathsEventListeners",
      value: function addPathsEventListeners(paths, opts) {
        var self = this;

        var _loop2 = function _loop2(p) {
          var extendedOpts = {
            paths: paths[p],
            tooltipEl: opts.tooltipEl,
            tooltipY: opts.tooltipY,
            tooltipX: opts.tooltipX,
            elGrid: opts.elGrid,
            hoverArea: opts.hoverArea,
            ttItems: opts.ttItems
          };
          var events = ['mousemove', 'mouseup', 'touchmove', 'mouseout', 'touchend'];
          events.map(function (ev) {
            return paths[p].addEventListener(ev, self.onSeriesHover.bind(self, extendedOpts), {
              capture: false,
              passive: true
            });
          });
        };

        for (var p = 0; p < paths.length; p++) {
          _loop2(p);
        }
      }
      /*
       ** Check to see if the tooltips should be updated based on a mouse / touch event
       */

    }, {
      key: "onSeriesHover",
      value: function onSeriesHover(opt, e) {
        var _this2 = this;


        var targetDelay = 100;
        var timeSinceLastUpdate = Date.now() - this.lastHoverTime;

        if (timeSinceLastUpdate >= targetDelay) {


          this.seriesHover(opt, e);
        } else {


          clearTimeout(this.seriesHoverTimeout);

          this.seriesHoverTimeout = setTimeout(function () {
            _this2.seriesHover(opt, e);
          }, targetDelay - timeSinceLastUpdate);
        }
      }
      /*
       ** The actual series hover function
       */

    }, {
      key: "seriesHover",
      value: function seriesHover(opt, e) {
        var _this3 = this;

        this.lastHoverTime = Date.now();
        var chartGroups = [];
        var w = this.w;

        if (w.config.chart.group) {
          chartGroups = this.ctx.getGroupedCharts();
        }

        if (w.globals.axisCharts && (w.globals.minX === -Infinity && w.globals.maxX === Infinity || w.globals.dataPoints === 0)) {
          return;
        }

        if (chartGroups.length) {
          chartGroups.forEach(function (ch) {
            var tooltipEl = _this3.getElTooltip(ch);

            var newOpts = {
              paths: opt.paths,
              tooltipEl: tooltipEl,
              tooltipY: opt.tooltipY,
              tooltipX: opt.tooltipX,
              elGrid: opt.elGrid,
              hoverArea: opt.hoverArea,
              ttItems: ch.w.globals.tooltip.ttItems
            };

            if (ch.w.globals.minX === _this3.w.globals.minX && ch.w.globals.maxX === _this3.w.globals.maxX) {
              ch.w.globals.tooltip.seriesHoverByContext({
                chartCtx: ch,
                ttCtx: ch.w.globals.tooltip,
                opt: newOpts,
                e: e
              });
            }
          });
        } else {
          this.seriesHoverByContext({
            chartCtx: this.ctx,
            ttCtx: this.w.globals.tooltip,
            opt: opt,
            e: e
          });
        }
      }
    }, {
      key: "seriesHoverByContext",
      value: function seriesHoverByContext(_ref) {
        var chartCtx = _ref.chartCtx,
            ttCtx = _ref.ttCtx,
            opt = _ref.opt,
            e = _ref.e;
        var w = chartCtx.w;
        var tooltipEl = this.getElTooltip();
        if (!tooltipEl) return;

        ttCtx.tooltipRect = {
          x: 0,
          y: 0,
          ttWidth: tooltipEl.getBoundingClientRect().width,
          ttHeight: tooltipEl.getBoundingClientRect().height
        };
        ttCtx.e = e;

        if (ttCtx.tooltipUtil.hasBars() && !w.globals.comboCharts && !ttCtx.isBarShared) {
          if (this.tConfig.onDatasetHover.highlightDataSeries) {
            var series = new Series(chartCtx);
            series.toggleSeriesOnHover(e, e.target.parentNode);
          }
        }

        if (ttCtx.fixedTooltip) {
          ttCtx.drawFixedTooltipRect();
        }

        if (w.globals.axisCharts) {
          ttCtx.axisChartsTooltips({
            e: e,
            opt: opt,
            tooltipRect: ttCtx.tooltipRect
          });
        } else {

          ttCtx.nonAxisChartsTooltips({
            e: e,
            opt: opt,
            tooltipRect: ttCtx.tooltipRect
          });
        }
      }

    }, {
      key: "axisChartsTooltips",
      value: function axisChartsTooltips(_ref2) {
        var e = _ref2.e,
            opt = _ref2.opt;
        var w = this.w;
        var x, y;
        var seriesBound = opt.elGrid.getBoundingClientRect();
        var clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        var clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
        this.clientY = clientY;
        this.clientX = clientX;
        w.globals.capturedSeriesIndex = -1;
        w.globals.capturedDataPointIndex = -1;

        if (clientY < seriesBound.top || clientY > seriesBound.top + seriesBound.height) {
          this.handleMouseOut(opt);
          return;
        }

        if (Array.isArray(this.tConfig.enabledOnSeries) && !w.config.tooltip.shared) {
          var index = parseInt(opt.paths.getAttribute('index'), 10);

          if (this.tConfig.enabledOnSeries.indexOf(index) < 0) {
            this.handleMouseOut(opt);
            return;
          }
        }

        var tooltipEl = this.getElTooltip();
        var xcrosshairs = this.getElXCrosshairs();
        var isStickyTooltip = w.globals.xyCharts || w.config.chart.type === 'bar' && !w.globals.isBarHorizontal && this.tooltipUtil.hasBars() && this.tConfig.shared || w.globals.comboCharts && this.tooltipUtil.hasBars();

        if (e.type === 'mousemove' || e.type === 'touchmove' || e.type === 'mouseup') {

          if (w.globals.collapsedSeries.length + w.globals.ancillaryCollapsedSeries.length === w.globals.series.length) {
            return;
          }

          if (xcrosshairs !== null) {
            xcrosshairs.classList.add('apexcharts-active');
          }

          var hasYAxisTooltip = this.yaxisTooltips.filter(function (b) {
            return b === true;
          });

          if (this.ycrosshairs !== null && hasYAxisTooltip.length) {
            this.ycrosshairs.classList.add('apexcharts-active');
          }

          if (isStickyTooltip && !this.showOnIntersect) {
            this.handleStickyTooltip(e, clientX, clientY, opt);
          } else {
            if (w.config.chart.type === 'heatmap' || w.config.chart.type === 'treemap') {
              var markerXY = this.intersect.handleHeatTreeTooltip({
                e: e,
                opt: opt,
                x: x,
                y: y,
                type: w.config.chart.type
              });
              x = markerXY.x;
              y = markerXY.y;
              tooltipEl.style.left = x + 'px';
              tooltipEl.style.top = y + 'px';
            } else {
              if (this.tooltipUtil.hasBars()) {
                this.intersect.handleBarTooltip({
                  e: e,
                  opt: opt
                });
        nt} realIndex - current iterating i
       * @param {int} j - current iterating series's j index
       * @return {string} pathFrom is the string which will be appended in animations
       **/

    }, {
      key: "getPreviousPath",
      value: function getPreviousPath(realIndex, j) {
        var w = this.w;
        var pathFrom;

        for (var pp = 0; pp < w.globals.previousPaths.length; pp++) {
          var gpp = w.globals.previousPaths[pp];

          if (gpp.paths && gpp.paths.length > 0 && parseInt(gpp.realIndex, 10) === parseInt(realIndex, 10)) {
            if (typeof w.globals.previousPaths[pp].paths[j] !== 'undefined') {
              pathFrom = w.globals.previousPaths[pp].paths[j].d;
            }
          }
        }

        return pathFrom;
      }
    }]);

    return Bar;
  }();

  /**
   * ApexCharts BarStacked Class responsible for drawing both Stacked Columns and Bars.
   *
   * @module BarStacked
   * The whole calculation for stacked bar/column is different from normal bar/column,
   * hence it makes sense to derive a new class for it extending most of the props of Parent Bar
   **/

  var BarStacked = /*#__PURE__*/function (_Bar) {
    _inherits(BarStacked, _Bar);

    var _super = _createSuper(BarStacked);

    function BarStacked() {
      _classCallCheck(this, BarStacked);

      return _super.apply(this, arguments);
    }

    _createClass(BarStacked, [{
      key: "draw",
      value: function draw(series, seriesIndex) {
        var _this = this;

        var w = this.w;
        this.graphics = new Graphics(this.ctx);
        this.bar = new Bar(this.ctx, this.xyRatios);
        var coreUtils = new CoreUtils(this.ctx, w);
        series = coreUtils.getLogSeries(series);
        this.yRatio = coreUtils.getLogYRatios(this.yRatio);
        this.barHelpers.initVariables(series);

        if (w.config.chart.stackType === '100%') {
          series = w.globals.seriesPercent.slice();
        }

        this.series = series;
        this.totalItems = 0;
        this.prevY = [];

        this.prevX = [];

        this.prevYF = [];

        this.prevXF = [];

        this.prevYVal = [];

        this.prevXVal = [];

        this.xArrj = [];

        this.xArrjF = [];

        this.xArrjVal = [];

        this.yArrj = [];

        this.yArrjF = [];

        this.yArrjVal = [];

        for (var sl = 0; sl < series.length; sl++) {
          if (series[sl].length > 0) {
            this.totalItems += series[sl].length;
          }
        }

        var ret = this.graphics.group({
          class: 'apexcharts-bar-series apexcharts-plot-series'
        });
        var x = 0;
        var y = 0;

        var _loop = function _loop(i, bc) {
          var xDivision = void 0;

          var yDivision = void 0;

          var zeroH = void 0;

          var zeroW = void 0;

          var xArrValues = [];
          var yArrValues = [];
          var realIndex = w.globals.comboCharts ? seriesIndex[i] : i;

          if (_this.yRatio.length > 1) {
            _this.yaxisIndex = realIndex;
          }

          _this.isReversed = w.config.yaxis[_this.yaxisIndex] && w.config.yaxis[_this.yaxisIndex].reversed;

          var elSeries = _this.graphics.group({
            class: "apexcharts-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[realIndex]),
            rel: i + 1,
            'data:realIndex': realIndex
          });

          _this.ctx.series.addCollapsedClassToSeries(elSeries, realIndex);


          var elDataLabelsWrap = _this.graphics.group({
            class: 'apexcharts-datalabels',
            'data:realIndex': realIndex
          });

          var elGoalsMarkers = _this.graphics.group({
            class: 'apexcharts-bar-goals-markers',
            style: "pointer-events: none"
          });

          var barHeight = 0;
          var barWidth = 0;

          var initPositions = _this.initialPositions(x, y, xDivision, yDivision, zeroH, zeroW);

          y = initPositions.y;
          barHeight = initPositions.barHeight;
          yDivision = initPositions.yDivision;
          zeroW = initPositions.zeroW;
          x = initPositions.x;
          barWidth = initPositions.barWidth;
          xDivision = initPositions.xDivision;
          zeroH = initPositions.zeroH;
          _this.yArrj = [];
          _this.yArrjF = [];
          _this.yArrjVal = [];
          _this.xArrj = [];
          _this.xArrjF = [];
          _this.xArrjVal = [];






          if (_this.prevY.length === 1 && _this.prevY[0].every(function (val) {
            return isNaN(val);
          })) {

            _this.prevY[0] = _this.prevY[0].map(function (val) {
              return zeroH;
            });

            _this.prevYF[0] = _this.prevYF[0].map(function (val) {
              return 0;
            });
          }

          for (var j = 0; j < w.globals.dataPoints; j++) {
            var strokeWidth = _this.barHelpers.getStrokeWidth(i, j, realIndex);

            var commonPathOpts = {
              indexes: {
                i: i,
                j: j,
                realIndex: realIndex,
                bc: bc
              },
              strokeWidth: strokeWidth,
              x: x,
              y: y,
              elSeries: elSeries
            };
            var paths = null;

            if (_this.isHorizontal) {
              paths = _this.drawStackedBarPaths(_objectSpread2(_objectSpread2({}, commonPathOpts), {}, {
                zeroW: zeroW,
                barHeight: barHeight,
                yDivision: yDivision
              }));
              barWidth = _this.series[i][j] / _this.invertedYRatio;
            } else {
              paths = _this.drawStackedColumnPaths(_objectSpread2(_objectSpread2({}, commonPathOpts), {}, {
                xDivision: xDivision,
                barWidth: barWidth,
                zeroH: zeroH
              }));
              barHeight = _this.series[i][j] / _this.yRatio[_this.yaxisIndex];
            }

            var barGoalLine = _this.barHelpers.drawGoalLine({
              barXPosition: paths.barXPosition,
              barYPosition: paths.barYPosition,
              goalX: paths.goalX,
              goalY: paths.goalY,
              barHeight: barHeight,
              barWidth: barWidth
            });

            if (barGoalLine) {
              elGoalsMarkers.add(barGoalLine);
            }

            y = paths.y;
            x = paths.x;
            xArrValues.push(x);
            yArrValues.push(y);

            var pathFill = _this.barHelpers.getPathFillColor(series, i, j, realIndex);

            elSeries = _this.renderSeries({
              realIndex: realIndex,
              pathFill: pathFill,
              j: j,
              i: i,
              pathFrom: paths.pathFrom,
              pathTo: paths.pathTo,
              strokeWidth: strokeWidth,
              elSeries: elSeries,
              x: x,
              y: y,
              series: series,
              barHeight: barHeight,
              barWidth: barWidth,
              elDataLabelsWrap: elDataLabelsWrap,
              elGoalsMarkers: elGoalsMarkers,
              type: 'bar',
              visibleSeries: 0
            });
          }


          w.globals.seriesXvalues[realIndex] = xArrValues;
          w.globals.seriesYvalues[realIndex] = yArrValues;

          _this.prevY.push(_this.yArrj);

          _this.prevYF.push(_this.yArrjF);

          _this.prevYVal.push(_this.yArrjVal);

          _this.prevX.push(_this.xArrj);

          _this.prevXF.push(_this.xArrjF);

          _this.prevXVal.push(_this.xArrjVal);

          ret.add(elSeries);
        };

        for (var i = 0, bc = 0; i < series.length; i++, bc++) {
          _loop(i, bc);
        }

        return ret;
      }
    }, {
      key: "initialPositions",
      value: function initialPositions(x, y, xDivision, yDivision, zeroH, zeroW) {
        var w = this.w;
        var barHeight, barWidth;

        if (this.isHorizontal) {

          yDivision = w.globals.gridHeight / w.globals.dataPoints;
          barHeight = yDivision;
          barHeight = barHeight * parseInt(w.config.plotOptions.bar.barHeight, 10) / 100;
          zeroW = this.baseLineInvertedY + w.globals.padHorizontal + (this.isReversed ? w.globals.gridWidth : 0) - (this.isReversed ? this.baseLineInvertedY * 2 : 0);

          y = (yDivision - barHeight) / 2;
        } else {

          xDivision = w.globals.gridWidth / w.globals.dataPoints;
          barWidth = xDivision;

          if (w.globals.isXNumeric && w.globals.dataPoints > 1) {

            xDivision = w.globals.minXDiff / this.xRatio;
            barWidth = xDivision * parseInt(this.barOptions.columnWidth, 10) / 100;
          } else {
            barWidth = barWidth * parseInt(w.config.plotOptions.bar.columnWidth, 10) / 100;
          }

          zeroH = w.globals.gridHeight - this.baseLineY[this.yaxisIndex] - (this.isReversed ? w.globals.gridHeight : 0) + (this.isReversed ? this.baseLineY[this.yaxisIndex] * 2 : 0);

          x = w.globals.padHorizontal + (xDivision - barWidth) / 2;
        }

        return {
          x: x,
          y: y,
          yDivision: yDivision,
          xDivision: xDivision,
          barHeight: barHeight,
          barWidth: barWidth,
          zeroH: zeroH,
          zeroW: zeroW
        };
      }
    }, {
      key: "drawStackedBarPaths",
      value: function drawStackedBarPaths(_ref) {
        var indexes = _ref.indexes,
            barHeight = _ref.barHeight,
            strokeWidth = _ref.strokeWidth,
            zeroW = _ref.zeroW,
            x = _ref.x,
            y = _ref.y,
            yDivision = _ref.yDivision,
            elSeries = _ref.elSeries;
        var w = this.w;
        var barYPosition = y;
        var barXPosition;
        var i = indexes.i;
        var j = indexes.j;
        var prevBarW = 0;

        for (var k = 0; k < this.prevXF.length; k++) {
          prevBarW = prevBarW + this.prevXF[k][j];
        }

        if (i > 0) {
          var bXP = zeroW;

          if (this.prevXVal[i - 1][j] < 0) {
            bXP = this.series[i][j] >= 0 ? this.prevX[i - 1][j] + prevBarW - (this.isReversed ? prevBarW : 0) * 2 : this.prevX[i - 1][j];
          } else if (this.prevXVal[i - 1][j] >= 0) {
            bXP = this.series[i][j] >= 0 ? this.prevX[i - 1][j] : this.prevX[i - 1][j] - prevBarW + (this.isReversed ? prevBarW : 0) * 2;
          }

          barXPosition = bXP;
        } else {

          barXPosition = zeroW;
        }

        if (this.series[i][j] === null) {
          x = barXPosition;
        } else {
          x = barXPosition + this.series[i][j] / this.invertedYRatio - (this.isReversed ? this.series[i][j] / this.invertedYRatio : 0) * 2;
        }

        var paths = this.barHelpers.getBarpaths({
          barYPosition: barYPosition,
          barHeight: barHeight,
          x1: barXPosition,
          x2: x,
          strokeWidth: strokeWidth,
          series: this.series,
          realIndex: indexes.realIndex,
          i: i,
          j: j,
          w: w
        });
        this.barHelpers.barBackground({
          j: j,
          i: i,
          y1: barYPosition,
          y2: barHeight,
          elSeries: elSeries
        });
        y = y + yDivision;
        return {
          pathTo: paths.pathTo,
          pathFrom: paths.pathFrom,
          goalX: this.barHelpers.getGoalValues('x', zeroW, null, i, j),
          barYPosition: barYPosition,
          x: x,
          y: y
        };
      }
    }, {
      key: "drawStackedColumnPaths",
      value: function drawStackedColumnPaths(_ref2) {
        var indexes = _ref2.indexes,
            x = _ref2.x,
            y = _ref2.y,
            xDivision = _ref2.xDivision,
            barWidth = _ref2.barWidth,
            zeroH = _ref2.zeroH;
            _ref2.strokeWidth;
            var elSeries = _ref2.elSeries;
        var w = this.w;
        var i = indexes.i;
        var j = indexes.j;
        var bc = indexes.bc;

        if (w.globals.isXNumeric) {
          var seriesVal = w.globals.seriesX[i][j];
          if (!seriesVal) seriesVal = 0;
          x = (seriesVal - w.globals.minX) / this.xRatio - barWidth / 2;
        }

        var barXPosition = x;
        var barYPosition;
        var prevBarH = 0;

        for (var k = 0; k < this.prevYF.length; k++) {


          prevBarH = prevBarH + (!isNaN(this.prevYF[k][j]) ? this.prevYF[k][j] : 0);
        }

        if (i > 0 && !w.globals.isXNumeric || i > 0 && w.globals.isXNumeric && w.globals.seriesX[i - 1][j] === w.globals.seriesX[i][j]) {
          var bYP;
          var prevYValue;
          var p = Math.min(this.yRatio.length + 1, i + 1);

          if (this.prevY[i - 1] !== undefined) {
            for (var ii = 1; ii < p; ii++) {
              if (!isNaN(this.prevY[i - ii][j])) {

                prevYValue = this.prevY[i - ii][j];

                break;
              }
            }
          }

          for (var _ii = 1; _ii < p; _ii++) {

            if (this.prevYVal[i - _ii][j] < 0) {
              bYP = this.series[i][j] >= 0 ? prevYValue - prevBarH + (this.isReversed ? prevBarH : 0) * 2 : prevYValue;

              break;
            } else if (this.prevYVal[i - _ii][j] >= 0) {
              bYP = this.series[i][j] >= 0 ? prevYValue : prevYValue + prevBarH - (this.isReversed ? prevBarH : 0) * 2;

              break;
            }
          }

          if (typeof bYP === 'undefined') bYP = w.globals.gridHeight;


          if (this.prevYF[0].every(function (val) {
            return val === 0;
          }) && this.prevYF.slice(1, i).every(function (arr) {
            return arr.every(function (val) {
              return isNaN(val);
            });
          })) {
            barYPosition = zeroH;
          } else {

            barYPosition = bYP;
          }
        } else {

          barYPosition = zeroH;
        }

        if (this.series[i][j]) {
          y = barYPosition - this.series[i][j] / this.yRatio[this.yaxisIndex] + (this.isReversed ? this.series[i][j] / this.yRatio[this.yaxisIndex] : 0) * 2;
        } else {

          y = barYPosition;
        }

        var paths = this.barHelpers.getColumnPaths({
          barXPosition: barXPosition,
          barWidth: barWidth,
          y1: barYPosition,
          y2: y,
          yRatio: this.yRatio[this.yaxisIndex],
          strokeWidth: this.strokeWidth,
          series: this.series,
          realIndex: indexes.realIndex,
          i: i,
          j: j,
          w: w
        });
        this.barHelpers.barBackground({
          bc: bc,
          j: j,
          i: i,
          x1: barXPosition,
          x2: barWidth,
          elSeries: elSeries
        });
        x = x + xDivision;
        return {
          pathTo: paths.pathTo,
          pathFrom: paths.pathFrom,
          goalY: this.barHelpers.getGoalValues('y', null, zeroH, i, j),
          barXPosition: barXPosition,
          x: w.globals.isXNumeric ? x - xDivision : x,
          y: y
        };
      }
    }]);

    return BarStacked;
  }(Bar);

  /**
   * ApexCharts BoxCandleStick Class responsible for drawing both Stacked Columns and Bars.
   *
   * @module BoxCandleStick
   **/

  var BoxCandleStick = /*#__PURE__*/function (_Bar) {
    _inherits(BoxCandleStick, _Bar);

    var _super = _createSuper(BoxCandleStick);

    function BoxCandleStick() {
      _classCallCheck(this, BoxCandleStick);

      return _super.apply(this, arguments);
    }

    _createClass(BoxCandleStick, [{
      key: "draw",
      value: function draw(series, ctype, seriesIndex) {
        var _this = this;

        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var type = w.globals.comboCharts ? ctype : w.config.chart.type;
        var fill = new Fill(this.ctx);
        this.candlestickOptions = this.w.config.plotOptions.candlestick;
        this.boxOptions = this.w.config.plotOptions.boxPlot;
        this.isHorizontal = w.config.plotOptions.bar.horizontal;
        var coreUtils = new CoreUtils(this.ctx, w);
        series = coreUtils.getLogSeries(series);
        this.series = series;
        this.yRatio = coreUtils.getLogYRatios(this.yRatio);
        this.barHelpers.initVariables(series);
        var ret = graphics.group({
          class: "apexcharts-".concat(type, "-series apexcharts-plot-series")
        });

        var _loop = function _loop(i) {
          _this.isBoxPlot = w.config.chart.type === 'boxPlot' || w.config.series[i].type === 'boxPlot';
          var x = void 0,
              y = void 0,
              xDivision = void 0,

          yDivision = void 0,

          zeroH = void 0,

          zeroW = void 0;

          var yArrj = [];

          var xArrj = [];

          var realIndex = w.globals.comboCharts ? seriesIndex[i] : i;

          var elSeries = graphics.group({
            class: "apexcharts-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[realIndex]),
            rel: i + 1,
            'data:realIndex': realIndex
          });

          _this.ctx.series.addCollapsedClassToSeries(elSeries, realIndex);

          if (series[i].length > 0) {
            _this.visibleI = _this.visibleI + 1;
          }

          var barHeight = 0;
          var barWidth = 0;

          if (_this.yRatio.length > 1) {
            _this.yaxisIndex = realIndex;
          }

          var initPositions = _this.barHelpers.initialPositions();

          y = initPositions.y;
          barHeight = initPositions.barHeight;
          yDivision = initPositions.yDivision;
          zeroW = initPositions.zeroW;
          x = initPositions.x;
          barWidth = initPositions.barWidth;
          xDivision = initPositions.xDivision;
          zeroH = initPositions.zeroH;
          xArrj.push(x + barWidth / 2);

          var elDataLabelsWrap = graphics.group({
            class: 'apexcharts-datalabels',
            'data:realIndex': realIndex
          });

          var _loop2 = function _loop2(j) {
            var strokeWidth = _this.barHelpers.getStrokeWidth(i, j, realIndex);

            var paths = null;
            var pathsParams = {
              indexes: {
                i: i,
                j: j,
                realIndex: realIndex
              },
              x: x,
              y: y,
              strokeWidth: strokeWidth,
              elSeries: elSeries
            };

            if (_this.isHorizontal) {
              paths = _this.drawHorizontalBoxPaths(_objectSpread2(_objectSpread2({}, pathsParams), {}, {
                yDivision: yDivision,
                barHeight: barHeight,
                zeroW: zeroW
              }));
            } else {
              paths = _this.drawVerticalBoxPaths(_objectSpread2(_objectSpread2({}, pathsParams), {}, {
                xDivision: xDivision,
                barWidth: barWidth,
                zeroH: zeroH
              }));
            }

            y = paths.y;
            x = paths.x;

            if (j > 0) {
              xArrj.push(x + barWidth / 2);
            }

            yArrj.push(y);
            paths.pathTo.forEach(function (pathTo, pi) {
              var lineFill = !_this.isBoxPlot && _this.candlestickOptions.wick.useFillColor ? paths.color[pi] : w.globals.stroke.colors[i];
              var pathFill = fill.fillPath({
                seriesNumber: realIndex,
                dataPointIndex: j,
                color: paths.color[pi],
                value: series[i][j]
              });

              _this.renderSeries({
                realIndex: realIndex,
                pathFill: pathFill,
                lineFill: lineFill,
                j: j,
                i: i,
                pathFrom: paths.pathFrom,
                pathTo: pathTo,
                strokeWidth: strokeWidth,
                elSeries: elSeries,
                x: x,
                y: y,
                series: series,
                barHeight: barHeight,
                barWidth: barWidth,
                elDataLabelsWrap: elDataLabelsWrap,
                visibleSeries: _this.visibleI,
                type: w.config.chart.type
              });
            });
          };

          for (var j = 0; j < w.globals.dataPoints; j++) {
            _loop2(j);
          }


          w.globals.seriesXvalues[realIndex] = xArrj;
          w.globals.seriesYvalues[realIndex] = yArrj;
          ret.add(elSeries);
        };

        for (var i = 0; i < series.length; i++) {
          _loop(i);
        }

        return ret;
      }
    }, {
      key: "drawVerticalBoxPaths",
      value: function drawVerticalBoxPaths(_ref) {
        var indexes = _ref.indexes,
            x = _ref.x;
            _ref.y;
            var xDivision = _ref.xDivision,
            barWidth = _ref.barWidth,
            zeroH = _ref.zeroH,
            strokeWidth = _ref.strokeWidth;
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var i = indexes.i;
        var j = indexes.j;
        var isPositive = true;
        var colorPos = w.config.plotOptions.candlestick.colors.upward;
        var colorNeg = w.config.plotOptions.candlestick.colors.downward;
        var color = '';

        if (this.isBoxPlot) {
          color = [this.boxOptions.colors.lower, this.boxOptions.colors.upper];
        }

        var yRatio = this.yRatio[this.yaxisIndex];
        var realIndex = indexes.realIndex;
        var ohlc = this.getOHLCValue(realIndex, j);
        var l1 = zeroH;
        var l2 = zeroH;

        if (ohlc.o > ohlc.c) {
          isPositive = false;
        }

        var y1 = Math.min(ohlc.o, ohlc.c);
        var y2 = Math.max(ohlc.o, ohlc.c);
        var m = ohlc.m;

        if (w.globals.isXNumeric) {
          x = (w.globals.seriesX[realIndex][j] - w.globals.minX) / this.xRatio - barWidth / 2;
        }

        var barXPosition = x + barWidth * this.visibleI;

        if (typeof this.series[i][j] === 'undefined' || this.series[i][j] === null) {
          y1 = zeroH;
          y2 = zeroH;
        } else {
          y1 = zeroH - y1 / yRatio;
          y2 = zeroH - y2 / yRatio;
          l1 = zeroH - ohlc.h / yRatio;
          l2 = zeroH - ohlc.l / yRatio;
          m = zeroH - ohlc.m / yRatio;
        }

        var pathTo = graphics.move(barXPosition, zeroH);
        var pathFrom = graphics.move(barXPosition + barWidth / 2, y1);

        if (w.globals.previousPaths.length > 0) {
          pathFrom = this.getPreviousPath(realIndex, j, true);
        }

        if (this.isBoxPlot) {
          pathTo = [graphics.move(barXPosition, y1) + graphics.line(barXPosition + barWidth / 2, y1) + graphics.line(barXPosition + barWidth / 2, l1) + graphics.line(barXPosition + barWidth / 4, l1) + graphics.line(barXPosition + barWidth - barWidth / 4, l1) + graphics.line(barXPosition + barWidth / 2, l1) + graphics.line(barXPosition + barWidth / 2, y1) + graphics.line(barXPosition + barWidth, y1) + graphics.line(barXPosition + barWidth, m) + graphics.line(barXPosition, m) + graphics.line(barXPosition, y1 + strokeWidth / 2), graphics.move(barXPosition, m) + graphics.line(barXPosition + barWidth, m) + graphics.line(barXPosition + barWidth, y2) + graphics.line(barXPosition + barWidth / 2, y2) + graphics.line(barXPosition + barWidth / 2, l2) + graphics.line(barXPosition + barWidth - barWidth / 4, l2) + graphics.line(barXPosition + barWidth / 4, l2) + graphics.line(barXPosition + barWidth / 2, l2) + graphics.line(barXPosition + barWidth / 2, y2) + graphics.line(barXPosition, y2) + graphics.line(barXPosition, m) + 'z'];
        } else {

          pathTo = [graphics.move(barXPosition, y2) + graphics.line(barXPosition + barWidth / 2, y2) + graphics.line(barXPosition + barWidth / 2, l1) + graphics.line(barXPosition + barWidth / 2, y2) + graphics.line(barXPosition + barWidth, y2) + graphics.line(barXPosition + barWidth, y1) + graphics.line(barXPosition + barWidth / 2, y1) + graphics.line(barXPosition + barWidth / 2, l2) + graphics.line(barXPosition + barWidth / 2, y1) + graphics.line(barXPosition, y1) + graphics.line(barXPosition, y2 - strokeWidth / 2)];
        }

        pathFrom = pathFrom + graphics.move(barXPosition, y1);

        if (!w.globals.isXNumeric) {
          x = x + xDivision;
        }

        return {
          pathTo: pathTo,
          pathFrom: pathFrom,
          x: x,
          y: y2,
          barXPosition: barXPosition,
          color: this.isBoxPlot ? color : isPositive ? [colorPos] : [colorNeg]
        };
      }
    }, {
      key: "drawHorizontalBoxPaths",
      value: function drawHorizontalBoxPaths(_ref2) {
        var indexes = _ref2.indexes;
            _ref2.x;
            var y = _ref2.y,
            yDivision = _ref2.yDivision,
            barHeight = _ref2.barHeight,
            zeroW = _ref2.zeroW,
            strokeWidth = _ref2.strokeWidth;
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var i = indexes.i;
        var j = indexes.j;
        var color = this.boxOptions.colors.lower;

        if (this.isBoxPlot) {
          color = [this.boxOptions.colors.lower, this.boxOptions.colors.upper];
        }

        var yRatio = this.invertedYRatio;
        var realIndex = indexes.realIndex;
        var ohlc = this.getOHLCValue(realIndex, j);
        var l1 = zeroW;
        var l2 = zeroW;
        var x1 = Math.min(ohlc.o, ohlc.c);
        var x2 = Math.max(ohlc.o, ohlc.c);
        var m = ohlc.m;

        if (w.globals.isXNumeric) {
          y = (w.globals.seriesX[realIndex][j] - w.globals.minX) / this.invertedXRatio - barHeight / 2;
        }

        var barYPosition = y + barHeight * this.visibleI;

        if (typeof this.series[i][j] === 'undefined' || this.series[i][j] === null) {
          x1 = zeroW;
          x2 = zeroW;
        } else {
          x1 = zeroW + x1 / yRatio;
          x2 = zeroW + x2 / yRatio;
          l1 = zeroW + ohlc.h / yRatio;
          l2 = zeroW + ohlc.l / yRatio;
          m = zeroW + ohlc.m / yRatio;
        }

        var pathTo = graphics.move(zeroW, barYPosition);
        var pathFrom = graphics.move(x1, barYPosition + barHeight / 2);

        if (w.globals.previousPaths.length > 0) {
          pathFrom = this.getPreviousPath(realIndex, j, true);
        }

        pathTo = [graphics.move(x1, barYPosition) + graphics.line(x1, barYPosition + barHeight / 2) + graphics.line(l1, barYPosition + barHeight / 2) + graphics.line(l1, barYPosition + barHeight / 2 - barHeight / 4) + graphics.line(l1, barYPosition + barHeight / 2 + barHeight / 4) + graphics.line(l1, barYPosition + barHeight / 2) + graphics.line(x1, barYPosition + barHeight / 2) + graphics.line(x1, barYPosition + barHeight) + graphics.line(m, barYPosition + barHeight) + graphics.line(m, barYPosition) + graphics.line(x1 + strokeWidth / 2, barYPosition), graphics.move(m, barYPosition) + graphics.line(m, barYPosition + barHeight) + graphics.line(x2, barYPosition + barHeight) + graphics.line(x2, barYPosition + barHeight / 2) + graphics.line(l2, barYPosition + barHeight / 2) + graphics.line(l2, barYPosition + barHeight - barHeight / 4) + graphics.line(l2, barYPosition + barHeight / 4) + graphics.line(l2, barYPosition + barHeight / 2) + graphics.line(x2, barYPosition + barHeight / 2) + graphics.line(x2, barYPosition) + graphics.line(m, barYPosition) + 'z'];
        pathFrom = pathFrom + graphics.move(x1, barYPosition);

        if (!w.globals.isXNumeric) {
          y = y + yDivision;
        }

        return {
          pathTo: pathTo,
          pathFrom: pathFrom,
          x: x2,
          y: y,
          barYPosition: barYPosition,
          color: color
        };
      }
    }, {
      key: "getOHLCValue",
      value: function getOHLCValue(i, j) {
        var w = this.w;
        return {
          o: this.isBoxPlot ? w.globals.seriesCandleH[i][j] : w.globals.seriesCandleO[i][j],
          h: this.isBoxPlot ? w.globals.seriesCandleO[i][j] : w.globals.seriesCandleH[i][j],
          m: w.globals.seriesCandleM[i][j],
          l: this.isBoxPlot ? w.globals.seriesCandleC[i][j] : w.globals.seriesCandleL[i][j],
          c: this.isBoxPlot ? w.globals.seriesCandleL[i][j] : w.globals.seriesCandleC[i][j]
        };
      }
    }]);

    return BoxCandleStick;
  }(Bar);

  var TreemapHelpers = /*#__PURE__*/function () {
    function TreemapHelpers(ctx) {
      _classCallCheck(this, TreemapHelpers);

      this.ctx = ctx;
      this.w = ctx.w;
    }

    _createClass(TreemapHelpers, [{
      key: "checkColorRange",
      value: function checkColorRange() {
        var w = this.w;
        var negRange = false;
        var chartOpts = w.config.plotOptions[w.config.chart.type];

        if (chartOpts.colorScale.ranges.length > 0) {
          chartOpts.colorScale.ranges.map(function (range, index) {
            if (range.from <= 0) {
              negRange = true;
            }
          });
        }

        return negRange;
      }
    }, {
      key: "getShadeColor",
      value: function getShadeColor(chartType, i, j, negRange) {
        var w = this.w;
        var colorShadePercent = 1;
        var shadeIntensity = w.config.plotOptions[chartType].shadeIntensity;
        var colorProps = this.determineColor(chartType, i, j);

        if (w.globals.hasNegs || negRange) {
          if (w.config.plotOptions[chartType].reverseNegativeShade) {
            if (colorProps.percent < 0) {
              colorShadePercent = colorProps.percent / 100 * (shadeIntensity * 1.25);
            } else {
              colorShadePercent = (1 - colorProps.percent / 100) * (shadeIntensity * 1.25);
            }
          } else {
            if (colorProps.percent <= 0) {
              colorShadePercent = 1 - (1 + colorProps.percent / 100) * shadeIntensity;
            } else {
              colorShadePercent = (1 - colorProps.percent / 100) * shadeIntensity;
            }
          }
        } else {
          colorShadePercent = 1 - colorProps.percent / 100;

          if (chartType === 'treemap') {
            colorShadePercent = (1 - colorProps.percent / 100) * (shadeIntensity * 1.25);
          }
        }

        var color = colorProps.color;
        var utils = new Utils$1();

        if (w.config.plotOptions[chartType].enableShades) {
          if (this.w.config.theme.mode === 'dark') {
            color = Utils$1.hexToRgba(utils.shadeColor(colorShadePercent * -1, colorProps.color), w.config.fill.opacity);
          } else {
            color = Utils$1.hexToRgba(utils.shadeColor(colorShadePercent, colorProps.color), w.config.fill.opacity);
          }
        }

        return {
          color: color,
          colorProps: colorProps
        };
      }
    }, {
      key: "determineColor",
      value: function determineColor(chartType, i, j) {
        var w = this.w;
        var val = w.globals.series[i][j];
        var chartOpts = w.config.plotOptions[chartType];
        var seriesNumber = chartOpts.colorScale.inverse ? j : i;

        if (chartOpts.distributed && w.config.chart.type === 'treemap') {
          seriesNumber = j;
        }

        var color = w.globals.colors[seriesNumber];
        var foreColor = null;
        var min = Math.min.apply(Math, _toConsumableArray(w.globals.series[i]));
        var max = Math.max.apply(Math, _toConsumableArray(w.globals.series[i]));

        if (!chartOpts.distributed && chartType === 'heatmap') {
          min = w.globals.minY;
          max = w.globals.maxY;
        }

        if (typeof chartOpts.colorScale.min !== 'undefined') {
          min = chartOpts.colorScale.min < w.globals.minY ? chartOpts.colorScale.min : w.globals.minY;
          max = chartOpts.colorScale.max > w.globals.maxY ? chartOpts.colorScale.max : w.globals.maxY;
        }

        var total = Math.abs(max) + Math.abs(min);
        var percent = 100 * val / (total === 0 ? total - 0.000001 : total);

        if (chartOpts.colorScale.ranges.length > 0) {
          var colorRange = chartOpts.colorScale.ranges;
          colorRange.map(function (range, index) {
            if (val >= range.from && val <= range.to) {
              color = range.color;
              foreColor = range.foreColor ? range.foreColor : null;
              min = range.from;
              max = range.to;
              var rTotal = Math.abs(max) + Math.abs(min);
              percent = 100 * val / (rTotal === 0 ? rTotal - 0.000001 : rTotal);
            }
          });
        }

        return {
          color: color,
          foreColor: foreColor,
          percent: percent
        };
      }
    }, {
      key: "calculateDataLabels",
      value: function calculateDataLabels(_ref) {
        var text = _ref.text,
            x = _ref.x,
            y = _ref.y,
            i = _ref.i,
            j = _ref.j,
            colorProps = _ref.colorProps,
            fontSize = _ref.fontSize;
        var w = this.w;
        var dataLabelsConfig = w.config.dataLabels;
        var graphics = new Graphics(this.ctx);
        var dataLabels = new DataLabels(this.ctx);
        var elDataLabelsWrap = null;

        if (dataLabelsConfig.enabled) {
          elDataLabelsWrap = graphics.group({
            class: 'apexcharts-data-labels'
          });
          var offX = dataLabelsConfig.offsetX;
          var offY = dataLabelsConfig.offsetY;
          var dataLabelsX = x + offX;
          var dataLabelsY = y + parseFloat(dataLabelsConfig.style.fontSize) / 3 + offY;
          dataLabels.plotDataLabelsText({
            x: dataLabelsX,
            y: dataLabelsY,
            text: text,
            i: i,
            j: j,
            color: colorProps.foreColor,
            parent: elDataLabelsWrap,
            fontSize: fontSize,
            dataLabelsConfig: dataLabelsConfig
          });
        }

        return elDataLabelsWrap;
      }
    }, {
      key: "addListeners",
      value: function addListeners(elRect) {
        var graphics = new Graphics(this.ctx);
        elRect.node.addEventListener('mouseenter', graphics.pathMouseEnter.bind(this, elRect));
        elRect.node.addEventListener('mouseleave', graphics.pathMouseLeave.bind(this, elRect));
        elRect.node.addEventListener('mousedown', graphics.pathMouseDown.bind(this, elRect));
      }
    }]);

    return TreemapHelpers;
  }();

  /**
   * ApexCharts HeatMap Class.
   * @module HeatMap
   **/

  var HeatMap = /*#__PURE__*/function () {
    function HeatMap(ctx, xyRatios) {
      _classCallCheck(this, HeatMap);

      this.ctx = ctx;
      this.w = ctx.w;
      this.xRatio = xyRatios.xRatio;
      this.yRatio = xyRatios.yRatio;
      this.dynamicAnim = this.w.config.chart.animations.dynamicAnimation;
      this.helpers = new TreemapHelpers(ctx);
      this.rectRadius = this.w.config.plotOptions.heatmap.radius;
      this.strokeWidth = this.w.config.stroke.show ? this.w.config.stroke.width : 0;
    }

    _createClass(HeatMap, [{
      key: "draw",
      value: function draw(series) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var ret = graphics.group({
          class: 'apexcharts-heatmap'
        });
        ret.attr('clip-path', "url(#gridRectMask".concat(w.globals.cuid, ")"));

        var xDivision = w.globals.gridWidth / w.globals.dataPoints;
        var yDivision = w.globals.gridHeight / w.globals.series.length;
        var y1 = 0;
        var rev = false;
        this.negRange = this.helpers.checkColorRange();
        var heatSeries = series.slice();

        if (w.config.yaxis[0].reversed) {
          rev = true;
          heatSeries.reverse();
        }

        for (var i = rev ? 0 : heatSeries.length - 1; rev ? i < heatSeries.length : i >= 0; rev ? i++ : i--) {

          var elSeries = graphics.group({
            class: "apexcharts-series apexcharts-heatmap-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[i]),
            rel: i + 1,
            'data:realIndex': i
          });
          this.ctx.series.addCollapsedClassToSeries(elSeries, i);

          if (w.config.chart.dropShadow.enabled) {
            var shadow = w.config.chart.dropShadow;
            var filters = new Filters(this.ctx);
            filters.dropShadow(elSeries, shadow, i);
          }

          var x1 = 0;
          var shadeIntensity = w.config.plotOptions.heatmap.shadeIntensity;

          for (var j = 0; j < heatSeries[i].length; j++) {
            var heatColor = this.helpers.getShadeColor(w.config.chart.type, i, j, this.negRange);
            var color = heatColor.color;
            var heatColorProps = heatColor.colorProps;

            if (w.config.fill.type === 'image') {
              var fill = new Fill(this.ctx);
              color = fill.fillPath({
                seriesNumber: i,
                dataPointIndex: j,
                opacity: w.globals.hasNegs ? heatColorProps.percent < 0 ? 1 - (1 + heatColorProps.percent / 100) : shadeIntensity + heatColorProps.percent / 100 : heatColorProps.percent / 100,
                patternID: Utils$1.randomId(),
                width: w.config.fill.image.width ? w.config.fill.image.width : xDivision,
                height: w.config.fill.image.height ? w.config.fill.image.height : yDivision
              });
            }

            var radius = this.rectRadius;
            var rect = graphics.drawRect(x1, y1, xDivision, yDivision, radius);
            rect.attr({
              cx: x1,
              cy: y1
            });
            rect.node.classList.add('apexcharts-heatmap-rect');
            elSeries.add(rect);
            rect.attr({
              fill: color,
              i: i,
              index: i,
              j: j,
              val: heatSeries[i][j],
              'stroke-width': this.strokeWidth,
              stroke: w.config.plotOptions.heatmap.useFillColorAsStroke ? color : w.globals.stroke.colors[0],
              color: color
            });
            this.helpers.addListeners(rect);

            if (w.config.chart.animations.enabled && !w.globals.dataChanged) {
              var speed = 1;

              if (!w.globals.resized) {
                speed = w.config.chart.animations.speed;
              }

              this.animateHeatMap(rect, x1, y1, xDivision, yDivision, speed);
            }

            if (w.globals.dataChanged) {
              var _speed = 1;

              if (this.dynamicAnim.enabled && w.globals.shouldAnimate) {
                _speed = this.dynamicAnim.speed;
                var colorFrom = w.globals.previousPaths[i] && w.globals.previousPaths[i][j] && w.globals.previousPaths[i][j].color;
                if (!colorFrom) colorFrom = 'rgba(255, 255, 255, 0)';
                this.animateHeatColor(rect, Utils$1.isColorHex(colorFrom) ? colorFrom : Utils$1.rgb2hex(colorFrom), Utils$1.isColorHex(color) ? color : Utils$1.rgb2hex(color), _speed);
              }
            }

            var formatter = w.config.dataLabels.formatter;
            var formattedText = formatter(w.globals.series[i][j], {
              value: w.globals.series[i][j],
              seriesIndex: i,
              dataPointIndex: j,
              w: w
            });
            var dataLabels = this.helpers.calculateDataLabels({
              text: formattedText,
              x: x1 + xDivision / 2,
              y: y1 + yDivision / 2,
              i: i,
              j: j,
              colorProps: heatColorProps,
              series: heatSeries
            });

            if (dataLabels !== null) {
              elSeries.add(dataLabels);
            }

            x1 = x1 + xDivision;
          }

          y1 = y1 + yDivision;
          ret.add(elSeries);
        }


        var yAxisScale = w.globals.yAxisScale[0].result.slice();

        if (w.config.yaxis[0].reversed) {
          yAxisScale.unshift('');
        } else {
          yAxisScale.push('');
        }

        w.globals.yAxisScale[0].result = yAxisScale;
        var divisor = w.globals.gridHeight / w.globals.series.length;
        w.config.yaxis[0].labels.offsetY = -(divisor / 2);
        return ret;
      }
    }, {
      key: "animateHeatMap",
      value: function animateHeatMap(el, x, y, width, height, speed) {
        var animations = new Animations(this.ctx);
        animations.animateRect(el, {
          x: x + width / 2,
          y: y + height / 2,
          width: 0,
          height: 0
        }, {
          x: x,
          y: y,
          width: width,
          height: height
        }, speed, function () {
          animations.animationCompleted(el);
        });
      }
    }, {
      key: "animateHeatColor",
      value: function animateHeatColor(el, colorFrom, colorTo, speed) {
        el.attr({
          fill: colorFrom
        }).animate(speed).attr({
          fill: colorTo
        });
      }
    }]);

    return HeatMap;
  }();

  var CircularChartsHelpers = /*#__PURE__*/function () {
    function CircularChartsHelpers(ctx) {
      _classCallCheck(this, CircularChartsHelpers);

      this.ctx = ctx;
      this.w = ctx.w;
    }

    _createClass(CircularChartsHelpers, [{
      key: "drawYAxisTexts",
      value: function drawYAxisTexts(x, y, i, text) {
        var w = this.w;
        var yaxisConfig = w.config.yaxis[0];
        var formatter = w.globals.yLabelFormatters[0];
        var graphics = new Graphics(this.ctx);
        var yaxisLabel = graphics.drawText({
          x: x + yaxisConfig.labels.offsetX,
          y: y + yaxisConfig.labels.offsetY,
          text: formatter(text, i),
          textAnchor: 'middle',
          fontSize: yaxisConfig.labels.style.fontSize,
          fontFamily: yaxisConfig.labels.style.fontFamily,
          foreColor: Array.isArray(yaxisConfig.labels.style.colors) ? yaxisConfig.labels.style.colors[i] : yaxisConfig.labels.style.colors
        });
        return yaxisLabel;
      }
    }]);

    return CircularChartsHelpers;
  }();

  /**
   * ApexCharts Pie Class for drawing Pie / Donut Charts.
   * @module Pie
   **/

  var Pie = /*#__PURE__*/function () {
    function Pie(ctx) {
      _classCallCheck(this, Pie);

      this.ctx = ctx;
      this.w = ctx.w;
      var w = this.w;
      this.chartType = this.w.config.chart.type;
      this.initialAnim = this.w.config.chart.animations.enabled;
      this.dynamicAnim = this.initialAnim && this.w.config.chart.animations.dynamicAnimation.enabled;
      this.animBeginArr = [0];
      this.animDur = 0;
      this.donutDataLabels = this.w.config.plotOptions.pie.donut.labels;
      this.lineColorArr = w.globals.stroke.colors !== undefined ? w.globals.stroke.colors : w.globals.colors;
      this.defaultSize = Math.min(w.globals.gridWidth, w.globals.gridHeight);
      this.centerY = this.defaultSize / 2;
      this.centerX = w.globals.gridWidth / 2;

      if (w.config.chart.type === 'radialBar') {
        this.fullAngle = 360;
      } else {
        this.fullAngle = Math.abs(w.config.plotOptions.pie.endAngle - w.config.plotOptions.pie.startAngle);
      }

      this.initialAngle = w.config.plotOptions.pie.startAngle % this.fullAngle;
      w.globals.radialSize = this.defaultSize / 2.05 - w.config.stroke.width - (!w.config.chart.sparkline.enabled ? w.config.chart.dropShadow.blur : 0);
      this.donutSize = w.globals.radialSize * parseInt(w.config.plotOptions.pie.donut.size, 10) / 100;
      this.maxY = 0;
      this.sliceLabels = [];
      this.sliceSizes = [];
      this.prevSectorAngleArr = [];
    }

    _createClass(Pie, [{
      key: "draw",
      value: function draw(series) {
        var _this = this;

        var self = this;
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        this.ret = graphics.group({
          class: 'apexcharts-pie'
        });
        if (w.globals.noData) return this.ret;
        var total = 0;

        for (var k = 0; k < series.length; k++) {

          total += Utils$1.negToZero(series[k]);
        }

        var sectorAngleArr = [];

        var elSeries = graphics.group();

        if (total === 0) {
          total = 0.00001;
        }

        series.forEach(function (m) {
          _this.maxY = Math.max(_this.maxY, m);
        });

        if (w.config.yaxis[0].max) {
          this.maxY = w.config.yaxis[0].max;
        }

        if (w.config.grid.position === 'back' && this.chartType === 'polarArea') {
          this.drawPolarElements(this.ret);
        }

        for (var i = 0; i < series.length; i++) {

          var angle = this.fullAngle * Utils$1.negToZero(series[i]) / total;
          sectorAngleArr.push(angle);

          if (this.chartType === 'polarArea') {
            sectorAngleArr[i] = this.fullAngle / series.length;
            this.sliceSizes.push(w.globals.radialSize * series[i] / this.maxY);
          } else {
            this.sliceSizes.push(w.globals.radialSize);
          }
        }

        if (w.globals.dataChanged) {
          var prevTotal = 0;

          for (var _k = 0; _k < w.globals.previousPaths.length; _k++) {

            prevTotal += Utils$1.negToZero(w.globals.previousPaths[_k]);
          }

          var previousAngle;

          for (var _i = 0; _i < w.globals.previousPaths.length; _i++) {

            previousAngle = this.fullAngle * Utils$1.negToZero(w.globals.previousPaths[_i]) / prevTotal;
            this.prevSectorAngleArr.push(previousAngle);
          }
        }


        if (this.donutSize < 0) {
          this.donutSize = 0;
        }

        var scaleSize = w.config.plotOptions.pie.customScale;
        var halfW = w.globals.gridWidth / 2;
        var halfH = w.globals.gridHeight / 2;
        var translateX = halfW - w.globals.gridWidth / 2 * scaleSize;
        var translateY = halfH - w.globals.gridHeight / 2 * scaleSize;

        if (this.chartType === 'donut') {

          var circle = graphics.drawCircle(this.donutSize);
          circle.attr({
            cx: this.centerX,
            cy: this.centerY,
            fill: w.config.plotOptions.pie.donut.background ? w.config.plotOptions.pie.donut.background : 'transparent'
          });
          elSeries.add(circle);
        }

        var elG = self.drawArcs(sectorAngleArr, series);

        this.sliceLabels.forEach(function (s) {
          elG.add(s);
        });
        elSeries.attr({
          transform: "translate(".concat(translateX, ", ").concat(translateY, ") scale(").concat(scaleSize, ")")
        });
        elSeries.add(elG);
        this.ret.add(elSeries);

        if (this.donutDataLabels.show) {
          var dataLabels = this.renderInnerDataLabels(this.donutDataLabels, {
            hollowSize: this.donutSize,
            centerX: this.centerX,
            centerY: this.centerY,
            opacity: this.donutDataLabels.show,
            translateX: translateX,
            translateY: translateY
          });
          this.ret.add(dataLabels);
        }

        if (w.config.grid.position === 'front' && this.chartType === 'polarArea') {
          this.drawPolarElements(this.ret);
        }

        return this.ret;
      }

    }, {
      key: "drawArcs",
      value: function drawArcs(sectorAngleArr, series) {
        var w = this.w;
        var filters = new Filters(this.ctx);
        var graphics = new Graphics(this.ctx);
        var fill = new Fill(this.ctx);
        var g = graphics.group({
          class: 'apexcharts-slices'
        });
        var startAngle = this.initialAngle;
        var prevStartAngle = this.initialAngle;
        var endAngle = this.initialAngle;
        var prevEndAngle = this.initialAngle;
        this.strokeWidth = w.config.stroke.show ? w.config.stroke.width : 0;

        for (var i = 0; i < sectorAngleArr.length; i++) {
          var elPieArc = graphics.group({
            class: "apexcharts-series apexcharts-pie-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[i]),
            rel: i + 1,
            'data:realIndex': i
          });
          g.add(elPieArc);
          startAngle = endAngle;
          prevStartAngle = prevEndAngle;
          endAngle = startAngle + sectorAngleArr[i];
          prevEndAngle = prevStartAngle + this.prevSectorAngleArr[i];
          var angle = endAngle < startAngle ? this.fullAngle + endAngle - startAngle : endAngle - startAngle;
          var pathFill = fill.fillPath({
            seriesNumber: i,
            size: this.sliceSizes[i],
            value: series[i]
          });

          var path = this.getChangedPath(prevStartAngle, prevEndAngle);
          var elPath = graphics.drawPath({
            d: path,
            stroke: Array.isArray(this.lineColorArr) ? this.lineColorArr[i] : this.lineColorArr,
            strokeWidth: 0,
            fill: pathFill,
            fillOpacity: w.config.fill.opacity,
            classes: "apexcharts-pie-area apexcharts-".concat(this.chartType.toLowerCase(), "-slice-").concat(i)
          });
          elPath.attr({
            index: 0,
            j: i
          });
          filters.setSelectionFilter(elPath, 0, i);

          if (w.config.chart.dropShadow.enabled) {
            var shadow = w.config.chart.dropShadow;
            filters.dropShadow(elPath, shadow, i);
          }

          this.addListeners(elPath, this.donutDataLabels);
          Graphics.setAttrs(elPath.node, {
            'data:angle': angle,
            'data:startAngle': startAngle,
            'data:strokeWidth': this.strokeWidth,
            'data:value': series[i]
          });
          var labelPosition = {
            x: 0,
            y: 0
          };

          if (this.chartType === 'pie' || this.chartType === 'polarArea') {
            labelPosition = Utils$1.polarToCartesian(this.centerX, this.centerY, w.globals.radialSize / 1.25 + w.config.plotOptions.pie.dataLabels.offset, (startAngle + angle / 2) % this.fullAngle);
          } else if (this.chartType === 'donut') {
            labelPosition = Utils$1.polarToCartesian(this.centerX, this.centerY, (w.globals.radialSize + this.donutSize) / 2 + w.config.plotOptions.pie.dataLabels.offset, (startAngle + angle / 2) % this.fullAngle);
          }

          elPieArc.add(elPath);

          var dur = 0;

          if (this.initialAnim && !w.globals.resized && !w.globals.dataChanged) {
            dur = angle / this.fullAngle * w.config.chart.animations.speed;
            if (dur === 0) dur = 1;
            this.animDur = dur + this.animDur;
            this.animBeginArr.push(this.animDur);
          } else {
            this.animBeginArr.push(0);
          }

          if (this.dynamicAnim && w.globals.dataChanged) {
            this.animatePaths(elPath, {
              size: this.sliceSizes[i],
              endAngle: endAngle,
              startAngle: startAngle,
              prevStartAngle: prevStartAngle,
              prevEndAngle: prevEndAngle,
              animateStartingPos: true,
              i: i,
              animBeginArr: this.animBeginArr,
              shouldSetPrevPaths: true,
              dur: w.config.chart.animations.dynamicAnimation.speed
            });
          } else {
            this.animatePaths(elPath, {
              size: this.sliceSizes[i],
              endAngle: endAngle,
              startAngle: startAngle,
              i: i,
              totalItems: sectorAngleArr.length - 1,
              animBeginArr: this.animBeginArr,
              dur: dur
            });
          }


          if (w.config.plotOptions.pie.expandOnClick && this.chartType !== 'polarArea') {
            elPath.click(this.pieClicked.bind(this, i));
          }

          if (typeof w.globals.selectedDataPoints[0] !== 'undefined' && w.globals.selectedDataPoints[0].indexOf(i) > -1) {
            this.pieClicked(i);
          }

          if (w.config.dataLabels.enabled) {
            var xPos = labelPosition.x;
            var yPos = labelPosition.y;
            var text = 100 * angle / this.fullAngle + '%';

            if (angle !== 0 && w.config.plotOptions.pie.dataLabels.minAngleToShowLabel < sectorAngleArr[i]) {
              var formatter = w.config.dataLabels.formatter;

              if (formatter !== undefined) {
                text = formatter(w.globals.seriesPercent[i][0], {
                  seriesIndex: i,
                  w: w
                });
              }

              var foreColor = w.globals.dataLabels.style.colors[i];
              var elPieLabelWrap = graphics.group({
                class: "apexcharts-datalabels"
              });
              var elPieLabel = graphics.drawText({
                x: xPos,
                y: yPos,
                text: text,
                textAnchor: 'middle',
                fontSize: w.config.dataLabels.style.fontSize,
                fontFamily: w.config.dataLabels.style.fontFamily,
                fontWeight: w.config.dataLabels.style.fontWeight,
                foreColor: foreColor
              });
              elPieLabelWrap.add(elPieLabel);

              if (w.config.dataLabels.dropShadow.enabled) {
                var textShadow = w.config.dataLabels.dropShadow;
                filters.dropShadow(elPieLabel, textShadow);
              }

              elPieLabel.node.classList.add('apexcharts-pie-label');

              if (w.config.chart.animations.animate && w.globals.resized === false) {
                elPieLabel.node.classList.add('apexcharts-pie-label-delay');
                elPieLabel.node.style.animationDelay = w.config.chart.animations.speed / 940 + 's';
              }

              this.sliceLabels.push(elPieLabelWrap);
            }
          }
        }

        return g;
      }
    }, {
      key: "addListeners",
      value: function addListeners(elPath, dataLabels) {
        var graphics = new Graphics(this.ctx);

        elPath.node.addEventListener('mouseenter', graphics.pathMouseEnter.bind(this, elPath));
        elPath.node.addEventListener('mouseleave', graphics.pathMouseLeave.bind(this, elPath));
        elPath.node.addEventListener('mouseleave', this.revertDataLabelsInner.bind(this, elPath.node, dataLabels));
        elPath.node.addEventListener('mousedown', graphics.pathMouseDown.bind(this, elPath));

        if (!this.donutDataLabels.total.showAlways) {
          elPath.node.addEventListener('mouseenter', this.printDataLabelsInner.bind(this, elPath.node, dataLabels));
          elPath.node.addEventListener('mousedown', this.printDataLabelsInner.bind(this, elPath.node, dataLabels));
        }
      }

    }, {
      key: "animatePaths",
      value: function animatePaths(el, opts) {
        var w = this.w;
        var me = this;
        var angle = opts.endAngle < opts.startAngle ? this.fullAngle + opts.endAngle - opts.startAngle : opts.endAngle - opts.startAngle;
        var prevAngle = angle;
        var fromStartAngle = opts.startAngle;
        var toStartAngle = opts.startAngle;

        if (opts.prevStartAngle !== undefined && opts.prevEndAngle !== undefined) {
          fromStartAngle = opts.prevEndAngle;
          prevAngle = opts.prevEndAngle < opts.prevStartAngle ? this.fullAngle + opts.prevEndAngle - opts.prevStartAngle : opts.prevEndAngle - opts.prevStartAngle;
        }

        if (opts.i === w.config.series.length - 1) {

          if (angle + toStartAngle > this.fullAngle) {
            opts.endAngle = opts.endAngle - (angle + toStartAngle);
          } else if (angle + toStartAngle < this.fullAngle) {
            opts.endAngle = opts.endAngle + (this.fullAngle - (angle + toStartAngle));
          }
        }

        if (angle === this.fullAngle) angle = this.fullAngle - 0.01;
        me.animateArc(el, fromStartAngle, toStartAngle, angle, prevAngle, opts);
      }
    }, {
      key: "animateArc",
      value: function animateArc(el, fromStartAngle, toStartAngle, angle, prevAngle, opts) {
        var me = this;
        var w = this.w;
        var animations = new Animations(this.ctx);
        var size = opts.size;
        var path;

        if (isNaN(fromStartAngle) || isNaN(prevAngle)) {
          fromStartAngle = toStartAngle;
          prevAngle = angle;
          opts.dur = 0;
        }

        var currAngle = angle;
        var startAngle = toStartAngle;
        var fromAngle = fromStartAngle < toStartAngle ? this.fullAngle + fromStartAngle - toStartAngle : fromStartAngle - toStartAngle;

        if (w.globals.dataChanged && opts.shouldSetPrevPaths) {

          if (opts.prevEndAngle) {
            path = me.getPiePath({
              me: me,
              startAngle: opts.prevStartAngle,
              angle: opts.prevEndAngle < opts.prevStartAngle ? this.fullAngle + opts.prevEndAngle - opts.prevStartAngle : opts.prevEndAngle - opts.prevStartAngle,
              size: size
            });
            el.attr({
              d: path
            });
          }
        }

        if (opts.dur !== 0) {
          el.animate(opts.dur, w.globals.easing, opts.animBeginArr[opts.i]).afterAll(function () {
            if (me.chartType === 'pie' || me.chartType === 'donut' || me.chartType === 'polarArea') {
              this.animate(w.config.chart.animations.dynamicAnimation.speed).attr({
                'stroke-width': me.strokeWidth
              });
            }

            if (opts.i === w.config.series.length - 1) {
              animations.animationCompleted(el);
            }
          }).during(function (pos) {
            currAngle = fromAngle + (angle - fromAngle) * pos;

            if (opts.animateStartingPos) {
              currAngle = prevAngle + (angle - prevAngle) * pos;
              startAngle = fromStartAngle - prevAngle + (toStartAngle - (fromStartAngle - prevAngle)) * pos;
            }

            path = me.getPiePath({
              me: me,
              startAngle: startAngle,
              angle: currAngle,
              size: size
            });
            el.node.setAttribute('data:pathOrig', path);
            el.attr({
              d: path
            });
          });
        } else {
          path = me.getPiePath({
            me: me,
            startAngle: startAngle,
            angle: angle,
            size: size
          });

          if (!opts.isTrack) {
            w.globals.animationEnded = true;
          }

          el.node.setAttribute('data:pathOrig', path);
          el.attr({
            d: path,
            'stroke-width': me.strokeWidth
          });
        }
      }
    }, {
      key: "pieClicked",
      value: function pieClicked(i) {
        var w = this.w;
        var me = this;
        var path;
        var size = me.sliceSizes[i] + (w.config.plotOptions.pie.expandOnClick ? 4 : 0);
        var elPath = w.globals.dom.Paper.select(".apexcharts-".concat(me.chartType.toLowerCase(), "-slice-").concat(i)).members[0];

        if (elPath.attr('data:pieClicked') === 'true') {
          elPath.attr({
            'data:pieClicked': 'false'
          });
          this.revertDataLabelsInner(elPath.node, this.donutDataLabels);
          var origPath = elPath.attr('data:pathOrig');
          elPath.attr({
            d: origPath
          });
          return;
        } else {

          var allEls = w.globals.dom.baseEl.getElementsByClassName('apexcharts-pie-area');
          Array.prototype.forEach.call(allEls, function (pieSlice) {
            pieSlice.setAttribute('data:pieClicked', 'false');
            var origPath = pieSlice.getAttribute('data:pathOrig');

            if (origPath) {
              pieSlice.setAttribute('d', origPath);
            }
          });
          elPath.attr('data:pieClicked', 'true');
        }

        var startAngle = parseInt(elPath.attr('data:startAngle'), 10);
        var angle = parseInt(elPath.attr('data:angle'), 10);
        path = me.getPiePath({
          me: me,
          startAngle: startAngle,
          angle: angle,
          size: size
        });
        if (angle === 360) return;
        elPath.plot(path);
      }
    }, {
      key: "getChangedPath",
      value: function getChangedPath(prevStartAngle, prevEndAngle) {
        var path = '';

        if (this.dynamicAnim && this.w.globals.dataChanged) {
          path = this.getPiePath({
            me: this,
            startAngle: prevStartAngle,
            angle: prevEndAngle - prevStartAngle,
            size: this.size
          });
        }

        return path;
      }
    }, {
      key: "getPiePath",
      value: function getPiePath(_ref) {
        var me = _ref.me,
            startAngle = _ref.startAngle,
            angle = _ref.angle,
            size = _ref.size;
        var path;
        var startDeg = startAngle;
        var startRadians = Math.PI * (startDeg - 90) / 180;
        var endDeg = angle + startAngle;

        if (Math.ceil(endDeg) >= this.fullAngle + this.w.config.plotOptions.pie.startAngle % this.fullAngle) {
          endDeg = this.fullAngle + this.w.config.plotOptions.pie.startAngle % this.fullAngle - 0.01;
        }

        if (Math.ceil(endDeg) > this.fullAngle) endDeg -= this.fullAngle;
        var endRadians = Math.PI * (endDeg - 90) / 180;
        var x1 = me.centerX + size * Math.cos(startRadians);
        var y1 = me.centerY + size * Math.sin(startRadians);
        var x2 = me.centerX + size * Math.cos(endRadians);
        var y2 = me.centerY + size * Math.sin(endRadians);
        var startInner = Utils$1.polarToCartesian(me.centerX, me.centerY, me.donutSize, endDeg);
        var endInner = Utils$1.polarToCartesian(me.centerX, me.centerY, me.donutSize, startDeg);
        var largeArc = angle > 180 ? 1 : 0;
        var pathBeginning = ['M', x1, y1, 'A', size, size, 0, largeArc, 1, x2, y2];

        if (me.chartType === 'donut') {
          path = [].concat(pathBeginning, ['L', startInner.x, startInner.y, 'A', me.donutSize, me.donutSize, 0, largeArc, 0, endInner.x, endInner.y, 'L', x1, y1, 'z']).join(' ');
        } else if (me.chartType === 'pie' || me.chartType === 'polarArea') {
          path = [].concat(pathBeginning, ['L', me.centerX, me.centerY, 'L', x1, y1]).join(' ');
        } else {
          path = [].concat(pathBeginning).join(' ');
        }

        return path;
      }
    }, {
      key: "drawPolarElements",
      value: function drawPolarElements(parent) {
        var w = this.w;
        var scale = new Range$1(this.ctx);
        var graphics = new Graphics(this.ctx);
        var helpers = new CircularChartsHelpers(this.ctx);
        var gCircles = graphics.group();
   g = graphics.group({
          class: 'apexcharts-datalabels-group',
          transform: "translate(".concat(opts.translateX ? opts.translateX : 0, ", ").concat(opts.translateY ? opts.translateY : 0, ") scale(").concat(w.config.plotOptions.pie.customScale, ")")
        });
        var showTotal = dataLabelsConfig.total.show;
        g.node.style.opacity = opts.opacity;
        var x = opts.centerX;
        var y = opts.centerY;
        var labelColor, valueColor;

        if (dataLabelsConfig.name.color === undefined) {
          labelColor = w.globals.colors[0];
        } else {
          labelColor = dataLabelsConfig.name.color;
        }

        var labelFontSize = dataLabelsConfig.name.fontSize;
        var labelFontFamily = dataLabelsConfig.name.fontFamily;
        var labelFontWeight = dataLabelsConfig.name.fontWeight;

        if (dataLabelsConfig.value.color === undefined) {
          valueColor = w.config.chart.foreColor;
        } else {
          valueColor = dataLabelsConfig.value.color;
        }

        var lbFormatter = dataLabelsConfig.value.formatter;
        var val = '';
        var name = '';

        if (showTotal) {
          labelColor = dataLabelsConfig.total.color;
          labelFontSize = dataLabelsConfig.total.fontSize;
          labelFontFamily = dataLabelsConfig.total.fontFamily;
          labelFontWeight = dataLabelsConfig.total.fontWeight;
          name = dataLabelsConfig.total.label;
          val = dataLabelsConfig.total.formatter(w);
        } else {
          if (w.globals.series.length === 1) {
            val = lbFormatter(w.globals.series[0], w);
            name = w.globals.seriesNames[0];
          }
        }

        if (name) {
          name = dataLabelsConfig.name.formatter(name, dataLabelsConfig.total.show, w);
        }

        if (dataLabelsConfig.name.show) {
          var elLabel = graphics.drawText({
            x: x,
            y: y + parseFloat(dataLabelsConfig.name.offsetY),
            text: name,
            textAnchor: 'middle',
            foreColor: labelColor,
            fontSize: labelFontSize,
            fontWeight: labelFontWeight,
            fontFamily: labelFontFamily
          });
          elLabel.node.classList.add('apexcharts-datalabel-label');
          g.add(elLabel);
        }

        if (dataLabelsConfig.value.show) {
          var valOffset = dataLabelsConfig.name.show ? parseFloat(dataLabelsConfig.value.offsetY) + 16 : dataLabelsConfig.value.offsetY;
          var elValue = graphics.drawText({
            x: x,
            y: y + valOffset,
            text: val,
            textAnchor: 'middle',
            foreColor: valueColor,
            fontWeight: dataLabelsConfig.value.fontWeight,
            fontSize: dataLabelsConfig.value.fontSize,
            fontFamily: dataLabelsConfig.value.fontFamily
          });
          elValue.node.classList.add('apexcharts-datalabel-value');
          g.add(elValue);
        }


        return g;
      }
      /**
       *
       * @param {string} name - The name of the series
       * @param {string} val - The value of that series
       * @param {object} el - Optional el (indicates which series was hovered/clicked). If this param is not present, means we need to show total
       */

    }, {
      key: "printInnerLabels",
      value: function printInnerLabels(labelsConfig, name, val, el) {
        var w = this.w;
        var labelColor;

        if (el) {
          if (labelsConfig.name.color === undefined) {
            labelColor = w.globals.colors[parseInt(el.parentNode.getAttribute('rel'), 10) - 1];
          } else {
            labelColor = labelsConfig.name.color;
          }
        } else {
          if (w.globals.series.length > 1 && labelsConfig.total.show) {
            labelColor = labelsConfig.total.color;
          }
        }

        var elLabel = w.globals.dom.baseEl.querySelector('.apexcharts-datalabel-label');
        var elValue = w.globals.dom.baseEl.querySelector('.apexcharts-datalabel-value');
        var lbFormatter = labelsConfig.value.formatter;
        val = lbFormatter(val, w);

        if (!el && typeof labelsConfig.total.formatter === 'function') {
          val = labelsConfig.total.formatter(w);
        }

        var isTotal = name === labelsConfig.total.label;
        name = labelsConfig.name.formatter(name, isTotal, w);

        if (elLabel !== null) {
          elLabel.textContent = name;
        }

        if (elValue !== null) {
          elValue.textContent = val;
        }

        if (elLabel !== null) {
          elLabel.style.fill = labelColor;
        }
      }
    }, {
      key: "printDataLabelsInner",
      value: function printDataLabelsInner(el, dataLabelsConfig) {
        var w = this.w;
        var val = el.getAttribute('data:value');
        var name = w.globals.seriesNames[parseInt(el.parentNode.getAttribute('rel'), 10) - 1];

        if (w.globals.series.length > 1) {
          this.printInnerLabels(dataLabelsConfig, name, val, el);
        }

        var dataLabelsGroup = w.globals.dom.baseEl.querySelector('.apexcharts-datalabels-group');

        if (dataLabelsGroup !== null) {
          dataLabelsGroup.style.opacity = 1;
        }
      }
    }, {
      key: "drawSpokes",
      value: function drawSpokes(parent) {
        var _this2 = this;

        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var spokeConfig = w.config.plotOptions.polarArea.spokes;
        if (spokeConfig.strokeWidth === 0) return;
        var spokes = [];
        var angleDivision = 360 / w.globals.series.length;

        for (var i = 0; i < w.globals.series.length; i++) {
          spokes.push(Utils$1.polarToCartesian(this.centerX, this.centerY, w.globals.radialSize, w.config.plotOptions.pie.startAngle + angleDivision * i));
        }

        spokes.forEach(function (p, i) {
          var line = graphics.drawLine(p.x, p.y, _this2.centerX, _this2.centerY, Array.isArray(spokeConfig.connectorColors) ? spokeConfig.connectorColors[i] : spokeConfig.connectorColors);
          parent.add(line);
        });
      }
    }, {
      key: "revertDataLabelsInner",
      value: function revertDataLabelsInner(elem, dataLabelsConfig, event) {
        var _this3 = this;

        var w = this.w;
        var dataLabelsGroup = w.globals.dom.baseEl.querySelector('.apexcharts-datalabels-group');
        var sliceOut = false;
        var slices = w.globals.dom.baseEl.getElementsByClassName("apexcharts-pie-area");

        var selectSlice = function selectSlice(_ref2) {
          var makeSliceOut = _ref2.makeSliceOut,
              printLabel = _ref2.printLabel;
          Array.prototype.forEach.call(slices, function (s) {
            if (s.getAttribute('data:pieClicked') === 'true') {
              if (makeSliceOut) {
                sliceOut = true;
              }

              if (printLabel) {
                _this3.printDataLabelsInner(s, dataLabelsConfig);
              }
            }
          });
        };

        selectSlice({
          makeSliceOut: true,
          printLabel: false
        });

        if (dataLabelsConfig.total.show && w.globals.series.length > 1) {
          if (sliceOut && !dataLabelsConfig.total.showAlways) {
            selectSlice({
              makeSliceOut: false,
              printLabel: true
            });
          } else {
            this.printInnerLabels(dataLabelsConfig, dataLabelsConfig.total.label, dataLabelsConfig.total.formatter(w));
          }
        } else {
          selectSlice({
            makeSliceOut: false,
            printLabel: true
          });

          if (!sliceOut) {
            if (w.globals.selectedDataPoints.length && w.globals.series.length > 1) {
              if (w.globals.selectedDataPoints[0].length > 0) {
                var index = w.globals.selectedDataPoints[0];
                var el = w.globals.dom.baseEl.querySelector(".apexcharts-".concat(this.chartType.toLowerCase(), "-slice-").concat(index));
                this.printDataLabelsInner(el, dataLabelsConfig);
              } else if (dataLabelsGroup && w.globals.selectedDataPoints.length && w.globals.selectedDataPoints[0].length === 0) {
                dataLabelsGroup.style.opacity = 0;
              }
            } else {
              if (dataLabelsGroup && w.globals.series.length > 1) {
                dataLabelsGroup.style.opacity = 0;
              }
            }
          }
        }
      }
    }]);

    return Pie;
  }();

  /**
   * ApexCharts Radar Class for Spider/Radar Charts.
   * @module Radar
   **/

  var Radar = /*#__PURE__*/function () {
    function Radar(ctx) {
      _classCallCheck(this, Radar);

      this.ctx = ctx;
      this.w = ctx.w;
      this.chartType = this.w.config.chart.type;
      this.initialAnim = this.w.config.chart.animations.enabled;
      this.dynamicAnim = this.initialAnim && this.w.config.chart.animations.dynamicAnimation.enabled;
      this.animDur = 0;
      var w = this.w;
      this.graphics = new Graphics(this.ctx);
      this.lineColorArr = w.globals.stroke.colors !== undefined ? w.globals.stroke.colors : w.globals.colors;
      this.defaultSize = w.globals.svgHeight < w.globals.svgWidth ? w.globals.gridHeight + w.globals.goldenPadding * 1.5 : w.globals.gridWidth;
      this.isLog = w.config.yaxis[0].logarithmic;
      this.coreUtils = new CoreUtils(this.ctx);
      this.maxValue = this.isLog ? this.coreUtils.getLogVal(w.globals.maxY, 0) : w.globals.maxY;
      this.minValue = this.isLog ? this.coreUtils.getLogVal(this.w.globals.minY, 0) : w.globals.minY;
      this.polygons = w.config.plotOptions.radar.polygons;
      this.strokeWidth = w.config.stroke.show ? w.config.stroke.width : 0;
      this.size = this.defaultSize / 2.1 - this.strokeWidth - w.config.chart.dropShadow.blur;

      if (w.config.xaxis.labels.show) {
        this.size = this.size - w.globals.xAxisLabelsWidth / 1.75;
      }

      if (w.config.plotOptions.radar.size !== undefined) {
        this.size = w.config.plotOptions.radar.size;
      }

      this.dataRadiusOfPercent = [];
      this.dataRadius = [];
      this.angleArr = [];
      this.yaxisLabelsTextsPos = [];
    }

    _createClass(Radar, [{
      key: "draw",
      value: function draw(series) {
        var _this = this;

        var w = this.w;
        var fill = new Fill(this.ctx);
        var allSeries = [];
        var dataLabels = new DataLabels(this.ctx);

        if (series.length) {
          this.dataPointsLen = series[w.globals.maxValsInArrayIndex].length;
        }

        this.disAngle = Math.PI * 2 / this.dataPointsLen;
        var halfW = w.globals.gridWidth / 2;
        var halfH = w.globals.gridHeight / 2;
        var translateX = halfW + w.config.plotOptions.radar.offsetX;
        var translateY = halfH + w.config.plotOptions.radar.offsetY;
        var ret = this.graphics.group({
          class: 'apexcharts-radar-series apexcharts-plot-series',
          transform: "translate(".concat(translateX || 0, ", ").concat(translateY || 0, ")")
        });
        var dataPointsPos = [];
        var elPointsMain = null;
        var elDataPointsMain = null;
        this.yaxisLabels = this.graphics.group({
          class: 'apexcharts-yaxis'
        });
        series.forEach(function (s, i) {
          var longestSeries = s.length === w.globals.dataPoints;

          var elSeries = _this.graphics.group().attr({
            class: "apexcharts-series",
            'data:longestSeries': longestSeries,
            seriesName: Utils$1.escapeString(w.globals.seriesNames[i]),
            rel: i + 1,
            'data:realIndex': i
          });

          _this.dataRadiusOfPercent[i] = [];
          _this.dataRadius[i] = [];
          _this.angleArr[i] = [];
          s.forEach(function (dv, j) {
            var range = Math.abs(_this.maxValue - _this.minValue);
            dv = dv + Math.abs(_this.minValue);

            if (_this.isLog) {
              dv = _this.coreUtils.getLogVal(dv, 0);
            }

            _this.dataRadiusOfPercent[i][j] = dv / range;
            _this.dataRadius[i][j] = _this.dataRadiusOfPercent[i][j] * _this.size;
            _this.angleArr[i][j] = j * _this.disAngle;
          });
          dataPointsPos = _this.getDataPointsPos(_this.dataRadius[i], _this.angleArr[i]);

          var paths = _this.createPaths(dataPointsPos, {
            x: 0,
            y: 0
          });


          elPointsMain = _this.graphics.group({
            class: 'apexcharts-series-markers-wrap apexcharts-element-hidden'
          });

          elDataPointsMain = _this.graphics.group({
            class: "apexcharts-datalabels",
            'data:realIndex': i
          });
          w.globals.delayedElements.push({
            el: elPointsMain.node,
            index: i
          });
          var defaultRenderedPathOptions = {
            i: i,
            realIndex: i,
            animationDelay: i,
            initialSpeed: w.config.chart.animations.speed,
            dataChangeSpeed: w.config.chart.animations.dynamicAnimation.speed,
            className: "apexcharts-radar",
            shouldClipToGrid: false,
            bindEventsOnPaths: false,
            stroke: w.globals.stroke.colors[i],
            strokeLineCap: w.config.stroke.lineCap
          };
          var pathFrom = null;

          if (w.globals.previousPaths.length > 0) {
            pathFrom = _this.getPreviousPath(i);
          }

          for (var p = 0; p < paths.linePathsTo.length; p++) {
            var renderedLinePath = _this.graphics.renderPaths(_objectSpread2(_objectSpread2({}, defaultRenderedPathOptions), {}, {
              pathFrom: pathFrom === null ? paths.linePathsFrom[p] : pathFrom,
              pathTo: paths.linePathsTo[p],
              strokeWidth: Array.isArray(_this.strokeWidth) ? _this.strokeWidth[i] : _this.strokeWidth,
              fill: 'none',
              drawShadow: false
            }));

            elSeries.add(renderedLinePath);
            var pathFill = fill.fillPath({
              seriesNumber: i
            });

            var renderedAreaPath = _this.graphics.renderPaths(_objectSpread2(_objectSpread2({}, defaultRenderedPathOptions), {}, {
              pathFrom: pathFrom === null ? paths.areaPathsFrom[p] : pathFrom,
              pathTo: paths.areaPathsTo[p],
              strokeWidth: 0,
              fill: pathFill,
              drawShadow: false
            }));

            if (w.config.chart.dropShadow.enabled) {
              var filters = new Filters(_this.ctx);
              var shadow = w.config.chart.dropShadow;
              filters.dropShadow(renderedAreaPath, Object.assign({}, shadow, {
                noUserSpaceOnUse: true
              }), i);
            }

            elSeries.add(renderedAreaPath);
          }

          s.forEach(function (sj, j) {
            var markers = new Markers(_this.ctx);
            var opts = markers.getMarkerConfig({
              cssClass: 'apexcharts-marker',
              seriesIndex: i,
              dataPointIndex: j
            });

            var point = _this.graphics.drawMarker(dataPointsPos[j].x, dataPointsPos[j].y, opts);

            point.attr('rel', j);
            point.attr('j', j);
            point.attr('index', i);
            point.node.setAttribute('default-marker-size', opts.pSize);

            var elPointsWrap = _this.graphics.group({
              class: 'apexcharts-series-markers'
            });

            if (elPointsWrap) {
              elPointsWrap.add(point);
            }

            elPointsMain.add(elPointsWrap);
            elSeries.add(elPointsMain);
            var dataLabelsConfig = w.config.dataLabels;

            if (dataLabelsConfig.enabled) {
              var text = dataLabelsConfig.formatter(w.globals.series[i][j], {
                seriesIndex: i,
                dataPointIndex: j,
                w: w
              });
              dataLabels.plotDataLabelsText({
                x: dataPointsPos[j].x,
                y: dataPointsPos[j].y,
                text: text,
                textAnchor: 'middle',
                i: i,
                j: i,
                parent: elDataPointsMain,
                offsetCorrection: false,
                dataLabelsConfig: _objectSpread2({}, dataLabelsConfig)
              });
            }

            elSeries.add(elDataPointsMain);
          });
          allSeries.push(elSeries);
        });
        this.drawPolygons({
          parent: ret
        });

        if (w.config.xaxis.labels.show) {
          var xaxisTexts = this.drawXAxisTexts();
          ret.add(xaxisTexts);
        }

        allSeries.forEach(function (elS) {
          ret.add(elS);
        });
        ret.add(this.yaxisLabels);
        return ret;
      }
    }, {
      key: "drawPolygons",
      value: function drawPolygons(opts) {
        var _this2 = this;

        var w = this.w;
        var parent = opts.parent;
        var helpers = new CircularChartsHelpers(this.ctx);
        var yaxisTexts = w.globals.yAxisScale[0].result.reverse();
        var layers = yaxisTexts.length;
        var radiusSizes = [];
        var layerDis = this.size / (layers - 1);

        for (var i = 0; i < layers; i++) {
          radiusSizes[i] = layerDis * i;
        }

        radiusSizes.reverse();
        var polygonStrings = [];
        var lines = [];
        radiusSizes.forEach(function (radiusSize, r) {
          var polygon = Utils$1.getPolygonPos(radiusSize, _this2.dataPointsLen);
          var string = '';
          polygon.forEach(function (p, i) {
            if (r === 0) {
              var line = _this2.graphics.drawLine(p.x, p.y, 0, 0, Array.isArray(_this2.polygons.connectorColors) ? _this2.polygons.connectorColors[i] : _this2.polygons.connectorColors);

              lines.push(line);
            }

            if (i === 0) {
              _this2.yaxisLabelsTextsPos.push({
                x: p.x,
                y: p.y
              });
            }

            string += p.x + ',' + p.y + ' ';
          });
          polygonStrings.push(string);
        });
        polygonStrings.forEach(function (p, i) {
          var strokeColors = _this2.polygons.strokeColors;
          var strokeWidth = _this2.polygons.strokeWidth;

          var polygon = _this2.graphics.drawPolygon(p, Array.isArray(strokeColors) ? strokeColors[i] : strokeColors, Array.isArray(strokeWidth) ? strokeWidth[i] : strokeWidth, w.globals.radarPolygons.fill.colors[i]);

          parent.add(polygon);
        });
        lines.forEach(function (l) {
          parent.add(l);
        });

        if (w.config.yaxis[0].show) {
          this.yaxisLabelsTextsPos.forEach(function (p, i) {
            var yText = helpers.drawYAxisTexts(p.x, p.y, i, yaxisTexts[i]);

            _this2.yaxisLabels.add(yText);
          });
        }
      }
    }, {
      key: "drawXAxisTexts",
      value: function drawXAxisTexts() {
        var _this3 = this;

        var w = this.w;
        var xaxisLabelsConfig = w.config.xaxis.labels;
        var elXAxisWrap = this.graphics.group({
          class: 'apexcharts-xaxis'
        });
        var polygonPos = Utils$1.getPolygonPos(this.size, this.dataPointsLen);
        w.globals.labels.forEach(function (label, i) {
          var formatter = w.config.xaxis.labels.formatter;
          var dataLabels = new DataLabels(_this3.ctx);

          if (polygonPos[i]) {
            var textPos = _this3.getTextPos(polygonPos[i], _this3.size);

            var text = formatter(label, {
              seriesIndex: -1,
              dataPointIndex: i,
              w: w
            });
            dataLabels.plotDataLabelsText({
              x: textPos.newX,
              y: textPos.newY,
              text: text,
              textAnchor: textPos.textAnchor,
              i: i,
              j: i,
              parent: elXAxisWrap,
              color: Array.isArray(xaxisLabelsConfig.style.colors) && xaxisLabelsConfig.style.colors[i] ? xaxisLabelsConfig.style.colors[i] : '#a8a8a8',
              dataLabelsConfig: _objectSpread2({
                textAnchor: textPos.textAnchor,
                dropShadow: {
                  enabled: false
                }
              }, xaxisLabelsConfig),
              offsetCorrection: false
            });
          }
        });
        return elXAxisWrap;
      }
    }, {
      key: "createPaths",
      value: function createPaths(pos, origin) {
        var _this4 = this;

        var linePathsTo = [];
        var linePathsFrom = [];
        var areaPathsTo = [];
        var areaPathsFrom = [];

        if (pos.length) {
          linePathsFrom = [this.graphics.move(origin.x, origin.y)];
          areaPathsFrom = [this.graphics.move(origin.x, origin.y)];
          var linePathTo = this.graphics.move(pos[0].x, pos[0].y);
          var areaPathTo = this.graphics.move(pos[0].x, pos[0].y);
          pos.forEach(function (p, i) {
            linePathTo += _this4.graphics.line(p.x, p.y);
            areaPathTo += _this4.graphics.line(p.x, p.y);

            if (i === pos.length - 1) {
              linePathTo += 'Z';
              areaPathTo += 'Z';
            }
          });
          linePathsTo.push(linePathTo);
          areaPathsTo.push(areaPathTo);
        }

        return {
          linePathsFrom: linePathsFrom,
          linePathsTo: linePathsTo,
          areaPathsFrom: areaPathsFrom,
          areaPathsTo: areaPathsTo
        };
      }
    }, {
      key: "getTextPos",
      value: function getTextPos(pos, polygonSize) {
        var limit = 10;
        var textAnchor = 'middle';
        var newX = pos.x;
        var newY = pos.y;

        if (Math.abs(pos.x) >= limit) {
          if (pos.x > 0) {
            textAnchor = 'start';
            newX += 10;
          } else if (pos.x < 0) {
            textAnchor = 'end';
            newX -= 10;
          }
        } else {
          textAnchor = 'middle';
        }

        if (Math.abs(pos.y) >= polygonSize - limit) {
          if (pos.y < 0) {
            newY -= 10;
          } else if (pos.y > 0) {
            newY += 10;
          }
        }

        return {
          textAnchor: textAnchor,
          newX: newX,
          newY: newY
        };
      }
    }, {
      key: "getPreviousPath",
      value: function getPreviousPath(realIndex) {
        var w = this.w;
        var pathFrom = null;

        for (var pp = 0; pp < w.globals.previousPaths.length; pp++) {
          var gpp = w.globals.previousPaths[pp];

          if (gpp.paths.length > 0 && parseInt(gpp.realIndex, 10) === parseInt(realIndex, 10)) {
            if (typeof w.globals.previousPaths[pp].paths[0] !== 'undefined') {
              pathFrom = w.globals.previousPaths[pp].paths[0].d;
            }
          }
        }

        return pathFrom;
      }
    }, {
      key: "getDataPointsPos",
      value: function getDataPointsPos(dataRadiusArr, angleArr) {
        var dataPointsLen = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : this.dataPointsLen;
        dataRadiusArr = dataRadiusArr || [];
        angleArr = angleArr || [];
        var dataPointsPosArray = [];

        for (var j = 0; j < dataPointsLen; j++) {
          var curPointPos = {};
          curPointPos.x = dataRadiusArr[j] * Math.sin(angleArr[j]);
          curPointPos.y = -dataRadiusArr[j] * Math.cos(angleArr[j]);
          dataPointsPosArray.push(curPointPos);
        }

        return dataPointsPosArray;
      }
    }]);

    return Radar;
  }();

  /**
   * ApexCharts Radial Class for drawing Circle / Semi Circle Charts.
   * @module Radial
   **/

  var Radial = /*#__PURE__*/function (_Pie) {
    _inherits(Radial, _Pie);

    var _super = _createSuper(Radial);

    function Radial(ctx) {
      var _this;

      _classCallCheck(this, Radial);

      _this = _super.call(this, ctx);
      _this.ctx = ctx;
      _this.w = ctx.w;
      _this.animBeginArr = [0];
      _this.animDur = 0;
      var w = _this.w;
      _this.startAngle = w.config.plotOptions.radialBar.startAngle;
      _this.endAngle = w.config.plotOptions.radialBar.endAngle;
      _this.totalAngle = Math.abs(w.config.plotOptions.radialBar.endAngle - w.config.plotOptions.radialBar.startAngle);
      _this.trackStartAngle = w.config.plotOptions.radialBar.track.startAngle;
      _this.trackEndAngle = w.config.plotOptions.radialBar.track.endAngle;
      _this.donutDataLabels = _this.w.config.plotOptions.radialBar.dataLabels;
      _this.radialDataLabels = _this.donutDataLabels;

      if (!_this.trackStartAngle) _this.trackStartAngle = _this.startAngle;
      if (!_this.trackEndAngle) _this.trackEndAngle = _this.endAngle;
      if (_this.endAngle === 360) _this.endAngle = 359.99;
      _this.margin = parseInt(w.config.plotOptions.radialBar.track.margin, 10);
      return _this;
    }

    _createClass(Radial, [{
      key: "draw",
      value: function draw(series) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var ret = graphics.group({
          class: 'apexcharts-radialbar'
        });
        if (w.globals.noData) return ret;
        var elSeries = graphics.group();
        var centerY = this.defaultSize / 2;
        var centerX = w.globals.gridWidth / 2;
        var size = this.defaultSize / 2.05;

        if (!w.config.chart.sparkline.enabled) {
          size = size - w.config.stroke.width - w.config.chart.dropShadow.blur;
        }

        var colorArr = w.globals.fill.colors;

        if (w.config.plotOptions.radialBar.track.show) {
          var elTracks = this.drawTracks({
            size: size,
            centerX: centerX,
            centerY: centerY,
            colorArr: colorArr,
            series: series
          });
          elSeries.add(elTracks);
        }

        var elG = this.drawArcs({
          size: size,
          centerX: centerX,
          centerY: centerY,
          colorArr: colorArr,
          series: series
        });
        var totalAngle = 360;

        if (w.config.plotOptions.radialBar.startAngle < 0) {
          totalAngle = this.totalAngle;
        }

        var angleRatio = (360 - totalAngle) / 360;
        w.globals.radialSize = size - size * angleRatio;

        if (this.radialDataLabels.value.show) {
          var offset = Math.max(this.radialDataLabels.value.offsetY, this.radialDataLabels.name.offsetY);
          w.globals.radialSize += offset * angleRatio;
        }

        elSeries.add(elG.g);

        if (w.config.plotOptions.radialBar.hollow.position === 'front') {
          elG.g.add(elG.elHollow);

          if (elG.dataLabels) {
            elG.g.add(elG.dataLabels);
          }
        }

        ret.add(elSeries);
        return ret;
      }
    }, {
      key: "drawTracks",
      value: function drawTracks(opts) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var g = graphics.group({
          class: 'apexcharts-tracks'
        });
        var filters = new Filters(this.ctx);
        var fill = new Fill(this.ctx);
        var strokeWidth = this.getStrokeWidth(opts);
        opts.size = opts.size - strokeWidth / 2;

        for (var i = 0; i < opts.series.length; i++) {
          var elRadialBarTrack = graphics.group({
            class: 'apexcharts-radialbar-track apexcharts-track'
          });
          g.add(elRadialBarTrack);
          elRadialBarTrack.attr({
            rel: i + 1
          });
          opts.size = opts.size - strokeWidth - this.margin;
          var trackConfig = w.config.plotOptions.radialBar.track;
          var pathFill = fill.fillPath({
            seriesNumber: 0,
            size: opts.size,
            fillColors: Array.isArray(trackConfig.background) ? trackConfig.background[i] : trackConfig.background,
            solid: true
          });
          var startAngle = this.trackStartAngle;
          var endAngle = this.trackEndAngle;
          if (Math.abs(endAngle) + Math.abs(startAngle) >= 360) endAngle = 360 - Math.abs(this.startAngle) - 0.1;
          var elPath = graphics.drawPath({
            d: '',
            stroke: pathFill,
            strokeWidth: strokeWidth * parseInt(trackConfig.strokeWidth, 10) / 100,
            fill: 'none',
            strokeOpacity: trackConfig.opacity,
            classes: 'apexcharts-radialbar-area'
          });

          if (trackConfig.dropShadow.enabled) {
            var shadow = trackConfig.dropShadow;
            filters.dropShadow(elPath, shadow);
          }

          elRadialBarTrack.add(elPath);
          elPath.attr('id', 'apexcharts-radialbarTrack-' + i);
          this.animatePaths(elPath, {
            centerX: opts.centerX,
            centerY: opts.centerY,
            endAngle: endAngle,
            startAngle: startAngle,
            size: opts.size,
            i: i,
            totalItems: 2,
            animBeginArr: 0,
            dur: 0,
            isTrack: true,
            easing: w.globals.easing
          });
        }

        return g;
      }
    }, {
      key: "drawArcs",
      value: function drawArcs(opts) {
        var w = this.w;

        var graphics = new Graphics(this.ctx);
        var fill = new Fill(this.ctx);
        var filters = new Filters(this.ctx);
        var g = graphics.group();
        var strokeWidth = this.getStrokeWidth(opts);
        opts.size = opts.size - strokeWidth / 2;
        var hollowFillID = w.config.plotOptions.radialBar.hollow.background;
        var hollowSize = opts.size - strokeWidth * opts.series.length - this.margin * opts.series.length - strokeWidth * parseInt(w.config.plotOptions.radialBar.track.strokeWidth, 10) / 100 / 2;
        var hollowRadius = hollowSize - w.config.plotOptions.radialBar.hollow.margin;

        if (w.config.plotOptions.radialBar.hollow.image !== undefined) {
          hollowFillID = this.drawHollowImage(opts, g, hollowSize, hollowFillID);
        }

        var elHollow = this.drawHollow({
          size: hollowRadius,
          centerX: opts.centerX,
          centerY: opts.centerY,
          fill: hollowFillID ? hollowFillID : 'transparent'
        });

        if (w.config.plotOptions.radialBar.hollow.dropShadow.enabled) {
          var shadow = w.config.plotOptions.radialBar.hollow.dropShadow;
          filters.dropShadow(elHollow, shadow);
        }

        var shown = 1;

        if (!this.radialDataLabels.total.show && w.globals.series.length > 1) {
          shown = 0;
        }

        var dataLabels = null;

        if (this.radialDataLabels.show) {
          dataLabels = this.renderInnerDataLabels(this.radialDataLabels, {
            hollowSize: hollowSize,
            centerX: opts.centerX,
            centerY: opts.centerY,
            opacity: shown
          });
        }

        if (w.config.plotOptions.radialBar.hollow.position === 'back') {
          g.add(elHollow);

          if (dataLabels) {
            g.add(dataLabels);
          }
        }

        var reverseLoop = false;

        if (w.config.plotOptions.radialBar.inverseOrder) {
          reverseLoop = true;
        }

        for (var i = reverseLoop ? opts.series.length - 1 : 0; reverseLoop ? i >= 0 : i < opts.series.length; reverseLoop ? i-- : i++) {
          var elRadialBarArc = graphics.group({
            class: "apexcharts-series apexcharts-radial-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[i])
          });
          g.add(elRadialBarArc);
          elRadialBarArc.attr({
            rel: i + 1,
            'data:realIndex': i
          });
          this.ctx.series.addCollapsedClassToSeries(elRadialBarArc, i);
          opts.size = opts.size - strokeWidth - this.margin;
          var pathFill = fill.fillPath({
            seriesNumber: i,
            size: opts.size,
            value: opts.series[i]
          });
          var startAngle = this.startAngle;
          var prevStartAngle = void 0;

          var dataValue = Utils$1.negToZero(opts.series[i] > 100 ? 100 : opts.series[i]) / 100;
          var endAngle = Math.round(this.totalAngle * dataValue) + this.startAngle;
          var prevEndAngle = void 0;

          if (w.globals.dataChanged) {
            prevStartAngle = this.startAngle;
            prevEndAngle = Math.round(this.totalAngle * Utils$1.negToZero(w.globals.previousPaths[i]) / 100) + prevStartAngle;
          }

          var currFullAngle = Math.abs(endAngle) + Math.abs(startAngle);

          if (currFullAngle >= 360) {
            endAngle = endAngle - 0.01;
          }

          var prevFullAngle = Math.abs(prevEndAngle) + Math.abs(prevStartAngle);

          if (prevFullAngle >= 360) {
            prevEndAngle = prevEndAngle - 0.01;
          }

          var angle = endAngle - startAngle;
          var dashArray = Array.isArray(w.config.stroke.dashArray) ? w.config.stroke.dashArray[i] : w.config.stroke.dashArray;
          var elPath = graphics.drawPath({
            d: '',
            stroke: pathFill,
            strokeWidth: strokeWidth,
            fill: 'none',
            fillOpacity: w.config.fill.opacity,
            classes: 'apexcharts-radialbar-area apexcharts-radialbar-slice-' + i,
            strokeDashArray: dashArray
          });
          Graphics.setAttrs(elPath.node, {
            'data:angle': angle,
            'data:value': opts.series[i]
          });

          if (w.config.chart.dropShadow.enabled) {
            var _shadow = w.config.chart.dropShadow;
            filters.dropShadow(elPath, _shadow, i);
          }

          filters.setSelectionFilter(elPath, 0, i);
          this.addListeners(elPath, this.radialDataLabels);
          elRadialBarArc.add(elPath);
          elPath.attr({
            index: 0,
            j: i
          });
          var dur = 0;

          if (this.initialAnim && !w.globals.resized && !w.globals.dataChanged) {
            dur = w.config.chart.animations.speed;
          }

          if (w.globals.dataChanged) {
            dur = w.config.chart.animations.dynamicAnimation.speed;
          }

          this.animDur = dur / (opts.series.length * 1.2) + this.animDur;
          this.animBeginArr.push(this.animDur);
          this.animatePaths(elPath, {
            centerX: opts.centerX,
            centerY: opts.centerY,
            endAngle: endAngle,
            startAngle: startAngle,
            prevEndAngle: prevEndAngle,
            prevStartAngle: prevStartAngle,
            size: opts.size,
            i: i,
            totalItems: 2,
            animBeginArr: this.animBeginArr,
            dur: dur,
            shouldSetPrevPaths: true,
            easing: w.globals.easing
          });
        }

        return {
          g: g,
          elHollow: elHollow,
          dataLabels: dataLabels
        };
      }
    }, {
      key: "drawHollow",
      value: function drawHollow(opts) {
        var graphics = new Graphics(this.ctx);
        var circle = graphics.drawCircle(opts.size * 2);
        circle.attr({
          class: 'apexcharts-radialbar-hollow',
          cx: opts.centerX,
          cy: opts.centerY,
          r: opts.size,
          fill: opts.fill
        });
        return circle;
      }
    }, {
      key: "drawHollowImage",
      value: function drawHollowImage(opts, g, hollowSize, hollowFillID) {
        var w = this.w;
        var fill = new Fill(this.ctx);
        var randID = Utils$1.randomId();
        var hollowFillImg = w.config.plotOptions.radialBar.hollow.image;

        if (w.config.plotOptions.radialBar.hollow.imageClipped) {
          fill.clippedImgArea({
            width: hollowSize,
            height: hollowSize,
            image: hollowFillImg,
            patternID: "pattern".concat(w.globals.cuid).concat(randID)
          });
          hollowFillID = "url(#pattern".concat(w.globals.cuid).concat(randID, ")");
        } else {
          var imgWidth = w.config.plotOptions.radialBar.hollow.imageWidth;
          var imgHeight = w.config.plotOptions.radialBar.hollow.imageHeight;

          if (imgWidth === undefined && imgHeight === undefined) {
            var image = w.globals.dom.Paper.image(hollowFillImg).loaded(function (loader) {
              this.move(opts.centerX - loader.width / 2 + w.config.plotOptions.radialBar.hollow.imageOffsetX, opts.centerY - loader.height / 2 + w.config.plotOptions.radialBar.hollow.imageOffsetY);
            });
            g.add(image);
          } else {
            var _image = w.globals.dom.Paper.image(hollowFillImg).loaded(function (loader) {
              this.move(opts.centerX - imgWidth / 2 + w.config.plotOptions.radialBar.hollow.imageOffsetX, opts.centerY - imgHeight / 2 + w.config.plotOptions.radialBar.hollow.imageOffsetY);
              this.size(imgWidth, imgHeight);
            });

            g.add(_image);
          }
        }

        return hollowFillID;
      }
    }, {
      key: "getStrokeWidth",
      value: function getStrokeWidth(opts) {
        var w = this.w;
        return opts.size * (100 - parseInt(w.config.plotOptions.radialBar.hollow.size, 10)) / 100 / (opts.series.length + 1) - this.margin;
      }
    }]);

    return Radial;
  }(Pie);

  /**
   * ApexCharts RangeBar Class responsible for drawing Range/Timeline Bars.
   *
   * @module RangeBar
   **/

  var RangeBar = /*#__PURE__*/function (_Bar) {
    _inherits(RangeBar, _Bar);

    var _super = _createSuper(RangeBar);

    function RangeBar() {
      _classCallCheck(this, RangeBar);

      return _super.apply(this, arguments);
    }

    _createClass(RangeBar, [{
      key: "draw",
      value: function draw(series, seriesIndex) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        this.rangeBarOptions = this.w.config.plotOptions.rangeBar;
        this.series = series;
        this.seriesRangeStart = w.globals.seriesRangeStart;
        this.seriesRangeEnd = w.globals.seriesRangeEnd;
        this.barHelpers.initVariables(series);
        var ret = graphics.group({
          class: 'apexcharts-rangebar-series apexcharts-plot-series'
        });

        for (var i = 0; i < series.length; i++) {
          var x = void 0,
              y = void 0,
              xDivision = void 0,

          yDivision = void 0,

          zeroH = void 0,

          zeroW = void 0;

          var realIndex = w.globals.comboCharts ? seriesIndex[i] : i;

          var elSeries = graphics.group({
            class: "apexcharts-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[realIndex]),
            rel: i + 1,
            'data:realIndex': realIndex
          });
          this.ctx.series.addCollapsedClassToSeries(elSeries, realIndex);

          if (series[i].length > 0) {
            this.visibleI = this.visibleI + 1;
          }

          var barHeight = 0;
          var barWidth = 0;

          if (this.yRatio.length > 1) {
            this.yaxisIndex = realIndex;
          }

          var initPositions = this.barHelpers.initialPositions();
          y = initPositions.y;
          zeroW = initPositions.zeroW;
          x = initPositions.x;
          barWidth = initPositions.barWidth;
          xDivision = initPositions.xDivision;
          zeroH = initPositions.zeroH;

          var elDataLabelsWrap = graphics.group({
            class: 'apexcharts-datalabels',
            'data:realIndex': realIndex
          });
          var elGoalsMarkers = graphics.group({
            class: 'apexcharts-rangebar-goals-markers',
            style: "pointer-events: none"
          });

          for (var j = 0; j < w.globals.dataPoints; j++) {
            var strokeWidth = this.barHelpers.getStrokeWidth(i, j, realIndex);
            var y1 = this.seriesRangeStart[i][j];
            var y2 = this.seriesRangeEnd[i][j];
            var paths = null;
            var barYPosition = null;
            var params = {
              x: x,
              y: y,
              strokeWidth: strokeWidth,
              elSeries: elSeries
            };
            yDivision = initPositions.yDivision;
            barHeight = initPositions.barHeight;

            if (this.isHorizontal) {
              barYPosition = y + barHeight * this.visibleI;
              var seriesLen = this.seriesLen;

              if (w.config.plotOptions.bar.rangeBarGroupRows) {
                seriesLen = 1;
              }

              var srty = (yDivision - barHeight * seriesLen) / 2;

              if (typeof w.config.series[i].data[j] === 'undefined') {


                break;
              }

              if (w.config.series[i].data[j].x) {
                var positions = this.detectOverlappingBars({
                  i: i,
                  j: j,
                  barYPosition: barYPosition,
                  srty: srty,
                  barHeight: barHeight,
                  yDivision: yDivision,
                  initPositions: initPositions
                });
                barHeight = positions.barHeight;
                barYPosition = positions.barYPosition;
              }

              paths = this.drawRangeBarPaths(_objectSpread2({
                indexes: {
                  i: i,
                  j: j,
                  realIndex: realIndex
                },
                barHeight: barHeight,
                barYPosition: barYPosition,
                zeroW: zeroW,
                yDivision: yDivision,
                y1: y1,
                y2: y2
              }, params));
              barWidth = paths.barWidth;
            } else {
              paths = this.drawRangeColumnPaths(_objectSpread2({
                indexes: {
                  i: i,
                  j: j,
                  realIndex: realIndex
                },
                zeroH: zeroH,
                barWidth: barWidth,
                xDivision: xDivision
              }, params));
              barHeight = paths.barHeight;
            }

            var barGoalLine = this.barHelpers.drawGoalLine({
              barXPosition: paths.barXPosition,
              barYPosition: barYPosition,
              goalX: paths.goalX,
              goalY: paths.goalY,
              barHeight: barHeight,
              barWidth: barWidth
            });

            if (barGoalLine) {
              elGoalsMarkers.add(barGoalLine);
            }

            y = paths.y;
            x = paths.x;
            var pathFill = this.barHelpers.getPathFillColor(series, i, j, realIndex);
            var lineFill = w.globals.stroke.colors[realIndex];
            this.renderSeries({
              realIndex: realIndex,
              pathFill: pathFill,
              lineFill: lineFill,
              j: j,
              i: i,
              x: x,
              y: y,
              y1: y1,
              y2: y2,
              pathFrom: paths.pathFrom,
              pathTo: paths.pathTo,
              strokeWidth: strokeWidth,
              elSeries: elSeries,
              series: series,
              barHeight: barHeight,
              barYPosition: barYPosition,
              barWidth: barWidth,
              elDataLabelsWrap: elDataLabelsWrap,
              elGoalsMarkers: elGoalsMarkers,
              visibleSeries: this.visibleI,
              type: 'rangebar'
            });
          }

          ret.add(elSeries);
        }

        return ret;
      }
    }, {
      key: "detectOverlappingBars",
      value: function detectOverlappingBars(_ref) {
        var i = _ref.i,
            j = _ref.j,
            barYPosition = _ref.barYPosition,
            srty = _ref.srty,
            barHeight = _ref.barHeight,
            yDivision = _ref.yDivision,
            initPositions = _ref.initPositions;
        var w = this.w;
        var overlaps = [];
        var rangeName = w.config.series[i].data[j].rangeName;
        var labelX = w.config.series[i].data[j].x;
        var rowIndex = w.globals.labels.indexOf(labelX);
        var overlappedIndex = w.globals.seriesRange[i].findIndex(function (tx) {
          return tx.x === labelX && tx.overlaps.length > 0;
        });

        if (w.config.plotOptions.bar.rangeBarGroupRows) {
          barYPosition = srty + yDivision * rowIndex;
        } else {
          barYPosition = srty + barHeight * this.visibleI + yDivision * rowIndex;
        }

        if (overlappedIndex > -1 && !w.config.plotOptions.bar.rangeBarOverlap) {
          overlaps = w.globals.seriesRange[i][overlappedIndex].overlaps;

          if (overlaps.indexOf(rangeName) > -1) {
            barHeight = initPositions.barHeight / overlaps.length;
            barYPosition = barHeight * this.visibleI + yDivision * (100 - parseInt(this.barOptions.barHeight, 10)) / 100 / 2 + barHeight * (this.visibleI + overlaps.indexOf(rangeName)) + yDivision * rowIndex;
          }
        }

        return {
          barYPosition: barYPosition,
          barHeight: barHeight
        };
      }
    }, {
      key: "drawRangeColumnPaths",
      value: function drawRangeColumnPaths(_ref2) {
        var indexes = _ref2.indexes,
            x = _ref2.x;
            _ref2.strokeWidth;
            var xDivision = _ref2.xDivision,
            barWidth = _ref2.barWidth,
            zeroH = _ref2.zeroH;
        var w = this.w;
        var i = indexes.i;
        var j = indexes.j;
        var yRatio = this.yRatio[this.yaxisIndex];
        var realIndex = indexes.realIndex;
        var range = this.getRangeValue(realIndex, j);
        var y1 = Math.min(range.start, range.end);
        var y2 = Math.max(range.start, range.end);

        if (w.globals.isXNumeric) {
          x = (w.globals.seriesX[i][j] - w.globals.minX) / this.xRatio - barWidth / 2;
        }

        var barXPosition = x + barWidth * this.visibleI;

        if (typeof this.series[i][j] === 'undefined' || this.series[i][j] === null) {
          y1 = zeroH;
        } else {
          y1 = zeroH - y1 / yRatio;
          y2 = zeroH - y2 / yRatio;
        }

        var barHeight = Math.abs(y2 - y1);
        var paths = this.barHelpers.getColumnPaths({
          barXPosition: barXPosition,
          barWidth: barWidth,
          y1: y1,
          y2: y2,
          strokeWidth: this.strokeWidth,
          series: this.seriesRangeEnd,
          realIndex: indexes.realIndex,
          i: realIndex,
          j: j,
          w: w
        });

        if (!w.globals.isXNumeric) {
          x = x + xDivision;
        }

        return {
          pathTo: paths.pathTo,
          pathFrom: paths.pathFrom,
          barHeight: barHeight,
          x: x,
          y: y2,
          goalY: this.barHelpers.getGoalValues('y', null, zeroH, i, j),
          barXPosition: barXPosition
        };
      }
    }, {
      key: "drawRangeBarPaths",
      value: function drawRangeBarPaths(_ref3) {
        var indexes = _ref3.indexes,
            y = _ref3.y,
            y1 = _ref3.y1,
            y2 = _ref3.y2,
            yDivision = _ref3.yDivision,
            barHeight = _ref3.barHeight,
            barYPosition = _ref3.barYPosition,
            zeroW = _ref3.zeroW;
        var w = this.w;
        var x1 = zeroW + y1 / this.invertedYRatio;
        var x2 = zeroW + y2 / this.invertedYRatio;
        var barWidth = Math.abs(x2 - x1);
        var paths = this.barHelpers.getBarpaths({
          barYPosition: barYPosition,
          barHeight: barHeight,
          x1: x1,
          x2: x2,
          strokeWidth: this.strokeWidth,
          series: this.seriesRangeEnd,
          i: indexes.realIndex,
          realIndex: indexes.realIndex,
          j: indexes.j,
          w: w
        });

        if (!w.globals.isXNumeric) {
          y = y + yDivision;
        }

        return {
          pathTo: paths.pathTo,
          pathFrom: paths.pathFrom,
          barWidth: barWidth,
          x: x2,
          goalX: this.barHelpers.getGoalValues('x', zeroW, null, indexes.realIndex, indexes.j),
          y: y
        };
      }
    }, {
      key: "getRangeValue",
      value: function getRangeValue(i, j) {
        var w = this.w;
        return {
          start: w.globals.seriesRangeStart[i][j],
          end: w.globals.seriesRangeEnd[i][j]
        };
      }
    }]);

    return RangeBar;
  }(Bar);

  var Helpers = /*#__PURE__*/function () {
    function Helpers(lineCtx) {
      _classCallCheck(this, Helpers);

      this.w = lineCtx.w;
      this.lineCtx = lineCtx;
    }

    _createClass(Helpers, [{
      key: "sameValueSeriesFix",
      value: function sameValueSeriesFix(i, series) {
        var w = this.w;

        if (w.config.fill.type === 'gradient' || w.config.fill.type[i] === 'gradient') {
          var coreUtils = new CoreUtils(this.lineCtx.ctx, w);


          /* #fix https://github.com/apexcharts/apexcharts.js/issues/358 */

          if (coreUtils.seriesHaveSameValues(i)) {
            var gSeries = series[i].slice();
            gSeries[gSeries.length - 1] = gSeries[gSeries.length - 1] + 0.000001;
            series[i] = gSeries;
          }
        }

        return series;
      }
    }, {
      key: "calculatePoints",
      value: function calculatePoints(_ref) {
        var series = _ref.series,
            realIndex = _ref.realIndex,
            x = _ref.x,
            y = _ref.y,
            i = _ref.i,
            j = _ref.j,
            prevY = _ref.prevY;
        var w = this.w;
        var ptX = [];
        var ptY = [];

        if (j === 0) {
          var xPT1st = this.lineCtx.categoryAxisCorrection + w.config.markers.offsetX;



          if (w.globals.isXNumeric) {
            xPT1st = (w.globals.seriesX[realIndex][0] - w.globals.minX) / this.lineCtx.xRatio + w.config.markers.offsetX;
          }


          ptX.push(xPT1st);
          ptY.push(Utils$1.isNumber(series[i][0]) ? prevY + w.config.markers.offsetY : null);
          ptX.push(x + w.config.markers.offsetX);
          ptY.push(Utils$1.isNumber(series[i][j + 1]) ? y + w.config.markers.offsetY : null);
        } else {
          ptX.push(x + w.config.markers.offsetX);
          ptY.push(Utils$1.isNumber(series[i][j + 1]) ? y + w.config.markers.offsetY : null);
        }

        var pointsPos = {
          x: ptX,
          y: ptY
        };
        return pointsPos;
      }
    }, {
      key: "checkPreviousPaths",
      value: function checkPreviousPaths(_ref2) {
        var pathFromLine = _ref2.pathFromLine,
            pathFromArea = _ref2.pathFromArea,
            realIndex = _ref2.realIndex;
        var w = this.w;

        for (var pp = 0; pp < w.globals.previousPaths.length; pp++) {
          var gpp = w.globals.previousPaths[pp];

          if ((gpp.type === 'line' || gpp.type === 'area') && gpp.paths.length > 0 && parseInt(gpp.realIndex, 10) === parseInt(realIndex, 10)) {
            if (gpp.type === 'line') {
              this.lineCtx.appendPathFrom = false;
              pathFromLine = w.globals.previousPaths[pp].paths[0].d;
            } else if (gpp.type === 'area') {
              this.lineCtx.appendPathFrom = false;
              pathFromArea = w.globals.previousPaths[pp].paths[0].d;

              if (w.config.stroke.show && w.globals.previousPaths[pp].paths[1]) {
                pathFromLine = w.globals.previousPaths[pp].paths[1].d;
              }
            }
          }
        }

        return {
          pathFromLine: pathFromLine,
          pathFromArea: pathFromArea
        };
      }
    }, {
      key: "determineFirstPrevY",
      value: function determineFirstPrevY(_ref3) {
        var _series$i;

        var i = _ref3.i,
            series = _ref3.series,
            prevY = _ref3.prevY,
            lineYPosition = _ref3.lineYPosition;
        var w = this.w;

        if (typeof ((_series$i = series[i]) === null || _series$i === void 0 ? void 0 : _series$i[0]) !== 'undefined') {
          if (w.config.chart.stacked) {
            if (i > 0) {

              lineYPosition = this.lineCtx.prevSeriesY[i - 1][0];
            } else {

              lineYPosition = this.lineCtx.zeroY;
            }
          } else {
            lineYPosition = this.lineCtx.zeroY;
          }

          prevY = lineYPosition - series[i][0] / this.lineCtx.yRatio[this.lineCtx.yaxisIndex] + (this.lineCtx.isReversed ? series[i][0] / this.lineCtx.yRatio[this.lineCtx.yaxisIndex] : 0) * 2;
        } else {

          if (w.config.chart.stacked && i > 0 && typeof series[i][0] === 'undefined') {

            for (var s = i - 1; s >= 0; s--) {

              if (series[s][0] !== null && typeof series[s][0] !== 'undefined') {
                lineYPosition = this.lineCtx.prevSeriesY[s][0];
                prevY = lineYPosition;
                break;
              }
            }
          }
        }

        return {
          prevY: prevY,
          lineYPosition: lineYPosition
        };
      }
    }]);

    return Helpers;
  }();

  /**
   * ApexCharts Line Class responsible for drawing Line / Area / RangeArea Charts.
   * This class is also responsible for generating values for Bubble/Scatter charts, so need to rename it to Axis Charts to avoid confusions
   * @module Line
   **/

  var Line = /*#__PURE__*/function () {
    function Line(ctx, xyRatios, isPointsChart) {
      _classCallCheck(this, Line);

      this.ctx = ctx;
      this.w = ctx.w;
      this.xyRatios = xyRatios;
      this.pointsChart = !(this.w.config.chart.type !== 'bubble' && this.w.config.chart.type !== 'scatter') || isPointsChart;
      this.scatter = new Scatter(this.ctx);
      this.noNegatives = this.w.globals.minX === Number.MAX_VALUE;
      this.lineHelpers = new Helpers(this);
      this.markers = new Markers(this.ctx);
      this.prevSeriesY = [];
      this.categoryAxisCorrection = 0;
      this.yaxisIndex = 0;
    }

    _createClass(Line, [{
      key: "draw",
      value: function draw(series, ctype, seriesIndex, seriesRangeEnd) {
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var type = w.globals.comboCharts ? ctype : w.config.chart.type;
        var ret = graphics.group({
          class: "apexcharts-".concat(type, "-series apexcharts-plot-series")
        });
        var coreUtils = new CoreUtils(this.ctx, w);
        this.yRatio = this.xyRatios.yRatio;
        this.zRatio = this.xyRatios.zRatio;
        this.xRatio = this.xyRatios.xRatio;
        this.baseLineY = this.xyRatios.baseLineY;
        series = coreUtils.getLogSeries(series);
        this.yRatio = coreUtils.getLogYRatios(this.yRatio);

        var allSeries = [];

        for (var i = 0; i < series.length; i++) {
          series = this.lineHelpers.sameValueSeriesFix(i, series);
          var realIndex = w.globals.comboCharts ? seriesIndex[i] : i;

          this._initSerieVariables(series, i, realIndex);

          var yArrj = [];

          var xArrj = [];

          var x = w.globals.padHorizontal + this.categoryAxisCorrection;
          var y = 1;
          var linePaths = [];
          var areaPaths = [];
          this.ctx.series.addCollapsedClassToSeries(this.elSeries, realIndex);

          if (w.globals.isXNumeric && w.globals.seriesX.length > 0) {
            x = (w.globals.seriesX[realIndex][0] - w.globals.minX) / this.xRatio;
          }

          xArrj.push(x);
          var pX = x;
          var pY = void 0;
          var pY2 = void 0;
          var prevX = pX;
          var prevY = this.zeroY;
          var prevY2 = this.zeroY;
          var lineYPosition = 0;

          var firstPrevY = this.lineHelpers.determineFirstPrevY({
            i: i,
            series: series,
            prevY: prevY,
            lineYPosition: lineYPosition
          });
          prevY = firstPrevY.prevY;
          yArrj.push(prevY);
          pY = prevY;

          var firstPrevY2 = void 0;

          if (type === 'rangeArea') {
            firstPrevY2 = this.lineHelpers.determineFirstPrevY({
              i: i,
              series: seriesRangeEnd,
              prevY: prevY2,
              lineYPosition: lineYPosition
            });
            prevY2 = firstPrevY2.prevY;
            pY2 = prevY2;
          }

          var pathsFrom = this._calculatePathsFrom({
            type: type,
            series: series,
            i: i,
            realIndex: realIndex,
            prevX: prevX,
            prevY: prevY,
            prevY2: prevY2
          });

          var iteratingOpts = {
            type: type,
            series: series,
            realIndex: realIndex,
            i: i,
            x: x,
            y: y,
            pX: pX,
            pY: pY,
            pathsFrom: pathsFrom,
            linePaths: linePaths,
            areaPaths: areaPaths,
            seriesIndex: seriesIndex,
            lineYPosition: lineYPosition,
            xArrj: xArrj,
            yArrj: yArrj,
            seriesRangeEnd: seriesRangeEnd
          };

          var paths = this._iterateOverDataPoints(_objectSpread2(_objectSpread2({}, iteratingOpts), {}, {
            iterations: type === 'rangeArea' ? series[i].length - 1 : undefined,
            isRangeStart: true
          }));

          if (type === 'rangeArea') {
            var pathsFrom2 = this._calculatePathsFrom({
              series: seriesRangeEnd,
              i: i,
              realIndex: realIndex,
              prevX: prevX,
              prevY: prevY2
            });

            var rangePaths = this._iterateOverDataPoints(_objectSpread2(_objectSpread2({}, iteratingOpts), {}, {
              series: seriesRangeEnd,
              pY: pY2,
              pathsFrom: pathsFrom2,
              iterations: seriesRangeEnd[i].length - 1,
              isRangeStart: false
            }));

            paths.linePaths[0] = rangePaths.linePath + paths.linePath;
            paths.pathFromLine = rangePaths.pathFromLine + paths.pathFromLine;
          }

          this._handlePaths({
            type: type,
            realIndex: realIndex,
            i: i,
            paths: paths
          });

          this.elSeries.add(this.elPointsMain);
          this.elSeries.add(this.elDataLabelsWrap);
          allSeries.push(this.elSeries);
        }

        if (w.config.chart.stacked) {
          for (var s = allSeries.length; s > 0; s--) {
            ret.add(allSeries[s - 1]);
          }
        } else {
          for (var _s = 0; _s < allSeries.length; _s++) {
            ret.add(allSeries[_s]);
          }
        }

        return ret;
      }
    }, {
    {
          var pathFill = fill.fillPath({
            seriesNumber: realIndex
          });

          for (var p = 0; p < paths.areaPaths.length; p++) {
            var renderedPath = graphics.renderPaths(_objectSpread2(_objectSpread2({}, defaultRenderedPathOptions), {}, {
              pathFrom: paths.pathFromArea,
              pathTo: paths.areaPaths[p],
              stroke: 'none',
              strokeWidth: 0,
              strokeLineCap: null,
              fill: pathFill
            }));
            this.elSeries.add(renderedPath);
          }
        }

        if (w.config.stroke.show && !this.pointsChart) {
          var lineFill = null;

          if (type === 'line') {
            lineFill = fill.fillPath({
              seriesNumber: realIndex,
              i: i
            });
          } else {
            if (w.config.stroke.fill.type === 'solid') {
              lineFill = w.globals.stroke.colors[realIndex];
            } else {
              var prevFill = w.config.fill;
              w.config.fill = w.config.stroke.fill;
              lineFill = fill.fillPath({
                seriesNumber: realIndex,
                i: i
              });
              w.config.fill = prevFill;
            }
          }


          for (var _p = 0; _p < paths.linePaths.length; _p++) {
            var _pathFill = lineFill;

            if (type === 'rangeArea') {
              _pathFill = fill.fillPath({
                seriesNumber: realIndex
              });
            }

            var linePathCommonOpts = _objectSpread2(_objectSpread2({}, defaultRenderedPathOptions), {}, {
              pathFrom: paths.pathFromLine,
              pathTo: paths.linePaths[_p],
              stroke: lineFill,
              strokeWidth: this.strokeWidth,
              strokeLineCap: w.config.stroke.lineCap,
              fill: type === 'rangeArea' ? _pathFill : 'none'
            });

            var _renderedPath = graphics.renderPaths(linePathCommonOpts);

            this.elSeries.add(_renderedPath);

            _renderedPath.attr('fill-rule', "evenodd");

            if (forecast.count > 0 && type !== 'rangeArea') {
              var renderedForecastPath = graphics.renderPaths(linePathCommonOpts);
              renderedForecastPath.node.setAttribute('stroke-dasharray', forecast.dashArray);

              if (forecast.strokeWidth) {
                renderedForecastPath.node.setAttribute('stroke-width', forecast.strokeWidth);
              }

              this.elSeries.add(renderedForecastPath);
              renderedForecastPath.attr('clip-path', "url(#forecastMask".concat(w.globals.cuid, ")"));

              _renderedPath.attr('clip-path', "url(#nonForecastMask".concat(w.globals.cuid, ")"));
            }
          }
        }
      }
    }, {
      key: "_iterateOverDataPoints",
      value: function _iterateOverDataPoints(_ref3) {
        var type = _ref3.type,
            series = _ref3.series,
            iterations = _ref3.iterations,
            realIndex = _ref3.realIndex,
            i = _ref3.i,
            x = _ref3.x,
            y = _ref3.y,
            pX = _ref3.pX,
            pY = _ref3.pY,
            pathsFrom = _ref3.pathsFrom,
            linePaths = _ref3.linePaths,
            areaPaths = _ref3.areaPaths,
            seriesIndex = _ref3.seriesIndex,
            lineYPosition = _ref3.lineYPosition,
            xArrj = _ref3.xArrj,
            yArrj = _ref3.yArrj,
            isRangeStart = _ref3.isRangeStart,
            seriesRangeEnd = _ref3.seriesRangeEnd;
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var yRatio = this.yRatio;
        var prevY = pathsFrom.prevY,
            linePath = pathsFrom.linePath,
            areaPath = pathsFrom.areaPath,
            pathFromLine = pathsFrom.pathFromLine,
            pathFromArea = pathsFrom.pathFromArea;
        var minY = Utils$1.isNumber(w.globals.minYArr[realIndex]) ? w.globals.minYArr[realIndex] : w.globals.minY;

        if (!iterations) {
          iterations = w.globals.dataPoints > 1 ? w.globals.dataPoints - 1 : w.globals.dataPoints;
        }

        var y2 = y;

        for (var j = 0; j < iterations; j++) {
          var isNull = typeof series[i][j + 1] === 'undefined' || series[i][j + 1] === null;

          if (w.globals.isXNumeric) {
            var sX = w.globals.seriesX[realIndex][j + 1];

            if (typeof w.globals.seriesX[realIndex][j + 1] === 'undefined') {
              /* fix #374 */
              sX = w.globals.seriesX[realIndex][iterations - 1];
            }

            x = (sX - w.globals.minX) / this.xRatio;
          } else {
            x = x + this.xDivision;
          }

          if (w.config.chart.stacked) {
            if (i > 0 && w.globals.collapsedSeries.length < w.config.series.length - 1) {

              var prevIndex = function prevIndex(pi) {
                var pii = pi;

                for (var cpi = 0; cpi < w.globals.series.length; cpi++) {
                  if (w.globals.collapsedSeriesIndices.indexOf(pi) > -1) {
                    pii--;
                    break;
                  }
                }

                return pii >= 0 ? pii : 0;
              };

              lineYPosition = this.prevSeriesY[prevIndex(i - 1)][j + 1];
            } else {

              lineYPosition = this.zeroY;
            }
          } else {
            lineYPosition = this.zeroY;
          }

          if (isNull) {
            y = lineYPosition - minY / yRatio[this.yaxisIndex] + (this.isReversed ? minY / yRatio[this.yaxisIndex] : 0) * 2;
          } else {
            y = lineYPosition - series[i][j + 1] / yRatio[this.yaxisIndex] + (this.isReversed ? series[i][j + 1] / yRatio[this.yaxisIndex] : 0) * 2;

            if (type === 'rangeArea') {
              y2 = lineYPosition - seriesRangeEnd[i][j + 1] / yRatio[this.yaxisIndex] + (this.isReversed ? seriesRangeEnd[i][j + 1] / yRatio[this.yaxisIndex] : 0) * 2;
            }
          }


          xArrj.push(x);

          yArrj.push(y);
          var pointsPos = this.lineHelpers.calculatePoints({
            series: series,
            x: x,
            y: y,
            realIndex: realIndex,
            i: i,
            j: j,
            prevY: prevY
          });

          var calculatedPaths = this._createPaths({
            type: type,
            series: series,
            i: i,
            realIndex: realIndex,
            j: j,
            x: x,
            y: y,
            y2: y2,
            pX: pX,
            pY: pY,
            linePath: linePath,
            areaPath: areaPath,
            linePaths: linePaths,
            areaPaths: areaPaths,
            seriesIndex: seriesIndex,
            isRangeStart: isRangeStart
          });

          areaPaths = calculatedPaths.areaPaths;
          linePaths = calculatedPaths.linePaths;
          pX = calculatedPaths.pX;
          pY = calculatedPaths.pY;
          areaPath = calculatedPaths.areaPath;
          linePath = calculatedPaths.linePath;

          if (this.appendPathFrom) {
            pathFromLine = pathFromLine + graphics.line(x, this.zeroY);
            pathFromArea = pathFromArea + graphics.line(x, this.zeroY);
          }

          this.handleNullDataPoints(series, pointsPos, i, j, realIndex);

          this._handleMarkersAndLabels({
            type: type,
            pointsPos: pointsPos,
            i: i,
            j: j,
            realIndex: realIndex,
            isRangeStart: isRangeStart
          });
        }

        return {
          yArrj: yArrj,
          xArrj: xArrj,
          pathFromArea: pathFromArea,
          areaPaths: areaPaths,
          pathFromLine: pathFromLine,
          linePaths: linePaths,
          linePath: linePath,
          areaPath: areaPath
        };
      }
    }, {
      key: "_handleMarkersAndLabels",
      value: function _handleMarkersAndLabels(_ref4) {
        var type = _ref4.type,
            pointsPos = _ref4.pointsPos,
            isRangeStart = _ref4.isRangeStart,
            i = _ref4.i,
            j = _ref4.j,
            realIndex = _ref4.realIndex;
        var w = this.w;
        var dataLabels = new DataLabels(this.ctx);

        if (!this.pointsChart) {
          if (w.globals.series[i].length > 1) {
            this.elPointsMain.node.classList.add('apexcharts-element-hidden');
          }

          var elPointsWrap = this.markers.plotChartMarkers(pointsPos, realIndex, j + 1);

          if (elPointsWrap !== null) {
            this.elPointsMain.add(elPointsWrap);
          }
        } else {

          this.scatter.draw(this.elSeries, j, {
            realIndex: realIndex,
            pointsPos: pointsPos,
            zRatio: this.zRatio,
            elParent: this.elPointsMain
          });
        }

        var drawnLabels = dataLabels.drawDataLabel({
          type: type,
          isRangeStart: isRangeStart,
          pos: pointsPos,
          i: realIndex,
          j: j + 1
        });

        if (drawnLabels !== null) {
          this.elDataLabelsWrap.add(drawnLabels);
        }
      }
    }, {
      key: "_createPaths",
      value: function _createPaths(_ref5) {
        var type = _ref5.type,
            series = _ref5.series,
            i = _ref5.i,
            realIndex = _ref5.realIndex,
            j = _ref5.j,
            x = _ref5.x,
            y = _ref5.y,
            y2 = _ref5.y2,
            pX = _ref5.pX,
            pY = _ref5.pY,
            linePath = _ref5.linePath,
            areaPath = _ref5.areaPath,
            linePaths = _ref5.linePaths,
            areaPaths = _ref5.areaPaths,
            seriesIndex = _ref5.seriesIndex,
            isRangeStart = _ref5.isRangeStart;
        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var curve = w.config.stroke.curve;
        var areaBottomY = this.areaBottomY;

        if (Array.isArray(w.config.stroke.curve)) {
          if (Array.isArray(seriesIndex)) {
            curve = w.config.stroke.curve[seriesIndex[i]];
          } else {
            curve = w.config.stroke.curve[i];
          }
        }



        if (curve === 'smooth') {
          var length = (x - pX) * 0.35;

          if (w.globals.hasNullValues) {
            if (series[i][j] !== null) {
              if (series[i][j + 1] !== null) {
                linePath = graphics.move(pX, pY) + graphics.curve(pX + length, pY, x - length, y, x + 1, y);
                areaPath = graphics.move(pX + 1, pY) + graphics.curve(pX + length, pY, x - length, y, x + 1, y) + graphics.line(x, areaBottomY) + graphics.line(pX, areaBottomY) + 'z';
              } else {
                linePath = graphics.move(pX, pY);
                areaPath = graphics.move(pX, pY) + 'z';
              }
            }

            linePaths.push(linePath);
            areaPaths.push(areaPath);
          } else {
            linePath = linePath + graphics.curve(pX + length, pY, x - length, y, x, y);
            areaPath = areaPath + graphics.curve(pX + length, pY, x - length, y, x, y);
          }

          pX = x;
          pY = y;

          if (j === series[i].length - 2) {

            areaPath = areaPath + graphics.curve(pX, pY, x, y, x, areaBottomY) + graphics.move(x, y) + 'z';

            if (type === 'rangeArea' && isRangeStart) {
              linePath = linePath + graphics.curve(pX, pY, x, y, x, y2) + graphics.move(x, y2) + 'z';
            } else {
              if (!w.globals.hasNullValues) {
                linePaths.push(linePath);
                areaPaths.push(areaPath);
              }
            }
          }
        } else {
          if (series[i][j + 1] === null) {
            linePath = linePath + graphics.move(x, y);
            var numericOrCatX = w.globals.isXNumeric ? (w.globals.seriesX[realIndex][j] - w.globals.minX) / this.xRatio : x - this.xDivision;
            areaPath = areaPath + graphics.line(numericOrCatX, areaBottomY) + graphics.move(x, y) + 'z';
          }

          if (series[i][j] === null) {
            linePath = linePath + graphics.move(x, y);
            areaPath = areaPath + graphics.move(x, areaBottomY);
          }

          if (curve === 'stepline') {
            linePath = linePath + graphics.line(x, null, 'H') + graphics.line(null, y, 'V');
            areaPath = areaPath + graphics.line(x, null, 'H') + graphics.line(null, y, 'V');
          } else if (curve === 'straight') {
            linePath = linePath + graphics.line(x, y);
            areaPath = areaPath + graphics.line(x, y);
          }

          if (j === series[i].length - 2) {

            areaPath = areaPath + graphics.line(x, areaBottomY) + graphics.move(x, y) + 'z';

            if (type === 'rangeArea' && isRangeStart) {
              linePath = linePath + graphics.line(x, y2) + graphics.move(x, y2) + 'z';
            } else {
              linePaths.push(linePath);
              areaPaths.push(areaPath);
            }
          }
        }

        return {
          linePaths: linePaths,
          areaPaths: areaPaths,
          pX: pX,
          pY: pY,
          linePath: linePath,
          areaPath: areaPath
        };
      }
    }, {
      key: "handleNullDataPoints",
      value: function handleNullDataPoints(series, pointsPos, i, j, realIndex) {
        var w = this.w;

        if (series[i][j] === null && w.config.markers.showNullDataPoints || series[i].length === 1) {

          var elPointsWrap = this.markers.plotChartMarkers(pointsPos, realIndex, j + 1, this.strokeWidth - w.config.markers.strokeWidth / 2, true);

          if (elPointsWrap !== null) {
            this.elPointsMain.add(elPointsWrap);
          }
        }
      }
    }]);

    return Line;
  }();

  /*
   * treemap-squarify.js - open source implementation of squarified treemaps
   *
   * Treemap Squared 0.5 - Treemap Charting library
   *
   * https://github.com/imranghory/treemap-squared/
   *
   * Copyright (c) 2012 Imran Ghory (imranghory@gmail.com)
   * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
   *
   *
   * Implementation of the squarify treemap algorithm described in:
   *
   * Bruls, Mark; Huizing, Kees; van Wijk, Jarke J. (2000), "Squarified treemaps"
   * in de Leeuw, W.; van Liere, R., Data Visualization 2000:
   * Proc. Joint Eurographics and IEEE TCVG Symp. on Visualization, Springer-Verlag, pp. 33–42.
   *
   * Paper is available online at: http://www.win.tue.nl/~vanwijk/stm.pdf
   *
   * The code in this file is completeley decoupled from the drawing code so it should be trivial
   * to port it to any other vector drawing library. Given an array of datapoints this library returns
   * an array of cartesian coordinates that represent the rectangles that make up the treemap.
   *
   * The library also supports multidimensional data (nested treemaps) and performs normalization on the data.
   *
   * See the README file for more details.
   */
  window.TreemapSquared = {};

  (function () {

    window.TreemapSquared.generate = function () {
      function Container(xoffset, yoffset, width, height) {
        this.xoffset = xoffset;

        this.yoffset = yoffset;

        this.height = height;
        this.width = width;

        this.shortestEdge = function () {
          return Math.min(this.height, this.width);
        };



        this.getCoordinates = function (row) {
          var coordinates = [];
          var subxoffset = this.xoffset,
              subyoffset = this.yoffset; //our offset within the container

          var areawidth = sumArray(row) / this.height;
          var areaheight = sumArray(row) / this.width;
          var i;

          if (this.width >= this.height) {
            for (i = 0; i < row.length; i++) {
              coordinates.push([subxoffset, subyoffset, subxoffset + areawidth, subyoffset + row[i] / areawidth]);
              subyoffset = subyoffset + row[i] / areawidth;
            }
          } else {
            for (i = 0; i < row.length; i++) {
              coordinates.push([subxoffset, subyoffset, subxoffset + row[i] / areaheight, subyoffset + areaheight]);
              subxoffset = subxoffset + row[i] / areaheight;
            }
          }

          return coordinates;
        };




        this.cutArea = function (area) {
          var newcontainer;

          if (this.width >= this.height) {
            var areawidth = area / this.height;
            var newwidth = this.width - areawidth;
            newcontainer = new Container(this.xoffset + areawidth, this.yoffset, newwidth, this.height);
          } else {
            var areaheight = area / this.width;
            var newheight = this.height - areaheight;
            newcontainer = new Container(this.xoffset, this.yoffset + areaheight, this.width, newheight);
          }

          return newcontainer;
        };
      }




      function normalize(data, area) {
        var normalizeddata = [];
        var sum = sumArray(data);
        var multiplier = area / sum;
        var i;

        for (i = 0; i < data.length; i++) {
          normalizeddata[i] = data[i] * multiplier;
        }

        return normalizeddata;
      }




      function treemapMultidimensional(data, width, height, xoffset, yoffset) {
        xoffset = typeof xoffset === 'undefined' ? 0 : xoffset;
        yoffset = typeof yoffset === 'undefined' ? 0 : yoffset;
        var mergeddata = [];
        var mergedtreemap;
        var results = [];
        var i;

        if (isArray(data[0])) {

          for (i = 0; i < data.length; i++) {
            mergeddata[i] = sumMultidimensionalArray(data[i]);
          }

          mergedtreemap = treemapSingledimensional(mergeddata, width, height, xoffset, yoffset);

          for (i = 0; i < data.length; i++) {
            results.push(treemapMultidimensional(data[i], mergedtreemap[i][2] - mergedtreemap[i][0], mergedtreemap[i][3] - mergedtreemap[i][1], mergedtreemap[i][0], mergedtreemap[i][1]));
          }
        } else {
          results = treemapSingledimensional(data, width, height, xoffset, yoffset);
        }

        return results;
      }


      function treemapSingledimensional(data, width, height, xoffset, yoffset) {
        xoffset = typeof xoffset === 'undefined' ? 0 : xoffset;
        yoffset = typeof yoffset === 'undefined' ? 0 : yoffset;
        var rawtreemap = squarify(normalize(data, width * height), [], new Container(xoffset, yoffset, width, height), []);
        return flattenTreemap(rawtreemap);
      }




      function flattenTreemap(rawtreemap) {
        var flattreemap = [];
        var i, j;

        for (i = 0; i < rawtreemap.length; i++) {
          for (j = 0; j < rawtreemap[i].length; j++) {
            flattreemap.push(rawtreemap[i][j]);
          }
        }

        return flattreemap;
      }




      function squarify(data, currentrow, container, stack) {
        var length;
        var nextdatapoint;
        var newcontainer;

        if (data.length === 0) {
          stack.push(container.getCoordinates(currentrow));
          return;
        }

        length = container.shortestEdge();
        nextdatapoint = data[0];

        if (improvesRatio(currentrow, nextdatapoint, length)) {
          currentrow.push(nextdatapoint);
          squarify(data.slice(1), currentrow, container, stack);
        } else {
          newcontainer = container.cutArea(sumArray(currentrow), stack);
          stack.push(container.getCoordinates(currentrow));
          squarify(data, [], newcontainer, stack);
        }

        return stack;
      }



      function improvesRatio(currentrow, nextnode, length) {
        var newrow;

        if (currentrow.length === 0) {
          return true;
        }

        newrow = currentrow.slice();
        newrow.push(nextnode);
        var currentratio = calculateRatio(currentrow, length);
        var newratio = calculateRatio(newrow, length);


        return currentratio >= newratio;
      }



      function calculateRatio(row, length) {
        var min = Math.min.apply(Math, row);
        var max = Math.max.apply(Math, row);
        var sum = sumArray(row);
        return Math.max(Math.pow(length, 2) * max / Math.pow(sum, 2), Math.pow(sum, 2) / (Math.pow(length, 2) * min));
      }


      function isArray(arr) {
        return arr && arr.constructor === Array;
      }


      function sumArray(arr) {
        var sum = 0;
        var i;

        for (i = 0; i < arr.length; i++) {
          sum += arr[i];
        }

        return sum;
      }


      function sumMultidimensionalArray(arr) {
        var i,
            total = 0;

        if (isArray(arr[0])) {
          for (i = 0; i < arr.length; i++) {
            total += sumMultidimensionalArray(arr[i]);
          }
        } else {
          total = sumArray(arr);
        }

        return total;
      }

      return treemapMultidimensional;
    }();
  })();

  /**
   * ApexCharts TreemapChart Class.
   * @module TreemapChart
   **/

  var TreemapChart = /*#__PURE__*/function () {
    function TreemapChart(ctx, xyRatios) {
      _classCallCheck(this, TreemapChart);

      this.ctx = ctx;
      this.w = ctx.w;
      this.strokeWidth = this.w.config.stroke.width;
      this.helpers = new TreemapHelpers(ctx);
      this.dynamicAnim = this.w.config.chart.animations.dynamicAnimation;
      this.labels = [];
    }

    _createClass(TreemapChart, [{
      key: "draw",
      value: function draw(series) {
        var _this = this;

        var w = this.w;
        var graphics = new Graphics(this.ctx);
        var fill = new Fill(this.ctx);
        var ret = graphics.group({
          class: 'apexcharts-treemap'
        });
        if (w.globals.noData) return ret;
        var ser = [];
        series.forEach(function (s) {
          var d = s.map(function (v) {
            return Math.abs(v);
          });
          ser.push(d);
        });
        this.negRange = this.helpers.checkColorRange();
        w.config.series.forEach(function (s, i) {
          s.data.forEach(function (l) {
            if (!Array.isArray(_this.labels[i])) _this.labels[i] = [];

            _this.labels[i].push(l.x);
          });
        });
        var nodes = window.TreemapSquared.generate(ser, w.globals.gridWidth, w.globals.gridHeight);
        nodes.forEach(function (node, i) {
          var elSeries = graphics.group({
            class: "apexcharts-series apexcharts-treemap-series",
            seriesName: Utils$1.escapeString(w.globals.seriesNames[i]),
            rel: i + 1,
            'data:realIndex': i
          });

          if (w.config.chart.dropShadow.enabled) {
            var shadow = w.config.chart.dropShadow;
            var filters = new Filters(_this.ctx);
            filters.dropShadow(ret, shadow, i);
          }

          var elDataLabelWrap = graphics.group({
            class: 'apexcharts-data-labels'
          });
          node.forEach(function (r, j) {
            var x1 = r[0];
            var y1 = r[1];
            var x2 = r[2];
            var y2 = r[3];
            var elRect = graphics.drawRect(x1, y1, x2 - x1, y2 - y1, 0, '#fff', 1, _this.strokeWidth, w.config.plotOptions.treemap.useFillColorAsStroke ? color : w.globals.stroke.colors[i]);
            elRect.attr({
              cx: x1,
              cy: y1,
              index: i,
              i: i,
              j: j,
              width: x2 - x1,
              height: y2 - y1
            });

            var colorProps = _this.helpers.getShadeColor(w.config.chart.type, i, j, _this.negRange);

            var color = colorProps.color;

            if (typeof w.config.series[i].data[j] !== 'undefined' && w.config.series[i].data[j].fillColor) {
              color = w.config.series[i].data[j].fillColor;
            }

            var pathFill = fill.fillPath({
              color: color,
              seriesNumber: i,
              dataPointIndex: j
            });
            elRect.node.classList.add('apexcharts-treemap-rect');
            elRect.attr({
              fill: pathFill
            });

            _this.helpers.addListeners(elRect);

            var fromRect = {
              x: x1 + (x2 - x1) / 2,
              y: y1 + (y2 - y1) / 2,
              width: 0,
              height: 0
            };
            var toRect = {
              x: x1,
              y: y1,
              width: x2 - x1,
              height: y2 - y1
            };

            if (w.config.chart.animations.enabled && !w.globals.dataChanged) {
              var speed = 1;

              if (!w.globals.resized) {
                speed = w.config.chart.animations.speed;
              }

              _this.animateTreemap(elRect, fromRect, toRect, speed);
            }

            if (w.globals.dataChanged) {
              var _speed = 1;

              if (_this.dynamicAnim.enabled && w.globals.shouldAnimate) {
                _speed = _this.dynamicAnim.speed;

                if (w.globals.previousPaths[i] && w.globals.previousPaths[i][j] && w.globals.previousPaths[i][j].rect) {
                  fromRect = w.globals.previousPaths[i][j].rect;
                }

                _this.animateTreemap(elRect, fromRect, toRect, _speed);
              }
            }

            var fontSize = _this.getFontSize(r);

            var formattedText = w.config.dataLabels.formatter(_this.labels[i][j], {
              value: w.globals.series[i][j],
              seriesIndex: i,
              dataPointIndex: j,
              w: w
            });

            var dataLabels = _this.helpers.calculateDataLabels({
              text: formattedText,
              x: (x1 + x2) / 2,
              y: (y1 + y2) / 2 + _this.strokeWidth / 2 + fontSize / 3,
              i: i,
              j: j,
              colorProps: colorProps,
              fontSize: fontSize,
              series: series
            });

            if (w.config.dataLabels.enabled && dataLabels) {
              _this.rotateToFitLabel(dataLabels, fontSize, formattedText, x1, y1, x2, y2);
            }

            elSeries.add(elRect);

            if (dataLabels !== null) {
              elSeries.add(dataLabels);
            }
          });
          elSeries.add(elDataLabelWrap);
          ret.add(elSeries);
        });
        return ret;
      }



    }, {
      key: "getFontSize",
      value: function getFontSize(coordinates) {
        var w = this.w;

        function totalLabelLength(arr) {
          var i,
              total = 0;

          if (Array.isArray(arr[0])) {
            for (i = 0; i < arr.length; i++) {
              total += totalLabelLength(arr[i]);
            }
          } else {
            for (i = 0; i < arr.length; i++) {
              total += arr[i].length;
            }
          }

          return total;
        }


        function countLabels(arr) {
          var i,
              total = 0;

          if (Array.isArray(arr[0])) {
            for (i = 0; i < arr.length; i++) {
              total += countLabels(arr[i]);
            }
          } else {
            for (i = 0; i < arr.length; i++) {
              total += 1;
            }
          }

          return total;
        }

        var averagelabelsize = totalLabelLength(this.labels) / countLabels(this.labels);

        function fontSize(width, height) {




          var area = width * height;
          var arearoot = Math.pow(area, 0.5);
          return Math.min(arearoot / averagelabelsize, parseInt(w.config.dataLabels.style.fontSize, 10));
        }

        return fontSize(coordinates[2] - coordinates[0], coordinates[3] - coordinates[1]);
      }
    }, {
      key: "rotateToFitLabel",
      value: function rotateToFitLabel(elText, fontSize, text, x1, y1, x2, y2) {
        var graphics = new Graphics(this.ctx);
        var textRect = graphics.getTextRects(text, fontSize); //if the label fits better sideways then rotate it

        if (textRect.width + this.w.config.stroke.width + 5 > x2 - x1 && textRect.width <= y2 - y1) {
          var labelRotatingCenter = graphics.rotateAroundCenter(elText.node);
          elText.node.setAttribute('transform', "rotate(-90 ".concat(labelRotatingCenter.x, " ").concat(labelRotatingCenter.y, ")"));
        }
      }
    }, {
      key: "animateTreemap",
      value: function animateTreemap(el, fromRect, toRect, speed) {
        var animations = new Animations(this.ctx);
        animations.animateRect(el, {
          x: fromRect.x,
          y: fromRect.y,
          width: fromRect.width,
          height: fromRect.height
        }, {
          x: toRect.x,
          y: toRect.y,
          width: toRect.width,
          height: toRect.height
        }, speed, function () {
          animations.animationCompleted(el);
        });
      }
    }]);

    return TreemapChart;
  }();

  var MINUTES_IN_DAY = 24 * 60;
  var SECONDS_IN_DAY = MINUTES_IN_DAY * 60;
  var MIN_ZOOM_DAYS = 10 / SECONDS_IN_DAY;
  /**
   * ApexCharts TimeScale Class for generating time ticks for x-axis.
   *
   * @module TimeScale
   **/

  var TimeScale = /*#__PURE__*/function () {
    function TimeScale(ctx) {
      _classCallCheck(this, TimeScale);

      this.ctx = ctx;
      this.w = ctx.w;
      this.timeScaleArray = [];
      this.utc = this.w.config.xaxis.labels.datetimeUTC;
    }

    _createClass(TimeScale, [{
      key: "calculateTimeScaleTicks",
      value: function calculateTimeScaleTicks(minX, maxX) {
        var _this = this;

        var w = this.w;

        if (w.globals.allSeriesCollapsed) {
          w.globals.labels = [];
          w.globals.timescaleLabels = [];
          return [];
        }

        var dt = new DateTime(this.ctx);
        var daysDiff = (maxX - minX) / (1000 * SECONDS_IN_DAY);
        this.determineInterval(daysDiff);
        w.globals.disableZoomIn = false;
        w.globals.disableZoomOut = false;

        if (daysDiff < MIN_ZOOM_DAYS) {
          w.globals.disableZoomIn = true;
        } else if (daysDiff > 50000) {
          w.globals.disableZoomOut = true;
        }

        var timeIntervals = dt.getTimeUnitsfromTimestamp(minX, maxX, this.utc);
        var daysWidthOnXAxis = w.globals.gridWidth / daysDiff;
        var hoursWidthOnXAxis = daysWidthOnXAxis / 24;
        var minutesWidthOnXAxis = hoursWidthOnXAxis / 60;
        var secondsWidthOnXAxis = minutesWidthOnXAxis / 60;
        var numberOfHours = Math.floor(daysDiff * 24);
        var numberOfMinutes = Math.floor(daysDiff * MINUTES_IN_DAY);
        var numberOfSeconds = Math.floor(daysDiff * SECONDS_IN_DAY);
        var numberOfDays = Math.floor(daysDiff);
        var numberOfMonths = Math.floor(daysDiff / 30);
        var numberOfYears = Math.floor(daysDiff / 365);
        var firstVal = {
          minMillisecond: timeIntervals.minMillisecond,
          minSecond: timeIntervals.minSecond,
          minMinute: timeIntervals.minMinute,
          minHour: timeIntervals.minHour,
          minDate: timeIntervals.minDate,
          minMonth: timeIntervals.minMonth,
          minYear: timeIntervals.minYear
        };
        var currentMillisecond = firstVal.minMillisecond;
        var currentSecond = firstVal.minSecond;
        var currentMinute = firstVal.minMinute;
        var currentHour = firstVal.minHour;
        var currentMonthDate = firstVal.minDate;
        var currentDate = firstVal.minDate;
        var currentMonth = firstVal.minMonth;
        var currentYear = firstVal.minYear;
        var params = {
          firstVal: firstVal,
          currentMillisecond: currentMillisecond,
          currentSecond: currentSecond,
          currentMinute: currentMinute,
          currentHour: currentHour,
          currentMonthDate: currentMonthDate,
          currentDate: currentDate,
          currentMonth: currentMonth,
          currentYear: currentYear,
          daysWidthOnXAxis: daysWidthOnXAxis,
          hoursWidthOnXAxis: hoursWidthOnXAxis,
          minutesWidthOnXAxis: minutesWidthOnXAxis,
          secondsWidthOnXAxis: secondsWidthOnXAxis,
          numberOfSeconds: numberOfSeconds,
          numberOfMinutes: numberOfMinutes,
          numberOfHours: numberOfHours,
          numberOfDays: numberOfDays,
          numberOfMonths: numberOfMonths,
          numberOfYears: numberOfYears
        };

        switch (this.tickInterval) {
          case 'years':
            {
              this.generateYearScale(params);
              break;
            }

          case 'months':
          case 'half_year':
            {
              this.generateMonthScale(params);
              break;
            }

          case 'months_days':
          case 'months_fortnight':
          case 'days':
          case 'week_days':
            {
              this.generateDayScale(params);
              break;
            }

          case 'hours':
            {
              this.generateHourScale(params);
              break;
            }

          case 'minutes_fives':
          case 'minutes':
            this.generateMinuteScale(params);
            break;

          case 'seconds_tens':
          case 'seconds_fives':
          case 'seconds':
            this.generateSecondScale(params);
            break;
        }




        var adjustedMonthInTimeScaleArray = this.timeScaleArray.map(function (ts) {
          var defaultReturn = {
            position: ts.position,
            unit: ts.unit,
            year: ts.year,
            day: ts.day ? ts.day : 1,
            hour: ts.hour ? ts.hour : 0,
            month: ts.month + 1
          };

          if (ts.unit === 'month') {
            return _objectSpread2(_objectSpread2({}, defaultReturn), {}, {
              day: 1,
              value: ts.value + 1
            });
          } else if (ts.unit === 'day' || ts.unit === 'hour') {
            return _objectSpread2(_objectSpread2({}, defaultReturn), {}, {
              value: ts.value
            });
          } else if (ts.unit === 'minute') {
            return _objectSpread2(_objectSpread2({}, defaultReturn), {}, {
              value: ts.value,
              minute: ts.value
            });
          } else if (ts.unit === 'second') {
            return _objectSpread2(_objectSpread2({}, defaultReturn), {}, {
              value: ts.value,
              minute: ts.minute,
              second: ts.second
            });
          }

          return ts;
        });
        var filteredTimeScale = adjustedMonthInTimeScaleArray.filter(function (ts) {
          var modulo = 1;
          var ticks = Math.ceil(w.globals.gridWidth / 120);
          var value = ts.value;

          if (w.config.xaxis.tickAmount !== undefined) {
            ticks = w.config.xaxis.tickAmount;
          }

          if (adjustedMonthInTimeScaleArray.length > ticks) {
            modulo = Math.floor(adjustedMonthInTimeScaleArray.length / ticks);
          }

          var shouldNotSkipUnit = false;

          var shouldNotPrint = false;

          switch (_this.tickInterval) {
            case 'years':

              if (ts.unit === 'year') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'half_year':
              modulo = 7;

              if (ts.unit === 'year') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'months':
              modulo = 1;

              if (ts.unit === 'year') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'months_fortnight':
              modulo = 15;

              if (ts.unit === 'year' || ts.unit === 'month') {
                shouldNotSkipUnit = true;
              }

              if (value === 30) {
                shouldNotPrint = true;
              }

              break;

            case 'months_days':
              modulo = 10;

              if (ts.unit === 'month') {
                shouldNotSkipUnit = true;
              }

              if (value === 30) {
                shouldNotPrint = true;
              }

              break;

            case 'week_days':
              modulo = 8;

              if (ts.unit === 'month') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'days':
              modulo = 1;

              if (ts.unit === 'month') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'hours':
              if (ts.unit === 'day') {
                shouldNotSkipUnit = true;
              }

              break;

            case 'minutes_fives':
              if (value % 5 !== 0) {
                shouldNotPrint = true;
              }

              break;

            case 'seconds_tens':
              if (value % 10 !== 0) {
                shouldNotPrint = true;
              }

              break;

            case 'seconds_fives':
              if (value % 5 !== 0) {
                shouldNotPrint = true;
              }

              break;
          }

          if (_this.tickInterval === 'hours' || _this.tickInterval === 'minutes_fives' || _this.tickInterval === 'seconds_tens' || _this.tickInterval === 'seconds_fives') {
            if (!shouldNotPrint) {
              return true;
            }
          } else {
            if ((value % modulo === 0 || shouldNotSkipUnit) && !shouldNotPrint) {
              return true;
            }
          }
        });
        return filteredTimeScale;
      }
    }, {
      key: "recalcDimensionsBasedOnFormat",
      value: function recalcDimensionsBasedOnFormat(filteredTimeScale, inverted) {
        var w = this.w;
        var reformattedTimescaleArray = this.formatDates(filteredTimeScale);
        var removedOverlappingTS = this.removeOverlappingTS(reformattedTimescaleArray);
        w.globals.timescaleLabels = removedOverlappingTS.slice();




        var dimensions = new Dimensions(this.ctx);
        dimensions.plotCoords();
      }
    }, {
      key: "determineInterval",
      value: function determineInterval(daysDiff) {
        var yearsDiff = daysDiff / 365;
        var hoursDiff = daysDiff * 24;
        var minutesDiff = hoursDiff * 60;
        var secondsDiff = minutesDiff * 60;

        switch (true) {
          case yearsDiff > 5:
            this.tickInterval = 'years';
            break;

          case daysDiff > 800:
            this.tickInterval = 'half_year';
            break;

          case daysDiff > 180:
            this.tickInterval = 'months';
            break;

          case daysDiff > 90:
            this.tickInterval = 'months_fortnight';
            break;

          case daysDiff > 60:
            this.tickInterval = 'months_days';
            break;

          case daysDiff > 30:
            this.tickInterval = 'week_days';
            break;

          case daysDiff > 2:
            this.tickInterval = 'days';
            break;

          case hoursDiff > 2.4:
            this.tickInterval = 'hours';
            break;

          case minutesDiff > 15:
            this.tickInterval = 'minutes_fives';
            break;

          case minutesDiff > 5:
            this.tickInterval = 'minutes';
            break;

          case minutesDiff > 1:
            this.tickInterval = 'seconds_tens';
            break;

          case secondsDiff > 20:
            this.tickInterval = 'seconds_fives';
            break;

          default:
            this.tickInterval = 'seconds';
            break;
        }
      }
    }, {
      key: "generateYearScale",
      value: function generateYearScale(_ref) {
        var firstVal = _ref.firstVal,
            currentMonth = _ref.currentMonth,
            currentYear = _ref.currentYear,
            daysWidthOnXAxis = _ref.daysWidthOnXAxis,
            numberOfYears = _ref.numberOfYears;
        var firstTickValue = firstVal.minYear;
        var firstTickPosition = 0;
        var dt = new DateTime(this.ctx);
        var unit = 'year';

        if (firstVal.minDate > 1 || firstVal.minMonth > 0) {
          var remainingDays = dt.determineRemainingDaysOfYear(firstVal.minYear, firstVal.minMonth, firstVal.minDate);

          var remainingDaysOfFirstYear = dt.determineDaysOfYear(firstVal.minYear) - remainingDays + 1;

          firstTickPosition = remainingDaysOfFirstYear * daysWidthOnXAxis;
          firstTickValue = firstVal.minYear + 1;

          this.timeScaleArray.push({
            position: firstTickPosition,
            value: firstTickValue,
            unit: unit,
            year: firstTickValue,
            month: Utils$1.monthMod(currentMonth + 1)
          });
        } else if (firstVal.minDate === 1 && firstVal.minMonth === 0) {

          this.timeScaleArray.push({
            position: firstTickPosition,
            value: firstTickValue,
            unit: unit,
            year: currentYear,
            month: Utils$1.monthMod(currentMonth + 1)
          });
        }

        var year = firstTickValue;
        var pos = firstTickPosition;

        for (var i = 0; i < numberOfYears; i++) {
          year++;
          pos = dt.determineDaysOfYear(year - 1) * daysWidthOnXAxis + pos;
          this.timeScaleArray.push({
            position: pos,
            value: year,
            unit: unit,
            year: year,
            month: 1
          });
        }
      }
    }, {
      key: "generateMonthScale",
      value: function generateMonthScale(_ref2) {
        var firstVal = _ref2.firstVal,
            currentMonthDate = _ref2.currentMonthDate,
            currentMonth = _ref2.currentMonth,
            currentYear = _ref2.currentYear,
            daysWidthOnXAxis = _ref2.daysWidthOnXAxis,
            numberOfMonths = _ref2.numberOfMonths;
        var firstTickValue = currentMonth;
        var firstTickPosition = 0;
        var dt = new DateTime(this.ctx);
        var unit = 'month';
        var yrCounter = 0;

        if (firstVal.minDate > 1) {

          var remainingDaysOfFirstMonth = dt.determineDaysOfMonths(currentMonth + 1, firstVal.minYear) - currentMonthDate + 1;

          firstTickPosition = remainingDaysOfFirstMonth * daysWidthOnXAxis;
          firstTickValue = Utils$1.monthMod(currentMonth + 1);
          var year = currentYear + yrCounter;

          var _month = Utils$1.monthMod(firstTickValue);

          var value = firstTickValue;

          if (firstTickValue === 0) {
            unit = 'year';
            value = year;
            _month = 1;
            yrCounter += 1;
            year = year + yrCounter;
          }


          this.timeScaleArray.push({
            position: firstTickPosition,
            value: value,
            unit: unit,
            year: year,
            month: _month
          });
        } else {

          this.timeScaleArray.push({
            position: firstTickPosition,
            value: firstTickValue,
            unit: unit,
            year: currentYear,
            month: Utils$1.monthMod(currentMonth)
          });
        }

        var month = firstTickValue + 1;
        var pos = firstTickPosition;

        for (var i = 0, j = 1; i < numberOfMonths; i++, j++) {
          month = Utils$1.monthMod(month);

          if (month === 0) {
            unit = 'year';
            yrCounter += 1;
          } else {
            unit = 'month';
          }

          var _year = this._getYear(currentYear, month, yrCounter);

          pos = dt.determineDaysOfMonths(month, _year) * daysWidthOnXAxis + pos;
          var monthVal = month === 0 ? _year : month;
          this.timeScaleArray.push({
            position: pos,
            value: monthVal,
            unit: unit,
            year: _year,
            month: month === 0 ? 1 : month
          });
          month++;
        }
      }
    }, {
      key: "generateDayScale",
      value: function generateDayScale(_ref3) {
        var firstVal = _ref3.firstVal,
            currentMonth = _ref3.currentMonth,
            currentYear = _ref3.currentYear,
            hoursWidthOnXAxis = _ref3.hoursWidthOnXAxis,
            numberOfDays = _ref3.numberOfDays;
        var dt = new DateTime(this.ctx);
        var unit = 'day';
        var firstTickValue = firstVal.minDate + 1;
        var date = firstTickValue;

        var changeMonth = function changeMonth(dateVal, month, year) {
          var monthdays = dt.determineDaysOfMonths(month + 1, year);

          if (dateVal > monthdays) {
            month = month + 1;
            date = 1;
            unit = 'month';
            val = month;
            return month;
          }

          return month;
        };

        var remainingHours = 24 - firstVal.minHour;
        var yrCounter = 0;

        var firstTickPosition = remainingHours * hoursWidthOnXAxis;
        var val = firstTickValue;
        var month = changeMonth(date, currentMonth, currentYear);

        if (firstVal.minHour === 0 && firstVal.minDate === 1) {

          firstTickPosition = 0;
          val = Utils$1.monthMod(firstVal.minMonth);
          unit = 'month';
          date = firstVal.minDate;
          numberOfDays++;
        } else if (firstVal.minDate !== 1 && firstVal.minHour === 0 && firstVal.minMinute === 0) {

          firstTickPosition = 0;
          firstTickValue = firstVal.minDate;
          date = firstTickValue;
          val = firstTickValue;

          month = changeMonth(date, currentMonth, currentYear);
        }


        this.timeScaleArray.push({
          position: firstTickPosition,
          value: val,
          unit: unit,
          year: this._getYear(currentYear, month, yrCounter),
          month: Utils$1.monthMod(month),
          day: date
        });
        var pos = firstTickPosition;

        for (var i = 0; i < numberOfDays; i++) {
          date += 1;
          unit = 'day';
          month = changeMonth(date, month, this._getYear(currentYear, month, yrCounter));

          var year = this._getYear(currentYear, month, yrCounter);

          pos = 24 * hoursWidthOnXAxis + pos;
          var value = date === 1 ? Utils$1.monthMod(month) : date;
          this.timeScaleArray.push({
            position: pos,
            value: value,
            unit: unit,
            year: year,
            month: Utils$1.monthMod(month),
            day: value
          });
        }
      }
    }, {
      key: "generateHourScale",
      value: function generateHourScale(_ref4) {
        var firstVal = _ref4.firstVal,
            currentDate = _ref4.currentDate,
            currentMonth = _ref4.currentMonth,
            currentYear = _ref4.currentYear,
            minutesWidthOnXAxis = _ref4.minutesWidthOnXAxis,
            numberOfHours = _ref4.numberOfHours;
        var dt = new DateTime(this.ctx);
        var yrCounter = 0;
        var unit = 'hour';

        var changeDate = function changeDate(dateVal, month) {
          var monthdays = dt.determineDaysOfMonths(month + 1, currentYear);

          if (dateVal > monthdays) {
            date = 1;
            month = month + 1;
          }

          return {
            month: month,
            date: date
          };
        };

        var changeMonth = function changeMonth(dateVal, month) {
          var monthdays = dt.determineDaysOfMonths(month + 1, currentYear);

          if (dateVal > monthdays) {
            month = month + 1;
            return month;
          }

          return month;
        };


        var remainingMins = 60 - (firstVal.minMinute + firstVal.minSecond / 60.0);
        var firstTickPosition = remainingMins * minutesWidthOnXAxis;
        var firstTickValue = firstVal.minHour + 1;
        var hour = firstTickValue + 1;

        if (remainingMins === 60) {
          firstTickPosition = 0;
          firstTickValue = firstVal.minHour;
          hour = firstTickValue + 1;
        }

        var date = currentDate;
        var month = changeMonth(date, currentMonth);

        this.timeScaleArray.push({
          position: firstTickPosition,
          value: firstTickValue,
          unit: unit,
          day: date,
          hour: hour,
          year: currentYear,
          month: Utils$1.monthMod(month)
        });
        var pos = firstTickPosition;

        for (var i = 0; i < numberOfHours; i++) {
          unit = 'hour';

          if (hour >= 24) {
            hour = 0;
            date += 1;
            unit = 'day';
            var checkNextMonth = changeDate(date, month);
            month = checkNextMonth.month;
            month = changeMonth(date, month);
          }

          var year = this._getYear(currentYear, month, yrCounter);

          pos = 60 * minutesWidthOnXAxis + pos;
          var val = hour === 0 ? date : hour;
          this.timeScaleArray.push({
            position: pos,
            value: val,
            unit: unit,
            hour: hour,
            day: date,
            year: year,
            month: Utils$1.monthMod(month)
          });
          hour++;
        }
      }
    }, {
      key: "generateMinuteScale",
      value: function generateMinuteScale(_ref5) {
        var currentMillisecond = _ref5.currentMillisecond,
            currentSecond = _ref5.currentSecond,
            currentMinute = _ref5.currentMinute,
            currentHour = _ref5.currentHour,
            currentDate = _ref5.currentDate,
            currentMonth = _ref5.currentMonth,
            currentYear = _ref5.currentYear,
            minutesWidthOnXAxis = _ref5.minutesWidthOnXAxis,
            secondsWidthOnXAxis = _ref5.secondsWidthOnXAxis,
            numberOfMinutes = _ref5.numberOfMinutes;
        var yrCounter = 0;
        var unit = 'minute';
        var remainingSecs = 60 - currentSecond;
        var firstTickPosition = (remainingSecs - currentMillisecond / 1000) * secondsWidthOnXAxis;
        var minute = currentMinute + 1;
        var date = currentDate;
        var month = currentMonth;
        var year = currentYear;
        var hour = currentHour;
        var pos = firstTickPosition;

        for (var i = 0; i < numberOfMinutes; i++) {
          if (minute >= 60) {
            minute = 0;
            hour += 1;

            if (hour === 24) {
              hour = 0;
            }
          }

          this.timeScaleArray.push({
            position: pos,
            value: minute,
            unit: unit,
            hour: hour,
            minute: minute,
            day: date,
            year: this._getYear(year, month, yrCounter),
            month: Utils$1.monthMod(month)
          });
          pos += minutesWidthOnXAxis;
          minute++;
        }
      }
    }, {
      key: "generateSecondScale",
      value: function generateSecondScale(_ref6) {
        var currentMillisecond = _ref6.currentMillisecond,
            currentSecond = _ref6.currentSecond,
            currentMinute = _ref6.currentMinute,
            currentHour = _ref6.currentHour,
            currentDate = _ref6.currentDate,
            currentMonth = _ref6.currentMonth,
            currentYear = _ref6.currentYear,
            secondsWidthOnXAxis = _ref6.secondsWidthOnXAxis,
            numberOfSeconds = _ref6.numberOfSeconds;
        var yrCounter = 0;
        var unit = 'second';
        var remainingMillisecs = 1000 - currentMillisecond;
        var firstTickPosition = remainingMillisecs / 1000 * secondsWidthOnXAxis;
        var second = currentSecond + 1;
        var minute = currentMinute;
        var date = currentDate;
        var month = currentMonth;
        var year = currentYear;
        var hour = currentHour;
        var pos = firstTickPosition;

        for (var i = 0; i < numberOfSeconds; i++) {
          if (second >= 60) {
            minute++;
            second = 0;

            if (minute >= 60) {
              hour++;
              minute = 0;

              if (hour === 24) {
                hour = 0;
              }
            }
          }

          this.timeScaleArray.push({
            position: pos,
            value: second,
            unit: unit,
            hour: hour,
            minute: minute,
            second: second,
            day: date,
            year: this._getYear(year, month, yrCounter),
            month: Utils$1.monthMod(month)
          });
          pos += secondsWidthOnXAxis;
          second++;
        }
      }
    }, {
      key: "createRawDateString",
      value: function createRawDateString(ts, value) {
        var raw = ts.year;

        if (ts.month === 0) {

          ts.month = 1;
        }

        raw += '-' + ('0' + ts.month.toString()).slice(-2);

        if (ts.unit === 'day') {
          raw += ts.unit === 'day' ? '-' + ('0' + value).slice(-2) : '-01';
        } else {
          raw += '-' + ('0' + (ts.day ? ts.day : '1')).slice(-2);
        }


        if (ts.unit === 'hour') {
          raw += ts.unit === 'hour' ? 'T' + ('0' + value).slice(-2) : 'T00';
        } else {
          raw += 'T' + ('0' + (ts.hour ? ts.hour : '0')).slice(-2);
        }

        if (ts.unit === 'minute') {
          raw += ':' + ('0' + value).slice(-2);
        } else {
          raw += ':' + (ts.minute ? ('0' + ts.minute).slice(-2) : '00');
        }

        if (ts.unit === 'second') {
          raw += ':' + ('0' + value).slice(-2);
        } else {
          raw += ':00';
        }

        if (this.utc) {
          raw += '.000Z';
        }

        return raw;
      }
    }, {
      key: "formatDates",
      value: function formatDates(filteredTimeScale) {
        var _this2 = this;

        var w = this.w;
        var reformattedTimescaleArray = filteredTimeScale.map(function (ts) {
          var value = ts.value.toString();
          var dt = new DateTime(_this2.ctx);

          var raw = _this2.createRawDateString(ts, value);

          var dateToFormat = dt.getDate(dt.parseDate(raw));

          if (!_this2.utc) {

            dateToFormat = dt.getDate(dt.parseDateWithTimezone(raw));
          }

          if (w.config.xaxis.labels.format === undefined) {
            var customFormat = 'dd MMM';
            var dtFormatter = w.config.xaxis.labels.datetimeFormatter;
            if (ts.unit === 'year') customFormat = dtFormatter.year;
            if (ts.unit === 'month') customFormat = dtFormatter.month;
            if (ts.unit === 'day') customFormat = dtFormatter.day;
            if (ts.unit === 'hour') customFormat = dtFormatter.hour;
            if (ts.unit === 'minute') customFormat = dtFormatter.minute;
            if (ts.unit === 'second') customFormat = dtFormatter.second;
            value = dt.formatDate(dateToFormat, customFormat);
          } else {
            value = dt.formatDate(dateToFormat, w.config.xaxis.labels.format);
          }

          return {
            dateString: raw,
            position: ts.position,
            value: value,
            unit: ts.unit,
            year: ts.year,
            month: ts.month
          };
        });
        return reformattedTimescaleArray;
      }
    }, {
      key: "removeOverlappingTS",
      value: function removeOverlappingTS(arr) {
        var _this3 = this;

        var graphics = new Graphics(this.ctx);
        var equalLabelLengthFlag = false;

        var constantLabelWidth;

        if (arr.length > 0 &&
        arr[0].value &&
        arr.every(function (lb) {
          return lb.value.length === arr[0].value.length;
        })
        ) {
          equalLabelLengthFlag = true;

          constantLabelWidth = graphics.getTextRects(arr[0].value).width;
        }

        var lastDrawnIndex = 0;
        var filteredArray = arr.map(function (item, index) {
          if (index > 0 && _this3.w.config.xaxis.labels.hideOverlappingLabels) {
            var prevLabelWidth = !equalLabelLengthFlag
            ? graphics.getTextRects(arr[lastDrawnIndex].value).width
            : constantLabelWidth;

            var prevPos = arr[lastDrawnIndex].position;
            var pos = item.position;

            if (pos > prevPos + prevLabelWidth + 10) {
              lastDrawnIndex = index;
              return item;
            } else {
              return null;
            }
          } else {
            return item;
          }
        });
        filteredArray = filteredArray.filter(function (f) {
          return f !== null;
        });
        return filteredArray;
      }
    }, {
      key: "_getYear",
      value: function _getYear(currentYear, month, yrCounter) {
        return currentYear + Math.floor(month / 12) + yrCounter;
      }
    }]);

    return TimeScale;
  }();

  /**
   * ApexCharts Core Class responsible for major calculations and creating elements.
   *
   * @module Core
   **/

  var Core = /*#__PURE__*/function () {
    function Core(el, ctx) {
      _classCallCheck(this, Core);

      this.ctx = ctx;
      this.w = ctx.w;
      this.el = el;
    }


    _createClass(Core, [{
      key: "setupElements",
      value: function setupElements() {
        var gl = this.w.globals;
        var cnf = this.w.config;

ndlestickSeries.series, 'candlestick', candlestickSeries.i));
          }

          if (boxplotSeries.series.length > 0) {
            elGraph.push(boxCandlestick.draw(boxplotSeries.series, 'boxPlot', boxplotSeries.i));
          }

          if (rangeBarSeries.series.length > 0) {
            elGraph.push(this.ctx.rangeBar.draw(rangeBarSeries.series, rangeBarSeries.i));
          }

          if (scatterSeries.series.length > 0) {
            var scatterLine = new Line(this.ctx, xyRatios, true);
            elGraph.push(scatterLine.draw(scatterSeries.series, 'scatter', scatterSeries.i));
          }

          if (bubbleSeries.series.length > 0) {
            var bubbleLine = new Line(this.ctx, xyRatios, true);
            elGraph.push(bubbleLine.draw(bubbleSeries.series, 'bubble', bubbleSeries.i));
          }
        } else {
          switch (cnf.chart.type) {
            case 'line':
              elGraph = line.draw(gl.series, 'line');
              break;

            case 'area':
              elGraph = line.draw(gl.series, 'area');
              break;

            case 'bar':
              if (cnf.chart.stacked) {
                var _barStacked = new BarStacked(this.ctx, xyRatios);

                elGraph = _barStacked.draw(gl.series);
              } else {
                this.ctx.bar = new Bar(this.ctx, xyRatios);
                elGraph = this.ctx.bar.draw(gl.series);
              }

              break;

            case 'candlestick':
              var candleStick = new BoxCandleStick(this.ctx, xyRatios);
              elGraph = candleStick.draw(gl.series, 'candlestick');
              break;

            case 'boxPlot':
              var boxPlot = new BoxCandleStick(this.ctx, xyRatios);
              elGraph = boxPlot.draw(gl.series, 'boxPlot');
              break;

            case 'rangeBar':
              elGraph = this.ctx.rangeBar.draw(gl.series);
              break;

            case 'rangeArea':
              elGraph = line.draw(gl.seriesRangeStart, 'rangeArea', undefined, gl.seriesRangeEnd);
              break;

            case 'heatmap':
              var heatmap = new HeatMap(this.ctx, xyRatios);
              elGraph = heatmap.draw(gl.series);
              break;

            case 'treemap':
              var treemap = new TreemapChart(this.ctx, xyRatios);
              elGraph = treemap.draw(gl.series);
              break;

            case 'pie':
            case 'donut':
            case 'polarArea':
              elGraph = this.ctx.pie.draw(gl.series);
              break;

            case 'radialBar':
              elGraph = radialBar.draw(gl.series);
              break;

            case 'radar':
              elGraph = radar.draw(gl.series);
              break;

            default:
              elGraph = line.draw(gl.series);
          }
        }

        return elGraph;
      }
    }, {
      key: "setSVGDimensions",
      value: function setSVGDimensions() {
        var gl = this.w.globals;
        var cnf = this.w.config;
        gl.svgWidth = cnf.chart.width;
        gl.svgHeight = cnf.chart.height;
        var elDim = Utils$1.getDimensions(this.el);
        var widthUnit = cnf.chart.width.toString().split(/[0-9]+/g).pop();

        if (widthUnit === '%') {
          if (Utils$1.isNumber(elDim[0])) {
            if (elDim[0].width === 0) {
              elDim = Utils$1.getDimensions(this.el.parentNode);
            }

            gl.svgWidth = elDim[0] * parseInt(cnf.chart.width, 10) / 100;
          }
        } else if (widthUnit === 'px' || widthUnit === '') {
          gl.svgWidth = parseInt(cnf.chart.width, 10);
        }

        var heightUnit = cnf.chart.height.toString().split(/[0-9]+/g).pop();

        if (gl.svgHeight !== 'auto' && gl.svgHeight !== '') {
          if (heightUnit === '%') {
            var elParentDim = Utils$1.getDimensions(this.el.parentNode);
            gl.svgHeight = elParentDim[1] * parseInt(cnf.chart.height, 10) / 100;
          } else {
            gl.svgHeight = parseInt(cnf.chart.height, 10);
          }
        } else {
          if (gl.axisCharts) {
            gl.svgHeight = gl.svgWidth / 1.61;
          } else {
            gl.svgHeight = gl.svgWidth / 1.2;
          }
        }

        if (gl.svgWidth < 0) gl.svgWidth = 0;
        if (gl.svgHeight < 0) gl.svgHeight = 0;
        Graphics.setAttrs(gl.dom.Paper.node, {
          width: gl.svgWidth,
          height: gl.svgHeight
        });

        if (heightUnit !== '%') {

          var offsetY = cnf.chart.sparkline.enabled ? 0 : gl.axisCharts ? cnf.chart.parentHeightOffset : 0;
          gl.dom.Paper.node.parentNode.parentNode.style.minHeight = gl.svgHeight + offsetY + 'px';
        }

        gl.dom.elWrap.style.width = gl.svgWidth + 'px';
        gl.dom.elWrap.style.height = gl.svgHeight + 'px';
      }
    }, {
      key: "shiftGraphPosition",
      value: function shiftGraphPosition() {
        var gl = this.w.globals;
        var tY = gl.translateY;
        var tX = gl.translateX;
        var scalingAttrs = {
          transform: 'translate(' + tX + ', ' + tY + ')'
        };
        Graphics.setAttrs(gl.dom.elGraphical.node, scalingAttrs);
      }

    }, {
      key: "resizeNonAxisCharts",
      value: function resizeNonAxisCharts() {
        var w = this.w;
        var gl = w.globals;
        var legendHeight = 0;
        var offY = w.config.chart.sparkline.enabled ? 1 : 15;
        offY = offY + w.config.grid.padding.bottom;

        if ((w.config.legend.position === 'top' || w.config.legend.position === 'bottom') && w.config.legend.show && !w.config.legend.floating) {
          legendHeight = new Legend(this.ctx).legendHelpers.getLegendBBox().clwh + 10;
        }

        var el = w.globals.dom.baseEl.querySelector('.apexcharts-radialbar, .apexcharts-pie');
        var chartInnerDimensions = w.globals.radialSize * 2.05;

        if (el && !w.config.chart.sparkline.enabled && w.config.plotOptions.radialBar.startAngle !== 0) {
          var elRadialRect = Utils$1.getBoundingClientRect(el);
          chartInnerDimensions = elRadialRect.bottom;
          var maxHeight = elRadialRect.bottom - elRadialRect.top;
          chartInnerDimensions = Math.max(w.globals.radialSize * 2.05, maxHeight);
        }

        var newHeight = chartInnerDimensions + gl.translateY + legendHeight + offY;

        if (gl.dom.elLegendForeign) {
          gl.dom.elLegendForeign.setAttribute('height', newHeight);
        }


        if (w.config.chart.height && String(w.config.chart.height).indexOf('%') > 0) return;
        gl.dom.elWrap.style.height = newHeight + 'px';
        Graphics.setAttrs(gl.dom.Paper.node, {
          height: newHeight
        });
        gl.dom.Paper.node.parentNode.parentNode.style.minHeight = newHeight + 'px';
      }
      /*
       ** All the calculations for setting range in charts will be done here
       */

    }, {
      key: "coreCalculations",
      value: function coreCalculations() {
        var range = new Range(this.ctx);
        range.init();
      }
    }, {
      key: "resetGlobals",
      value: function resetGlobals() {
        var _this = this;

        var resetxyValues = function resetxyValues() {
          return _this.w.config.series.map(function (s) {
            return [];
          });
        };

        var globalObj = new Globals();
        var gl = this.w.globals;
        globalObj.initGlobalVars(gl);
        gl.seriesXvalues = resetxyValues();
        gl.seriesYvalues = resetxyValues();
      }
    }, {
      key: "isMultipleY",
      value: function isMultipleY() {

        if (this.w.config.yaxis.constructor === Array && this.w.config.yaxis.length > 1) {
          this.w.globals.isMultipleYAxis = true;
          return true;
        }
      }
    }, {
      key: "xySettings",
      value: function xySettings() {
        var xyRatios = null;
        var w = this.w;

        if (w.globals.axisCharts) {
          if (w.config.xaxis.crosshairs.position === 'back') {
            var crosshairs = new Crosshairs(this.ctx);
            crosshairs.drawXCrosshairs();
          }

          if (w.config.yaxis[0].crosshairs.position === 'back') {
            var _crosshairs = new Crosshairs(this.ctx);

            _crosshairs.drawYCrosshairs();
          }

          if (w.config.xaxis.type === 'datetime' && w.config.xaxis.labels.formatter === undefined) {
            this.ctx.timeScale = new TimeScale(this.ctx);
            var formattedTimeScale = [];

            if (isFinite(w.globals.minX) && isFinite(w.globals.maxX) && !w.globals.isBarHorizontal) {
              formattedTimeScale = this.ctx.timeScale.calculateTimeScaleTicks(w.globals.minX, w.globals.maxX);
            } else if (w.globals.isBarHorizontal) {
              formattedTimeScale = this.ctx.timeScale.calculateTimeScaleTicks(w.globals.minY, w.globals.maxY);
            }

            this.ctx.timeScale.recalcDimensionsBasedOnFormat(formattedTimeScale);
          }

          var coreUtils = new CoreUtils(this.ctx);
          xyRatios = coreUtils.getCalculatedRatios();
        }

        return xyRatios;
      }
    }, {
      key: "updateSourceChart",
      value: function updateSourceChart(targetChart) {
        this.ctx.w.globals.selection = undefined;

        this.ctx.updateHelpers._updateOptions({
          chart: {
            selection: {
              xaxis: {
                min: targetChart.w.globals.minX,
                max: targetChart.w.globals.maxX
              }
            }
          }
        }, false, false);
      }
    }, {
      key: "setupBrushHandler",
      value: function setupBrushHandler() {
        var _this2 = this;

        var w = this.w;

        if (!w.config.chart.brush.enabled) {
          return;
        }



        if (typeof w.config.chart.events.selection !== 'function') {
          var targets = w.config.chart.brush.targets || [w.config.chart.brush.target];

          targets.forEach(function (target) {
            var targetChart = ApexCharts.getChartByID(target);
            targetChart.w.globals.brushSource = _this2.ctx;

            if (typeof targetChart.w.config.chart.events.zoomed !== 'function') {
              targetChart.w.config.chart.events.zoomed = function () {
                _this2.updateSourceChart(targetChart);
              };
            }

            if (typeof targetChart.w.config.chart.events.scrolled !== 'function') {
              targetChart.w.config.chart.events.scrolled = function () {
                _this2.updateSourceChart(targetChart);
              };
            }
          });

          w.config.chart.events.selection = function (chart, e) {
            targets.forEach(function (target) {
              var targetChart = ApexCharts.getChartByID(target);
              var yaxis = Utils$1.clone(w.config.yaxis);

              if (w.config.chart.brush.autoScaleYaxis && targetChart.w.globals.series.length === 1) {
                var scale = new Range$1(targetChart);
                yaxis = scale.autoScaleY(targetChart, yaxis, e);
              }

              var multipleYaxis = targetChart.w.config.yaxis.reduce(function (acc, curr, index) {
                return [].concat(_toConsumableArray(acc), [_objectSpread2(_objectSpread2({}, targetChart.w.config.yaxis[index]), {}, {
                  min: yaxis[0].min,
                  max: yaxis[0].max
                })]);
              }, []);

              targetChart.ctx.updateHelpers._updateOptions({
                xaxis: {
                  min: e.xaxis.min,
                  max: e.xaxis.max
                },
                yaxis: multipleYaxis
              }, false, false, false, false);
            });
          };
        }
      }
    }]);

    return Core;
  }();

  var UpdateHelpers = /*#__PURE__*/function () {
    function UpdateHelpers(ctx) {
      _classCallCheck(this, UpdateHelpers);

      this.ctx = ctx;
      this.w = ctx.w;
    }
    /**
     * private method to update Options.
     *
     * @param {object} options - A new config object can be passed which will be merged with the existing config object
     * @param {boolean} redraw - should redraw from beginning or should use existing paths and redraw from there
     * @param {boolean} animate - should animate or not on updating Options
     * @param {boolean} overwriteInitialConfig - should update the initial config or not
     */


    _createClass(UpdateHelpers, [{
      key: "_updateOptions",
      value: function _updateOptions(options) {
        var _this = this;

        var redraw = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
        var animate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
        var updateSyncedCharts = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : true;
        var overwriteInitialConfig = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
        return new Promise(function (resolve) {
          var charts = [_this.ctx];

          if (updateSyncedCharts) {
            charts = _this.ctx.getSyncedCharts();
          }

          if (_this.ctx.w.globals.isExecCalled) {

            charts = [_this.ctx];
            _this.ctx.w.globals.isExecCalled = false;
          }

          charts.forEach(function (ch, chartIndex) {
            var w = ch.w;
            w.globals.shouldAnimate = animate;

            if (!redraw) {
              w.globals.resized = true;
              w.globals.dataChanged = true;

              if (animate) {
                ch.series.getPreviousPaths();
              }
            }

            if (options && _typeof(options) === 'object') {
              ch.config = new Config(options);
              options = CoreUtils.extendArrayProps(ch.config, options, w);

              if (ch.w.globals.chartID !== _this.ctx.w.globals.chartID) {

                delete options.series;
              }

              w.config = Utils$1.extend(w.config, options);

              if (overwriteInitialConfig) {

                w.globals.lastXAxis = options.xaxis ? Utils$1.clone(options.xaxis) : [];
                w.globals.lastYAxis = options.yaxis ? Utils$1.clone(options.yaxis) : [];

                w.globals.initialConfig = Utils$1.extend({}, w.config);
                w.globals.initialSeries = Utils$1.clone(w.config.series);

                if (options.series) {

                  for (var i = 0; i < w.globals.collapsedSeriesIndices.length; i++) {
                    var series = w.config.series[w.globals.collapsedSeriesIndices[i]];
                    w.globals.collapsedSeries[i].data = w.globals.axisCharts ? series.data.slice() : series;
                  }

                  for (var _i = 0; _i < w.globals.ancillaryCollapsedSeriesIndices.length; _i++) {
                    var _series = w.config.series[w.globals.ancillaryCollapsedSeriesIndices[_i]];
                    w.globals.ancillaryCollapsedSeries[_i].data = w.globals.axisCharts ? _series.data.slice() : _series;
                  }


                  ch.series.emptyCollapsedSeries(w.config.series);
                }
              }
            }

            return ch.update(options).then(function () {
              if (chartIndex === charts.length - 1) {
                resolve(ch);
              }
            });
          });
        });
      }
      /**
       * Private method to update Series.
       *
       * @param {array} series - New series which will override the existing
       */

    }, {
      key: "_updateSeries",
      value: function _updateSeries(newSeries, animate) {
        var _this2 = this;

        var overwriteInitialSeries = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
        return new Promise(function (resolve) {
          var w = _this2.w;
          w.globals.shouldAnimate = animate;
          w.globals.dataChanged = true;

          if (animate) {
            _this2.ctx.series.getPreviousPaths();
          }

          var existingSeries;

          if (w.globals.axisCharts) {
            existingSeries = newSeries.map(function (s, i) {
              return _this2._extendSeries(s, i);
            });

            if (existingSeries.length === 0) {
              existingSeries = [{
                data: []
              }];
            }

            w.config.series = existingSeries;
          } else {

            w.config.series = newSeries.slice();
          }

          if (overwriteInitialSeries) {
            w.globals.initialConfig.series = Utils$1.clone(w.config.series);
            w.globals.initialSeries = Utils$1.clone(w.config.series);
          }

          return _this2.ctx.update().then(function () {
            resolve(_this2.ctx);
          });
        });
      }
    }, {
      key: "_extendSeries",
      value: function _extendSeries(s, i) {
        var w = this.w;
        var ser = w.config.series[i];
        return _objectSpread2(_objectSpread2({}, w.config.series[i]), {}, {
          name: s.name ? s.name : ser && ser.name,
          color: s.color ? s.color : ser && ser.color,
          type: s.type ? s.type : ser && ser.type,
          data: s.data ? s.data : ser && ser.data
        });
      }
    }, {
      key: "toggleDataPointSelection",
      value: function toggleDataPointSelection(seriesIndex, dataPointIndex) {
        var w = this.w;
        var elPath = null;
        var parent = ".apexcharts-series[data\\:realIndex='".concat(seriesIndex, "']");

        if (w.globals.axisCharts) {
          elPath = w.globals.dom.Paper.select("".concat(parent, " path[j='").concat(dataPointIndex, "'], ").concat(parent, " circle[j='").concat(dataPointIndex, "'], ").concat(parent, " rect[j='").concat(dataPointIndex, "']")).members[0];
        } else {

          if (typeof dataPointIndex === 'undefined') {
            elPath = w.globals.dom.Paper.select("".concat(parent, " path[j='").concat(seriesIndex, "']")).members[0];

            if (w.config.chart.type === 'pie' || w.config.chart.type === 'polarArea' || w.config.chart.type === 'donut') {
              this.ctx.pie.pieClicked(seriesIndex);
            }
          }
        }

        if (elPath) {
          var graphics = new Graphics(this.ctx);
          graphics.pathMouseDown(elPath, null);
        } else {
          console.warn('toggleDataPointSelection: Element not found');
          return null;
        }

        return elPath.node ? elPath.node : null;
      }
    }, {
      key: "forceXAxisUpdate",
      value: function forceXAxisUpdate(options) {
        var w = this.w;
        var minmax = ['min', 'max'];
        minmax.forEach(function (a) {
          if (typeof options.xaxis[a] !== 'undefined') {
            w.config.xaxis[a] = options.xaxis[a];
            w.globals.lastXAxis[a] = options.xaxis[a];
          }
        });

        if (options.xaxis.categories && options.xaxis.categories.length) {
          w.config.xaxis.categories = options.xaxis.categories;
        }

        if (w.config.xaxis.convertedCatToNumeric) {
          var defaults = new Defaults(options);
          options = defaults.convertCatToNumericXaxis(options, this.ctx);
        }

        return options;
      }
    }, {
      key: "forceYAxisUpdate",
      value: function forceYAxisUpdate(options) {
        if (options.chart && options.chart.stacked && options.chart.stackType === '100%') {
          if (Array.isArray(options.yaxis)) {
            options.yaxis.forEach(function (yaxe, index) {
              options.yaxis[index].min = 0;
              options.yaxis[index].max = 100;
            });
          } else {
            options.yaxis.min = 0;
            options.yaxis.max = 100;
          }
        }

        return options;
      }
      /**
       * This function reverts the yaxis and xaxis min/max values to what it was when the chart was defined.
       * This function fixes an important bug where a user might load a new series after zooming in/out of previous series which resulted in wrong min/max
       * Also, this should never be called internally on zoom/pan - the reset should only happen when user calls the updateSeries() function externally
       * The function also accepts an object {xaxis, yaxis} which when present is set as the new xaxis/yaxis
       */

    }, {
      key: "revertDefaultAxisMinMax",
      value: function revertDefaultAxisMinMax(opts) {
        var _this3 = this;

        var w = this.w;
        var xaxis = w.globals.lastXAxis;
        var yaxis = w.globals.lastYAxis;

        if (opts && opts.xaxis) {
          xaxis = opts.xaxis;
        }

        if (opts && opts.yaxis) {
          yaxis = opts.yaxis;
        }

        w.config.xaxis.min = xaxis.min;
        w.config.xaxis.max = xaxis.max;

        var getLastYAxis = function getLastYAxis(index) {
          if (typeof yaxis[index] !== 'undefined') {
            w.config.yaxis[index].min = yaxis[index].min;
            w.config.yaxis[index].max = yaxis[index].max;
          }
        };

        w.config.yaxis.map(function (yaxe, index) {
          if (w.globals.zoomed) {

            getLastYAxis(index);
          } else {

            if (typeof yaxis[index] !== 'undefined') {
              getLastYAxis(index);
            } else {

              if (typeof _this3.ctx.opts.yaxis[index] !== 'undefined') {
                yaxe.min = _this3.ctx.opts.yaxis[index].min;
                yaxe.max = _this3.ctx.opts.yaxis[index].max;
              }
            }
          }
        });
      }
    }]);

    return UpdateHelpers;
  }();

  (function (root, factory) {
    /* istanbul ignore next */
    if (typeof define === 'function' && define.amd) {
      define(function () {
        return factory(root, root.document);
      });
      /* below check fixes #412 */
    } else if ((typeof exports === "undefined" ? "undefined" : _typeof(exports)) === 'object' && typeof module !== 'undefined') {
      module.exports = root.document ? factory(root, root.document) : function (w) {
        return factory(w, w.document);
      };
    } else {
      root.SVG = factory(root, root.document);
    }
  })(typeof window !== 'undefined' ? window : undefined, function (window, document) {


    var globalRef = typeof this !== 'undefined' ? this : window;

    var SVG = globalRef.SVG = function (element) {
      if (SVG.supported) {
        element = new SVG.Doc(element);

        if (!SVG.parser.draw) {
          SVG.prepare();
        }

        return element;
      }
    };


    SVG.ns = 'http://www.w3.org/2000/svg';
    SVG.xmlns = 'http://www.w3.org/2000/xmlns/';
    SVG.xlink = 'http://www.w3.org/1999/xlink';
    SVG.svgjs = 'http://svgjs.dev';

    SVG.supported = function () {
      return true;

    }();


    if (!SVG.supported) return false;

    SVG.did = 1000;

    SVG.eid = function (name) {
      return 'Svgjs' + capitalize(name) + SVG.did++;
    };


    SVG.create = function (name) {

      var element = document.createElementNS(this.ns, name);

      element.setAttribute('id', this.eid(name));
      return element;
    };


    SVG.extend = function () {
      var modules, methods;

      modules = [].slice.call(arguments);

      methods = modules.pop();

      for (var i = modules.length - 1; i >= 0; i--) {
        if (modules[i]) {
          for (var key in methods) {
            modules[i].prototype[key] = methods[key];
          }
        }
      }


      if (SVG.Set && SVG.Set.inherit) {
        SVG.Set.inherit();
      }
    };


    SVG.invent = function (config) {

      var initializer = typeof config.create === 'function' ? config.create : function () {
        this.constructor.call(this, SVG.create(config.create));
      };

      if (config.inherit) {
        initializer.prototype = new config.inherit();
      }


      if (config.extend) {
        SVG.extend(initializer, config.extend);
      }


      if (config.construct) {
        SVG.extend(config.parent || SVG.Container, config.construct);
      }

      return initializer;
    };


    SVG.adopt = function (node) {

      if (!node) return null;

      if (node.instance) return node.instance;

      var element;

      if (node.nodeName == 'svg') {
        element = node.parentNode instanceof window.SVGElement ? new SVG.Nested() : new SVG.Doc();
      } else if (node.nodeName == 'linearGradient') {
        element = new SVG.Gradient('linear');
      } else if (node.nodeName == 'radialGradient') {
        element = new SVG.Gradient('radial');
      } else if (SVG[capitalize(node.nodeName)]) {
        element = new SVG[capitalize(node.nodeName)]();
      } else {
        element = new SVG.Element(node);
      }


      element.type = node.nodeName;
      element.node = node;
      node.instance = element;

      if (element instanceof SVG.Doc) {
        element.namespace().defs();
      }


      element.setData(JSON.parse(node.getAttribute('svgjs:data')) || {});
      return element;
    };


    SVG.prepare = function () {

      var body = document.getElementsByTagName('body')[0],
          draw = (body ? new SVG.Doc(body) : SVG.adopt(document.documentElement).nested()).size(2, 0);

      SVG.parser = {
        body: body || document.documentElement,
        draw: draw.style('opacity:0;position:absolute;left:-100%;top:-100%;overflow:hidden').node,
        poly: draw.polyline().node,
        path: draw.path().node,
        native: SVG.create('svg')
      };
    };

    SVG.parser = {
      native: SVG.create('svg')
    };
    document.addEventListener('DOMContentLoaded', function () {
      if (!SVG.parser.draw) {
        SVG.prepare();
      }
    }, false);

    SVG.regex = {

      numberAndUnit: /^([+-]?(\d+(\.\d*)?|\.\d+)(e[+-]?\d+)?)([a-z%]*)$/i,

      hex: /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,

      rgb: /rgb\((\d+),(\d+),(\d+)\)/,

      reference: /#([a-z0-9\-_]+)/i,

      transforms: /\)\s*,?\s*/,

      whitespace: /\s/g,

      isHex: /^#[a-f0-9]{3,6}$/i,

      isRgb: /^rgb\(/,

      isCss: /[^:]+:[^;]+;?/,

      isBlank: /^(\s+)?$/,

      isNumber: /^[+-]?(\d+(\.\d*)?|\.\d+)(e[+-]?\d+)?$/i,

      isPercent: /^-?[\d\.]+%$/,

      isImage: /\.(jpg|jpeg|png|gif|svg)(\?[^=]+.*)?/i,

      delimiter: /[\s,]+/,


      hyphen: /([^e])\-/gi,

      pathLetters: /[MLHVCSQTAZ]/gi,

      isPathLetter: /[MLHVCSQTAZ]/i,

      numbersWithDots: /((\d?\.\d+(?:e[+-]?\d+)?)((?:\.\d+(?:e[+-]?\d+)?)+))+/gi,

      dots: /\./g
    };
    SVG.utils = {

      map: function map(array, block) {
        var il = array.length,
            result = [];

        for (var i = 0; i < il; i++) {
          result.push(block(array[i]));
        }

        return result;
      },

      filter: function filter(array, block) {
        var il = array.length,
            result = [];

        for (var i = 0; i < il; i++) {
          if (block(array[i])) {
            result.push(array[i]);
          }
        }

        return result;
      },
      filterSVGElements: function filterSVGElements(nodes) {
        return this.filter(nodes, function (el) {
          return el instanceof window.SVGElement;
        });
      }
    };
    SVG.defaults = {

      attrs: {

        'fill-opacity': 1,
        'stroke-opacity': 1,
        'stroke-width': 0,
        'stroke-linejoin': 'miter',
        'stroke-linecap': 'butt',
        fill: '#000000',
        stroke: '#000000',
        opacity: 1,

        x: 0,
        y: 0,
        cx: 0,
        cy: 0,

        width: 0,
        height: 0,

        r: 0,
        rx: 0,
        ry: 0,

        offset: 0,
        'stop-opacity': 1,
        'stop-color': '#000000',

        'font-size': 16,
        'font-family': 'Helvetica, Arial, sans-serif',
        'text-anchor': 'start'
      }
    };

    SVG.Color = function (color) {
      var match;

      this.r = 0;
      this.g = 0;
      this.b = 0;
      if (!color) return;

      if (typeof color === 'string') {
        if (SVG.regex.isRgb.test(color)) {

          match = SVG.regex.rgb.exec(color.replace(SVG.regex.whitespace, ''));

          this.r = parseInt(match[1]);
          this.g = parseInt(match[2]);
          this.b = parseInt(match[3]);
        } else if (SVG.regex.isHex.test(color)) {

          match = SVG.regex.hex.exec(fullHex(color));

          this.r = parseInt(match[1], 16);
          this.g = parseInt(match[2], 16);
          this.b = parseInt(match[3], 16);
        }
      } else if (_typeof(color) === 'object') {
        this.r = color.r;
        this.g = color.g;
        this.b = color.b;
      }
    };

    SVG.extend(SVG.Color, {

      toString: function toString() {
        return this.toHex();
      },

      toHex: function toHex() {
        return '#' + compToHex(this.r) + compToHex(this.g) + compToHex(this.b);
      },

      toRgb: function toRgb() {
        return 'rgb(' + [this.r, this.g, this.b].join() + ')';
      },

      brightness: function brightness() {
        return this.r / 255 * 0.30 + this.g / 255 * 0.59 + this.b / 255 * 0.11;
      },

      morph: function morph(color) {
        this.destination = new SVG.Color(color);
        return this;
      },

      at: function at(pos) {

        if (!this.destination) return this;

        pos = pos < 0 ? 0 : pos > 1 ? 1 : pos;

        return new SVG.Color({
          r: ~~(this.r + (this.destination.r - this.r) * pos),
          g: ~~(this.g + (this.destination.g - this.g) * pos),
          b: ~~(this.b + (this.destination.b - this.b) * pos)
        });
      }
    });


    SVG.Color.test = function (color) {
      color += '';
      return SVG.regex.isHex.test(color) || SVG.regex.isRgb.test(color);
    };


    SVG.Color.isRgb = function (color) {
      return color && typeof color.r === 'number' && typeof color.g === 'number' && typeof color.b === 'number';
    };


    SVG.Color.isColor = function (color) {
      return SVG.Color.isRgb(color) || SVG.Color.test(color);
    };


    SVG.Array = function (array, fallback) {
      array = (array || []).valueOf();

      if (array.length == 0 && fallback) {
        array = fallback.valueOf();
      }


      this.value = this.parse(array);
    };

    SVG.extend(SVG.Array, {

      toString: function toString() {
        return this.value.join(' ');
      },

      valueOf: function valueOf() {
        return this.value;
      },

      parse: function parse(array) {
        array = array.valueOf();

        if (Array.isArray(array)) return array;
        return this.split(array);
      }
    });

    SVG.PointArray = function (array, fallback) {
      SVG.Array.call(this, array, fallback || [[0, 0]]);
    };


    SVG.PointArray.prototype = new SVG.Array();
    SVG.PointArray.prototype.constructor = SVG.PointArray;
    var pathHandlers = {
      M: function M(c, p, p0) {
        p.x = p0.x = c[0];
        p.y = p0.y = c[1];
        return ['M', p.x, p.y];
      },
      L: function L(c, p) {
        p.x = c[0];
        p.y = c[1];
        return ['L', c[0], c[1]];
      },
      H: function H(c, p) {
        p.x = c[0];
        return ['H', c[0]];
      },
      V: function V(c, p) {
        p.y = c[0];
        return ['V', c[0]];
      },
      C: function C(c, p) {
        p.x = c[4];
        p.y = c[5];
        return ['C', c[0], c[1], c[2], c[3], c[4], c[5]];
      },
      Q: function Q(c, p) {
        p.x = c[2];
        p.y = c[3];
        return ['Q', c[0], c[1], c[2], c[3]];
      },
      Z: function Z(c, p, p0) {
        p.x = p0.x;
        p.y = p0.y;
        return ['Z'];
      }
    };
    var mlhvqtcsa = 'mlhvqtcsaz'.split('');

    for (var i = 0, il = mlhvqtcsa.length; i < il; ++i) {
      pathHandlers[mlhvqtcsa[i]] = function (i) {
        return function (c, p, p0) {
          if (i == 'H') c[0] = c[0] + p.x;else if (i == 'V') c[0] = c[0] + p.y;else if (i == 'A') {
            c[5] = c[5] + p.x, c[6] = c[6] + p.y;
          } else {
            for (var j = 0, jl = c.length; j < jl; ++j) {
              c[j] = c[j] + (j % 2 ? p.y : p.x);
            }
          }

          if (pathHandlers && typeof pathHandlers[i] === 'function') {

            return pathHandlers[i](c, p, p0);
          }
        };
      }(mlhvqtcsa[i].toUpperCase());
    }


    SVG.PathArray = function (array, fallback) {
      SVG.Array.call(this, array, fallback || [['M', 0, 0]]);
    };


    SVG.PathArray.prototype = new SVG.Array();
    SVG.PathArray.prototype.constructor = SVG.PathArray;
    SVG.extend(SVG.PathArray, {

      toString: function toString() {
        return arrayToString(this.value);
      },

      move: function move(x, y) {

        var box = this.bbox();

        x -= box.x;
        y -= box.y;
        return this;
      },

      at: function at(pos) {

        if (!this.destination) return this;
        var sourceArray = this.value,
            destinationArray = this.destination.value,
            array = [],
            pathArray = new SVG.PathArray(),
            il,
            jl;


        for (var i = 0, il = sourceArray.length; i < il; i++) {
          array[i] = [sourceArray[i][0]];

          for (var j = 1, jl = sourceArray[i].length; j < jl; j++) {
            array[i][j] = sourceArray[i][j] + (destinationArray[i][j] - sourceArray[i][j]) * pos;
          }






          if (array[i][0] === 'A') {
            array[i][4] = +(array[i][4] != 0);
            array[i][5] = +(array[i][5] != 0);
          }
        }


        pathArray.value = array;
        return pathArray;
      },

      parse: function parse(array) {

        if (array instanceof SVG.PathArray) return array.valueOf();

        var s,
            arr,
            paramCnt = {
          'M': 2,
          'L': 2,
          'H': 1,
          'V': 1,
          'C': 6,
          'S': 4,
          'Q': 4,
          'T': 2,
          'A': 7,
          'Z': 0
        };

        if (typeof array === 'string') {
          array = array.replace(SVG.regex.numbersWithDots, pathRegReplace)
          .replace(SVG.regex.pathLetters, ' $& ')
          .replace(SVG.regex.hyphen, '$1 -')
          .trim()
          .split(SVG.regex.delimiter);
        } else {
          array = array.reduce(function (prev, curr) {
            return [].concat.call(prev, curr);
          }, []);
        }


        var arr = [],
            p = new SVG.Point(),
            p0 = new SVG.Point(),
            index = 0,
            len = array.length;

        do {

          if (SVG.regex.isPathLetter.test(array[index])) {
            s = array[index];
            ++index;
          } else if (s == 'M') {
            s = 'L';
          } else if (s == 'm') {
            s = 'l';
          }

          arr.push(pathHandlers[s].call(null, array.slice(index, index = index + paramCnt[s.toUpperCase()]).map(parseFloat), p, p0));
        } while (len > index);

        return arr;
      },

      bbox: function bbox() {
        if (!SVG.parser.draw) {
          SVG.prepare();
        }

        SVG.parser.path.setAttribute('d', this.toString());
        return SVG.parser.path.getBBox();
      }
    });

    SVG.Number = SVG.invent({

      create: function create(value, unit) {

        this.value = 0;
        this.unit = unit || '';

        if (typeof value === 'number') {

          this.value = isNaN(value) ? 0 : !isFinite(value) ? value < 0 ? -3.4e+38 : +3.4e+38 : value;
        } else if (typeof value === 'string') {
          unit = value.match(SVG.regex.numberAndUnit);

          if (unit) {

            this.value = parseFloat(unit[1]);

            if (unit[5] == '%') {
              this.value /= 100;
            } else if (unit[5] == 's') {
              this.value *= 1000;
            }


            this.unit = unit[5];
          }
        } else {
          if (value instanceof SVG.Number) {
            this.value = value.valueOf();
            this.unit = value.unit;
          }
        }
      },

      extend: {

        toString: function toString() {
          return (this.unit == '%' ? ~~(this.value * 1e8) / 1e6 : this.unit == 's' ? this.value / 1e3 : this.value) + this.unit;
        },
        toJSON: function toJSON() {
          return this.toString();
        },

        valueOf: function valueOf() {
          return this.value;
        },

        plus: function plus(number) {
          number = new SVG.Number(number);
          return new SVG.Number(this + number, this.unit || number.unit);
        },

        minus: function minus(number) {
          number = new SVG.Number(number);
          return new SVG.Number(this - number, this.unit || number.unit);
        },

        times: function times(number) {
          number = new SVG.Number(number);
          return new SVG.Number(this * number, this.unit || number.unit);
        },

        divide: function divide(number) {
          number = new SVG.Number(number);
          return new SVG.Number(this / number, this.unit || number.unit);
        },

        to: function to(unit) {
          var number = new SVG.Number(this);

          if (typeof unit === 'string') {
            number.unit = unit;
          }

          return number;
        },

        morph: function morph(number) {
          this.destination = new SVG.Number(number);

          if (number.relative) {
            this.destination.value += this.value;
          }

          return this;
        },

        at: function at(pos) {

          if (!this.destination) return this;

          return new SVG.Number(this.destination).minus(this).times(pos).plus(this);
        }
      }
    });
    SVG.Element = SVG.invent({

      create: function create(node) {

        this._stroke = SVG.defaults.attrs.stroke;
        this._event = null;

        this.dom = {};

        if (this.node = node) {
          this.type = node.nodeName;
          this.node.instance = this;

          this._stroke = node.getAttribute('stroke') || this._stroke;
        }
      },

      extend: {

        x: function x(_x) {
          return this.attr('x', _x);
        },

        y: function y(_y) {
          return this.attr('y', _y);
        },

        cx: function cx(x) {
          return x == null ? this.x() + this.width() / 2 : this.x(x - this.width() / 2);
        },

        cy: function cy(y) {
          return y == null ? this.y() + this.height() / 2 : this.y(y - this.height() / 2);
        },

        move: function move(x, y) {
          return this.x(x).y(y);
        },

        center: function center(x, y) {
          return this.cx(x).cy(y);
        },

        width: function width(_width) {
          return this.attr('width', _width);
        },

        height: function height(_height) {
          return this.attr('height', _height);
        },

        size: function size(width, height) {
          var p = proportionalSize(this, width, height);
          return this.width(new SVG.Number(p.width)).height(new SVG.Number(p.height));
        },

        clone: function clone(parent) {

          this.writeDataToDom();

          var clone = assignNewId(this.node.cloneNode(true));

          if (parent) parent.add(clone);else this.after(clone);
          return clone;
        },

        remove: function remove() {
          if (this.parent()) {
            this.parent().removeElement(this);
          }

          return this;
        },

        replace: function replace(element) {
          this.after(element).remove();
          return element;
        },

        addTo: function addTo(parent) {
          return parent.put(this);
        },

        putIn: function putIn(parent) {
          return parent.add(this);
        },

        id: function id(_id) {
          return this.attr('id', _id);
        },

        show: function show() {
          return this.style('display', '');
        },

        hide: function hide() {
          return this.style('display', 'none');
        },

        visible: function visible() {
          return this.style('display') != 'none';
        },

        toString: function toString() {
          return this.attr('id');
        },

        classes: function classes() {
          var attr = this.attr('class');
          return attr == null ? [] : attr.trim().split(SVG.regex.delimiter);
        },

        hasClass: function hasClass(name) {
          return this.classes().indexOf(name) != -1;
        },

        addClass: function addClass(name) {
          if (!this.hasClass(name)) {
            var array = this.classes();
            array.push(name);
            this.attr('class', array.join(' '));
          }

          return this;
        },

        removeClass: function removeClass(name) {
          if (this.hasClass(name)) {
            this.attr('class', this.classes().filter(function (c) {
              return c != name;
            }).join(' '));
          }

          return this;
        },

        toggleClass: function toggleClass(name) {
          return this.hasClass(name) ? this.removeClass(name) : this.addClass(name);
        },

        reference: function reference(attr) {
          return SVG.get(this.attr(attr));
        },

        parent: function parent(type) {
          var parent = this;

          if (!parent.node.parentNode) return null;

          parent = SVG.adopt(parent.node.parentNode);
          if (!type) return parent;

          while (parent && parent.node instanceof window.SVGElement) {
            if (typeof type === 'string' ? parent.matches(type) : parent instanceof type) return parent;
            if (!parent.node.parentNode || parent.node.parentNode.nodeName == '#document') return null;

            parent = SVG.adopt(parent.node.parentNode);
          }
        },

        doc: function doc() {
          return this instanceof SVG.Doc ? this : this.parent(SVG.Doc);
        },

        parents: function parents(type) {
          var parents = [],
              parent = this;

          do {
            parent = parent.parent(type);
            if (!parent || !parent.node) break;
            parents.push(parent);
          } while (parent.parent);

          return parents;
        },

        matches: function matches(selector) {
          return _matches(this.node, selector);
        },

        native: function native() {
          return this.node;
        },

        svg: function svg(_svg) {

          var well = document.createElement('svg');

          if (_svg && this instanceof SVG.Parent) {

            well.innerHTML = '<svg>' + _svg.replace(/\n/, '').replace(/<([\w:-]+)([^<]+?)\/>/g, '<$1$2></$1>') + '</svg>';

            for (var i = 0, il = well.firstChild.childNodes.length; i < il; i++) {
              this.node.appendChild(well.firstChild.firstChild);
            }

          } else {

            well.appendChild(_svg = document.createElement('svg'));

            this.writeDataToDom();

            _svg.appendChild(this.node.cloneNode(true));


            return well.innerHTML.replace(/^<svg>/, '').replace(/<\/svg>$/, '');
          }

          return this;
        },

        writeDataToDom: function writeDataToDom() {

          if (this.each || this.lines) {
            var fn = this.each ? this : this.lines();
            fn.each(function () {
              this.writeDataToDom();
            });
          }


          this.node.removeAttribute('svgjs:data');

          if (Object.keys(this.dom).length) {
            this.node.setAttribute('svgjs:data', JSON.stringify(this.dom));
          }


          return this;
        },

        setData: function setData(o) {
          this.dom = o;
          return this;
        },
        is: function is(obj) {
          return _is(this, obj);
        }
      }
    });
    SVG.easing = {
      '-': function _(pos) {
        return pos;
      },
      '<>': function _(pos) {
        return -Math.cos(pos * Math.PI) / 2 + 0.5;
      },
      '>': function _(pos) {
        return Math.sin(pos * Math.PI / 2);
      },
      '<': function _(pos) {
        return -Math.cos(pos * Math.PI / 2) + 1;
      }
    };

    SVG.morph = function (pos) {
      return function (from, to) {
        return new SVG.MorphObj(from, to).at(pos);
      };
    };

    SVG.Situation = SVG.invent({
      create: function create(o) {
        this.init = false;
        this.reversed = false;
        this.reversing = false;
        this.duration = new SVG.Number(o.duration).valueOf();
        this.delay = new SVG.Number(o.delay).valueOf();
        this.start = +new Date() + this.delay;
        this.finish = this.start + this.duration;
        this.ease = o.ease;


        this.loop = 0;
        this.loops = false;
        this.animations = {

        };
        this.attrs = {

        };
        this.styles = {

        };
        this.transforms = [

        ];
        this.once = {

        };
      }
    });
    SVG.FX = SVG.invent({
      create: function create(element) {
        this._target = element;
        this.situations = [];
        this.active = false;
        this.situation = null;
        this.paused = false;
        this.lastPos = 0;
        this.pos = 0;


        this.absPos = 0;
        this._speed = 1;
      },
      extend: {
        /**
         * sets or returns the target of this animation
         * @param o object || number In case of Object it holds all parameters. In case of number its the duration of the animation
         * @param ease function || string Function which should be used for easing or easing keyword
         * @param delay Number indicating the delay before the animation starts
         * @return target || this
         */
        animate: function animate(o, ease, delay) {
          if (_typeof(o) === 'object') {
            ease = o.ease;
            delay = o.delay;
            o = o.duration;
          }

          var situation = new SVG.Situation({
            duration: o || 1000,
            delay: delay || 0,
            ease: SVG.easing[ease || '-'] || ease
          });
          this.queue(situation);
          return this;
        },

        /**
        * sets a delay before the next element of the queue is called
        * @param delay Duration of delay in milliseconds
        * @return this.target()
        */

        /**
        * sets or returns the target of this animation
        * @param null || target SVG.Element which should be set as new target
        * @return target || this
        */
        target: function target(_target) {
          if (_target && _target instanceof SVG.Element) {
            this._target = _target;
            return this;
          }

          return this._target;
        },

        timeToAbsPos: function timeToAbsPos(timestamp) {
          return (timestamp - this.situation.start) / (this.situation.duration / this._speed);
        },

        absPosToTime: function absPosToTime(absPos) {
          return this.situation.duration / this._speed * absPos + this.situation.start;
        },

        startAnimFrame: function startAnimFrame() {
          this.stopAnimFrame();
          this.animationFrame = window.requestAnimationFrame(function () {
            this.step();
          }.bind(this));
        },

        stopAnimFrame: function stopAnimFrame() {
          window.cancelAnimationFrame(this.animationFrame);
        },

        start: function start() {

          if (!this.active && this.situation) {
            this.active = true;
            this.startCurrent();
          }

          return this;
        },

        startCurrent: function startCurrent() {
          this.situation.start = +new Date() + this.situation.delay / this._speed;
          this.situation.finish = this.situation.start + this.situation.duration / this._speed;
          return this.initAnimations().step();
        },

        /**
        * adds a function / Situation to the animation queue
        * @param fn function / situation to add
        * @return this
        */
        queue: function queue(fn) {
          if (typeof fn === 'function' || fn instanceof SVG.Situation) {
            this.situations.push(fn);
          }

          if (!this.situation) this.situation = this.situations.shift();
          return this;
        },

        /**
        * pulls next element from the queue and execute it
        * @return this
        */
        dequeue: function dequeue() {

          this.stop();

          this.situation = this.situations.shift();

          if (this.situation) {
            if (this.situation instanceof SVG.Situation) {
              this.start();
            } else {

              this.situation.call(this);
            }
          }

          return this;
        },


        initAnimations: function initAnimations() {
          var source;
          var s = this.situation;
          if (s.init) return this;

          for (var i in s.animations) {
            source = this.target()[i]();

            if (!Array.isArray(source)) {
              source = [source];
            }

            if (!Array.isArray(s.animations[i])) {
              s.animations[i] = [s.animations[i]];
            }




            for (var j = source.length; j--;) {


              if (s.animations[i][j] instanceof SVG.Number) {
                source[j] = new SVG.Number(source[j]);
              }

              s.animations[i][j] = source[j].morph(s.animations[i][j]);
            }
          }

          for (var i in s.attrs) {
            s.attrs[i] = new SVG.MorphObj(this.target().attr(i), s.attrs[i]);
          }

          for (var i in s.styles) {
            s.styles[i] = new SVG.MorphObj(this.target().style(i), s.styles[i]);
          }

          s.initialTransformation = this.target().matrixify();
          s.init = true;
          return this;
        },
        clearQueue: function clearQueue() {
          this.situations = [];
          return this;
        },
        clearCurrent: function clearCurrent() {
          this.situation = null;
          return this;
        },

        /** stops the animation immediately
        * @param jumpToEnd A Boolean indicating whether to complete the current animation immediately.
        * @param clearQueue A Boolean indicating whether to remove queued animation as well.
        * @return this
        */
        stop: function stop(jumpToEnd, clearQueue) {
          var active = this.active;
          this.active = false;

          if (clearQueue) {
            this.clearQueue();
          }

          if (jumpToEnd && this.situation) {

            !active && this.startCurrent();
            this.atEnd();
          }

          this.stopAnimFrame();
          return this.clearCurrent();
        },
        after: function after(fn) {
          var c = this.last(),
              wrapper = function wrapper(e) {
            if (e.detail.situation == c) {
              fn.call(this, c);
              this.off('finished.fx', wrapper);
            }
          };

          this.target().on('finished.fx', wrapper);
          return this._callStart();
        },

        during: function during(fn) {
          var c = this.last(),
              wrapper = function wrapper(e) {
            if (e.detail.situation == c) {
              fn.call(this, e.detail.pos, SVG.morph(e.detail.pos), e.detail.eased, c);
            }
          };


          this.target().off('during.fx', wrapper).on('during.fx', wrapper);
          this.after(function () {
            this.off('during.fx', wrapper);
          });
          return this._callStart();
        },

        afterAll: function afterAll(fn) {
          var wrapper = function wrapper(e) {
            fn.call(this);
            this.off('allfinished.fx', wrapper);
          };


          this.target().off('allfinished.fx', wrapper).on('allfinished.fx', wrapper);
          return this._callStart();
        },
        last: function last() {
          return this.situations.length ? this.situations[this.situations.length - 1] : this.situation;
        },

        add: function add(method, args, type) {
          this.last()[type || 'animations'][method] = args;
          return this._callStart();
        },

        /** perform one step of the animation
        *  @param ignoreTime Boolean indicating whether to ignore time and use position directly or recalculate position based on time
        *  @return this
        */
        step: function step(ignoreTime) {

          if (!ignoreTime) this.absPos = this.timeToAbsPos(+new Date());

          if (this.situation.loops !== false) {
            var absPos, absPosInt, lastLoop;

            absPos = Math.max(this.absPos, 0);
            absPosInt = Math.floor(absPos);

            if (this.situation.loops === true || absPosInt < this.situation.loops) {
              this.pos = absPos - absPosInt;
              lastLoop = this.situation.loop;
              this.situation.loop = absPosInt;
            } else {
              this.absPos = this.situation.loops;
              this.pos = 1;

              lastLoop = this.situation.loop - 1;
              this.situation.loop = this.situation.loops;
            }

            if (this.situation.reversing) {

              this.situation.reversed = this.situation.reversed != Boolean((this.situation.loop - lastLoop) % 2);
            }
          } else {

            this.absPos = Math.min(this.absPos, 1);
            this.pos = this.absPos;
          }


          if (this.pos < 0) this.pos = 0;
          if (this.situation.reversed) this.pos = 1 - this.pos;

          var eased = this.situation.ease(this.pos);
