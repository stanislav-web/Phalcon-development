"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    app.controller('SignController', ['$scope', '$location', 'Authentication', '$translatePartialLoader', 'Meta', 'Session', 'BASE', function ($scope, $location, Authentication, $translatePartialLoader, Meta, Session, BASE) {

        // add language support to this controller
        $translatePartialLoader.addPart('sign');

        // hide banners
        $scope.$parent.bannersOn = false;

        // set meta title
        Meta.setTitle('Sign In', $scope.$parent.title);

        $scope.loginForm = true;
        $scope.registerForm = false;
        $scope.remindForm = false;

        // user form switcher
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

        // sign to account
        $scope.sign = function () {

            $scope.loading = true;

            // setup credentials
            var credentials = {
                'login': $scope.login,
                'password': $scope.password
            };

            // call auth service
            Authentication.login(BASE.ROUTES.AUTH, credentials).then(function (response) {

                // auth success! Set data to session & get redirect to account
                Session.set('auth', response);
                $location.path(BASE.ROUTES.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        /**
         * Restore access password action
         */
        $scope.restore = function () {

            $scope.loading = true;

            // setup credentials
            var credentials = {
                'login': $scope.login
            };

            // call auth service
            Authentication.restore(BASE.ROUTES.AUTH, credentials).then(function () {

                // restore success!
                console.log(response);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        /**
         * Register account action
         */
        $scope.register = function () {

            $scope.loading = true;

            // setup credentials
            var credentials = {
                'login':    $scope.login,
                'name':     $scope.name,
                'password': $scope.password
            };

            // call auth service
            Authentication.register(BASE.ROUTES.AUTH, credentials).then(function (response) {

                // register success!
                console.log(response);

            }).finally(function () {
                $scope.loading = false;
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