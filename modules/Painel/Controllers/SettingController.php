<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;


class SettingController extends Controller
{
 
   /*Mostar o perfil do usuário*/
   public function index()
   {
	  if(Auth::check(['admin'])){
		  view('@Painel/Views/settings/index',
		  ['page_title'=>'Configurações',
		  'status'=>$this->status()]);
	 }else view('@Painel/Views/401');
   }
   
   /*Retorna o status*/
   public function status(){
	   $status = array(
	   'test'=>'Em teste',
	   'dev'=>'Em desenvolvimento',
	   'deploy'=>'Em produção',
	   'maintenance'=>'Manutenção'
	   );
	   return $status;
   }
   
} 
