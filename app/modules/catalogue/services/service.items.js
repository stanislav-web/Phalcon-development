(function (angular) {

    'use strict';

    /**
     * Items Service
     */
    angular.module('app.catalogue')

        .service('ItemsService', ['Restangular', 'DataService', function(Restangular, DataService) {


            return {

                /**
                 * Load items
                 *
                 * @param mixed ids
                 * @param callable callback
                 * @returns {Promise(*)}
                 */
                load : function(ids, params, callback) {

                    var id  = (
                        (typeof ids === 'array') ? ids.join() :
                        (typeof ids === 'object') ? DataService.getPropertyArray(ids, 'id').join()  : parseInt(ids)
                    );

                    Restangular.all(CONFIG.REST.ITEM_ATTRIBUTES.replace(":ids", id)).getList(params).then(function(response) {
                        callback(response.original);
                    });
                },

            };
    }]);
})(angular);