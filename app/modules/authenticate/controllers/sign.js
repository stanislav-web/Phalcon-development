"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    angular.module('app.authenticate').controller('SignController', ['$scope', '$location', 'Authentication', '$translatePartialLoader', 'Meta',
        function ($scope, $location, Authentication, $translatePartialLoader, Meta) {

        // add language support to this controller
        $translatePartialLoader.addPart('sign');

        // hide banners
        $scope.$parent.bannersOn = false;

        // set meta title
        Meta.setTitle('Sign In', $scope.$parent.title);

        $scope.loginForm = true;
        $scope.registerForm = false;
        $scope.remindForm = false;

        // User form switcher
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

        // Sign to account
        $scope.sign = function () {

            $scope.loading = true;

            var credentials = {
                'login': $scope.login,
                'password': $scope.password
            };

            Authentication.login(CONFIG.ROUTES.AUTH, credentials).then(function(response) {

                // auth success! Set data to session & get redirect to home page
                Authentication.setAuthData(response);
                $location.path(CONFIG.ROUTES.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Restore access password action
        $scope.restore = function () {

            $scope.loading = true;

            var credentials = {
                'login': $scope.login
            };

            Authentication.restore(CONFIG.ROUTES.AUTH, credentials).then(function () {

                // restore success!
                console.log(response);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Register account action
        $scope.register = function () {

            $scope.loading = true;

            var credentials = {
                'login':    $scope.login,
                'name':     $scope.name,
                'password': $scope.password
            };

            Authentication.register(CONFIG.ROUTES.AUTH, credentials).then(function (response) {

                // register success! Set data to session & get redirect to account
                Authentication.setAuthData(response.access);

                $location.path(CONFIG.ROUTES.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Logout process
        $scope.logout = function () {
            Authentication.logout(CONFIG.ROUTES.AUTH).then(function() {
                $location.path(CONFIG.ROUTES.HOME);
            });
        };

        // Check password identity action
        $scope.checkPassword = function () {
            $scope.formRegister.passwordx.$error.dontMatch = $scope.password !== $scope.passwordx;
        };
    }]);

})(angular);