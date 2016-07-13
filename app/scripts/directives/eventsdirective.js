'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:eventsDirective
 * @description
 * # eventsDirective
 */
angular.module('bodegaUninorteApp')
  .directive('eventsDirective', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/templates/events.tpl.html',
      controller: 'DashboardCtrl',
      scope: {
      	events: '='        
      }  
    };
  });
