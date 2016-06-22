'use strict';

/**
 * @ngdoc directive
 * @name bodegaUninorteApp.directive:loginDirective
 * @description
 * # loginDirective
 */
angular.module('bodegaUninorteApp')
	.directive('loginDirective', function(){	
		return {
			templateUrl: 'views/templates/login.tpl.html'		
		};
	}); 
