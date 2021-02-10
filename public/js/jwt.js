"use strict";
var jwt = {};

//Verfica se é JSON JWT com code  e token
jwt.is = function (str) {
   var isJson = (typeof str == 'object') ? true : false; 
   if(isJson){
	   isJson = str.hasOwnProperty('code') && str.hasOwnProperty('token') ? true : false;
   }
   return isJson;
}
//Salva os dados do JWT em localStorage recebidos do servidor
jwt.save = function (data) {
        if(jwt.is(data)){
			if(data.code == '201'){
				delete data['code'];
				delete data['message'];
				localStorage.clear();
				localStorage.setItem('nopadi_jwt_data',JSON.stringify(data));
				return true;
				
			}else return false;	
		}else return false;
};
//Salva os dados do JWT em localStorage recebidos do servidor
jwt.remove = function () {
		if(localStorage.getItem('nopadi_jwt_data')){
			localStorage.removeItem('nopadi_jwt_data');
			return true;
		}else return false;	
};

//Retorna todos os dados do JWT
jwt.gets = function (r=false) { 
	    var jwtData = localStorage.getItem('nopadi_jwt_data');
		jwtData = jwtData ? JSON.parse(jwtData) : false;
        var check = jwtData != false && jwtData.hasOwnProperty('token') ? true : false; 
		if(check){
			return jwtData;		
		}else return r = r ? {} : null;
};

jwt.all = jwt.gets(true);
jwt.token = jwt.gets(true).token;
jwt.datetime = jwt.gets(true).created_in;

//Retorna todos os dados, só que no formato json
jwt.json = function () { 
	   return JSON.stringify(jwt.gets(true));
};

//Verfica a existencia
jwt.check = function (search=false) { 
	 var role = null;
     if(search && (Array.isArray(search) || Number.isInteger(search))){
		//Checa por nome da função do usuário
		if(jwt.check()){
		if(Array.isArray(search)){
			role = (typeof jwt.all.role == 'string') ? jwt.all.role : false;
			if(role) return (search.indexOf(role) != -1) ? true : false;
			else return false;
		}else{
			role = (typeof jwt.all.role == 'number') ? jwt.all.role : false;
			if(role) return (search >= role) ? true : false;
			else return false;
		  }
	    }
	 }else{
		if(search){
			role = (typeof jwt.all.role == 'string') ? jwt.all.role : false;
			return (role == search) ? true : false;
		}else{
			return jwt.gets(false) ? true : false; 
		} 
	 } 
	
};

jwt.location = function(url,time=0){	
	if(time == 0){
		 window.location.href = url;
	}else{
		setTimeout(function() {
             window.location.href = url;
       }, time);
	}   
};

jwt.click = function(id,func) { 
  var el = document.querySelector(id);
  el.addEventListener("click",func,false); 
}; 
 
jwt.close = function(func) { 
  window.onbeforeunload = func;
};

jwt.open = function(func) { 
  window.onload = func;
};


