'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:NavbarctrlCtrl
 * @description
 * # NavbarctrlCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
	.controller('navBarCtrl', function ($scope, $location, loginService) {		
		$scope.isActive = function(viewLocation) {
      		return viewLocation !== $location.path();
    	};
    	$scope.logout = function(){
    		loginService.logout();
    	}
	});
