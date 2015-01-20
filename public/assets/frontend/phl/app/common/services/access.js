'use strict';

(function(angular){

    /**
     * Always put cookie token to header
     */
    phlModule.factory('access', function ($http, $cookies) {

        return {

            /**
             *  Set access token for each header requests
             * @param token
             */
            init: function (token) {

                $http.defaults.headers.common['X-Access-Token'] = token || $cookies.token;
            }

        };
    });

})(angular);