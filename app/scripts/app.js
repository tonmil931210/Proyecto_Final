'use strict';

/**
 * @ngdoc overview
 * @name bodegaUninorteApp
 * @description
 * # bodegaUninorteApp
 *
 * Main module of the application.
 */
angular
  .module('bodegaUninorteApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.materialize',
    'ngStorage'
  ])
  .config(function ($routeProvider, loginServiceProvider) {
    $routeProvider
      .when('/login',{
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl',
        redirectTo: function(){
          if(loginServiceProvider.$get().islogged()){
            return '/dashboard';
          }
        }                     
      })
      .when('/dashboard', {
        templateUrl: 'views/dashboard.html',
        controller: 'DashboardCtrl',
        redirectTo: function(){
          if(!loginServiceProvider.$get().islogged()){
            return '/login';
          }
        }         
      })
      .when('/inventario', {
        templateUrl: 'views/inventory.html',
        controller: 'InventoryCtrl',
        redirectTo: function(){
          if(!loginServiceProvider.$get().islogged()){
            return '/login';
          }
        }         
      })
      .otherwise({
        redirectTo: '/login'
      });
  })
  .run(function(sessionService, $localStorage, $cookieStore){
    try{
        if($cookieStore.get('token') !== undefined){
            sessionService.set('token', $cookieStore.get('token'));
        }else{
          if($localStorage.auth.token !== null){
            sessionService.set('token', $localStorage.auth.token);
          }
        }        
      }catch(err){
        
      }
  });
