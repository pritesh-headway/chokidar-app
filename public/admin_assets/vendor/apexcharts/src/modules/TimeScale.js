import DateTime from '../utils/DateTime'
import Dimensions from './dimensions/Dimensions'
import Graphics from './Graphics'
import Utils from '../utils/Utils'

const MINUTES_IN_DAY = 24 * 60
const SECONDS_IN_DAY = MINUTES_IN_DAY * 60
const MIN_ZOOM_DAYS = 10 / SECONDS_IN_DAY

/**
 * ApexCharts TimeScale Class for generating time ticks for x-axis.
 *
 * @module TimeScale
 **/

class TimeScale {
  constructor(ctx) {
    this.ctx = ctx
    this.w = ctx.w
    this.timeScaleArray = []
    this.utc = this.w.config.xaxis.labels.datetimeUTC
  }

  calculateTimeScaleTicks(minX, maxX) {
    let w = this.w
    if (w.globals.allSeriesCollapsed) {
      w.globals.labels = []
      w.globals.timescaleLabels = []
      return []
    }

    let dt = new DateTime(this.ctx)

    const daysDiff = (maxX - minX) / (1000 * SECONDS_IN_DAY)
    this.determineInterval(daysDiff)

    w.globals.disableZoomIn = false
    w.globals.disableZoomOut = false

    if (daysDiff < MIN_ZOOM_DAYS) {
      w.globals.disableZoomIn = true
    } else if (daysDiff > 50000) {
      w.globals.disableZoomOut = true
    }

    const timeIntervals = dt.getTimeUnitsfromTimestamp(minX, maxX, this.utc)

    const daysWidthOnXAxis = w.globals.gridWidth / daysDiff
    const hoursWidthOnXAxis = daysWidthOnXAxis / 24
    const minutesWidthOnXAxis = hoursWidthOnXAxis / 60
    const secondsWidthOnXAxis = minutesWidthOnXAxis / 60

    let numberOfHours = Math.floor(daysDiff * 24)
    let numberOfMinutes = Math.floor(daysDiff * MINUTES_IN_DAY)
    let numberOfSeconds = Math.floor(daysDiff * SECONDS_IN_DAY)
    let numberOfDays = Math.floor(daysDiff)
    let numberOfMonths = Math.floor(daysDiff / 30)
    let numberOfYears = Math.floor(daysDiff / 365)

    const firstVal = {
      minMillisecond: timeIntervals.minMillisecond,
      minSecond: timeIntervals.minSecond,
      minMinute: timeIntervals.minMinute,
      minHour: timeIntervals.minHour,
      minDate: timeIntervals.minDate,
      minMonth: timeIntervals.minMonth,
      minYear: timeIntervals.minYear
    }

    let currentMillisecond = firstVal.minMillisecond
    let currentSecond = firstVal.minSecond
    let currentMinute = firstVal.minMinute
    let currentHour = firstVal.minHour
    let currentMonthDate = firstVal.minDate
    let currentDate = firstVal.minDate
    let currentMonth = firstVal.minMonth
    let currentYear = firstVal.minYear

    const params = {
      firstVal,
      currentMillisecond,
      currentSecond,
      currentMinute,
      currentHour,
      currentMonthDate,
      currentDate,
      currentMonth,
      currentYear,
      daysWidthOnXAxis,
      hoursWidthOnXAxis,
      minutesWidthOnXAxis,
      secondsWidthOnXAxis,
      numberOfSeconds,
      numberOfMinutes,
      numberOfHours,
      numberOfDays,
      numberOfMonths,
      numberOfYears
    }

    switch (this.tickInterval) {
      case 'years': {
        this.generateYearScale(params)
        break
      }
      case 'months':
      case 'half_year': {
        this.generateMonthScale(params)
        break
      }
      case 'months_days':
      case 'months_fortnight':
      case 'days':
      case 'week_days': {
        this.generateDayScale(params)
        break
      }
      case 'hours': {
        this.generateHourScale(params)
        break
      }
      case 'minutes_fives':
      case 'minutes':
        this.generateMinuteScale(params)
        break
      case 'seconds_tens':
      case 'seconds_fives':
      case 'seconds':
        this.generateSecondScale(params)
        break
    }
    const adjustedMonthInTimeScaleArray = this.timeScaleArray.map((ts) => {
      let defaultReturn = {
        position: ts.position,
        unit: ts.unit,
        year: ts.year,
        day: ts.day ? ts.day : 1,
        hour: ts.hour ? ts.hour : 0,
        month: ts.month + 1
      }
      if (ts.unit === 'month') {
        return {
          ...defaultReturn,
          day: 1,
          value: ts.value + 1
        }
      } else if (ts.unit === 'day' || ts.unit === 'hour') {
        return {
          ...defaultReturn,
          value: ts.value
        }
      } else if (ts.unit === 'minute') {
        return {
          ...defaultReturn,
          value: ts.value,
          minute: ts.value
        }
      } else if (ts.unit === 'second') {
        return {
          ...defaultReturn,
          value: ts.value,
          minute: ts.minute,
          second: ts.second
        }
      }

      return ts
    })

    const filteredTimeScale = adjustedMonthInTimeScaleArray.filter((ts) => {
      let modulo = 1
      let ticks = Math.ceil(w.globals.gridWidth / 120)
      let value = ts.value
      if (w.config.xaxis.tickAmount !== undefined) {
        ticks = w.config.xaxis.tickAmount
      }
      if (adjustedMonthInTimeScaleArray.length > ticks) {
        modulo = Math.floor(adjustedMonthInTimeScaleArray.length / ticks)
      }

      let shouldNotSkipUnit = false
      let shouldNotPrint = false

      switch (this.tickInterval) {
        case 'years':

          if (ts.unit === 'year') {
            shouldNotSkipUnit = true
          }
          break
        case 'half_year':
          modulo = 7
          if (ts.unit === 'year') {
            shouldNotSkipUnit = true
          }
          break
        case 'months':
          modulo = 1
          if (ts.unit === 'year') {
            shouldNotSkipUnit = true
          }
          break
        case 'months_fortnight':
          modulo = 15
          if (ts.unit === 'year' || ts.unit === 'month') {
            shouldNotSkipUnit = true
          }
          if (value === 30) {
            shouldNotPrint = true
          }
          break
        case 'months_days':
          modulo = 10
          if (ts.unit === 'month') {
            shouldNotSkipUnit = true
          }
          if (value === 30) {
            shouldNotPrint = true
          }
          break
        case 'week_days':
          modulo = 8
          if (ts.unit === 'month') {
            shouldNotSkipUnit = true
          }
          break
        case 'days':
          modulo = 1
          if (ts.unit === 'month') {
            shouldNotSkipUnit = true
          }
          break
        case 'hours':
          if (ts.unit === 'day') {
            shouldNotSkipUnit = true
          }
          break
        case 'minutes_fives':
          if (value % 5 !== 0) {
            shouldNotPrint = true
          }
          break
        case 'seconds_tens':
          if (value % 10 !== 0) {
            shouldNotPrint = true
          }
          break
        case 'seconds_fives':
          if (value % 5 !== 0) {
            shouldNotPrint = true
          }
          break
      }

      if (
        this.tickInterval === 'hours' ||
        this.tickInterval === 'minutes_fives' ||
        this.tickInterval === 'seconds_tens' ||
        this.tickInterval === 'seconds_fives'
      ) {
        if (!shouldNotPrint) {
          return true
        }
      } else {
        if ((value % modulo === 0 || shouldNotSkipUnit) && !shouldNotPrint) {
          return true
        }
      }
    })

    return filteredTimeScale
  }

