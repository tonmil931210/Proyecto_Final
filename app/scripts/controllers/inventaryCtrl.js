'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:InventaryCtrl
 * @description
 * # InventaryCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
    .controller('InventoryCtrl', function ($scope) {

    $(document).ready(function(){          
	    $('.modal-trigger').leanModal();
    }); 

    $(document).ready(function() {
      $('select').material_select();
    });

    $scope.itemTypes = ["no retornable","retornable"];
		
		$scope.all = [
        {
          id: 1,
          type:"no retornable",
          name:"item 1",
          quantity: 100,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 2,
          type:"no retornable",
          name:"item 2",
          quantity: 200,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 3,
          type:"no retornable",
          name:"item 3",
          quantity: 400,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 4,
          type:"no retornable",
          name:"item 4",
          quantity: 400,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 5,
          type:"retornable",
          name:"item 5",
          quantity: 600,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 6,
          type:"retornable",
          name:"item 6",
          quantity: 10,
          reorder: 20,
          price: 20,
          minStock: 10
        },
        {
          id: 7,
          type:"retornable",
          name:"item 7",
          quantity: 9,
          reorder: 100,
          price: 20,
          minStock: 10
        },
        {
          id: 8,
          type:"retornable",
          name:"item 8",
          quantity: 100,
          reorder: 20,
          price: 20,
          minStock: 10
        },
      ];

      $scope.itemsForReoder = getItemsForReoder();            
      $scope.itemsMinStock = getItemsMinStock();
      
      $scope.setItemsForReorder = function(){
      	$scope.itemsForReoder = getItemsForReoder();
      };

      $scope.setItemsMinStock = function(){
      	$scope.itemsMinStock = getItemsMinStock();
      };

      function getItemsForReoder(){
      	var items = [];
      	for(var item of $scope.all){
      		if(item.quantity < item.reorder && item.quantity >= item.minStock){
      			items.push(item);
      		}
      	}
      	return items;
      };


      function getItemsMinStock(){
      	var items = [];
      	for(var item of $scope.all){
      		if(item.quantity < item.minStock){
      			items.push(item);
      		}
      	}
      	return items;
      };

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
      	var id;
      	if($scope.all.length > 0){
      		id = $scope.all[$scope.all.length - 1].id + 1;
      	}else{
      		id = 1;
      	}
      	item.id = id;
      	$scope.all.push(angular.copy(item));
		    $scope.newItem = {type:$scope.itemTypes[0]};
		    $scope.itemsForReoder = getItemsForReoder();            
      	$scope.itemsMinStock = getItemsMinStock();  	
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

      	var index = findItemById(item);

      	$scope.all[index] = item; 

      	$scope.itemsForReoder = getItemsForReoder();            
      	$scope.itemsMinStock = getItemsMinStock();    	

      };

      $scope.discardChangesItem = function (item) {
      	
      };

      $scope.deleteItem = function(item){        
      	var index = findItemById(item);      	        
        $("#itemId").val(index);
        $('#deleteItemModal').openModal();     	
      };

      $scope.saveDeleteItem = function(){
        var index = parseInt($("#itemId").val());                
        $scope.all.splice(index, 1);                
        $scope.itemsForReoder = getItemsForReoder();            
        $scope.itemsMinStock = getItemsMinStock();        
      };

      function findItemById(item) {
      	for (var i = 0; i < $scope.all.length; i++) {
      		if($scope.all[i].id === item.id){
      			return i;
      		}
      	}
      	return -1;
      }


  });
