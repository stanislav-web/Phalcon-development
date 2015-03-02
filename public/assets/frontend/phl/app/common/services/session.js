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
                return store.set(key, value);
            },

            /**
             * Get key from session storage
             *
             * @uses store
             * @param key
             * @returns {*}
             */
            get: function (key) {
                return store.get(key);
            },

            /**
             * Remove key from session storage
             *
             * @param key
             * @returns {*}
             */
            remove: function (key) {
                return store.remove(key);
            },

            /**
             * Destroy all keys
             *
             * @returns {*}
             */
            destroy: function () {
                return store.clear();
            }
        };
    });
})(angular);