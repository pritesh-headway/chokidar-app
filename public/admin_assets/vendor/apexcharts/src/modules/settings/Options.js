/**
 * ApexCharts Options for setting the initial configuration of ApexCharts
 **/
import en from './../../locales/en.json'

export default class Options {
  constructor() {
    this.yAxis = {
      show: true,
      showAlways: false,
      showForNullSeries: true,
      seriesName: undefined,
      opposite: false,
      reversed: false,
      logarithmic: false,
      logBase: 10,
      tickAmount: undefined,
      forceNiceScale: false,
      max: undefined,
      min: undefined,
      floating: false,
      decimalsInFloat: undefined,
      labels: {
        show: true,
        minWidth: 0,
        maxWidth: 160,
        offsetX: 0,
        offsetY: 0,
        align: undefined,
        rotate: 0,
        padding: 20,
        style: {
          colors: [],
          fontSize: '11px',
          fontWeight: 400,
          fontFamily: undefined,
          cssClass: ''
        },
        formatter: undefined
      },
      axisBorder: {
        show: false,
        color: '#e0e0e0',
        width: 1,
        offsetX: 0,
        offsetY: 0
      },
      axisTicks: {
        show: false,
        color: '#e0e0e0',
        width: 6,
        offsetX: 0,
        offsetY: 0
      },
      title: {
        text: undefined,
        rotate: -90,
        offsetY: 0,
        offsetX: 0,
        style: {
          color: undefined,
          fontSize: '11px',
          fontWeight: 900,
          fontFamily: undefined,
          cssClass: ''
        }
      },
      tooltip: {
        enabled: false,
        offsetX: 0
      },
      crosshairs: {
        show: true,
        position: 'front',
        stroke: {
          color: '#b6b6b6',
          width: 1,
          dashArray: 0
        }
      }
    }

    this.pointAnnotation = {
      id: undefined,
      x: 0,
      y: null,
      yAxisIndex: 0,
      seriesIndex: 0,
      mouseEnter: undefined,
      mouseLeave: undefined,
      click: undefined,
      marker: {
        size: 4,
        fillColor: '#fff',
        strokeWidth: 2,
        strokeColor: '#333',
        shape: 'circle',
        offsetX: 0,
        offsetY: 0,
        radius: 2,
        cssClass: ''
      },
      label: {
        borderColor: '#c2c2c2',
        borderWidth: 1,
        borderRadius: 2,
        text: undefined,
        textAnchor: 'middle',
        offsetX: 0,
        offsetY: 0,
        mouseEnter: undefined,
        mouseLeave: undefined,
        click: undefined,
        style: {
          background: '#fff',
          color: undefined,
          fontSize: '11px',
          fontFamily: undefined,
          fontWeight: 400,
          cssClass: '',
          padding: {
            left: 5,
            right: 5,
            top: 2,
            bottom: 2
          }
        }
      },
      customSVG: {

        SVG: undefined,
        cssClass: undefined,
        offsetX: 0,
        offsetY: 0
      },
      image: {
        path: undefined,
        width: 20,
        height: 20,
        offsetX: 0,
        offsetY: 0
      }
    }

    this.yAxisAnnotation = {
      id: undefined,
      y: 0,
      y2: null,
      strokeDashArray: 1,
      fillColor: '#c2c2c2',
      borderColor: '#c2c2c2',
      borderWidth: 1,
      opacity: 0.3,
      offsetX: 0,
      offsetY: 0,
      width: '100%',
      yAxisIndex: 0,
      label: {
        borderColor: '#c2c2c2',
        borderWidth: 1,
        borderRadius: 2,
        text: undefined,
        textAnchor: 'end',
        position: 'right',
        offsetX: 0,
        offsetY: -3,
        mouseEnter: undefined,
        mouseLeave: undefined,
        click: undefined,
        style: {
          background: '#fff',
          color: undefined,
          fontSize: '11px',
          fontFamily: undefined,
          fontWeight: 400,
          cssClass: '',
          padding: {
            left: 5,
            right: 5,
            top: 2,
            bottom: 2
          }
        }
      }
    }

    this.xAxisAnnotation = {
      id: undefined,
      x: 0,
      x2: null,
      strokeDashArray: 1,
      fillColor: '#c2c2c2',
      borderColor: '#c2c2c2',
      borderWidth: 1,
      opacity: 0.3,
      offsetX: 0,
      offsetY: 0,
      label: {
        borderColor: '#c2c2c2',
        borderWidth: 1,
        borderRadius: 2,
        text: undefined,
        textAnchor: 'middle',
        orientation: 'vertical',
        position: 'top',
        offsetX: 0,
        offsetY: 0,
        mouseEnter: undefined,
        mouseLeave: undefined,
        click: undefined,
        style: {
          background: '#fff',
          color: undefined,
          fontSize: '11px',
          fontFamily: undefined,
          fontWeight: 400,
          cssClass: '',
          padding: {
            left: 5,
            right: 5,
            top: 2,
            bottom: 2
          }
        }
      }
    }

    this.text = {
      x: 0,
      y: 0,
      text: '',
      textAnchor: 'start',
      foreColor: undefined,
      fontSize: '13px',
      fontFamily: undefined,
      fontWeight: 400,
      appendTo: '.apexcharts-annotations',
      backgroundColor: 'transparent',
      borderColor: '#c2c2c2',
      borderRadius: 0,
      borderWidth: 0,
      paddingLeft: 4,
      paddingRight: 4,
      paddingTop: 2,
      paddingBottom: 2
    }
  }
  init() {
    return {
      annotations: {
        yaxis: [this.yAxisAnnotation],
        xaxis: [this.xAxisAnnotation],
        points: [this.pointAnnotation],
        texts: [],
        images: [],
        shapes: []
      },
      chart: {
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
            delay: 150,
            enabled: true
          },
          dynamicAnimation: {
            enabled: true,
            speed: 350
          }
        },
        background: 'transparent',
        locales: [en],
        defaultLocale: 'en',
        dropShadow: {
          enabled: false,
          enabledOnSeries: undefined,
          top: 2,
          left: 2,
          blur: 4,
          color: '#000',
          opacity: 0.35
        },
        events: {
          animationEnd: undefined,
          beforeMount: undefined,
          mounted: undefined,
          updated: undefined,
          click: undefined,
          mouseMove: undefined,
          mouseLeave: undefined,
          xAxisLabelClick: undefined,
          legendClick: undefined,
          markerClick: undefined,
          selection: undefined,
          dataPointSelection: undefined,
          dataPointMouseEnter: undefined,
          dataPointMouseLeave: undefined,
          beforeZoom: undefined,
          beforeResetZoom: undefined,
          zoomed: undefined,
          scrolled: undefined,
          brushScrolled: undefined
        },
        foreColor: '#373d3f',
        fontFamily: 'Helvetica, Arial, sans-serif',
        height: 'auto',
        parentHeightOffset: 15,
        redrawOnParentResize: true,
        redrawOnWindowResize: true,
        id: undefined,
        group: undefined,
        offsetX: 0,
        offsetY: 0,
        selection: {
          enabled: false,
          type: 'x',

          fill: {
            color: '#24292e',
            opacity: 0.1
          },
          stroke: {
            width: 1,
            color: '#24292e',
            opacity: 0.4,
            dashArray: 3
          },
          xaxis: {
            min: undefined,
            max: undefined
          },
          yaxis: {
            min: undefined,
            max: undefined
          }
        },
        sparkline: {
          enabled: false
        },
        brush: {
          enabled: false,
          autoScaleYaxis: true,
          target: undefined
        },
        stacked: false,
        stackType: 'normal',
        toolbar: {
          show: true,
          offsetX: 0,
          offsetY: 0,
          tools: {
            download: true,
            selection: true,
            zoom: true,
            zoomin: true,
            zoomout: true,
            pan: true,
            reset: true,
            customIcons: []
          },
          export: {
            csv: {
              filename: undefined,
              columnDelimiter: ',',
              headerCategory: 'category',
              headerValue: 'value',
              dateFormatter(timestamp) {
                return new Date(timestamp).toDateString()
              }
            },
            png: {
              filename: undefined
            },
            svg: {
              filename: undefined
            }
          },
          autoSelected: 'zoom'
        },
        type: 'line',
        width: '100%',
        zoom: {
          enabled: true,
          type: 'x',
          autoScaleYaxis: false,
          zoomedArea: {
            fill: {
              color: '#90CAF9',
              opacity: 0.4
            },
            stroke: {
              color: '#0D47A1',
              opacity: 0.4,
              width: 1
            }
          }
        }
      },
      plotOptions: {
        area: {
          fillTo: 'origin'
        },
        bar: {
          horizontal: false,
          columnWidth: '70%',
          barHeight: '70%',
          distributed: false,
          borderRadius: 0,
          borderRadiusApplication: 'around',
          borderRadiusWhenStacked: 'last',
          rangeBarOverlap: true,
          rangeBarGroupRows: false,
          hideZeroBarsWhenGrouped: false,
          colors: {
            ranges: [],
            backgroundBarColors: [],
            backgroundBarOpacity: 1,
            backgroundBarRadius: 0
          },
          dataLabels: {
            position: 'top',
            maxItems: 100,
            hideOverflowingLabels: true,
            orientation: 'horizontal',
            total: {
              enabled: false,
              formatter: undefined,
              offsetX: 0,
              offsetY: 0,
              style: {
                color: '#373d3f',
                fontSize: '12px',
                fontFamily: undefined,
                fontWeight: 600
              }
            }
          }
        },
        bubble: {
          zScaling: true,
          minBubbleRadius: undefined,
          maxBubbleRadius: undefined
        },
        candlestick: {
          colors: {
            upward: '#00B746',
            downward: '#EF403C'
          },
          wick: {
            useFillColor: true
          }
        },
        boxPlot: {
          colors: {
            upper: '#00E396',
            lower: '#008FFB'
          }
        },
        heatmap: {
          radius: 2,
          enableShades: true,
          shadeIntensity: 0.5,
          reverseNegativeShade: false,
          distributed: false,
          useFillColorAsStroke: false,
          colorScale: {
            inverse: false,
            ranges: [],
            min: undefined,
            max: undefined
          }
        },
        treemap: {
          enableShades: true,
          shadeIntensity: 0.5,
          distributed: false,
          reverseNegativeShade: false,
          useFillColorAsStroke: false,
          colorScale: {
            inverse: false,
            ranges: [],
            min: undefined,
            max: undefined
          }
        },
        radialBar: {
          inverseOrder: false,
          startAngle: 0,
          endAngle: 360,
          offsetX: 0,
          offsetY: 0,
          hollow: {
            margin: 5,
            size: '50%',
            background: 'transparent',
            image: undefined,
            imageWidth: 150,
            imageHeight: 150,
            imageOffsetX: 0,
            imageOffsetY: 0,
            imageClipped: true,
            position: 'front',
            dropShadow: {
              enabled: false,
              top: 0,
              left: 0,
              blur: 3,
              color: '#000',
              opacity: 0.5
            }
          },
          track: {
            show: true,
            startAngle: undefined,
            endAngle: undefined,
            background: '#f2f2f2',
            strokeWidth: '97%',
            opacity: 1,
            margin: 5,
            dropShadow: {
              enabled: false,
              top: 0,
              left: 0,
              blur: 3,
              color: '#000',
              opacity: 0.5
            }
          },
          dataLabels: {
            show: true,
            name: {
              show: true,
              fontSize: '16px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 0,
              formatter(val) {
                return val
              }
            },
            value: {
              show: true,
              fontSize: '14px',
              fontFamily: undefined,
              fontWeight: 400,
              color: undefined,
              offsetY: 16,
              formatter(val) {
                return val + '%'
              }
            },
            total: {
              show: false,
              label: 'Total',
              fontSize: '16px',
              fontWeight: 600,
              fontFamily: undefined,
              color: undefined,
              formatter(w) {
                return (
                  w.globals.seriesTotals.reduce((a, b) => a + b, 0) /
                  w.globals.series.length +
                  '%'
                )
              }
            }
          }
        },
        pie: {
          customScale: 1,
          offsetX: 0,
          offsetY: 0,
          startAngle: 0,
          endAngle: 360,
          expandOnClick: true,
          dataLabels: {

            offset: 0,
            minAngleToShowLabel: 10
          },
          donut: {
            size: '65%',
            background: 'transparent',
            labels: {

              show: false,
              name: {
                show: true,
                fontSize: '16px',
                fontFamily: undefined,
                fontWeight: 600,
                color: undefined,
                offsetY: -10,
                formatter(val) {
                  return val
                }
              },
              value: {
                show: true,
                fontSize: '20px',
                fontFamily: undefined,
                fontWeight: 400,
                color: undefined,
                offsetY: 10,
                formatter(val) {
                  return val
                }
              },
              total: {
                show: false,
                showAlways: false,
                label: 'Total',
                fontSize: '16px',
                fontWeight: 400,
                fontFamily: undefined,
                color: undefined,
                formatter(w) {
                  return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                }
              }
            }
          }
        },
        polarArea: {
          rings: {
            strokeWidth: 1,
            strokeColor: '#e8e8e8'
          },
          spokes: {
            strokeWidth: 1,
            connectorColors: '#e8e8e8'
          }
        },
        radar: {
          size: undefined,
          offsetX: 0,
          offsetY: 0,
          polygons: {

            strokeWidth: 1,
            strokeColors: '#e8e8e8',
            connectorColors: '#e8e8e8',
            fill: {
              colors: undefined
            }
          }
        }
      },
      colors: undefined,
      dataLabels: {
        enabled: true,
        enabledOnSeries: undefined,
        formatter(val) {
          return val !== null ? val : ''
        },
        textAnchor: 'middle',
        distributed: false,
        offsetX: 0,
        offsetY: 0,
        style: {
          fontSize: '12px',
          fontFamily: undefined,
          fontWeight: 600,
          colors: undefined
        },
        background: {
          enabled: true,
          foreColor: '#fff',
          borderRadius: 2,
          padding: 4,
          opacity: 0.9,
          borderWidth: 1,
          borderColor: '#fff',
          dropShadow: {
            enabled: false,
            top: 1,
            left: 1,
            blur: 1,
            color: '#000',
            opacity: 0.45
          }
        },
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          color: '#000',
          opacity: 0.45
        }
      },
      fill: {
        type: 'solid',
        colors: undefined,
        opacity: 0.85,
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: undefined,
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 50, 100],
          colorStops: []
        },
        image: {
          src: [],
          width: undefined,
          height: undefined
        },
        pattern: {
          style: 'squares',
          width: 6,
          height: 6,
          strokeWidth: 2
        }
      },
      forecastDataPoints: {
        count: 0,
        fillOpacity: 0.5,
        strokeWidth: undefined,
        dashArray: 4
      },
      grid: {
        show: true,
        borderColor: '#e0e0e0',
        strokeDashArray: 0,
        position: 'back',
        xaxis: {
          lines: {
            show: false
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        },
        row: {
          colors: undefined,
          opacity: 0.5
        },
        column: {
          colors: undefined,
          opacity: 0.5
        },
        padding: {
          top: 0,
          right: 10,
          bottom: 0,
          left: 12
        }
      },
      labels: [],
      legend: {
        show: true,
        showForSingleSeries: false,
        showForNullSeries: true,
        showForZeroSeries: true,
        floating: false,
        position: 'bottom',

        horizontalAlign: 'center',
        inverseOrder: false,
        fontSize: '12px',
        fontFamily: undefined,
        fontWeight: 400,
        width: undefined,
        height: undefined,
        formatter: undefined,
        tooltipHoverFormatter: undefined,
        offsetX: -20,
        offsetY: 4,
        customLegendItems: [],
        labels: {
          colors: undefined,
          useSeriesColors: false
        },
        markers: {
          width: 12,
          height: 12,
          strokeWidth: 0,
          fillColors: undefined,
          strokeColor: '#fff',
          radius: 12,
          customHTML: undefined,
          offsetX: 0,
          offsetY: 0,
          onClick: undefined
        },
        itemMargin: {
          horizontal: 5,
          vertical: 2
        },
        onItemClick: {
          toggleDataSeries: true
        },
        onItemHover: {
          highlightDataSeries: true
        }
      },
      markers: {
        discrete: [],
        size: 0,
        colors: undefined,
        //strokeColor: '#fff',
        strokeColors: '#fff',
        strokeWidth: 2,
        strokeOpacity: 0.9,
        strokeDashArray: 0,
        fillOpacity: 1,
        shape: 'circle',
        width: 8,
        height: 8,
        radius: 2,
        offsetX: 0,
        offsetY: 0,
        onClick: undefined,
        onDblClick: undefined,
        showNullDataPoints: true,
        hover: {
          size: undefined,
          sizeOffset: 3
        }
      },
      noData: {
        text: undefined,
        align: 'center',
        verticalAlign: 'middle',
        offsetX: 0,
        offsetY: 0,
        style: {
          color: undefined,
          fontSize: '14px',
          fontFamily: undefined
        }
      },
      responsive: [],
      series: undefined,
      states: {
        normal: {
          filter: {
            type: 'none',
            value: 0
          }
        },
        hover: {
          filter: {
            type: 'lighten',
            value: 0.1
          }
        },
        active: {
          allowMultipleDataPointsSelection: false,
          filter: {
            type: 'darken',
            value: 0.5
          }
        }
      },
      title: {
        text: undefined,
        align: 'left',
        margin: 5,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
          fontSize: '14px',
          fontWeight: 900,
          fontFamily: undefined,
          color: undefined
        }
      },
      subtitle: {
        text: undefined,
        align: 'left',
        margin: 5,
        offsetX: 0,
        offsetY: 30,
        floating: false,
        style: {
          fontSize: '12px',
          fontWeight: 400,
          fontFamily: undefined,
          color: undefined
        }
      },
      stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        width: 2,
        colors: undefined,
        dashArray: 0,
        fill: {
          type: 'solid',
          colors: undefined,
          opacity: 0.85,
          gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 100],
            colorStops: []
          }
        }
      },
      tooltip: {
        enabled: true,
        enabledOnSeries: undefined,
        shared: true,
        followCursor: false,
        intersect: false,
        inverseOrder: false,
        custom: undefined,
        fillSeriesColor: false,
        theme: 'light',
        cssClass: '',
        style: {
          fontSize: '12px',
          fontFamily: undefined
        },
        onDatasetHover: {
          highlightDataSeries: false
        },
        x: {

          show: true,
          format: 'dd MMM',
          formatter: undefined
        },
        y: {
          formatter: undefined,
          title: {
            formatter(seriesName) {
              return seriesName ? seriesName + ': ' : ''
            }
          }
        },
        z: {
          formatter: undefined,
          title: 'Size: '
        },
        marker: {
          show: true,
          fillColors: undefined
        },
        items: {
          display: 'flex'
        },
        fixed: {
          enabled: false,
          position: 'topRight',
          offsetX: 0,
          offsetY: 0
        }
      },
      xaxis: {
        type: 'category',
        categories: [],
        convertedCatToNumeric: false,
        offsetX: 0,
        offsetY: 0,
        overwriteCategories: undefined,
        labels: {
          show: true,
          rotate: -45,
          rotateAlways: false,
          hideOverlappingLabels: true,
          trim: false,
          minHeight: undefined,
          maxHeight: 120,
          showDuplicates: true,
          style: {
            colors: [],
            fontSize: '12px',
            fontWeight: 400,
            fontFamily: undefined,
            cssClass: ''
          },
          offsetX: 0,
          offsetY: 0,
          format: undefined,
          formatter: undefined,
          datetimeUTC: true,
          datetimeFormatter: {
            year: 'yyyy',
            month: "MMM 'yy",
            day: 'dd MMM',
            hour: 'HH:mm',
            minute: 'HH:mm:ss',
            second: 'HH:mm:ss'
          }
        },
        group: {
          groups: [],
          style: {
            colors: [],
            fontSize: '12px',
            fontWeight: 400,
            fontFamily: undefined,
            cssClass: ''
          }
        },
        axisBorder: {
          show: true,
          color: '#e0e0e0',
          width: '100%',
          height: 1,
          offsetX: 0,
          offsetY: 0
        },
        axisTicks: {
          show: true,
          color: '#e0e0e0',
          height: 6,
          offsetX: 0,
          offsetY: 0
        },
        tickAmount: undefined,
        tickPlacement: 'on',
        min: undefined,
        max: undefined,
        range: undefined,
        floating: false,
        decimalsInFloat: undefined,
        position: 'bottom',
        title: {
          text: undefined,
          offsetX: 0,
          offsetY: 0,
          style: {
            color: undefined,
            fontSize: '12px',
            fontWeight: 900,
            fontFamily: undefined,
            cssClass: ''
          }
        },
        crosshairs: {
          show: true,
          width: 1,
          position: 'back',
          opacity: 0.9,
          stroke: {
            color: '#b6b6b6',
            width: 1,
            dashArray: 3
          },
          fill: {
            type: 'solid',
            color: '#B1B9C4',
            gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5
            }
          },
          dropShadow: {
            enabled: false,
            left: 0,
            top: 0,
            blur: 1,
            opacity: 0.4
          }
        },
        tooltip: {
          enabled: true,
          offsetY: 0,
          formatter: undefined,
          style: {
            fontSize: '12px',
            fontFamily: undefined
          }
        }
      },
      yaxis: this.yAxis,
      theme: {
        mode: 'light',
        palette: 'palette1',
        monochrome: {

          enabled: false,
          color: '#008FFB',
          shadeTo: 'light',
          shadeIntensity: 0.65
        }
      }
    }
  }
}
