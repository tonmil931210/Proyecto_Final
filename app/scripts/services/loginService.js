'use strict';

angular.module('bodegaUninorteApp')
.factory('loginService',  function($http ,$rootScope,$location,sessionService, $localStorage, $cookieStore, urlConstant){
	return {
		login: function(userData){										
			/*var authData = {token:'13216546879'};	
			if(userData.remember_me){
				$localStorage.auth = {
					token: authData.token,
					selected: userData.remember_me
				};						
			}else{
				$cookieStore.put('token', authData.token);						
			}
			sessionService.set('token', authData.token);
			$location.path('/dashboard');
			if (!$rootScope.$$phase){
			 	$rootScope.$apply();
			}*/
			//START LOANDIG ANIMATION

			$http({
				method: 'POST',
				url: urlConstant + 'login/',
				data: {email: userData.email, password: userData.password}
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION
			    console.log(response);
			    console.log(response.headers());			    
			    console.log(response.headers(['Authorization']));			    
			    console.log(response.headers(['Date']));			    
			    if(userData.remember_me){
					$localStorage.auth = {
						token: response.headers('Authorization'),
						selected: userData.remember_me
					};						
				}else{
					$cookieStore.put('token', response.headers('Authorization'));						
				}
				sessionService.set('token', response.headers('Authorization'));
				$location.path('/dashboard');
				if (!$rootScope.$$phase){
				 	$rootScope.$apply();
				}
			  }, function errorCallback(response) {

			  });	
										
		},		
		logout: function(){
			sessionService.destroy('token');			
			$localStorage.auth = {
		        token: null,
		        selected: null
		    };	    
		    $cookieStore.put('token', undefined);
			$location.path('/login');    
			/*$http({
				method: 'DELETE',
				url: urlConstant + 'logout/',
				headers:{
					'Authorization': sessionService.get('token')
				}
			}).then(function successCallback(response) {
			    //STOP LOANDING ANIMATION	
			    console.log(response);		
			    sessionService.destroy('token');			
				$localStorage.auth = {
			        token: null,
			        selected: null
			    };	    
			    $cookieStore.put('token', undefined);
				$location.path('/login');    
			  }, function errorCallback(response) {

			  });	*/
			
		},
		islogged:function(){			
			if(sessionService.get('token')){
			 	return true;
			}
			else{
				try{
        			return ($cookieStore.get('token') !== undefined || $localStorage.auth.token !== null) && ($cookieStore.get('token') !== 'null' || $localStorage.auth.token !== 'null') ;
				}catch(err){
					this.logout();
					return false;
				}				
			} 
			
		}
	};
});