"use strict";

(function(angular){

    /**
     * Controller "UserController"
     *
     * User strict auth area
     */
    angular.module('app.user').controller('UserController', ['$scope', 'Meta', 'UserService',
        function($scope, Meta, UserService) {

            // set meta title
            $scope.$parent.$watch('engines', function(engine) {
                Meta.setTitle(engine.name);
            });

            $scope.auth = UserService.getUserAuth();
        }
    ]);

})(angular);


