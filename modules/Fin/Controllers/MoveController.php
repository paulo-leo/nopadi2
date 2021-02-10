<?php 
namespace Modules\Fin\Controllers; 

use Nopadi\Http\URI;
use Nopadi\Http\Auth;
use Nopadi\Http\Send;
use Nopadi\Http\Param;
use Nopadi\MVC\Controller;

class MoveController extends Controller
{
	
   /*Valida o token para alteração da senha*/
   public function index()
   {
       view("@Fin/Views/moves/index");
   } 
  
  public function create()
   {
       view("@Fin/Views/moves/create");
   } 
} 





