"use strict";

(function(angular){

    /**
     * Controller "LanguageController"
     *
     * Control of a switching translation.
     */
    angular.module('app.common').controller('LanguageController', ['$translate', '$scope',
        function ($translate, $scope) {

            // set up language switcher

            $scope.changeLanguage = function (langKey) {

                // change quickly
                $translate.use(langKey);

                // send to storage
                localStorage.setItem(CONFIG.LANGUAGES.PREFIX, langKey);
                $scope.currentLanguage  =   langKey;

                // update languages global
                $scope.$parent.$on('$translatePartialLoaderStructureChanged', function () {
                    $translate.refresh();
                });

                moment.locale(langKey);
            };
        }]);

})(angular);