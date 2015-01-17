"use strict";

/**
 * Controller "SignController"
 *
 * @dependencies $scope global variables
 * @dependencies $translate angular-translater
 * @dependencies $cookies angular-cookies
 */
phl.controller('SignController', ['$scope', '$rootScope', '$location', 'AuthenticationService', '$translatePartialLoader',
    function ($scope, $rootScope, $location, AuthenticationService, $translatePartialLoader) {

    // add language support to this action
    $translatePartialLoader.addPart('sign');

    // reset login status
    AuthenticationService.ClearCredentials();

    $scope.signIn = function () {
        $scope.dataLoading = true;
        AuthenticationService.Login($scope.login, $scope.password, $scope.remember, function(response) {

             if(response.success) {

                    // success authentication

                    AuthenticationService.SetCredentials($scope.login, $scope.password);
                    $location.path('/');

             } else {

                $scope.error = response.message;
                $scope.dataLoading = false;

             }
        });
    };

}]);