'use strict';

(function (angular) {

    /**
     * Session service
     */
    app.service('Session',  function() {

        return {

            /**
             * Set key to session storage
             *
             * @param key
             * @param value
             * @returns {*}
             */
            set: function (key, value) {

                if (typeof value == 'object') {
                    value = JSON.stringify(value);
                }
                return localStorage.setItem(key, value);
            },

            /**
             * Get key from session storage
             *
             * @uses store
             * @param key
             * @returns {*}
             */
            get: function (key) {

                var data = localStorage.getItem(key);
                try {
                    if(data.length) {
                        return JSON.parse(data);
                    }

                }
                catch(e) {
                    return data;
                }
            },

            /**
             * Remove key from session storage
             *
             * @param key
             * @returns {*}
             */
            remove: function (key) {
                return localStorage.removeItem(key);
            },

            /**
             * Destroy all keys
             *
             * @returns {*}
             */
            destroy: function () {
                return localStorage.clear();
            }
        };
    });
})(angular);