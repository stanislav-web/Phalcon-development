'use strict';

(function(angular){

    /**
     *  Auth Service factory
     */
    phlModule.service('authService',
        ['$http', '$cookieStore', '$rootScope',
        function ($http, $cookieStore, $rootScope) {

            var service = {};
            var user    = false;
            var logged    = false;

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

                $rootScope.user     = user      = data.user;
                $rootScope.logged   = logged    = true;

                $http.get('/account')
                    .success(function (response) {

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

                        if(response.success) {

                            delete $rootScope.user;
                            delete $rootScope.logged;
                        }
                    });

            };

            /**
             * Remove user data from cookies (Log out)
             * @constructor
             */
            service.isLoggedIn = function () {

                return(logged) ? logged : false;
            };

            service.getUser = function() {
                return user;
            };

            return service;
        }]);

})(angular);