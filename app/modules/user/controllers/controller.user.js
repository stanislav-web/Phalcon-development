"use strict";

(function(angular){

    /**
     * Controller "UserController"
     *
     * User strict auth area
     */
    angular.module('app.user').controller('UserController', ['$scope', 'Document', 'UserService', 'UploadService',
        function($scope, Document, UserService) {

            var userPromise = UserService.getUser();

            if(userPromise) {
                userPromise.then(function(response) {

                    $scope.user = response;
                    $scope.auth = UserService.getUserAuth();

                    // set meta title
                    Document.prependTitle($scope.user.name, '-');

                    // set user profile photo
                    $scope.user.photo = UserService.setUserPhoto(response.photo);

                });

                /**
                 * Upload user profile image
                 *
                 * @param file
                 * @param event
                 */
                $scope.upload = function(file, event) {

                    // upload a user profile photo
                    var upload = UserService.uploadProfilePicture($scope.auth.access, file[0], $scope, event);
                    if(upload != undefined) {
                        upload.success(function() {
                            notify.success('Your profile picture has been updated');
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
                 * Update user profile password
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
                    }, function() {
                        $scope.loading = false;
                    });
                }
            }
        }
    ]);

})(angular);


