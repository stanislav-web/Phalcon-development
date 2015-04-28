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
                restrict: "AE",
                link: function (scope, element, attrs) {

                    scope.$watch('root', function(global) {

                        if(!_.isUndefined(global)) {

                            _.map(global.engines.categories, function(category) {
                                if(category.hasOwnProperty('childs')) {
                                    // partition array by fixed chunk
                                    category.childs = _.chunk(category.childs, BASE.LIST.PARTS);
                                }
                            });
                            scope.categories = global.engines.categories;
                        }
                    });
                },
                templateUrl: TEMPLATE.MENU_CATEGORIES
            }
        }]);

})(angular);






