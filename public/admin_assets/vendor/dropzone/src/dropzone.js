import Emitter from "./emitter.js";
import defaultOptions from "./options.js";

export default class Dropzone extends Emitter {
  static initClass() {

    this.prototype.Emitter = Emitter;

    /*
     This is a list of all available events you can register on a dropzone object.

     You can register an event handler like this:

     dropzone.on("dragEnter", function() { });

     */
    this.prototype.events = [
      "drop",
      "dragstart",
      "dragend",
      "dragenter",
      "dragover",
      "dragleave",
      "addedfile",
      "addedfiles",
      "removedfile",
      "thumbnail",
      "error",
      "errormultiple",
      "processing",
      "processingmultiple",
      "uploadprogress",
      "totaluploadprogress",
      "sending",
      "sendingmultiple",
      "success",
      "successmultiple",
      "canceled",
      "canceledmultiple",
      "complete",
      "completemultiple",
      "reset",
      "maxfilesexceeded",
      "maxfilesreached",
      "queuecomplete",
    ];

    this.prototype._thumbnailQueue = [];
    this.prototype._processingThumbnail = false;
  }
  static extend(target, ...objects) {
    for (let object of objects) {
      for (let key in object) {
        let val = object[key];
        target[key] = val;
      }
    }
    return target;
  }

  constructor(el, options) {
    super();
    let fallback, left;
    this.element = el;

    this.version = Dropzone.version;

    this.clickableElements = [];
    this.listeners = [];
    this.files = [];

    if (typeof this.element === "string") {
      this.element = document.querySelector(this.element);
    }
    if (!this.element || this.element.nodeType == null) {
      throw new Error("Invalid dropzone element.");
    }

    if (this.element.dropzone) {
      throw new Error("Dropzone already attached.");
    }
    Dropzone.instances.push(this);
    this.element.dropzone = this;

    let elementOptions =
      (left = Dropzone.optionsForElement(this.element)) != null ? left : {};

    this.options = Dropzone.extend(
      {},
      defaultOptions,
      elementOptions,
      options != null ? options : {}
    );

    this.options.previewTemplate = this.options.previewTemplate.replace(
      /\n*/g,
      ""
    );
    if (this.options.forceFallback || !Dropzone.isBrowserSupported()) {
      return this.options.fallback.call(this);
    }
    if (this.options.url == null) {
      this.options.url = this.element.getAttribute("action");
    }

    if (!this.options.url) {
      throw new Error("No URL provided.");
    }

    if (this.options.acceptedFiles && this.options.acceptedMimeTypes) {
      throw new Error(
        "You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated."
      );
    }

    if (this.options.uploadMultiple && this.options.chunking) {
      throw new Error("You cannot set both: uploadMultiple and chunking.");
    }
    if (this.options.acceptedMimeTypes) {
      this.options.acceptedFiles = this.options.acceptedMimeTypes;
      delete this.options.acceptedMimeTypes;
    }
    if (this.options.renameFilename != null) {
      this.options.renameFile = (file) =>
        this.options.renameFilename.call(this, file.name, file);
    }

    if (typeof this.options.method === "string") {
      this.options.method = this.options.method.toUpperCase();
    }

    if ((fallback = this.getExistingFallback()) && fallback.parentNode) {

      fallback.parentNode.removeChild(fallback);
    }
    if (this.options.previewsContainer !== false) {
      if (this.options.previewsContainer) {
        this.previewsContainer = Dropzone.getElement(
          this.options.previewsContainer,
          "previewsContainer"
        );
      } else {
        this.previewsContainer = this.element;
      }
    }

    if (this.options.clickable) {
      if (this.options.clickable === true) {
        this.clickableElements = [this.element];
      } else {
        this.clickableElements = Dropzone.getElements(
          this.options.clickable,
          "clickable"
        );
      }
    }

    this.init();
  }
  getAcceptedFiles() {
    return this.files.filter((file) => file.accepted).map((file) => file);
  }
  getRejectedFiles() {
    return this.files.filter((file) => !file.accepted).map((file) => file);
  }

  getFilesWithStatus(status) {
    return this.files
      .filter((file) => file.status === status)
      .map((file) => file);
  }
  getQueuedFiles() {
    return this.getFilesWithStatus(Dropzone.QUEUED);
  }

  getUploadingFiles() {
    return this.getFilesWithStatus(Dropzone.UPLOADING);
  }

