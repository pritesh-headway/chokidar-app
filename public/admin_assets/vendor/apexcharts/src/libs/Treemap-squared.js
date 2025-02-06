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

window.TreemapSquared = {}
  ; (function () {
    'use strict'
    window.TreemapSquared.generate = (function () {
      function Container(xoffset, yoffset, width, height) {
        this.xoffset = xoffset
        this.yoffset = yoffset
        this.height = height
        this.width = width

        this.shortestEdge = function () {
          return Math.min(this.height, this.width)
        }
        this.getCoordinates = function (row) {
          let coordinates = []
          let subxoffset = this.xoffset,
            subyoffset = this.yoffset //our offset within the container
          let areawidth = sumArray(row) / this.height
          let areaheight = sumArray(row) / this.width
          let i

          if (this.width >= this.height) {
            for (i = 0; i < row.length; i++) {
              coordinates.push([
                subxoffset,
                subyoffset,
                subxoffset + areawidth,
                subyoffset + row[i] / areawidth
              ])
              subyoffset = subyoffset + row[i] / areawidth
            }
          } else {
            for (i = 0; i < row.length; i++) {
              coordinates.push([
                subxoffset,
                subyoffset,
                subxoffset + row[i] / areaheight,
                subyoffset + areaheight
              ])
              subxoffset = subxoffset + row[i] / areaheight
            }
          }
          return coordinates
        }
        this.cutArea = function (area) {
          let newcontainer

          if (this.width >= this.height) {
            let areawidth = area / this.height
            let newwidth = this.width - areawidth
            newcontainer = new Container(
              this.xoffset + areawidth,
              this.yoffset,
              newwidth,
              this.height
            )
          } else {
            let areaheight = area / this.width
            let newheight = this.height - areaheight
            newcontainer = new Container(
              this.xoffset,
              this.yoffset + areaheight,
              this.width,
              newheight
            )
          }
          return newcontainer
        }
      }
      function normalize(data, area) {
        let normalizeddata = []
        let sum = sumArray(data)
        let multiplier = area / sum
        let i

        for (i = 0; i < data.length; i++) {
          normalizeddata[i] = data[i] * multiplier
        }
        return normalizeddata
      }
      function treemapMultidimensional(data, width, height, xoffset, yoffset) {
        xoffset = typeof xoffset === 'undefined' ? 0 : xoffset
        yoffset = typeof yoffset === 'undefined' ? 0 : yoffset

        let mergeddata = []
        let mergedtreemap
        let results = []
        let i

        if (isArray(data[0])) {

          for (i = 0; i < data.length; i++) {
            mergeddata[i] = sumMultidimensionalArray(data[i])
          }
          mergedtreemap = treemapSingledimensional(
            mergeddata,
            width,
            height,
            xoffset,
            yoffset
          )

          for (i = 0; i < data.length; i++) {
            results.push(
              treemapMultidimensional(
                data[i],
                mergedtreemap[i][2] - mergedtreemap[i][0],
                mergedtreemap[i][3] - mergedtreemap[i][1],
                mergedtreemap[i][0],
                mergedtreemap[i][1]
              )
            )
          }
        } else {
          results = treemapSingledimensional(
            data,
            width,
            height,
            xoffset,
            yoffset
          )
        }
        return results
      }
      function treemapSingledimensional(data, width, height, xoffset, yoffset) {
        xoffset = typeof xoffset === 'undefined' ? 0 : xoffset
        yoffset = typeof yoffset === 'undefined' ? 0 : yoffset

        let rawtreemap = squarify(
          normalize(data, width * height),
          [],
          new Container(xoffset, yoffset, width, height),
          []
        )
        return flattenTreemap(rawtreemap)
      }
      function flattenTreemap(rawtreemap) {
        let flattreemap = []
        let i, j

        for (i = 0; i < rawtreemap.length; i++) {
          for (j = 0; j < rawtreemap[i].length; j++) {
            flattreemap.push(rawtreemap[i][j])
          }
        }
        return flattreemap
      }
      function squarify(data, currentrow, container, stack) {
        let length
        let nextdatapoint
        let newcontainer

        if (data.length === 0) {
          stack.push(container.getCoordinates(currentrow))
          return
        }

        length = container.shortestEdge()
        nextdatapoint = data[0]

        if (improvesRatio(currentrow, nextdatapoint, length)) {
          currentrow.push(nextdatapoint)
          squarify(data.slice(1), currentrow, container, stack)
        } else {
          newcontainer = container.cutArea(sumArray(currentrow), stack)
          stack.push(container.getCoordinates(currentrow))
          squarify(data, [], newcontainer, stack)
        }
        return stack
      }
      function improvesRatio(currentrow, nextnode, length) {
        let newrow

        if (currentrow.length === 0) {
          return true
        }

        newrow = currentrow.slice()
        newrow.push(nextnode)

        let currentratio = calculateRatio(currentrow, length)
        let newratio = calculateRatio(newrow, length)
        return currentratio >= newratio
      }
      function calculateRatio(row, length) {
        let min = Math.min.apply(Math, row)
        let max = Math.max.apply(Math, row)
        let sum = sumArray(row)
        return Math.max(
          (Math.pow(length, 2) * max) / Math.pow(sum, 2),
          Math.pow(sum, 2) / (Math.pow(length, 2) * min)
        )
      }
      function isArray(arr) {
        return arr && arr.constructor === Array
      }
      function sumArray(arr) {
        let sum = 0
        let i

        for (i = 0; i < arr.length; i++) {
          sum += arr[i]
        }
        return sum
      }
      function sumMultidimensionalArray(arr) {
        let i,
          total = 0

        if (isArray(arr[0])) {
          for (i = 0; i < arr.length; i++) {
            total += sumMultidimensionalArray(arr[i])
          }
        } else {
          total = sumArray(arr)
        }
        return total
      }

      return treemapMultidimensional
    })()
  })()
