
"use strict";

(function(angular){

    /**
     * Controller "SubscribeController"
     *
     * Control of a user submissions
     */
    angular.module('app.common').controller('SubscribeController', ['$translate', '$scope', 'SubscribeService',
        function ($translate, $scope, SubscribeService) {

            /**
             *  Submit email for subscribers list
             */
            $scope.submit = function() {

                $scope.loading = true;

                SubscribeService.add(this.email).then(function () {

                    // subscribe has been success
                    notify.success('You have successfully subscribed to our newsletter');

                }).finally(function () {
                    $scope.loading = false;
                });
            }
        }]);

})(angular);