'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:InventaryCtrl
 * @description
 * # InventaryCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
    .controller('InventoryCtrl', function ($scope, itemService) {

    $(document).ready(function(){          
	    $('.modal-trigger').leanModal();
    }); 

    $(document).ready(function() {
      $('select').material_select();
    });

    $scope.itemTypes = ["no retornable","retornable"];
		
		$scope.all = itemService.all();
    $scope.itemsForReoder = itemService.getItemsForReoder();
    $scope.itemsMinStock = itemService.getItemsMinStock();      

    $scope.searchItem = function(keyword){
  		return function(item){
  			if(keyword === undefined || keyword === ""){
  				return true;
  			}
  			return ((item.id == keyword || item.name.includes(keyword)));
  		}
    };

    $scope.newItem = {type:$scope.itemTypes[0]};

    $scope.saveItem = function(item){
      itemService.new(item);
	    //RECARGAR DATOS
      
    };

    $scope.editItemVar = {};      

    $scope.editItem = function(item){
    	$("#editItemVarId").val(item.id);
    	$("#editItemVarName").val(item.name);        	
      if(item.type === "retornable"){
        $("#editItemVarType select").val('2');     
      }else{
        $("#editItemVarType select").val('1');     
      }        
    	$("#editItemVarPrice").val(item.price);
    	$("#editItemVarQuantity").val(item.quantity);
    	$("#editItemVarReorder").val(item.reorder);
    	$("#editItemVarMinStock").val(item.minStock);
    	$('#editItemModal').openModal();
    };

    $scope.saveChangesItem = function(_item){      	      	      	
    	var item = {};
    	item.id = parseInt($("#editItemVarId").val());
    	item.name = $("#editItemVarName").val();                         
      var type =  parseInt($("#editItemVarType").val());        
      if(type === 2){
        item.type = "retornable";      
      }
      if(type === 1){
        item.type = "no retornable";
      }
    	item.price = parseInt($("#editItemVarPrice").val());
    	item.quantity = parseInt($("#editItemVarQuantity").val());
    	item.reorder = parseInt($("#editItemVarReorder").val());
    	item.minStock = parseInt($("#editItemVarMinStock").val());       	 	        

    	itemService.edit(item);  	
      //RECARGAR VALORES
    };

    $scope.discardChangesItem = function (item) {
    	
    };

    $scope.deleteItem = function(item){            	
      $("#itemId").val(item.id);
      $('#deleteItemModal').openModal();     	
    };

    $scope.saveDeleteItem = function(){
      var itemId = parseInt($("#itemId").val());                
      itemService.delete(itemId);       
    };   


  });
