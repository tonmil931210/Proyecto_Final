'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:navbarDirective
 * @description
 * # navbarDirective
 */
angular.module('bodegaUninorteApp')
  .directive('navbarDirective', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/templates/nav-bar.tpl.html',
      controller: 'navBarCtrl'      
    };
  });
