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
     * Create socket connect
     *
     * @param {string} page
     * @return Socket
     */
    create : function() {

        if(!this.isSupported)
            throw Error('Websockets dooes not supported');

        console.info('[CONFIG]', this.config);

        /**
         * @type {WebSocket}
         */
        var connect = new WebSocket(this.config.protocol + this.config.host +':'+this.config.port+''+this.config.route);

        // socket connect event
        connect.onopen = function connectionOpened() {
            console.info('[SOCKET] Open connect');
        };

        // socket message event
        connect.onmessage = function messageReceived(message) {
            console.info('[SOCKET] Send', message.data);
        };

        // socket close event
        connect.onclose = function(event, reason) {
            console.info('[SOCKET] Close');
        };

        // socket error event
        connect.onerror = function(event) {
            console.info('[SOCKET] Error: '+event.data);
        };

        this.connect = connect;

        return this;
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

        console.info('[SEND]', url);

        var then = this;
        this.wait(this.connect, function() {
            then.connect.send(JSON.stringify({'page' : url}));
        });
    }
};

// run
Socket.create().send(document.URL);