"use strict";

(function(angular) {

    angular.module('app')
        .directive('languageSwitcher', function () {
            return {
                restrict: "AE",
                template: '<ul ng-controller="LanguageController" ng-init="changeLanguage(currentLanguage)">' +
                '<li ng-class="{\'active\':currentLanguage === \'en\'}"><span ng-click="changeLanguage(\'en\')" class="lang-sm lang-lbl" lang="en"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'ru\'}"><span ng-click="changeLanguage(\'ru\')" class="lang-sm lang-lbl" lang="ru"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'de\'}"><span ng-click="changeLanguage(\'de\')" class="lang-sm lang-lbl" lang="de"></span>&nbsp;</li>' +
                '<li ng-class="{\'active\':currentLanguage === \'uk\'}"><span ng-click="changeLanguage(\'uk\')" class="lang-sm lang-lbl" lang="uk"></span>&nbsp;</li>' +
                '</ul>'
            }
        });
})(angular);






