'use strict';

angular.module('bodegaUninorteApp')
.factory('eventService', function(){
	return {
		all: function (){
			return [{
		  	    	name: 'Feria Pop',
		  	    	date: '03/06/2016',
		  	    	orders: [{
		  	    		name:'Orden #1', 
		  	    		date:'01/06/2016',
		  	    		items:[{
		  	    			name:'Item 1',
		  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
		  	    			id: 201,
		  	    			quantity: 3,
		  	    			type:'no retornable'
		  	    		},{
		  	    			name:'Item 2',
		  	    			id: 201,
		  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
		  	    			quantity: 5,
		  	    			type:'no retornable'
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
		  	    			type:'no retornable'
		  	    		},{
		  	    			name:'Item 10',
		  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
		  	    			id: 203,
		  	    			quantity: 5,
		  	    			type:'no retornable'
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
		  	    			type:'no retornable'
		  	    		},{
		  	    			name:'Item 6',
		  	    			quantity: 5,
		  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
		  	    			id: 207,
		  	    			type:'no retornable'
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
		  	    			type:'no retornable'
		  	    		},{
		  	    			name:'Item 16',
		  	    			quantity: 5,
		  	    			id: 201,
		  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
		  	    			type:'no retornable'
		  	    		}],
		  	    		status:'pendiente'
		  	    		}]
		  	    	},{
			  	    	name: 'Feria Del Libro',
			  	    	date: '01/06/2016',
			  	    	orders: [{
			  	    		name:'Orden #1',
			  	    		date:'01/05/2016', 
			  	    		items:[{
			  	    			name:'Item 7',
			  	    			quantity: 3,
			  	    			id: 204,
			  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
			  	    			type:'no retornable'
			  	    		},{
			  	    			name:'Item 6',
			  	    			quantity: 5,
			  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
			  	    			id: 207,
			  	    			type:'no retornable'
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
			  	    			type:'no retornable'
			  	    		},{
			  	    			name:'Item 16',
			  	    			quantity: 5,
			  	    			id: 201,
			  	    			image: 'http://ftbwiki.org/images/d/db/Item_Enchanted_Golden_Apple.png',
			  	    			type:'no retornable'
			  	    		}],
			  	    		status:'pendiente'
			  	    	}]  	    		
		  	    	}];
		},
		byStatus: function(status) {
	    	var events = [];
	    	for(var event of this.all()){  	    			    		
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
		},
		new: function (event) {			
			//post event
		},
		edit: function (event){
			//put
		},
		delete: function (event){
			//delete
		}

	};
});