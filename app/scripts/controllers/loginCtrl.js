'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
	.controller('LoginCtrl', function ($scope, loginService) {
		$scope.login = function(data){			
			loginService.login(data, $scope);
		};
  	});
