import Data from '../modules/Data'
import AxesUtils from '../modules/axes/AxesUtils'
import Series from '../modules/Series'
import Utils from '../utils/Utils'

class Exports {
  constructor(ctx) {
    this.ctx = ctx
    this.w = ctx.w
  }

  scaleSvgNode(svg, scale) {

    let svgWidth = parseFloat(svg.getAttributeNS(null, 'width'))
    let svgHeight = parseFloat(svg.getAttributeNS(null, 'height'))

    svg.setAttributeNS(null, 'width', svgWidth * scale)
    svg.setAttributeNS(null, 'height', svgHeight * scale)
    svg.setAttributeNS(null, 'viewBox', '0 0 ' + svgWidth + ' ' + svgHeight)
  }

  fixSvgStringForIe11(svgData) {

    if (!Utils.isIE11()) {

      return svgData.replace(/&nbsp;/g, '&#160;')
    }
    let nXmlnsSeen = 0
    let result = svgData.replace(
      /xmlns="http:\/\/www.w3.org\/2000\/svg"/g,
      (match) => {
        nXmlnsSeen++
        return nXmlnsSeen === 2
          ? 'xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"'
          : match
      }
    )
    result = result.replace(/xmlns:NS\d+=""/g, '')

    result = result.replace(/NS\d+:(\w+:\w+=")/g, '$1')

    return result
  }

  getSvgString(scale) {
    if (scale == undefined) {
      scale = 1
    }
    let svgString = this.w.globals.dom.Paper.svg()

    if (scale !== 1) {

      const svgNode = this.w.globals.dom.Paper.node.cloneNode(true)

      this.scaleSvgNode(svgNode, scale)

      svgString = new XMLSerializer().serializeToString(svgNode)
    }
    return this.fixSvgStringForIe11(svgString)
  }

  cleanup() {
    const w = this.w
    const xcrosshairs = w.globals.dom.baseEl.getElementsByClassName(
      'apexcharts-xcrosshairs'
    )
    const ycrosshairs = w.globals.dom.baseEl.getElementsByClassName(
      'apexcharts-ycrosshairs'
    )
    const zoomSelectionRects = w.globals.dom.baseEl.querySelectorAll(
      '.apexcharts-zoom-rect, .apexcharts-selection-rect'
    )
    Array.prototype.forEach.call(zoomSelectionRects, (z) => {
      z.setAttribute('width', 0)
    })
    if (xcrosshairs && xcrosshairs[0]) {
      xcrosshairs[0].setAttribute('x', -500)
      xcrosshairs[0].setAttribute('x1', -500)
      xcrosshairs[0].setAttribute('x2', -500)
    }
    if (ycrosshairs && ycrosshairs[0]) {
      ycrosshairs[0].setAttribute('y', -100)
      ycrosshairs[0].setAttribute('y1', -100)
      ycrosshairs[0].setAttribute('y2', -100)
    }
  }

  svgUrl() {
    this.cleanup()

    const svgData = this.getSvgString()
    const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' })
    return URL.createObjectURL(svgBlob)
  }

  dataURI(options) {
    return new Promise((resolve) => {
      const w = this.w

      const scale = options
        ? options.scale || options.width / w.globals.svgWidth
        : 1

      this.cleanup()
      const canvas = document.createElement('canvas')
      canvas.width = w.globals.svgWidth * scale
      canvas.height = parseInt(w.globals.dom.elWrap.style.height, 10) * scale

      const canvasBg =
        w.config.chart.background === 'transparent'
          ? '#fff'
          : w.config.chart.background

      let ctx = canvas.getContext('2d')
      ctx.fillStyle = canvasBg
      ctx.fillRect(0, 0, canvas.width * scale, canvas.height * scale)

      const svgData = this.getSvgString(scale)

      if (window.canvg && Utils.isIE11()) {
        let v = window.canvg.Canvg.fromString(ctx, svgData, {
          ignoreClear: true,
          ignoreDimensions: true
        })

        v.start()

        let blob = canvas.msToBlob()

        v.stop()

        resolve({ blob })
      } else {
        const svgUrl = 'data:image/svg+xml,' + encodeURIComponent(svgData)
        let img = new Image()
        img.crossOrigin = 'anonymous'

        img.onload = () => {
          ctx.drawImage(img, 0, 0)

          if (canvas.msToBlob) {

            let blob = canvas.msToBlob()
            resolve({ blob })
          } else {
            let imgURI = canvas.toDataURL('image/png')
            resolve({ imgURI })
          }
        }

        img.src = svgUrl
      }
    })
  }

  exportToSVG() {
    this.triggerDownload(
      this.svgUrl(),
      this.w.config.chart.toolbar.export.svg.filename,
      '.svg'
    )
  }

  exportToPng() {
    this.dataURI().then(({ imgURI, blob }) => {
      if (blob) {
        navigator.msSaveOrOpenBlob(blob, this.w.globals.chartID + '.png')
      } else {
        this.triggerDownload(
          imgURI,
          this.w.config.chart.toolbar.export.png.filename,
          '.png'
        )
      }
    })
  }

  exportToCSV({
    series,
    fileName,
    columnDelimiter = ',',
    lineDelimiter = '\n'
  }) {
    const w = this.w

    if (!series) series = w.config.series

    let columns = []
    let rows = []
    let result = ''
    let universalBOM = '\uFEFF'
    let gSeries = w.globals.series.map((s, i) => {
      return w.globals.collapsedSeriesIndices.indexOf(i) === -1 ? s : []
    })

    const isTimeStamp = (num) => {
      return w.config.xaxis.type === 'datetime' && String(num).length >= 10
    }
    const seriesMaxDataLength = Math.max(
      ...series.map((s) => {
        return s.data ? s.data.length : 0
      })
    )
    const dataFormat = new Data(this.ctx)

    const axesUtils = new AxesUtils(this.ctx)
    const getCat = (i) => {
      let cat = ''
      if (!w.globals.axisCharts) {
        cat = w.config.labels[i]
      } else {
        if (
          w.config.xaxis.type === 'category' ||
          w.config.xaxis.convertedCatToNumeric
        ) {
          if (w.globals.isBarHorizontal) {
            let lbFormatter = w.globals.yLabelFormatters[0]
            let sr = new Series(this.ctx)
            let activeSeries = sr.getActiveConfigSeriesIndex()

            cat = lbFormatter(w.globals.labels[i], {
              seriesIndex: activeSeries,
              dataPointIndex: i,
              w
            })
          } else {
            cat = axesUtils.getLabel(
              w.globals.labels,
              w.globals.timescaleLabels,
              0,
              i
            ).text
          }
        }
        if (w.config.xaxis.type === 'datetime') {
          if (w.config.xaxis.categories.length) {
            cat = w.config.xaxis.categories[i]
          } else if (w.config.labels.length) {
            cat = w.config.labels[i]
          }
        }
      }

      if (Array.isArray(cat)) {
        cat = cat.join(' ')
      }

      return Utils.isNumber(cat) ? cat : cat.split(columnDelimiter).join('')
    }
    const getEmptyDataForCsvColumn = () => {
      return [...Array(seriesMaxDataLength)].map(() => '')
    }

    const handleAxisRowsColumns = (s, sI) => {
      if (columns.length && sI === 0) {

        rows.push(columns.join(columnDelimiter))
      }

      if (s.data) {

        s.data = (s.data.length && s.data) || getEmptyDataForCsvColumn()
        for (let i = 0; i < s.data.length; i++) {

          columns = []

          let cat = getCat(i)
          if (!cat) {
            if (dataFormat.isFormatXY()) {
              cat = series[sI].data[i].x
            } else if (dataFormat.isFormat2DArray()) {
              cat = series[sI].data[i] ? series[sI].data[i][0] : ''
            }
          }

          if (sI === 0) {

            columns.push(
              isTimeStamp(cat)
                ? w.config.chart.toolbar.export.csv.dateFormatter(cat)
                : Utils.isNumber(cat)
                  ? cat
                  : cat.split(columnDelimiter).join('')
            )

            for (let ci = 0; ci < w.globals.series.length; ci++) {
              if (dataFormat.isFormatXY()) {
                columns.push(series[ci].data[i].y)
              } else {
                columns.push(gSeries[ci][i])
              }
            }
          }

          if (
            w.config.chart.type === 'candlestick' ||
            (s.type && s.type === 'candlestick')
          ) {
            columns.pop()
            columns.push(w.globals.seriesCandleO[sI][i])
            columns.push(w.globals.seriesCandleH[sI][i])
            columns.push(w.globals.seriesCandleL[sI][i])
            columns.push(w.globals.seriesCandleC[sI][i])
          }

          if (
            w.config.chart.type === 'boxPlot' ||
            (s.type && s.type === 'boxPlot')
          ) {
            columns.pop()
            columns.push(w.globals.seriesCandleO[sI][i])
            columns.push(w.globals.seriesCandleH[sI][i])
            columns.push(w.globals.seriesCandleM[sI][i])
            columns.push(w.globals.seriesCandleL[sI][i])
            columns.push(w.globals.seriesCandleC[sI][i])
          }

          if (w.config.chart.type === 'rangeBar') {
            columns.pop()
            columns.push(w.globals.seriesRangeStart[sI][i])
            columns.push(w.globals.seriesRangeEnd[sI][i])
          }

          if (columns.length) {
            rows.push(columns.join(columnDelimiter))
          }
        }
      }
    }

    columns.push(w.config.chart.toolbar.export.csv.headerCategory)

    if (w.config.chart.type === 'boxPlot') {
      columns.push('minimum')
      columns.push('q1')
      columns.push('median')
      columns.push('q3')
      columns.push('maximum')
    } else if (w.config.chart.type === 'candlestick') {
      columns.push('open')
      columns.push('high')
      columns.push('low')
      columns.push('close')
    } else if (w.config.chart.type === 'rangeBar') {
      columns.push('minimum')
      columns.push('maximum')
    } else {
      series.map((s, sI) => {
        const sname = s.name ? s.name : `series-${sI}`
        if (w.globals.axisCharts) {
          columns.push(
            sname.split(columnDelimiter).join('')
              ? sname.split(columnDelimiter).join('')
              : `series-${sI}`
          )
        }
      })
    }

    if (!w.globals.axisCharts) {
      columns.push(w.config.chart.toolbar.export.csv.headerValue)
      rows.push(columns.join(columnDelimiter))
    }
    series.map((s, sI) => {
      if (w.globals.axisCharts) {
        handleAxisRowsColumns(s, sI)
      } else {
        columns = []

        columns.push(w.globals.labels[sI].split(columnDelimiter).join(''))
        columns.push(gSeries[sI])
        rows.push(columns.join(columnDelimiter))
      }
    })

    result += rows.join(lineDelimiter)

    this.triggerDownload(
      'data:text/csv; charset=utf-8,' +
      encodeURIComponent(universalBOM + result),
      fileName ? fileName : w.config.chart.toolbar.export.csv.filename,
      '.csv'
    )
  }

  triggerDownload(href, filename, ext) {
    const downloadLink = document.createElement('a')
    downloadLink.href = href
    downloadLink.download = (filename ? filename : this.w.globals.chartID) + ext
    document.body.appendChild(downloadLink)
    downloadLink.click()
    document.body.removeChild(downloadLink)
  }
}

export default Exports
