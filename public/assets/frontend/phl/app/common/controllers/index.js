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
    app.controller('IndexCtrl', ['$scope', '$rootScope', '$http', '$location', '$sce', 'ROUTES',
        function($scope, $rootScope, $http, $location, $sce, ROUTES) {

            /**
             *	Perform a GET request on the API and pass the slug to it using $location.url()
             *	On success, pass the data to the view through $scope.trusty
             */
            $http.get($location.url())
                .success(function(data){

                    $scope.trusty = function() {

                        return $sce.trustAsHtml(data.content);
                    }

                    // Inject the basic elements into the rootScope
                    $rootScope.title = data.title;
                    $rootScope.topmenu = data.topmenu;

                })
                .error(function(){

                    // redirect to not found page
                    $location.url(ROUTES.NOT_FOUND);

                });
        }]);

})(angular);