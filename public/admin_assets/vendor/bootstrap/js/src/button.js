/**
 * --------------------------------------------------------------------------
 * Bootstrap (v5.3.0-alpha1): button.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 * --------------------------------------------------------------------------
 */

import { defineJQueryPlugin } from './util/index.js'
import EventHandler from './dom/event-handler.js'
import BaseComponent from './base-component.js'

/**
 * Constants
 */

const NAME = 'button'
const DATA_KEY = 'bs.button'
const EVENT_KEY = `.${DATA_KEY}`
const DATA_API_KEY = '.data-api'

const CLASS_NAME_ACTIVE = 'active'
const SELECTOR_DATA_TOGGLE = '[data-bs-toggle="button"]'
const EVENT_CLICK_DATA_API = `click${EVENT_KEY}${DATA_API_KEY}`

/**
 * Class definition
 */

class Button extends BaseComponent {

  static get NAME() {
    return NAME
  }
  toggle() {

    this._element.setAttribute('aria-pressed', this._element.classList.toggle(CLASS_NAME_ACTIVE))
  }
  static jQueryInterface(config) {
    return this.each(function () {
      const data = Button.getOrCreateInstance(this)

      if (config === 'toggle') {
        data[config]()
      }
    })
  }
}

/**
 * Data API implementation
 */

EventHandler.on(document, EVENT_CLICK_DATA_API, SELECTOR_DATA_TOGGLE, event => {
  event.preventDefault()

  const button = event.target.closest(SELECTOR_DATA_TOGGLE)
  const data = Button.getOrCreateInstance(button)

  data.toggle()
})

/**
 * jQuery
 */

defineJQueryPlugin(Button)

export default Button
