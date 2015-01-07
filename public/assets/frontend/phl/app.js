var phl = angular.module('phl', ["ngRoute"]);


/**function($httpProvider) {

    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';

    $httpProvider.defaults.transformRequest = [function (data) {
        if (data === undefined) {
            data = {};
        }
        // get token from meta
        var token = $('meta[name=token]');

        // token to view
        $scope.token_id = token.attr('title');
        $scope.token_val = token.attr('content');

        data[token.attr('title')] = token.attr('content');
        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];
});*/