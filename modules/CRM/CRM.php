<?php 
namespace Modules\CRM; 

use Nopadi\Http\Route;

class CRM
{
	public function main(){
		
        $crm = array(
           'crm'=>'index'
       );
	   
	    $business = array(
           'crm/business'=>'index',
		   'crm/business/create'=>'create'
       );
	   
	   $account = array(
           'crm/accounts'=>'index',
		   'crm/accounts/{id}'=>'show',
		   'crm/accounts/create'=>'create'
       );
	   
	   $product = array(
           'crm/products'=>'index',
		   'crm/products/create'=>'create'
       );
	 
	    Route::get('crm','@CRM/Controllers/CRMController@index');
	    Route::resources('crm/accounts','@CRM/Controllers/AccountController');
	    Route::resources('crm/contacts','@CRM/Controllers/ContactController');
		Route::resources('crm/business','@CRM/Controllers/BusinessController');
		Route::resources('crm/proposals','@CRM/Controllers/ProposalController');
		
		Route::controllers($product,'@CRM/Controllers/ProductController');

	}
} 
