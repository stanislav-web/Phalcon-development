'use strict';

(function (angular) {

    /**
     * Translate load failed notifier
     */
    angular.module('app.common').factory('TranslateErrorHandler', function ($q, $log) {
        return function (part, lang) {
            $log.error('The "' + part + '/' + lang + '" part was not loaded.');
            return $q.when({});
        };
    });

})(angular);