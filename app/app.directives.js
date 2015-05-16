"use strict";

(function(angular) {

    angular.module('app.directives', [])

        .directive('usSpinner', ['$http', '$rootScope' ,function ($http, $rootScope) {
            return {
                link: function (scope, elm, attrs)
                {
                    $rootScope.spinnerActive = false;
                    scope.isLoading = function () {
                        return $http.pendingRequests.length > 0;
                    };

                    scope.$watch(scope.isLoading, function (loading)
                    {
                        $rootScope.spinnerActive = loading;
                        if(loading){
                            elm.removeClass('ng-hide');
                        } else {
                            elm.addClass('ng-hide');
                        }
                    });
                }
            };
        }])
        .directive('menuTop', function () {

            return {
                restrict: "AE",
                templateUrl: CONFIG.DIRECTIVES.TOP
            }
        })
        .directive('menuCategories', function () {
            return {
                restrict: "AE",
                templateUrl: CONFIG.DIRECTIVES.CATEGORIES

            }
        })
        .directive('sidebar', function () {
            return {
                restrict: "AE",
                templateUrl: CONFIG.DIRECTIVES.SIDEBAR
            }
        })
        .directive('languageSwitcher', function () {
            return {
                restrict: "AE",
                template: '<ul ng-controller="LanguageController" ng-init="changeLanguage(currentLanguage)">' +
                '<li ng-class="{\'active\':currentLanguage === \'en\'}"><span ng-click="changeLanguage(\'en\')" class="lang-sm lang-lbl" lang="en"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'ru\'}"><span ng-click="changeLanguage(\'ru\')" class="lang-sm lang-lbl" lang="ru"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'de\'}"><span ng-click="changeLanguage(\'de\')" class="lang-sm lang-lbl" lang="de"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'uk\'}"><span ng-click="changeLanguage(\'uk\')" class="lang-sm lang-lbl" lang="uk"></span>&nbsp;</li>' +
                '</ul>'
            }
        })

        .directive('banners', ['$timeout', function ($timeout)  {
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
                templateUrl: CONFIG.DIRECTIVES.BANNERS,

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