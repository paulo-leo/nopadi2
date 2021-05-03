<?php
/*
*
*Author: Paulo Leonardo da Silva Cassimiro
*
*/
namespace Nopadi\FS;

use Nopadi\Http\URI;

class ReadArray
{
  private $arr = array();
  private $filename;
  
  /*Ler o caminho do arquivo*/
  public function __construct($file){
	  
	  $uri = new URI();
	  $file = $uri->local($file);
	  $this->filename = $file;
	  
	  if(file_exists($file)){
		  
		 $file = require($file); 

	  if(is_array($file)){
		 
		 $this->arr = $file;
		 
	  }
	    }
  }
  
    /*Faz um include de arquivo*/
  public static function addFile($file){
	  
	  $uri = new URI();
	  $file = $uri->local($file);
	  
	  if(file_exists($file))
		        require($file); 
  }
  
  /*Retona todos os valores*/
  public function gets(){
	return $this->arr;  
  }
  
  /*Mescla um array ao array novo*/
  public function merge($array)
  { 
     if(is_array($array)){
		$this->arr = array_merge($this->arr, $array);
		return true;
	 }else return false;   
  }
  
  public function mergeFile($file){
	  $file = new ReadArray($file);
	  $this->merge($file->gets());
  }
  
  /*Adiciona um novo elemento ao nó de dados*/
  public function set($key,$val=null,$val2=null)
  {  
      if($val2){
		  $this->arr[$key][$val] = $val2; 
	  }else{
		  $this->arr[$key] = $val; 
	  }
  }
  
  /*Retorna um valor por meio da chave especifica*/
  public function get($key,$default=null){
	  
	  return isset($this->arr[$key]) ? $this->arr[$key] : $default;
	  
  }
  
  /*Salva o arquivo com as alterações*/
  public function save()
  {  
      $data = $this->arr;
	  $filename = $this->filename; 
	  $array = null;
	  foreach($data as $key=>$val){
		  
		  
		  if(is_string($val)){
			  $val = "'{$val}'";
		  }
		  
		  if(is_bool($val)){
			  $val = $val ? 'true' : 'false';
		  }
		  
		  $array .= "\n'{$key}'=>{$val},";
	  }
	  
	  $data =  "<?php\nreturn [".$array."];";
      $data = str_ireplace(',];','];',$data);  
	  return file_put_contents($filename,$data,FILE_TEXT); 
  }
}






