"use strict";

(function(angular) {

    angular.module('app.catalogue')

        .directive('gridview', function() {
            return {
                restrict: 'E',
                templateUrl: CONFIG.DIRECTIVES.GRIDVIEW,
                scope: {
                    items : '='
                },
                link: function ($scope, element, attrs) {
                    //DOM manipulation
                    console.log($scope, element, attrs);
                }
            };
        });

})(angular);
