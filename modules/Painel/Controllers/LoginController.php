<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;
use Nopadi\MVC\Form;

class LoginController extends Controller
{
	
   /*Exibe o formulário de login*/
   public function showLoginForm()
   {
	  if(!Auth::check())
	      view("@Painel/Views/login",['logout'=>false]); 
	  else to_url('painel');	
   }
   
   /*Faz o login do usuário*/
   public function login()
   {
        Auth::post();
	    echo Auth::status();
   }
   
   /*Desloga o usuário*/
   public function logout()
   {
     if(Auth::destroy())
	 view("@Painel/Views/login",['logout'=>true]); 
   }
   
   public function teste(){
	   
	   view("@Painel/Views/users/form");	   
	   
    }
} 





