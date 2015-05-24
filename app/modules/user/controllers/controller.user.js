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
                Document.setTitle(engine.name);
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

                $scope.upload = function(file, event) {
                    if(event.type === 'change') {
                        // upload a user profile photo
                        UploadService.uploadUserPhoto($scope.auth.access, file[0]).success(function() {

                            // change preview
                            var fileReader = new FileReader();
                            fileReader.readAsDataURL(file[0]);
                            fileReader.onload = function (e) {
                                $scope.user.photo = e.target.result;
                            }
                        })
                        .error(function(data) {
                            notify.error(data);
                            return false;
                        })
                    }
                }
            }
        }
    ]);

})(angular);


