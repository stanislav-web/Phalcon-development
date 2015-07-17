(function (angular) {

    'use strict';

    /**
     * Currencies Service
     */
    angular.module('app.common')

        .service('LanguageService', ['$translate', function($translate) {

            return {

                /**
                 * Set language
                 *
                 * @param string languane
                 * @param object scope
                 * @param callable callback
                 */
                set : function(lang, scope, callback) {

                    // change quickly
                    $translate.use(lang);
                    moment.locale(lang);

                    // send to storage
                    localStorage.setItem(CONFIG.LANGUAGES.PREFIX, lang);

                    // update languages global
                    scope.$parent.$on('$translatePartialLoaderStructureChanged', function () {
                        $translate.refresh();
                        callback();
                    });

                },

                /**
                 * Get language
                 *
                 * @returns {string}
                 */
                get : function() {
                    return localStorage.getItem(CONFIG.LANGUAGES.PREFIX) || CONFIG.LANGUAGES.DEFAULT;
                }
            };
    }]);
})(angular);