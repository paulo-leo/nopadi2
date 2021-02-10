<?php

use Nopadi\Http\Route;
use Nopadi\Http\Param;
/******************************************************
 ******** Nopadi - Desenvolvimento web progressivo*****
 ******** Arquivo de rotas principal (web)*************
*******************************************************/

use Nopadi\Http\Auth;


Route::get('*',function(){ view('404'); });

Route::get('/',function(){ view('welcome'); });


Route::post('teste',function(){
    sleep(5);
	hello(alert('Seu formulário chegou!'));
	
});

Route::get('teste/{id}',function(){
    
	
	
	if(Param::get('id')){
		hello(Param::int('id'));
	}
});




