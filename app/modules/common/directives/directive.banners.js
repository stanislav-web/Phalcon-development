"use strict";

(function(angular) {

    angular.module('app.common')
        .directive('bannersSlideshow', ['$timeout', function ($timeout)  {
            return {
                restrict: "AE",
                link: function(scope, elem, attrs) {

                    var timer;
                    var sliderFunc = function() {
                        timer = $timeout(function() {
                            scope.next();
                            timer = $timeout(sliderFunc, CONFIG.SLIDER.TIMEOUT);
                        }, CONFIG.SLIDER.TIMEOUT);
                    };

                    sliderFunc();

                    scope.$on('$destroy', function() {
                        $timeout.cancel(timer); // when the scope is getting destroyed, cancel the timer
                    });
                },
                templateUrl: CONFIG.TEMPLATES.BANNERS,

                controller: function($scope) {

                    $scope.currentIndex = 0; // Initially the index is at the first image
                    $scope.next = function() {

                        $scope.currentIndex < $scope.banners.length - 1
                            ? $scope.currentIndex++ : $scope.currentIndex = 0;
                    };

                    $scope.prev = function() {
                        $scope.currentIndex > 0
                            ? $scope.currentIndex-- : $scope.currentIndex = $scope.banners.length - 1;
                    };

                    $scope.$watch('currentIndex', function() {

                        if($scope.hasOwnProperty('banners')) {
                            $scope.banners.forEach(function(image) {
                                image.visible = false; // make every image invisible
                            });
                            $scope.banners[$scope.currentIndex].visible = true; // make the current image visible
                        }
                    });
                }
            }
        }]);
})(angular);