  getAddedFiles() {
    return this.getFilesWithStatus(Dropzone.ADDED);
  }
  getActiveFiles() {
    return this.files
      .filter(
        (file) =>
          file.status === Dropzone.UPLOADING || file.status === Dropzone.QUEUED
      )
      .map((file) => file);
  }
  init() {

    if (this.element.tagName === "form") {
      this.element.setAttribute("enctype", "multipart/form-data");
    }

    if (
      this.element.classList.contains("dropzone") &&
      !this.element.querySelector(".dz-message")
    ) {
      this.element.appendChild(
        Dropzone.createElement(
          `<div class="dz-default dz-message"><button class="dz-button" type="button">${this.options.dictDefaultMessage}</button></div>`
        )
      );
    }

    if (this.clickableElements.length) {
      let setupHiddenFileInput = () => {
        if (this.hiddenFileInput) {
          this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
        }
        this.hiddenFileInput = document.createElement("input");
        this.hiddenFileInput.setAttribute("type", "file");
        if (this.options.maxFiles === null || this.options.maxFiles > 1) {
          this.hiddenFileInput.setAttribute("multiple", "multiple");
        }
        this.hiddenFileInput.className = "dz-hidden-input";

        if (this.options.acceptedFiles !== null) {
          this.hiddenFileInput.setAttribute(
            "accept",
            this.options.acceptedFiles
          );
        }
        if (this.options.capture !== null) {
          this.hiddenFileInput.setAttribute("capture", this.options.capture);
        }
        this.hiddenFileInput.setAttribute("tabindex", "-1");
        this.hiddenFileInput.style.visibility = "hidden";
        this.hiddenFileInput.style.position = "absolute";
        this.hiddenFileInput.style.top = "0";
        this.hiddenFileInput.style.left = "0";
        this.hiddenFileInput.style.height = "0";
        this.hiddenFileInput.style.width = "0";
        Dropzone.getElement(
          this.options.hiddenInputContainer,
          "hiddenInputContainer"
        ).appendChild(this.hiddenFileInput);
        this.hiddenFileInput.addEventListener("change", () => {
          let { files } = this.hiddenFileInput;
          if (files.length) {
            for (let file of files) {
              this.addFile(file);
            }
          }
          this.emit("addedfiles", files);
          setupHiddenFileInput();
        });
      };
      setupHiddenFileInput();
    }

    this.URL = window.URL !== null ? window.URL : window.webkitURL;
    for (let eventName of this.events) {
      this.on(eventName, this.options[eventName]);
    }

    this.on("uploadprogress", () => this.updateTotalUploadProgress());

    this.on("removedfile", () => this.updateTotalUploadProgress());

    this.on("canceled", (file) => this.emit("complete", file));
    this.on("complete", (file) => {
      if (
        this.getAddedFiles().length === 0 &&
        this.getUploadingFiles().length === 0 &&
        this.getQueuedFiles().length === 0
      ) {

        return setTimeout(() => this.emit("queuecomplete"), 0);
      }
    });

    const containsFiles = function (e) {
      if (e.dataTransfer.types) {
        for (var i = 0; i < e.dataTransfer.types.length; i++) {
          if (e.dataTransfer.types[i] === "Files") return true;
        }
      }
      return false;
    };

    let noPropagation = function (e) {
      if (!containsFiles(e)) return;
      e.stopPropagation();
      if (e.preventDefault) {
        return e.preventDefault();
      } else {
        return (e.returnValue = false);
      }
    };
    this.listeners = [
      {
        element: this.element,
        events: {
          dragstart: (e) => {
            return this.emit("dragstart", e);
          },
          dragenter: (e) => {
            noPropagation(e);
            return this.emit("dragenter", e);
          },
          dragover: (e) => {
            let efct;
            try {
              efct = e.dataTransfer.effectAllowed;
            } catch (error) { }
            e.dataTransfer.dropEffect =
              "move" === efct || "linkMove" === efct ? "move" : "copy";

            noPropagation(e);
            return this.emit("dragover", e);
          },
          dragleave: (e) => {
            return this.emit("dragleave", e);
          },
          drop: (e) => {
            noPropagation(e);
            return this.drop(e);
          },
          dragend: (e) => {
            return this.emit("dragend", e);
          },
        },
      },
    ];

    this.clickableElements.forEach((clickableElement) => {
      return this.listeners.push({
        element: clickableElement,
        events: {
          click: (evt) => {

            if (
              clickableElement !== this.element ||
              evt.target === this.element ||
              Dropzone.elementInside(
                evt.target,
                this.element.querySelector(".dz-message")
              )
            ) {
              this.hiddenFileInput.click();
            }
            return true;
          },
        },
      });
    });

    this.enable();

    return this.options.init.call(this);
  }
  destroy() {
    this.disable();
    this.removeAllFiles(true);
    if (
      this.hiddenFileInput != null ? this.hiddenFileInput.parentNode : undefined
    ) {
      this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
      this.hiddenFileInput = null;
    }
    delete this.element.dropzone;
    return Dropzone.instances.splice(Dropzone.instances.indexOf(this), 1);
  }

  updateTotalUploadProgress() {
    let totalUploadProgress;
    let totalBytesSent = 0;
    let totalBytes = 0;

    let activeFiles = this.getActiveFiles();

    if (activeFiles.length) {
      for (let file of this.getActiveFiles()) {
        totalBytesSent += file.upload.bytesSent;
        totalBytes += file.upload.total;
      }
      totalUploadProgress = (100 * totalBytesSent) / totalBytes;
    } else {
      totalUploadProgress = 100;
    }

    return this.emit(
      "totaluploadprogress",
      totalUploadProgress,
      totalBytes,
      totalBytesSent
    );
  }
  _getParamName(n) {
    if (typeof this.options.paramName === "function") {
      return this.options.paramName(n);
    } else {
      return `${this.options.paramName}${this.options.uploadMultiple ? `[${n}]` : ""
        }`;
    }
  }
  _renameFile(file) {
    if (typeof this.options.renameFile !== "function") {
      return file.name;
    }
    return this.options.renameFile(file);
  }
  //
  getFallbackForm() {
    let existingFallback, form;
    if ((existingFallback = this.getExistingFallback())) {
      return existingFallback;
    }

    let fieldsString = '<div class="dz-fallback">';
    if (this.options.dictFallbackText) {
      fieldsString += `<p>${this.options.dictFallbackText}</p>`;
    }
    fieldsString += `<input type="file" name="${this._getParamName(0)}" ${this.options.uploadMultiple ? 'multiple="multiple"' : undefined
      } /><input type="submit" value="Upload!"></div>`;

    let fields = Dropzone.createElement(fieldsString);
    if (this.element.tagName !== "FORM") {
      form = Dropzone.createElement(
        `<form action="${this.options.url}" enctype="multipart/form-data" method="${this.options.method}"></form>`
      );
      form.appendChild(fields);
    } else {

      this.element.setAttribute("enctype", "multipart/form-data");
      this.element.setAttribute("method", this.options.method);
    }
    return form != null ? form : fields;
  }
  //

  getExistingFallback() {
    let getFallback = function (elements) {
      for (let el of elements) {
        if (/(^| )fallback($| )/.test(el.className)) {
          return el;
        }
      }
    };

    for (let tagName of ["div", "form"]) {
      var fallback;
      if (
        (fallback = getFallback(this.element.getElementsByTagName(tagName)))
      ) {
        return fallback;
      }
    }
  }
  setupEventListeners() {
    return this.listeners.map((elementListeners) =>
      (() => {
        let result = [];
        for (let event in elementListeners.events) {
          let listener = elementListeners.events[event];
          result.push(
            elementListeners.element.addEventListener(event, listener, false)
          );
        }
        return result;
      })()
    );
  }
  removeEventListeners() {
    return this.listeners.map((elementListeners) =>
      (() => {
        let result = [];
        for (let event in elementListeners.events) {
          let listener = elementListeners.events[event];
          result.push(
            elementListeners.element.removeEventListener(event, listener, false)
          );
        }
        return result;
      })()
    );
  }
  disable() {
    this.clickableElements.forEach((element) =>
      element.classList.remove("dz-clickable")
    );
    this.removeEventListeners();
    this.disabled = true;

    return this.files.map((file) => this.cancelUpload(file));
  }

