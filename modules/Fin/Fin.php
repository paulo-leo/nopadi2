<?php 
namespace Modules\Fin; 

use Nopadi\Http\Route;

class Fin
{
	public function main(){
		
        $fin = array(
           'fin'=>'index'
       );
	   
	    $lead = array(
           'fin/leads'=>'index',
		   'fin/leads/create'=>'create'
       );
	   
	   $account = array(
           'fin/accounts'=>'index',
		   'fin/accounts/create'=>'create'
       );
	   
	   $product = array(
           'fin/products'=>'index',
		   'fin/products/create'=>'create'
       );
	 
	    Route::controllers($fin,'@fin/Controllers/finController');
		Route::resources('fin/moves','@fin/Controllers/MoveController');
	    Route::resources('fin/branches','@fin/Controllers/BrancheController');
	    Route::resources('fin/contas','@fin/Controllers/ContaController');

	}
} 
