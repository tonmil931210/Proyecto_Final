'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:NavbarctrlCtrl
 * @description
 * # NavbarctrlCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
	.controller('navBarCtrl', function ($scope) {
		$scope.options = [
							'<a href="sass.html">Sass</a>',
							'<a href="sass3.html">Sass2</a>',
							'<a href="sass2.html">Sass3</a>'
							];

	});
