"use strict";

(function(angular) {

    angular.module('app.common')
        .filter('stripTags', function () {
            return function(text) {
                return String(text).replace(/<[^>]+>/gm, '');
            }
        });

})(angular);






