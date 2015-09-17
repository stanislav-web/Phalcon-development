(function(angular) {

    "use strict";

    angular.module('app.socket', []);

        /**
         * Is WebSockets support
         *
         * @type {boolean}
         */
        var isSupported = (("WebSocket" in window && window.WebSocket != undefined) ||
                       ("MozWebSocket" in window)),

            /**
             * WebSockets connection
             *
             * @type {WebSocket}
             */
            connection = null;


        if(isSupported) {

            angular.module('app.socket')
                .service('Socket', [function() {

                    return {

                        /**
                         * Set visitor
                         *
                         * @param string route
                         */
                        setVisitor : function(route) {

                            if(connection === null) {
                                // create connection instance
                                connection = new WebSocket(CONFIG.SOCKET + '?page=' + route)
                            }

                            // open connection to socket
                            connection.onopen = function(e) {
                                (CONFIG.DEBBUG === true) ? debug('Connection established', CONFIG.SOCKET, route) : null;
                            };

                            // close connection to socket
                            connection.onclose = function(e) {
                                (CONFIG.DEBBUG === true) ? debug('Connection close', CONFIG.SOCKET) : null;
                            };
                        },
                    };
                }
             ]);
        }

})(angular);