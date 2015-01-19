"use strict";

/**
 * Controller "SignController"
 *
 * @dependencies $scope global variables
 * @dependencies $translate angular-translater
 * @dependencies $cookies angular-cookies
 */
phl.controller('SignController', ['$scope', '$rootScope', '$location', 'AuthenticationService', '$translatePartialLoader', '$splash',
    function ($scope, $rootScope, $location, AuthenticationService, $translatePartialLoader, $splash) {

    // add language support to this action
    $translatePartialLoader.addPart('sign');

    /**
     * Get Sign type (login / register )
     * @param string
     */
    $scope.typeSign = function(string) {
        $scope.type = string;
    };

    /**
     * Login to account
     */
    $scope.signIn = function () {

        $scope.dataLoading = true;

        // call auth service

        AuthenticationService.Login($scope.login, $scope.password, $scope.type, function(response) {

            if(response.success) {

                    // success authentication (setup success cookies and some user data)
                    AuthenticationService.UserApply(response);

                    // close splash window & redirect to profile
                    $splash.close();
                    $location.path('/profile');

             } else {

                $scope.error = response.message;
                $scope.dataLoading = false;

             }
        });
    };

    /**
     * Login out
     */
    $scope.logout = function () {

        AuthenticationService.Logout();
        $location.path('/');
    };

}]);