'use strict';

(function (angular) {

    /**
     * Upload Data Service
     */
    angular.module('app.common')

        .service('UploadService', ['Upload', function(Upload) {

            var config = {
                method : 'POST'
            };

            return {

                uploadUserPhoto : function(auth, photo) {

                    return this.upload({
                        url: CONFIG.URL+''+CONFIG.REST.FILES,
                        file: photo,
                        fields: {
                            id: auth.user_id,
                            mapper: 'UserMapper'
                        },
                        headers : {
                            'Content-Type': CONFIG.FORM_ENCODING,
                            'Authorization' : 'Bearer '+auth.token
                        }
                    });
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
                        creadentials.method = config.method;
                    }

                    return Upload.upload(creadentials);
                }
            };
    }]);
})(angular);