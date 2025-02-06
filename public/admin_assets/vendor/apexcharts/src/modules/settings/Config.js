import Defaults from './Defaults'
import Utils from './../../utils/Utils'
import Options from './Options'

/**
 * ApexCharts Config Class for extending user options with pre-defined ApexCharts config.
 *
 * @module Config
 **/
export default class Config {
  constructor(opts) {
    this.opts = opts
  }

  init({ responsiveOverride }) {
    let opts = this.opts
    let options = new Options()
    let defaults = new Defaults(opts)

    this.chartType = opts.chart.type

    opts = this.extendYAxis(opts)
    opts = this.extendAnnotations(opts)

    let config = options.init()
    let newDefaults = {}
    if (opts && typeof opts === 'object') {
      let chartDefaults = {}
      const chartTypes = [
        'line',
        'area',
        'bar',
        'candlestick',
        'boxPlot',
        'rangeBar',
        'rangeArea',
        'bubble',
        'scatter',
        'heatmap',
        'treemap',
        'pie',
        'polarArea',
        'donut',
        'radar',
        'radialBar'
      ]

      if (chartTypes.indexOf(opts.chart.type) !== -1) {
        chartDefaults = defaults[opts.chart.type]()
      } else {
        chartDefaults = defaults.line()
      }

      if (opts.chart.stacked && opts.chart.type === 'bar') {
        chartDefaults = defaults.stackedBars()
      }

      if (opts.chart.brush && opts.chart.brush.enabled) {
        chartDefaults = defaults.brush(chartDefaults)
      }

      if (opts.chart.stacked && opts.chart.stackType === '100%') {
        opts = defaults.stacked100(opts)
      }
      this.checkForDarkTheme(window.Apex)
      this.checkForDarkTheme(opts)

      opts.xaxis = opts.xaxis || window.Apex.xaxis || {}
      if (!responsiveOverride) {
        opts.xaxis.convertedCatToNumeric = false
      }

      opts = this.checkForCatToNumericXAxis(this.chartType, chartDefaults, opts)

      if (
        (opts.chart.sparkline && opts.chart.sparkline.enabled) ||
        (window.Apex.chart &&
          window.Apex.chart.sparkline &&
          window.Apex.chart.sparkline.enabled)
      ) {
        chartDefaults = defaults.sparkline(chartDefaults)
      }
      newDefaults = Utils.extend(config, chartDefaults)
    }
    let mergedWithDefaultConfig = Utils.extend(newDefaults, window.Apex)
    config = Utils.extend(mergedWithDefaultConfig, opts)
    config = this.handleUserInputErrors(config)

    return config
  }

  checkForCatToNumericXAxis(chartType, chartDefaults, opts) {
    let defaults = new Defaults(opts)

    const isBarHorizontal =
      (chartType === 'bar' || chartType === 'boxPlot') &&
      opts.plotOptions &&
      opts.plotOptions.bar &&
      opts.plotOptions.bar.horizontal

    const unsupportedZoom =
      chartType === 'pie' ||
      chartType === 'polarArea' ||
      chartType === 'donut' ||
      chartType === 'radar' ||
      chartType === 'radialBar' ||
      chartType === 'heatmap'

    const notNumericXAxis =
      opts.xaxis.type !== 'datetime' && opts.xaxis.type !== 'numeric'

    let tickPlacement = opts.xaxis.tickPlacement
      ? opts.xaxis.tickPlacement
      : chartDefaults.xaxis && chartDefaults.xaxis.tickPlacement
    if (
      !isBarHorizontal &&
      !unsupportedZoom &&
      notNumericXAxis &&
      tickPlacement !== 'between'
    ) {
      opts = defaults.convertCatToNumeric(opts)
    }

    return opts
  }

