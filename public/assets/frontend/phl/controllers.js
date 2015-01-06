// create controller, with Dependency
phl.controller('IndexController', ['$scope', '$routeParams', function($scope, $routeParams) {

    "use strict";

    $scope.user = {
        name : $routeParams.name
    };

}]);

// create controller, with Dependency
phl.controller('UserController', ['$scope', '$routeParams', function($scope, $routeParams) {

     "use strict";

    $scope.user = {
        name : $routeParams.name
    };

}]);