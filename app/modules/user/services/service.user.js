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
                },

                /**
                 * Update user profile info
                 *
                 * @param credentials
                 * @returns {*}
                 */
                updateUser: function(credentials) {

                    var auth = AuthenticationService.getAuthData();

                    if(auth) {

                        return Restangular.one(CONFIG.REST.USERS)
                            .customPUT({
                                id : credentials.id,
                                name : credentials.name,
                                surname : credentials.surname,
                                about : credentials.about
                            }, '', undefined, {
                                'Authorization' : 'Bearer '+auth.access.token,
                                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                            });
                    }
                },
                /**
                 * Update user password
                 *
                 * @param credentials
                 * @returns {*}
                 */
                updatePassword: function(credentials) {

                    console.log(credentials); return;
                    var auth = AuthenticationService.getAuthData();

                    if(auth) {

                        return Restangular.one(CONFIG.REST.USERS)
                            .customPUT({
                                id : credentials.id,
                                password : credentials.password,
                                oldpassword : credentials.oldpassword
                            }, '', undefined, {
                                'Authorization' : 'Bearer '+auth.access.token,
                                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                            });
                    }
                }

            };
    }]);
})(angular);