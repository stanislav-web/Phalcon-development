"use strict";

(function(angular) {

    app.directive('menu', ['TEMPLATE', function (TEMPLATE) {

        return {
            restrict: "E",
            templateUrl: TEMPLATE.MENU,
            transclude: true,
            scope: {
                isAuthentificated: "="
            }
        }
    }]);

})(angular);






