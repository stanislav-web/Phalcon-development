"use strict";

(function(angular) {

    angular.module('app.common')

        .directive('subscribe', function () {
            return {
                restrict: "AE",
                templateUrl: CONFIG.DIRECTIVES.SUBSCRIBE,
                controller: 'SubscribeController'
            }
        });

})(angular);