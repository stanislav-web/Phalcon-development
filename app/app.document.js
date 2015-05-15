"use strict";

(function(angular) {

    angular.module('app.document', [])

        .service('Document',  ['$translate', '$rootScope', function($translate, $rootScope) {

            return {

                /**
                 * Set page title
                 *
                 * @param newTitle
                 * @param oldTitle
                 * @returns {*}
                 */
                setTitle: function (newTitle, oldTitle) {

                    $translate(newTitle).then(function (newTitle) {
                        $rootScope.documentTitle = newTitle;
                    });

                    $rootScope.$on('$translateChangeSuccess', function () {
                        $translate(newTitle).then(function (newTitle) {

                            if(!_.isUndefined(oldTitle) === true) {
                                // hack to disable reload basic title
                                $rootScope.documentTitle = newTitle;
                            }
                        });
                    });
                },

                /**
                 * Prepend title
                 *
                 * @param title
                 * @param delimiter
                 * @returns {*}
                 */
                prependTitle: function (title, delimiter) {

                    if(!delimiter) delimiter = ' ';
                    if(!documentTitle) var documentTitle = $rootScope.documentTitle;

                    $rootScope.$on('$translateChangeSuccess', function () {
                        $translate(title).then(function (title) {
                            $rootScope.documentTitle = title +' ' + delimiter + ' '+ documentTitle;
                        });
                    });

                    return this;
                },

                /**
                 * Append title
                 *
                 * @param title
                 * @param delimiter
                 * @returns {*}
                 */
                appendTitle: function (title, delimiter) {

                    if(!delimiter) delimiter = ' ';

                    $rootScope.$on('$translateChangeSuccess', function () {
                        $translate(title).then(function (title) {
                            $rootScope.documentTitle += ' '+ delimiter+ ' ' + title;
                        });
                    });

                    return this;
                },

                /**
                 * Set page description
                 *
                 * @param description
                 * @returns {*}
                 */
                setDescription: function (description) {
                    var desc =  String(description).replace(/<[^>]+>/gm, '');
                    $rootScope.engines.description = desc;
                }
            };
        }]);

})(angular);