  recalcDimensionsBasedOnFormat(filteredTimeScale, inverted) {
    const w = this.w
    const reformattedTimescaleArray = this.formatDates(filteredTimeScale)

    const removedOverlappingTS = this.removeOverlappingTS(
      reformattedTimescaleArray
    )

    w.globals.timescaleLabels = removedOverlappingTS.slice()
    let dimensions = new Dimensions(this.ctx)
    dimensions.plotCoords()
  }

  determineInterval(daysDiff) {
    const yearsDiff = daysDiff / 365
    const hoursDiff = daysDiff * 24
    const minutesDiff = hoursDiff * 60
    const secondsDiff = minutesDiff * 60
    switch (true) {
      case yearsDiff > 5:
        this.tickInterval = 'years'
        break
      case daysDiff > 800:
        this.tickInterval = 'half_year'
        break
      case daysDiff > 180:
        this.tickInterval = 'months'
        break
      case daysDiff > 90:
        this.tickInterval = 'months_fortnight'
        break
      case daysDiff > 60:
        this.tickInterval = 'months_days'
        break
      case daysDiff > 30:
        this.tickInterval = 'week_days'
        break
      case daysDiff > 2:
        this.tickInterval = 'days'
        break
      case hoursDiff > 2.4:
        this.tickInterval = 'hours'
        break
      case minutesDiff > 15:
        this.tickInterval = 'minutes_fives'
        break
      case minutesDiff > 5:
        this.tickInterval = 'minutes'
        break
      case minutesDiff > 1:
        this.tickInterval = 'seconds_tens'
        break
      case secondsDiff > 20:
        this.tickInterval = 'seconds_fives'
        break
      default:
        this.tickInterval = 'seconds'
        break
    }
  }

