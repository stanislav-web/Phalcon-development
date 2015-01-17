"use strict";

/**
 * Controller "LanguageController"
 *
 * @dependencies $translate angular-translater
 * @dependencies $scope global variables
 * @dependencies $cookies angular-cookies
 */
phl.controller('LanguageController', ['$translate', '$scope', '$cookies',
    function ($translate, $scope, $cookies) {

    // set up language switcher

    $scope.changeLanguage = function (langKey) {

        // change quickly
        $translate.use(langKey);

        if(store.enabled) {

            // send to storage
            store.set('NG_TRANSLATE_LANG_KEY',   langKey);
        }
        else {

            // create cookie
            $cookies.NG_TRANSLATE_LANG_KEY = langKey;
        }

        $scope.currentLanguage  =   langKey;
    };
}]);