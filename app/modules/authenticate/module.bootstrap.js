"use strict";

(function(angular) {

    // authenticate module
    angular.module('app.authenticate', [])

        .constant('ModuleAuthenticateConfig', {
            key : 'PICKCHARSFROMTHISSET',
            keyLength : 4
        })
        .run(['$rootScope', 'Authentication', function($rootScope, Authentication) {

            $rootScope.$on("$locationChangeSuccess", function(event, next, current) {

                // Auth checkout
                var user = Authentication.isLoggedIn();
                if(user === true) {
                        //@TODO Checkout ACL
//                        if(CONFIG.ACL[user.role].indexOf(next.originalPath) == -1) {
//                            console.log('403 Access Forbidden');
//                            $location.path(CONFIG.LOCATIONS.FORBIDDEN);
//                            event.preventDefault();
//                        }
                }

            });
        }])

})(angular);