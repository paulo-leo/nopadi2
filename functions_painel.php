<?php
/*
*Arquivo de funções do Nopadi
*Author: Paulo Leonardo Da Silva Cassimiro
*/
/*
Funções que acionar um evento
*/
function modal_open_click($id='np-modal-01',$type=true){
	$id = 'np-modal-'.$id;
	$type = $type ? 'block' : 'none';
	return 'onclick="document.getElementById(\''.$id.'\').style.display=\''.$type.'\'"';
}

function btn_delete($id,$content=null){
	$npId = 'np-modal-delete-'.$id;
    return '<a type="button" class="np-link np-hover-text-red" onclick="document.getElementById(\''.$npId.'\').style.display=\'block\'"><i class="material-icons">delete</i></a>

<!-- The Modal -->
<div id="'.$npId.'" class="np-modal">
  <div class="np-modal-content np-round np-animate-top" style="max-width:510px">
    <div class="np-container">
      <span onclick="document.getElementById(\''.$npId.'\').style.display=\'none\'"
      class="np-button np-hover-white np-hover-text-red np-display-topright np-round np-small np-padding-small">
	  <i class="material-icons">close</i></span>
	  <h3><i class="material-icons">delete</i>'.text(':delete').'</h3>
      <div class="np-padding np-delete-loading-'.$id.'">'.$content.'</div>
	  <span onclick="document.getElementById(\''.$npId.'\').style.display=\'none\'"
      class="np-button np-text-red">'.text(':cancel').'</span>
	 <span class="np-btn-delete np-button np-text-green" id="'.$id.'">'.text(':confirm').'</span>
    </div>
  </div>
</div> ';

}



