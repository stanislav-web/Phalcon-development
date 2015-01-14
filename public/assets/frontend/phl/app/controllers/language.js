"use strict";

/**
 * Controller "LanguageController"
 *
 * @dependencies $scope global variables
 * @dependencies $translate angular-translater
 *
 */

phl.controller('LanguageController', ['$translate', '$scope', function ($translate, $scope) {

    // set up language switcher

    $scope.changeLanguage = function (langKey) {

        $translate.use(langKey);
        $translate.refresh();

    };

    $scope.getCurrentLanguage = function () {
        $translate.preferredLanguage();
    };

}]);