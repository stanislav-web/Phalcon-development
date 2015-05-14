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
            Meta.setTitle($scope.$parent.engines.name);

            // get user auth data
            console.log(UserService.getUserAuth());
        }
    ]);

})(angular);


