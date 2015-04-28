'use strict';

(function (angular) {

    /**
     * Notification provider
     * @TODO
     */
    angular.module('providers', ['notifications'])
        .provider('Notifier',  function NotifierProvider() {

            this.$get = function() {
                return new setProvider($notifications);
            };
    });

})(angular);

