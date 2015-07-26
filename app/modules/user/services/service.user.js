'use strict';
(function (angular) {

    /**
     * User service
     */
    angular.module('app.user')
        .service('UserService',  ['Restangular', 'AuthenticationService', 'UploadService', function(Restangular, AuthenticationService, UploadService) {

            return {

                setUserPhoto : function(photo) {

                    if(photo.length > 0) {
                        // resolve full uri photo path
                        return CONFIG.FILES_URL + photo;
                    }
                    else {
                        // set default image as empty
                       return ModuleUserConfig.noImage;
                    }
                },

                /**
                 * Upload user profile picture
                 * 
                 * @param auth
                 * @param photo
                 * @param scope
                 * @param event
                 * @returns {*}
                 */
                uploadProfilePicture : function(auth, photo, scope, event) {

                    if(event.type === 'change') {

                        // resolve picture data
                        UploadService.readPicture(photo, function(event) {
                            scope.user.photo = event.target.result;
                        });

                        // upload picture
                        return UploadService.upload({
                            url: CONFIG.URL+''+CONFIG.REST.FILES,
                            file: photo,
                            fields: {
                                id: auth.user_id,
                                mapper: 'UserMapper'
                            },
                            headers : {
                                'Content-Type': CONFIG.FORM_ENCODING,
                                'Authorization' : 'Bearer '+auth.token
                            }
                        });
                    }

                },

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
                 * Set fresh auth data
                 *
                 * @param data
                 * @returns {*}
                 */
                setAuthData : function (data) {
                    return AuthenticationService.setAuthData(data);
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
                 * Get user fresh auth
                 * @param credentials
                 * @returns {*}
                 */
                getFreshAuth : function(credentials) {

                    return AuthenticationService.auth(CONFIG.REST.AUTH, {
                        login : credentials.login,
                        password : credentials.currentPassword
                    });
                },

                /**
                 * Update user password
                 *
                 * @param credentials
                 * @returns {*}
                 */
                updatePassword: function(credentials) {

                    var auth = AuthenticationService.getAuthData();

                    if(auth) {

                        return Restangular.one(CONFIG.REST.USERS)
                            .customPUT({
                                id : credentials.id,
                                password : credentials.newPassword
                            }, '', undefined, {
                                'Authorization' : 'Bearer '+auth.access.token,
                                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                            });
                    }
                }
            };
    }]);
})(angular);