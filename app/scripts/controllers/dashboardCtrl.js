'use strict';

/**
 * @ngdoc function
 * @name bodegaUninorteApp.controller:DashboardCtrl
 * @description
 * # DashboardCtrl
 * Controller of the bodegaUninorteApp
 */
angular.module('bodegaUninorteApp')
  .controller('DashboardCtrl', function ($scope, eventService) {

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
  			}
  		};

      $scope.searchEvent = function(keyword){
        $scope.keyword = keyword;        
      };

      $scope.newEvent = function (event) {
        event.date = dateToString($scope.currentTime);        
        eventService.new(event);
        $scope.all.push(event);     
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
      }
      
      $scope.all = eventService.all();
      $scope.all.event1 = $scope.all[0].name;
      $scope.pending = eventService.byStatus('pendiente');
      $scope.rejected = eventService.byStatus('rechazada');
      $scope.delivered = eventService.byStatus('entregada'); 
      $scope.orderTypes = ["no retornable","retornable"];
      

      function editDate(eventIndex,days){
        var date = stringToDate($scope.all[eventIndex].date,"dd/mm/yyyy","/");
        date.setDate(date.getDate()+days);
        return date;
      }
      

      $scope.order = {
        event: $scope.all[0].name, 
        type: $scope.orderTypes[0],
        deliveredDate: editDate(0,-3), 
        returnDate: editDate(0,7)
      };

      $scope.items = [
        {
          id: 1,
          type:"no retornable",
          name:"item 1",
          quantity: 100,
          reorder: 20,
          minStock: 10
        },
        {
          id: 2,
          type:"no retornable",
          name:"item 2",
          quantity: 200,
          reorder: 20,
          minStock: 10
        },
        {
          id: 3,
          type:"no retornable",
          name:"item 3",
          quantity: 400,
          reorder: 20,
          minStock: 10
        },
        {
          id: 4,
          type:"no retornable",
          name:"item 4",
          quantity: 400,
          reorder: 20,
          minStock: 10
        },
        {
          id: 5,
          type:"retornable",
          name:"item 5",
          quantity: 600,
          reorder: 20,
          minStock: 10
        },
        {
          id: 6,
          type:"retornable",
          name:"item 6",
          quantity: 100,
          reorder: 20,
          minStock: 10
        },
        {
          id: 7,
          type:"retornable",
          name:"item 7",
          quantity: 800,
          reorder: 100,
          minStock: 10
        },
        {
          id: 8,
          type:"retornable",
          name:"item 8",
          quantity: 100,
          reorder: 20,
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

      $scope.itemSelection = [];

      $scope.itemsForm = $scope.getItemsByType("no retornable");

      $scope.changeItems = function(){        
        $scope.itemsForm = $scope.getItemsByType($scope.order.type);
        $scope.itemSelection = [];
      }

      $scope.changeEventOnOrder = function(){
        var index = getIndexByEventName($scope.order.event);
        $scope.order.deliveredDate = editDate(index,-3);
        $scope.order.returnDate = editDate(index,7);
      }

      $scope.toggleSelectionItem = function (item) {        
        var idx = $scope.isItem(item);
        // is currently selected
        if (idx > -1) {          
          $scope.itemSelection.splice(idx, 1);
        }
        // is newly selected
        else {          
          $scope.itemSelection.push(item);
        }        
      };

      $scope.isItem = function(item){
        for (var i = 0; i < $scope.itemSelection.length; i++) {
          if($scope.itemSelection[i].id === item.id){
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

      function getIndexByEventName(name){
        for (var i = 0; i < $scope.all.length; i++) {
          if($scope.all[i].name === name){
            return i;
          }
        }
        return -1;
      }

  });
