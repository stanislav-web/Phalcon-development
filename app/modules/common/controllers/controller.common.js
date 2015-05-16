"use strict";

(function(angular){

    /**
     * Controller "CommonController"
     *
     * Control of main page.
     */
    angular.module('app.common').controller('CommonController', ['Document', '$scope',
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