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
                return localStorage.getItem(key);
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