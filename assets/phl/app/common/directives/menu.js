"use strict";

(function(angular) {

    app.directive('menu', ['TEMPLATE', function (TEMPLATE) {

        return {
            restrict: "E",
            templateUrl: TEMPLATE.MENU
        }
    }]);

})(angular);






