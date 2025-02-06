import CoreUtils from '../modules/CoreUtils'
import Bar from './Bar'
import Graphics from '../modules/Graphics'
import Utils from '../utils/Utils'

/**
 * ApexCharts BarStacked Class responsible for drawing both Stacked Columns and Bars.
 *
 * @module BarStacked
 * The whole calculation for stacked bar/column is different from normal bar/column,
 * hence it makes sense to derive a new class for it extending most of the props of Parent Bar
 **/

class BarStacked extends Bar {
  draw(series, seriesIndex) {
    let w = this.w
    this.graphics = new Graphics(this.ctx)
    this.bar = new Bar(this.ctx, this.xyRatios)

    const coreUtils = new CoreUtils(this.ctx, w)
    series = coreUtils.getLogSeries(series)
    this.yRatio = coreUtils.getLogYRatios(this.yRatio)

    this.barHelpers.initVariables(series)

    if (w.config.chart.stackType === '100%') {
      series = w.globals.seriesPercent.slice()
    }

    this.series = series

    this.totalItems = 0

    this.prevY = []
    this.prevX = []
    this.prevYF = []
    this.prevXF = []
    this.prevYVal = []
    this.prevXVal = []

    this.xArrj = []
    this.xArrjF = []
    this.xArrjVal = []
    this.yArrj = []
    this.yArrjF = []
    this.yArrjVal = []

    for (let sl = 0; sl < series.length; sl++) {
      if (series[sl].length > 0) {
        this.totalItems += series[sl].length
      }
    }

    let ret = this.graphics.group({
      class: 'apexcharts-bar-series apexcharts-plot-series'
    })

    let x = 0
    let y = 0

    for (let i = 0, bc = 0; i < series.length; i++, bc++) {
      let xDivision
      let yDivision
      let zeroH
      let zeroW

      let xArrValues = []
      let yArrValues = []

      let realIndex = w.globals.comboCharts ? seriesIndex[i] : i

      if (this.yRatio.length > 1) {
        this.yaxisIndex = realIndex
      }

      this.isReversed =
        w.config.yaxis[this.yaxisIndex] &&
        w.config.yaxis[this.yaxisIndex].reversed
      let elSeries = this.graphics.group({
        class: `apexcharts-series`,
        seriesName: Utils.escapeString(w.globals.seriesNames[realIndex]),
        rel: i + 1,
        'data:realIndex': realIndex
      })
      this.ctx.series.addCollapsedClassToSeries(elSeries, realIndex)
      let elDataLabelsWrap = this.graphics.group({
        class: 'apexcharts-datalabels',
        'data:realIndex': realIndex
      })

      let elGoalsMarkers = this.graphics.group({
        class: 'apexcharts-bar-goals-markers',
        style: `pointer-events: none`
      })

      let barHeight = 0
      let barWidth = 0

      let initPositions = this.initialPositions(
        x,
        y,
        xDivision,
        yDivision,
        zeroH,
        zeroW
      )
      y = initPositions.y
      barHeight = initPositions.barHeight
      yDivision = initPositions.yDivision
      zeroW = initPositions.zeroW

      x = initPositions.x
      barWidth = initPositions.barWidth
      xDivision = initPositions.xDivision
      zeroH = initPositions.zeroH

      this.yArrj = []
      this.yArrjF = []
      this.yArrjVal = []
      this.xArrj = []
      this.xArrjF = []
      this.xArrjVal = []
      if (this.prevY.length === 1 && this.prevY[0].every((val) => isNaN(val))) {

        this.prevY[0] = this.prevY[0].map((val) => zeroH)

        this.prevYF[0] = this.prevYF[0].map((val) => 0)
      }

      for (let j = 0; j < w.globals.dataPoints; j++) {
        const strokeWidth = this.barHelpers.getStrokeWidth(i, j, realIndex)
        const commonPathOpts = {
          indexes: { i, j, realIndex, bc },
          strokeWidth,
          x,
          y,
          elSeries
        }
        let paths = null
        if (this.isHorizontal) {
          paths = this.drawStackedBarPaths({
            ...commonPathOpts,
            zeroW,
            barHeight,
            yDivision
          })
          barWidth = this.series[i][j] / this.invertedYRatio
        } else {
          paths = this.drawStackedColumnPaths({
            ...commonPathOpts,
            xDivision,
            barWidth,
            zeroH
          })
          barHeight = this.series[i][j] / this.yRatio[this.yaxisIndex]
        }

        const barGoalLine = this.barHelpers.drawGoalLine({
          barXPosition: paths.barXPosition,
          barYPosition: paths.barYPosition,
          goalX: paths.goalX,
          goalY: paths.goalY,
          barHeight,
          barWidth
        })

        if (barGoalLine) {
          elGoalsMarkers.add(barGoalLine)
        }

        y = paths.y
        x = paths.x

        xArrValues.push(x)
        yArrValues.push(y)

        let pathFill = this.barHelpers.getPathFillColor(series, i, j, realIndex)

        elSeries = this.renderSeries({
          realIndex,
          pathFill,
          j,
          i,
          pathFrom: paths.pathFrom,
          pathTo: paths.pathTo,
          strokeWidth,
          elSeries,
          x,
          y,
          series,
          barHeight,
          barWidth,
          elDataLabelsWrap,
          elGoalsMarkers,
          type: 'bar',
          visibleSeries: 0
        })
      }
      w.globals.seriesXvalues[realIndex] = xArrValues
      w.globals.seriesYvalues[realIndex] = yArrValues
      this.prevY.push(this.yArrj)
      this.prevYF.push(this.yArrjF)
      this.prevYVal.push(this.yArrjVal)
      this.prevX.push(this.xArrj)
      this.prevXF.push(this.xArrjF)
      this.prevXVal.push(this.xArrjVal)

      ret.add(elSeries)
    }

    return ret
  }

