'use strict';

(function (angular) {

    /**
     * Crypt service
     */
    angular.module('app')
        .service('Crypt',  function() {

            return {

                /**
                 * Encode string
                 *
                 * @param string input
                 * @returns string
                 */
                encode: function (input) {
                    input = escape(input);
                    var output = "";
                    var chr1, chr2, chr3 = "";
                    var enc1, enc2, enc3, enc4 = "";
                    var i = 0;

                    do {
                        chr1 = input.charCodeAt(i++);
                        chr2 = input.charCodeAt(i++);
                        chr3 = input.charCodeAt(i++);

                        enc1 = chr1 >> 2;
                        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                        enc4 = chr3 & 63;

                        if (isNaN(chr2)) {
                            enc3 = enc4 = 64;
                        } else if (isNaN(chr3)) {
                            enc4 = 64;
                        }

                        output = output +
                        CONFIG.KEY.charAt(enc1) +
                        CONFIG.KEY.charAt(enc2) +
                        CONFIG.KEY.charAt(enc3) +
                        CONFIG.KEY.charAt(enc4);
                        chr1 = chr2 = chr3 = "";
                        enc1 = enc2 = enc3 = enc4 = "";
                    } while (i < input.length);

                    return output;
                },

                /**
                 * Decode string
                 *
                 * @param string input
                 * @returns string
                 */
                decode: function (input) {

                    var output = "";
                    var chr1, chr2, chr3 = "";
                    var enc1, enc2, enc3, enc4 = "";
                    var i = 0;

                    // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
                    var base64test = /[^A-Za-z0-9\+\/\=]/g;
                    if (base64test.exec(input)) {
                        console.log("There were invalid base64 characters in the input text.\n" +
                        "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                        "Expect errors in decoding.");
                    }

                    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

                    do {
                        enc1 = CONFIG.KEY.indexOf(input.charAt(i++));
                        enc2 = CONFIG.KEY.indexOf(input.charAt(i++));
                        enc3 = CONFIG.KEY.indexOf(input.charAt(i++));
                        enc4 = CONFIG.KEY.indexOf(input.charAt(i++));

                        chr1 = (enc1 << 2) | (enc2 >> 4);
                        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                        chr3 = ((enc3 & 3) << 6) | enc4;

                        output = output + String.fromCharCode(chr1);

                        if (enc3 != 64) {
                            output = output + String.fromCharCode(chr2);
                        }
                        if (enc4 != 64) {
                            output = output + String.fromCharCode(chr3);
                        }

                        chr1 = chr2 = chr3 = "";
                        enc1 = enc2 = enc3 = enc4 = "";

                    } while (i < input.length);

                    return unescape(output);
                }
            };
        });
})(angular);