"use strict";

(function(angular) {

    // authenticate module
    angular.module('app.authenticate', [])

        .constant('ModuleAuthenticateConfig', {
            key : 'PICKCHARSFROMTHISSET',
            keyLength : 4
        })
        .run(['$rootScope', 'AuthenticationService', '$location', function($rootScope, AuthenticationService, $location) {

            $rootScope.$on("$routeChangeSuccess", function(event, next, current) {

                // Auth checkout
                $rootScope.isLoggedIn = AuthenticationService.isLoggedIn();

                if($rootScope.isLoggedIn === true) {
                    var user = AuthenticationService.getAuthData();

                    if(next.$$route && next.$$route.hasOwnProperty('access')) {

                        // Checkout ACL
                        if(next.$$route.access.indexOf(user.roles.role) == -1) {
                            window.location.assign(CONFIG.LOCATIONS.FORBIDDEN);
                        }
                    }
                }
                else if(next.$$route.hasOwnProperty('authorization')) {

                    // Unauthorized users remove to home page
                    $location.path(CONFIG.LOCATIONS.HOME);
                }
            });
        }])

})(angular);