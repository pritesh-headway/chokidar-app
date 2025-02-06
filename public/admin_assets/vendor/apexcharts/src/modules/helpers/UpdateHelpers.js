import Defaults from '../settings/Defaults'
import Config from '../settings/Config'
import CoreUtils from '../CoreUtils'
import Graphics from '../Graphics'
import Utils from '../../utils/Utils'

export default class UpdateHelpers {
  constructor(ctx) {
    this.ctx = ctx
    this.w = ctx.w
  }

  /**
   * private method to update Options.
   *
   * @param {object} options - A new config object can be passed which will be merged with the existing config object
   * @param {boolean} redraw - should redraw from beginning or should use existing paths and redraw from there
   * @param {boolean} animate - should animate or not on updating Options
   * @param {boolean} overwriteInitialConfig - should update the initial config or not
   */
  _updateOptions(
    options,
    redraw = false,
    animate = true,
    updateSyncedCharts = true,
    overwriteInitialConfig = false
  ) {
    return new Promise((resolve) => {
      let charts = [this.ctx]
      if (updateSyncedCharts) {
        charts = this.ctx.getSyncedCharts()
      }

      if (this.ctx.w.globals.isExecCalled) {

        charts = [this.ctx]
        this.ctx.w.globals.isExecCalled = false
      }

      charts.forEach((ch, chartIndex) => {
        let w = ch.w

        w.globals.shouldAnimate = animate

        if (!redraw) {
          w.globals.resized = true
          w.globals.dataChanged = true

          if (animate) {
            ch.series.getPreviousPaths()
          }
        }

        if (options && typeof options === 'object') {
          ch.config = new Config(options)
          options = CoreUtils.extendArrayProps(ch.config, options, w)
          if (ch.w.globals.chartID !== this.ctx.w.globals.chartID) {

            delete options.series
          }

          w.config = Utils.extend(w.config, options)

          if (overwriteInitialConfig) {

            w.globals.lastXAxis = options.xaxis
              ? Utils.clone(options.xaxis)
              : []
            w.globals.lastYAxis = options.yaxis
              ? Utils.clone(options.yaxis)
              : []
            w.globals.initialConfig = Utils.extend({}, w.config)
            w.globals.initialSeries = Utils.clone(w.config.series)

            if (options.series) {

              for (
                let i = 0;
                i < w.globals.collapsedSeriesIndices.length;
                i++
              ) {
                let series =
                  w.config.series[w.globals.collapsedSeriesIndices[i]]
                w.globals.collapsedSeries[i].data = w.globals.axisCharts
                  ? series.data.slice()
                  : series
              }
              for (
                let i = 0;
                i < w.globals.ancillaryCollapsedSeriesIndices.length;
                i++
              ) {
                let series =
                  w.config.series[w.globals.ancillaryCollapsedSeriesIndices[i]]
                w.globals.ancillaryCollapsedSeries[i].data = w.globals
                  .axisCharts
                  ? series.data.slice()
                  : series
              }
              ch.series.emptyCollapsedSeries(w.config.series)
            }
          }
        }

        return ch.update(options).then(() => {
          if (chartIndex === charts.length - 1) {
            resolve(ch)
          }
        })
      })
    })
  }

  /**
   * Private method to update Series.
   *
   * @param {array} series - New series which will override the existing
   */
  _updateSeries(newSeries, animate, overwriteInitialSeries = false) {
    return new Promise((resolve) => {
      const w = this.w

      w.globals.shouldAnimate = animate

      w.globals.dataChanged = true

      if (animate) {
        this.ctx.series.getPreviousPaths()
      }

      let existingSeries
      if (w.globals.axisCharts) {
        existingSeries = newSeries.map((s, i) => {
          return this._extendSeries(s, i)
        })

        if (existingSeries.length === 0) {
          existingSeries = [{ data: [] }]
        }
        w.config.series = existingSeries
      } else {

        w.config.series = newSeries.slice()
      }

      if (overwriteInitialSeries) {
        w.globals.initialConfig.series = Utils.clone(w.config.series)
        w.globals.initialSeries = Utils.clone(w.config.series)
      }
      return this.ctx.update().then(() => {
        resolve(this.ctx)
      })
    })
  }

