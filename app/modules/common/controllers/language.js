"use strict";

(function(angular){

    /**
     * Controller "LanguageController"
     *
     * Control of a switching translation.
     */
    angular.module('app').controller('LanguageController', ['$translate', '$scope', 'Session',
        function ($translate, $scope, Session) {

            // set up language switcher

            $scope.changeLanguage = function (langKey) {

                // change quickly
                $translate.use(langKey);

                // send to storage
                Session.set(CONFIG.LANGUAGES.PREFIX, langKey);
                $scope.currentLanguage  =   langKey;

                // update languages global
                $scope.$parent.$on('$translatePartialLoaderStructureChanged', function () {
                    $translate.refresh();
                });

                moment.locale(langKey);
            };
        }]);

})(angular);