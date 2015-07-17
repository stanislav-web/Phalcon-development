'use strict';

(function (angular) {

    /**
     * Data Service
     */
    angular.module('app.common')

        .provider("Serialize", function () {
            var data = [];

            return {

                /**
                 * The workhorse; converts an object to x-www-form-urlencoded serialization.
                 *
                 * @param {Object} obj
                 * @return {String}
                 */
                urlencode: function (innerData) {

                    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

                    for(name in innerData) {
                        value = innerData[name];

                        if(value instanceof Array) {
                            for(i=0; i<value.length; ++i) {
                                subValue = value[i];
                                fullSubName = name + '[' + i + ']';
                                innerObj = {};
                                innerObj[fullSubName] = subValue;
                                query += this.urlencode(innerObj) + '&';
                            }
                        }
                        else if(value instanceof Object) {
                            for(subName in value) {
                                subValue = value[subName];
                                fullSubName = name + '[' + subName + ']';
                                innerObj = {};
                                innerObj[fullSubName] = subValue;
                                query += this.urlencode(innerObj) + '&';
                            }
                        }
                        else if(value !== undefined && value !== null)
                            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                    }

                    data =  (query.length) ? query.substr(0, query.length - 1) : query;

                    return data;
                },

                /**
                 * Separate response data
                 *
                 * @param response
                 * @param operation
                 * @returns {{}}
                 */
                separateResponse : function(response, operation) {

                    var newResponse = {};
                    if(operation === 'getList') {
                        newResponse = response.data;
                        if(response.debug) {
                            newResponse.meta = response.meta;
                        }
                        if(response.debug) {
                            newResponse.debug = response.debug;
                        }
                    }
                    else {
                        newResponse = response.data
                    }
                    return newResponse;
                },

                $get: function () {
                    return data;
                }
            };
         })

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