  generateYearScale({
    firstVal,
    currentMonth,
    currentYear,
    daysWidthOnXAxis,
    numberOfYears
  }) {
    let firstTickValue = firstVal.minYear
    let firstTickPosition = 0
    const dt = new DateTime(this.ctx)

    let unit = 'year'

    if (firstVal.minDate > 1 || firstVal.minMonth > 0) {
      let remainingDays = dt.determineRemainingDaysOfYear(
        firstVal.minYear,
        firstVal.minMonth,
        firstVal.minDate
      )
      let remainingDaysOfFirstYear =
        dt.determineDaysOfYear(firstVal.minYear) - remainingDays + 1
      firstTickPosition = remainingDaysOfFirstYear * daysWidthOnXAxis
      firstTickValue = firstVal.minYear + 1

      this.timeScaleArray.push({
        position: firstTickPosition,
        value: firstTickValue,
        unit,
        year: firstTickValue,
        month: Utils.monthMod(currentMonth + 1)
      })
    } else if (firstVal.minDate === 1 && firstVal.minMonth === 0) {

      this.timeScaleArray.push({
        position: firstTickPosition,
        value: firstTickValue,
        unit,
        year: currentYear,
        month: Utils.monthMod(currentMonth + 1)
      })
    }

    let year = firstTickValue
    let pos = firstTickPosition
    for (let i = 0; i < numberOfYears; i++) {
      year++
      pos = dt.determineDaysOfYear(year - 1) * daysWidthOnXAxis + pos
      this.timeScaleArray.push({
        position: pos,
        value: year,
        unit,
        year,
        month: 1
      })
    }
  }

