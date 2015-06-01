'use strict';

(function (angular) {

    /**
     * Subscribe Service
     */
    angular.module('app.common')

        .service('SubscribeService', ['Restangular', function(Restangular) {

            return {

                /**
                 * Add email to subscribers list
                 *
                 * @param credentials
                 */
                add : function(email) {

                    return Restangular.one(CONFIG.REST.SUBSCRIBE)
                        .customPOST({'email' : email}, '', undefined, {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                        });
                }
            };
    }]);
})(angular);