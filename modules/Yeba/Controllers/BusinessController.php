<?php 
namespace Modules\CRM\Controllers; 

use Nopadi\Http\URI;
use Nopadi\Http\Auth;
use Nopadi\Http\Send;
use Nopadi\Http\Param;
use Nopadi\MVC\Controller;

class BusinessController extends Controller
{
	
   /*Valida o token para alteração da senha*/
   public function index()
   {
       view("@CRM/Views/business/index");
   } 
  
  public function create()
   {
       view("@CRM/Views/business/create");
   } 
} 





