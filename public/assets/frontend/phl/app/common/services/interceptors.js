'use strict';

(function (angular) {

    /**
     * Request service
     */
    app.factory('httpRequestInterceptor',  ['$q','$location','ROUTES', '$rootScope',
        function($q, $location, ROUTES, $rootScope) {

        return {

            'responseError': function(rejection) {

                // do something on error
                if(rejection.status === 404){
                    $location.path(ROUTES.NOT_FOUND);
                }
                else if(rejection.status === 500){

                    $location.path(ROUTES.SERVER_ERROR);
                    $rootScope.title = 'Internal Server Error';

                }
                return $q.reject(rejection);
            }
        };
    }]);
})(angular);