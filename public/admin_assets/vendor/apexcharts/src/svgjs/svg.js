/*!
* svg.js - A lightweight library for manipulating and animating SVG.
* @version 2.6.6
* https://svgdotjs.github.io/
*/;
(function (root, factory) {
  /* istanbul ignore next */
  if (typeof define === 'function' && define.amd) {
    define(function () {
      return factory(root, root.document)
    })
    /* below check fixes #412 */
  } else if (typeof exports === 'object' && typeof module !== 'undefined') {
    module.exports = root.document ? factory(root, root.document) : function (w) { return factory(w, w.document) }
  } else {
    root.SVG = factory(root, root.document)
  }
}(typeof window !== 'undefined' ? window : this, function (window, document) {
  var globalRef = (typeof this !== 'undefined') ? this : window
  var SVG = globalRef.SVG = function (element) {
    if (SVG.supported) {
      element = new SVG.Doc(element)

      if (!SVG.parser.draw) { SVG.prepare() }

      return element
    }
  }
  SVG.ns = 'http://www.w3.org/2000/svg'
  SVG.xmlns = 'http://www.w3.org/2000/xmlns/'
  SVG.xlink = 'http://www.w3.org/1999/xlink'
  SVG.svgjs = 'http://svgjs.dev'
  SVG.supported = (function () {
    return true
  })()
  if (!SVG.supported) return false
  SVG.did = 1000
  SVG.eid = function (name) {
    return 'Svgjs' + capitalize(name) + (SVG.did++)
  }
  SVG.create = function (name) {

    var element = document.createElementNS(this.ns, name)
    element.setAttribute('id', this.eid(name))

    return element
  }
  SVG.extend = function () {
    var modules, methods
    modules = [].slice.call(arguments)
    methods = modules.pop()

    for (var i = modules.length - 1; i >= 0; i--) {
      if (modules[i]) {
        for (var key in methods) { modules[i].prototype[key] = methods[key] }
      }
    }
    if (SVG.Set && SVG.Set.inherit) { SVG.Set.inherit() }
  }
  SVG.invent = function (config) {

    var initializer = typeof config.create === 'function'
      ? config.create
      : function () {
        this.constructor.call(this, SVG.create(config.create))
      }
    if (config.inherit) { initializer.prototype = new config.inherit() }
    if (config.extend) { SVG.extend(initializer, config.extend) }
    if (config.construct) { SVG.extend(config.parent || SVG.Container, config.construct) }

    return initializer
  }
  SVG.adopt = function (node) {

    if (!node) return null
    if (node.instance) return node.instance
    var element
    if (node.nodeName == 'svg') { element = node.parentNode instanceof window.SVGElement ? new SVG.Nested() : new SVG.Doc() } else if (node.nodeName == 'linearGradient') { element = new SVG.Gradient('linear') } else if (node.nodeName == 'radialGradient') { element = new SVG.Gradient('radial') } else if (SVG[capitalize(node.nodeName)]) { element = new SVG[capitalize(node.nodeName)]() } else { element = new SVG.Element(node) }
    element.type = node.nodeName
    element.node = node
    node.instance = element
    if (element instanceof SVG.Doc) { element.namespace().defs() }
    element.setData(JSON.parse(node.getAttribute('svgjs:data')) || {})

    return element
  }
  SVG.prepare = function () {

    var body = document.getElementsByTagName('body')[0],
      draw = (body ? new SVG.Doc(body) : SVG.adopt(document.documentElement).nested()).size(2, 0)
    SVG.parser = {
      body: body || document.documentElement,
      draw: draw.style('opacity:0;position:absolute;left:-100%;top:-100%;overflow:hidden').node,
      poly: draw.polyline().node,
      path: draw.path().node,
      native: SVG.create('svg')
    }
  }

  SVG.parser = {
    native: SVG.create('svg')
  }

  document.addEventListener('DOMContentLoaded', function () {
    if (!SVG.parser.draw) { SVG.prepare() }
  }, false)
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
  }

  SVG.utils = {

    map: function (array, block) {
      var il = array.length,
        result = []

      for (var i = 0; i < il; i++) { result.push(block(array[i])) }

      return result
    },
    filter: function (array, block) {
      var il = array.length,
        result = []

      for (var i = 0; i < il; i++) {
        if (block(array[i])) { result.push(array[i]) }
      }

      return result
    },

    filterSVGElements: function (nodes) {
      return this.filter(nodes, function (el) { return el instanceof window.SVGElement })
    }

  }

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

  }

  SVG.Color = function (color) {
    var match
    this.r = 0
    this.g = 0
    this.b = 0

    if (!color) return
    if (typeof color === 'string') {
      if (SVG.regex.isRgb.test(color)) {

        match = SVG.regex.rgb.exec(color.replace(SVG.regex.whitespace, ''))
        this.r = parseInt(match[1])
        this.g = parseInt(match[2])
        this.b = parseInt(match[3])
      } else if (SVG.regex.isHex.test(color)) {

        match = SVG.regex.hex.exec(fullHex(color))
        this.r = parseInt(match[1], 16)
        this.g = parseInt(match[2], 16)
        this.b = parseInt(match[3], 16)
      }
    } else if (typeof color === 'object') {
      this.r = color.r
      this.g = color.g
      this.b = color.b
    }
  }

  SVG.extend(SVG.Color, {

    toString: function () {
      return this.toHex()
    },

    toHex: function () {
      return '#' +
        compToHex(this.r) +
        compToHex(this.g) +
        compToHex(this.b)
    },

    toRgb: function () {
      return 'rgb(' + [this.r, this.g, this.b].join() + ')'
    },

    brightness: function () {
      return (this.r / 255 * 0.30) +
        (this.g / 255 * 0.59) +
        (this.b / 255 * 0.11)
    },

    morph: function (color) {
      this.destination = new SVG.Color(color)

      return this
    },

    at: function (pos) {

      if (!this.destination) return this
      pos = pos < 0 ? 0 : pos > 1 ? 1 : pos
      return new SVG.Color({
        r: ~~(this.r + (this.destination.r - this.r) * pos),
        g: ~~(this.g + (this.destination.g - this.g) * pos),
        b: ~~(this.b + (this.destination.b - this.b) * pos)
      })
    }

  })
  SVG.Color.test = function (color) {
    color += ''
    return SVG.regex.isHex.test(color) ||
      SVG.regex.isRgb.test(color)
  }
  SVG.Color.isRgb = function (color) {
    return color && typeof color.r === 'number' &&
      typeof color.g === 'number' &&
      typeof color.b === 'number'
  }
  SVG.Color.isColor = function (color) {
    return SVG.Color.isRgb(color) || SVG.Color.test(color)
  }

  SVG.Array = function (array, fallback) {
    array = (array || []).valueOf()
    if (array.length == 0 && fallback) { array = fallback.valueOf() }
    this.value = this.parse(array)
  }

  SVG.extend(SVG.Array, {
    toString: function () {
      return this.value.join(' ')
    },

    valueOf: function () {
      return this.value
    },

    parse: function (array) {
      array = array.valueOf()
      if (Array.isArray(array)) return array

      return this.split(array)
    },

  })

  SVG.PointArray = function (array, fallback) {
    SVG.Array.call(this, array, fallback || [[0, 0]])
  }
  SVG.PointArray.prototype = new SVG.Array()
  SVG.PointArray.prototype.constructor = SVG.PointArray
  var pathHandlers = {
    M: function (c, p, p0) {
      p.x = p0.x = c[0]
      p.y = p0.y = c[1]

      return ['M', p.x, p.y]
    },
    L: function (c, p) {
      p.x = c[0]
      p.y = c[1]
      return ['L', c[0], c[1]]
    },
    H: function (c, p) {
      p.x = c[0]
      return ['H', c[0]]
    },
    V: function (c, p) {
      p.y = c[0]
      return ['V', c[0]]
    },
    C: function (c, p) {
      p.x = c[4]
      p.y = c[5]
      return ['C', c[0], c[1], c[2], c[3], c[4], c[5]]
    },
    Q: function (c, p) {
      p.x = c[2]
      p.y = c[3]
      return ['Q', c[0], c[1], c[2], c[3]]
    },
    Z: function (c, p, p0) {
      p.x = p0.x
      p.y = p0.y
      return ['Z']
    },
  }

  var mlhvqtcsa = 'mlhvqtcsaz'.split('')

  for (var i = 0, il = mlhvqtcsa.length; i < il; ++i) {
    pathHandlers[mlhvqtcsa[i]] = (function (i) {
      return function (c, p, p0) {
        if (i == 'H') c[0] = c[0] + p.x
        else if (i == 'V') c[0] = c[0] + p.y
        else if (i == 'A') {
          c[5] = c[5] + p.x,
            c[6] = c[6] + p.y
        } else {
          for (var j = 0, jl = c.length; j < jl; ++j) {
            c[j] = c[j] + (j % 2 ? p.y : p.x)
          }
        }

        if (pathHandlers && typeof pathHandlers[i] === 'function') {

          return pathHandlers[i](c, p, p0)
        }
      }
    })(mlhvqtcsa[i].toUpperCase())
  }
  SVG.PathArray = function (array, fallback) {
    SVG.Array.call(this, array, fallback || [['M', 0, 0]])
  }
  SVG.PathArray.prototype = new SVG.Array()
  SVG.PathArray.prototype.constructor = SVG.PathArray

  SVG.extend(SVG.PathArray, {

    toString: function () {
      return arrayToString(this.value)
    },

    move: function (x, y) {

      var box = this.bbox()
      x -= box.x
      y -= box.y

      return this
    },

    at: function (pos) {

      if (!this.destination) return this

      var sourceArray = this.value,
        destinationArray = this.destination.value,
        array = [], pathArray = new SVG.PathArray(),
        il, jl
      for (var i = 0, il = sourceArray.length; i < il; i++) {
        array[i] = [sourceArray[i][0]]
        for (var j = 1, jl = sourceArray[i].length; j < jl; j++) {
          array[i][j] = sourceArray[i][j] + (destinationArray[i][j] - sourceArray[i][j]) * pos
        }
        if (array[i][0] === 'A') {
          array[i][4] = +(array[i][4] != 0)
          array[i][5] = +(array[i][5] != 0)
        }
      }
      pathArray.value = array
      return pathArray
    },

    parse: function (array) {

      if (array instanceof SVG.PathArray) return array.valueOf()
      var i, x0, y0, s, seg, arr,
        x = 0,
        y = 0,
        paramCnt = { 'M': 2, 'L': 2, 'H': 1, 'V': 1, 'C': 6, 'S': 4, 'Q': 4, 'T': 2, 'A': 7, 'Z': 0 }

      if (typeof array === 'string') {
        array = array
          .replace(SVG.regex.numbersWithDots, pathRegReplace)
          .replace(SVG.regex.pathLetters, ' $& ')
          .replace(SVG.regex.hyphen, '$1 -')
          .trim()
          .split(SVG.regex.delimiter)
      } else {
        array = array.reduce(function (prev, curr) {
          return [].concat.call(prev, curr)
        }, [])
      }
      var arr = [],
        p = new SVG.Point(),
        p0 = new SVG.Point(),
        index = 0,
        len = array.length

      do {

        if (SVG.regex.isPathLetter.test(array[index])) {
          s = array[index]
          ++index

        } else if (s == 'M') {
          s = 'L'
        } else if (s == 'm') {
          s = 'l'
        }

        arr.push(pathHandlers[s].call(null,
          array.slice(index, (index = index + paramCnt[s.toUpperCase()])).map(parseFloat),
          p, p0
        )
        )
      } while (len > index)

      return arr
    },

    bbox: function () {
      if (!SVG.parser.draw) { SVG.prepare() }
      SVG.parser.path.setAttribute('d', this.toString())

      return SVG.parser.path.getBBox()
    }

  })
  SVG.Number = SVG.invent({

    create: function (value, unit) {

      this.value = 0
      this.unit = unit || ''
      if (typeof value === 'number') {

        this.value = isNaN(value) ? 0 : !isFinite(value) ? (value < 0 ? -3.4e+38 : +3.4e+38) : value
      } else if (typeof value === 'string') {
        unit = value.match(SVG.regex.numberAndUnit)

        if (unit) {

          this.value = parseFloat(unit[1])
          if (unit[5] == '%') { this.value /= 100 } else if (unit[5] == 's') { this.value *= 1000 }
          this.unit = unit[5]
        }
      } else {
        if (value instanceof SVG.Number) {
          this.value = value.valueOf()
          this.unit = value.unit
        }
      }
    },

    extend: {

      toString: function () {
        return (
          this.unit == '%'
            ? ~~(this.value * 1e8) / 1e6
            : this.unit == 's'
              ? this.value / 1e3
              : this.value
        ) + this.unit
      },
      toJSON: function () {
        return this.toString()
      },
      valueOf: function () {
        return this.value
      },

      plus: function (number) {
        number = new SVG.Number(number)
        return new SVG.Number(this + number, this.unit || number.unit)
      },

      minus: function (number) {
        number = new SVG.Number(number)
        return new SVG.Number(this - number, this.unit || number.unit)
      },

      times: function (number) {
        number = new SVG.Number(number)
        return new SVG.Number(this * number, this.unit || number.unit)
      },

      divide: function (number) {
        number = new SVG.Number(number)
        return new SVG.Number(this / number, this.unit || number.unit)
      },

      to: function (unit) {
        var number = new SVG.Number(this)

        if (typeof unit === 'string') { number.unit = unit }

        return number
      },

      morph: function (number) {
        this.destination = new SVG.Number(number)

        if (number.relative) {
          this.destination.value += this.value
        }

        return this
      },

      at: function (pos) {

        if (!this.destination) return this
        return new SVG.Number(this.destination)
          .minus(this)
          .times(pos)
          .plus(this)
      }

    }
  })

  SVG.Element = SVG.invent({

    create: function (node) {

      this._stroke = SVG.defaults.attrs.stroke
      this._event = null
      this.dom = {}
      if (this.node = node) {
        this.type = node.nodeName
        this.node.instance = this
        this._stroke = node.getAttribute('stroke') || this._stroke
      }
    },
    extend: {

      x: function (x) {
        return this.attr('x', x)
      },

      y: function (y) {
        return this.attr('y', y)
      },

      cx: function (x) {
        return x == null ? this.x() + this.width() / 2 : this.x(x - this.width() / 2)
      },

      cy: function (y) {
        return y == null ? this.y() + this.height() / 2 : this.y(y - this.height() / 2)
      },

      move: function (x, y) {
        return this.x(x).y(y)
      },

      center: function (x, y) {
        return this.cx(x).cy(y)
      },

      width: function (width) {
        return this.attr('width', width)
      },

      height: function (height) {
        return this.attr('height', height)
      },

      size: function (width, height) {
        var p = proportionalSize(this, width, height)

        return this
          .width(new SVG.Number(p.width))
          .height(new SVG.Number(p.height))
      },

      clone: function (parent) {

        this.writeDataToDom()
        var clone = assignNewId(this.node.cloneNode(true))
        if (parent) parent.add(clone)
        else this.after(clone)

        return clone
      },

      remove: function () {
        if (this.parent()) { this.parent().removeElement(this) }

        return this
      },

      replace: function (element) {
        this.after(element).remove()

        return element
      },

      addTo: function (parent) {
        return parent.put(this)
      },

      putIn: function (parent) {
        return parent.add(this)
      },

      id: function (id) {
        return this.attr('id', id)
      },
      show: function () {
        return this.style('display', '')
      },

      hide: function () {
        return this.style('display', 'none')
      },

      visible: function () {
        return this.style('display') != 'none'
      },

      toString: function () {
        return this.attr('id')
      },

      classes: function () {
        var attr = this.attr('class')

        return attr == null ? [] : attr.trim().split(SVG.regex.delimiter)
      },

      hasClass: function (name) {
        return this.classes().indexOf(name) != -1
      },

      addClass: function (name) {
        if (!this.hasClass(name)) {
          var array = this.classes()
          array.push(name)
          this.attr('class', array.join(' '))
        }

        return this
      },

      removeClass: function (name) {
        if (this.hasClass(name)) {
          this.attr('class', this.classes().filter(function (c) {
            return c != name
          }).join(' '))
        }

        return this
      },

      toggleClass: function (name) {
        return this.hasClass(name) ? this.removeClass(name) : this.addClass(name)
      },

      reference: function (attr) {
        return SVG.get(this.attr(attr))
      },

      parent: function (type) {
        var parent = this
        if (!parent.node.parentNode) return null
        parent = SVG.adopt(parent.node.parentNode)

        if (!type) return parent
        while (parent && parent.node instanceof window.SVGElement) {
          if (typeof type === 'string' ? parent.matches(type) : parent instanceof type) return parent
          if (!parent.node.parentNode || parent.node.parentNode.nodeName == '#document') return null
          parent = SVG.adopt(parent.node.parentNode)
        }
      },

      doc: function () {
        return this instanceof SVG.Doc ? this : this.parent(SVG.Doc)
      },

      parents: function (type) {
        var parents = [], parent = this

        do {
          parent = parent.parent(type)
          if (!parent || !parent.node) break

          parents.push(parent)
        } while (parent.parent)

        return parents
      },

      matches: function (selector) {
        return matches(this.node, selector)
      },

      native: function () {
        return this.node
      },

      svg: function (svg) {

        var well = document.createElement('svg')
        if (svg && this instanceof SVG.Parent) {

          well.innerHTML = '<svg>' + svg.replace(/\n/, '').replace(/<([\w:-]+)([^<]+?)\/>/g, '<$1$2></$1>') + '</svg>'
          for (var i = 0, il = well.firstChild.childNodes.length; i < il; i++) { this.node.appendChild(well.firstChild.firstChild) }
        } else {

          well.appendChild(svg = document.createElement('svg'))
          this.writeDataToDom()
          svg.appendChild(this.node.cloneNode(true))
          return well.innerHTML.replace(/^<svg>/, '').replace(/<\/svg>$/, '')
        }

        return this
      },
      writeDataToDom: function () {

        if (this.each || this.lines) {
          var fn = this.each ? this : this.lines()
          fn.each(function () {
            this.writeDataToDom()
          })
        }
        this.node.removeAttribute('svgjs:data')

        if (Object.keys(this.dom).length) { this.node.setAttribute('svgjs:data', JSON.stringify(this.dom)) }

        return this
      },

      setData: function (o) {
        this.dom = o
        return this
      },
      is: function (obj) {
        return is(this, obj)
      }
    }
  })

  SVG.easing = {
    '-': function (pos) { return pos },
    '<>': function (pos) { return -Math.cos(pos * Math.PI) / 2 + 0.5 },
    '>': function (pos) { return Math.sin(pos * Math.PI / 2) },
    '<': function (pos) { return -Math.cos(pos * Math.PI / 2) + 1 }
  }

  SVG.morph = function (pos) {
    return function (from, to) {
      return new SVG.MorphObj(from, to).at(pos)
    }
  }

  SVG.Situation = SVG.invent({

    create: function (o) {
      this.init = false
      this.reversed = false
      this.reversing = false

      this.duration = new SVG.Number(o.duration).valueOf()
      this.delay = new SVG.Number(o.delay).valueOf()

      this.start = +new Date() + this.delay
      this.finish = this.start + this.duration
      this.ease = o.ease
      this.loop = 0
      this.loops = false

      this.animations = {
      }

      this.attrs = {
      }

      this.styles = {
      }

      this.transforms = [
      ]

      this.once = {
      }
    }

  })

  SVG.FX = SVG.invent({

    create: function (element) {
      this._target = element
      this.situations = []
      this.active = false
      this.situation = null
      this.paused = false
      this.lastPos = 0
      this.pos = 0
      this.absPos = 0
      this._speed = 1
    },

    extend: {

      /**
       * sets or returns the target of this animation
       * @param o object || number In case of Object it holds all parameters. In case of number its the duration of the animation
       * @param ease function || string Function which should be used for easing or easing keyword
       * @param delay Number indicating the delay before the animation starts
       * @return target || this
       */
      animate: function (o, ease, delay) {
        if (typeof o === 'object') {
          ease = o.ease
          delay = o.delay
          o = o.duration
        }

        var situation = new SVG.Situation({
          duration: o || 1000,
          delay: delay || 0,
          ease: SVG.easing[ease || '-'] || ease
        })

        this.queue(situation)

        return this
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
      target: function (target) {
        if (target && target instanceof SVG.Element) {
          this._target = target
          return this
        }

        return this._target
      },
      timeToAbsPos: function (timestamp) {
        return (timestamp - this.situation.start) / (this.situation.duration / this._speed)
      },
      absPosToTime: function (absPos) {
        return this.situation.duration / this._speed * absPos + this.situation.start
      },
      startAnimFrame: function () {
        this.stopAnimFrame()
        this.animationFrame = window.requestAnimationFrame(function () { this.step() }.bind(this))
      },
      stopAnimFrame: function () {
        window.cancelAnimationFrame(this.animationFrame)
      },
      start: function () {

        if (!this.active && this.situation) {
          this.active = true
          this.startCurrent()
        }

        return this
      },
      startCurrent: function () {
        this.situation.start = +new Date() + this.situation.delay / this._speed
        this.situation.finish = this.situation.start + this.situation.duration / this._speed
        return this.initAnimations().step()
      },

      /**
     * adds a function / Situation to the animation queue
     * @param fn function / situation to add
     * @return this
     */
      queue: function (fn) {
        if (typeof fn === 'function' || fn instanceof SVG.Situation) { this.situations.push(fn) }

        if (!this.situation) this.situation = this.situations.shift()

        return this
      },

      /**
     * pulls next element from the queue and execute it
     * @return this
     */
      dequeue: function () {

        this.stop()
        this.situation = this.situations.shift()

        if (this.situation) {
          if (this.situation instanceof SVG.Situation) {
            this.start()
          } else {

            this.situation.call(this)
          }
        }

        return this
      },
      initAnimations: function () {
        var source
        var s = this.situation

        if (s.init) return this

        for (var i in s.animations) {
          source = this.target()[i]()

          if (!Array.isArray(source)) {
            source = [source]
          }

          if (!Array.isArray(s.animations[i])) {
            s.animations[i] = [s.animations[i]]
          }
          for (var j = source.length; j--;) {
            if (s.animations[i][j] instanceof SVG.Number) { source[j] = new SVG.Number(source[j]) }

            s.animations[i][j] = source[j].morph(s.animations[i][j])
          }
        }

        for (var i in s.attrs) {
          s.attrs[i] = new SVG.MorphObj(this.target().attr(i), s.attrs[i])
        }

        for (var i in s.styles) {
          s.styles[i] = new SVG.MorphObj(this.target().style(i), s.styles[i])
        }

        s.initialTransformation = this.target().matrixify()

        s.init = true
        return this
      },
      clearQueue: function () {
        this.situations = []
        return this
      },
      clearCurrent: function () {
        this.situation = null
        return this
      },
      /** stops the animation immediately
     * @param jumpToEnd A Boolean indicating whether to complete the current animation immediately.
     * @param clearQueue A Boolean indicating whether to remove queued animation as well.
     * @return this
     */
      stop: function (jumpToEnd, clearQueue) {
        var active = this.active
        this.active = false

        if (clearQueue) {
          this.clearQueue()
        }

        if (jumpToEnd && this.situation) {

          !active && this.startCurrent()
          this.atEnd()
        }

        this.stopAnimFrame()

        return this.clearCurrent()
      },
      after: function (fn) {
        var c = this.last(),
          wrapper = function wrapper(e) {
            if (e.detail.situation == c) {
              fn.call(this, c)
              this.off('finished.fx', wrapper)
            }
          }

        this.target().on('finished.fx', wrapper)

        return this._callStart()
      },

      during: function (fn) {
        var c = this.last(),
          wrapper = function (e) {
            if (e.detail.situation == c) {
              fn.call(this, e.detail.pos, SVG.morph(e.detail.pos), e.detail.eased, c)
            }
          }
        this.target().off('during.fx', wrapper).on('during.fx', wrapper)

        this.after(function () {
          this.off('during.fx', wrapper)
        })

        return this._callStart()
      },
      afterAll: function (fn) {
        var wrapper = function wrapper(e) {
          fn.call(this)
          this.off('allfinished.fx', wrapper)
        }
        this.target().off('allfinished.fx', wrapper).on('allfinished.fx', wrapper)

        return this._callStart()
      },
      last: function () {
        return this.situations.length ? this.situations[this.situations.length - 1] : this.situation
      },
      add: function (method, args, type) {
        this.last()[type || 'animations'][method] = args
        return this._callStart()
      },

      /** perform one step of the animation
     *  @param ignoreTime Boolean indicating whether to ignore time and use position directly or recalculate position based on time
     *  @return this
     */
      step: function (ignoreTime) {

        if (!ignoreTime) this.absPos = this.timeToAbsPos(+new Date())
        if (this.situation.loops !== false) {
          var absPos, absPosInt, lastLoop
          absPos = Math.max(this.absPos, 0)
          absPosInt = Math.floor(absPos)

          if (this.situation.loops === true || absPosInt < this.situation.loops) {
            this.pos = absPos - absPosInt
            lastLoop = this.situation.loop
            this.situation.loop = absPosInt
          } else {
            this.absPos = this.situation.loops
            this.pos = 1

            lastLoop = this.situation.loop - 1
            this.situation.loop = this.situation.loops
          }

          if (this.situation.reversing) {

            this.situation.reversed = this.situation.reversed != Boolean((this.situation.loop - lastLoop) % 2)
          }
        } else {

          this.absPos = Math.min(this.absPos, 1)
          this.pos = this.absPos
        }
        if (this.pos < 0) this.pos = 0

        if (this.situation.reversed) this.pos = 1 - this.pos
        var eased = this.situation.ease(this.pos)
        for (var i in this.situation.once) {
          if (i > this.lastPos && i <= eased) {
            this.situation.once[i].call(this.target(), this.pos, eased)
            delete this.situation.once[i]
          }
        }
        if (this.active) this.target().fire('during', { pos: this.pos, eased: eased, fx: this, situation: this.situation })
        if (!this.situation) {
          return this
        }
        this.eachAt()
        if ((this.pos == 1 && !this.situation.reversed) || (this.situation.reversed && this.pos == 0)) {

          this.stopAnimFrame()
          this.target().fire('finished', { fx: this, situation: this.situation })

          if (!this.situations.length) {
            this.target().fire('allfinished')
            if (!this.situations.length) {
              this.target().off('.fx')
              this.active = false
            }
          }
          if (this.active) this.dequeue()
          else this.clearCurrent()
        } else if (!this.paused && this.active) {

          this.startAnimFrame()
        }
        this.lastPos = eased
        return this
      },
      eachAt: function () {
        var len, at, self = this, target = this.target(), s = this.situation
        for (var i in s.animations) {
          at = [].concat(s.animations[i]).map(function (el) {
            return typeof el !== 'string' && el.at ? el.at(s.ease(self.pos), self.pos) : el
          })

          target[i].apply(target, at)
        }
        for (var i in s.attrs) {
          at = [i].concat(s.attrs[i]).map(function (el) {
            return typeof el !== 'string' && el.at ? el.at(s.ease(self.pos), self.pos) : el
          })

          target.attr.apply(target, at)
        }
        for (var i in s.styles) {
          at = [i].concat(s.styles[i]).map(function (el) {
            return typeof el !== 'string' && el.at ? el.at(s.ease(self.pos), self.pos) : el
          })

          target.style.apply(target, at)
        }
        if (s.transforms.length) {

          at = s.initialTransformation
          for (var i = 0, len = s.transforms.length; i < len; i++) {

            var a = s.transforms[i]
            if (a instanceof SVG.Matrix) {
              if (a.relative) {
                at = at.multiply(new SVG.Matrix().morph(a).at(s.ease(this.pos)))
              } else {
                at = at.morph(a).at(s.ease(this.pos))
              }
              continue
            }
            if (!a.relative) { a.undo(at.extract()) }
            at = at.multiply(a.at(s.ease(this.pos)))
          }
          target.matrix(at)
        }

        return this
      },
      once: function (pos, fn, isEased) {
        var c = this.last()
        if (!isEased) pos = c.ease(pos)

        c.once[pos] = fn

        return this
      },

      _callStart: function () {
        setTimeout(function () { this.start() }.bind(this), 0)
        return this
      }

    },

    parent: SVG.Element,
    construct: {

      animate: function (o, ease, delay) {
        return (this.fx || (this.fx = new SVG.FX(this))).animate(o, ease, delay)
      },
      delay: function (delay) {
        return (this.fx || (this.fx = new SVG.FX(this))).delay(delay)
      },
      stop: function (jumpToEnd, clearQueue) {
        if (this.fx) { this.fx.stop(jumpToEnd, clearQueue) }

        return this
      },
      finish: function () {
        if (this.fx) { this.fx.finish() }

        return this
      },

    }

  })
  SVG.MorphObj = SVG.invent({

    create: function (from, to) {

      if (SVG.Color.isColor(to)) return new SVG.Color(from).morph(to)

      if (SVG.regex.delimiter.test(from)) {

        if (SVG.regex.pathLetters.test(from)) return new SVG.PathArray(from).morph(to)

        else return new SVG.Array(from).morph(to)
      }

      if (SVG.regex.numberAndUnit.test(to)) return new SVG.Number(from).morph(to)
      this.value = from
      this.destination = to
    },

    extend: {
      at: function (pos, real) {
        return real < 1 ? this.value : this.destination
      },

      valueOf: function () {
        return this.value
      }
    }

  })

  SVG.extend(SVG.FX, {

    attr: function (a, v, relative) {

      if (typeof a === 'object') {
        for (var key in a) { this.attr(key, a[key]) }
      } else {
        this.add(a, v, 'attrs')
      }

      return this
    },

    plot: function (a, b, c, d) {

      if (arguments.length == 4) {
        return this.plot([a, b, c, d])
      }

      return this.add('plot', new (this.target().morphArray)(a))
    },
  })

  SVG.Box = SVG.invent({
    create: function (x, y, width, height) {
      if (typeof x === 'object' && !(x instanceof SVG.Element)) {

        return SVG.Box.call(this, x.left != null ? x.left : x.x, x.top != null ? x.top : x.y, x.width, x.height)
      } else if (arguments.length == 4) {
        this.x = x
        this.y = y
        this.width = width
        this.height = height
      }
      fullBox(this)
    }
  })

  SVG.BBox = SVG.invent({

    create: function (element) {
      SVG.Box.apply(this, [].slice.call(arguments))
      if (element instanceof SVG.Element) {
        var box
        try {
          if (!document.documentElement.contains) {

            var topParent = element.node
            while (topParent.parentNode) {
              topParent = topParent.parentNode
            }
            if (topParent != document) throw new Error('Element not in the dom')
          } else {
          }
          box = element.node.getBBox()
        } catch (e) {
          if (element instanceof SVG.Shape) {
            if (!SVG.parser.draw) {

              SVG.prepare()
            }
            var clone = element.clone(SVG.parser.draw.instance).show()

            if (clone && clone.node && typeof clone.node.getBBox === 'function') {

              box = clone.node.getBBox()
            }
            if (clone && typeof clone.remove === 'function') {
              clone.remove()
            }
          } else {
            box = {
              x: element.node.clientLeft,
              y: element.node.clientTop,
              width: element.node.clientWidth,
              height: element.node.clientHeight
            }
          }
        }

        SVG.Box.call(this, box)
      }
    },
    inherit: SVG.Box,
    parent: SVG.Element,
    construct: {

      bbox: function () {
        return new SVG.BBox(this)
      }
    }

  })

  SVG.BBox.prototype.constructor = SVG.BBox
  SVG.Matrix = SVG.invent({

    create: function (source) {
      var base = arrayToMatrix([1, 0, 0, 1, 0, 0])
      source = source === null ? base : source instanceof SVG.Element
        ? source.matrixify()
        : typeof source === 'string'
          ? arrayToMatrix(source.split(SVG.regex.delimiter).map(parseFloat))
          : arguments.length == 6
            ? arrayToMatrix([].slice.call(arguments))
            : Array.isArray(source)
              ? arrayToMatrix(source)
              : source && typeof source === 'object'
                ? source : base
      for (var i = abcdef.length - 1; i >= 0; --i) {
        this[abcdef[i]] = source[abcdef[i]] != null
          ? source[abcdef[i]] : base[abcdef[i]]
      }
    },
    extend: {

      extract: function () {

        var px = deltaTransformPoint(this, 0, 1),
          py = deltaTransformPoint(this, 1, 0),
          skewX = 180 / Math.PI * Math.atan2(px.y, px.x) - 90

        return {

          x: this.e,
          y: this.f,
          transformedX: (this.e * Math.cos(skewX * Math.PI / 180) + this.f * Math.sin(skewX * Math.PI / 180)) / Math.sqrt(this.a * this.a + this.b * this.b),
          transformedY: (this.f * Math.cos(skewX * Math.PI / 180) + this.e * Math.sin(-skewX * Math.PI / 180)) / Math.sqrt(this.c * this.c + this.d * this.d),
          rotation: skewX,
          a: this.a,
          b: this.b,
          c: this.c,
          d: this.d,
          e: this.e,
          f: this.f,
          matrix: new SVG.Matrix(this)
        }
      },

      clone: function () {
        return new SVG.Matrix(this)
      },

      morph: function (matrix) {

        this.destination = new SVG.Matrix(matrix)

        return this
      },
      multiply: function (matrix) {
        return new SVG.Matrix(this.native().multiply(parseMatrix(matrix).native()))
      },

      inverse: function () {
        return new SVG.Matrix(this.native().inverse())
      },

      translate: function (x, y) {
        return new SVG.Matrix(this.native().translate(x || 0, y || 0))
      },
      native: function () {

        var matrix = SVG.parser.native.createSVGMatrix()
        for (var i = abcdef.length - 1; i >= 0; i--) { matrix[abcdef[i]] = this[abcdef[i]] }

        return matrix
      },

      toString: function () {

        return 'matrix(' + float32String(this.a) + ',' + float32String(this.b) +
          ',' + float32String(this.c) + ',' + float32String(this.d) +
          ',' + float32String(this.e) + ',' + float32String(this.f) +
          ')'
      }
    },
    parent: SVG.Element,
    construct: {

      ctm: function () {
        return new SVG.Matrix(this.node.getCTM())
      },

      screenCTM: function () {
        /* https://bugzilla.mozilla.org/show_bug.cgi?id=1344537
           This is needed because FF does not return the transformation matrix
           for the inner coordinate system when getScreenCTM() is called on nested svgs.
           However all other Browsers do that */
        if (this instanceof SVG.Nested) {
          var rect = this.rect(1, 1)
          var m = rect.node.getScreenCTM()
          rect.remove()
          return new SVG.Matrix(m)
        }
        return new SVG.Matrix(this.node.getScreenCTM())
      }

    }

  })

  SVG.Point = SVG.invent({

    create: function (x, y) {
      var i, source, base = { x: 0, y: 0 }
      source = Array.isArray(x)
        ? { x: x[0], y: x[1] }
        : typeof x === 'object'
          ? { x: x.x, y: x.y }
          : x != null
            ? { x: x, y: (y != null ? y : x) } : base
      this.x = source.x
      this.y = source.y
    },
    extend: {

      clone: function () {
        return new SVG.Point(this)
      },

      morph: function (x, y) {

        this.destination = new SVG.Point(x, y)

        return this
      },
    }

  })

  SVG.extend(SVG.Element, {
    point: function (x, y) {
      return new SVG.Point(x, y).transform(this.screenCTM().inverse())
    }

  })

  SVG.extend(SVG.Element, {

    attr: function (a, v, n) {

      if (a == null) {

        a = {}
        v = this.node.attributes
        for (var n = v.length - 1; n >= 0; n--) { a[v[n].nodeName] = SVG.regex.isNumber.test(v[n].nodeValue) ? parseFloat(v[n].nodeValue) : v[n].nodeValue }

        return a
      } else if (typeof a === 'object') {

        for (var v_ in a) this.attr(v_, a[v_])
      } else if (v === null) {

        this.node.removeAttribute(a)
      } else if (v == null) {

        v = this.node.getAttribute(a)
        return v == null
          ? SVG.defaults.attrs[a]
          : SVG.regex.isNumber.test(v)
            ? parseFloat(v) : v
      } else {

        if (a == 'stroke-width') { this.attr('stroke', parseFloat(v) > 0 ? this._stroke : null) } else if (a == 'stroke') { this._stroke = v }
        if (a == 'fill' || a == 'stroke') {
          if (SVG.regex.isImage.test(v)) { v = this.doc().defs().image(v, 0, 0) }

          if (v instanceof SVG.Image) {
            v = this.doc().defs().pattern(0, 0, function () {
              this.add(v)
            })
          }
        }
        if (typeof v === 'number') { v = new SVG.Number(v) }
        else if (SVG.Color.isColor(v)) { v = new SVG.Color(v) }
        else if (Array.isArray(v)) { v = new SVG.Array(v) }
        if (a == 'leading') {

          if (this.leading) { this.leading(v) }
        } else {

          typeof n === 'string'
            ? this.node.setAttributeNS(n, a, v.toString())
            : this.node.setAttribute(a, v.toString())
        }
        if (this.rebuild && (a == 'font-size' || a == 'x')) { this.rebuild(a, v) }
      }

      return this
    }
  })

  SVG.extend(SVG.Element, {

    transform: function (o, relative) {

      var target = this,
        matrix, bbox
      if (typeof o !== 'object') {

        matrix = new SVG.Matrix(target).extract()

        return typeof o === 'string' ? matrix[o] : matrix
      }
      matrix = new SVG.Matrix(target)
      relative = !!relative || !!o.relative
      if (o.a != null) {
        matrix = relative

          ? matrix.multiply(new SVG.Matrix(o))

          : new SVG.Matrix(o)
      }

      return this.attr('transform', matrix)
    }
  })
  SVG.extend(SVG.Element, {

    untransform: function () {
      return this.attr('transform', null)
    },

    matrixify: function () {
      var matrix = (this.attr('transform') || '')

        .split(SVG.regex.transforms).slice(0, -1).map(function (str) {

          var kv = str.trim().split('(')
          return [kv[0], kv[1].split(SVG.regex.delimiter).map(function (str) { return parseFloat(str) })]
        })

        .reduce(function (matrix, transform) {
          if (transform[0] == 'matrix') return matrix.multiply(arrayToMatrix(transform[1]))
          return matrix[transform[0]].apply(matrix, transform[1])
        }, new SVG.Matrix())

      return matrix
    },

    toParent: function (parent) {
      if (this == parent) return this
      var ctm = this.screenCTM()
      var pCtm = parent.screenCTM().inverse()

      this.addTo(parent).untransform().transform(pCtm.multiply(ctm))

      return this
    },

    toDoc: function () {
      return this.toParent(this.doc())
    }

  })

  SVG.Transformation = SVG.invent({

    create: function (source, inversed) {
      if (arguments.length > 1 && typeof inversed !== 'boolean') {
        return this.constructor.call(this, [].slice.call(arguments))
      }

      if (Array.isArray(source)) {
        for (var i = 0, len = this.arguments.length; i < len; ++i) {
          this[this.arguments[i]] = source[i]
        }
      } else if (source && typeof source === 'object') {
        for (var i = 0, len = this.arguments.length; i < len; ++i) {
          this[this.arguments[i]] = source[this.arguments[i]]
        }
      }

      this.inversed = false

      if (inversed === true) {
        this.inversed = true
      }
    },

  })

  SVG.Translate = SVG.invent({

    parent: SVG.Matrix,
    inherit: SVG.Transformation,

    create: function (source, inversed) {
      this.constructor.apply(this, [].slice.call(arguments))
    },

    extend: {
      arguments: ['transformedX', 'transformedY'],
      method: 'translate'
    }

  })
  SVG.extend(SVG.Element, {

    style: function (s, v) {
      if (arguments.length == 0) {

        return this.node.style.cssText || ''
      } else if (arguments.length < 2) {

        if (typeof s === 'object') {
          for (var v_ in s) this.style(v_, s[v_])
        } else if (SVG.regex.isCss.test(s)) {

          s = s.split(/\s*;\s*/)

            .filter(function (e) { return !!e })
            .map(function (e) { return e.split(/\s*:\s*/) })
          while (v = s.pop()) {
            this.style(v[0], v[1])
          }
        } else {

          return this.node.style[camelCase(s)]
        }
      } else {
        this.node.style[camelCase(s)] = v === null || SVG.regex.isBlank.test(v) ? '' : v
      }

      return this
    }
  })
  SVG.Parent = SVG.invent({

    create: function (element) {
      this.constructor.call(this, element)
    },
    inherit: SVG.Element,
    extend: {

      children: function () {
        return SVG.utils.map(SVG.utils.filterSVGElements(this.node.childNodes), function (node) {
          return SVG.adopt(node)
        })
      },

      add: function (element, i) {
        if (i == null) { this.node.appendChild(element.node) } else if (element.node != this.node.childNodes[i]) { this.node.insertBefore(element.node, this.node.childNodes[i]) }

        return this
      },

      put: function (element, i) {
        this.add(element, i)
        return element
      },

      has: function (element) {
        return this.index(element) >= 0
      },

      index: function (element) {
        return [].slice.call(this.node.childNodes).indexOf(element.node)
      },

      get: function (i) {
        return SVG.adopt(this.node.childNodes[i])
      },

      first: function () {
        return this.get(0)
      },

      last: function () {
        return this.get(this.node.childNodes.length - 1)
      },

      each: function (block, deep) {
        var il,
          children = this.children()

        for (var i = 0, il = children.length; i < il; i++) {
          if (children[i] instanceof SVG.Element) { block.apply(children[i], [i, children]) }

          if (deep && (children[i] instanceof SVG.Container)) { children[i].each(block, deep) }
        }

        return this
      },

      removeElement: function (element) {
        this.node.removeChild(element.node)

        return this
      },

      clear: function () {

        while (this.node.hasChildNodes()) { this.node.removeChild(this.node.lastChild) }
        delete this._defs

        return this
      },
      defs: function () {
        return this.doc().defs()
      }
    }

  })

  SVG.extend(SVG.Parent, {

    ungroup: function (parent, depth) {
      if (depth === 0 || this instanceof SVG.Defs || this.node == SVG.parser.draw) return this

      parent = parent || (this instanceof SVG.Doc ? this : this.parent(SVG.Parent))
      depth = depth || Infinity

      this.each(function () {
        if (this instanceof SVG.Defs) return this
        if (this instanceof SVG.Parent) return this.ungroup(parent, depth - 1)
        return this.toParent(parent)
      })

      this.node.firstChild || this.remove()

      return this
    },

    flatten: function (parent, depth) {
      return this.ungroup(parent, depth)
    }

  })
  SVG.Container = SVG.invent({

    create: function (element) {
      this.constructor.call(this, element)
    },
    inherit: SVG.Parent

  })

  SVG.ViewBox = SVG.invent({
    parent: SVG.Container,
    construct: {

    }

  })

    ;['click',
      'dblclick',
      'mousedown',
      'mouseup',
      'mouseover',
      'mouseout',
      'mousemove',
      'touchstart',
      'touchmove',
      'touchleave',
      'touchend',
      'touchcancel'].forEach(function (event) {

        SVG.Element.prototype[event] = function (f) {

          SVG.on(this.node, event, f)
          return this
        }
      })
  SVG.listeners = []
  SVG.handlerMap = []
  SVG.listenerId = 0
  SVG.on = function (node, event, listener, binding, options) {

    var l = listener.bind(binding || node.instance || node),
      index = (SVG.handlerMap.indexOf(node) + 1 || SVG.handlerMap.push(node)) - 1,
      ev = event.split('.')[0],
      ns = event.split('.')[1] || '*'
    SVG.listeners[index] = SVG.listeners[index] || {}
    SVG.listeners[index][ev] = SVG.listeners[index][ev] || {}
    SVG.listeners[index][ev][ns] = SVG.listeners[index][ev][ns] || {}

    if (!listener._svgjsListenerId) { listener._svgjsListenerId = ++SVG.listenerId }
    SVG.listeners[index][ev][ns][listener._svgjsListenerId] = l
    node.addEventListener(ev, l, options || { passive: true })
  }
  SVG.off = function (node, event, listener) {
    var index = SVG.handlerMap.indexOf(node),
      ev = event && event.split('.')[0],
      ns = event && event.split('.')[1],
      namespace = ''

    if (index == -1) return

    if (listener) {
      if (typeof listener === 'function') listener = listener._svgjsListenerId
      if (!listener) return
      if (SVG.listeners[index][ev] && SVG.listeners[index][ev][ns || '*']) {

        node.removeEventListener(ev, SVG.listeners[index][ev][ns || '*'][listener], false)

        delete SVG.listeners[index][ev][ns || '*'][listener]
      }
    } else if (ns && ev) {

      if (SVG.listeners[index][ev] && SVG.listeners[index][ev][ns]) {
        for (var listener_ in SVG.listeners[index][ev][ns]) { SVG.off(node, [ev, ns].join('.'), listener_) }

        delete SVG.listeners[index][ev][ns]
      }
    } else if (ns) {

      for (var event_ in SVG.listeners[index]) {
        for (var namespace in SVG.listeners[index][event_]) {
          if (ns === namespace) {
            SVG.off(node, [event_, ns].join('.'))
          }
        }
      }
    } else if (ev) {

      if (SVG.listeners[index][ev]) {
        for (var namespace in SVG.listeners[index][ev]) { SVG.off(node, [ev, namespace].join('.')) }

        delete SVG.listeners[index][ev]
      }
    } else {

      for (var event_ in SVG.listeners[index]) { SVG.off(node, event_) }

      delete SVG.listeners[index]
      delete SVG.handlerMap[index]
    }
  }

  //
  SVG.extend(SVG.Element, {

    on: function (event, listener, binding, options) {
      SVG.on(this.node, event, listener, binding, options)

      return this
    },

    off: function (event, listener) {
      SVG.off(this.node, event, listener)

      return this
    },

    fire: function (event, data) {

      if (event instanceof window.Event) {
        this.node.dispatchEvent(event)
      } else {
        this.node.dispatchEvent(event = new SVG.CustomEvent(event, { detail: data, cancelable: true }))
      }

      this._event = event
      return this
    },
    event: function () {
      return this._event
    }
  })

  SVG.Defs = SVG.invent({

    create: 'defs',
    inherit: SVG.Container

  })
  SVG.G = SVG.invent({

    create: 'g',
    inherit: SVG.Container,
    extend: {

      x: function (x) {
        return x == null ? this.transform('x') : this.transform({ x: x - this.x() }, true)
      },
    },
    construct: {

      group: function () {
        return this.put(new SVG.G())
      }
    }
  })

  SVG.Doc = SVG.invent({

    create: function (element) {
      if (element) {

        element = typeof element === 'string'
          ? document.getElementById(element)
          : element
        if (element.nodeName == 'svg') {
          this.constructor.call(this, element)
        } else {
          this.constructor.call(this, SVG.create('svg'))
          element.appendChild(this.node)
          this.size('100%', '100%')
        }
        this.namespace().defs()
      }
    },
    inherit: SVG.Container,
    extend: {

      namespace: function () {
        return this
          .attr({ xmlns: SVG.ns, version: '1.1' })
          .attr('xmlns:xlink', SVG.xlink, SVG.xmlns)
          .attr('xmlns:svgjs', SVG.svgjs, SVG.xmlns)
      },

      defs: function () {
        if (!this._defs) {
          var defs
          if (defs = this.node.getElementsByTagName('defs')[0]) { this._defs = SVG.adopt(defs) } else { this._defs = new SVG.Defs() }
          this.node.appendChild(this._defs.node)
        }

        return this._defs
      },

      parent: function () {
        if (!this.node.parentNode || this.node.parentNode.nodeName == '#document') return null
        return this.node.parentNode
      },
      remove: function () {
        if (this.parent()) {
          this.parent().removeChild(this.node)
        }

        return this
      },
      clear: function () {

        while (this.node.hasChildNodes()) { this.node.removeChild(this.node.lastChild) }
        delete this._defs
        if (SVG.parser.draw && !SVG.parser.draw.parentNode) { this.node.appendChild(SVG.parser.draw) }

        return this
      },
      clone: function (parent) {

        this.writeDataToDom()
        var node = this.node
        var clone = assignNewId(node.cloneNode(true))
        if (parent) {
          (parent.node || parent).appendChild(clone.node)
        } else {
          node.parentNode.insertBefore(clone.node, node.nextSibling)
        }

        return clone
      }
    }

  })
  //
  SVG.extend(SVG.Element, {
  })
  SVG.Gradient = SVG.invent({

    create: function (type) {
      this.constructor.call(this, SVG.create(type + 'Gradient'))
      this.type = type
    },
    inherit: SVG.Container,
    extend: {

      at: function (offset, color, opacity) {
        return this.put(new SVG.Stop()).update(offset, color, opacity)
      },

      update: function (block) {

        this.clear()
        if (typeof block === 'function') { block.call(this, this) }

        return this
      },

      fill: function () {
        return 'url(#' + this.id() + ')'
      },

      toString: function () {
        return this.fill()
      },

      attr: function (a, b, c) {
        if (a == 'transform') a = 'gradientTransform'
        return SVG.Container.prototype.attr.call(this, a, b, c)
      }
    },
    construct: {

      gradient: function (type, block) {
        return this.defs().gradient(type, block)
      }
    }
  })
  SVG.extend(SVG.Gradient, SVG.FX, {

    from: function (x, y) {
      return (this._target || this).type == 'radial'
        ? this.attr({ fx: new SVG.Number(x), fy: new SVG.Number(y) })
        : this.attr({ x1: new SVG.Number(x), y1: new SVG.Number(y) })
    },

    to: function (x, y) {
      return (this._target || this).type == 'radial'
        ? this.attr({ cx: new SVG.Number(x), cy: new SVG.Number(y) })
        : this.attr({ x2: new SVG.Number(x), y2: new SVG.Number(y) })
    }
  })
  SVG.extend(SVG.Defs, {

    gradient: function (type, block) {
      return this.put(new SVG.Gradient(type)).update(block)
    }

  })

  SVG.Stop = SVG.invent({

    create: 'stop',
    inherit: SVG.Element,
    extend: {

      update: function (o) {
        if (typeof o === 'number' || o instanceof SVG.Number) {
          o = {
            offset: arguments[0],
            color: arguments[1],
            opacity: arguments[2]
          }
        }
        if (o.opacity != null) this.attr('stop-opacity', o.opacity)
        if (o.color != null) this.attr('stop-color', o.color)
        if (o.offset != null) this.attr('offset', new SVG.Number(o.offset))

        return this
      }
    }

  })

  SVG.Pattern = SVG.invent({

    create: 'pattern',
    inherit: SVG.Container,
    extend: {

      fill: function () {
        return 'url(#' + this.id() + ')'
      },

      update: function (block) {

        this.clear()
        if (typeof block === 'function') { block.call(this, this) }

        return this
      },

      toString: function () {
        return this.fill()
      },

      attr: function (a, b, c) {
        if (a == 'transform') a = 'patternTransform'
        return SVG.Container.prototype.attr.call(this, a, b, c)
      }

    },
    construct: {

      pattern: function (width, height, block) {
        return this.defs().pattern(width, height, block)
      }
    }
  })

  SVG.extend(SVG.Defs, {

    pattern: function (width, height, block) {
      return this.put(new SVG.Pattern()).update(block).attr({
        x: 0,
        y: 0,
        width: width,
        height: height,
        patternUnits: 'userSpaceOnUse'
      })
    }

  })
  SVG.Shape = SVG.invent({

    create: function (element) {
      this.constructor.call(this, element)
    },
    inherit: SVG.Element

  })

  SVG.Symbol = SVG.invent({

    create: 'symbol',
    inherit: SVG.Container,

    construct: {

      symbol: function () {
        return this.put(new SVG.Symbol())
      }
    }
  })

  SVG.Use = SVG.invent({

    create: 'use',
    inherit: SVG.Shape,
    extend: {

      element: function (element, file) {

        return this.attr('href', (file || '') + '#' + element, SVG.xlink)
      }
    },
    construct: {

      use: function (element, file) {
        return this.put(new SVG.Use()).element(element, file)
      }
    }
  })
  SVG.Rect = SVG.invent({

    create: 'rect',
    inherit: SVG.Shape,
    construct: {

      rect: function (width, height) {
        return this.put(new SVG.Rect()).size(width, height)
      }
    }
  })
  SVG.Circle = SVG.invent({

    create: 'circle',
    inherit: SVG.Shape,
    construct: {

      circle: function (size) {
        return this.put(new SVG.Circle()).rx(new SVG.Number(size).divide(2)).move(0, 0)
      }
    }
  })

  SVG.extend(SVG.Circle, SVG.FX, {

    rx: function (rx) {
      return this.attr('r', rx)
    },

    ry: function (ry) {
      return this.rx(ry)
    }
  })

  SVG.Ellipse = SVG.invent({

    create: 'ellipse',
    inherit: SVG.Shape,
    construct: {

      ellipse: function (width, height) {
        return this.put(new SVG.Ellipse()).size(width, height).move(0, 0)
      }
    }
  })

  SVG.extend(SVG.Ellipse, SVG.Rect, SVG.FX, {

    rx: function (rx) {
      return this.attr('rx', rx)
    },

    ry: function (ry) {
      return this.attr('ry', ry)
    }
  })
  SVG.extend(SVG.Circle, SVG.Ellipse, {

    x: function (x) {
      return x == null ? this.cx() - this.rx() : this.cx(x + this.rx())
    },

    y: function (y) {
      return y == null ? this.cy() - this.ry() : this.cy(y + this.ry())
    },

    cx: function (x) {
      return x == null ? this.attr('cx') : this.attr('cx', x)
    },

    cy: function (y) {
      return y == null ? this.attr('cy') : this.attr('cy', y)
    },

    width: function (width) {
      return width == null ? this.rx() * 2 : this.rx(new SVG.Number(width).divide(2))
    },

    height: function (height) {
      return height == null ? this.ry() * 2 : this.ry(new SVG.Number(height).divide(2))
    },

    size: function (width, height) {
      var p = proportionalSize(this, width, height)

      return this
        .rx(new SVG.Number(p.width).divide(2))
        .ry(new SVG.Number(p.height).divide(2))
    }
  })
  SVG.Line = SVG.invent({

    create: 'line',
    inherit: SVG.Shape,
    extend: {

      array: function () {
        return new SVG.PointArray([
          [this.attr('x1'), this.attr('y1')],
          [this.attr('x2'), this.attr('y2')]
        ])
      },

      plot: function (x1, y1, x2, y2) {
        if (x1 == null) { return this.array() } else if (typeof y1 !== 'undefined') { x1 = { x1: x1, y1: y1, x2: x2, y2: y2 } } else { x1 = new SVG.PointArray(x1).toLine() }

        return this.attr(x1)
      },

      move: function (x, y) {
        return this.attr(this.array().move(x, y).toLine())
      },

      size: function (width, height) {
        var p = proportionalSize(this, width, height)

        return this.attr(this.array().size(p.width, p.height).toLine())
      }
    },
    construct: {

      line: function (x1, y1, x2, y2) {
        return SVG.Line.prototype.plot.apply(
          this.put(new SVG.Line())
          , x1 != null ? [x1, y1, x2, y2] : [0, 0, 0, 0]
        )
      }
    }
  })

  SVG.Polyline = SVG.invent({

    create: 'polyline',
    inherit: SVG.Shape,
    construct: {

      polyline: function (p) {

        return this.put(new SVG.Polyline()).plot(p || new SVG.PointArray())
      }
    }
  })

  SVG.Polygon = SVG.invent({

    create: 'polygon',
    inherit: SVG.Shape,
    construct: {

      polygon: function (p) {

        return this.put(new SVG.Polygon()).plot(p || new SVG.PointArray())
      }
    }
  })
  SVG.extend(SVG.Polyline, SVG.Polygon, {

    array: function () {
      return this._array || (this._array = new SVG.PointArray(this.attr('points')))
    },

    plot: function (p) {
      return (p == null)
        ? this.array()
        : this.clear().attr('points', typeof p === 'string' ? p : (this._array = new SVG.PointArray(p)))
    },

    clear: function () {
      delete this._array
      return this
    },

    move: function (x, y) {
      return this.attr('points', this.array().move(x, y))
    },

    size: function (width, height) {
      var p = proportionalSize(this, width, height)

      return this.attr('points', this.array().size(p.width, p.height))
    }

  })
  SVG.extend(SVG.Line, SVG.Polyline, SVG.Polygon, {

    morphArray: SVG.PointArray,

    x: function (x) {
      return x == null ? this.bbox().x : this.move(x, this.bbox().y)
    },

    y: function (y) {
      return y == null ? this.bbox().y : this.move(this.bbox().x, y)
    },

    width: function (width) {
      var b = this.bbox()

      return width == null ? b.width : this.size(width, b.height)
    },

    height: function (height) {
      var b = this.bbox()

      return height == null ? b.height : this.size(b.width, height)
    }
  })
  SVG.Path = SVG.invent({

    create: 'path',
    inherit: SVG.Shape,
    extend: {

      morphArray: SVG.PathArray,

      array: function () {
        return this._array || (this._array = new SVG.PathArray(this.attr('d')))
      },

      plot: function (d) {
        return (d == null)
          ? this.array()
          : this.clear().attr('d', typeof d === 'string' ? d : (this._array = new SVG.PathArray(d)))
      },

      clear: function () {
        delete this._array
        return this
      },

    },
    construct: {

      path: function (d) {

        return this.put(new SVG.Path()).plot(d || new SVG.PathArray())
      }
    }
  })

  SVG.Image = SVG.invent({

    create: 'image',
    inherit: SVG.Shape,
    extend: {

      load: function (url) {
        if (!url) return this

        var self = this,
          img = new window.Image()
        SVG.on(img, 'load', function () {
          SVG.off(img)

          var p = self.parent(SVG.Pattern)

          if (p === null) return
          if (self.width() == 0 && self.height() == 0) { self.size(img.width, img.height) }
          if (p && p.width() == 0 && p.height() == 0) { p.size(self.width(), self.height()) }
          if (typeof self._loaded === 'function') {
            self._loaded.call(self, {
              width: img.width,
              height: img.height,
              ratio: img.width / img.height,
              url: url
            })
          }
        })

        SVG.on(img, 'error', function (e) {
          SVG.off(img)

          if (typeof self._error === 'function') {
            self._error.call(self, e)
          }
        })

        return this.attr('href', (img.src = this.src = url), SVG.xlink)
      },

      loaded: function (loaded) {
        this._loaded = loaded
        return this
      },

      error: function (error) {
        this._error = error
        return this
      }
    },
    construct: {

      image: function (source, width, height) {
        return this.put(new SVG.Image()).load(source).size(width || 0, height || width || 0)
      }
    }

  })
  SVG.Text = SVG.invent({

    create: function () {
      this.constructor.call(this, SVG.create('text'))

      this.dom.leading = new SVG.Number(1.3)
      this._rebuild = true
      this._build = false
      this.attr('font-family', SVG.defaults.attrs['font-family'])
    },
    inherit: SVG.Shape,
    extend: {

      x: function (x) {

        if (x == null) { return this.attr('x') }

        return this.attr('x', x)
      },

      text: function (text) {

        if (typeof text === 'undefined') {
          var text = ''
          var children = this.node.childNodes
          for (var i = 0, len = children.length; i < len; ++i) {

            if (i != 0 && children[i].nodeType != 3 && SVG.adopt(children[i]).dom.newLined == true) {
              text += '\n'
            }
            text += children[i].textContent
          }

          return text
        }
        this.clear().build(true)

        if (typeof text === 'function') {

          text.call(this, this)
        } else {

          text = text.split('\n')
          for (var i = 0, il = text.length; i < il; i++) { this.tspan(text[i]).newLine() }
        }
        return this.build(false).rebuild()
      },

      size: function (size) {
        return this.attr('font-size', size).rebuild()
      },

      leading: function (value) {

        if (value == null) { return this.dom.leading }
        this.dom.leading = new SVG.Number(value)

        return this.rebuild()
      },

      lines: function () {
        var node = (this.textPath && this.textPath() || this).node
        var lines = SVG.utils.map(SVG.utils.filterSVGElements(node.childNodes), function (el) {
          return SVG.adopt(el)
        })
        return new SVG.Set(lines)
      },

      rebuild: function (rebuild) {

        if (typeof rebuild === 'boolean') { this._rebuild = rebuild }
        if (this._rebuild) {
          var self = this,
            blankLineOffset = 0,
            dy = this.dom.leading * new SVG.Number(this.attr('font-size'))

          this.lines().each(function () {
            if (this.dom.newLined) {
              if (!self.textPath()) { this.attr('x', self.attr('x')) }
              if (this.text() == '\n') {
                blankLineOffset += dy
              } else {
                this.attr('dy', dy + blankLineOffset)
                blankLineOffset = 0
              }
            }
          })

          this.fire('rebuild')
        }

        return this
      },

      build: function (build) {
        this._build = !!build
        return this
      },

      setData: function (o) {
        this.dom = o
        this.dom.leading = new SVG.Number(o.leading || 1.3)
        return this
      }
    },
    construct: {

      text: function (text) {
        return this.put(new SVG.Text()).text(text)
      },

      plain: function (text) {
        return this.put(new SVG.Text()).plain(text)
      }
    }

  })

  SVG.Tspan = SVG.invent({

    create: 'tspan',
    inherit: SVG.Shape,
    extend: {

      text: function (text) {
        if (text == null) return this.node.textContent + (this.dom.newLined ? '\n' : '')

        typeof text === 'function' ? text.call(this, this) : this.plain(text)

        return this
      },

      dx: function (dx) {
        return this.attr('dx', dx)
      },

      dy: function (dy) {
        return this.attr('dy', dy)
      },

      newLine: function () {

        var t = this.parent(SVG.Text)
        this.dom.newLined = true
        return this.dy(t.dom.leading * t.attr('font-size')).attr('x', t.x())
      }
    }

  })

  SVG.extend(SVG.Text, SVG.Tspan, {

    plain: function (text) {

      if (this._build === false) { this.clear() }
      this.node.appendChild(document.createTextNode(text))

      return this
    },

    tspan: function (text) {
      var node = (this.textPath && this.textPath() || this).node,
        tspan = new SVG.Tspan()
      if (this._build === false) { this.clear() }
      node.appendChild(tspan.node)

      return tspan.text(text)
    },

    clear: function () {
      var node = (this.textPath && this.textPath() || this).node
      while (node.hasChildNodes()) { node.removeChild(node.lastChild) }

      return this
    },

    length: function () {
      return this.node.getComputedTextLength()
    }
  })

  SVG.TextPath = SVG.invent({

    create: 'textPath',
    inherit: SVG.Parent,
    parent: SVG.Text,
    construct: {
      morphArray: SVG.PathArray,

      array: function () {
        var track = this.track()

        return track ? track.array() : null
      },

      plot: function (d) {
        var track = this.track(),
          pathArray = null

        if (track) {
          pathArray = track.plot(d)
        }

        return (d == null) ? pathArray : this
      },

      track: function () {
        var path = this.textPath()

        if (path) { return path.reference('href') }
      },

      textPath: function () {
        if (this.node.firstChild && this.node.firstChild.nodeName == 'textPath') { return SVG.adopt(this.node.firstChild) }
      }
    }
  })

  SVG.Nested = SVG.invent({

    create: function () {
      this.constructor.call(this, SVG.create('svg'))

      this.style('overflow', 'visible')
    },
    inherit: SVG.Container,
    construct: {

      nested: function () {
        return this.put(new SVG.Nested())
      }
    }
  })
  var sugar = {
    stroke: ['color', 'width', 'opacity', 'linecap', 'linejoin', 'miterlimit', 'dasharray', 'dashoffset'],
    fill: ['color', 'opacity', 'rule'],
    prefix: function (t, a) {
      return a == 'color' ? t : t + '-' + a
    }
  }
    ;['fill', 'stroke'].forEach(function (m) {
      var extension = {}

      extension[m] = function (o) {
        if (typeof o === 'undefined') { return this }
        if (typeof o === 'string' || SVG.Color.isRgb(o) || (o && typeof o.fill === 'function')) { this.attr(m, o) } else {
          for (var i = sugar[m].length - 1; i >= 0; i--) {
            if (o[sugar[m][i]] != null) { this.attr(sugar.prefix(m, sugar[m][i]), o[sugar[m][i]]) }
          }
        }

        return this
      }

      SVG.extend(SVG.Element, SVG.FX, extension)
    })

  SVG.extend(SVG.Element, SVG.FX, {
    translate: function (x, y) {
      return this.transform({ x: x, y: y })
    },

    matrix: function (m) {
      return this.attr('transform', new SVG.Matrix(arguments.length == 6 ? [].slice.call(arguments) : m))
    },

    opacity: function (value) {
      return this.attr('opacity', value)
    },

    dx: function (x) {
      return this.x(new SVG.Number(x).plus(this instanceof SVG.FX ? 0 : this.x()), true)
    },

    dy: function (y) {
      return this.y(new SVG.Number(y).plus(this instanceof SVG.FX ? 0 : this.y()), true)
    },

  })
  SVG.extend(SVG.Path, {

    length: function () {
      return this.node.getTotalLength()
    },

    pointAt: function (length) {
      return this.node.getPointAtLength(length)
    }
  })
  SVG.Set = SVG.invent({

    create: function (members) {

      Array.isArray(members) ? this.members = members : this.clear()
    },
    extend: {

      add: function () {
        var il, elements = [].slice.call(arguments)

        for (var i = 0, il = elements.length; i < il; i++) { this.members.push(elements[i]) }

        return this
      },

      remove: function (element) {
        var i = this.index(element)
        if (i > -1) { this.members.splice(i, 1) }

        return this
      },

      each: function (block) {
        for (var i = 0, il = this.members.length; i < il; i++) { block.apply(this.members[i], [i, this.members]) }

        return this
      },

      clear: function () {

        this.members = []

        return this
      },

      length: function () {
        return this.members.length
      },

      has: function (element) {
        return this.index(element) >= 0
      },

      index: function (element) {
        return this.members.indexOf(element)
      },

      get: function (i) {
        return this.members[i]
      },

      first: function () {
        return this.get(0)
      },

      last: function () {
        return this.get(this.members.length - 1)
      },

      valueOf: function () {
        return this.members
      },

    },
    construct: {

      set: function (members) {
        return new SVG.Set(members)
      }
    }
  })

  SVG.FX.Set = SVG.invent({

    create: function (set) {

      this.set = set
    }

  })
  SVG.Set.inherit = function () {
    var methods = []
    for (var m in SVG.Shape.prototype) {
      if (typeof SVG.Shape.prototype[m] === 'function' && typeof SVG.Set.prototype[m] !== 'function') { methods.push(m) }
    }
    methods.forEach(function (method) {
      SVG.Set.prototype[method] = function () {
        for (var i = 0, il = this.members.length; i < il; i++) {
          if (this.members[i] && typeof this.members[i][method] === 'function') { this.members[i][method].apply(this.members[i], arguments) }
        }

        return method == 'animate' ? (this.fx || (this.fx = new SVG.FX.Set(this))) : this
      }
    })
    methods = []
    for (var m in SVG.FX.prototype) {
      if (typeof SVG.FX.prototype[m] === 'function' && typeof SVG.FX.Set.prototype[m] !== 'function') { methods.push(m) }
    }
    methods.forEach(function (method) {
      SVG.FX.Set.prototype[method] = function () {
        for (var i = 0, il = this.set.members.length; i < il; i++) { this.set.members[i].fx[method].apply(this.set.members[i].fx, arguments) }

        return this
      }
    })
  }

  SVG.extend(SVG.Element, {

  })
  SVG.extend(SVG.Element, {

    remember: function (k, v) {

      if (typeof arguments[0] === 'object') {
        for (var v_ in k) { this.remember(v_, k[v_]) }
      }
      else if (arguments.length == 1) { return this.memory()[k] }
      else { this.memory()[k] = v }

      return this
    },
    forget: function () {
      if (arguments.length == 0) { this._memory = {} } else {
        for (var i = arguments.length - 1; i >= 0; i--) { delete this.memory()[arguments[i]] }
      }

      return this
    },
    memory: function () {
      return this._memory || (this._memory = {})
    }

  })

  SVG.get = function (id) {
    var node = document.getElementById(idFromReference(id) || id)
    return SVG.adopt(node)
  }
  SVG.select = function (query, parent) {
    return new SVG.Set(
      SVG.utils.map((parent || document).querySelectorAll(query), function (node) {
        return SVG.adopt(node)
      })
    )
  }

  SVG.extend(SVG.Parent, {

    select: function (query) {
      return SVG.select(query, this.node)
    }

  })
  function pathRegReplace(a, b, c, d) {
    return c + d.replace(SVG.regex.dots, ' .')
  }
  function array_clone(arr) {
    var clone = arr.slice(0)
    for (var i = clone.length; i--;) {
      if (Array.isArray(clone[i])) {
        clone[i] = array_clone(clone[i])
      }
    }
    return clone
  }
  function is(el, obj) {
    return el instanceof obj
  }
  function matches(el, selector) {
    return (el.matches || el.matchesSelector || el.msMatchesSelector || el.mozMatchesSelector || el.webkitMatchesSelector || el.oMatchesSelector).call(el, selector)
  }
  function camelCase(s) {
    return s.toLowerCase().replace(/-(.)/g, function (m, g) {
      return g.toUpperCase()
    })
  }
  function capitalize(s) {
    return s.charAt(0).toUpperCase() + s.slice(1)
  }
  function fullHex(hex) {
    return hex.length == 4
      ? ['#',
        hex.substring(1, 2), hex.substring(1, 2),
        hex.substring(2, 3), hex.substring(2, 3),
        hex.substring(3, 4), hex.substring(3, 4)
      ].join('') : hex
  }
  function compToHex(comp) {
    var hex = comp.toString(16)
    return hex.length == 1 ? '0' + hex : hex
  }
  function proportionalSize(element, width, height) {
    if (width == null || height == null) {
      var box = element.bbox()

      if (width == null) { width = box.width / box.height * height } else if (height == null) { height = box.height / box.width * width }
    }

    return {
      width: width,
      height: height
    }
  }
  function deltaTransformPoint(matrix, x, y) {
    return {
      x: x * matrix.a + y * matrix.c + 0,
      y: x * matrix.b + y * matrix.d + 0
    }
  }
  function arrayToMatrix(a) {
    return { a: a[0], b: a[1], c: a[2], d: a[3], e: a[4], f: a[5] }
  }
  function parseMatrix(matrix) {
    if (!(matrix instanceof SVG.Matrix)) { matrix = new SVG.Matrix(matrix) }

    return matrix
  }
  function ensureCentre(o, target) {
    o.cx = o.cx == null ? target.bbox().cx : o.cx
    o.cy = o.cy == null ? target.bbox().cy : o.cy
  }
  function arrayToString(a) {
    for (var i = 0, il = a.length, s = ''; i < il; i++) {
      s += a[i][0]

      if (a[i][1] != null) {
        s += a[i][1]

        if (a[i][2] != null) {
          s += ' '
          s += a[i][2]

          if (a[i][3] != null) {
            s += ' '
            s += a[i][3]
            s += ' '
            s += a[i][4]

            if (a[i][5] != null) {
              s += ' '
              s += a[i][5]
              s += ' '
              s += a[i][6]

              if (a[i][7] != null) {
                s += ' '
                s += a[i][7]
              }
            }
          }
        }
      }
    }

    return s + ' '
  }
  function assignNewId(node) {

    for (var i = node.childNodes.length - 1; i >= 0; i--) {
      if (node.childNodes[i] instanceof window.SVGElement) { assignNewId(node.childNodes[i]) }
    }

    return SVG.adopt(node).id(SVG.eid(node.nodeName))
  }
  function fullBox(b) {
    if (b.x == null) {
      b.x = 0
      b.y = 0
      b.width = 0
      b.height = 0
    }

    b.w = b.width
    b.h = b.height
    b.x2 = b.x + b.width
    b.y2 = b.y + b.height
    b.cx = b.x + b.width / 2
    b.cy = b.y + b.height / 2

    return b
  }
  function idFromReference(url) {
    var m = (url || '').toString().match(SVG.regex.reference)

    if (m) return m[1]
  }
  function float32String(v) {
    return Math.abs(v) > 1e-37 ? v : 0
  }
  var abcdef = 'abcdef'.split('')
  if (typeof window.CustomEvent !== 'function') {

    var CustomEventPoly = function (event, options) {
      options = options || { bubbles: false, cancelable: false, detail: undefined }
      var e = document.createEvent('CustomEvent')
      e.initCustomEvent(event, options.bubbles, options.cancelable, options.detail)
      return e
    }

    CustomEventPoly.prototype = window.Event.prototype

    SVG.CustomEvent = CustomEventPoly
  } else {
    SVG.CustomEvent = window.CustomEvent
  }

  return SVG
}))
