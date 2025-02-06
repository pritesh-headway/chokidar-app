export default class Emitter {

  on(event, fn) {
    this._callbacks = this._callbacks || {};

    if (!this._callbacks[event]) {
      this._callbacks[event] = [];
    }
    this._callbacks[event].push(fn);
    return this;
  }

  emit(event, ...args) {
    this._callbacks = this._callbacks || {};
    let callbacks = this._callbacks[event];

    if (callbacks) {
      for (let callback of callbacks) {
        callback.apply(this, args);
      }
    }

    if (this.element) {
      this.element.dispatchEvent(
        this.makeEvent("dropzone:" + event, { args: args })
      );
    }
    return this;
  }

  makeEvent(eventName, detail) {
    let params = { bubbles: true, cancelable: true, detail: detail };

    if (typeof window.CustomEvent === "function") {
      return new CustomEvent(eventName, params);
    } else {
      var evt = document.createEvent("CustomEvent");
      evt.initCustomEvent(
        eventName,
        params.bubbles,
        params.cancelable,
        params.detail
      );
      return evt;
    }
  }
  off(event, fn) {
    if (!this._callbacks || arguments.length === 0) {
      this._callbacks = {};
      return this;
    }
    let callbacks = this._callbacks[event];
    if (!callbacks) {
      return this;
    }
    if (arguments.length === 1) {
      delete this._callbacks[event];
      return this;
    }
    for (let i = 0; i < callbacks.length; i++) {
      let callback = callbacks[i];
      if (callback === fn) {
        callbacks.splice(i, 1);
        break;
      }
    }

    return this;
  }
}
