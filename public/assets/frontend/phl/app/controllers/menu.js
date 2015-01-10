"use strict";

/**
 * Controller "TopMenuController"
 *
 * @dependencies $scope global variables
 *
 */
phl.controller('TopMenuController', ['$scope', '$location', function($scope, $location) {

    $scope.isActive = function (route) {

        return route === $location.url();
    }
}]);
