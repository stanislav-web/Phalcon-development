'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    app.service('Authentication',  ['$rootScope', '$q', '$http', 'base64', 'Session',
        function($rootScope, $q, $http, base64, Session) {

        /**
         * User authentication state
         * @type {boolean}
         */
        var isAuthenticated = false;

        /**
         * User object
         * @type {null}
         */
        var user = null;

        return {

            /**
             * Get auth user's params
             *
             * @returns {ng.IPromise<T>}
             */
            requestUser: function (route) {

                var deferred = $q.defer();

                $http.get(route, {headers : {
                    'X-Token':   store.get('token')
                }}).success(function (response) {

                    // Check if user is defined first
                    if (response.success) {
                        $rootScope.user = user = response.user;
                        $rootScope.isAuthenticated = isAuthenticated = true;

                        // update auth token
                        Session.set('token', base64.encode(response.token));

                    }
                    deferred.resolve(user);

                }).error(function (error) {
                    deferred.reject(error);
                });

                return deferred.promise;
            },

            /**
             * Get Auth user data
             *
             * @returns {*}
             */
            getUser: function () {
                return user;
            },

            /**
             * Is user still auth ?
             *
             * @returns {boolean}
             */
            isLoggedIn: function () {
                return (isAuthenticated === true) ? true : false;
            },

            /**
             * Log in to account / Register
             *
             * @param $scope object credentials
             * @param string route handler
             * @returns {ng.IPromise<T>}
             */
            sign: function (credentials, route) {

                var deferred = $q.defer();

                $http.post(route, credentials).success(function (response) {

                    if (response.success) {

                        $rootScope.user = user = response.user;
                        $rootScope.isAuthenticated = isAuthenticated = true;

                        // set auth token
                        Session.set('token', base64.encode(response.token));

                        deferred.resolve(response);
                    }
                    else {
                        deferred.resolve(response);
                    }

                }).error(function (error) {

                    deferred.reject(error);
                });

                return deferred.promise;
            },

            /**
             * Restore account
             *
             * @param $scope object credentials
             * @param string route handler
             * @returns {ng.IPromise<T>}
             */
            restore: function (credentials, route) {

                var deferred = $q.defer();

                $http.post(route, credentials).success(function (response) {
                    if (response.success) {

                        deferred.resolve(response);
                    }
                    else {
                        deferred.resolve(response);
                    }

                }).error(function (error) {

                    deferred.reject(error);
                });

                return deferred.promise;
            },

            /**
             * Logout
             *
             * @param route
             * @returns {*}
             */
            logout: function (route) {

                var deferred = $q.defer();

                $http.delete(route).success(function (response) {
                    if (response.success) {

                        $rootScope.user = user = null;
                        $rootScope.isAuthenticated = isAuthenticated = false;
                        Session.remove('token');

                        deferred.resolve(true);
                    }
                    else {
                        deferred.resolve(false);
                    }

                }).error(function (error) {
                    deferred.reject(error);
                });

                return deferred.promise;
            }
        };
    }]);
})(angular);