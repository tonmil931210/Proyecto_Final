'use strict';

angular.module('bodegaUninorteApp')
.factory('itemService', function($http, urlConstant){
	return {
		all: function (){
			$http({
				method: 'GET',
				url: urlConstant + ''
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    
			  }, function errorCallback(response) {

			  });			
		},
		new: function (itemData) {
			$http({
				method: 'POST',
				url: urlConstant + '',
				data: {}
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    
				}, function errorCallback(response) {

			  	});
		}
	};
});