  extendYAxis(opts, w) {
    let options = new Options()

    if (
      typeof opts.yaxis === 'undefined' ||
      !opts.yaxis ||
      (Array.isArray(opts.yaxis) && opts.yaxis.length === 0)
    ) {
      opts.yaxis = {}
    }
    if (
      opts.yaxis.constructor !== Array &&
      window.Apex.yaxis &&
      window.Apex.yaxis.constructor !== Array
    ) {
      opts.yaxis = Utils.extend(opts.yaxis, window.Apex.yaxis)
    }
    if (opts.yaxis.constructor !== Array) {

      opts.yaxis = [Utils.extend(options.yAxis, opts.yaxis)]
    } else {
      opts.yaxis = Utils.extendArray(opts.yaxis, options.yAxis)
    }

    let isLogY = false
    opts.yaxis.forEach((y) => {
      if (y.logarithmic) {
        isLogY = true
      }
    })

    let series = opts.series
    if (w && !series) {
      series = w.config.series
    }
    if (isLogY && series.length !== opts.yaxis.length && series.length) {
      opts.yaxis = series.map((s, i) => {
        if (!s.name) {
          series[i].name = `series-${i + 1}`
        }
        if (opts.yaxis[i]) {
          opts.yaxis[i].seriesName = series[i].name
          return opts.yaxis[i]
        } else {
          const newYaxis = Utils.extend(options.yAxis, opts.yaxis[0])
          newYaxis.show = false
          return newYaxis
        }
      })
    }

    if (isLogY && series.length > 1 && series.length !== opts.yaxis.length) {
      console.warn(
        'A multi-series logarithmic chart should have equal number of series and y-axes. Please make sure to equalize both.'
      )
    }
    return opts
  }
  extendAnnotations(opts) {
    if (typeof opts.annotations === 'undefined') {
      opts.annotations = {}
      opts.annotations.yaxis = []
      opts.annotations.xaxis = []
      opts.annotations.points = []
    }

    opts = this.extendYAxisAnnotations(opts)
    opts = this.extendXAxisAnnotations(opts)
    opts = this.extendPointAnnotations(opts)

    return opts
  }

  extendYAxisAnnotations(opts) {
    let options = new Options()

    opts.annotations.yaxis = Utils.extendArray(
      typeof opts.annotations.yaxis !== 'undefined'
        ? opts.annotations.yaxis
        : [],
      options.yAxisAnnotation
    )
    return opts
  }

  extendXAxisAnnotations(opts) {
    let options = new Options()

    opts.annotations.xaxis = Utils.extendArray(
      typeof opts.annotations.xaxis !== 'undefined'
        ? opts.annotations.xaxis
        : [],
      options.xAxisAnnotation
    )
    return opts
  }
  extendPointAnnotations(opts) {
    let options = new Options()

    opts.annotations.points = Utils.extendArray(
      typeof opts.annotations.points !== 'undefined'
        ? opts.annotations.points
        : [],
      options.pointAnnotation
    )
    return opts
  }

  checkForDarkTheme(opts) {
    if (opts.theme && opts.theme.mode === 'dark') {
      if (!opts.tooltip) {
        opts.tooltip = {}
      }
      if (opts.tooltip.theme !== 'light') {
        opts.tooltip.theme = 'dark'
      }

      if (!opts.chart.foreColor) {
        opts.chart.foreColor = '#f6f7f8'
      }

      if (!opts.chart.background) {
        opts.chart.background = '#424242'
      }

      if (!opts.theme.palette) {
        opts.theme.palette = 'palette4'
      }
    }
  }

  handleUserInputErrors(opts) {
    let config = opts

    if (config.tooltip.shared && config.tooltip.intersect) {
      throw new Error(
        'tooltip.shared cannot be enabled when tooltip.intersect is true. Turn off any other option by setting it to false.'
      )
    }

    if (config.chart.type === 'bar' && config.plotOptions.bar.horizontal) {

      if (config.yaxis.length > 1) {
        throw new Error(
          'Multiple Y Axis for bars are not supported. Switch to column chart by setting plotOptions.bar.horizontal=false'
        )
      }
      if (config.yaxis[0].reversed) {
        config.yaxis[0].opposite = true
      }

      config.xaxis.tooltip.enabled = false
      config.yaxis[0].tooltip.enabled = false
      config.chart.zoom.enabled = false
    }

    if (config.chart.type === 'bar' || config.chart.type === 'rangeBar') {
      if (config.tooltip.shared) {
        if (
          config.xaxis.crosshairs.width === 'barWidth' &&
          config.series.length > 1
        ) {
          config.xaxis.crosshairs.width = 'tickWidth'
        }
      }
    }

    if (
      config.chart.type === 'candlestick' ||
      config.chart.type === 'boxPlot'
    ) {
      if (config.yaxis[0].reversed) {
        console.warn(
          `Reversed y-axis in ${config.chart.type} chart is not supported.`
        )
        config.yaxis[0].reversed = false
      }
    }

    return config
  }
}
