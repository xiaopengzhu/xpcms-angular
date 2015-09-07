var app = angular.module('app', ['ngRoute']);

//路由设置
app.config(function($routeProvider){
    $routeProvider.when('/', {
        templateUrl: "Views/index/index.html",
        controller: "indexCtrl",
    }).when('/article/:cid', {
        templateUrl: "Views/article/list.html",
        controller: "artCtrl",
    }).when('/article/view/:id', {
        templateUrl: "Views/article/view.html",
        controller: "artCtrl",
    }).when('/photo/:id', {
        templateUrl: "Views/photo/list.html",
        controller: "artCtrl",
    }).when('/music/:id', {
        templateUrl: "Views/music/list.html",
        controller: "artlistCtrl",
    }).when('/video/:id', {
        templateUrl: "Views/video/list.html",
        controller: "artlistCtrl",
    }).when('/product/:id', {
        templateUrl: "Views/product/list.html",
        controller: "artlistCtrl",
    });
});

//过滤器
app.filter("toHtml", ["$sce", function($sce) {
    return function(text) {
        return $sce.trustAsHtml(text);
    }
}]);

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

//文章控制器
app.controller('artCtrl', ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams) {
    if ($routeParams.cid) {
        $http.get('/xpcms-angular/service/article/getListData/cid/'+$routeParams.cid)
        .success(function (data) {
            $scope.data = data;
        })
        .error(function () {
            alert("get artlist error");
        });
    } else if ($routeParams.id) {
        $http.get('/xpcms-angular/service/article/getViewData/id/'+$routeParams.id)
        .success(function (data) {
            $scope.data = data;
        })
        .error(function () {
            alert("get artlist error");
        });
    }
}]).filter("to_html", ["$sce", function($sce) {
    return function(text) {
        console.log(text);
    	//return $sce.trustAsHtml(text);
    }
}]);

