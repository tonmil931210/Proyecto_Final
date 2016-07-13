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
      }

      $scope.all = eventService.all();
      $scope.pending = eventService.byStatus('pendiente');
      $scope.rejected = eventService.byStatus('rechazada');
      $scope.delivered = eventService.byStatus('entregada');
  });
