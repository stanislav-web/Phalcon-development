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

            /**
             * Form switcher
             */
            $scope.loginForm = true;
            $scope.registerForm = false;
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
                Authentication.login(credentials).then(function (response) {

                    if (response.success) {

                        // close splash window & redirect to account
                        $splash.close();
                        $location.path(ROUTES.ACCOUNT);

                    } else {
                        // return error to show in sign form
                        $scope.error = response.message;
                        $scope.dataLoading = false;

                    }
                });
            };

            /**
             * Sign to account action
             */
            $scope.register = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'login': $scope.login,
                    'password': $scope.password
                }

                // call auth service
                Authentication.login(credentials).then(function (response) {

                    if (response.success) {

                        // close splash window & redirect to account
                        $splash.close();
                        $location.path(ROUTES.ACCOUNT);

                    } else {
                        // return error to show in sign form
                        $scope.error = response.message;
                        $scope.dataLoading = false;

                    }
                });
            };

            /**
             * Login out
             */
            $scope.logout = function () {

                Authentication.logout().then(function (response) {

                    if (response) {

                        $location.path(ROUTES.HOME);

                    }
                });
            };
        }]);

})(angular);