  _extendSeries(s, i) {
    const w = this.w
    const ser = w.config.series[i]

    return {
      ...w.config.series[i],
      name: s.name ? s.name : ser && ser.name,
      color: s.color ? s.color : ser && ser.color,
      type: s.type ? s.type : ser && ser.type,
      data: s.data ? s.data : ser && ser.data
    }
  }

  toggleDataPointSelection(seriesIndex, dataPointIndex) {
    const w = this.w
    let elPath = null
    const parent = `.apexcharts-series[data\\:realIndex='${seriesIndex}']`

    if (w.globals.axisCharts) {
      elPath = w.globals.dom.Paper.select(
        `${parent} path[j='${dataPointIndex}'], ${parent} circle[j='${dataPointIndex}'], ${parent} rect[j='${dataPointIndex}']`
      ).members[0]
    } else {

      if (typeof dataPointIndex === 'undefined') {
        elPath = w.globals.dom.Paper.select(
          `${parent} path[j='${seriesIndex}']`
        ).members[0]

        if (
          w.config.chart.type === 'pie' ||
          w.config.chart.type === 'polarArea' ||
          w.config.chart.type === 'donut'
        ) {
          this.ctx.pie.pieClicked(seriesIndex)
        }
      }
    }

    if (elPath) {
      const graphics = new Graphics(this.ctx)
      graphics.pathMouseDown(elPath, null)
    } else {
      console.warn('toggleDataPointSelection: Element not found')
      return null
    }

    return elPath.node ? elPath.node : null
  }

  forceXAxisUpdate(options) {
    const w = this.w
    const minmax = ['min', 'max']

    minmax.forEach((a) => {
      if (typeof options.xaxis[a] !== 'undefined') {
        w.config.xaxis[a] = options.xaxis[a]
        w.globals.lastXAxis[a] = options.xaxis[a]
      }
    })

    if (options.xaxis.categories && options.xaxis.categories.length) {
      w.config.xaxis.categories = options.xaxis.categories
    }

    if (w.config.xaxis.convertedCatToNumeric) {
      const defaults = new Defaults(options)
      options = defaults.convertCatToNumericXaxis(options, this.ctx)
    }
    return options
  }

  forceYAxisUpdate(options) {
    if (
      options.chart &&
      options.chart.stacked &&
      options.chart.stackType === '100%'
    ) {
      if (Array.isArray(options.yaxis)) {
        options.yaxis.forEach((yaxe, index) => {
          options.yaxis[index].min = 0
          options.yaxis[index].max = 100
        })
      } else {
        options.yaxis.min = 0
        options.yaxis.max = 100
      }
    }
    return options
  }

  /**
   * This function reverts the yaxis and xaxis min/max values to what it was when the chart was defined.
   * This function fixes an important bug where a user might load a new series after zooming in/out of previous series which resulted in wrong min/max
   * Also, this should never be called internally on zoom/pan - the reset should only happen when user calls the updateSeries() function externally
   * The function also accepts an object {xaxis, yaxis} which when present is set as the new xaxis/yaxis
   */
  revertDefaultAxisMinMax(opts) {
    const w = this.w

    let xaxis = w.globals.lastXAxis
    let yaxis = w.globals.lastYAxis

    if (opts && opts.xaxis) {
      xaxis = opts.xaxis
    }
    if (opts && opts.yaxis) {
      yaxis = opts.yaxis
    }
    w.config.xaxis.min = xaxis.min
    w.config.xaxis.max = xaxis.max

    const getLastYAxis = (index) => {
      if (typeof yaxis[index] !== 'undefined') {
        w.config.yaxis[index].min = yaxis[index].min
        w.config.yaxis[index].max = yaxis[index].max
      }
    }

    w.config.yaxis.map((yaxe, index) => {
      if (w.globals.zoomed) {

        getLastYAxis(index)
      } else {

        if (typeof yaxis[index] !== 'undefined') {
          getLastYAxis(index)
        } else {

          if (typeof this.ctx.opts.yaxis[index] !== 'undefined') {
            yaxe.min = this.ctx.opts.yaxis[index].min
            yaxe.max = this.ctx.opts.yaxis[index].max
          }
        }
      }
    })
  }
}
