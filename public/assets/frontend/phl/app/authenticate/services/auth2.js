'use strict';

(function(angular){

    /**
     *  Auth Service factory
     */
    phlModule.factory('authService', ['$q', '$http', function ($q, $http) {

        /**
         * User auth state
         * @type {boolean}
         */
        var isAuthenticated = false;

        /**
         * Auth user data
         * @type {null}
         */
        var user = null;

        return {

            login : function (credentials) {

                console.log('Sign credentials:', credentials);

                var deferred = $q.defer();

                $http.post('/sign', credentials).success(function (response) {

                    if(response.user) {

                        isAuthenticated =   true;
                        user =  response.user;
                        deferred.resolve(response);
                    }
                    else {
                        deferred.reject(response);
                    }

                }).error(function(error) {
                    deferred.reject(error);
                });

                return deferred.promise;
            },

            requestUser : function() {

                var deferred = $q.defer();

                $http.get('/sign/verify').success(function(response) {

                    if(response.user) {
                        isAuthenticated =   true;
                        user =  response.user;
                        deferred.resolve(response.user);
                    }
                }).error(function(error) {
                    deferred.reject(error);
                });

                return deferred.promise;
            },

            getUser : function() {
                return user;
            },

            isLoggedIn: function () {
                return isAuthenticated;
            },

            logout: function () {

                var deferred = $q.defer();

                $http.post('/logout').success(function (response) {

                    if(response.success) {

                        isAuthenticated =   false;
                        user =  null;
                    }
                    else {
                        deferred.reject(response.message);
                    }

                }).error(function(error) {
                    deferred.reject(error);
                });

                return deferred.promise;
            }
        }

    }]);

})(angular);