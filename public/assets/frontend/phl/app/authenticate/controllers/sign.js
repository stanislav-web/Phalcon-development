"use strict";

/**
 * Controller "SignController"
 *
 * @dependencies $scope global variables
 * @dependencies $translate angular-translater
 * @dependencies $cookies angular-cookies
 */
phlModule.controller('SignCtrl', ['$scope', '$rootScope', '$location', 'authService', '$translatePartialLoader', '$splash',
    function ($scope, $rootScope, $location, authService, $translatePartialLoader, $splash) {

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

            authService.Login($scope.login, $scope.password, $scope.type, function(response) {

                if(response.success) {

                    // success authentication (setup success cookies and some user data)
                    authService.UserApply(response);

                    // close splash window & redirect to profile
                    $splash.close();
                    $location.path('/account');

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

            authService.Logout();
            $location.path('/');
        };

    }]);