  initialPositions(x, y, xDivision, yDivision, zeroH, zeroW) {
    let w = this.w

    let barHeight, barWidth
    if (this.isHorizontal) {

      yDivision = w.globals.gridHeight / w.globals.dataPoints
      barHeight = yDivision

      barHeight =
        (barHeight * parseInt(w.config.plotOptions.bar.barHeight, 10)) / 100

      zeroW =
        this.baseLineInvertedY +
        w.globals.padHorizontal +
        (this.isReversed ? w.globals.gridWidth : 0) -
        (this.isReversed ? this.baseLineInvertedY * 2 : 0)
      y = (yDivision - barHeight) / 2
    } else {

      xDivision = w.globals.gridWidth / w.globals.dataPoints

      barWidth = xDivision

      if (w.globals.isXNumeric && w.globals.dataPoints > 1) {

        xDivision = w.globals.minXDiff / this.xRatio
        barWidth = (xDivision * parseInt(this.barOptions.columnWidth, 10)) / 100
      } else {
        barWidth =
          (barWidth * parseInt(w.config.plotOptions.bar.columnWidth, 10)) / 100
      }

      zeroH =
        w.globals.gridHeight -
        this.baseLineY[this.yaxisIndex] -
        (this.isReversed ? w.globals.gridHeight : 0) +
        (this.isReversed ? this.baseLineY[this.yaxisIndex] * 2 : 0)
      x = w.globals.padHorizontal + (xDivision - barWidth) / 2
    }
    return {
      x,
      y,
      yDivision,
      xDivision,
      barHeight,
      barWidth,
      zeroH,
      zeroW
    }
  }

  drawStackedBarPaths({
    indexes,
    barHeight,
    strokeWidth,
    zeroW,
    x,
    y,
    yDivision,
    elSeries
  }) {
    let w = this.w
    let barYPosition = y
    let barXPosition
    let i = indexes.i
    let j = indexes.j

    let prevBarW = 0
    for (let k = 0; k < this.prevXF.length; k++) {
      prevBarW = prevBarW + this.prevXF[k][j]
    }

    if (i > 0) {
      let bXP = zeroW

      if (this.prevXVal[i - 1][j] < 0) {
        bXP =
          this.series[i][j] >= 0
            ? this.prevX[i - 1][j] +
            prevBarW -
            (this.isReversed ? prevBarW : 0) * 2
            : this.prevX[i - 1][j]
      } else if (this.prevXVal[i - 1][j] >= 0) {
        bXP =
          this.series[i][j] >= 0
            ? this.prevX[i - 1][j]
            : this.prevX[i - 1][j] -
            prevBarW +
            (this.isReversed ? prevBarW : 0) * 2
      }

      barXPosition = bXP
    } else {

      barXPosition = zeroW
    }

    if (this.series[i][j] === null) {
      x = barXPosition
    } else {
      x =
        barXPosition +
        this.series[i][j] / this.invertedYRatio -
        (this.isReversed ? this.series[i][j] / this.invertedYRatio : 0) * 2
    }

    const paths = this.barHelpers.getBarpaths({
      barYPosition,
      barHeight,
      x1: barXPosition,
      x2: x,
      strokeWidth,
      series: this.series,
      realIndex: indexes.realIndex,
      i,
      j,
      w
    })

    this.barHelpers.barBackground({
      j,
      i,
      y1: barYPosition,
      y2: barHeight,
      elSeries
    })

    y = y + yDivision

    return {
      pathTo: paths.pathTo,
      pathFrom: paths.pathFrom,
      goalX: this.barHelpers.getGoalValues('x', zeroW, null, i, j),
      barYPosition,
      x,
      y
    }
  }

