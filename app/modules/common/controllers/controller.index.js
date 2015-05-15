"use strict";

(function(angular){

    /**
     * Controller "IndexController"
     *
     * Control of main page.
     */
    angular.module('app.common').controller('IndexController', ['Document', '$scope',
        function(Document, $scope) {

            // set meta title
            $scope.$parent.$watch('engines', function(engine) {
                if(!_.isUndefined(engine)) {
                    Document.setTitle(engine.name);
                }
            });
        }
    ]);

})(angular);