'use strict';

(function (angular) {

    /**
     * User service
     */
    angular.module('app.user')
        .service('UserService',  ['AuthenticationService', function(AuthenticationService) {

            return {

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