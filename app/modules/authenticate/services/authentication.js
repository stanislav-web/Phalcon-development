'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    angular.module('app.authenticate').service('Authentication',  ['Restangular', 'Session',
        function(Restangular, Session) {

            /**
             * Get user auth data
             *
             * @returns object
             */
            var getAuthData = function(key) {
                if(_.isUndefined(key)) {
                    var key = getKey();
                }

                return Session.get('auth', key);
            };

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
                return Session.remove('auth');
            };

            /**
             * Random string generator
             * @param len
             * @param charSet
             * @returns {string}
             */
            var randomString = function(len, charSet) {
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
                 * @param string route
                 * @returns {*}
                 */
                login: function(route, credentials) {

                    return Restangular.all(route)
                        .customGET(undefined, credentials);
                },

                /**
                 * Restore account
                 *
                 * @param array credentials
                 * @param string route
                 * @returns {*}
                 */
                restore: function(route, credentials) {

                    return Restangular.one(route)
                        .customPUT(credentials, '', undefined, {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                        });
                },

                /**
                 * Register account
                 *
                 * @param array credentials
                 * @param string route
                 * @returns {*}
                 */
                register: function(route, credentials) {

                    return Restangular.one(route)
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

                    var auth = getAuthData();

                    // check for data isset
                    if(!_.isNull(auth) && !_.isUndefined(auth)) {

                        // check for data contains specific keys
                        if(_.has(auth, ['user_id']) && _.has(auth, ['expire_date']) && _.has(auth, ['token'])) {

                            // check for data is valid by date
                            if(moment(auth.expire_date).isValid()
                                && moment(auth.expire_date).unix() > moment().unix()) {

                                return true;
                            }
                        }
                    }
                    removeAuthData();
                },

                /**
                 * Set user auth data
                 *
                 * @param response
                 */
                setAuthData: function(response) {
                    var key = randomString(5, 'PICKCHARSFROMTHISSET');

                    Session.set('mode', key);
                    Session.set('auth', response, key);
                },

                /**
                 * Get user auth data
                 */
                getAuthData: function() {
                    return getAuthData();
                },

                /**
                 * Logout
                 *
                 * @param route
                 * @returns null
                 */
                logout: function (route) {

                    removeAuthData();
                    return Restangular.all(route)
                        .customDELETE();
                }
            };
    }]);
})(angular);