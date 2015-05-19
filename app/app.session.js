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
                    setTimeout(function() {
                        localStorage.setItem(key, value);
                    }, 10);
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
                 */
                remove: function (key) {

                    localStorage.removeItem(key);

                    return  this;
                },

                /**
                 * Destroy all keys
                 */
                destroy: function () {
                    localStorage.clear();
                }
            };
        });

})(angular);