  enable() {
    delete this.disabled;
    this.clickableElements.forEach((element) =>
      element.classList.add("dz-clickable")
    );
    return this.setupEventListeners();
  }
  filesize(size) {
    let selectedSize = 0;
    let selectedUnit = "b";

    if (size > 0) {
      let units = ["tb", "gb", "mb", "kb", "b"];

      for (let i = 0; i < units.length; i++) {
        let unit = units[i];
        let cutoff = Math.pow(this.options.filesizeBase, 4 - i) / 10;

        if (size >= cutoff) {
          selectedSize = size / Math.pow(this.options.filesizeBase, 4 - i);
          selectedUnit = unit;
          break;
        }
      }

      selectedSize = Math.round(10 * selectedSize) / 10;
    }

    return `<strong>${selectedSize}</strong> ${this.options.dictFileSizeUnits[selectedUnit]}`;
  }
  _updateMaxFilesReachedClass() {
    if (
      this.options.maxFiles != null &&
      this.getAcceptedFiles().length >= this.options.maxFiles
    ) {
      if (this.getAcceptedFiles().length === this.options.maxFiles) {
        this.emit("maxfilesreached", this.files);
      }
      return this.element.classList.add("dz-max-files-reached");
    } else {
      return this.element.classList.remove("dz-max-files-reached");
    }
  }

  drop(e) {
    if (!e.dataTransfer) {
      return;
    }
    this.emit("drop", e);
    let files = [];
    for (let i = 0; i < e.dataTransfer.files.length; i++) {
      files[i] = e.dataTransfer.files[i];
    }
    if (files.length) {
      let { items } = e.dataTransfer;
      if (items && items.length && items[0].webkitGetAsEntry != null) {

        this._addFilesFromItems(items);
      } else {
        this.handleFiles(files);
      }
    }

    this.emit("addedfiles", files);
  }

  paste(e) {
    if (
      __guard__(e != null ? e.clipboardData : undefined, (x) => x.items) == null
    ) {
      return;
    }

    this.emit("paste", e);
    let { items } = e.clipboardData;

    if (items.length) {
      return this._addFilesFromItems(items);
    }
  }

