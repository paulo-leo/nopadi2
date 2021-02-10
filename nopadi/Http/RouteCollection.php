<?php
namespace Nopadi\Http;

use Nopadi\Http\Param;

class RouteCollection 
{
	//Armazena as rotas
	protected static $route_get = [];
	protected static $route_post = [];
	protected static $route_put = [];
	protected static $route_delete = [];
	
	/*Cria e armazena a rota*/
	protected static function add($type,$route,$args=null){
		
         Param::set($route);
		 
		 $er = '{([A-Za-zÀ-ú0-9\.\-\_]+)}';
		 $route = preg_replace("/{$er}/simU", '{string}', $route);
		 $route = str_ireplace('/','\/',$route);
		 $route = str_ireplace('{string}','([A-Za-zÀ-ú0-9\.\-\_]+)',$route);
		 
		 
		$args = array(
		'callback'=>$args['callback'],
		'namespace'=>$args['namespace'],
		'params'=>$args['params'],
		'middleware'=>$args['middleware']
		);
		
		switch($type){
			case 'POST' : self::$route_post[$route] = $args; break;
			case 'PUT' : self::$route_put[$route] =$args; break;
			case 'DELETE' : self::$route_delete[$route] = $args; break;
			default : self::$route_get[$route] = $args; break;
		}
	}
	//Obtem todas as rotas armazenadas
	public static function all($type){
		switch($type){
			case 'POST' : return self::$route_post; break;
			case 'PUT' :  return self::$route_put; break;
			case 'DELETE' :  return self::$route_delete; break;
			default :  return self::$route_get; break;
		}
	}
}