'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    app.service('Authentication',  ['$rootScope', '$q', '$http', '$timeout', '$cookies',
        function($rootScope, $q, $http, $timeout, $cookies) {

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

                $http.get(route).success(function (response) {

                    //$timeout(function () {

                        // Check if user is defined first
                        if (response.success) {


                            $rootScope.user = user = response.user;
                            $rootScope.isAuthenticated = isAuthenticated = true;

                            // send auth token
                            $http.defaults.headers.common['X-Token'] = $cookies.token;
                        }

                        deferred.resolve(user);

                    //}, 1000);

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
             * @returns {null}
             */
            isLoggedIn: function () {
                return (isAuthenticated) ? true : false;
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

                        // send auth token
                        $http.defaults.headers.common['X-Token'] = $cookies.token;

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

                $http.get(route).success(function (response) {
                    if (response.success) {

                        $rootScope.user = user = null;
                        $rootScope.isAuthenticated = isAuthenticated = false;
                        $http.defaults.headers.common['X-Token'] = '';

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
        }
    }]);
})(angular);