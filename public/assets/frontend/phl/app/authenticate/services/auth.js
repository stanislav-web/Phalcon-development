'use strict';

(function(angular){

    /**
     *  Auth Service factory
     */
    phlModule.factory('authService',
        ['$http', '$cookieStore', '$rootScope', 'access',
        function ($http, $cookieStore, $rootScope, access) {

            var service = {};
            var user    = false;

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

                $rootScope.user = user = data.user;

                access.init(data.token);

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
                        }
                    });

            };

            /**
             * Remove user data from cookies (Log out)
             * @constructor
             */
            service.isLoggedIn = function (state) {

                return(user) ? user : false;
            };

            service.getUser = function() {
                return user;
            };

            return service;
        }]);

})(angular);