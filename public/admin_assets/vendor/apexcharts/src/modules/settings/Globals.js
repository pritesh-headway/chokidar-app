import Utils from './../../utils/Utils'

export default class Globals {
  initGlobalVars(gl) {
    gl.series = []
    gl.seriesCandleO = []
    gl.seriesCandleH = []
    gl.seriesCandleM = []
    gl.seriesCandleL = []
    gl.seriesCandleC = []
    gl.seriesRangeStart = []
    gl.seriesRangeEnd = []
    gl.seriesRange = []
    gl.seriesPercent = []
    gl.seriesGoals = []
    gl.seriesX = []
    gl.seriesZ = []
    gl.seriesNames = []
    gl.seriesTotals = []
    gl.seriesLog = []
    gl.seriesColors = []
    gl.stackedSeriesTotals = []
    gl.seriesXvalues = []
    gl.seriesYvalues = []

    gl.labels = []
    gl.hasGroups = false
    gl.groups = []
    gl.categoryLabels = []
    gl.timescaleLabels = []
    gl.noLabelsProvided = false
    gl.resizeTimer = null
    gl.selectionResizeTimer = null
    gl.delayedElements = []
    gl.pointsArray = []
    gl.dataLabelsRects = []
    gl.isXNumeric = false
    gl.skipLastTimelinelabel = false
    gl.skipFirstTimelinelabel = false
    gl.isDataXYZ = false
    gl.isMultiLineX = false
    gl.isMultipleYAxis = false
    gl.maxY = -Number.MAX_VALUE
    gl.minY = Number.MIN_VALUE
    gl.minYArr = []
    gl.maxYArr = []
    gl.maxX = -Number.MAX_VALUE
    gl.minX = Number.MAX_VALUE
    gl.initialMaxX = -Number.MAX_VALUE
    gl.initialMinX = Number.MAX_VALUE
    gl.maxDate = 0
    gl.minDate = Number.MAX_VALUE
    gl.minZ = Number.MAX_VALUE
    gl.maxZ = -Number.MAX_VALUE
    gl.minXDiff = Number.MAX_VALUE
    gl.yAxisScale = []
    gl.xAxisScale = null
    gl.xAxisTicksPositions = []
    gl.yLabelsCoords = []
    gl.yTitleCoords = []
    gl.barPadForNumericAxis = 0
    gl.padHorizontal = 0
    gl.xRange = 0
    gl.yRange = []
    gl.zRange = 0
    gl.dataPoints = 0
    gl.xTickAmount = 0
  }

  globalVars(config) {
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
      zoomEnabled:
        config.chart.toolbar.autoSelected === 'zoom' &&
        config.chart.toolbar.tools.zoom &&
        config.chart.zoom.enabled,
      panEnabled:
        config.chart.toolbar.autoSelected === 'pan' &&
        config.chart.toolbar.tools.pan,
      selectionEnabled:
        config.chart.toolbar.autoSelected === 'selection' &&
        config.chart.toolbar.tools.selection,
      yaxis: null,
      mousedown: false,
      lastClientPosition: {},
      visibleXRange: undefined,
      yValueDecimal: 0,
      total: 0,
      SVGNS: 'http://www.w3.org/2000/svg',
      svgWidth: 0,
      svgHeight: 0,
      noData: false,
      locale: {},
      dom: {},
      memory: {
        methodsToExec: []
      },
      shouldAnimate: true,
      skipLastTimelinelabel: false,
      skipFirstTimelinelabel: false,
      delayedElements: [],
      axisCharts: true,

      isDataXYZ: false,
      resized: false,
      resizeTimer: null,

      comboCharts: false,
      dataChanged: false,
      previousPaths: [],

      allSeriesHasEqualX: true,
      pointsArray: [],

      dataLabelsRects: [],
      lastDrawnDataLabelsIndexes: [],
      hasNullValues: false,
      easing: null,
      zoomed: false,
      gridWidth: 0,
      gridHeight: 0,
      rotateXLabels: false,
      defaultLabels: false,
      xLabelFormatter: undefined,
      yLabelFormatters: [],
      xaxisTooltipFormatter: undefined,
      ttKeyFormatter: undefined,
      ttVal: undefined,
      ttZFormatter: undefined,
      LINE_HEIGHT_RATIO: 1.618,
      xAxisLabelsHeight: 0,
      xAxisGroupLabelsHeight: 0,
      xAxisLabelsWidth: 0,
      yAxisLabelsWidth: 0,
      scaleX: 1,
      scaleY: 1,
      translateX: 0,
      translateY: 0,
      translateYAxisX: [],
      yAxisWidths: [],
      translateXAxisY: 0,
      translateXAxisX: 0,
      tooltip: null
    }
  }

  init(config) {
    let globals = this.globalVars(config)
    this.initGlobalVars(globals)

    globals.initialConfig = Utils.extend({}, config)
    globals.initialSeries = Utils.clone(config.series)

    globals.lastXAxis = Utils.clone(globals.initialConfig.xaxis)
    globals.lastYAxis = Utils.clone(globals.initialConfig.yaxis)
    return globals
  }
}
