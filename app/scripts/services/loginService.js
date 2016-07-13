'use strict';

angular.module('bodegaUninorteApp')
.factory('loginService',  function($rootScope,$location,sessionService, $localStorage, $cookieStore){
	return {
		login: function(userData){							
			var authData = {token:'13216546879'};
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
			}							
		},		
		logout: function(){
			sessionService.destroy('token');			
			$localStorage.auth = {
		        token: null,
		        selected: null
		    };	    
		    $cookieStore.put('token', undefined);
			$location.path('/login');
		},
		islogged:function(){			
			if(sessionService.get('token')){
			 	return true;
			}
			else{
				try{
        			return $cookieStore.get('token') !== undefined || $localStorage.auth.token !== null;
				}catch(err){
					this.logout();
					return false;
				}				
			} 
			
		}
	};
});