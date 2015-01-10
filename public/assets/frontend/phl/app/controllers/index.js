"use strict";

/**
 * Controller "MenuController"
 *
 * @dependencies $scope global variables
 *
 */
phl.controller('IndexController', function($scope, $rootScope, $http, $location, $sce) {

    /**
     *	Perform a GET request on the API and pass the slug to it using $location.url()
     *	On success, pass the data to the view through $scope.page
     */
    $http.get($location.url())
        .success(function(data, status, headers, config){

            $scope.trusty = function() {

                return $sce.trustAsHtml(data.content);
            }

            // Inject the title into the rootScope
            $rootScope.title = data.title;

        })
        .error(function(data, status, headers, config){
            window.alert("We have been unable to access the feed :-(");
        })
});