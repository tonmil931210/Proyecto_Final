'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:inventary
 * @description
 * # inventary
 */
angular.module('bodegaUninorteApp')
  .directive('inventoryDirective', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/templates/inventory.tpl.html',
      controller: 'InventoryCtrl' 
    };
  });
