'use strict';

(function (angular) {

    /**
     * Engines service
     */
    app.service('Engines',  ['Restangular', function(Restangular) {

        return {

            /**
             * Get one engine by Id
             *
             * @param int engine_id
             * @returns {*}
             */
            getOne: function (engine_id) {

                return Restangular.one("engines", engine_id).customGET("categories").$object;
            }
        };
    }]);
})(angular);