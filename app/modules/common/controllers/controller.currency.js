"use strict";

(function(angular){

    /**
     * Controller "CurrencyController"
     *
     * Control of a switching currency list.
     */
    angular.module('app.common').controller('CurrencyController', ['$translate', '$scope',
        function ($translate, $scope) {

            $scope.changeCurrency = function(currency) {
                console.log('Selected currency', currency);
            };

        }]);

})(angular);