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
    }).when('/photo/:cid', {
        templateUrl: "Views/photo/list.html",
        controller: "photoCtrl",
    }).when('/music/:cid', {
        templateUrl: "Views/music/list.html",
        controller: "musicCtrl",
    }).when('/video/:cid', {
        templateUrl: "Views/video/list.html",
        controller: "videoCtrl",
    }).when('/video/view/:id', {
        templateUrl: "Views/video/view.html",
        controller: "videoCtrl",
    }).when('/product/:cid', {
        templateUrl: "Views/product/list.html",
        controller: "artlistCtrl",
    });
});

//过滤器
app.filter("toHtml", ["$sce", function($sce) {
    return function(text) {
        return $sce.trustAsHtml(text);
    }
}])
.filter("empty", function() {
   return function(text, def) {
       if (text.length < 1)
           return def;
       else
           return text;
   }
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
}]);

//图片控制器
app.controller('photoCtrl', ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams) {
    $http.get('/xpcms-angular/service/photo/getData/cid/'+$routeParams.cid)
    .success(function (data) {
        $scope.data = data;
    })
    .error(function () {
        alert("get photo data error");
    });
}]);

//音乐控制器
app.controller('musicCtrl', ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams) {
    $http.get('/xpcms-angular/service/music/getData/cid/'+$routeParams.cid)
    .success(function (data) {
        $scope.data = data;
    })
    .error(function () {
        alert("get music data error");
    });
}]);

//视频控制器
app.controller('videoCtrl', ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams) {
    if ($routeParams.cid) {
        $http.get('/xpcms-angular/service/video/getListData/cid/'+$routeParams.cid)
        .success(function (data) {
            $scope.data = data;
        })
        .error(function () {
            alert("get videolist data error");
        });
    } else if ($routeParams.id) {
        $http.get('/xpcms-angular/service/video/getViewData/id/'+$routeParams.id)
        .success(function (data) {
            $scope.data = data;
        })
        .error(function () {
            alert("get video data error");
        });
    }
}]);


