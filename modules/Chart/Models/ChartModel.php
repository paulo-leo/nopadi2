<?php
namespace Modules\Chart\Models;

use Nopadi\MVC\Model;

class ChartModel extends Model
    {
	  /*Prover o acesso estático ao modelo*/
	  public static function model()
	  {
		return new ChartModel();
	  } 	
    }

