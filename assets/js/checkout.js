/*!
 * paypalincontextjs
 * @version 3.4.2
 * @timestamp 01-20-2016
 *
 * Copyright PayPal
 *
 * Licensed under the Apache License, Version 2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 */

(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var constants = require('./constants');
var cookies = require('./cookies');
var device = require('./device');
var dom = require('./dom');
var events = require('./events');
var guid = require('./guid');

require('./shim');

(function () {
    /** PRIVATE **/

    /**
     * Logs the msg to the console.
     * @param {string} msg to print in console
     * @returns {null}
     */
    function _log(msg) {
        if (window.console) {
            console.log(msg);
        }
    }

    var paypal = paypal || {};
    if (window.paypal && window.paypal.checkout) {
        _log(constants.ERROR_MESSAGES.PAYPAL_GLOBAL_OVERRIDE);
        return;
    }
    (function () {

        /**
         * Creates an instance of the in-context MiniBrowser UI
         * @param {Object} userConfig Overrides to the default configuration
         */
        paypal.checkout = (function () {
            var app = {},
                config = {
                    name: constants.MINI_BROWSER_NAME, // This is eventually changed to something like: PPFrame1a2b3c4d5e, etc.
                    css: 'body.PPFrame {        overflow: hidden;}#PPFrame {        z-index: 20002;        top: 0;        left: 0;}#PPFrame .ppICMask {        z-index: 20001;        position: absolute;        top: 0;        left: 0;        background-color: black;        background-image: radial-gradient(circle farthest-corner, #000000, #4A4A4A);        opacity: 0.80;        filter: alpha(opacity=80);}#PPFrame .ppmodal {        font-family: "HelveticaNeue", "HelveticaNeue-Light", "Helvetica Neue Light", helvetica, arial, sans-serif;        font-size: 14px;        text-align: center;        color: #fff;        z-index: 20003;        -webkit-box-sizing: border-box;        -moz-box-sizing: border-box;        -ms-box-sizing: border-box;        box-sizing: border-box;        width: 350px;        top: 50%;        left: 50%;        position: fixed;        margin-left: -165px;        margin-top: -80px;}#PPFrame .loading .spinner {        height: 30px;        width: 30px;        position:absolute;        left: 48%;        top: 50%;        margin: -15px auto auto -15px;        opacity: 1;        filter: alpha(opacity=100);        background-color: rgba(255, 255, 255, 0.701961);        -webkit-animation: rotation .7s infinite linear;        -moz-animation: rotation .7s infinite linear;        -o-animation: rotation .7s infinite linear;        animation: rotation .7s infinite linear;        border-left: 8px solid rgba(0,0,0,.20);        border-right: 8px solid rgba(0,0,0,.20);        border-bottom: 8px solid rgba(0,0,0,.20);        border-top: 8px solid rgba(33,128,192,1);        border-radius: 100%;}@-webkit-keyframes rotation {        from {                -webkit-transform: rotate(0deg);        }        to {                -webkit-transform: rotate(359deg);        }}@-moz-keyframes rotation {        from {                -moz-transform: rotate(0deg);        }        to {                -moz-transform: rotate(359deg);        }}@-o-keyframes rotation {        from {                -o-transform: rotate(0deg);        }        to {                -o-transform: rotate(359deg);        }}@keyframes rotation {        from {                transform: rotate(0deg);        }        to {                transform: rotate(359deg);        }}#PPFrame .loading.noanimation .spinner {        height: 48px;        width: 48px;        border: none;        background: url(https://www.paypalobjects.com/webstatic/checkout/hermes/icon_loader_med.gif) no-repeat center center;}#PPFrame .ppmodal.loading {        min-height: 160px;}#PPFrame .ppmodal .pplogo {        background: url(https://www.paypalobjects.com/webstatic/checkout/hermes/mb_sprite.png) no-repeat 0 0;        width: 94px;        height: 25px;        margin: 0 0 26px 130px;}#PPFrame .ppmodal .closeButton {        position: fixed;        top: 10px;        right: 10px;        display: inline-block;        text-indent: -999em;        cursor: pointer;        width: 20px;        height: 20px;        background: url("https://www.paypalobjects.com/webstatic/checkout/hermes/flat/hermes_window_sprite_v6_2x.png");        background-size: 250px;        background-position: -222px 0;        background-repeat: no-repeat;}#PPFrame .ppmodal .text {        font-size: 14px;}#PPFrame .ppmodal a.button {        display: block;        cursor: pointer;        margin-top: 20px;        color: #0088cc;}#PPFrame .ppmodal a.ppbutton {        display: block;        cursor: pointer;        margin-top: 20px;        color: #0088cc;}@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: ~"2/1"), only screen and (min-device-pixel-ratio: 2) {        #PPFrame .ppmodal .pplogo {                background: url(https://www.paypalobjects.com/webstatic/checkout/hermes/mb_sprite_2x.png) no-repeat 0 0;                background-size: 100px 75px;        }}',
                    secureWindow: constants.CONTENT_SECURE_WINDOW, // This can be modified by the parent app
                    locale: constants.DEFAULT_LOCALE, // This can be modified by the parent app
                    trigger: null,
                    isSmartPhone: false,
                    isWebView: false,
                    merchantID: null,
                    showMiniB: true,
                    sandBox: false,
                    devMode: false,
                    version: '3.0',
                    log: true,
                    cookiedExp: cookies.getItem('PPXOEXP'),
                    debug: cookies.getItem('PPDEBUG'),
                    oldIe: navigator.userAgent.match(/MSIE [87]\./i),
                    // IE<10 can only postmessage from window to iframe
                    needsIframeBridge: !!navigator.userAgent.match(/MSIE/i),
                    prefetchLoaded: false,
                    currentAgent: device.getAgent(),
                    merchantConfig: null,
                    guid: null,
                    enableOneTouch: true
                },
                requireBtnJs = false,
                btnList = [],
                isOpen = false,
                errMsg = '', // eslint-disable-line no-unused-vars
                ecToken = null,
                jsBtnConfigs = [],
                setupCalled = false,
                oneTouchShowed = false,
                merchantServiceUrl = null;


            app.urlPrefix = '';


            /**
             * Tracking various events
             * @param {object} msg to send via beacon
             * @returns {null}
             */
            function _track(msg, isError) {
                // var fpti = 'https://t.paypal.com/ts?v=0.1&pgrp=INTEGRATION_JS_LOG&page=INTEGRATION_JS_LOG&tmpl=INTEGRATION_JS_LOG',
                var url = config.sandBox ? constants.SANDBOX_URL_ROOT : constants.LIVE_URL_ROOT,
                    msgStr;

                if (config.devMode) {
                    url = constants.LOCALHOST_URL_ROOT;
                }

                if (config.log && typeof msg === 'object') {
                    msg.merchantSite = document.domain;
                    msg.version = config.version;
                    msg.token = ecToken;
                    msg.guid = config.guid;
                    msg.oneTouchShowed = oneTouchShowed.toString();
                    msg.jsBtnConfig = jsBtnConfigs;
                    msg.status += jsBtnConfigs.length > 0 ? '_JS' : '';
                    msg.status += oneTouchShowed ? '_ONETOUCH' : '';

                    msgStr = JSON.stringify(msg);
                    msgStr = encodeURIComponent(msgStr);
                    url = url + '/webapps/' + (config.merchantConfig.app || 'hermes') + '/api/log?event=' + msg.status
                    + '&state=merchant_incontext&token=' + (ecToken ? ecToken : 'undefined') // token='undefined' for FEEL logging
                    + '&level=' + (isError ? 'error' : 'info')
                    + '&cb=' + Date.now()
                    + '&msg=' + msgStr;

                    var beacon = new Image();
                    beacon.src = url;

                    if (config.debug) {
                        _log(decodeURIComponent(msgStr));
                    }
                }
            }

            /**
             * Embeds the CSS for the UI into the document head
             */
            function _addCSS() {
                var css = config.css,
                    styleEl = document.createElement('style');

                css = css.replace(new RegExp('PPFrame', 'g'), config.name);

                styleEl.type = 'text/css';

                if (styleEl.styleSheet) {
                    styleEl.styleSheet.cssText = css;
                } else {
                    styleEl.appendChild(document.createTextNode(css));
                }

                config.css = css;

                document.getElementsByTagName('head')[0].appendChild(styleEl);
            }

            /* Creates the mask */
            function _createMask() {
                var mask = document.getElementById('ppICMask');
                var actualWidth = document.documentElement ? document.documentElement.clientWidth : window.innerWidth;
                var windowWidth, windowHeight, scrollWidth, scrollHeight, width, height;

                if (window.innerHeight && window.scrollMaxY) {
                    scrollWidth = actualWidth + window.scrollMaxX;
                    scrollHeight = window.innerHeight + window.scrollMaxY;
                } else if (document.body.scrollHeight > document.body.offsetHeight) {
                    scrollWidth = document.body.scrollWidth;
                    scrollHeight = document.body.scrollHeight;
                } else {
                    scrollWidth = document.body.offsetWidth;
                    scrollHeight = document.body.offsetHeight;
                }

                if (window.innerHeight) {
                    windowWidth = actualWidth;
                    windowHeight = window.innerHeight;
                } else if (document.documentElement && document.documentElement.clientHeight) {
                    windowWidth = document.documentElement.clientWidth;
                    windowHeight = document.documentElement.clientHeight;
                } else if (document.body) {
                    windowWidth = document.body.clientWidth;
                    windowHeight = document.body.clientHeight;
                }

                width = windowWidth > scrollWidth ? windowWidth : scrollWidth;
                height = windowHeight > scrollHeight ? windowHeight : scrollHeight;

                mask.style.width = width + 'px';
                mask.style.height = height + 'px';

                if (config.name && document.body.className.indexOf(config.name) === -1) {
                    document.body.className += ' ' + config.name;
                }
            }

            function _openMiniBrowser() {
                var left, top, win,
                    width = constants.MINI_BROWSER_WIDTH,
                    height = constants.MINI_BROWSER_HEIGHT,
                    winOpened = false,
                    loading = document.querySelector('#' + config.name + ' .ppmodal.loading');

                // Calculate the popup location based on parent window, need to center to the parent window.
                if (window.outerWidth) {
                    left = Math.round((window.outerWidth - width) / 2) + window.screenX;
                    top = Math.round((window.outerHeight - height) / 2) + window.screenY;
                } else if (window.screen.width) {
                    left = Math.round((window.screen.width - width) / 2);
                    top = Math.round((window.screen.height - height) / 2);
                }

                win = app.win = window.open('about:blank', config.name, 'top=' + top + ', left=' + left + ', width=' + width + ', height=' + height + ', location=1, status=1, toolbar=0, menubar=0, resizable=1, scrollbars=1');

                // (Backwards compatibility) Adding "win" to the global namespace for merchants from the past using internal APIS :|
                addToNamespace({
                    win: win
                });

                // Popup blocked case
                if (!win) {
                    _track({
                        status: 'IC_CLICK_OPEN_MB_FAILED'
                    }, true);
                    return window;
                // for sync ajax case
                } else if (ecToken) {
                    _track({
                        status: 'IC_CLICK_OPEN_MB_SUCCESS'
                    });
                }

                if (win && win.focus) {
                    win.focus();
                }

                if (loading) {
                    loading.className = 'ppmodal';
                }

                // Show the loading screen on the opened popup window till merchant does a 302 after setEC call
                try {
                    dom.injectLoadingInterstitial(win.document);
                } catch (err) {
                    // For IE9 and IE10 win.document gets permission denied if win.domain is reset to a new domain
                    try {
                        // this is hacky and should be replaced by something better asap
                        var docDomHax = 'javascript' + ':' + 'void((function(){document.open();document.domain="' + document.domain + '";})())';
                        win.location = docDomHax;
                        dom.injectLoadingInterstitial(win.document);
                    } catch (e) {
                        _log(constants.ERROR_MESSAGES.CANNOT_WRITE_TO_MINI_BROWSER);
                    }
                }

                winOpened = true;

                if (winOpened) {

                    var initUrl = win.location.href;

                    app.intVal = setInterval(function () {
                        if (win) {
                            // Polling minibrowser to detect if window is close, if closed redirect the parent window to return/cancel url
                            if (win.closed) {
                                clearInterval(app.intVal);
                                winOpened = false;
                                return _destroy();
                            }
                            else {
                                // when mb is opened, check whether merchant site page is loaded in mb
                                try {
                                    var currentUrl = win.location.href;
                                    // Skip checking if current url is undefined, empty string '', or 'about:blank'
                                    var isDifferentInitUrl = !!currentUrl && (initUrl !== currentUrl) && (currentUrl.indexOf('about:blank') === -1);
                                    // Skip checking if merchant service url is not defined in html (mostly ajax case)
                                    var isNotMerchantServiceUrlWhenPassed = (!merchantServiceUrl || currentUrl.indexOf(merchantServiceUrl) !== 0);
                                    // In case that paypal.com is the merchant or somehow the current page is the paypal checkout page
                                    var isPayPalCheckoutPage = (/paypal.com(.)+token=/gi).test(currentUrl);

                                    if (isDifferentInitUrl && isNotMerchantServiceUrlWhenPassed && !isPayPalCheckoutPage)
                                    {
                                        // merchant (not initial or service to call setec) page is loaded in mb
                                        clearInterval(app.intVal);
                                        _track({
                                            status: 'IC_MERCHANT_PAGE_LOADED_IN_MINIBROWSER'
                                        });
                                        winOpened = false;
                                        _destroy();
                                        window.location.href = currentUrl;
                                    }
                                } catch (e) {
                                    // showing non merchant site page, reset initUrl in case the new merchant page url
                                    // loaded in mb is the same as the initial one
                                    initUrl = null;
                                }
                            }
                        }

                    }, 500);
                }

                _listenMiniBrowser();

                return win;
            }

            function _onMessage(event) {
                var msg = document.querySelector('#' + config.name + ' .message'),
                    data;

                // Domain check to accept post messages from PayPal domain only or in dev mode
                if (event.origin.match(/paypal.com/i) || config.devMode) {
                    try {
                        data = JSON.parse(event.data);
                    } catch (e) {
                        data = event.data;
                    }

                    config.returnUrl = data.returnUrl;
                    config.landingUrl = data.landingUrl;

                    // (Backwards compatibility) data.secureWindowmsg for backwards compatibility
                    config.content = config.content || {};
                    config.secureWindow = data.secureWindowmsg || config.secureWindow;

                    // de-coding the urls
                    if (config.returnUrl) {
                        config.returnUrl = config.returnUrl.replace(/&amp;/g, '&');
                    }

                    if (config.landingUrl) {
                        config.landingUrl = config.landingUrl.replace(/&amp;/g, '&');
                    }

                    if (data.cancelUrl) {
                        config.cancelUrl = data.cancelUrl.replace(/&amp;/g, '&');
                    }

                    // Update the content from the post message response
                    if (msg) {
                        msg.innerHTML = config.secureWindow;
                    }

                    if (!ecToken && config.landingUrl) {
                        ecToken = getECToken(config.landingUrl);
                        // logging for non-ajax case
                        _track({
                            status: 'IC_CLICK_OPEN_MB_SUCCESS'
                        });
                    }

                    if (data.updateParent && config.returnUrl) {
                        if (msg) {
                            msg.innerHTML = constants.CONTENT_LOADING;
                        }
                        // top.location.href = config.returnUrl;
                        data.cancelUrl = null;
                        // config.cancelUrl = null;
                        _destroy();
                    }

                } else {
                    _log(constants.ERROR_MESSAGES.POSTMESSAGE_INVALID_ORIGIN);
                }
            }


            /**
             * Adds post message listener to listen for messages from MiniBrowser
             * @return {undefined}
             */
            function _listenMiniBrowser() {

                // Browsers that support postMessage
                if (window.postMessage) {

                    /**
                     * Event to listen for post messages sent from PayPal popup window.
                     * Data from PayPal will contains return url and the localised content.
                     */
                    events.addEvent(window, 'message', _onMessage);
                }
            }

            /**
             * Renders and displays the UI
             *
             * @return {object} The new popup window object the flow will appear in.
             */
            function _render() {

                try {

                    var elem = window.event ?
                       window.event.currentTarget || window.event.target || window.event.srcElement : this;

                    if (window.event) {
                        // if user is holding shift, control, or command, let the link do its thing
                        if (event.ctrlKey || event.shiftKey || event.metaKey) {
                            _track({
                                status: 'IC_RENDER_META_KEYPRESS'
                            });
                            return null;
                        }
                    }

                    // PXP decision return not to show in-context flow
                    if (config.showMiniB === false) {
                        return null;
                    }

                    if (elem && elem.form) {
                        elem.form.target = config.name;
                        merchantServiceUrl = elem.form.action;
                    } else if (elem && elem.tagName && elem.tagName.toLowerCase() === 'a') {
                        elem.target = config.name;
                        merchantServiceUrl = elem.href;
                    } else if (elem && elem.tagName && (elem.tagName.toLowerCase() === 'img' || elem.tagName.toLowerCase() === 'button') && elem.parentNode.tagName.toLowerCase() === 'a') {
                        elem.parentNode.target = config.name;
                        merchantServiceUrl = elem.parentNode.href;
                    } else if (elem && elem.tagName && elem.tagName.toLowerCase() === 'button' && elem.parentNode.parentNode.tagName.toLowerCase() === 'a') {
                        elem.parentNode.parentNode.target = config.name;
                        merchantServiceUrl = elem.parentNode.parentNode.href;
                    } else if (this && this.hasOwnProperty('target') && typeof this.target !== 'undefined') {   // not sure what this use case is
                        this.target = config.name;
                        merchantServiceUrl = this.action || this.href;
                    }
                    // If PayPal mask is not present only
                    if (!document.querySelectorAll('#' + config.name).length) {
                        dom.injectIncontext(null, config);
                        document.body.className = document.body.className + ' ' + config.name;
                        _createMask();
                        _bindEvents();
                    }

                    isOpen = true;

                    return _openMiniBrowser();
                } catch (err) {
                    _track({
                        status: 'IC_RENDER_ERROR',
                        error_msg: err
                    }, true);
                    errMsg = err;
                }

            }

            /**
             * Custom event which does some cleanup: all UI DOM nodes and custom events
             * are removed from the current page
             *
             * @param {Event} e The event object
             */
            function _destroy(event) {
                var wrapper = document.getElementById(config.name);

                // To avoid double refresh triggering from clear interval
                clearInterval(app.intVal);

                if (isOpen && wrapper && wrapper.parentNode) {
                    // Update the content from the post message response
                    // var msg = document.querySelector('#PPFrame .message');
                    var msg = document.querySelector('#' + config.name + ' .message');
                    if (msg && config.cancelUrl) {
                        msg.innerHTML = constants.CONTENT_LOADING;

                        if (!config.returnUrl) {
                            _track({
                                status: 'IC_DESTROY_TO_CANCEL_URL'
                            });

                            // From startFlow or single page apps with # cancel urls
                            if (config.fromStartFlow || window.location.href.split('#')[0] === config.cancelUrl.split('#')[0]) {
                                wrapper.parentNode.removeChild(wrapper);
                            }

                            window.location.replace(config.cancelUrl);
                        }

                    // if no cancel or return url is passed in
                    } else if (!config.returnUrl) {
                        wrapper.parentNode.removeChild(wrapper);
                        document.body.className = document.body.className.replace(config.name, '');
                        _track({
                            status: 'IC_DESTROY_NO_CANCEL_RETURN_URL'
                        });
                    }
                }

                _removeEvents();

                isOpen = false;

                if (app.win && app.win.close) {
                    app.win.close();
                }

                if (config.returnUrl) {
                    _track({
                        status: 'IC_DESTROY_TO_RETURN_URL'
                    });
                    if (config.fromStartFlow) {
                        if (isOpen && wrapper && wrapper.parentNode) {
                            wrapper.parentNode.removeChild(wrapper);
                        }
                    }
                    window.location.replace(config.returnUrl);
                }

            }

            /**
             *  Hides lightbox when user clicks Esc key.
             */
            function _toggleLightbox(event) {
                if (event.which === null && (event.charCode !== null || event.keyCode !== null)) {
                    event.which = event.charCode !== null ? event.charCode : event.keyCode;
                }
                if (event.which === 27) {
                    errMsg = constants.ERROR_MESSAGES.BUYER_CANCELLED_TRANSACTION;
                    _destroy();
                }
            }

            /**
             * Sets up the events for an instance
             */
            function _bindEvents() {
                var mask = document.getElementById('ppICMask');
                var closeButton = document.getElementById('closeButton');

                events.addEvent(mask, 'click', paypal.checkout.startFlow, this);
                events.addEvent(closeButton, 'click', _destroy, this);

                if (window.orientation) {
                    events.addEvent(window, 'orientationchange', _createMask, this);
                }
                events.addEvent(window, 'resize', _createMask, this);
                events.addEvent(window, 'unload', _destroy, this);
                events.addEvent(window, 'keyup', _toggleLightbox, this);
            }

            /**
             * Remove all the events for an instance
             */
            function _removeEvents() {
                if (window.orientation) {
                    events.removeEvent(window, 'orientationchange', _createMask);
                }
                events.removeEvent(window, 'resize', _createMask);
                events.removeEvent(window, 'unload', _destroy);
                events.removeEvent(window, 'keyup', _toggleLightbox);
            }

            function _clickHandler(event, clickFn, condFn) {
                if (condFn && !condFn()) {
                    return null;
                }

                if (clickFn) {
                    clickFn(event);
                } else {
                    _render.call(this, event);
                }
            }

            /*
             * Finds elements with data-paypal-button data attributes and adds click event listeners
             */
            function _setTriggers() {
                var i = btnList.length;

                while (i--) {
                    var btnObj = btnList[i];
                    _setTrigger(btnObj.element, btnObj.clickFn, btnObj.condFn);
                }
            }

            /*
             * Adds click event listeners
             */
            function _setTrigger(el, clickFn, condiFn) {
                events.addEvent(el, 'click', function(event) {
                    _clickHandler.call(this, event, clickFn, condiFn);
                }, this);
            }

            function _nao() {
                // get high-res time, fallback to classic datetime
                var perfNow = window.performance && window.performance.now && window.performance.now();
                var now = parseInt(perfNow || new Date().getTime(), 10);
                return now;
            }

            /**
            * Creates a function that will remove the iframe specified
            * @returns Function<void>
            */
            function _iframeTimedOut(iframe) {
                return function () {
                    // stop loading of iframe content
                    if (typeof (window.frames[iframe.name].stop) !== 'undefined') {
                        window.frames[iframe.name].stop();
                    } else {
                        window.frames[iframe.name].document.execCommand('Stop');
                    }
                    // remove listener for iframe load event
                    // since we didn't make it in time
                    iframe.onload = null;
                    iframe.parentNode.removeChild(iframe);

                };
            }

             /**
              * Creates a success handler function
              * that clears the failure timeout
              * @returns Function<void>
              */
            function _iframePrefetchLoaded(timer, name, start) {
                return function () {
                    var elapsed = _nao() - start;
                    config.prefetchLoaded = true;
                    _track({
                        status: 'IC_HERMES_PREFETCH_COMPLETE',
                        elapsed: elapsed
                    });
                    clearTimeout(timer);
                };
            }

            /**
             * Creates an invisible iframe (used for beacons, bridges, prefetch loaders) given a name and URL
             *
             * @returns {HTMLIFrameElement}
             */
            function _setupIframe(name, url) {
                var iframe;

                // workaround: IE6 + 7 won't let you name an iframe after you create it
                try {
                    iframe = document.createElement('<iframe name="' + name + '">');
                } catch (err) {
                    iframe = document.createElement('iframe');
                    iframe.name = name;
                }

                // batch write attributes as quick as possible
                iframe.setAttribute('style', 'margin: 0; padding: 0; border: 0px none; overflow: hidden;');
                iframe.setAttribute('frameborder', 0);
                iframe.setAttribute('border', 0);
                iframe.setAttribute('scrolling', 'no');
                iframe.setAttribute('allowTransparency', true);
                // accessibility attributes.
                // these prevent screenreaders from announcing
                // iframe contents or allowing navigation to these frames.
                iframe.setAttribute('tabindex', -1);
                iframe.setAttribute('hidden', true);
                iframe.setAttribute('title', '');
                iframe.setAttribute('role', 'presentation');

                // set the src to begin the loading process
                iframe.src = url;
                return iframe;
            }

            /**
             * Prefetches resources before user clicks checkout button and (hopefully) primes them in the browser's cache
             *
             * @returns {undefined}
             */
            function _setupPrefetchIframe() {
                var domain = config.sandBox ? constants.SANDBOX_URL_ROOT : constants.LIVE_URL_ROOT;
                var url = domain + constants.PREFETCH_CONTEXT_ROOT + (config.debug ? '?resources_prefetch=1' : '');
                var iframe = _setupIframe(constants.PREFETCH_NAME, url);

                // set up timeout so slow prefetch/bridge loading
                // doesn't affect IC rendering
                var timer = setTimeout(_iframeTimedOut(iframe), constants.LOADING_TIMEOUT);
                var start = _nao();
                var iframeSuccess = _iframePrefetchLoaded(timer, name, start);
                events.addEvent(iframe, 'load', iframeSuccess);

                document.body.appendChild(iframe);
            }

            /**
             * IE doesn't support cross domain post message. Create an iFrame Bridge to communicate between Mini browser and parent window.
             * This is only for IE
             * @returns {undefined}
             */
            function _setUpPayPalBridge() {
                var domain = config.sandBox ? constants.SANDBOX_URL_ROOT : constants.LIVE_URL_ROOT;
                var iframe = _setupIframe(constants.BRIDGE_NAME, domain + constants.BRIDGE_CONTEXT_ROOT);

                document.body.appendChild(iframe);
            }

            /**
             * Detects if the browser is MiniBrowser eligible.
             * @param {none}
             * @returns {boolean} true if eligible
             */
            function _isICEligible() {
                var userAgent = navigator.userAgent.toLowerCase();

                config.isSmartPhone = device.isDevice(userAgent);
                config.isWebView = device.isWebView(userAgent);

                if (typeof config.currentAgent === 'object' && config.currentAgent.length === 2) {
                    if (parseFloat(config.currentAgent[1]) < constants.SUPPORTED_AGENTS[config.currentAgent[0]]) {
                        _track({
                            status: 'IC_ELIGIBLITY_BROWSER_NOT_SUPPORTED',
                            browser: config.currentAgent[0],
                            browserversion: config.currentAgent[1]
                        });
                        return false;
                    }
                }

                return !(config.isSmartPhone || config.isWebView || config.oldIe);
            }


            /**
             * Renders the initial checkout flow on the page
             * Basically an init function
             */
            function _init() {

                window.name = window.name === config.name ? '' : window.name;

                // Add event listeners to PayPal trigger elements
                _setTriggers();

                // Do nothing if the device/browser is not eligible for in-context experience
                if (!_isICEligible()) {
                    config.showMiniB = false;
                    return;
                }

                if (config.needsIframeBridge) {
                    // SetUp PayPal Bridge
                    _setUpPayPalBridge();
                }

                // Setup prefetch iframe
                _setupPrefetchIframe();

                // Add PayPal specific css on the merchant site
                _addCSS();

                var gOldOnError = window.onerror;
                // Override previous handler.
                window.onerror = function errorHandler(errorMsg, url, lineNumber) {
                    if (config.debug === 'true') {
                        _track({
                            status: 'IC_WINDOW_ERROR',
                            errmsg: errorMsg,
                            url: url
                        }, true);
                    }

                    if (gOldOnError) {
                        return gOldOnError(errorMsg, url, lineNumber);
                    }
                    return false;
                };
            }

            function _getBtnContainers(el, result) {
                // either an array or nodelist
                if (el.constructor.toString().indexOf('Array') > -1 || el.length > 0 && typeof el.item !== 'undefined') {
                    for (var i = 0; i < el.length; i++) {
                        _getBtnContainers(el[i], result);
                    }
                } else {
                    var domEl = typeof el === 'string' ? document.getElementById(el) : el;

                    if (domEl) {
                        result.push(domEl);
                    } else {
                        _log(constants.ERROR_MESSAGES.SETUP_MISSING_ELEMENT + el);
                    }
                }
            }

            function _addButtonElement (container, btnOptions, clickFn, condFn) {

                var dataAttrs = {
                    lc: config.merchantConfig.locale || 'en_US',
                    color: btnOptions.color || 'gold',
                    size: btnOptions.size || 'small'
                };

                var buttonDom = window.paypal.button.create(config.merchantID, dataAttrs, { // eslint-disable-line no-undef
                    label: btnOptions.label,
                    type: 'button'
                });

                var buttonEle = buttonDom.el,
                    btnTagEle = buttonEle.getElementsByTagName('BUTTON')[0];

                if (config.enableOneTouch) {

                    if (!document.getElementById(constants.ONETOUCH_IFRAME_ID)) {
                        var oneTouchIframe = document.createElement('iframe');
                        oneTouchIframe.setAttribute('id', constants.ONETOUCH_IFRAME_ID);
                        oneTouchIframe.setAttribute('src', constants.ONETOUCH_IFRAME_URL);
                        oneTouchIframe.style.display = 'none';
                        document.body.appendChild(oneTouchIframe);
                        _listenOneTouch();
                    }
                }

                // should bind onclick event in here
                if (container.nodeName === 'A') {
                    btnList.push(_getBtnObject(container, clickFn, condFn));

                    // for IE8-, button inside of link doesn't work
                    if (config.oldIe) {
                        events.addEvent(btnTagEle, 'click', function() {
                            window.location = container.getAttribute('href');
                        });
                    }
                // a form
                } else {
                    btnList.push(_getBtnObject(btnTagEle, clickFn, condFn));
                }
                container.appendChild(buttonEle);

                // Add js button related options for tracking
                dataAttrs.label = btnOptions.label;
                jsBtnConfigs.push(dataAttrs);

            }

            function _listenOneTouch() {
                var eventMethod = window.addEventListener ? 'addEventListener' : 'attachEvent',
                    eventer = window[eventMethod],
                    data,
                    messageEvent = eventMethod === 'attachEvent' ? 'onmessage' : 'message';

                // Browsers that support postMessage
                if (window.postMessage) {
                    eventer(messageEvent, function (event) {

                        // Domain check to accept post messages from PayPal domain only or in dev mode
                        if (event.origin.match(/paypalobjects.com/i) || config.devMode || event.origin.match(/localhost:8100/i)) {
                            try {
                                data = JSON.parse(event.data);
                            } catch (e) {
                                data = event.data;
                            }

                            if (data.popupHtml) {
                                var taglineSpans = document.getElementsByClassName(constants.JS_BUTTON_TAGLINE_SPAN_STYLE);
                                for (var i = 0; i < taglineSpans.length; i++) {
                                    taglineSpans[i].innerHTML = data.popupHtml;
                                }

                                // track one touch rendering event
                                if (taglineSpans.length > 0) {
                                    oneTouchShowed = true;
                                    // Special tracking for one touch
                                    _track({'status': 'IC_RENDER'});
                                }
                            }

                            if (data.popupCss) {
                                var styleEl = document.createElement('style');
                                styleEl.type = 'text/css';
                                if (styleEl.stylesheet) {
                                    styleEl.stylesheet.cssText = data.popupCss;
                                } else {
                                    styleEl.appendChild(document.createTextNode(data.popupCss));
                                }

                                document.getElementsByTagName('head')[0].appendChild(styleEl);
                            }
                        }

                    }, false);
                }
            }

            function _getBtnObject(element, clickFn, condFn) {
                return {
                    element: element,
                    clickFn: clickFn,
                    condFn: condFn
                };
            }

            /**
             *   Create Javascript buttons if needed based on merchant's setup and then initialize
             */
            function _initWithButtonGeneration () {

                var merchantConfig = config.merchantConfig,
                    jsBtnIds = merchantConfig && merchantConfig.container,
                    customBtnIds = merchantConfig && merchantConfig.button,
                    jsBtnTypes = merchantConfig && merchantConfig.type || [],
                    color = merchantConfig && merchantConfig.color,
                    size = merchantConfig && merchantConfig.size,
                    condFn = merchantConfig && merchantConfig.condition,
                    clickFn = merchantConfig && merchantConfig.click,
                    btnsConfigList = merchantConfig && merchantConfig.buttons,
                    btnContainers = [];

                if (btnsConfigList && btnsConfigList.length) {
                    for (var i = 0; i < btnsConfigList.length; i++) {
                        var btnConfig = btnsConfigList[i];
                        var elId = btnConfig.container || btnConfig.button;
                        var elDom = typeof elId === 'string' ? document.getElementById(elId) : elId;

                        if (btnConfig.container) {
                            _addButtonElement(elDom, {
                                label: btnConfig.type || 'checkout',
                                color: btnConfig.color,
                                size: btnConfig.size
                            }, btnConfig.click, btnConfig.condition);
                        } else if (btnConfig.button) {
                            btnList.push(_getBtnObject(elDom, btnConfig.click, btnConfig.condition));
                        }
                    }
                } else {
                    // get all container list
                    _getBtnContainers(jsBtnIds || customBtnIds, btnContainers);

                    for (var j = 0; j < btnContainers.length; j++) {
                        if (customBtnIds) {
                            btnList.push(_getBtnObject(btnContainers[j], clickFn, condFn));
                        } else {
                            _addButtonElement(btnContainers[j], {
                                label: jsBtnTypes[j] || 'checkout',
                                color: color,
                                size: size
                            }, clickFn, condFn);
                        }
                    }
                }

                _track({
                    status: 'IC_SETUP',
                    'button-type': customBtnIds ? 'STATIC' : 'JS',
                    'button-number': btnList.length
                });

                _init();

                // to ensure users not able to click static buttons before script is loaded
                var hideBtns = document.querySelectorAll('.' + constants.STATIC_BUTTON_HIDDEN_STYLE);
                var hideBtnsLength = hideBtns.length;
                for (var k = 0; k < hideBtnsLength; k++) {
                    hideBtns[k].className = hideBtns[k].className.replace(constants.STATIC_BUTTON_HIDDEN_STYLE, '');
                }
            }

            function _requireLoadButtonJS() {
                if (window.paypal.button && window.paypal.button.create) { // eslint-disable-line no-undef
                    return false;
                }

                var merchantConfig = config.merchantConfig,
                    btnListConfig = merchantConfig.buttons;

                if (btnListConfig && btnListConfig.length) {
                    for (var i in btnListConfig) {
                        if (btnListConfig[i].container) {
                            return true;
                        }
                    }
                } else if (merchantConfig && merchantConfig.container) {
                    return true;
                }

                return false;
            }

            function _checkConditionAndLog(testValue, errorValue, errorStatus) {
                var verdict = (testValue === errorValue);
                if (verdict) {
                    _log(constants.ERROR_MESSAGES[errorStatus]);
                    _track({
                        status: errorStatus,
                        error_msg: constants.ERROR_MESSAGES[errorStatus]
                    });
                }
                return verdict;
            }

            function loadScript(url, callback) {
                var head = document.head || document.getElementsByTagName('head')[0] || document.documentElement;
                var script = document.createElement('script');

                script.async = 'async';
                script.src = url;

                script.onload = script.onreadystatechange = function (_, abort) {
                    if (abort || !script.readyState || (/loaded|complete/).test(script.readyState)) {
                        script.onload = script.onreadystatechange = null;

                        if (head && script.parentNode) {
                            head.removeChild(script);
                        }

                        script = undefined;

                        if (!abort) {
                            callback();
                        }
                    }
                };

                head.insertBefore(script, head.firstChild);
            }

            /** PUBLIC **/
            // paypal.checkout.setup(merchant, {
            //    container: 'myContainer',          // {String|HTMLElement|Array} Optional. `submit` and `click` events are hijacked when possible.
            //    button: 'myButton',                // {String|HTMLElement|Array} Optional. HTMLElement/ID of a custom buttom.
            //    locale: 'en_US',                   // {String} Optional. Local code for localization. Defaults to 'en_US'
            //    environment: 'production',         // {String} Optional. Defaults to 'production'. Possible options are 'sandbox'.
            //    app: 'hermes'                      // {String} Optional. Defaults to 'hermes'.  Possible options are 'xoonboarding'.
            //    click: function() {}               // {Function} Optional. Overrides the behavior when the button is clicked.
            //    condition: function() {}          // {Function} Optional. Boolean if the PayPal popup should when button is clicked.
            // });

            app.setup = function (merchantId, merchantConfig) {
                if (_checkConditionAndLog(setupCalled, true, 'IC_SETUP_CALLED_TWICE')) {
                    return;
                }

                config.guid = guid.getGUID();
                config.name += config.guid.substring(0, 8);
                config.merchantID = merchantId;
                config.locale = merchantConfig.locale || config.locale;

                if (_checkConditionAndLog(!merchantId, true, 'IC_SETUP_MERCHANTID_ERROR')) {
                    return;
                }

                config.merchantConfig = merchantConfig;
                config.sandBox = merchantConfig.environment === 'sandbox' ? true : false;

                if (config.sandBox) {
                    _log(constants.ERROR_MESSAGES.SANDBOX_BANNER);
                }

                app.urlPrefix = config.sandBox ? constants.SANDBOX_URL_PREFIX : constants.LIVE_URL_PREFIX;

                // (Backwards compatibility) Adding "urlPrefix" to the global namespace for merchants from the past using internal APIS :|
                addToNamespace({
                    urlPrefix: app.urlPrefix
                });

                requireBtnJs = _requireLoadButtonJS();

                if (requireBtnJs) {
                    // fetch button.js
                    loadScript(constants.BUTTON_JS_URL, _initWithButtonGeneration);
                } else {
                    _initWithButtonGeneration();
                }
                setupCalled = true;
            };

            /**
             * Public method to init the XO flow manually for ASYNC AJAX flow
             * This method need to be called before AJAX call is being made on merchant site
             * @param {null}
             */
            app.initXO = function () {

                // For non IC eligible browsers load the url in the same window
                if (!_isICEligible() || !config.showMiniB) {
                    return;
                }
                _checkConditionAndLog(setupCalled, false, 'IC_INITXO_CALLED_BEFORE_SETUP');
                config.win = _render();
            };

            /**
             * Public method to start the flow manually, e.g. from Flash
             * @param {string} url or token of the landing page that needs to be loaded in mini browser
             */
            app.startFlow = function (url) {
                _checkConditionAndLog(setupCalled, false, 'IC_STARTFLOW_CALLED_BEFORE_SETUP');

                if (app.win) {
                    if (app.win.focus) {
                        app.win.focus();
                    }

                    if (!url || typeof url === 'object') {
                        // if mini browser already opens and url is not passed or caused by clicking on mask, then it is a restart
                        return;
                    }
                }

                url = url || config.landingUrl;

                // url can be either an url or token
                // if token is passed in
                if (url && url.toLowerCase && url.toLowerCase().indexOf('ec-') === 0) {
                    url = app.urlPrefix + url;
                }

                if (url && url.match(/paypal.com/i)) {
                    config.fromStartFlow = true;
                }

                if (url) {
                    url = url.replace(/\s+$/, '');
                }

                try {
                    ecToken = getECToken(url);
                } catch (err) {
                    _log(constants.ERROR_MESSAGES.MISSING_EC_TOKEN);
                }

                // For non IC eligible browsers load the url in the same window
                if (!_isICEligible() || !config.showMiniB) {
                    if (url) {
                        location.href = url;
                    } else {
                        window.name = config.name;
                    }
                    return;
                }

                var win = config.win || _render();

                // If Mini browser is blocked by popup blocker assign the user to full context as fallback (legacy integrations)
                win = win || window;

                // If already Mini browser window is opened and changing the name in cross domain throws permission denied exception
                try {
                    win.name = win.name || config.name;
                } catch (err) {
                    _log(constants.ERROR_MESSAGES.MINI_BROWSER_ALREADY_OPEN);
                }

                if (config.prefetchLoaded) {
                    url += '&prefetch=1';
                }

                if (url) {
                    if (win.location) {
                        win.location = url;
                    } else {
                        win.src = url;
                    }
                }

                // for async ajax case.
                if (config.win) {
                    _track({
                        status: 'IC_CLICK_OPEN_MB_SUCCESS'
                    });
                }

            };

            /**
             * Public method to close the flow's UI
             */
            app.closeFlow = function (successUrl) {
                _destroy();

                if (successUrl) {
                    top.location.href = successUrl;
                }
            };

            // Return public methods
            return app;
        }());

        function getECToken(url) {
            var parts = url.split('EC-');
            return parts.length > 1 ? 'EC-' + parts[1].split('&')[0] : null;
        }

        // Expose global namespace
        addToNamespace({
            initXO: paypal.checkout.initXO,
            startFlow: paypal.checkout.startFlow,
            closeFlow: paypal.checkout.closeFlow,
            restartFlow: paypal.checkout.startFlow,
            setup: paypal.checkout.setup
        });

        // If the merchant defined a paypalCheckoutReady function, 
        // set it to run after window load
        if (typeof window.paypalCheckoutReady === 'function') {
            window.paypalCheckoutReady();
        }

    }());

    function addToNamespace(obj) {
        var namespace = window.PAYPAL || {};
        namespace.apps = namespace.apps || {};
        namespace.apps.Checkout = namespace.apps.Checkout || {};

        for (var prop in obj) {
            namespace.apps.Checkout[prop] = obj[prop];
        }

        // (Backwards compatibility) Setting up aliases for convenience
        namespace.checkout = namespace.apps.Checkout;

        // Export "PAYPAL" and "paypal" as globals
        window.PAYPAL = window.paypal = namespace;
    }

    // for backward compatibility
    function callNewSetup() {
        var oldButtonEl = document.querySelectorAll('[data-paypal-button]'),
            sandboxEl = document.querySelectorAll('[data-paypal-sandbox]'),
            merchantIdEl = document.querySelectorAll('[data-paypal-id]');

        // Don't construct setup call if merchant doesn't have any old configuration
        if (oldButtonEl.length || sandboxEl.length || merchantIdEl.length) {

            var oldButtons = oldButtonEl.length ? oldButtonEl : [],
                environment = sandboxEl.length ? 'sandbox' : 'production',
                merchantId = merchantIdEl.length ? merchantIdEl[0].getAttribute('data-paypal-id') : document.domain;

            paypal.checkout.setup(merchantId, {
                environment: environment,
                button: oldButtons
            });
        }
    }

    if (typeof window.paypalCheckoutReady !== 'function') {
        if (window.addEventListener) {
            window.addEventListener('load', callNewSetup, false);
        } else if (window.attachEvent) {
            window.attachEvent('onload', callNewSetup);
        }
    }
}());

},{"./constants":2,"./cookies":3,"./device":4,"./dom":5,"./events":6,"./guid":7,"./shim":8}],2:[function(require,module,exports){
'use strict';

module.exports = {
    // Max time we'll wait for an iframe load
    LOADING_TIMEOUT: 5000,
    // Bridge
    BRIDGE_NAME: 'PayPalBridge',
    BRIDGE_CONTEXT_ROOT: '/webapps/hermes/bridge',

    // Prefetch
    PREFETCH_NAME: 'prefetch',
    PREFETCH_CONTEXT_ROOT: '/webapps/hermes/prefetch',

    // Classes
    STATIC_BUTTON_HIDDEN_STYLE: 'paypal-button-hidden',

    // Content
    CONTENT_CLOSE_WINDOW: 'Close Window',
    CONTENT_LOADING: 'Loading...',
    CONTENT_SECURE_WINDOW: 'Don\'t see the secure PayPal browser? We\'ll help you re-launch the window to complete your purchase. <a onclick="paypal.checkout.startFlow();" class="ppbutton">Continue</a>',

    // Device
    SUPPORTED_AGENTS: {
        Chrome: 27,
        IE: 9,
        MSIE: 9,
        Firefox: 30,
        Safari: 5.1,
        Opera: 23
    },

    // Locale
    DEFAULT_LOCALE: 'en_US',

    // Mini-browser
    MINI_BROWSER_NAME: 'PPFrame',
    MINI_BROWSER_HEIGHT: 535,
    MINI_BROWSER_WIDTH: 450,

    // One touch related
    ONETOUCH_IFRAME_ID: 'paypalOneTouchIframe',
    JS_BUTTON_TAGLINE_SPAN_STYLE: 'paypal-button-tag-content',

    // URLs
    BUTTON_JS_URL: '//www.paypalobjects.com/api/button.js',
    ONETOUCH_IFRAME_URL: '//www.paypalobjects.com/api/oneTouch.html',
    LIVE_URL_PREFIX: 'https://www.paypal.com/checkoutnow?token=',
    LIVE_URL_ROOT: 'https://www.paypal.com',
    LOCALHOST_URL_ROOT: 'http://localhost:9000',
    SANDBOX_URL_PREFIX: 'https://www.sandbox.paypal.com/checkoutnow?token=',
    SANDBOX_URL_ROOT: 'https://www.sandbox.paypal.com',

    // Templates
    TEMPLATES: {"incontext":"<div id=\"ppICMask\" class=\"ppICMask\"></div><div class=\"<%=(error ? \"ppmodal\" : \"ppmodal loading\")%>\">    <div class=\"pplogo\"></div>    <div id=\"ppmsg\" class=\"message\"><%=secureWindow%></div>    <a id=\"closeButton\" class=\"closeButton\" role=\"button\"><%=closeWindow%></a>    <%=(error ? \"<div class='text'>\" + error + \"</div>\" : \"\")%></div>","loading":"<!DOCTYPE html><html lang=\"en\">    <head>        <title>PayPal</title>        <style>            body {                font-family: \"HelveticaNeue\", \"HelveticaNeue-Light\", \"Helvetica Neue Light\", helvetica, arial, sans-serif;                font-size: 95%;                color: #2c2e2f;            }            .spinner {                height: 100%;                width: 100%;                position: absolute;                z-index: 10;                background: red;            }            .spinner.preloader {                position: fixed;                top: 0;                left: 0;                z-index: 1000;                background-color: #fff;            }            .spinner {                height: 100%;                width: 100%;                position: absolute;                z-index: 10;            }            .spinner .spinWrap {                width: 200px;                position: absolute;                top: 40%;                left: 50%;                margin-left: -100px;            }            .spinner .loader {                height: 30px;                width: 30px;                position: absolute;                top: 0;                left: 50%;                margin: 0 0 0 -23px;                opacity: 1;                filter: alpha(opacity=100);                background-color: rgba(255, 255, 255, 0.701961);                -webkit-animation: rotation .7s infinite linear;                -moz-animation: rotation .7s infinite linear;                -o-animation: rotation .7s infinite linear;                animation: rotation .7s infinite linear;                border-left: 8px solid rgba(0, 0, 0, 0.2);                border-right: 8px solid rgba(0, 0, 0, 0.2);                border-bottom: 8px solid rgba(0, 0, 0, 0.2);                border-top: 8px solid #2180c0;                border-radius: 100%;            }            .spinner .loadingMessage {                -webkit-box-sizing: border-box;                -moz-box-sizing: border-box;                -ms-box-sizing: border-box;                box-sizing: border-box;                width: 100%;                margin-top: 55px;                text-align: center;                z-index: 100;            }            @-webkit-keyframes rotation {                from {                    -webkit-transform: rotate(0deg);                }                to {                    -webkit-transform: rotate(359deg);                }            }            @-moz-keyframes rotation {                from {                    -moz-transform: rotate(0deg);                }                to {                    -moz-transform: rotate(359deg);                }            }            @-o-keyframes rotation {                from {                    -o-transform: rotate(0deg);                }                to {                    -o-transform: rotate(359deg);                }            }            @keyframes rotation {                from {                    transform: rotate(0deg);                }                to {                    transform: rotate(359deg);                }            }            @media (max-width:30em) and (min-width:0) {                .spinner {                    position: fixed;                }            }        </style>    </head>    <body>        <div id=\"preloaderSpinner\" class=\"preloader spinner\">            <div class=\"spinWrap\">                <p class=\"loader\"></p>                <p class=\"loadingMessage\" id=\"spinnerMessage\"></p>            </div>        </div>    </body></html>"},
    ERROR_MESSAGES: {
        IC_SETUP_CALLED_TWICE: 'Error: You are calling paypal.checkout.setup() more than once. This function can only be called once per page load. Any further calls will be ignored.',
        PAYPAL_GLOBAL_OVERRIDE: 'Error: window.paypal.checkout already exists. You may have inserted the checkout.js script more than once. Ignoring further attempts to assign to window.paypal.checkout.',
        POSTMESSAGE_INVALID_ORIGIN: 'Message received from invalid domain',
        IC_SETUP_MERCHANTID_ERROR: 'Merchant id is required for setup!',
        SANDBOX_BANNER: 'PayPal Incontext is running in sandbox mode. This message will not appear in production mode',
        MISSING_EC_TOKEN: 'EC Token is not passed in url passed by ajax response',
        MINI_BROWSER_ALREADY_OPEN: 'Mini browser window already opened and trying to change name',
        CANNOT_WRITE_TO_MINI_BROWSER: 'unable to write to minibrowser',
        BUYER_CANCELLED_TRANSACTION: 'Buyer cancelled the transaction',
        SETUP_MISSING_ELEMENT: 'IC_SETUP_CONTAINER_ERROR: Can\'t find element ',
        IC_INITXO_CALLED_BEFORE_SETUP: 'paypal.checkout.initXO() was called before calling paypal.checkout.setup(). Please call paypal.checkout.setup() first.',
        IC_STARTFLOW_CALLED_BEFORE_SETUP: 'paypal.checkout.startFlow() was called before calling paypal.checkout.setup(). Please call paypal.checkout.setup() first.'
    }
};
},{}],3:[function(require,module,exports){
'use strict';

module.exports = {
    getItem: function (sKey) {
        if (!sKey) {
            return null;
        }
        return decodeURIComponent(document.cookie.replace(new RegExp('(?:(?:^|.*;)\\s*' + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=\\s*([^;]*).*$)|^.*$'), '$1')) || null;
    },
    setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if (!sKey || (/^(?:expires|max\-age|path|domain|secure)$/i).test(sKey)) {
            return false;
        }
        var sExpires = '';
        if (vEnd) {
            if (vEnd.constructor === Number) {
                sExpires = vEnd === Infinity ? '; expires=Fri, 31 Dec 9999 23:59:59 GMT' : '; max-age=' + vEnd;
            } else if (vEnd.constructor === String) {
                sExpires = '; expires=' + vEnd;
            } else if (vEnd.constructor === Date) {
                sExpires = '; expires=' + vEnd.toUTCString();
            }
        }
        document.cookie = encodeURIComponent(sKey) + '=' + encodeURIComponent(sValue) + sExpires + (sDomain ? '; domain=' + sDomain : '') + (sPath ? '; path=' + sPath : '') + (bSecure ? '; secure' : '');
        return true;
    },
    removeItem: function (sKey, sPath, sDomain) {
        if (!this.hasItem(sKey)) {
            return false;
        }
        document.cookie = encodeURIComponent(sKey) + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT' + (sDomain ? '; domain=' + sDomain : '') + (sPath ? '; path=' + sPath : '');
        return true;
    },
    hasItem: function (sKey) {
        if (!sKey) {
            return false;
        }
        return (new RegExp('(?:^|;\\s*)' + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=')).test(document.cookie);
    },
    keys: function () {
        var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, '').split(/\s*(?:\=[^;]*)?;\s*/); // eslint-disable-line fasec/no-unsafe-regex
        for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) {
            aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
        }
        return aKeys;
    }
};
},{}],4:[function(require,module,exports){
'use strict';

/**
 * Detects if the view is being rendered in mobile.
 * @param userAgent string
 * @returns {boolean} true if the view is loaded in mobile/tablet.
 */

function isDevice(userAgent) {
    if (userAgent.match(/Android|webOS|iPhone|iPad|iPod|bada|Symbian|Palm|CriOS|BlackBerry|IEMobile|WindowsMobile|Opera Mini/i)) {
        return true;
    }

    return false;
}

/**
 * Method to detect if the merchant page is in web view
 * @param userAgent string
 * @returns {boolean} True if web view
 */
function isWebView(userAgent) {
    return (/(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i).test(userAgent);
}

function getAgent() {
    var ua = navigator.userAgent, tem,
        M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(M[1])) {
        tem = (/\brv[ :]+(\d+)/g).exec(ua) || [];
        return ['IE', tem[1] || ''];
    }
    if (M[1] === 'Chrome') {
        tem = ua.match(/\bOPR\/(\d+)/);
        if (tem !== null) {
            return ['Opera', tem[1]];
        }
    }
    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+(\.\d{1,2}))/i)) !== null) {
        M.splice(1, 1, tem[1]);
    }
    return M;
}

