angular.module('UsersTools').controller('UsersToolsController',
    function UsersToolsController($scope) {
        let self=this;
        self.testMessage='Angular. UsersToolsController. Created';
        $scope.testMessage=self.testMessage;
        console.log(self.testMessage);
    }
);