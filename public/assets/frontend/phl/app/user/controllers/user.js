"use strict";

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
    app.controller('UserCtrl', ['$scope', '$rootScope', '$http', '$location',
        function($scope, $rootScope, $http, $location) {

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


