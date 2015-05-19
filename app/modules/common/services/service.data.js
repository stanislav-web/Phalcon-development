'use strict';

(function (angular) {

    /**
     * Data Service
     */
    angular.module('app.common')

        .service('DataService', [function() {

            return {

                /**
                 * Get nested json data
                 *
                 * @param string path
                 * @returns {*}
                 */
                getData: function(path, callback) {

                    var xobj = new XMLHttpRequest();
                    xobj.overrideMimeType("application/json");
                    xobj.open('GET', path, true); // Replace 'my_data' with the path to your file
                    xobj.onreadystatechange = function () {
                        if (xobj.readyState == 4 && xobj.status == "200") {
                            // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
                            callback(JSON.parse(xobj.responseText));
                        }
                    };
                    xobj.send(null);
                }
            };
    }]);
})(angular);