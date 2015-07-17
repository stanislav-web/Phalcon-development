"use strict";

(function(angular){

    /**
     * Controller "LanguageController"
     *
     * Control of a switching translation.
     */
    angular.module('app.common').controller('LanguageController', ['LanguageService', '$scope',
        function (LanguageService, $scope) {

            // set up language switcher

            $scope.changeLanguage = function (langKey) {

                // change quickly
                LanguageService.set(langKey, $scope, function() {
                    $scope.currentLanguage  =   langKey;
                });
            };
        }]);

})(angular);