module.exports = {
    getAgent: getAgent,
    isDevice: isDevice,
    isWebView: isWebView
};
},{}],5:[function(require,module,exports){
'use strict';

var constants = require('./constants');
var template = require('./util/template');

/**
 * Injects the incontext experience (mask, help text + mini browser) into the <body>
 */
function injectIncontext(options, config) {
    options = options || {};

    var incontextMarkup = template(constants.TEMPLATES.incontext, {
        error: options.error,
        secureWindow: config.secureWindow,
        closeWindow: constants.closeWindow
    });

    var incontextWrapper = document.createElement('div');
    incontextWrapper.id = config.name;
    incontextWrapper.innerHTML = incontextMarkup;

    document.body.appendChild(incontextWrapper);
}

/**
 * Injects the loading interstitial page into "el"
 */
function injectLoadingInterstitial(el) {
    var loadingMarkup = template(constants.TEMPLATES.loading, {});

    el.write(loadingMarkup);
}

module.exports = {
    injectIncontext: injectIncontext,
    injectLoadingInterstitial: injectLoadingInterstitial
};
},{"./constants":2,"./util/template":9}],6:[function(require,module,exports){
'use strict';

/**
 * Storage object for all events; used to obtain exact signature when
 * removing events
 */
var eventCache = [];

/**
 * Normalized method of adding an event to an element
 *
 * @param {HTMLElement} obj The object to attach the event to
 * @param {String} type The type of event minus the 'on'
 * @param {Function} fn The callback function to add
 * @param {Object} scope A custom scope to use in the callback (optional)
 */
function addEvent(obj, type, fn, scope) {
    scope = scope || obj;

    var wrappedFn;

    if (obj.addEventListener) {
        wrappedFn = function (event) {
            fn.call(scope, event);
        };
        obj.addEventListener(type, wrappedFn, false);
    } else if (obj.attachEvent) {
        wrappedFn = function () {
            var e = window.event;
            // e.target = e.target || e.srcElement;

            e.preventDefault = function () {
                window.event.returnValue = false;
            };

            fn.call(scope, e);
        };

        obj.attachEvent('on' + type, wrappedFn);
    }

    eventCache.push([obj, type, fn, wrappedFn]);
}

/**
 * Normalized method of removing an event from an element
 *
 * @param {HTMLElement} obj The object to attach the event to
 * @param {String} type The type of event minus the 'on'
 * @param {Function} fn The callback function to remove
 */
function removeEvent(obj, type, fn) {
    var wrappedFn, item, i;

    for (i = 0; i < eventCache.length; i++) {
        item = eventCache[i];

        if (item[0] === obj && item[1] === type && item[2] === fn) {
            wrappedFn = item[3];

            if (wrappedFn) {
                if (obj.removeEventListener) {
                    obj.removeEventListener(type, wrappedFn, false);
                } else if (obj.detachEvent) {
                    obj.detachEvent('on' + type, wrappedFn);
                }
            }
        }
    }
}

module.exports = {
    addEvent: addEvent,
    removeEvent: removeEvent
};

},{}],7:[function(require,module,exports){
'use strict';

/**
 * Generates a GUID string.
 * @returns {String} The generated GUID.
 * @example af8a8416-6e18-a307-bd9c-f2c947bbb3aa
 * @author Slavik Meltser (slavik@meltser.info).
 * @link http://slavik.meltser.info/?p=142
 */
function getGUID() {
    function _p8(s) {
        var p = (Math.random().toString(16) + '000000000').substr(2, 8);
        return s ? '-' + p.substr(0, 4) + '-' + p.substr(4, 4) : p;
    }
    return _p8() + _p8(true) + _p8(true) + _p8();
}

module.exports = {
    getGUID: getGUID
};
},{}],8:[function(require,module,exports){
'use strict';

// JSON Polyfill for unsupported older browser
if (!window.JSON) {
    window.JSON = {
        parse: function (sJSON) { // eslint-disable-line strict
            return eval('(' + sJSON + ')'); // eslint-disable-line no-eval
        },
        stringify: function stringify (vContent) { // eslint-disable-line strict
            if (vContent instanceof Object) {
                var sOutput = '';
                if (vContent.constructor === Array) {
                    // @TODO: Does this line of code work? for loops can have 4 arguments? huh?
                    for (var nId = 0; nId < vContent.length; sOutput += this.stringify(vContent[nId]) + ',', nId++); // eslint-disable-line curly,no-extra-semi
                    return '[' + sOutput.substr(0, sOutput.length - 1) + ']';
                }
                if (vContent.toString !== Object.prototype.toString) {
                    return '\"' + vContent.toString().replace(/"/g, '\\$&') + '\"';
                }
                for (var sProp in vContent) {
                    sOutput += '\"' + sProp.replace(/"/g, '\\$&') + '\":' + this.stringify(vContent[sProp]) + ',';
                }
                return '{' + sOutput.substr(0, sOutput.length - 1) + '}';
            }
            return typeof vContent === 'string' ? '\"' + vContent.replace(/"/g, '\\$&') + '\"' : String(vContent);
        }
    };
}

// Date.now polyfill
if (!Date.now) {
    Date.now = function() { // eslint-disable-line strict
        return new Date().getTime();
    };
}
},{}],9:[function(require,module,exports){
/*eslint-disable */
'use strict';

/**
 * Didn't end up using a library like handlebars or ejs
 * because we want to keep this bundle as small as possible.
 */

// John Resig - http://ejohn.org/ - MIT Licensed
// Simple JavaScript Templating
// http://ejohn.org/blog/javascript-micro-templating/
var cache = {};

module.exports = function template(str, data) {
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    data = data || {};

    var fn = !/\W/.test(str) ?
        cache[str] = cache[str] ||
            template(document.getElementById(str).innerHTML) :

        // Generate a reusable function that will serve as a template
        // generator (and which will be cached).
        new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};" + "with(obj){p.push('" + str
            .replace(/[\r\t\n]/g, " ")
            .split("<%").join("\t")
            .replace(/((^|%>)[^\t]*)'/g, "$1\r")
            .replace(/\t=(.*?)%>/g, "',$1,'")
            .split("\t").join("');")
            .split("%>").join("p.push('")
            .split("\r").join("\\'") + "');}return p.join('');");

        return fn(data);
};
},{}]},{},[1,2,3,4,5,6,7,8,9]);