  generateMonthScale({
    firstVal,
    currentMonthDate,
    currentMonth,
    currentYear,
    daysWidthOnXAxis,
    numberOfMonths
  }) {
    let firstTickValue = currentMonth
    let firstTickPosition = 0
    const dt = new DateTime(this.ctx)
    let unit = 'month'
    let yrCounter = 0

    if (firstVal.minDate > 1) {

      let remainingDaysOfFirstMonth =
        dt.determineDaysOfMonths(currentMonth + 1, firstVal.minYear) -
        currentMonthDate +
        1
      firstTickPosition = remainingDaysOfFirstMonth * daysWidthOnXAxis
      firstTickValue = Utils.monthMod(currentMonth + 1)

      let year = currentYear + yrCounter
      let month = Utils.monthMod(firstTickValue)
      let value = firstTickValue

      if (firstTickValue === 0) {
        unit = 'year'
        value = year
        month = 1
        yrCounter += 1
        year = year + yrCounter
      }
      this.timeScaleArray.push({
        position: firstTickPosition,
        value,
        unit,
        year,
        month
      })
    } else {

      this.timeScaleArray.push({
        position: firstTickPosition,
        value: firstTickValue,
        unit,
        year: currentYear,
        month: Utils.monthMod(currentMonth)
      })
    }

    let month = firstTickValue + 1
    let pos = firstTickPosition
    for (let i = 0, j = 1; i < numberOfMonths; i++, j++) {
      month = Utils.monthMod(month)

      if (month === 0) {
        unit = 'year'
        yrCounter += 1
      } else {
        unit = 'month'
      }
      let year = this._getYear(currentYear, month, yrCounter)

      pos = dt.determineDaysOfMonths(month, year) * daysWidthOnXAxis + pos
      let monthVal = month === 0 ? year : month
      this.timeScaleArray.push({
        position: pos,
        value: monthVal,
        unit,
        year,
        month: month === 0 ? 1 : month
      })
      month++
    }
  }

  generateDayScale({
    firstVal,
    currentMonth,
    currentYear,
    hoursWidthOnXAxis,
    numberOfDays
  }) {
    const dt = new DateTime(this.ctx)
    let unit = 'day'
    let firstTickValue = firstVal.minDate + 1
    let date = firstTickValue

    const changeMonth = (dateVal, month, year) => {
      let monthdays = dt.determineDaysOfMonths(month + 1, year)

      if (dateVal > monthdays) {
        month = month + 1
        date = 1
        unit = 'month'
        val = month
        return month
      }

      return month
    }

    let remainingHours = 24 - firstVal.minHour
    let yrCounter = 0
    let firstTickPosition = remainingHours * hoursWidthOnXAxis

    let val = firstTickValue
    let month = changeMonth(date, currentMonth, currentYear)

    if (firstVal.minHour === 0 && firstVal.minDate === 1) {

      firstTickPosition = 0
      val = Utils.monthMod(firstVal.minMonth)
      unit = 'month'
      date = firstVal.minDate
      numberOfDays++
    } else if (
      firstVal.minDate !== 1 &&
      firstVal.minHour === 0 &&
      firstVal.minMinute === 0
    ) {

      firstTickPosition = 0
      firstTickValue = firstVal.minDate
      date = firstTickValue
      val = firstTickValue

      month = changeMonth(date, currentMonth, currentYear)
    }
    this.timeScaleArray.push({
      position: firstTickPosition,
      value: val,
      unit,
      year: this._getYear(currentYear, month, yrCounter),
      month: Utils.monthMod(month),
      day: date
    })

    let pos = firstTickPosition

    for (let i = 0; i < numberOfDays; i++) {
      date += 1
      unit = 'day'
      month = changeMonth(
        date,
        month,
        this._getYear(currentYear, month, yrCounter)
      )

      let year = this._getYear(currentYear, month, yrCounter)

      pos = 24 * hoursWidthOnXAxis + pos
      let value = date === 1 ? Utils.monthMod(month) : date
      this.timeScaleArray.push({
        position: pos,
        value,
        unit,
        year,
        month: Utils.monthMod(month),
        day: value
      })
    }
  }

