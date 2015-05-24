'use strict';
(function (angular) {

    /**
     * User service
     */
    angular.module('app.user')
        .service('UserService',  ['Restangular', 'AuthenticationService', function(Restangular, AuthenticationService) {

            return {

                /**
                 * Get User info
                 *
                 * @params string key
                 * @returns {*}
                 */
                getUser: function () {

                    var auth = AuthenticationService.getAuthData();

                    if(auth) {
                        var user_id = auth.access.user_id;
                        return Restangular.one(CONFIG.REST.USERS, user_id).get({},
                            {
                                'Authorization' : 'Bearer '+auth.access.token
                            }
                        );
                    }
                },

                /**
                 * Get User auth data
                 *
                 * @params string key
                 * @returns {*}
                 */
                getUserAuth: function () {

                    return AuthenticationService.getAuthData();
                }
            };
    }]);
})(angular);