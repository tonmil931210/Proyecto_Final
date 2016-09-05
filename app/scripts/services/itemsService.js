'use strict';

angular.module('bodegaUninorteApp')
.factory('itemService', function($http, urlConstant, sessionService){
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
				url: urlConstant + 'items',
				headers: {
					Authorization: sessionService.get('token')
				},
				data: {
					name: itemData,
					item_type_id: 0,
					number: itemData.quantity,
					min_stock: itemData.minStock,
					price: itemData.price,
					recorder: itemData.reorder

				}
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    	console.log('todo salio bien');
				}, function errorCallback(response) {
					console.log('todo salio mal');
			  	});
		}
	};
});