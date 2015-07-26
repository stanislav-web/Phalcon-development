(function(window) {

    "use strict";

    CONFIG = angular.extend({}, CONFIG, {
        LOGGER: false,
        DEBBUG: true
    });

    /**
     * Debugging any data function
     */
    window.debug = function() {
        var label = arguments[0], args = [];
        delete arguments[0];

        _.forEach(arguments, function(value) {
            if(value !== undefined) {
                args.push(value);
            }
        });
        console.info('[DEBUG] '+ label +': ', args);
    }
})(window);