  generateHourScale({
    firstVal,
    currentDate,
    currentMonth,
    currentYear,
    minutesWidthOnXAxis,
    numberOfHours
  }) {
    const dt = new DateTime(this.ctx)

    let yrCounter = 0
    let unit = 'hour'

    const changeDate = (dateVal, month) => {
      let monthdays = dt.determineDaysOfMonths(month + 1, currentYear)
      if (dateVal > monthdays) {
        date = 1
        month = month + 1
      }
      return { month, date }
    }

    const changeMonth = (dateVal, month) => {
      let monthdays = dt.determineDaysOfMonths(month + 1, currentYear)
      if (dateVal > monthdays) {
        month = month + 1
        return month
      }

      return month
    }
    let remainingMins = 60 - (firstVal.minMinute + firstVal.minSecond / 60.0)

    let firstTickPosition = remainingMins * minutesWidthOnXAxis
    let firstTickValue = firstVal.minHour + 1
    let hour = firstTickValue + 1

    if (remainingMins === 60) {
      firstTickPosition = 0
      firstTickValue = firstVal.minHour
      hour = firstTickValue + 1
    }

    let date = currentDate

    let month = changeMonth(date, currentMonth)
    this.timeScaleArray.push({
      position: firstTickPosition,
      value: firstTickValue,
      unit,
      day: date,
      hour,
      year: currentYear,
      month: Utils.monthMod(month)
    })

    let pos = firstTickPosition

    for (let i = 0; i < numberOfHours; i++) {
      unit = 'hour'

      if (hour >= 24) {
        hour = 0
        date += 1
        unit = 'day'

        const checkNextMonth = changeDate(date, month)

        month = checkNextMonth.month
        month = changeMonth(date, month)
      }

      let year = this._getYear(currentYear, month, yrCounter)
      pos = 60 * minutesWidthOnXAxis + pos
      let val = hour === 0 ? date : hour
      this.timeScaleArray.push({
        position: pos,
        value: val,
        unit,
        hour,
        day: date,
        year,
        month: Utils.monthMod(month)
      })

      hour++
    }
  }

  generateMinuteScale({
    currentMillisecond,
    currentSecond,
    currentMinute,
    currentHour,
    currentDate,
    currentMonth,
    currentYear,
    minutesWidthOnXAxis,
    secondsWidthOnXAxis,
    numberOfMinutes
  }) {
    let yrCounter = 0
    let unit = 'minute'

    let remainingSecs = 60 - currentSecond
    let firstTickPosition =
      (remainingSecs - currentMillisecond / 1000) * secondsWidthOnXAxis
    let minute = currentMinute + 1

    let date = currentDate
    let month = currentMonth
    let year = currentYear
    let hour = currentHour

    let pos = firstTickPosition
    for (let i = 0; i < numberOfMinutes; i++) {
      if (minute >= 60) {
        minute = 0
        hour += 1
        if (hour === 24) {
          hour = 0
        }
      }

      this.timeScaleArray.push({
        position: pos,
        value: minute,
        unit,
        hour,
        minute,
        day: date,
        year: this._getYear(year, month, yrCounter),
        month: Utils.monthMod(month)
      })

      pos += minutesWidthOnXAxis
      minute++
    }
  }

  generateSecondScale({
    currentMillisecond,
    currentSecond,
    currentMinute,
    currentHour,
    currentDate,
    currentMonth,
    currentYear,
    secondsWidthOnXAxis,
    numberOfSeconds
  }) {
    let yrCounter = 0
    let unit = 'second'

    const remainingMillisecs = 1000 - currentMillisecond
    let firstTickPosition = (remainingMillisecs / 1000) * secondsWidthOnXAxis

    let second = currentSecond + 1
    let minute = currentMinute
    let date = currentDate
    let month = currentMonth
    let year = currentYear
    let hour = currentHour

    let pos = firstTickPosition
    for (let i = 0; i < numberOfSeconds; i++) {
      if (second >= 60) {
        minute++
        second = 0
        if (minute >= 60) {
          hour++
          minute = 0
          if (hour === 24) {
            hour = 0
          }
        }
      }

      this.timeScaleArray.push({
        position: pos,
        value: second,
        unit,
        hour,
        minute,
        second,
        day: date,
        year: this._getYear(year, month, yrCounter),
        month: Utils.monthMod(month)
      })

      pos += secondsWidthOnXAxis
      second++
    }
  }

