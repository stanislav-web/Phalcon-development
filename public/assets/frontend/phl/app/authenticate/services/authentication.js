'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    app.service('Authentication',  ['$rootScope', '$q', '$http', 'base64', '$cookies',
        function($rootScope, $q, $http, base64) {

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
                        store.set('token', base64.encode(response.token));

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
                        store.set('token', base64.encode(response.token));

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
             * Log service
             */
            logout: function (route) {

                var deferred = $q.defer();

                $http.delete(route, {headers : {
                    'X-Token':   ''
                }}).success(function (response) {
                    if (response.success) {

                        $rootScope.user = user = null;
                        $rootScope.isAuthenticated = isAuthenticated = false;
                        $http.defaults.headers.common['X-Token'] = '';
                        store.remove('token');

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