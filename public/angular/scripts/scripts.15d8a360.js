"use strict";angular.module("cursoAngularApp",["ngAnimate","ngCookies","ngResource","ngRoute","ngSanitize","ngTouch"]).config(["$routeProvider",function(a){a.when("/users",{templateUrl:"views/users.html",controller:"UsersCtrl"}).when("/products",{templateUrl:"views/products.html",controller:"ProductsCtrl"}).when("/dashboard",{templateUrl:"views/dashboard.html",controller:"DashboardCtrl"}).when("/login",{templateUrl:"views/login.html",controller:"LoginCtrl"}).otherwise({redirectTo:"/dashboard"})}]).controller("AppController",["$scope","$location","LoginService",function(a,b,c){a.logout=function(){c.logout(function(a){a&&b.path("login")})}}]),angular.module("cursoAngularApp").controller("UsersCtrl",["$scope","$http","LoginService",function(a,b,c){c.thisIsProtected(function(c){b.defaults.headers.common.Authorization="Basic "+c,b.get("http://curso-angular-api.app/api/user").success(function(b){a.users=b}).error(function(a){window.console.log("error",a)})})}]),angular.module("cursoAngularApp").controller("ProductsCtrl",["$scope","LoginService",function(a,b){b.thisIsProtected(function(a){window.console.log("token",a)})}]),angular.module("cursoAngularApp").controller("DashboardCtrl",["$scope",function(a){a.awesomeThings=["HTML5 Boilerplate","AngularJS","Karma"]}]),angular.module("cursoAngularApp").controller("LoginCtrl",["$scope","$location","LoginService",function(a,b,c){a.email="vedovelli@gmail.com",a.password="123456",a.login=function(){c.login(a.email,a.password,function(c){c?b.path("dashboard"):a.errorMessage="Falha no login"})}}]),angular.module("cursoAngularApp").service("LoginService",["$http","$location",function(a,b){var c=this;c.token=null,c.login=function(b,d,e){a.post("http://curso-angular-api.app/login",{email:b,password:d}).success(function(a){c.token=a.token,e(!0)}).error(function(){e(!1)})},c.logout=function(b){a.get("http://curso-angular-api.app/logout").success(function(){c.token=null,b(!0)})},c.thisIsProtected=function(a){return null===c.token?(b.path("login"),!1):void a(c.token)}}]);