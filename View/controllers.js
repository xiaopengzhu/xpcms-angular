var app = angular.module('app',[]);

app.controller('indexCtrl', ["$scope", "$http", function($scope, $http) {
    $scope.categorys = [
        {id:2, name: '文章'},
        {id:3, name: '音乐'},
        {id:4, name: '视频'}
    ];
    
    $http.get('/xpcms-angular/service/getCategorys')
    .success(function (data) {
        $scope.categorys = data;
    })
    .error(function () {
        alert("get categorys error");
    });
    
    $http.get('/xpcms-angular/service/getIndexData')
    .success(function (data) {
        $scope.data = data;
    })
    .error(function () {
        alert("get slides error");
    });
    
    $http.get('/xpcms-angular/service/getLink')
    .success(function (data) {
        $scope.links = data;
    })
    .error(function () {
        alert("get links error");
    });
}]);