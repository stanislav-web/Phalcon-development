// Re-usable $splash module
angular.module('ui.splash', ['ui.bootstrap'])
    .service('$splash', [
        '$modal',
        '$rootScope',
        function($modal, $rootScope) {
            return {
                open: function (attrs, opts) {
                    var scope = $rootScope.$new();
                    angular.extend(scope, attrs);
                    opts = angular.extend(opts || {}, {
                        backdrop: false,
                        scope: scope,
                        templateUrl: '/assets/frontend/phl/app/templates/sign.html',
                        windowTemplateUrl: 'splash/index.html'
                    });
                    return $modal.open(opts);
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