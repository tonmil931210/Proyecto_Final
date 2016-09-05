'use strict';

angular.module('bodegaUninorteApp')
.factory('itemService', function($http, urlConstant, sessionService){
	return {
		all: function (){
			$http({
				method: 'GET',
				url: urlConstant + 'items'
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    return response.data.items;
			  }, function errorCallback(response) {
			  	return null;
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
					name: itemData.name,
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
		},
		get: function (itemId) {
			$http({
			 	method: 'GET',
			 	url: urlConstant + 'items/' + itemId,
			 	headers:{
			 		Authorization: sessionService.get('token')
			 	}
			 }).then(function successCallback(response) {
			 	return response.data.item;
			 }, function errorCallBack(response) {
		 	 	return null;
			 });
		},
		edit: function (itemData) {
			$http({
			 	method: 'PUT',
			 	url: urlConstant + 'items/' + itemData.id,
			 	headers:{
			 		Authorization: sessionService.get('token')
			 	},
			 	data: {
					name: itemData.name,
					item_type_id: 0,
					number: itemData.quantity,
					min_stock: itemData.minStock,
					price: itemData.price,
					recorder: itemData.reorder
				}
			 }).then(function successCallback(response) {
			 	console.log("item con id " + itemData.id + " editado exitosamente");
			 }, function errorCallBack(response) {
		 	 	console.log("item con id " + itemData.id + " NO FUE editado exitosamente");
			 });	 
		},
		delete: function (itemId) {
			 $http({
			 	method: 'DELETE',
			 	url: urlConstant + 'items/' + itemId,
			 	headers:{
			 		Authorization: sessionService.get('token')
			 	}
			 }).then(function successCallback(response) {
			 	console.log("item con id " + itemId + " borrado exitosamente");
			 }, function errorCallBack(response) {
		 	 	console.log("item con id " + itemId + " NO FUE borrado exitosamente");
			 });
		},
		getItemsForReorder: function () {
			$http({
				method: 'GET',
				url: urlConstant + 'items'
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    var items = response.data.items;
			    var itemsReorder = [];
			    for(var item of items){
			    	if(item.quantity < item.reorder && item.quantity >= item.minStock){
		      			itemsReorder.push(item);
		      		}
			    }
			    return itemsReorder;
			  }, function errorCallback(response) {
			  	return null;
			  });
		},
		getItemsMinStock: function () {
			 $http({
				method: 'GET',
				url: urlConstant + 'items'
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    var items = response.data.items;
			    var itemsMinStock = [];
			    for(var item of items){
			    	if(item.quantity < item.minStock){
		      			itemsMinStock.push(item);
		      		}
			    }
			    return itemsMinStock;
			  }, function errorCallback(response) {
			  	return null;
			  });
		}
	};
});