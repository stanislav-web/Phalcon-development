"use strict";

(function(angular) {

    app
        .directive('menuTop', ['TEMPLATE', function (TEMPLATE) {

            return {
                restrict: "E",
                templateUrl: TEMPLATE.MENU_TOP
            }
        }])
        .directive('menuCategories', ['TEMPLATE', 'BASE', function (TEMPLATE, BASE) {

            return {
                restrict: "E",
                link: function (scope, element, attrs) {
                    scope.categories = scope.root.engines.categories;
                    scope.step       = BASE.LIST.PARTS;

                    console.log('Categories', scope.categories[0].childs);

                    var Parts = _.map(_.partition(scope.categories[0].childs, function(val, i) {

                        return (i % 3);
                    }));

                    console.log('Parts', Parts);
                },
                templateUrl: TEMPLATE.MENU_CATEGORIES
            }
        }]);

})(angular);






