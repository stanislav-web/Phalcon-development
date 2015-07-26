(function(angular){

    "use strict";

    /**
     * Controller "ItemsController"
     *
     * Control item's representation.
     */
    angular.module('app.catalogue')

        .controller('ItemsController', ['Document', '$scope', 'CategoriesService', 'ItemsService',
            function(Document, $scope, CategoriesService, ItemsService) {

                // get current category id
                var category = CategoriesService.getCurrentCategory() || null;

                //  load categories items
                CategoriesService.getCategoryItems(category.id).then(function(response) {

                    // set meta title
                    Document.setTitle(response.categories.title);

                    // setup view scopes
                    $scope.category = response.categories;

                    // load category items with properties

                    ItemsService.load(response.items, {}, function(response) {
                        $scope.items = response.data;

                        console.log($scope.items);
                    });
                });

            }
    ]);

})(angular);