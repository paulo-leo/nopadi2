<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;
use Modules\Painel\Models\UserModel;

class UserController extends Controller
{
   /*Exibe todos os usuários por meio da paginação*/
   public function index()
   {  

	 if(Auth::check(['admin'])){
	  $filter = new Request();
	  
	  $status = $filter->get('status');
	  $role = $filter->get('role');
	  
	  $list = UserModel::model()
	      ->orderBy('id desc')
	      ->paginate(12,true); 
	   

     view('@Painel/Views/users/index',[
	             'page_title'=>text(':users'),
	             'list'=>$list,
				 'rolesOptions'=>options($this->roles(),$role),
				 'statusOptions'=>options($this->status(),$status)
				 ]);	
	 }else view('401');
	
    }
	
    /*Retonar o tipo ou função do usuário*/
   public function roles($name=null)
   {
		$roles = [
		'subscriber'=>':subscriber',
		'client'=>':client',
		'affiliated'=>':affiliated',
		'partner'=>':partner',
		'franchise'=>':franchise',
		'collaborator'=>':collaborator',
		'author'=>':author',
		'editor'=>':editor',
		'dev'=>':dev',
		'admin'=>':admin',
		'demo'=>':demo'];
		
		$roles = array_text($roles);
		
		return  is_null($name) ? $roles : $roles[$name];

	}
	
   /*Retonar o estado do usuário*/
   public function status($name=null)
   {
		$status = [
		'pending'=>':pending',  /*Usuário foi criado, mas ainda não fez login*/
		'active'=>':active',    /*Usuário ativo, pois já realizou login*/
		'blocked'=>':blocked',  /*Usuário foi bloqueado por algum motivo*/
		'banned'=>':banned',    /*Usuário foi banido do sistema*/
		'disabled'=>':disabled' /*Usuário foi desativado*/
		];
		
		$status = array_text($status);
		
		return  is_null($name) ? $status : $status[$name];

	}
   
   /*Exibe o fomulário para editar o usuário*/
   public function edit()
   { 
	  if(Auth::check(['admin'])){
	  //Busca pelo usuário por meio do ID
	  $find = UserModel::model()->find($this->id());
	   
	  if($find){
		  
	   $roleOptions = options($this->roles(),$find->role);
	   $statusOptions = options($this->status(),$find->status);
	   $langOptions = options($this->langs(),$find->lang);
	   
       view('@Painel/Views/users/edit',[
	       'page_title'=>text(':user.edit'),
	       'find'=>$find,
		   'statusOptions'=>$statusOptions,
		   'langOptions'=>$langOptions,
		   'roleOptions'=>$roleOptions]);
	   
	  }else view('@Painel/Views/404');
	   }else view('@Painel/Views/404');
   }
   
	/*Exibe o fomulário para criar um usuário*/
    public function create()
	{
	if(Auth::check(['admin'])){
		
	  $roleOptions = $this->roles();
	  $langOptions = $this->langs();

       view('@Painel/Views/users/create',[
	   'page_title'=>text(':user.create'),
	   'langOptions'=>$langOptions,
	'roleOptions'=>$roleOptions]);
	}else view('dashboard/401');
	   
   }
   
   /*Cria um usuário*/
    public function store()
	{
	   $request = new Request();
	   $request = $request->all();
	   
	   $request = Auth::create($request);
       $response = Auth::status();
	   
	   if($request){
		   
	      hello(alert(':user_create_success','success')); 
		   
	   }else{
		   
		   hello(alert(':'.$response,'danger'));  
	   }  
   }
   
   /*Atuliza um usuário*/
   public function update()
   {
	   $request = new Request();
	   
	   $id = $request->get('id');
	   $values = $request->all('id');
	   
	   $query = UserModel::model()->update($values,$id);
	   
	   if($query) hello(alert(':user.update.success','success'));
	   else hello(alert(':user.update.error','danger'));
	   
   }
   
   /*Apagar um usuário*/
   public function destroy()
   {
	   $request = new Request();
	   
	   $id = $request->get('id'); hello('ok');

	   $query = (user_id() != $id) ? UserModel::model()->delete($id) : false;
	   
	   if($query) hello('ok');
	   else hello(':user.delete.error','danger'); 
   }

  /*Retonar o idioma do usuário*/
   public function langs($name=null)
   {
		$langs = [
		 'pt-br'=>'Portugês do Brasil',
		 'en'=>'Inglês'
		];
		
		return  is_null($name) ? $langs : $langs[$name];

	}
   
   /*Busca por um usuário*/
   public function search(){
	   $search = new Request;
	   $name = $search->get('name');
	   
	   if($name && $name != '@f10'){
            hello('<li><input class="np-item" type="radio" value="Paulo leonardo"> Paulo leonardo | pauloleonardo@gmail.com</li>');
		    hello('<li><input class="np-item" type="radio" value="Anderson Paz"> Anderson Paz | ande@gmail.com</li>');
	   }elseif($name == '@f10'){
		    hello('<li><input class="np-item" type="radio" value="Paulo leonardo"> Paulo leonardo | pauloleonardo@gmail.com</li>');
		    hello('<li><input class="np-item" type="radio" value="Anderson Paz"> Anderson Paz | ande@gmail.com</li>');
			hello('<li><input class="np-item" type="radio" value="Paulo leonardo"> Paulo leonardo | pauloleonardo@gmail.com</li>');
		    hello('<li><input class="np-item" type="radio" value="Anderson Paz"> Anderson Paz | ande@gmail.com</li>');
			hello('<li><input class="np-item" type="radio" value="Paulo leonardo"> Paulo leonardo | pauloleonardo@gmail.com</li>');
		    hello('<li><input class="np-item" type="radio" value="Anderson Paz"> Anderson Paz | ande@gmail.com</li>');
	   }else{
		   hello('Não foi encontrado nenhum usuário','danger');
	   } 
   }
} 





