"use strict";

(function(angular) {

    app
        .directive('menuTop', ['BASE', function (BASE) {

            return {
                restrict: "AE",
                templateUrl: BASE.TEMPLATES.MENU_TOP
            }
        }])
        .directive('menuCategories', ['BASE', function (BASE) {
            return {
                restrict: "AE",
                templateUrl: BASE.TEMPLATES.MENU_CATEGORIES

            }
        }])
        .directive('sidebar', ['BASE', function (BASE) {
            return {
                restrict: "AE",
                templateUrl: BASE.TEMPLATES.MENU_SIDEBAR
            }
        }]);
})(angular);






