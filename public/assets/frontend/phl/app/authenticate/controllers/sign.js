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
        $scope.setType = function(string) {

            $scope.type = string;
        };

        /**
         * Login to account
         */
        $scope.sign = function () {

            $scope.dataLoading = true;

            // call auth service
            var promise =  authService.login({
                'login'     :   $scope.login,
                'password'  :   $scope.password,
                'type'      :   $scope.type
            }).then(function(response) {

                if(response.success) {

                    // close splash window & redirect to account
                   $splash.close();
                   $location.path('/account');

                } else {

                    $scope.error = response.message;
                    $scope.dataLoading = false;
                }

            }, function(error) {
                alert(error);
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