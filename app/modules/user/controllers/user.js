"use strict";

(function(angular){

    /**
     * Controller "UserController"
     *
     * User strict auth area
     */
    angular.module('app.user').controller('UserController', ['$scope', '$location', 'Meta',
        function($scope, $location, Meta) {

            // set meta title
            Meta.setTitle($scope.$parent.engines.name);
        }
    ]);

})(angular);


