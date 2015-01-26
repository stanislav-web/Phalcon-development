"use strict";

(function(angular){

    /**
     * Controller "TopMenuController"
     *
     * @dependencies $scope global variables
     * @dependencies $location window location
     * @dependencies $translate angular-translate.min.js
     * @dependencies $translatePartialLoader angular-translate-loader-partial.min.js
     * @dependencies $anchorScroll hash scroll support
     *
     */
    app.controller('TopMenuCtrl', ['$scope', '$location', '$translatePartialLoader', '$splash', '$http', '$sce', '$rootScope', '$anchorScroll',
        function($scope, $location, $translatePartialLoader, $splash, $http, $sce, $rootScope, $anchorScroll) {

            // add language support to this controller
            $translatePartialLoader.addPart('menu');

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

                // add token

                var token = $('meta[name=token]');

                $rootScope.token_id = token.attr('title');
                $rootScope.token_val = token.attr('content');

                $splash.open();
            };

        }]);

})(angular);
