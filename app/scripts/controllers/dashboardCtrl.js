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

      $(document).ready(function(){          
        $('.modal-trigger').leanModal();
      });     

      function collapseExpandHeader(index){
        if($("#collapsible-header-"+index).hasClass('active')){
          $("#collapsible-header-"+index).removeClass(function(){
            return "active";
          });           
        }else{
          $("#collapsible-header-"+index).addClass("active"); 
        }        
      }  

      $scope.all = [{
        name: 'Feria Pop',
        date: '03/06/2016',
        orders: [{
          name:'Orden #1', 
          date:'01/06/2016',
          items:[{
            id: 1,
            type:"no retornable",
            name:"item 1",                        
            quantityByOrder: 3
          },{
            id: 2,
            type:"no retornable",
            name:"item 2",                        
            quantityByOrder: 100
          }],
          status: 'entregada'
        },{
          name:'Orden #2', 
          date:'01/06/2016',
          items:[{
            id: 2,
            type:"no retornable",
            name:"item 2",                        
            quantityByOrder: 5
          },{
            id: 3,
            type:"no retornable",
            name:"item 3",                        
            quantityByOrder: 10
          }],
          status:'pendiente'
        },{
          name:'Orden #1',
          date:'01/06/2016', 
          items:[{
            id: 1,
            type:"no retornable",
            name:"item 1",                        
            quantityByOrder: 10
          },{
            id: 4,
            type:"no retornable",
            name:"item 4",                        
            quantityByOrder: 5
          }],
          status: 'rechazada'        
          }]
        },{
          name: 'Feria Del Libro',
          date: '01/06/2016',
          orders: [{
            name:'Orden #1',
            date:'01/05/2016', 
            items:[{
              id: 1,
              type:"no retornable",
              name:"item 1",                        
              quantityByOrder: 10
            },{
              id: 4,
              type:"no retornable",
              name:"item 4",                        
              quantityByOrder: 5
            }],
            status: 'rechazada'
          },{
            name:'Orden #2', 
            date:'01/06/2016',
            items:[{
              id: 1,
              type:"no retornable",
              name:"item 1",                        
              quantityByOrder: 3
            },{
              id: 2,
              type:"no retornable",
              name:"item 2",                        
              quantityByOrder: 100
            }],
            status:'pendiente'
          }]            
        }];
      $scope.pending = getEventByStatus('pendiente');
      $scope.rejected = getEventByStatus('rechazada');
      $scope.delivered = getEventByStatus('entregada'); 
      $scope.approved = getEventByStatus('aprobado'); 

     function getEventByStatus(status,sw) {
        var events = [];
        for(var event of $scope.all){                     
          var orders = [];
          for(var order of event.orders){
            if(sw){
              console.log(order.status);
            }                       
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

      //Setup for datepicker

      var currentTime = new Date();
      var event = {date:currentTime, name:'', orders:[]};
      $scope.event = event;
      $scope.currentTime = currentTime;      
      $scope.month = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Dicembre'];
      $scope.monthShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
      $scope.weekdaysFull = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
      $scope.weekdaysLetter = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'];
      $scope.disable = [false];
      $scope.today = 'Hoy';
      $scope.clear = 'Limpiar';
      $scope.close = 'Cerrar';
      var days = 15;
      $scope.minDate = (new Date($scope.currentTime.getTime() - ( 1000 * 60 * 60 *24 * days ))).toISOString();
      $scope.maxDate = (new Date($scope.currentTime.getTime() + ( 1000 * 60 * 60 *24 * days ))).toISOString();
      $scope.onStart = function () {
          //console.log('onStart');
      };
      $scope.onRender = function () {
          //console.log('onRender');
      };
      $scope.onOpen = function () {
          //console.log('onOpen');
      };
      $scope.onClose = function () {
          //console.log('onClose');
      };
      $scope.onSet = function () {
          //console.log('onSet');
      };
      $scope.onStop = function () {
          //console.log('onStop');
      };

  		$scope.setStyle = function(status){  			
  			switch(status){
  				case 'pendiente':  					
  					return {'color':'#f57f17'};  					
  				case 'aprobada':
  					return {'color':'#1b5e20'};  					
  				case 'rechazada':
  					return {'color':'#b71c1c'};  					
  				case 'entregada':
  					return {'color':'#0d47a1'};
          case 'aprobado':
            return {'color':'#2e7d32'};  					
  			}
  		};

      $scope.searchEvent = function(keyword){
        $scope.keyword = keyword;        
      };

      $scope.newEvent = function (event) {
        event.date = dateToString($scope.currentTime);                
        $scope.all.push(angular.copy(event)); 
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada');
        $scope.approved = getEventByStatus('aprobado'); 
        $scope.event = {};
      };      

      $scope.editEventVar = {name:"",date:"",index:-1};      
      $scope.editEvent = function (event, index) {
        $("#editName").val(event.name);
        $("#editDate").val(event.date);
        $("#editIndex").val(index);            
        collapseExpandHeader(index)             
        $('#editEventModal').openModal();                  
      }

      $scope.saveEditEvent = function () {         
        $scope.all[$("#editIndex").val()].name = $("#editName").val();
        $scope.all[$("#editIndex").val()].date = $("#editDate").val();
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada');
        $scope.approved = getEventByStatus('aprobado'); 
      }
      
      //$scope.all = eventService.all();      
      $scope.all.event1 = $scope.all[0].name;      
      $scope.orderTypes = ["no retornable","retornable"];
      

      function editDate(eventIndex,days){
        var date = stringToDate($scope.all[eventIndex].date,"dd/mm/yyyy","/");
        date.setDate(date.getDate()+days);
        return date;
      }

      function initNewOrder(){
        $scope.order = {
          event: $scope.all[0].name, 
          type: $scope.orderTypes[0],
          deliveredDate: editDate(0,-3), 
          returnDate: editDate(0,7),
          items: []
        };
        $scope.itemSelection = [];
        $scope.itemsForm = $scope.getItemsByType("no retornable");
      };
      
      $scope.items = [
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

      $scope.getItemsByType = function(type){
        var items = [];
        for (var item of $scope.items) {
          if(item.type === type){
            items.push(item);
          }
        }
        return items;
      }

      
      initNewOrder();

      $scope.changeItems = function(){        
        $scope.itemsForm = $scope.getItemsByType($scope.order.type);
        $scope.order.items = [];
      }

      $scope.changeEventOnOrder = function(){
        var index = getIndexByEventName($scope.order.event);
        $scope.order.deliveredDate = editDate(index,-3);
        $scope.order.returnDate = editDate(index,7);
      }

      $scope.addItemToOrder = function (item) {        
        var idx = $scope.isItem(item);
        // is currently selected
        if (idx > -1) {          
          $scope.order.items.splice(idx, 1);
        }
        // is newly selected
        else {          
          $scope.order.items.push(angular.copy(item));
        }        
      };

      $scope.newOrder = function(order){
        console.log(order);
        var index = getIndexByEventName(order.event);
        order.status = "pendiente";
        order.name = order.customer;
        $scope.all[index].orders.push(order);  
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada'); 
        $scope.approved = getEventByStatus('aprobado'); 

        initNewOrder();
      };
      $scope.apprOrder = {};
      $scope.approveOrder = function (order,event) {                    
        var eventIndex = getIndexByEventName(event.name);
        var orderIndex = getIndexByOrderName(order.name, eventIndex);
        $scope.apprOrder.name = orderIndex;
        $scope.apprOrder.event = eventIndex;
        $("#apprOrdername").val(orderIndex);
        $("#apprOrderevent").val(eventIndex);
        $('#approveOrderModal').openModal();          
      }

      $scope.saveApprovedOrder = function () {
        var eventIndex = $("#apprOrderevent").val();
        var orderIndex = $("#apprOrdername").val();
        $scope.all[eventIndex].orders[orderIndex].status = "aprobado";
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada'); 
        $scope.approved = getEventByStatus('aprobado');
      }

      $scope.deliOrder = {};
      $scope.deliverOrder = function (order,event) {                    
        var eventIndex = getIndexByEventName(event.name);
        var orderIndex = getIndexByOrderName(order.name, eventIndex);
        $scope.deliOrder.name = orderIndex;
        $scope.deliOrder.event = eventIndex;
        $("#deliOrdername").val(orderIndex);
        $("#deliOrderevent").val(eventIndex);
        $('#adeliverOrderModal').openModal();          
      }

      $scope.saveDeliverOrder = function () {
        var eventIndex = $("#deliOrderevent").val();
        var orderIndex = $("#deliOrdername").val();
        $scope.all[eventIndex].orders[orderIndex].status = "entregada";
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada'); 
        $scope.approved = getEventByStatus('aprobado');
      }

      $scope.rejecOrder = {};
      $scope.rejectedOrder = function (order,event) {                    
        var eventIndex = getIndexByEventName(event.name);
        var orderIndex = getIndexByOrderName(order.name, eventIndex);
        $scope.rejecOrder.name = orderIndex;
        $scope.rejecOrder.event = eventIndex;
        $("#rejecOrdername").val(orderIndex);
        $("#rejecOrderevent").val(eventIndex);
        $('#rejectedOrderModal').openModal();          
      }

      $scope.saveRejectedOrder = function () {
        var eventIndex = $("#rejecOrderevent").val();
        var orderIndex = $("#rejecOrdername").val();
        $scope.all[eventIndex].orders[orderIndex].status = "rechazada";
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada'); 
        $scope.approved = getEventByStatus('aprobado');
      }

      $scope.editOrderVar = {};
      $scope.editOrder = function (order,event) {                    
        var eventIndex = getIndexByEventName(event.name);
        var orderIndex = getIndexByOrderName(order.name, eventIndex);
        $scope.editOrderVar.name = orderIndex;
        $scope.editOrderVar.event = eventIndex;
        $scope.itemsForm = $scope.getItemsByType(order.type);        
        $('#item-2').attr('checked', true);
        $('#item-2').prop('checked', true);
        for(var item of order.items){
          $('#item-' + item.id)[0].checked = true   
        }
        console.log($scope.order.items);
        $scope.editOrderVar.items = order.items;        
        $scope.order.items = 
        $("#editOrdername").val(orderIndex);
        $("#editOrderevent").val(eventIndex);        
        $('#editOrderModal').openModal();          
      }

      $scope.saveEditOrder = function () {
        /*var eventIndex = $("#editOrdername").val();
        var orderIndex = $("#editOrdername").val();
        $scope.all[eventIndex].orders[orderIndex].status = "aprobado";
        $scope.pending = getEventByStatus('pendiente');
        $scope.rejected = getEventByStatus('rechazada');
        $scope.delivered = getEventByStatus('entregada'); 
        $scope.approved = getEventByStatus('aprobado');*/
        var values = getSelectItemsForEditOrder();
        console.log(values);
        console.log($scope.order.items);
      }

      function getSelectItemsForEditOrder() {
        var values = $('input:checkbox:checked.checkboxForItem').map(function () {
          return this.value;
        }).get();
        var valuesInt = [];
        for(var value  of values){
          valuesInt.push(parseInt(value));
        }
        return valuesInt;
      }

      $scope.isItem = function(item){
        for (var i = 0; i < $scope.order.items.length; i++) {
          if($scope.order.items[i].id === item.id){
            return i
          }          
        }
        return -1;
      };

      function dateToString(date) {        
        return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();        
      }

      function stringToDate(_date,_format,_delimiter){
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
            return formatedDate;
      }  

      function getItemById(id) {
        for (var i = 0; i < $scope.items.length; i++) {
          if($scope.items[i].id === id){
            return i;
          }
        }
        return -1;
      }

      function getIndexByEventName(name){
        for (var i = 0; i < $scope.all.length; i++) {
          if($scope.all[i].name === name){
            return i;
          }
        }
        return -1;
      }
      function getIndexByOrderName(name,eventIndex){
        for (var i = 0; i < $scope.all[eventIndex].orders.length; i++) {
          if($scope.all[eventIndex].orders[i].name === name){
            return i;
          }
        }
        return -1;
      }

  });
