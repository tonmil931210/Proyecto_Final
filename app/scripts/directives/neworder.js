'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:newOrder
 * @description
 * # newOrder
 */
angular.module('bodegaUninorteApp')
  .directive('newOrderDirective', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/templates/neworder.tpl.html',
      controller: 'DashboardCtrl' 
    };
  });
