"use strict";

var phl;

(function(angular){

    /**
     * Application Module
     */
    phl = angular.module('phl', ["ngRoute"], function($httpProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.transformRequest = [function (data) {
            if (data === undefined) {
                data = {};
            }
            var token = $('meta[name=token]');

            phl.value('token_id', token.attr('title'));
            phl.value('token_val', token.attr('content'));

            data[token.attr('title')] = token.attr('content');
            return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
        }];
    });

    // configure application

    phl.config(['$routeProvider', function($routeProvider) {

        /**
         * RouteProvider setup
         */
        $routeProvider.when("/home", {
            templateUrl: "assets/frontend/phl/views/index.html",
            controller: "IndexController"
        })
            .when("/about", {
                templateUrl: "assets/frontend/phl/views/about.html",
                controller: "AboutController"
            })
            .when("/contact", {
                templateUrl: "assets/frontend/phl/views/contact.html",
                controller: "ContactController"
            })
            .when("/blog", {
                templateUrl: "assets/frontend/phl/views/blog.html",
                controller: "BlogController"
            })
            .otherwise({ redirectTo: "/" });
    }]);
})(angular);