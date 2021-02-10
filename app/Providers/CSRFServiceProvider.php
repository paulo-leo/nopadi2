<?php

namespace App\Providers;

use Nopadi\Support\ServiceProvider;
use Nopadi\Http\Auth;

class CSRFServiceProvider extends ServiceProvider{
	/*Inicia o serviço*/
	 public function boot(){ 

	  if(!is_api()){
		 
		$this->tokenCreate();
		 //Valida o token no metodo post
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$token = isset($_POST['_token']) ? $_POST['_token'] : null;
			$csrf_token = $_SESSION['np_csrf_token'];
			
			if($token == $csrf_token){
				   unset($_POST['_token']);
			}else ServiceProvider::status('token.invalid',text(':invalid_token_csrf'));
			
	    }
		  }
	 }
	 /*gera o token*/
	 private function tokenCreate(){

		 $token_name = 'np_csrf_token';
		 
		 if(Auth::check()){
			if(!isset($_SESSION[$token_name]))
				 $_SESSION[$token_name] = md5(date('Y-m-d-H').Auth::user()->id);
			
		   }else{
			   
			   if(!isset($_SESSION[$token_name]))
			     $_SESSION[$token_name] = md5(date('Y-m-d-H')); 
		    }
	 }
}
