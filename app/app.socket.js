(function(angular) {

    "use strict";

    angular.module('app.socket', []);

            /**
             * Is WebSockets support
             *
             * @type {boolean}
             */
            var isSupported = (window.hasOwnProperty('WebSocket') && window.WebSocket != undefined);

            /**
             * WebSockets connection
             *
             * @type {WebSocket}
             */
            var socket = null;

            /**
             * Current page
             *
             * @type {string}
             */
            var page = null;


            if(isSupported) {

                angular.module('app.socket')
                    .service('Socket', [function() {

                        return {

                            /**
                             * Create socket connection instance
                             *
                             * @param string route initialize route
                             */
                            create : function(route) {

                                page = route;

                                if(!(socket instanceof WebSocket)) {
                                    socket = new WebSocket(CONFIG.SOCKET.SERVER)

                                    // open connection to socket
                                    socket.onopen = function() {
                                        socket.send(JSON.stringify({'page' : page}));
                                        (CONFIG.DEBBUG === true) ? debug('Connection established', CONFIG.SOCKET.SERVER) : null;
                                    };

                                    // socket message handler
                                    socket.onmessage = function(event) {
                                        (CONFIG.DEBBUG === true) ? debug('Send :', event.data) : null;
                                    };

                                    // close connection to socket
                                    socket.onclose = function() {
                                        (CONFIG.DEBBUG === true) ? debug('Connection close', CONFIG.SOCKET.SERVER) : null;
                                    };
                                }
                            },

                            /**
                             * Send message to server (current page)
                             */
                            message : function() {
                                socket.send(JSON.stringify({'page' : page}));
                            },
                        };
                    }
                ]
            );
        }

})(angular);