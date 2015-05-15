"use strict";

(function(angular){

    /**
     * Controller "IndexController"
     *
     * Control of main page.
     */
    angular.module('app.common').controller('IndexController', ['Meta', '$scope',
        function(Meta, $scope) {

            // set meta title
            $scope.$parent.$watch('engines', function(engine) {
                Meta.setTitle(engine.name);
            });
        }
    ]);

})(angular);