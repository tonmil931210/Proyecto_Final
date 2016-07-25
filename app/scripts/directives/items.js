'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:items
 * @description
 * # items
 */
angular.module('bodegaUninorteApp')
  .directive('itemsDirective', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/templates/items.tpl.html',
      controller: 'InventoryCtrl',
      scope: {
      	items: '='        
      }  
    };
  });
