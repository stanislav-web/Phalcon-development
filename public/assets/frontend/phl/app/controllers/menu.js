"use strict";

/**
 * Controller "TopMenuController"
 *
 * @dependencies $scope global variables
 * @dependencies $location window location
 * @dependencies $translate angular-translate.min.js
 * @dependencies $translatePartialLoader angular-translate-loader-partial.min.js
 *
 */
phl.controller('TopMenuController', function($scope, $location, $translatePartialLoader, $splash, $http, $sce, $rootScope) {

    // add language support to this controller

    $translatePartialLoader.addPart('menu');

    $scope.isActive = function (route) {

        return route === $location.url();
    }


    // open splash modal
    $scope.openSplash = function(url) {

        // get data from url

        $http.get(url)
            .success(function(data){

                // paste to modal box

                $splash.open({
                    title: data.title,
                    message: $sce.trustAsHtml(data.content)
                });
            })
            .error(function(){

                // redirect to not found page
                $location.url('/error/notFound');

        });
    };
});
