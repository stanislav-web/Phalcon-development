"use strict";

(function(angular) {

    angular.module('app.session', [])

        .service('Session',  function() {

            return {

                /**
                 * Set key to session storage
                 *
                 * @param key
                 * @param value
                 * @param secret
                 * @returns {*}
                 */
                set: function (key, value, secret) {

                    if (typeof value === 'object') {
                        value = JSON.stringify(value);
                    }

                    if(secret) {
                        value = CryptoJS.AES.encrypt(value, secret);
                    }

                    return localStorage.setItem(key, value);
                },

                /**
                 * Get key from session storage
                 *
                 * @uses store
                 * @param key
                 * @param secret
                 * @returns {*}
                 */
                get: function (key, secret) {

                    var data = localStorage.getItem(key), value;

                    try {

                        if(secret) {
                            data = CryptoJS.AES.decrypt(data, secret).toString(CryptoJS.enc.Utf8);
                            //console.log(data);
                        }
                        value = JSON.parse(data);

                    }
                    catch(e) {

                        if(secret) {

                            value = CryptoJS.AES.decrypt(data, secret)
                                .toString(CryptoJS.enc.Utf8);
                        }
                        else {
                            value = data;
                        }
                    }
                    finally {
                        if(value !== null) {
                            return value;
                        }
                    }
                },

                /**
                 * Remove key from session storage
                 *
                 * @param key
                 * @returns {*}
                 */
                remove: function (key) {
                    return localStorage.removeItem(key);
                },

                /**
                 * Destroy all keys
                 *
                 * @returns {*}
                 */
                destroy: function () {
                    return localStorage.clear();
                }
            };
        });

})(angular);