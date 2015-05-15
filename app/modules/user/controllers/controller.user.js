"use strict";

(function(angular){

    /**
     * Controller "UserController"
     *
     * User strict auth area
     */
    angular.module('app.user').controller('UserController', ['$scope', 'Document', 'UserService',
        function($scope, Document, UserService) {

            // set meta title
            $scope.$parent.$watch('engines', function(engine) {
                Document.setTitle(engine.name);
            });

            $scope.auth = UserService.getUserAuth();
        }
    ]);

})(angular);


