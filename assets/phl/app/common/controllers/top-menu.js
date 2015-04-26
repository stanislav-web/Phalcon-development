"use strict";

(function(angular){

    /**
     * Controller "TopMenuController"
     *
     * Controls the display of the main menu of the consumer.
     */
    app.controller('TopMenuController', ['$scope', '$location', '$translatePartialLoader', '$translate', '$splash', '$http', '$anchorScroll', 'BASE',
        function($scope, $location, $translatePartialLoader, $translate, $splash, $http, $anchorScroll, BASE) {

            // add language support to this controller
            $translatePartialLoader.addPart('menu');

            // load customer menu
            $http.get(BASE.LOCAL.CUSTOMER_MENU).success(function(response) {
                $scope.items = response;
            });

            $scope.isActive = function (route) {
                if($location.hash() != '') {
                    // scroller to hash name
                    $anchorScroll();
                    return route === $location.url() + '#' + $location.hash();
                }
                return route === $location.url();
            }

            // open splash modal
            $scope.openSplash = function() {

                // add language support to this action
                $translatePartialLoader.addPart('sign');

                $splash.open();
            };

        }]);

})(angular);
