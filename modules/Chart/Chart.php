<?php 
namespace Modules\Chart; 

use Nopadi\Http\Route;

class Chart
{
  public function main()
  {
    Route::resources('chart','@chart/Controllers/ChartController');
  }
}
