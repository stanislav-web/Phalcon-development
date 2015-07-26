(function (angular) {

    'use strict';

    /**
     * Categories Service
     */
    angular.module('app.catalogue')

        .service('CategoriesService', ['Restangular', 'DataService', function(Restangular, DataService) {

            /**
             * Flatten categories list
             * @type {Array}
             */
            var categoriesList = [];

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
                        response.categories = DataService.chunk(response.categories, 'childs', CONFIG.LIST.PARTS);
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
                 * Get the current category data
                 *
                 * @returns {function(*)}
                 */
                getCurrentCategory : function() {

                    var current =  _.remove(window.location.pathname.split('/'), function(el) {
                        return el.length > 0;
                    }).slice(-1).pop();

                    return _.find(this.loadFlatten(), { 'alias': current })
                },

                /**
                 * Get the current category items
                 *
                 * @param int category_id
                 * @param array params
                 * @returns {Promise(*)}
                 */
                getCategoryItems : function(category_id, params) {

                    return Restangular.one(CONFIG.REST.CATEGORY+'/'+parseInt(category_id))
                            .customGET(params);
                },
            };
    }]);
})(angular);