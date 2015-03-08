'use strict';

(function (angular) {

    /**
     * Request service
     */
    app.factory('httpRequestInterceptor',  ['$q','$location', 'ROUTES',
        function($q, $location, ROUTES) {

        return {

            /**
             * Response error handler
             * @param rejection
             * @returns {*}
             */
            'responseError': function(rejection) {

                // do something on error
                if(rejection.status === 404){

                    $location.path(ROUTES.NOT_FOUND);
                }
                else if(rejection.status === 500){

                    $location.path(ROUTES.SERVER_ERROR);
                }
                return $q.reject(rejection);
            }
        };
    }]);
})(angular);