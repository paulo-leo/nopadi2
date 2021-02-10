<?php 
namespace Modules\Painel; 

use Nopadi\Http\Route;

class Painel
{
	public function main(){
		
        $login = array(
           'get:login'=>'showLoginForm',
		   'post:login'=>'login',
		   'get:logout'=>'logout'
       );
	   
	   $register = array(
	      'get:register'=>'showRegistrationForm',
		  'post:register'=>'register'
	   );

       $password = array(
		   'get:password/reset'=>'showLinkRequestForm',
		   'post:password/email'=>'sendResetLinkEmail',
           'get:password/reset/{token}'=>'showResetForm',
		   'post:password/reset'=>'reset'
       );
	   
	   $profile = array(
		   'get:profile'=>'index',
		   'post:profile'=>'update',
		   'post:profile/avatar'=>'updateAvatar',
		   'get:profile/avatar'=>'getAvatar',
		   'post:profile/password'=>'updatePassword'
       );
   
       Route::controllers($login,'@Painel/Controllers/LoginController');
	   Route::controllers($register,'@Painel/Controllers/RegisterController');
	   Route::controllers($password,'@Painel/Controllers/ForgotPasswordController');
	   
	   Route::controllers($login,'@Painel/Controllers/LoginController');

   
	   Route::controllers($profile,'@Painel/Controllers/ProfileController');
	   
	   Route::resources('users','@Painel/Controllers/UserController');
	   
	   Route::resources('settings','@Painel/Controllers/SettingController');
	   
	    Route::resources('notifications','@Painel/Controllers/NotificationController');
	   
	   Route::get('dashboard',function(){
		   view('@Painel/Views/dashboard');
	   });
	   
	   Route::get('settings',function(){
		   view('@Painel/Views/settings/index');
	   });

	}
} 
