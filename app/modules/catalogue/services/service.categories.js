(function (angular) {

    'use strict';

    /**
     * Categories Service
     */
    angular.module('app.catalogue')

        .service('CategoriesService', ['Restangular', function(Restangular) {

            /**
             * Chunk categories by parts
             *
             * @param array categories
             * @returns {*}
             */
            var chunkCategories = function(categories) {

                categories.map(function(category) {
                    if(category.hasOwnProperty('childs')) {
                        // partition array by fixed chunk
                        category.childs = _.chunk(category.childs, CONFIG.LIST.PARTS);
                    }
                });

                return categories;
            };

            return {

                /**
                 * Load all engine's categories
                 *
                 * @param callable callback
                 */
                load : function(callback) {

                    Restangular.one("engines", CONFIG.ENGINE_ID).customGET("categories").then(function(response) {

                        // chunk categories by parts
                        response.categories = chunkCategories(response.categories);
                        callback(response);
                    });
                }
            };
    }]);
})(angular);