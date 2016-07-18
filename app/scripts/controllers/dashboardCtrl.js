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



      $scope.editEventName = "";
      $scope.editEventDate = "";

      $scope.editEvent = function (event) {
        var editEventVar = event;
        $scope.editEventVar = editEventVar;
        $scope.editEventVar.date = "";
        $('#editEventModal').openModal(); 
        console.log(editEventVar);
      }

      $scope.all = eventService.all();
      $scope.pending = eventService.byStatus('pendiente');
      $scope.rejected = eventService.byStatus('rechazada');
      $scope.delivered = eventService.byStatus('entregada');

      function dateToString(date) {        
        return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();        
      }
  });
