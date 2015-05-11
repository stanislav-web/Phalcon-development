'use strict';

(function (angular) {

    /**
     * Session service
     */
    app.service('Meta',  ['$translate', '$rootScope', function($translate, $rootScope) {

        return {

            /**
             * Set page title
             *
             * @param key
             * @returns {*}
             */
            setTitle: function (newTitle, oldTitle) {

                $translate(newTitle).then(function (newTitle) {
                    $rootScope.title = newTitle;
                });

                $rootScope.$on('$translateChangeSuccess', function () {
                    $translate(newTitle).then(function (newTitle) {

                        if(!_.isUndefined(oldTitle) === true) {
                            // hack to disable reload basic title
                            $rootScope.title = newTitle;
                        }
                    });
                });
            },

            /**
             * Set page title
             *
             * @param key
             * @returns {*}
             */
            setLanguageErrors: function () {

                console.log('ok');
            }
        };
    }]);
})(angular);