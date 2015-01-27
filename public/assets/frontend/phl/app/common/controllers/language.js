"use strict";

(function(angular){

    /**
     * Controller "LanguageController"
     *
     * @dependencies $translate angular-translater
     * @dependencies $scope global variables
     * @dependencies $cookies angular-cookies
     */
    app.controller('LanguageCtrl', ['$translate', '$scope', '$cookies',
        function ($translate, $scope, $cookies) {

            // set up language switcher

            $scope.changeLanguage = function (langKey) {

                // change quickly
                $translate.use(langKey);

                if($cookies) {

                    // create cookie
                    $cookies.NG_TRANSLATE_LANG_KEY = langKey;

                }
                else {
                    // send to storage
                    store.set('NG_TRANSLATE_LANG_KEY',   langKey);
                }

                $scope.currentLanguage  =   langKey;
            };
        }]);

})(angular);