"use strict";

/**
 *  Using for production
 */
var Socket = {

    /**
     * Is WebSockets support
     *
     * @type {boolean}
     */
    isSupported : ("WebSocket" in window && window.WebSocket != undefined),

    /**
     * Connection config
     */
    config : {
        protocol : 'ws://',
        host: '127.0.0.1',
        port: 9003,
        route: '/sonar',
    },

    /**
     * Url to connect
     */
    url : function() {
        return this.config.protocol + this.config.host +':'+this.config.port+''+this.config.route;
    },


    /**
     * Create socket connect
     *
     * @param {string} page
     * @return Socket
     */
    create : function() {

        if(!this.isSupported) {
            this.notify('error', 'Websockets dooes not supported');
        }

        /**
         * Connect identifier
         *
         * @param {string} url
         * @param {...string} protocols
         * @constructor
         */
        var connect = window['MozWebSocket'] ? new MozWebSocket(this.url()) : new WebSocket(this.url());

        /**
         * Socket message open
         *
         * @param {Event} event
         */
        connect.onopen = function (event) {
            if(connect.readyState === connect.OPEN) {
                Socket.notify(event.type, 'Connected to '+ Socket.url());
            }
        };

        /**
         * Socket message received event
         *
         * @param {String|ArrayBuffer|ArrayBufferView|Blob} message
         */
        connect.onmessage = function (message) {

            Socket.notify('received', message.data);
        };

        /**
         * Socket close event
         *
         * @param {Event} event
         */
        connect.onclose = function(event) {
            Socket.notify(event.type, 'Socket closed');
        };

        /**
         * Socket close event
         *
         * @param {Event} event
         */
        connect.onerror = function(event) {
            Socket.notify(event.type, 'Sorry, the web socket at '+ Socket.url() +' is unavailable');
        };

        this.connect = connect;

        return this;
    },

    /**
     * Notifier
     *
     * @param type
     * @param message
     */
    notify : function(type, message) {
        document.getElementById(type).innerHTML = message;
        console.info('[' + type.toUpperCase()+ '] ', message);
    },

    /**
     * Access watching
     *
     * @param {WebSocket} socket
     * @param {function} callback
     */
    wait : function(socket, callback) {

        var then = this;

        setTimeout(function() {
            if(socket.readyState === socket.OPEN) {
                callback();
            } else {
                then.wait(socket, callback);
            }
        }, 5);
    },

    /**
     * Send data to server
     *
     * @param {string} url
     */
    send : function(url) {

        var then = this;
        this.wait(this.connect, function() {
            then.connect.send(JSON.stringify({'page' : url}));
        });
    }
};

// run
Socket.create().send(document.URL);