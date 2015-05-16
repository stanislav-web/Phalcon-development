"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    angular.module('app.authenticate').controller('SignController', ['$scope', '$location', 'Authentication', '$translatePartialLoader', 'Document',
        function ($scope, $location, Authentication, $translatePartialLoader, Document) {

        // add language support to this controller
        $translatePartialLoader.addPart('sign');

        // hide banners
        $scope.$parent.bannersOn = false;

        // set meta title
        Document.prependTitle('Sign In', '-');

        $scope.loginForm = true;

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

        // Login to account
        $scope.login = function () {

            $scope.loading = true;

            Authentication.auth(CONFIG.REST.AUTH, this.credentials).then(function (response) {

                // auth success! Set data to session & get redirect to home page
                Authentication.setAuthData(response);
                $location.path(CONFIG.LOCATIONS.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Restore access password action
        $scope.restore = function () {

            $scope.loading = true;

            Authentication.restore(CONFIG.REST.AUTH, this.credentials).then(function () {

                // restore success!
                console.log(response);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Register account action
        $scope.register = function () {

            $scope.loading = true;

            Authentication.register(CONFIG.REST.AUTH, this.credentials).then(function (response) {

                // register success! Set data to session & get redirect to account
                Session.set('auth', response.access);
                $location.path(CONFIG.LOCATIONS.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Logout process
        $scope.logout = function () {
            Authentication.logout(CONFIG.REST.AUTH).then(function() {
                $location.path(CONFIG.LOCATIONS.HOME);
            });
        };

        // Check password identity action
        $scope.checkPassword = function () {
            $scope.formRegister.passwordx.$error.dontMatch = this.credentials.password !== this.passwordx;
        };
    }]);

})(angular);