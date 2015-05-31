"use strict";

(function(angular){

    /**
     * Controller "UserController"
     *
     * User strict auth area
     */
    angular.module('app.user').controller('UserController', ['$scope', 'Document', 'UserService', 'UploadService', 'ModuleUserConfig',
        function($scope, Document, UserService, UploadService, ModuleUserConfig) {

            // set meta title
            $scope.$parent.$watch('engines', function(engine) {
                if(!_.isUndefined(engine)) {
                    Document.setTitle(engine.name);
                }
            });

            var userPromise = UserService.getUser();

            if(userPromise) {
                userPromise.then(function(response) {

                    $scope.user = response;
                    $scope.auth = UserService.getUserAuth();

                    if($scope.user.photo.length > 0) {
                        // resolve full uri photo path
                        $scope.user.photo = CONFIG.FILES_URL + $scope.user.photo;
                    }
                    else {
                        // set default image as empty
                        $scope.user.photo = ModuleUserConfig.noImage;
                    }
                });

                /**
                 * Upload user profile image
                 *
                 * @param file
                 * @param event
                 */
                $scope.upload = function(file, event) {
                    if(event.type === 'change') {
                        // upload a user profile photo
                        UploadService.uploadUserPhoto($scope.auth.access, file[0]).success(function() {

                            // change preview
                            var fileReader = new FileReader();
                            fileReader.readAsDataURL(file[0]);
                            fileReader.onload = function (e) {
                                $scope.user.photo = e.target.result;
                                notify.success('Your profile picture has been updated');

                            }
                        })
                        .error(function(data) {
                            notify.error(data);
                            return false;
                        })
                    }
                }

                /**
                 * Update user profile data
                 *
                 * @param user
                 */
                $scope.profile = function(user) {

                    $scope.loading = true;

                    UserService.updateUser(user).then(function() {
                        notify.success('Your profile has been updated');
                        $scope.loading = false;

                    });
                },

                /**
                 * Update user profile data
                 *
                 * @param user
                 */
                    $scope.password = function(user) {

                        $scope.loading = true;

                        UserService.getFreshAuth(user).then(function(response) {


                            // Set fresh auth data to storage
                            UserService.setAuthData(response);

                            setTimeout(function() {

                                // update user password. Wait before storage update
                                UserService.updatePassword(user).then(function() {
                                    notify.success('Your password has been changed');
                                    $scope.loading = false;
                                });
                            }, 200);
                        });
                }
            }
        }
    ]);

})(angular);


