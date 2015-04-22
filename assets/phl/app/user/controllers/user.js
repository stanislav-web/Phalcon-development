"use strict";

/**
 * Controller "UserController"
 *
 * @dependencies $scope global variables
 *
 */

(function(angular){

    /**
     * Controller "IndexController"
     *
     * @dependencies $scope global controller variables
     * @dependencies $rootScope global variables
     * @dependencies $http http ajax service
     * @dependencies $location url service
     * @dependencies $sce sanitize HTML service
     */
    app.controller('UserCtrl', ['$scope', '$rootScope', '$http', '$location', 'ROUTES', '$cookies',
        function($scope, $rootScope, $http, $location, ROUTES, $cookies) {

            /**
             *	Perform a GET request on the API and pass the slug to it using $location.url()
             *	On success, pass the data to the view through $scope.trusty
             */
            $http.get($location.url(), {headers : {
                'X-Token':   $cookies.token
            }})
                .success(function(data){

                    // Inject the basic elements into the rootScope
                    $rootScope.title =  data.title;
                    $rootScope.user =   data.user;

                })
                .error(function(data) {

                    $rootScope.title    = data.title;
                    $rootScope.content  = data.content;

                    // redirect to not found page
                    $location.url(ROUTES.NOT_FOUND);

                });
        }]);

})(angular);


