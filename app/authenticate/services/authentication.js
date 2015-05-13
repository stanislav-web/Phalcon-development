'use strict';

(function (angular) {

    /**
     * User Authentication service
     */
    app.service('Authentication',  ['Restangular', 'Session',
        function(Restangular, Session) {

            /**
             * Logged user flag
             *
             * @type {boolean}
             */
            var isLoggedIn = false;

            /**
             * Get user auth data
             *
             * @returns object
             */
            var getAuthData = function() {
                return Session.get('auth');
            };

            /**
             * Remove user auth data
             *
             * @returns null
             */
            var removeAuthData = function() {
                return Session.remove('auth');
            };

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

                                isLoggedIn = true;
                                return true;
                            }
                        }
                    }
                    removeAuthData();
                },

                /**
                 * Logout
                 *
                 * @param route
                 * @returns null
                 */
                logout: function (route) {

                    var auth = Session.get('auth');

                    return Restangular.all(route)
                        .customDELETE();
                }
            };
    }]);
})(angular);