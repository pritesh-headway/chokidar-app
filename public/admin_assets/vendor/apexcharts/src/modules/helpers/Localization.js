import Utils from '../../utils/Utils'

import en from '../../locales/en.json'

export default class Localization {
  constructor(ctx) {
    this.ctx = ctx
    this.w = ctx.w
  }

  setCurrentLocaleValues(localeName) {
    let locales = this.w.config.chart.locales
    if (
      window.Apex.chart &&
      window.Apex.chart.locales &&
      window.Apex.chart.locales.length > 0
    ) {
      locales = this.w.config.chart.locales.concat(window.Apex.chart.locales)
    }
    const selectedLocale = locales.filter((c) => c.name === localeName)[0]

    if (selectedLocale) {

      let ret = Utils.extend(en, selectedLocale)
      this.w.globals.locale = ret.options
    } else {
      throw new Error(
        'Wrong locale name provided. Please make sure you set the correct locale name in options'
      )
    }
  }
}
