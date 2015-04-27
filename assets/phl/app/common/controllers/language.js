"use strict";

(function(angular){

    /**
     * Controller "LanguageController"
     *
     * Control of a switching translation.
     */
    app.controller('LanguageController', ['$translate', '$scope', 'Session', 'BASE',
        function ($translate, $scope, Session, BASE) {

            // set up language switcher

            $scope.changeLanguage = function (langKey) {

                // change quickly
                $translate.use(langKey);

                // send to storage
                Session.set(BASE.LANGUAGES.PREFIX, langKey);
                $scope.currentLanguage  =   langKey;
                moment.locale(langKey);
            };
        }]);

})(angular);