  handleFiles(files) {
    for (let file of files) {
      this.addFile(file);
    }
  }
  _addFilesFromItems(items) {
    return (() => {
      let result = [];
      for (let item of items) {
        var entry;
        if (
          item.webkitGetAsEntry != null &&
          (entry = item.webkitGetAsEntry())
        ) {
          if (entry.isFile) {
            result.push(this.addFile(item.getAsFile()));
          } else if (entry.isDirectory) {

            result.push(this._addFilesFromDirectory(entry, entry.name));
          } else {
            result.push(undefined);
          }
        } else if (item.getAsFile != null) {
          if (item.kind == null || item.kind === "file") {
            result.push(this.addFile(item.getAsFile()));
          } else {
            result.push(undefined);
          }
        } else {
          result.push(undefined);
        }
      }
      return result;
    })();
  }
  _addFilesFromDirectory(directory, path) {
    let dirReader = directory.createReader();

    let errorHandler = (error) =>
      __guardMethod__(console, "log", (o) => o.log(error));

    var readEntries = () => {
      return dirReader.readEntries((entries) => {
        if (entries.length > 0) {
          for (let entry of entries) {
            if (entry.isFile) {
              entry.file((file) => {
                if (
                  this.options.ignoreHiddenFiles &&
                  file.name.substring(0, 1) === "."
                ) {
                  return;
                }
                file.fullPath = `${path}/${file.name}`;
                return this.addFile(file);
              });
            } else if (entry.isDirectory) {
              this._addFilesFromDirectory(entry, `${path}/${entry.name}`);
            }
          }
          readEntries();
        }
        return null;
      }, errorHandler);
    };

    return readEntries();
  }
  //
  accept(file, done) {
    if (
      this.options.maxFilesize &&
      file.size > this.options.maxFilesize * 1024 * 1024
    ) {
      done(
        this.options.dictFileTooBig
          .replace("{{filesize}}", Math.round(file.size / 1024 / 10.24) / 100)
          .replace("{{maxFilesize}}", this.options.maxFilesize)
      );
    } else if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
      done(this.options.dictInvalidFileType);
    } else if (
      this.options.maxFiles != null &&
      this.getAcceptedFiles().length >= this.options.maxFiles
    ) {
      done(
        this.options.dictMaxFilesExceeded.replace(
          "{{maxFiles}}",
          this.options.maxFiles
        )
      );
      this.emit("maxfilesexceeded", file);
    } else {
      this.options.accept.call(this, file, done);
    }
  }

  addFile(file) {
    file.upload = {
      uuid: Dropzone.uuidv4(),
      progress: 0,
      total: file.size,
      bytesSent: 0,
      filename: this._renameFile(file),
    };
    this.files.push(file);

    file.status = Dropzone.ADDED;

    this.emit("addedfile", file);

    this._enqueueThumbnail(file);

    this.accept(file, (error) => {
      if (error) {
        file.accepted = false;
        this._errorProcessing([file], error);
      } else {
        file.accepted = true;
        if (this.options.autoQueue) {
          this.enqueueFile(file);
        }
      }
      this._updateMaxFilesReachedClass();
    });
  }
  enqueueFiles(files) {
    for (let file of files) {
      this.enqueueFile(file);
    }
    return null;
  }

  enqueueFile(file) {
    if (file.status === Dropzone.ADDED && file.accepted === true) {
      file.status = Dropzone.QUEUED;
      if (this.options.autoProcessQueue) {
        return setTimeout(() => this.processQueue(), 0);
      }
    } else {
      throw new Error(
        "This file can't be queued because it has already been processed or was rejected."
      );
    }
  }

  _enqueueThumbnail(file) {
    if (
      this.options.createImageThumbnails &&
      file.type.match(/image.*/) &&
      file.size <= this.options.maxThumbnailFilesize * 1024 * 1024
    ) {
      this._thumbnailQueue.push(file);
      return setTimeout(() => this._processThumbnailQueue(), 0);
    }
  }

  _processThumbnailQueue() {
    if (this._processingThumbnail || this._thumbnailQueue.length === 0) {
      return;
    }

    this._processingThumbnail = true;
    let file = this._thumbnailQueue.shift();
    return this.createThumbnail(
      file,
      this.options.thumbnailWidth,
      this.options.thumbnailHeight,
      this.options.thumbnailMethod,
      true,
      (dataUrl) => {
        this.emit("thumbnail", file, dataUrl);
        this._processingThumbnail = false;
        return this._processThumbnailQueue();
      }
    );
  }
  removeFile(file) {
    if (file.status === Dropzone.UPLOADING) {
      this.cancelUpload(file);
    }
    this.files = without(this.files, file);

    this.emit("removedfile", file);
    if (this.files.length === 0) {
      return this.emit("reset");
    }
  }
  removeAllFiles(cancelIfNecessary) {

    if (cancelIfNecessary == null) {
      cancelIfNecessary = false;
    }
    for (let file of this.files.slice()) {
      if (file.status !== Dropzone.UPLOADING || cancelIfNecessary) {
        this.removeFile(file);
      }
    }
    return null;
  }
  resizeImage(file, width, height, resizeMethod, callback) {
    return this.createThumbnail(
      file,
      width,
      height,
      resizeMethod,
      true,
      (dataUrl, canvas) => {
        if (canvas == null) {

          return callback(file);
        } else {
          let { resizeMimeType } = this.options;
          if (resizeMimeType == null) {
            resizeMimeType = file.type;
          }
          let resizedDataURL = canvas.toDataURL(
            resizeMimeType,
            this.options.resizeQuality
          );
          if (
            resizeMimeType === "image/jpeg" ||
            resizeMimeType === "image/jpg"
          ) {

            resizedDataURL = ExifRestore.restore(file.dataURL, resizedDataURL);
          }
          return callback(Dropzone.dataURItoBlob(resizedDataURL));
        }
      }
    );
  }

  createThumbnail(file, width, height, resizeMethod, fixOrientation, callback) {
    let fileReader = new FileReader();

    fileReader.onload = () => {
      file.dataURL = fileReader.result;
      if (file.type === "image/svg+xml") {
        if (callback != null) {
          callback(fileReader.result);
        }
        return;
      }

      this.createThumbnailFromUrl(
        file,
        width,
        height,
        resizeMethod,
        fixOrientation,
        callback
      );
    };

    fileReader.readAsDataURL(file);
  }
  //

  //
  displayExistingFile(
    mockFile,
    imageUrl,
    callback,
    crossOrigin,
    resizeThumbnail = true
  ) {
    this.emit("addedfile", mockFile);
    this.emit("complete", mockFile);

    if (!resizeThumbnail) {
      this.emit("thumbnail", mockFile, imageUrl);
      if (callback) callback();
    } else {
      let onDone = (thumbnail) => {
        this.emit("thumbnail", mockFile, thumbnail);
        if (callback) callback();
      };
      mockFile.dataURL = imageUrl;

      this.createThumbnailFromUrl(
        mockFile,
        this.options.thumbnailWidth,
        this.options.thumbnailHeight,
        this.options.thumbnailMethod,
        this.options.fixOrientation,
        onDone,
        crossOrigin
      );
    }
  }

  createThumbnailFromUrl(
    file,
    width,
    height,
    resizeMethod,
    fixOrientation,
    callback,
    crossOrigin
  ) {
    let img = document.createElement("img");

    if (crossOrigin) {
      img.crossOrigin = crossOrigin;
    }
    fixOrientation =
      getComputedStyle(document.body)["imageOrientation"] == "from-image"
        ? false
        : fixOrientation;

    img.onload = () => {
      let loadExif = (callback) => callback(1);
      if (typeof EXIF !== "undefined" && EXIF !== null && fixOrientation) {
        loadExif = (callback) =>
          EXIF.getData(img, function () {
            return callback(EXIF.getTag(this, "Orientation"));
          });
      }

      return loadExif((orientation) => {
        file.width = img.width;
        file.height = img.height;

        let resizeInfo = this.options.resize.call(
          this,
          file,
          width,
          height,
          resizeMethod
        );

        let canvas = document.createElement("canvas");
        let ctx = canvas.getContext("2d");

        canvas.width = resizeInfo.trgWidth;
        canvas.height = resizeInfo.trgHeight;

        if (orientation > 4) {
          canvas.width = resizeInfo.trgHeight;
          canvas.height = resizeInfo.trgWidth;
        }

        switch (orientation) {
          case 2:

            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            break;
          case 3:

            ctx.translate(canvas.width, canvas.height);
            ctx.rotate(Math.PI);
            break;
          case 4:

            ctx.translate(0, canvas.height);
            ctx.scale(1, -1);
            break;
          case 5:

            ctx.rotate(0.5 * Math.PI);
            ctx.scale(1, -1);
            break;
          case 6:

            ctx.rotate(0.5 * Math.PI);
            ctx.translate(0, -canvas.width);
            break;
          case 7:

            ctx.rotate(0.5 * Math.PI);
            ctx.translate(canvas.height, -canvas.width);
            ctx.scale(-1, 1);
            break;
          case 8:

            ctx.rotate(-0.5 * Math.PI);
            ctx.translate(-canvas.height, 0);
            break;
        }
        drawImageIOSFix(
          ctx,
          img,
          resizeInfo.srcX != null ? resizeInfo.srcX : 0,
          resizeInfo.srcY != null ? resizeInfo.srcY : 0,
          resizeInfo.srcWidth,
          resizeInfo.srcHeight,
          resizeInfo.trgX != null ? resizeInfo.trgX : 0,
          resizeInfo.trgY != null ? resizeInfo.trgY : 0,
          resizeInfo.trgWidth,
          resizeInfo.trgHeight
        );

        let thumbnail = canvas.toDataURL("image/png");

        if (callback != null) {
          return callback(thumbnail, canvas);
        }
      });
    };

    if (callback != null) {
      img.onerror = callback;
    }

    return (img.src = file.dataURL);
  }
  processQueue() {
    let { parallelUploads } = this.options;
    let processingLength = this.getUploadingFiles().length;
    let i = processingLength;
    if (processingLength >= parallelUploads) {
      return;
    }

    let queuedFiles = this.getQueuedFiles();

    if (!(queuedFiles.length > 0)) {
      return;
    }

    if (this.options.uploadMultiple) {

      return this.processFiles(
        queuedFiles.slice(0, parallelUploads - processingLength)
      );
    } else {
      while (i < parallelUploads) {
        if (!queuedFiles.length) {
          return;
        }
        this.processFile(queuedFiles.shift());
        i++;
      }
    }
  }
  processFile(file) {
    return this.processFiles([file]);
  }
  processFiles(files) {
    for (let file of files) {
      file.processing = true;
      file.status = Dropzone.UPLOADING;

      this.emit("processing", file);
    }

    if (this.options.uploadMultiple) {
      this.emit("processingmultiple", files);
    }

    return this.uploadFiles(files);
  }

  _getFilesWithXhr(xhr) {
    let files;
    return (files = this.files
      .filter((file) => file.xhr === xhr)
      .map((file) => file));
  }
  cancelUpload(file) {
    if (file.status === Dropzone.UPLOADING) {
      let groupedFiles = this._getFilesWithXhr(file.xhr);
      for (let groupedFile of groupedFiles) {
        groupedFile.status = Dropzone.CANCELED;
      }
      if (typeof file.xhr !== "undefined") {
        file.xhr.abort();
      }
      for (let groupedFile of groupedFiles) {
        this.emit("canceled", groupedFile);
      }
      if (this.options.uploadMultiple) {
        this.emit("canceledmultiple", groupedFiles);
      }
    } else if (
      file.status === Dropzone.ADDED ||
      file.status === Dropzone.QUEUED
    ) {
      file.status = Dropzone.CANCELED;
      this.emit("canceled", file);
      if (this.options.uploadMultiple) {
        this.emit("canceledmultiple", [file]);
      }
    }

    if (this.options.autoProcessQueue) {
      return this.processQueue();
    }
  }

  resolveOption(option, ...args) {
    if (typeof option === "function") {
      return option.apply(this, args);
    }
    return option;
  }

  uploadFile(file) {
    return this.uploadFiles([file]);
  }

  uploadFiles(files) {
    this._transformFiles(files, (transformedFiles) => {
      if (this.options.chunking) {
        let transformedFile = transformedFiles[0];
        files[0].upload.chunked =
          this.options.chunking &&
          (this.options.forceChunking ||
            transformedFile.size > this.options.chunkSize);
        files[0].upload.totalChunkCount = Math.ceil(
          transformedFile.size / this.options.chunkSize
        );
      }

      if (files[0].upload.chunked) {
        let file = files[0];
        let transformedFile = transformedFiles[0];
        let startedChunkCount = 0;

        file.upload.chunks = [];

        let handleNextChunk = () => {
          let chunkIndex = 0;
          while (file.upload.chunks[chunkIndex] !== undefined) {
            chunkIndex++;
          }
          if (chunkIndex >= file.upload.totalChunkCount) return;

          startedChunkCount++;

          let start = chunkIndex * this.options.chunkSize;
          let end = Math.min(
            start + this.options.chunkSize,
            transformedFile.size
          );

          let dataBlock = {
            name: this._getParamName(0),
            data: transformedFile.webkitSlice
              ? transformedFile.webkitSlice(start, end)
              : transformedFile.slice(start, end),
            filename: file.upload.filename,
            chunkIndex: chunkIndex,
          };

          file.upload.chunks[chunkIndex] = {
            file: file,
            index: chunkIndex,
            dataBlock: dataBlock,
            status: Dropzone.UPLOADING,
            progress: 0,
            retries: 0,
          };

          this._uploadData(files, [dataBlock]);
        };

        file.upload.finishedChunkUpload = (chunk, response) => {
          let allFinished = true;
          chunk.status = Dropzone.SUCCESS;
          chunk.dataBlock = null;

          chunk.xhr = null;

          for (let i = 0; i < file.upload.totalChunkCount; i++) {
            if (file.upload.chunks[i] === undefined) {
              return handleNextChunk();
            }
            if (file.upload.chunks[i].status !== Dropzone.SUCCESS) {
              allFinished = false;
            }
          }

          if (allFinished) {
            this.options.chunksUploaded(file, () => {
              this._finished(files, response, null);
            });
          }
        };

        if (this.options.parallelChunkUploads) {
          for (let i = 0; i < file.upload.totalChunkCount; i++) {
            handleNextChunk();
          }
        } else {
          handleNextChunk();
        }
      } else {
        let dataBlocks = [];
        for (let i = 0; i < files.length; i++) {
          dataBlocks[i] = {
            name: this._getParamName(i),
            data: transformedFiles[i],
            filename: files[i].upload.filename,
          };
        }
        this._uploadData(files, dataBlocks);
      }
    });
  }

  /
