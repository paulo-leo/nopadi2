<?php 
namespace Modules\CRM\Controllers; 

use Nopadi\Http\URI;
use Nopadi\Http\Auth;
use Nopadi\Http\Send;
use Nopadi\Http\Param;
use Nopadi\MVC\Controller;

class ContactController extends Controller
{
	
   /*Valida o token para alteração da senha*/
   public function index()
   {
       view("@CRM/Views/contacts/index");
   } 
  
  public function create()
   {
       view("@CRM/Views/contacts/create");
   } 
   
   public function show()
   {
       view("@CRM/Views/contacts/show");
   } 
} 





