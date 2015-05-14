'use strict';

(function (angular) {

    /**
     * User Data Service
     */
    angular.module('app.user').service('UserService',  ['Restangular', 'Session',
        function(Restangular, Session) {

            return {

                /**
                 * Get user auth data
                 *
                 * @returns object
                 */
                getUserAuth: function() {
                    return Session.get('auth');
                }
            };
    }]);
})(angular);