angular.module('UsersTools').controller('UsersToolsController',
    ['$scope',
    '$http',
    function UsersToolsController($scope,$http) {
        let self=this;
        $http.get('/users-tools/users-get').then(
            function success(response) {
                $scope.userMas=response.data;
        },
            function failed() {
                console.log('ОШИБКА! Не удалось получить данные с сервера');
                $scope.reponse='ОШИБКА! Не удалось получить данные с сервера';
        });
    }
]);