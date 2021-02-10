<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;
use Nopadi\MVC\Form;

class RegisterController extends Controller
{
	
   /*Exibe o formulário de login*/
   public function showRegistrationForm()
   {
	      view("@Painel/Views/register",['logout'=>false]); 
   }
} 