_getChunk(file, xhr) {
  for (let i = 0; i < file.upload.totalChunkCount; i++) {
    if (
      file.upload.chunks[i] !== undefined &&
      file.upload.chunks[i].xhr === xhr
    ) {
      return file.upload.chunks[i];
    }
  }
}
_uploadData(files, dataBlocks) {
  let xhr = new XMLHttpRequest();
  for (let file of files) {
    file.xhr = xhr;
  }
  if (files[0].upload.chunked) {

    files[0].upload.chunks[dataBlocks[0].chunkIndex].xhr = xhr;
  }

  let method = this.resolveOption(this.options.method, files);
  let url = this.resolveOption(this.options.url, files);
  xhr.open(method, url, true);
  let timeout = this.resolveOption(this.options.timeout, files);
  if (timeout) xhr.timeout = this.resolveOption(this.options.timeout, files);
  xhr.withCredentials = !!this.options.withCredentials;

  xhr.onload = (e) => {
    this._finishedUploading(files, xhr, e);
  };

  xhr.ontimeout = () => {
    this._handleUploadError(
      files,
      xhr,
      `Request timedout after ${this.options.timeout / 1000} seconds`
    );
  };

  xhr.onerror = () => {
    this._handleUploadError(files, xhr);
  };
  let progressObj = xhr.upload != null ? xhr.upload : xhr;
  progressObj.onprogress = (e) =>
    this._updateFilesUploadProgress(files, xhr, e);

  let headers = {
    Accept: "application/json",
    "Cache-Control": "no-cache",
    "X-Requested-With": "XMLHttpRequest",
  };

  if (this.options.headers) {
    Dropzone.extend(headers, this.options.headers);
  }

  for (let headerName in headers) {
    let headerValue = headers[headerName];
    if (headerValue) {
      xhr.setRequestHeader(headerName, headerValue);
    }
  }

  let formData = new FormData();
  if (this.options.params) {
    let additionalParams = this.options.params;
    if (typeof additionalParams === "function") {
      additionalParams = additionalParams.call(
        this,
        files,
        xhr,
        files[0].upload.chunked ? this._getChunk(files[0], xhr) : null
      );
    }

    for (let key in additionalParams) {
      let value = additionalParams[key];
      if (Array.isArray(value)) {
        for (let i = 0; i < value.length; i++) {
          formData.append(key, value[i]);
        }
      } else {
        formData.append(key, value);
      }
    }
  }
  for (let file of files) {
    this.emit("sending", file, xhr, formData);
  }
  if (this.options.uploadMultiple) {
    this.emit("sendingmultiple", files, xhr, formData);
  }

  this._addFormElementData(formData);
  for (let i = 0; i < dataBlocks.length; i++) {
    let dataBlock = dataBlocks[i];
    formData.append(dataBlock.name, dataBlock.data, dataBlock.filename);
  }

  this.submitRequest(xhr, formData, files);
}
_transformFiles(files, done) {
  let transformedFiles = [];

  let doneCounter = 0;
  for (let i = 0; i < files.length; i++) {
    this.options.transformFile.call(this, files[i], (transformedFile) => {
      transformedFiles[i] = transformedFile;
      if (++doneCounter === files.length) {
        done(transformedFiles);
      }
    });
  }
}
_addFormElementData(formData) {

  if (this.element.tagName === "FORM") {
    for (let input of this.element.querySelectorAll(
      "input, textarea, select, button"
    )) {
      let inputName = input.getAttribute("name");
      let inputType = input.getAttribute("type");
      if (inputType) inputType = inputType.toLowerCase();
      if (typeof inputName === "undefined" || inputName === null) continue;

      if (input.tagName === "SELECT" && input.hasAttribute("multiple")) {

        for (let option of input.options) {
          if (option.selected) {
            formData.append(inputName, option.value);
          }
        }
      } else if (
        !inputType ||
        (inputType !== "checkbox" && inputType !== "radio") ||
        input.checked
      ) {
        formData.append(inputName, input.value);
      }
    }
  }
}
_updateFilesUploadProgress(files, xhr, e) {
  if (!files[0].upload.chunked) {

    for (let file of files) {
      if (
        file.upload.total &&
        file.upload.bytesSent &&
        file.upload.bytesSent == file.upload.total
      ) {
        continue;
      }

      if (e) {
        file.upload.progress = (100 * e.loaded) / e.total;
        file.upload.total = e.total;
        file.upload.bytesSent = e.loaded;
      } else {

        file.upload.progress = 100;
        file.upload.bytesSent = file.upload.total;
      }

      this.emit(
        "uploadprogress",
        file,
        file.upload.progress,
        file.upload.bytesSent
      );
    }
  } else {
    let file = files[0];
    let chunk = this._getChunk(file, xhr);

    if (e) {
      chunk.progress = (100 * e.loaded) / e.total;
      chunk.total = e.total;
      chunk.bytesSent = e.loaded;
    } else {

      chunk.progress = 100;
      chunk.bytesSent = chunk.total;
    }
    file.upload.progress = 0;
    file.upload.total = 0;
    file.upload.bytesSent = 0;
    for (let i = 0; i < file.upload.totalChunkCount; i++) {
      if (
        file.upload.chunks[i] &&
        typeof file.upload.chunks[i].progress !== "undefined"
      ) {
        file.upload.progress += file.upload.chunks[i].progress;
        file.upload.total += file.upload.chunks[i].total;
        file.upload.bytesSent += file.upload.chunks[i].bytesSent;
      }
    }
    file.upload.progress = file.upload.progress / file.upload.totalChunkCount;

    this.emit(
      "uploadprogress",
      file,
      file.upload.progress,
      file.upload.bytesSent
    );
  }
}

