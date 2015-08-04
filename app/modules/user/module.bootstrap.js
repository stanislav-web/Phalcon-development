(function(angular) {

    "use strict";

    // user module
    angular.module('app.user', [])

        .constant('ModuleUserConfig', {
            noImage : CONFIG.DEFAULT_IMAGES.PROFILE
        });

})(angular);