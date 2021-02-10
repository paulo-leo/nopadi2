<?php 
namespace Modules\CRM\Controllers; 

use Nopadi\Http\Send;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;
use Modules\CRM\Models\AccountModel;

class AccountController extends Controller
{
	
   /*Valida o token para alteração da senha*/
   public function index()
   {
	    $list = AccountModel::model()
	      ->orderBy('id desc')
	      ->paginate(12,true); 
       view("@CRM/Views/accounts/index",['list'=>$list]);
   } 
   
   public function show()
   {
	     $id = Param::int('id');
	     $record = AccountModel::model()->find($id); 
		 if($record){
			view("@CRM/Views/accounts/show",['record'=>$record]); 
		 }else{
			view("@Painel/Views/404");
		 }
   } 
  
  public function create()
   {    //options($array = null, $check = null)
   
	   
	   $params = array(
	     'propspection'=>$this->propspection()
	   );
	   
       view("@CRM/Views/accounts/create",$params);
   }
   
   public function store()
   {
	   
	   $model = AccountModel::model();  
	   $request = new Request; 
	   $request->set('created_in',NP_DATETIME);
	   
       $name = $request->get('name');
	   $code = $request->get('code');
	   
	   
	   
	     $check = null;
	    if(strlen($name) < 2) $check .= "<p class='np-text-red'>*O nome da empresa não pode ser vazio.</p>";
		if(strlen($code) >= 1 && $model->find('code',$code)) $check .= "<p class='np-text-red'>*Já existe uma empresa usando este CNPJ/Código.</p>";
	    if($model->find('name',$name)) $check .= "<p class='np-text-red'>*Já existe uma empresa com este nome.</p>";
		
		if(!$check){
			
			if($model->insert($request->all())) hello(alert('Empresa cadastrada com sucesso','success'));
			else hello(alert('Não foi possível cadastrar a empresa','danger'));

		}else{
			hello(alert($check,'danger'));
		}
		  
	
   }

  public function propspection($name=null)
  {
	    $roles = [
		'whatsapp'=>'Whatsapp',
		'linkedin'=>'Linkedin',
		'gooqle'=>'Gooqle'
	  ];
		
		$roles = array_text($roles);
		
		return  is_null($name) ? $roles : $roles[$name];
  }
   
} 