_finishedUploading(files, xhr, e) {
  let response;

  if (files[0].status === Dropzone.CANCELED) {
    return;
  }

  if (xhr.readyState !== 4) {
    return;
  }

  if (xhr.responseType !== "arraybuffer" && xhr.responseType !== "blob") {
    response = xhr.responseText;

    if (
      xhr.getResponseHeader("content-type") &&
      ~xhr.getResponseHeader("content-type").indexOf("application/json")
    ) {
      try {
        response = JSON.parse(response);
      } catch (error) {
        e = error;
        response = "Invalid JSON response from server.";
      }
    }
  }

  this._updateFilesUploadProgress(files, xhr);

  if (!(200 <= xhr.status && xhr.status < 300)) {
    this._handleUploadError(files, xhr, response);
  } else {
    if (files[0].upload.chunked) {
      files[0].upload.finishedChunkUpload(
        this._getChunk(files[0], xhr),
        response
      );
    } else {
      this._finished(files, response, e);
    }
  }
}

_handleUploadError(files, xhr, response) {
  if (files[0].status === Dropzone.CANCELED) {
    return;
  }

  if (files[0].upload.chunked && this.options.retryChunks) {
    let chunk = this._getChunk(files[0], xhr);
    if (chunk.retries++ < this.options.retryChunksLimit) {
      this._uploadData(files, [chunk.dataBlock]);
      return;
    } else {
      console.warn("Retried this chunk too often. Giving up.");
    }
  }

  this._errorProcessing(
    files,
    response ||
    this.options.dictResponseError.replace("{{statusCode}}", xhr.status),
    xhr
  );
}

submitRequest(xhr, formData, files) {
  if (xhr.readyState != 1) {
    console.warn(
      "Cannot send this request because the XMLHttpRequest.readyState is not OPENED."
    );
    return;
  }
  xhr.send(formData);
}
_finished(files, responseText, e) {
  for (let file of files) {
    file.status = Dropzone.SUCCESS;
    this.emit("success", file, responseText, e);
    this.emit("complete", file);
  }
  if (this.options.uploadMultiple) {
    this.emit("successmultiple", files, responseText, e);
    this.emit("completemultiple", files);
  }

  if (this.options.autoProcessQueue) {
    return this.processQueue();
  }
}
_errorProcessing(files, message, xhr) {
  for (let file of files) {
    file.status = Dropzone.ERROR;
    this.emit("error", file, message, xhr);
    this.emit("complete", file);
  }
  if (this.options.uploadMultiple) {
    this.emit("errormultiple", files, message, xhr);
    this.emit("completemultiple", files);
  }

  if (this.options.autoProcessQueue) {
    return this.processQueue();
  }
}

  static uuidv4() {
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
    /[xy]/g,
    function (c) {
      let r = (Math.random() * 16) | 0,
        v = c === "x" ? r : (r & 0x3) | 0x8;
      return v.toString(16);
    }
  );
}
}
Dropzone.initClass();

Dropzone.version = "dev";
//

//

//

//

//

//

