"use strict";

(function(angular){

    /**
     * Controller "IndexController"
     *
     * Control of main page.
     */
    app.controller('IndexController', ['$scope', '$location', 'Meta',
        function($scope, $location, Meta) {

            // set meta title
            Meta.setTitle($scope.$parent.engines.name);
        }
    ]);

})(angular);