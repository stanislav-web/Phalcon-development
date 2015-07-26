'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    angular.module('app.authenticate')

        .service('AuthenticationService',  ['Restangular', 'Session','ModuleAuthenticateConfig',
        function(Restangular, Session, ModuleAuthenticateConfig) {

            /**
             * Get user key access
             *
             * @returns string
             */
            var getKey = function() {
                return Session.get('mode');
            };
            /**
             * Remove user auth data
             *
             * @returns null
             */
            var removeAuthData = function() {
                return Session.remove('auth').remove('mode');
            };

            /**
             * Random string generator
             * @param len
             * @param charSet
             * @returns {string}
             */
            var randomString = function(len, charSet) {
                //noinspection AssignmentToFunctionParameterJS
                charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var randomString = '';
                for (var i = 0; i < len; i++) {
                    var randomPoz = Math.floor(Math.random() * charSet.length);
                    randomString += charSet.substring(randomPoz,randomPoz+1);
                }
                return randomString;
            }

            return {

                /**
                 * Authenticate for user
                 *
                 * @param array credentials
                 * @returns {*}
                 */
                auth: function(credentials) {

                    return Restangular.all(CONFIG.REST.AUTH)
                        .customGET(undefined, _.merge(credentials, {_time : new Date().getTime()}));
                },

                /**
                 * Restore account
                 *
                 * @param array credentials
                 * @returns {*}
                 */
                restore: function(credentials) {

                    return Restangular.one(CONFIG.REST.AUTH)
                        .customPUT(credentials, '', undefined, {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                        });
                },

                /**
                 * Register account
                 *
                 * @param array credentials
                 * @returns {*}
                 */
                register: function(credentials) {

                    return Restangular.one(CONFIG.REST.AUTH)
                        .customPOST(credentials, '', undefined, {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                        });
                },

                /**
                 * Is user still auth ?
                 *
                 * @returns {boolean}
                 */
                isLoggedIn: function () {

                    var auth = this.getAuthData();

                    // check for data isset
                    if(!_.isNull(auth) && !_.isUndefined(auth)) {

                        // check for data contains specific keys
                        if(_.has(auth.access, ['user_id'])
                            && _.has(auth.access, ['expire_date'])
                                && _.has(auth.access, ['token'])) {

                            // check for data is valid by date
                            if(moment(auth.access.expire_date).isValid()
                                && moment(auth.access.expire_date).unix() > moment().unix()) {

                                return true;
                            }
                        }
                    }
                    removeAuthData();

                    return false;
                },

                /**
                 * Set user auth data
                 *
                 * @param response
                 */
                setAuthData: function(response) {
                    var key = randomString(ModuleAuthenticateConfig.keyLength, ModuleAuthenticateConfig.key);

                    Session.set('mode', key);
                    Session.set('auth', response, key);
                },

                /**
                 * Get user auth data
                 */
                getAuthData: function() {
                    var key = getKey();
                    return Session.get('auth', key);
                },

                /**
                 * Logout
                 *
                 * @returns null
                 */
                logout: function () {

                    var auth = this.getAuthData();

                    if(auth) {

                        var user_id = auth.access.user_id;

                        // clear tokens
                        removeAuthData();
                        return Restangular.one(CONFIG.REST.AUTH, user_id).remove({}, {
                                'Authorization' : 'Bearer '+auth.access.token
                            }
                        );
                    }
                    else {
                        return Restangular.one(CONFIG.REST.AUTH).remove();
                    }
                }
            };
    }]);
})(angular);