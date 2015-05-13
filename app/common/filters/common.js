"use strict";

(function(angular) {

    app
        .filter('stripTags', function () {
            return function(text) {
                return String(text).replace(/<[^>]+>/gm, '');
            }
        });

})(angular);






