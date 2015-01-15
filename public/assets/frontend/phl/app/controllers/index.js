"use strict";

/**
 * Controller "IndexController"
 *
 * @dependencies $scope global controller variables
 * @dependencies $rootScope global variables
 * @dependencies $http http ajax service
 * @dependencies $location url service
 * @dependencies $sce sanitize HTML service
 */
phl.controller('IndexController', function($scope, $rootScope, $http, $location, $sce) {

    /**
     *	Perform a GET request on the API and pass the slug to it using $location.url()
     *	On success, pass the data to the view through $scope.trusty
     */
    $http.get($location.url())
        .success(function(data){

            $scope.trusty = function() {

                return $sce.trustAsHtml(data.content);
            }

            // Inject the title into the rootScope
            $rootScope.title = data.title;

        })
        .error(function(){

            // redirect to not found page
            $location.url('/error/notFound');

        });
});