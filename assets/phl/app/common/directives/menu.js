"use strict";

(function(angular) {

    app
        .directive('menuTop', ['TEMPLATE', function (TEMPLATE) {

            return {
                restrict: "AE",
                templateUrl: TEMPLATE.MENU_TOP
            }
        }])
        .directive('menuCategories', ['TEMPLATE', function (TEMPLATE) {
            return {
                restrict: "AE",
                templateUrl: TEMPLATE.MENU_CATEGORIES

            }
        }])
        .directive('sidebar', ['TEMPLATE', function (TEMPLATE) {
            return {
                restrict: "AE",
                templateUrl: TEMPLATE.MENU_SIDEBAR
            }
        }]);
})(angular);