  drawStackedColumnPaths({
    indexes,
    x,
    y,
    xDivision,
    barWidth,
    zeroH,
    strokeWidth,
    elSeries
  }) {
    let w = this.w
    let i = indexes.i
    let j = indexes.j
    let bc = indexes.bc

    if (w.globals.isXNumeric) {
      let seriesVal = w.globals.seriesX[i][j]
      if (!seriesVal) seriesVal = 0
      x = (seriesVal - w.globals.minX) / this.xRatio - barWidth / 2
    }

    let barXPosition = x
    let barYPosition

    let prevBarH = 0
    for (let k = 0; k < this.prevYF.length; k++) {
      prevBarH = prevBarH + (!isNaN(this.prevYF[k][j]) ? this.prevYF[k][j] : 0)
    }

    if (
      (i > 0 && !w.globals.isXNumeric) ||
      (i > 0 &&
        w.globals.isXNumeric &&
        w.globals.seriesX[i - 1][j] === w.globals.seriesX[i][j])
    ) {
      let bYP
      let prevYValue
      const p = Math.min(this.yRatio.length + 1, i + 1)
      if (this.prevY[i - 1] !== undefined) {
        for (let ii = 1; ii < p; ii++) {
          if (!isNaN(this.prevY[i - ii][j])) {

            prevYValue = this.prevY[i - ii][j]

            break
          }
        }
      }

      for (let ii = 1; ii < p; ii++) {

        if (this.prevYVal[i - ii][j] < 0) {
          bYP =
            this.series[i][j] >= 0
              ? prevYValue - prevBarH + (this.isReversed ? prevBarH : 0) * 2
              : prevYValue

          break
        } else if (this.prevYVal[i - ii][j] >= 0) {
          bYP =
            this.series[i][j] >= 0
              ? prevYValue
              : prevYValue + prevBarH - (this.isReversed ? prevBarH : 0) * 2

          break
        }
      }

      if (typeof bYP === 'undefined') bYP = w.globals.gridHeight
      if (
        this.prevYF[0].every((val) => val === 0) &&
        this.prevYF.slice(1, i).every((arr) => arr.every((val) => isNaN(val)))
      ) {
        barYPosition = zeroH
      } else {

        barYPosition = bYP
      }
    } else {

      barYPosition = zeroH
    }

    if (this.series[i][j]) {
      y =
        barYPosition -
        this.series[i][j] / this.yRatio[this.yaxisIndex] +
        (this.isReversed
          ? this.series[i][j] / this.yRatio[this.yaxisIndex]
          : 0) *
        2
    } else {

      y = barYPosition
    }

    const paths = this.barHelpers.getColumnPaths({
      barXPosition,
      barWidth,
      y1: barYPosition,
      y2: y,
      yRatio: this.yRatio[this.yaxisIndex],
      strokeWidth: this.strokeWidth,
      series: this.series,
      realIndex: indexes.realIndex,
      i,
      j,
      w
    })

    this.barHelpers.barBackground({
      bc,
      j,
      i,
      x1: barXPosition,
      x2: barWidth,
      elSeries
    })

    x = x + xDivision

    return {
      pathTo: paths.pathTo,
      pathFrom: paths.pathFrom,
      goalY: this.barHelpers.getGoalValues('y', null, zeroH, i, j),
      barXPosition,
      x: w.globals.isXNumeric ? x - xDivision : x,
      y
    }
  }
}

export default BarStacked
