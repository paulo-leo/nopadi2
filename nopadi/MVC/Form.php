<?php 
namespace Nopadi\MVC;

class Form
{
  /* Faz a abertura de uma tag de formulário HTML com o estilo do Bootstrap */
  public function open($route='',$method='POST',$title=null)
  {
	   return '<form action="'.url($route).'" method="'.$method.'">
	    <div>
	   <div class="w3-left"><h3>'.$title.'</h3></div>
	   <div class="btn-group w3-right">
	      <button type="button" class="btn btn-outline-danger btn-sm">'.text(':cancel').'</button>
	      <button type="submit" class="btn btn-outline-success btn-sm">'.text(':save').'</button>
	   </div></div>';
  } 
  
  /* Faz a abertura de uma tag de formulário HTML com o estilo do Bootstrap */
  public function close()
  {
	   return '</form>';
  } 
   
 
   
  /* Cria um campo do tipo input text */
  public function input($params,$required=false)
  {
	  
	    //tipo
		$type = isset($params['type']) ? $params['type'] : 'text';
		$value = isset($params['value']) ? $params['value'] : null;
	    //pleceholder
		$placeholder = isset($params['placeholder']) ? $params['placeholder'] : null;
		//required
		$required = $required ? 'required' : null;

	   return '<input type="'.$type.'" class="form-control" value="'.$value.'" placeholder="'.$placeholder.'" '.$required.'>';
  } 
} 