  createRawDateString(ts, value) {
    let raw = ts.year

    if (ts.month === 0) {

      ts.month = 1
    }
    raw += '-' + ('0' + ts.month.toString()).slice(-2)
    if (ts.unit === 'day') {
      raw += ts.unit === 'day' ? '-' + ('0' + value).slice(-2) : '-01'
    } else {
      raw += '-' + ('0' + (ts.day ? ts.day : '1')).slice(-2)
    }
    if (ts.unit === 'hour') {
      raw += ts.unit === 'hour' ? 'T' + ('0' + value).slice(-2) : 'T00'
    } else {
      raw += 'T' + ('0' + (ts.hour ? ts.hour : '0')).slice(-2)
    }

    if (ts.unit === 'minute') {
      raw += ':' + ('0' + value).slice(-2)
    } else {
      raw += ':' + (ts.minute ? ('0' + ts.minute).slice(-2) : '00')
    }

    if (ts.unit === 'second') {
      raw += ':' + ('0' + value).slice(-2)
    } else {
      raw += ':00'
    }

    if (this.utc) {
      raw += '.000Z'
    }
    return raw
  }

  formatDates(filteredTimeScale) {
    const w = this.w

    const reformattedTimescaleArray = filteredTimeScale.map((ts) => {
      let value = ts.value.toString()

      let dt = new DateTime(this.ctx)

      const raw = this.createRawDateString(ts, value)

      let dateToFormat = dt.getDate(dt.parseDate(raw))
      if (!this.utc) {

        dateToFormat = dt.getDate(dt.parseDateWithTimezone(raw))
      }

      if (w.config.xaxis.labels.format === undefined) {
        let customFormat = 'dd MMM'
        const dtFormatter = w.config.xaxis.labels.datetimeFormatter
        if (ts.unit === 'year') customFormat = dtFormatter.year
        if (ts.unit === 'month') customFormat = dtFormatter.month
        if (ts.unit === 'day') customFormat = dtFormatter.day
        if (ts.unit === 'hour') customFormat = dtFormatter.hour
        if (ts.unit === 'minute') customFormat = dtFormatter.minute
        if (ts.unit === 'second') customFormat = dtFormatter.second

        value = dt.formatDate(dateToFormat, customFormat)
      } else {
        value = dt.formatDate(dateToFormat, w.config.xaxis.labels.format)
      }

      return {
        dateString: raw,
        position: ts.position,
        value,
        unit: ts.unit,
        year: ts.year,
        month: ts.month
      }
    })

    return reformattedTimescaleArray
  }

  removeOverlappingTS(arr) {
    const graphics = new Graphics(this.ctx)

    let equalLabelLengthFlag = false
    let constantLabelWidth
    if (
      arr.length > 0 &&
      arr[0].value &&
      arr.every((lb) => lb.value.length === arr[0].value.length)
    ) {
      equalLabelLengthFlag = true
      constantLabelWidth = graphics.getTextRects(arr[0].value).width
    }

    let lastDrawnIndex = 0

    let filteredArray = arr.map((item, index) => {
      if (index > 0 && this.w.config.xaxis.labels.hideOverlappingLabels) {
        const prevLabelWidth = !equalLabelLengthFlag
          ? graphics.getTextRects(arr[lastDrawnIndex].value).width
          : constantLabelWidth
        const prevPos = arr[lastDrawnIndex].position
        const pos = item.position

        if (pos > prevPos + prevLabelWidth + 10) {
          lastDrawnIndex = index
          return item
        } else {
          return null
        }
      } else {
        return item
      }
    })

    filteredArray = filteredArray.filter((f) => f !== null)

    return filteredArray
  }

  _getYear(currentYear, month, yrCounter) {
    return currentYear + Math.floor(month / 12) + yrCounter
  }
}

export default TimeScale
