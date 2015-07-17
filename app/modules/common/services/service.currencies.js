(function (angular) {

    'use strict';

    /**
     * Currencies Service
     */
    angular.module('app.common')

        .service('CurrenciesService', ['Restangular', function(Restangular) {

            /**
             * Build tree's select
             *
             * @param array response
             * @returns {*}
             */
            var buildSelect = function(response) {

                var currencies = [];

                response.forEach(function(value) {
                    currencies.push({
                        icon : '<img class="lang-sm lang-lbl" lang="' +value.code.toLowerCase()+ '">',
                        name : value.name,
                        maker : value.symbol,
                        ticked : (value.code === CONFIG.DEFAULT_CURRENCY) ? true : false
                    });
                });

                return currencies;
            };

            return {

                /**
                 * Load all
                 *
                 * @param callable callback
                 */
                load : function(callback) {

                    Restangular.all("currencies").getList().then(function(response) {
                        callback(buildSelect(response));
                    });
                }
            };
    }]);
})(angular);