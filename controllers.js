var app = angular.module('app',[]);
//路由设置
app.config(function($routeProvider){
    $routeProvider.when('/', {
        templateUrl: "Views/index/index.html",
        controller: "indexCtrl",
    }).when('/artlist/:id', {
        templateUrl: "Views/article/list.html",
        controller: "listCtrl",
    })
});

//公共数据控制器
app.controller('commonCtrl', ["$scope", "$http", function($scope, $http) {
    $http.get('/xpcms-angular/service/common/getData')
    .success(function (data) {
        $scope.categorys = data.categorys;
        $scope.links = data.links;
    })
    .error(function () {
        alert("get common data error");
    });
}]);

//首页控制器
app.controller('indexCtrl', ["$scope", "$http", function($scope, $http) {
    $http.get('/xpcms-angular/service/index/getData')
    .success(function (data) {
        $scope.data = data;
    })
    .error(function () {
        alert("get index data error");
    });
}]);

//文章列表控制器
app.controller('listCtrl', ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams) {
    console.log($routeParams.id);
    $http.get('/xpcms-angular/service/getArtList')
    .success(function (data) {
        $scope.arts = data;
    })
    .error(function () {
        alert("get categorys error");
    });
}]);




