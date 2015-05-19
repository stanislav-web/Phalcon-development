"use strict";

(function(angular){

    /**
     * Controller "TopMenuController"
     *
     * Controls the display of the main menu of the costomer.
     */
    angular.module('app.common').controller('TopMenuController', ['$scope', '$location', '$translatePartialLoader', '$translate', 'DataService', '$anchorScroll',
        function($scope, $location, $translatePartialLoader, $translate, DataService, $anchorScroll) {

            // add language support to this controller
            $translatePartialLoader.addPart('menu');

            $scope.isActive = function (url) {

                if($location.hash() != '') {
                    // scroll to hash name
                    $anchorScroll();
                    return url === $location.url() + '#' + $location.hash();
                }
                return url === $location.url();
            }

            // load customer menu
            $scope.$parent.$watch('isLoggedIn', function(isLoggedIn) {
                if(isLoggedIn !== undefined) {
                    var menu = ($scope.$parent.isLoggedIn === true)
                        ? CONFIG.LOCAL.CUSTOMER_AUTH_MENU : CONFIG.LOCAL.CUSTOMER_MENU;
                    DataService.getData(menu, function(response) {
                        $scope.items = response;
                    });
                }
            });

        }]);

})(angular);
