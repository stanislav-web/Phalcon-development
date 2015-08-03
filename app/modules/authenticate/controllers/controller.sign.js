"use strict";

(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    angular.module('app.authenticate').controller('SignController', ['$scope', 'AuthenticationService', '$translatePartialLoader', 'Document',
        function ($scope, AuthenticationService, $translatePartialLoader, Document) {

        // add language support to this controller
        $translatePartialLoader.addPart('sign');

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

            AuthenticationService.auth(this.credentials).then(function (response) {

                // auth success! Set data to session & get redirect to home page
                AuthenticationService.setAuthData(response);

                setTimeout(function() {
                    Document.redirect(CONFIG.LOCATIONS.ACCOUNT);
                },100);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Restore access password action
        $scope.restore = function () {

            $scope.loading = true;

            AuthenticationService.restore(this.credentials).then(function () {
                // restore success!
            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Register account action
        $scope.register = function () {

            $scope.loading = true;

            AuthenticationService.register(this.credentials).then(function (response) {

                // register success! Set data to session & get redirect to account
                Session.set('auth', response.access);
                Document.redirect(CONFIG.LOCATIONS.ACCOUNT);

            }).finally(function () {
                $scope.loading = false;
            });
        };

        // Logout process
        $scope.logout = function () {
            Authentication.logout().then(function() {
                Document.redirect(CONFIG.LOCATIONS.HOME);
            });
        };
    }]);

})(angular);