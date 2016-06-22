'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:DashboardCtrl
 * @description
 * # DashboardCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
  .controller('DashboardCtrl', function ($scope) {

  		$scope.setStyle = function(status){  			
  			switch(status){
  				case 'pendiente':  					
  					return {'color':'#f57f17'}
  					break;
  				case 'aprobada':
  					return {'color':'#1b5e20'}
  					break;
  				case 'rechazada':
  					return {'color':'#b71c1c'}
  					break;
  				case 'entregada':
  					return {'color':'#0d47a1'}
  					break;  				
  			}
  		};

  	    $scope.events = [{
  	    	name: 'Feria Pop',
  	    	date: '01/06/2016',
  	    	orders: [{
  	    		name:'Orden #1', 
  	    		date:'01/06/2016',
  	    		items:[{
  	    			name:'Item 1',
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			id: 201,
  	    			quantity: 3,
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 2',
  	    			id: 201,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			quantity: 5,
  	    			type:'retornable'
  	    		}],
  	    		status: 'entregada'
  	    	},{
  	    		name:'Orden #2', 
  	    		date:'01/06/2016',
  	    		items:[{
  	    			name:'Item 4',
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			id: 202,
  	    			quantity: 3,
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 10',
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			id: 203,
  	    			quantity: 5,
  	    			type:'retornable'
  	    		}],
  	    		status:'pendiente'
  	    	},{
  	    		name:'Orden #1',
  	    		date:'01/06/2016', 
  	    		items:[{
  	    			name:'Item 7',
  	    			quantity: 3,
  	    			id: 204,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 6',
  	    			quantity: 5,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			id: 207,
  	    			type:'retornable'
  	    		}],
  	    		status: 'rechazada'
  	    	},{
  	    		name:'Orden #2', 
  	    		date:'01/06/2016',
  	    		items:[{
  	    			name:'Item 72',
  	    			quantity: 3,
  	    			id: 201,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 16',
  	    			quantity: 5,
  	    			id: 201,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		}],
  	    		status:'pendiente'
  	    	}]  	    		
  	    },
  	    {  	    	
  	    	name: 'Feria Del Libro',
  	    	date: '01/06/2016',
  	    	orders: [{
  	    		name:'Orden #1',
  	    		date:'01/06/2016', 
  	    		items:[{
  	    			name:'Item 7',
  	    			quantity: 3,
  	    			id: 204,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 6',
  	    			quantity: 5,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			id: 207,
  	    			type:'retornable'
  	    		}],
  	    		status: 'rechazada'
  	    	},{
  	    		name:'Orden #2', 
  	    		date:'01/06/2016',
  	    		items:[{
  	    			name:'Item 72',
  	    			quantity: 3,
  	    			id: 201,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		},{
  	    			name:'Item 16',
  	    			quantity: 5,
  	    			id: 201,
  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
  	    			type:'retornable'
  	    		}],
  	    		status:'pendiente'
  	    	}]  	    		
  	    }];

  	    $scope.selectedEvents = $scope.events;

  	    $scope.getAllEvents = function(){  	 
  	    	$scope.selectedEvents = [];
			$scope.selectedEvents = $scope.events;  	    	
  	    }

  	    $scope.getPendingEvents = function(){  	    	    		
  	    	$scope.selectedEvents = [];
			$scope.selectedEvents = getEventByStatus('pendiente');    	    	
  	    }

  	    $scope.getRejectedEvents = function(){  	    	    		
  	    	$scope.selectedEvents = [];
			$scope.selectedEvents = getEventByStatus('rechazada');    	    	
  	    }

  	    $scope.getDeliveredEvents = function(){  	    	    		
  	    	$scope.selectedEvents = [];
			$scope.selectedEvents = getEventByStatus('entregada');    	    	
  	    }

  	    function getEventByStatus(status){
  	    	var events = [];
  	    	for(var event of $scope.events){  	    			    		
  	    		var orders = [];
  	    		for(var order of event.orders){  	    			
  	    			if(order.status === status){
  	    				orders.push(order);
  	    			}
  	    		}
  	    		if(orders.length > 0){
  	    			events.push({
  	    				name: event.name,
  	    				date: event.date,
  	    				orders: orders
  	    			});
  	    		}
  	    	}
  	    	return events;
  	    }

  });
