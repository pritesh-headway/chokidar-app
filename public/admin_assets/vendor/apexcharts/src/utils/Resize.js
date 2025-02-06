let ros = new WeakMap()

export function addResizeListener(el, fn) {
  let called = false

  if (el.nodeType !== Node.DOCUMENT_FRAGMENT_NODE) {
    const elRect = el.getBoundingClientRect()
    if (el.style.display === 'none' || elRect.width === 0) {
      called = true
    }
  }

  let ro = new ResizeObserver((r) => {
    if (called) {
      fn.call(el, r)
    }
    called = true
  })

  if (el.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {

    Array.from(el.children).forEach((c) => ro.observe(c))
  } else {
    ro.observe(el)
  }

  ros.set(fn, ro)
}

export function removeResizeListener(el, fn) {
  let ro = ros.get(fn)
  if (ro) {
    ro.disconnect()
    ros.delete(fn)
  }
}
