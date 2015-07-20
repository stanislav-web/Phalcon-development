(function (angular) {

    'use strict';

    /**
     * Categories Service
     */
    angular.module('app.catalogue')

        .service('CategoriesService', ['Restangular', function(Restangular) {

            /**
             * Flatten categories list
             * @type {Array}
             */
            var categoriesList = [];

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

            /**
             * Nested to flat categories tree
             *
             * @param array categories
             * @returns array
             */
            var flatCategories = function(categories) {

                for(var i = 0; i < categories.length; ++i) {

                    if(categories[i].hasOwnProperty('childs')) {
                        flatCategories(categories[i].childs);
                    }

                    categoriesList.push({
                        id          : categories[i].id,
                        alias       : categories[i].alias,
                        title       : categories[i].title,
                        description : categories[i].description,
                        translate   : categories[i].translate,
                    });
                }
            };


            return {

                /**
                 * Load all engine's categories
                 *
                 * @param callable callback
                 */
                load : function(callback) {

                    Restangular.one("engines", CONFIG.ENGINE_ID).customGET("categories").then(function(response) {

                        // flat nested categories
                        flatCategories(response.categories);

                        // chunk categories by parts
                        response.categories = chunkCategories(response.categories);
                        callback(response);
                    });
                },

                /**
                 * Load flatten categories list
                 *
                 * @returns {Array}
                 */
                loadFlatten : function() {
                    return categoriesList || [];
                },

                /**
                 * Get the current category with params
                 *
                 * @param callback
                 * @returns {function(*)}
                 */
                getCurrentCategory : function(callback) {

                    var current =  _.remove(window.location.pathname.split('/'), function(el) {
                        return el.length > 0;
                    }).slice(-1).pop();

                    callback(
                        _.find(this.loadFlatten(), { 'alias': current})
                    )

                }
            };
    }]);
})(angular);