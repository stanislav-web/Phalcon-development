"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    app.controller('SignController', ['$scope', '$location', 'Authentication', '$translatePartialLoader', 'Meta', 'BASE', function ($scope, $location, Authentication, $translatePartialLoader, Meta, BASE) {

        // add language support to this controller
        $translatePartialLoader.addPart('sign');

        // hide banners
        $scope.$parent.bannersOn = false;

            // set meta title
            Meta.setTitle('Sign In', $scope.$parent.title);

            $scope.loginForm = true;
            $scope.registerForm = false;
            $scope.remindForm = false;

            /**
             * Form switcher
             */
            $scope.toggle = function(form) {

                if(form === 'loginForm') {
                    $scope.registerForm = false;
                    $scope.restoreForm = false;
                    $scope.loginForm = true;
                }
                else if(form === 'restoreForm') {

                    $scope.registerForm = false;
                    $scope.restoreForm = true;
                    $scope.loginForm = false;
                }
                else {
                    $scope.registerForm = true;
                    $scope.restoreForm = false;
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
                };

                // call auth service
                Authentication.login(BASE.ROUTES.LOGIN, credentials).then(function (response) {

                    if(response.success) {
                        // close splash window & redirect to account
                        $splash.close();
                        $location.path(BASE.ROUTES.ACCOUNT);
                    }
                }, function(error) {

                    // return error to show in sign form
                    $scope.signError = error.message;
                    $scope.dataLoading = false;

                });
            };

            /**
             * Restore access password action
             */
            $scope.restore = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'login': $scope.login
                };

                // call auth service
                Authentication.restore(credentials, BASE.ROUTES.RESTORE).then(function (response) {

                    $scope.restoreSuccess = response.message;
                    $scope.dataLoading = false;

                    setTimeout(function() {
                        $splash.close();
                    }, 3000);

                }, function(error) {

                    // return error to show in sign form
                    $scope.restoreError = error.message;
                    $scope.dataLoading = false;

                });
            };

            /**
             * Register account action
             */
            $scope.register = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'login':    $scope.login,
                    'name':     $scope.name,
                    'password': $scope.password
                };

                // call auth service
                Authentication.sign(credentials, BASE.ROUTES.REGISTER).then(function (response) {

                    // close splash window & redirect to account
                    $splash.close();
                    $location.path(BASE.ROUTES.ACCOUNT);

                }, function(error) {

                    // return error to show in sign form
                    $scope.registerError = error.message;
                    $scope.dataLoading = false;

                });
            };

            /**
             * Login out
             */
            $scope.logout = function () {

                Authentication.logout(BASE.ROUTES.LOGOUT).then(function (response) {

                    if (response) {

                        $location.path(BASE.ROUTES.HOME);

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