"use strict";
(function(angular) {

    /**
     * Controller "SignController"
     *
     * @dependencies $scope global variables
     * @dependencies $translate angular-translater
     * @dependencies $cookies angular-cookies
     */
    app.controller('SignCtrl', ['$scope', '$rootScope', '$location', 'Authentication', '$translatePartialLoader', '$splash',
        function ($scope, $rootScope, $location, Authentication, $translatePartialLoader, $splash) {


            /**
             * Type of sign
             *
             * @type {string}
             */
            var type = '';

            /**
             * Get Sign type (login / register )
             *
             * @param string
             */
            $scope.typeSign = function (string) {
                type = string;
            };

            /**
             * Sign to account action
             *
             */
            $scope.sign = function () {

                $scope.dataLoading = true;

                // setup credentials
                var credentials = {
                    'type': type,
                    'login': $scope.login,
                    'password': $scope.password
                }

                // call auth service
                Authentication.login(credentials).then(function (response) {

                    if (response.success) {

                        // close splash window & redirect to account
                        $splash.close();
                        $location.path('/account');

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

                        $location.path('/');

                    }
                });
            };
        }]);

})(angular);