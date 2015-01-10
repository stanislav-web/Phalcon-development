"use strict";

(function(angular){

    // create config constants

    phl.constant('ROUTES', (function () {

        return {
            HOME:       '/',
            CONTACTS:   '/contacts',
            HELP:       '/help',
            AGREEMENT:  '/agreement',
            ABOUT:      '/about'
        }
    })());

    // configure application's routes

    phl.config(['$routeProvider', '$locationProvider', 'ROUTES', function($routeProvider, $locationProvider, ROUTES) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider.when(ROUTES.HOME, {
            templateUrl: 'assets/frontend/phl/app/templates/index.html',
            controller: "IndexController"
        })
        .when(ROUTES.CONTACTS, {
                templateUrl: 'assets/frontend/phl/app/templates/index.html',
                controller: "IndexController"
            })
        .when(ROUTES.HELP, {
                templateUrl: 'assets/frontend/phl/app/templates/index.html',
                controller: "IndexController"
        })
        .when(ROUTES.AGREEMENT, {
                templateUrl: 'assets/frontend/phl/app/templates/index.html',
                controller: "IndexController"
        })
        .when(ROUTES.ABOUT, {
                templateUrl: 'assets/frontend/phl/app/templates/index.html',
                controller: "IndexController"
        })
        .otherwise({ redirectTo: ROUTES.HOME });

    }]);

    // post load content handle directive

    phl.directive('bindUnsafeHtml', ['$compile', function ($compile) {
        return function(scope, element, attrs) {

            scope.$watch(

                function(scope) {

                    // watch the 'bindUnsafeHtml' expression for changes
                    return scope.$eval(attrs.bindUnsafeHtml);
                },

                function(value) {
                    // when the 'bindUnsafeHtml' expression changes
                    // assign it into the current DOM
                    element.html(value);

                    // compile the new DOM and link it to the current
                    // scope.
                    // NOTE: we only compile .childNodes so that
                    // we don't get into infinite loop compiling ourselves

                    $compile(element.contents())(scope);
                }
            );
        };
    }]);

})(angular);