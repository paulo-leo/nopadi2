<?php 
namespace Modules\Painel; 

use Nopadi\MVC\Module;
use Nopadi\Http\Route;
use Dompdf\Dompdf;

class Painel extends Module
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
		   'post:profile/upload'=>'updateAvatar',
		   'post:profile/update'=>'profileUpdate',
		   'post:profile/avatar'=>'updateAvatar',
		   'get:profile/avatar'=>'getAvatar',
		   'post:profile/password'=>'updatePassword',
		   'delete:profile/remove'=>'removeImage'
       );
	   
	   /*
	    Módulos
	   */
	   
	   $modules = array(
		   'get:settings/modules'=>'index',
		   'get:settings/modules/apps'=>'apps',
		   'post:settings/modules'=>'update',
		   'post:settings/modules/update'=>'updateJson'
       );
	   
	   $access = array(
		   'get:settings/sectors'=>'index'
       );
	   Route::controllers($access,'@Painel/Controllers/SectorController');
	   
       Route::controllers($modules,'@Painel/Controllers/ModulesController');
   
   
       Route::controllers($login,'@Painel/Controllers/LoginController');
	   Route::controllers($register,'@Painel/Controllers/RegisterController');
	   Route::controllers($password,'@Painel/Controllers/ForgotPasswordController');
	   
	   Route::controllers($login,'@Painel/Controllers/LoginController');

   
	   Route::controllers($profile,'@Painel/Controllers/ProfileController');
	   
	   Route::resources('users','@Painel/Controllers/UserController');
	   
	   Route::resources('settings','@Painel/Controllers/SettingController');
	   
	    Route::resources('notifications','@Painel/Controllers/NotificationController');
	   
	   Route::get('dashboard',function(){
		   return view('@Painel/Views/dashboard');
	   });
	   
	   Route::get('settings',function(){
		   return view('@Painel/Views/settings/index');
	   });
	   
	   Route::get('settings/theme',function(){
		   return view('@Painel/Views/settings/theme');
	   });
	   
	   Route::get('np-painel-pdf-export',function(){
		   
		   $dompdf = new Dompdf(["enable_remote"=>true]);
		   $file_name = 'np-view.pdf';
		   if(np_pdf_get('np_painel_view')){
			   $html = np_pdf_get('np_painel_view');
		   }else{
			   $html = np_pdf_get('np_painel_table');
			   $file_name = 'np-table.pdf';
		   }
		   
		   
	       $dompdf->loadHtml($html);
	       $dompdf->setPaper('A4', 'landscape');
	       $dompdf->render();
	       $dompdf->stream($file_name,["Attachment"=>false]);
		   
	   });
	   
	   /*Config*/
	   Route::get('settings/environment','@Painel/Controllers/SettingController@configEnvironment');
	   Route::post('settings/theme','@Painel/Controllers/SettingController@saveTheme');
	   Route::post('settings/environment','@Painel/Controllers/SettingController@saveEnvironment');
	   Route::post('settings/smtp','@Painel/Controllers/SettingController@saveSMTP');
	   Route::post('settings/key-api','@Painel/Controllers/SettingController@saveKeyAPI');

	   Route::get('settings/db',function(){
		   return view('@Painel/Views/settings/db');
	   });

	   Route::get('settings/smtp',function(){
         return view('@Painel/Views/settings/smtp');
	   });
	   Route::get('settings/key-api',function(){
         return view('@Painel/Views/settings/key-api');
	   });
	}
	
	public function disabled(){
		
	}
} 







