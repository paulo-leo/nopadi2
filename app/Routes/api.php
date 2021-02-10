<?php

use Nopadi\Http\Route;

/****************************************************************
 ******** Nopadi - Desenvolvimento web progressivo***************
 ********* Arquivo de rotas para API******************************
 *****************************************************************/

use Nopadi\Http\JWT;
use Nopadi\Http\Auth;
use Nopadi\Http\Request;
use Nopadi\Base\Schema;
use Nopadi\Http\URI;

Route::access();

Route::get('my-frame',function(){
	
	if(isset($_GET['msg'])){
		echo $_GET['msg'];
	}
	
	echo '<form>
	       <input type="text" name="msg" />
		   <input type="submit">
	     </form>';
		 
	
});


Route::get('frame',function(){
	
	echo '<iframe frameborder="0" src="'.url('my-frame').'"></iframe>';
	
});