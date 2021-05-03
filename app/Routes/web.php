<?php

use Nopadi\Base\DB;
use Nopadi\Base\Filter;
use Nopadi\Http\Route;
use Nopadi\Http\Request;
use Nopadi\Http\Param;
use Nopadi\Support\Dates;
/******************************************************
 ******** Nopadi - Desenvolvimento web progressivo*****
 ******** Arquivo de rotas principal (web)*************
*******************************************************/

Route::get('*',function(){ return view('404'); });
Route::get('/',function(){ return view('welcome'); });


Route::get('teste',function(){
	/*
    $var = "status[{10}]|name={paulo}||screen>10||home:1|100|vendas!";
	$x = new Filter();
	return $x->setFilter($var);
	*/
	
	return '<div class="col m12 s12 center"><a href="#" class="btn btn-small" onclick="window.print();">Imprimir</a></div>'.np_pdf_get();

});


Route::get('fin/box',function(){
  
   $x = options_get('item');
   hello(options_string($x));
  

   
   
  
  //var_dump($x);
  
});






