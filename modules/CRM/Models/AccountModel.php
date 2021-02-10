<?php
namespace Modules\CRM\Models;

use Nopadi\MVC\Model;

class AccountModel extends Model
    {
	  /*Prover o acesso estático ao modelo*/
	  protected $table = "crm_accounts";
	  
	  public static function model()
	  {
		return new AccountModel();
	  } 	
    }

