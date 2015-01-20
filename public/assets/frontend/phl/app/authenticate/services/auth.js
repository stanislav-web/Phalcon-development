'use strict';

(function(angular){

    /**
     *  Auth Service factory
     */
    phlModule.factory('authService',
        ['$http', '$cookieStore', '$rootScope',
        function ($http, $cookieStore, $rootScope) {

            var service = {};

            /**
             * Send data to server ( Input data )
             *
             * @param login
             * @param password
             * @param type
             * @param callback
             * @constructor
             */
            service.Login = function (login, password, type, callback) {

                $http.post('/sign', { login: login, password: password, type: type })
                    .success(function (response) {

                        callback(response);

                });
            };

            /**
             * Setup success data received from server
             * @param json data
             * @constructor
             */
            service.UserApply = function (data) {

                $rootScope.user = data.user;

                $http.get('/profile')
                    .success(function (response) {

                        //console.log(response);
                        $rootScope.title    =   response.title;
                        $rootScope.user     =   response.user;
                });
            };

            /**
             * Remove user data from cookies (Log out)
             * @constructor
             */
            service.Logout = function () {

                $http.get('/logout')
                    .success(function (response) {

                        $rootScope.title    =   response.title;
                        delete $rootScope.user;
                    });

            };

            return service;
        }]);

})(angular);