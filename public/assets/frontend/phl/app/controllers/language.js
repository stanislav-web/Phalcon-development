"use strict";

/**
 * Controller "LanguageController"
 *
 * @dependencies $scope global variables
 *
 */
phl.controller('LanguageController', ['$scope', '$translate', function ($scope, $translate) {

    $scope.toggleLanguage = function (key) {
        $translate.use(key);

        $translate.use(($translate.use() === 'en') ? key : 'en');

    };
}]);;