<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;

class RegisterController extends Controller
{
	
   /*Exibe o formulário de login*/
   public function showRegistrationForm()
   {
	      if(NP_NEW_MEMBERS == 'on'){
			 return view("@Painel/Views/register",['logout'=>false]);  
		  }else{
			  return view("404"); 
		  }
	      
   }
   public function register()
   {
	  $request = new Request;
	  $msg = null;
	  $register = null;
	  
	  $name = $request->get('name');
	  $surname = $request->get('surname');
	  
	  $password = $request->get('password1');
	  $password2 = $request->get('password2');
	  $email = $request->getEmail('email');
	  $lang = $request->get('lang',NP_LANG);
	  $accept_terms = $request->get('accept_terms','off');  
	  $email_marketing = $request->get('email_marketing','off');
	  
	  if($password == $password2)
	  {
		  $name = $name.' '.$surname;
		  
		  $values = array('name' => $name,
						'lang' => $lang,
						'accept_terms'=>$accept_terms,
						'email' =>$email,
						'email_marketing'=>$email_marketing,
						'$accept_terms'=>$accept_terms,
						'password' =>$password);
	  
	     $register = Auth::create($values);
		 $msg = Auth::status();
		  
	  }else{
		 $msg = "passwords_do_not_match"; 
	  }  
	  
	  if($register){ hello('success'); }else{
		  hello(':'.$msg,'danger');
	  }
	  
   }
} 





