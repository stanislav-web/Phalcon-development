'use strict';

(function(angular){

    /**
     * Splash window service
     */
    app.service('$splash', ['$modal', '$rootScope', 'TEMPLATE',
        function($modal, $rootScope, TEMPLATE) {

            var modalInstance;

            return {
                open: function (attrs, opts) {
                    var scope = $rootScope.$new();
                    angular.extend(scope, attrs);
                    opts = angular.extend(opts || {}, {
                        backdrop: false,
                        scope: scope,
                        templateUrl: TEMPLATE.SIGN,
                        windowTemplateUrl: 'splash/index.html'
                    });
                    modalInstance = $modal.open(opts);

                    return modalInstance;
                },

                close: function () {

                    return modalInstance.close();
                }
            };
        }
    ])
        .run([
            '$templateCache',
            function ($templateCache) {
                $templateCache.put('splash/index.html',
                    '<section class="splash" ng-class="{\'splash-open\': animate}" ng-style="{\'z-index\': 1000, display: \'block\'}" ng-click="close($event)">' +
                    '  <div class="splash-inner" ng-transclude></div>' +
                    '</section>'
                );
            }
        ]);

})(angular);