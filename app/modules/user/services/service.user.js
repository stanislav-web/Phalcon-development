'use strict';

(function (angular) {

    /**
     * User service
     */
    angular.module('app.user')
        .service('UserService',  ['Authentication', function(Authentication) {

            return {

                /**
                 * Get User auth data
                 *
                 * @params string key
                 * @returns {*}
                 */
                getUserAuth: function () {

                    return Authentication.getAuthData();
                }
            };
    }]);
})(angular);