function script_delete($route){
 return '<script>
$(function(){
  $(".np-btn-delete").click(function(){
     var id = $(this).attr("id"); 
     var msg = $(".np-delete-loading-"+id);
	 var item = $(".np-item-"+id);
	 
     $.ajax({
     url : "'.url($route).'",
     type : "delete",
     data : {id:id},
     beforeSend : function(){
       msg.html(\'<div class="np-center"><div class="np-progress np-white"><div class="np-indeterminate np-red"></div></div><h3 class="np-animate-fading np-text-red">'.text(':processing').'</h3></div>\');  
     },
	 success : function(data){
         if(data != "error"){
		    msg.html(data);
			item.hide("fast");
		 }else{
			 msg.html(data);
		 }
     }
    }); 
     return false;
  });
});
</script>';
}

function painel_header($title=null,$btn_edit=null,$options=null){
	
	$title = explode('|',$title);
	$icon = isset($title[1]) ? $title[1] : 'list';
	$title = $title[0];
	$btn_option_btn = null;
	$btn_option = null;
	$menu_div_options = null;
	if(is_array($options)){
		
		foreach($options as $key=>$val)
		{
			$btn_option_btn .= '<a style="text-alignx:left" href="'.$key.'" class="np-bar-item np-button np-left">'.text($val).'</a>';
		}
		
		$btn_option = '<a style="padding:3px" onclick="document.getElementById(\'np-painel-menu-options-itens\').style.display=\'block\'" class="np-item np-link np-hover-text-blue np-small np-right"><i class="material-icons">more_vert</i></a>';
		
		$menu_div_options = '<div class="np-sidebar np-bar-block np-card np-animate-right" style="display:none;width:300px;right:0;top:0;z-index:4" id="np-painel-menu-options-itens">
  <button onclick="document.getElementById(\'np-painel-menu-options-itens\').style.display=\'none\'" class="np-bar-item np-red np-button"><i class="material-icons">close</i>'.text(':close').'</button>'.$btn_option_btn.'</div>';
	}
	
	
	
	
	
	
	$btn_edit = $btn_edit ? '<a title="'.text(':edit').'" href="'.url($btn_edit).'" class="np-item np-link np-hover-text-blue np-small np-right" style="padding:3px"><i class="material-icons">edit</i></a>' : null;
	
	return '<div class="np-row">
      <div class="np-white np-padding np-col m12" style="position:relative;">
      <span class="np-item np-xlarge"><i class="material-icons">'.$icon.'</i>'.$title.'</span>'.$btn_option.'
	  <a title="'.text(':previous').'" onclick="window.history.go(-1);" class="np-item np-link np-hover-text-blue np-small np-right" style="padding:3px"><i class="material-icons">reply</i></a>
	 '.$btn_edit.'</div></div>'.$menu_div_options;
}

/*Função para abrir um formulário*/
function form_open($title=null,$url=null,$method='POST'){
	  $title = text($title);
	  $url = url($url);
	  $form = '<script>
	   $(document).ready(function() {
            var form = $("#np-form-open"); 
			form.submit(function(){ 
			var values = form.serialize();
				$.ajax({
					 url : "'.$url.'",
                     type :"'.$method.'",
                     data :values,
                    beforeSend : function(){ $("#np-top-loading").show(); $("#np-main-menu-top").addClass("np-animate-fading"); },
					success : function(data){ $("#np-form-msg").html(data); },
					complete : function(){ $("#np-top-loading").hide(); $("#np-main-menu-top").removeClass("np-animate-fading"); }
				});
				return false;
			});
      });
	  </script>
	  <form id="np-form-open" class="np-row" action="'.url($url).'" method="'.$method.'">
      <div class="np-white np-padding np-col m12" style="position:relative;">
      <span class="np-item np-xlarge">'.text($title).'</span>
      <a onclick="window.history.go(-1);" class="np-item np-button np-small np-border np-hover-red np-border-red np-right np-cancel-btn">'.text(':cancel').'</a>
	  <button type="submit" style="margin-right:3px" class="np-item np-button np-small np-hover-green np-border np-border-green np-right np-save-btn">'.text(':save').'</button>
      </div><div class="np-padding"><br><br><div id="np-form-msg"></div>';
	  return $form;
}
/*Função para fechar um formulário*/
function form_close(){
	return '</div></form>';
}

/*Função para abrir um formulário*/
function form_input($params=null,$required=false){
	    //tipo
		$type = isset($params['type']) ? $params['type'] : 'text';
		$label = isset($params['label']) ? text($params['label']) : null;
		$value = isset($params['value']) ? $params['value'] : null;
		$name = isset($params['name']) ? $params['name'] : null;
		$options = isset($params['options']) ? $params['options'] : array();
	    //pleceholder
		$placeholder = isset($params['placeholder']) ? text($params['placeholder']) : null;
		//required
		$required = $required ? 'required' : null;
		
		$class = $required == 'required' ? 'np-input np-border-red' : 'np-input';
		
		if($type == 'select'){
			 $option = null;
			 foreach($options as $key=>$val)
			 {
				$option .= '<option value="'.$key.'">'.$val.'</option>';  
			 }
			 
			 return '<label>'.$label.'</label>
	   <select type="'.$type.'" class="'.$class.'" name="'.$name.'" '.$required.'>'.$option.'</select>';
		}else{
			 return '<label>'.$label.'</label>
	   <input type="'.$type.'" class="'.$class.'" value="'.$value.'" placeholder="'.$placeholder.'" name="'.$name.'" '.$required.'>';
		}

	   return '<label>'.$label.'</label>
	   <input type="'.$type.'" class="'.$class.'" value="'.$value.'" placeholder="'.$placeholder.'" name="'.$name.'" '.$required.'>';
}


/*Função para exibir modal de busca*/
function form_search($param=null){
	
	 $label = isset($param['label']) ? $param['label'] : null;
	 $url = isset($param['url']) ? $param['url'] : null;
	 $url = url($url);
	 $name = isset($param['name']) ? $param['name'] : 'name';
	 $id = isset($param['id']) ? 'np-input-search-'.$param['id'] : 'np-input-search';
	 $id_input = $id.'-input';
	 $id_modal = $id.'-modal';
	 $id_input_search = $id.'-input-search';
	 $id_content = $id.'-content';

	 return '<label><i id="'.$id_modal.'-init" onclick="document.getElementById(\''.$id_modal.'\').style.display=\'block\'" class="material-icons np-link np-hover-text-blue">search</i>'.$label.'</label>
	        <input id="'.$id_input.'" class="np-input np-border-red" type="text" name="'.$name.'" required>  

<!-- The Modal -->
<div id="'.$id_modal.'" class="np-modal">
  <div class="np-modal-content np-animate-top" style="min-height:200px;max-width:600px">
    <div class="np-progress np-white np-progress-form-modal" style="display:none;height:8px;z-index:5;position:relative;top:0px">
         <div class="np-indeterminate np-blue"></div>
     </div>
    <div class="np-container np-padding">
      <span onclick="document.getElementById(\''.$id_modal.'\').style.display=\'none\'"
      class="np-button np-display-topright np-hover-red" style="padding:4px"><i class="material-icons">close</i></span>
      <h2 class="np-col m12"><i class="material-icons np-xxlarge">list</i>'.$label.'</h2>
	  <div class="np-cell-row">
           <div class="np-cell np-border" style="width:80%">
              <input class="np-input np-border-0" type="text" id="'.$id_input_search.'" placeholder="'.text(':search').'">
           </div>
		   <div id="'.$id_input_search.'-btn" class="np-link np-cell np-border np-center np-hover-blue" style="width:20%">
              <span style="position:relative;top:-18px;">
			  <i class="material-icons np-xlarge" style="position:relative;top:13px;">search</i>
			  </span>
           </div>
       </div>
	   <ul class="np-ul" id="'.$id_content.'"></ul>
	   <script>
	   $(document).ready(function() {
		   
		    var btn = $("#'.$id_input_search.'-btn");
			var content = $("#'.$id_content.'");
			
			function search(){
				var input = $("#'.$id_input_search.'").val();
				input = (input == "") ? "@f10" : input;
	
				$.ajax({
					 url : "'.$url.'",
                     type :"GET",
                     data :{"name":input},
                     beforeSend : function(){ $(".np-progress-form-modal").show(); },
					 success : function(data){ $("#'.$id_content.'").html(data); },
					 complete : function(){ $(".np-progress-form-modal").hide(); }
				});
			}
			
			btn.click(function(){
				search();
			});
			
			$("#'.$id_modal.'-init").click(function(){
				search();
			});
			
			content.on("click",".np-item",function(){
				var item = $(this).val();
				$("#'.$id_input.'").val(item);
				$("#'.$id_modal.'").css({"display":"none"});
			});
      });
	  </script>
    </div>
  </div>
</div>'; 
}

function menu_sidebar($config){
	
	$app = isset($config['app']) ? $config['app'] : null;
	$icon = isset($config['icon']) ? $config['icon'] : null;
	$route = isset($config['route']) ? $config['route'] : null;
	$title = isset($config['title']) ? $config['title'] : null;
	
	return '<a href="#" class="np-bar-item np-button np-padding"><i class="material-icons">supervisor_account</i>'.$title.'</a>';
}

/*Função de alerta de mensagens*/
function alert($msg,$type='info'){
	if($type == 'success'){
		 $title = text(':success');
		 $color = 'np-pale-green np-padding np-round-large';
		 $text_color = 'np-text-green';
		 $icon = 'done_all';
	}elseif($type == 'danger'){
		 $title = text(':error');
		 $icon = 'error_outline';
		 $color = 'np-pale-red np-padding np-round-large';
		 $text_color = 'np-text-red';
	}else{
		 $title = text(':info');
		 $color = 'np-pale-blue np-padding np-round-large';
		 $icon = 'info_outline';
		 $text_color = 'np-text-blue';
	}
	
	return '<div class="np-modal" style="display:block" id="np-painel-alert-modal">
	<div class="np-modal-content np-round-xxlarge'.$color.' np-display-container np-animate-top" style="max-width:550px">
  <span style="z-index:1" onclick="document.getElementById(\'np-painel-alert-modal\').style.display=\'none\'"
  class="np-button np-round-large np-large np-display-topright"><i class="material-icons">close</i></span>
  <div><h3><i class="material-icons '.$text_color.'">'.$icon.'</i>'.$title.'</h3><p>'.text($msg).'</p></div></div></div>';
}



