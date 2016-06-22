'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:dashboardDirective
 * @description
 * # dashboardDirective
 */
angular.module('bodegaUninorteApp')
  .directive('dashboardDirective', function () {
    return {
		templateUrl: 'views/templates/dashboard.tpl.html'		
	};
  });
