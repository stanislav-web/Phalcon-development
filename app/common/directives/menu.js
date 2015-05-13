"use strict";

(function(angular) {

    app
        .directive('menuTop', function () {

            return {
                restrict: "AE",
                templateUrl: CONFIG.TEMPLATES.MENU_TOP
            }
        })
        .directive('menuCategories', function () {
            return {
                restrict: "AE",
                templateUrl: CONFIG.TEMPLATES.MENU_CATEGORIES

            }
        })
        .directive('sidebar', function () {
            return {
                restrict: "AE",
                templateUrl: CONFIG.TEMPLATES.MENU_SIDEBAR
            }
        });
})(angular);






