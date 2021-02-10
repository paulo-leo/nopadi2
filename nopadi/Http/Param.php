<?php
/*
*Classe para paramenização da rota
*Autor:Paulo Leonardo da Silva Cassimiro
*/
namespace  Nopadi\Http;

use Nopadi\Http\URI;

class Param
{
    private static $param;
	
	/*Registra um parâmetro de rota*/
	public static function set($param){
		
		$er1 = '{([A-Za-zÀ-ú0-9\.\-\_]+)}';
		$size = explode('/',$param);
		
		$param = preg_replace("/{$er1}/simU", '{string}', $param);
		
		self::$param[$param] = array('size'=>count($size),'index'=>$size);
	}
	
	/*Obtem o valor do parametro de acordo com a chave*/
	public static function get($ind=null){
		$base = new URI();
		$uri = explode('?',$base->uri());
        $uri = $uri[0];
		 
		$value = null;
		foreach (self::$param as $key => $val){
			
			$er1 = '([A-Za-zÀ-ú0-9\.\-\_]+)';
		    $key = str_ireplace(['/','{string}'],['\/',$er1],$key);
			
			if(preg_match("/^{$key}$/i", $uri)){
				$search = array_search('{'.$ind.'}',$val['index']);
				if($search) $value = self::value($search);
			}
		}	
		return htmlspecialchars(trim($value), ENT_QUOTES);
	}
	
	/*Obtem o valor inteiro do parametro de acordo com a chave*/
	public static function int($key){
		$key = self::get($key);
		if(is_numeric($key)) return intval($key);
	}
	
	/*Obtem o valor flutuante do parametro de acordo com a chave*/
	public static function float($key){
		$key = self::get($key);
		if(is_numeric($key)) return floatval($key);
	}
	
	/*Verfica se o parametro corresponde ao valor informado*/
	public static function is($key,$value)
	{
		$key = self::get($key);
		if($key == $value) 
			return true;
		else return false;
	}
	
	/*Obtem o valor da rota*/
	private static function value($index)
    {
		$resource = new URI();
		$resource = explode('?',$resource->uri());
		$resource = $resource[0];
		
        $resource = explode('/', $resource);
        $value = $resource[$index];
        return trim(htmlspecialchars($value, ENT_QUOTES));
    }
	
	public static function first()
    {
		$resource = new URI();
		$base = $resource->base();
		$uri = explode('?',$resource->uri());
		$uri = $uri[0];
		$uri = str_ireplace($base,'',$uri);
		$uri = explode('/', $uri);
		return trim(htmlspecialchars($uri[0], ENT_QUOTES));
    }
	
	public static function last()
    {
		$resource = new URI();
		$resource = explode('?',$resource->uri());
		$resource = $resource[0];
        $resource = explode('/', $resource);
		$size = count($resource);
        $value = $resource[$size - 1];
        return trim(htmlspecialchars($value, ENT_QUOTES));
    }
}
