'use strict';

(function (angular) {

    /**
     * Upload Data Service
     */
    angular.module('app.common')

        .service('UploadService', ['Upload', function(Upload) {

            return {

                /**
                 * Read picture local
                 *
                 * @param callable callback
                 */
                readPicture : function(file, callback) {

                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function (event) {

                        (CONFIG.DEBBUG === true) ? debug('Read uploading event', event) : null;
                        callback(event);
                    }
                },

                /**
                 * Upload file
                 *
                 * @param string path
                 * @returns {*}
                 */
                upload: function(creadentials) {

                    if(!creadentials.hasOwnProperty('url')) {

                        notify.error('Upload URL not defined');
                        return false;
                    }
                    if(!creadentials.hasOwnProperty('method')) {
                        creadentials.method = CONFIG.UPLOAD_FILE_METHOD;
                    }

                    return Upload.upload(creadentials);
                }
            };
    }]);
})(angular);