Dropzone.options = {};
Dropzone.optionsForElement = function (element) {

  if (element.getAttribute("id")) {
    return Dropzone.options[camelize(element.getAttribute("id"))];
  } else {
    return undefined;
  }
};
Dropzone.instances = [];
Dropzone.forElement = function (element) {
  if (typeof element === "string") {
    element = document.querySelector(element);
  }
  if ((element != null ? element.dropzone : undefined) == null) {
    throw new Error(
      "No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone."
    );
  }
  return element.dropzone;
};
Dropzone.autoDiscover = true;
Dropzone.discover = function () {
  let dropzones;
  if (document.querySelectorAll) {
    dropzones = document.querySelectorAll(".dropzone");
  } else {
    dropzones = [];

    let checkElements = (elements) =>
      (() => {
        let result = [];
        for (let el of elements) {
          if (/(^| )dropzone($| )/.test(el.className)) {
            result.push(dropzones.push(el));
          } else {
            result.push(undefined);
          }
        }
        return result;
      })();
    checkElements(document.getElementsByTagName("div"));
    checkElements(document.getElementsByTagName("form"));
  }

  return (() => {
    let result = [];
    for (let dropzone of dropzones) {

      if (Dropzone.optionsForElement(dropzone) !== false) {
        result.push(new Dropzone(dropzone));
      } else {
        result.push(undefined);
      }
    }
    return result;
  })();
};
//
//

//
Dropzone.blockedBrowsers = [

  /opera.*(Macintosh|Windows Phone).*version\/12/i,
];
Dropzone.isBrowserSupported = function () {
  let capableBrowser = true;

  if (
    window.File &&
    window.FileReader &&
    window.FileList &&
    window.Blob &&
    window.FormData &&
    document.querySelector
  ) {
    if (!("classList" in document.createElement("a"))) {
      capableBrowser = false;
    } else {
      if (Dropzone.blacklistedBrowsers !== undefined) {
        Dropzone.blockedBrowsers = Dropzone.blacklistedBrowsers;
      }

      for (let regex of Dropzone.blockedBrowsers) {
        if (regex.test(navigator.userAgent)) {
          capableBrowser = false;
          continue;
        }
      }
    }
  } else {
    capableBrowser = false;
  }

  return capableBrowser;
};

Dropzone.dataURItoBlob = function (dataURI) {
  let byteString = atob(dataURI.split(",")[1]);
  let mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
  let ab = new ArrayBuffer(byteString.length);
  let ia = new Uint8Array(ab);
  for (
    let i = 0, end = byteString.length, asc = 0 <= end;
    asc ? i <= end : i >= end;
    asc ? i++ : i--
  ) {
    ia[i] = byteString.charCodeAt(i);
  }
  return new Blob([ab], { type: mimeString });
};
const without = (list, rejectedItem) =>
  list.filter((item) => item !== rejectedItem).map((item) => item);
const camelize = (str) =>
  str.replace(/[\-_](\w)/g, (match) => match.charAt(1).toUpperCase());
Dropzone.createElement = function (string) {
  let div = document.createElement("div");
  div.innerHTML = string;
  return div.childNodes[0];
};
Dropzone.elementInside = function (element, container) {
  if (element === container) {
    return true;
  }
  while ((element = element.parentNode)) {
    if (element === container) {
      return true;
    }
  }
  return false;
};

Dropzone.getElement = function (el, name) {
  let element;
  if (typeof el === "string") {
    element = document.querySelector(el);
  } else if (el.nodeType != null) {
    element = el;
  }
  if (element == null) {
    throw new Error(
      `Invalid \`${name}\` option provided. Please provide a CSS selector or a plain HTML element.`
    );
  }
  return element;
};

Dropzone.getElements = function (els, name) {
  let el, elements;
  if (els instanceof Array) {
    elements = [];
    try {
      for (el of els) {
        elements.push(this.getElement(el, name));
      }
    } catch (e) {
      elements = null;
    }
  } else if (typeof els === "string") {
    elements = [];
    for (el of document.querySelectorAll(els)) {
      elements.push(el);
    }
  } else if (els.nodeType != null) {
    elements = [els];
  }

  if (elements == null || !elements.length) {
    throw new Error(
      `Invalid \`${name}\` option provided. Please provide a CSS selector, a plain HTML element or a list of those.`
    );
  }

  return elements;
};
//
Dropzone.confirm = function (question, accepted, rejected) {
  if (window.confirm(question)) {
    return accepted();
  } else if (rejected != null) {
    return rejected();
  }
};
//

Dropzone.isValidFile = function (file, acceptedFiles) {
  if (!acceptedFiles) {
    return true;
  }
  acceptedFiles = acceptedFiles.split(",");

  let mimeType = file.type;
  let baseMimeType = mimeType.replace(/\/.*$/, "");

  for (let validType of acceptedFiles) {
    validType = validType.trim();
    if (validType.charAt(0) === ".") {
      if (
        file.name
          .toLowerCase()
          .indexOf(
            validType.toLowerCase(),
            file.name.length - validType.length
          ) !== -1
      ) {
        return true;
      }
    } else if (/\/\*$/.test(validType)) {

      if (baseMimeType === validType.replace(/\/.*$/, "")) {
        return true;
      }
    } else {
      if (mimeType === validType) {
        return true;
      }
    }
  }

  return false;
};
if (typeof jQuery !== "undefined" && jQuery !== null) {
  jQuery.fn.dropzone = function (options) {
    return this.each(function () {
      return new Dropzone(this, options);
    });
  };
}
Dropzone.ADDED = "added";

Dropzone.QUEUED = "queued";
Dropzone.ACCEPTED = Dropzone.QUEUED;

Dropzone.UPLOADING = "uploading";
Dropzone.PROCESSING = Dropzone.UPLOADING;

Dropzone.CANCELED = "canceled";
Dropzone.ERROR = "error";
Dropzone.SUCCESS = "success";

/*

 Bugfix for iOS 6 and 7
 Source: http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
 based on the work of https://github.com/stomita/ios-imagefile-megapixel

 */
let detectVerticalSquash = function (img) {
  let iw = img.naturalWidth;
  let ih = img.naturalHeight;
  let canvas = document.createElement("canvas");
  canvas.width = 1;
  canvas.height = ih;
  let ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  let { data } = ctx.getImageData(1, 0, 1, ih);
  let sy = 0;
  let ey = ih;
  let py = ih;
  while (py > sy) {
    let alpha = data[(py - 1) * 4 + 3];

    if (alpha === 0) {
      ey = py;
    } else {
      sy = py;
    }

    py = (ey + sy) >> 1;
  }
  let ratio = py / ih;

  if (ratio === 0) {
    return 1;
  } else {
    return ratio;
  }
};
var drawImageIOSFix = function (ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
  let vertSquashRatio = detectVerticalSquash(img);
  return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
};
class ExifRestore {
  static initClass() {
    this.KEY_STR =
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  }

