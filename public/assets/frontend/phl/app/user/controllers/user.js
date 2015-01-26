"use strict";

/**
 * Controller "UserController"
 *
 * @dependencies $scope global variables
 *
 */
"use strict";

(function(angular){

    /**
     * Controller "UserCtrl"
     *
     * @dependencies $scope global controller variables
     * @dependencies $rootScope global variables
     * @dependencies $http http ajax service
     * @dependencies $location url service
     */
    phlModule.controller('UserCtrl', ['$scope', '$rootScope', '$http', '$location', 'authService', 'Application',
        function($scope, $rootScope, $http, $location, authService, Application) {

            console.log('isAuth:', authService.isLoggedIn());
            console.log('User:', authService.getUser());


            Application.registerListener(function()
            {
                // When application is ready then redirect to the main page
                $location.path('/');
            });

            /**
             *	Perform a GET request on the API and pass the slug to it using $location.url()
             *	On success, pass the data to the view through $scope.trusty
             */
            $http.get($location.url())
                .success(function(data){

                    // Inject the basic elements into the rootScope
                    $rootScope.title =  data.title;
                    $rootScope.user =   data.user;

                })
                .error(function(){

                    // redirect to not found page
                    $location.url('/error/notFound');

                });
        }]);

})(angular);


