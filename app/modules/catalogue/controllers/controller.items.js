(function(angular){

    "use strict";

    /**
     * Controller "ItemsController"
     *
     * Control item's representation.
     */
    angular.module('app.catalogue').controller('ItemsController', ['Document', '$scope', 'CategoriesService',
        function(Document, $scope, CategoriesService) {

            // load current category
            CategoriesService.getCurrentCategory(function(category) {

                // set meta title
                Document.setTitle(category.title);
                $scope.category = category;
            });
        }
    ]);

})(angular);