<?php 
namespace Modules\Painel\Controllers; 

use Nopadi\Http\Auth;
use Nopadi\Http\Param;
use Nopadi\Http\Request;
use Nopadi\MVC\Controller;
use Nopadi\FS\UploadImage;
use Modules\Painel\Models\UserModel;
use Modules\Painel\Controllers\UserController;

class ProfileController extends Controller
{
 
   /*Mostar o perfil do usuário*/
   public function index()
   {
     //Busca pelo usuário por meio do ID
	  $find = UserModel::model()->find(user_id());
	      
	  if($find){
		  
	   $langOptions = options($this->users()->langs(),$find->lang);
	   
       view('@Painel/Views/users/profile',[
	       'page_title'=>text(':user.edit'),
	       'find'=>$find,
		   'langOptions'=>$langOptions]);
	   
	   }else view('404');

   }
   
   public function updatePassword()
   {
	       $request = new Request();
	   
		   $pass = $request->get('password');
		   $pass1 = $request->get('password-1');
		   $pass2 = $request->get('password-2');

		   if(Auth::checkPassword($pass,user_id())){
			  if($pass1 == $pass2 && strlen($pass1) > 5){
			  if($pass1 != $pass){
			    if(Auth::passwordUpdateManual($pass1,user_id())) 
					hello(':password_update_success','success');
				else hello(':password_update_error','danger');
			  }else hello(':equal_password','danger');
			  
		     }else hello(':passwords_do_not_match','danger');
		  }else hello(':invalid_password','danger'); 
   }
   
   /*Salva uma imagem de perfil*/
   public function updateAvatar()
   {
   //id do usuário
	$id = user_id();

	$remove = new Request();
	$remove = $remove->get('remove-image');
	
	if(!$remove){
    //Opções de criação da imagem
	$options = array(
	    'folder'=>'uploads/avatar/',
		'name'=>'userfile',
		'new_name'=>$id,
		'height'=>150,
		'width'=>150);

	 $file = new  UploadImage($options);
	 $save = $file->save();
	 $message = ':'.$file->getMessage();

	 if($save){
		
		if(user_image())
			if(user_image($save) != user_image()) user_image_remove();

		 Auth::setSession('image',$save);
		 Auth::imageUpdate($save,$id);

		 hello(text(':change_profile_picture_success'),'success');

	 }else{
		 hello($message,'danger');
	 }
	}else{
		if(user_image_remove()){
			 Auth::setSession('image',null);
		     Auth::imageUpdate(null,$id);
			 hello(text(':remove_profile_picture_success'),'success');
			
		} else hello(':remove_profile_picture_error','danger');
	}
   
   }

   /*Cria uma instancia da classe de usuários*/
   public function users()
   {
	   return new UserController;
   }
   
   /*Retorna a imagem de avatar*/
   public function getAvatar(){
	   $id = user_id();
	   $img =  Auth::find($id,'image');
	   return strlen($img) > 15 ?  user_image($img) : user_image('img/default-avatar.png');
   }
} 
