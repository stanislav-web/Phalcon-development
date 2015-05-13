"use strict";

(function(angular){

    /**
     * Controller "TopMenuController"
     *
     * Controls the display of the main menu of the costomer.
     */
    angular.module('app').controller('TopMenuController', ['$scope', '$location', '$translatePartialLoader', '$translate', '$http', '$anchorScroll',
        function($scope, $location, $translatePartialLoader, $translate, $http, $anchorScroll) {

            // add language support to this controller
            $translatePartialLoader.addPart('menu');

            // load customer menu
            $http.get(CONFIG.LOCAL.CUSTOMER_MENU).success(function(response) {
                $scope.items = response;
            });

            $scope.isActive = function (url) {

                if($location.hash() != '') {
                    // scroller to hash name
                    $anchorScroll();
                    return url === $location.url() + '#' + $location.hash();
                }
                return url === $location.url();
            }
        }]);

})(angular);
