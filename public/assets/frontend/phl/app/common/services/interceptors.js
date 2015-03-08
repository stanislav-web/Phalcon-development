'use strict';

(function (angular) {

    /**
     * Request service
     */
    app.factory('httpRequestInterceptor',  ['$q','$location','ROUTES', function($q, $location, ROUTES) {

        return {

            'responseError': function(rejection) {

                // do something on error
                if(rejection.status === 404){
                    $location.path(ROUTES.NOT_FOUND);
                }
                return $q.reject(rejection);
            }
        };
    }]);
})(angular);