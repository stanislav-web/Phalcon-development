"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    app.controller('SignCtrl', ['$scope', '$rootScope', '$location', 'Authentication', '$translatePartialLoader', '$splash', 'ROUTES',
        function ($scope, $rootScope, $location, Authentication, $translatePartialLoader, $splash, ROUTES) {

            $scope.loginForm = true;
            $scope.registerForm = false;

            /**
             * Form switcher
             */
            $scope.toggle = function(form) {

                if(form === 'loginForm') {
                    $scope.registerForm = false;
                    $scope.loginForm = true;
                }
                else {
                    $scope.registerForm = true;
                    $scope.loginForm = false;
                }
            };

            /**
             * Sign to account action
             */
            $scope.sign = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'login': $scope.login,
                    'password': $scope.password
                }

                // call auth service
                Authentication.sign(credentials, ROUTES.LOGIN).then(function (response) {

                    if (response.success) {

                        // close splash window & redirect to account
                        $splash.close();
                        $location.path(ROUTES.ACCOUNT);

                    } else {
                        // return error to show in sign form
                        $scope.signError = response.message;
                        $scope.dataLoading = false;

                    }
                });
            };

            /**
             * Register account action
             */
            $scope.register = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'login': $scope.login,
                    'name': $scope.name,
                    'password': $scope.password
                }

                // call auth service
                Authentication.sign(credentials, ROUTES.REGISTER).then(function (response) {

                    if (response.success) {

                        // close splash window & redirect to account
                        $splash.close();
                        $location.path(ROUTES.ACCOUNT);

                    } else {
                        // return error to show in sign form
                        $scope.registerError = response.message;
                        $scope.dataLoading = false;

                    }
                });
            };

            /**
             * Login out
             */
            $scope.logout = function () {

                Authentication.logout(ROUTES.LOGOUT).then(function (response) {

                    if (response) {

                        $location.path(ROUTES.HOME);

                    }
                });
            };

            /**
             * Check password identity action
             */
            $scope.checkPassword = function () {
                $scope.formRegister.passwordx.$error.dontMatch = $scope.password !== $scope.passwordx;
            };

        }]);

})(angular);