  static encode64(input) {
    let output = "";
    let chr1 = undefined;
    let chr2 = undefined;
    let chr3 = "";
    let enc1 = undefined;
    let enc2 = undefined;
    let enc3 = undefined;
    let enc4 = "";
    let i = 0;
    while (true) {
      chr1 = input[i++];
      chr2 = input[i++];
      chr3 = input[i++];
      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;
      if (isNaN(chr2)) {
        enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
        enc4 = 64;
      }
      output =
        output +
        this.KEY_STR.charAt(enc1) +
        this.KEY_STR.charAt(enc2) +
        this.KEY_STR.charAt(enc3) +
        this.KEY_STR.charAt(enc4);
      chr1 = chr2 = chr3 = "";
      enc1 = enc2 = enc3 = enc4 = "";
      if (!(i < input.length)) {
        break;
      }
    }
    return output;
  }

  static restore(origFileBase64, resizedFileBase64) {
    if (!origFileBase64.match("data:image/jpeg;base64,")) {
      return resizedFileBase64;
    }
    let rawImage = this.decode64(
      origFileBase64.replace("data:image/jpeg;base64,", "")
    );
    let segments = this.slice2Segments(rawImage);
    let image = this.exifManipulation(resizedFileBase64, segments);
    return `data:image/jpeg;base64,${this.encode64(image)}`;
  }

  static exifManipulation(resizedFileBase64, segments) {
    let exifArray = this.getExifArray(segments);
    let newImageArray = this.insertExif(resizedFileBase64, exifArray);
    let aBuffer = new Uint8Array(newImageArray);
    return aBuffer;
  }

  static getExifArray(segments) {
    let seg = undefined;
    let x = 0;
    while (x < segments.length) {
      seg = segments[x];
      if ((seg[0] === 255) & (seg[1] === 225)) {
        return seg;
      }
      x++;
    }
    return [];
  }

  static insertExif(resizedFileBase64, exifArray) {
    let imageData = resizedFileBase64.replace("data:image/jpeg;base64,", "");
    let buf = this.decode64(imageData);
    let separatePoint = buf.indexOf(255, 3);
    let mae = buf.slice(0, separatePoint);
    let ato = buf.slice(separatePoint);
    let array = mae;
    array = array.concat(exifArray);
    array = array.concat(ato);
    return array;
  }

  static slice2Segments(rawImageArray) {
    let head = 0;
    let segments = [];
    while (true) {
      var length;
      if ((rawImageArray[head] === 255) & (rawImageArray[head + 1] === 218)) {
        break;
      }
      if ((rawImageArray[head] === 255) & (rawImageArray[head + 1] === 216)) {
        head += 2;
      } else {
        length = rawImageArray[head + 2] * 256 + rawImageArray[head + 3];
        let endPoint = head + length + 2;
        let seg = rawImageArray.slice(head, endPoint);
        segments.push(seg);
        head = endPoint;
      }
      if (head > rawImageArray.length) {
        break;
      }
    }
    return segments;
  }

  static decode64(input) {
    let output = "";
    let chr1 = undefined;
    let chr2 = undefined;
    let chr3 = "";
    let enc1 = undefined;
    let enc2 = undefined;
    let enc3 = undefined;
    let enc4 = "";
    let i = 0;
    let buf = [];

    let base64test = /[^A-Za-z0-9\+\/\=]/g;
    if (base64test.exec(input)) {
      console.warn(
        "There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\nExpect errors in decoding."
      );
    }
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    while (true) {
      enc1 = this.KEY_STR.indexOf(input.charAt(i++));
      enc2 = this.KEY_STR.indexOf(input.charAt(i++));
      enc3 = this.KEY_STR.indexOf(input.charAt(i++));
      enc4 = this.KEY_STR.indexOf(input.charAt(i++));
      chr1 = (enc1 << 2) | (enc2 >> 4);
      chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
      chr3 = ((enc3 & 3) << 6) | enc4;
      buf.push(chr1);
      if (enc3 !== 64) {
        buf.push(chr2);
      }
      if (enc4 !== 64) {
        buf.push(chr3);
      }
      chr1 = chr2 = chr3 = "";
      enc1 = enc2 = enc3 = enc4 = "";
      if (!(i < input.length)) {
        break;
      }
    }
    return buf;
  }
}
ExifRestore.initClass();

/*
 * contentloaded.js
 *
 * Author: Diego Perini (diego.perini at gmail.com)
 * Summary: cross-browser wrapper for DOMContentLoaded
 * Updated: 20101020
 * License: MIT
 * Version: 1.2
 *
 * URL:
 * http://javascript.nwbox.com/ContentLoaded/
 * http://javascript.nwbox.com/ContentLoaded/MIT-LICENSE
 */
let contentLoaded = function (win, fn) {
  let done = false;
  let top = true;
  let doc = win.document;
  let root = doc.documentElement;
  let add = doc.addEventListener ? "addEventListener" : "attachEvent";
  let rem = doc.addEventListener ? "removeEventListener" : "detachEvent";
  let pre = doc.addEventListener ? "" : "on";
  var init = function (e) {
    if (e.type === "readystatechange" && doc.readyState !== "complete") {
      return;
    }
    (e.type === "load" ? win : doc)[rem](pre + e.type, init, false);
    if (!done && (done = true)) {
      return fn.call(win, e.type || e);
    }
  };

  var poll = function () {
    try {
      root.doScroll("left");
    } catch (e) {
      setTimeout(poll, 50);
      return;
    }
    return init("poll");
  };

  if (doc.readyState !== "complete") {
    if (doc.createEventObject && root.doScroll) {
      try {
        top = !win.frameElement;
      } catch (error) { }
      if (top) {
        poll();
      }
    }
    doc[add](pre + "DOMContentLoaded", init, false);
    doc[add](pre + "readystatechange", init, false);
    return win[add](pre + "load", init, false);
  }
};
Dropzone._autoDiscoverFunction = function () {
  if (Dropzone.autoDiscover) {
    return Dropzone.discover();
  }
};
contentLoaded(window, Dropzone._autoDiscoverFunction);

function __guard__(value, transform) {
  return typeof value !== "undefined" && value !== null
    ? transform(value)
    : undefined;
}
function __guardMethod__(obj, methodName, transform) {
  if (
    typeof obj !== "undefined" &&
    obj !== null &&
    typeof obj[methodName] === "function"
  ) {
    return transform(obj, methodName);
  } else {
    return undefined;
  }
}

export { Dropzone };
