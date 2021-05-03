<?php
/*
*Arquivo de funções do Nopadi
*Author: Paulo Leonardo Da Silva Cassimiro
*/

/*Componete SELECT2*/
function select2_search($url,$default=null,$args=null,$method='get')
{	
 $id = 'select2-'.str_url($url.$default);
 $id = str_ireplace('|','',$id);
 
 $url = url($url);
 $params = null;

 if(is_array($args))
 {
    foreach ($args as $key => $value) 
    {
    	$params .= ",{$key}:'{$value}'";
    }
 }

	 $default = explode('|',$default);
	 $name = $default[0];
	 
	 $res = explode(':',$name);
	 $name = isset($res[1]) ? $res[1] : $res[0];
	 $required = (isset($res[1]) && $res[0] == 'required') ? 'required' : null;

	 if(isset($default[1])){
	 	 $key =  $default[1];
	 	 $val = isset($default[2]) ? $default[2] : 'Padrão';
	     $default =  "<option value='{$key}'>{$val}</option>";
	 }else{
	 	 $default = null;
	 }
	

$select  = "<select {$required} id='{$id}' name='{$name}' class='browser-default'>{$default}</select>";
$select .= "<script type='text/javascript'>
            $(document).ready(function(){
            $('#{$id}').select2({
                ajax: {
                    url: '{$url}',
                    type: '{$method}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                    var query = {
                         search: params.term,
                         page: params.page{$params}
                         }
                      return query;
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
});
</script>";

return $select;

}


function hello_list_search($array){
	$array = id_value($array, 'name');
	$id = get('id');
	$search = get_search();

	if($id && !$search){
		$array = $array ? $array[$id] : 'no_value_found';
		hello($array);
	}elseif($search){
      if($array){ 
		 foreach($array as $key=>$val){ hello_list($key,$val,$id); }
	  }else{ hello('no_value_found'); }
    }else{ hello('no_value_found'); }
}

function hello_list($id,$name,$id_local=null){
		echo '<ul class="np-ul">';
		if($id == $id_local){
			echo'<li title="'.$name.'" class="np-btn-option np-border-bottom np-link np-hover-text-blue"  value="'.$id.'"><i class="material-icons np-text-green">done</i>'.$name.'</li>';
		}else{
			echo '<li title="'.$name.'" class="np-btn-option np-border-bottom np-link np-hover-text-blue" value="'.$id.'"><i class="material-icons np-text-gray">done</i>'.$name.'</li>';
		}
        echo '</ul>';
	}

function form_search_list($config){
    
	$title = isset($config['title']) ? $config['title'] : null;
	$url = isset($config['url']) ? $config['url'] : null;
	$name = isset($config['name']) ? $config['name'] : null;
	$id = isset($config['id']) ? $config['id'] : $name;
	$value = isset($config['value']) ? $config['value'] : null;
	
	$name_form = 'np-form-search-radio-';
	$content = $name_form.'content-'.$id;
	$form = $name_form.'form-'.$id;
	$input = $name_form.'input-'.$id;
	$input_for = $name_form.'input-for-'.$id;
	$input_search = $name_form.'text-'.$id;
	$modal = $name_form.'modal-'.$id;
	$progress =  $name_form.'progress-'.$id;
	$not_found = $name_form.'not_found-'.$id;

    $out = '<div class="input-field col m12 s12">
          <a href="#'.$modal.'" class="modal-trigger prefix"><i class="material-icons">search</i></a>
          <input type="text" id="'.$input.'">
          <label>'.$title.'</label>
		  <input value="'.$value.'" type="hidden" name="'.$name.'">
	      <span id="'.$not_found.'" class="np-text-red np-small">'.text(':no_value_found').'</span>
        </div>';

$out .= '<div class="modal" id="'.$modal.'">
	         <div class="modal-content">
                <div class="container">
				    <h6><i class="material-icons">search</i>'.$title.'</h6>
				    <input type="text" id="'.$input_search.'" placeholder="'.lang('search').'" class="np-input np-border np-round">
					  <div id="'.$progress.'" class="preloader-wrapper big active">
                       <div class="spinner-layer spinner-blue-only">
                       <div class="circle-clipper left">
                       <div class="circle"></div>
                      </div><div class="gap-patch">
                      <div class="circle"></div>
                      </div><div class="circle-clipper right">
                      <div class="circle"></div>
                     </div>
                      </div>
                      </div>
                 <div id="'.$content.'">
				 </div>
                 </div>
				 <div class="modal-footer">
                   <a href="#!" class="waves-light btn modal-close red">'.lang('close').'</a>
                  </div>
              </div>
          </div>
		  <script>
		  $(function(){
			  var inputText = $("#'.$input.'");
			  var input = $("#'.$input_search.'");
			  var content = $("#'.$content.'");
			  var progress = $("#'.$progress.'");
              progress.hide();

			  input.keypress(function(){
				  var input = $(this).val();
				  if(input.length >= 1){
					$.ajax({
						"url":"'.url($url).'",
						"type":"get",
						"data":{search:input,id:$("input[name='.$name.']").val()},
						beforeSend:function(){ progress.show(); },
						complete:function(){ progress.hide(); },
						success:function(data){ 
							if(data == "no_value_found"){
								var not = "<h6 class=\"np-text-red np-center np-animate-opacity\"><i class=\"material-icons\">info</i>'.text(':no_value_found').'</h6>";
								content.html(not);
							  }else{
								content.html(data);
								content.on("click",".np-btn-option",function(){
								   var title = $(this).attr("title");
								   var value = $(this).attr("value");
								   $("input[name='.$name.']").val(value);
								   inputText.val(title);
								   $("#'.$modal.'").hide();
								   npLoadRadioinput();
								});
							  } 
						}
					});  
				  }
			  });
			function npLoadRadioinput(){
				var not = $("#'.$not_found.'");
				not.hide();
				var id = $("input[name='.$name.']");
				var inp = id.val();
				inp = inp.trim();
				if(inp.length >= 1)
				{
						$.ajax({
						"url":"'.url($url).'",
						"type":"get",
						"data":{id:id.val()},
						success:function(data){
							 if(data == "no_value_found"){
                               not.show();
							   inputText.addClass("np-border-red");
							 }else{
                                inputText.val(data);
								not.hide();
								inputText.removeClass("np-border-red");
							 } 
						}
					}); 
				}
			}
			npLoadRadioinput();
		  });
		  </script>';
    return $out;
}


function form_switch($name=null,$value=0,$id=null){
	$value = trim($value);
	$value = $value == 'on' || $value == 1 ? 'on' : 'off';
	$checked = ($value == 'on') ? ' checked' : null;
	return '
	<!-- Switch -->
  <div class="switch">
    <label>
      <span class="red-text">'.lang('off').'</span>
      <input name="'.$name.'" type="checkbox"'.$checked.' id="'.$id.'">
      <span class="lever"></span>
      <span class="green-text">'.lang('on').'</span>
    </label>
  </div>
	';
}

function form_checkbox($name=null,$value=0,$id=null){
	return form_switch($name,$value,$id);
}

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

/*Função para abrir um formulário*/
function form_open($title=null,$url=null,$method='POST'){
	
	 $res = explode(':',$title);
	 $title = isset($res[1]) ? $res[1] : $res[0];
	 $reset = (isset($res[1]) && $res[0] == 'reset') ? '$("input").val("");' : null;
	
	  $title = text($title);
	  $url = url($url);
	  $form = '<script>
	   $(document).ready(function() { 
            var form = $("#np-form-open"); 
			form.submit(function(){ 
			var values = form.serialize();
			var loading = document.createElement("div");
            loading.innerHTML = "<div class=\"preloader-wrapper big active\"><div class=\"spinner-layer spinner-blue-only\"><div class=\"circle-clipper left\"><div class=\"circle\"></div></div><div class=\"gap-patch\"><div class=\"circle\"></div></div><div class=\"circle-clipper right\"><div class=\"circle\"></div></div></div></div>";
					$.ajax({
					url : "'.$url.'",
                    type :"'.$method.'",
                    data :values,
					dataType: "json",
                    beforeSend : function(){ 
                         
						  swal({
                            content: loading,
							title: "Salvando informações...",
                            button: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false
                            });

					},
					success : function(data){ 
                              var type = data.type;
							  var msg  = data.msg;
							  if(type == "success"){
								  swal("'.text(':success').'", msg, "success"); '.$reset.'
							  }else if(type == "error"){
								   swal("'.text(':error').'", msg, "error");
							  }else{
								 swal("'.text(':info').'", msg, "info") 
							  }
					}
				});
				return false;
			});
      });
	  </script>
	  <form id="np-form-open" action="'.url($url).'" method="'.$method.'" class="container row">
	  <h5>'.$title.'</h5>';
	  return $form;
}

/*Função para fechar um formulário*/
function form_close($title='save'){
	$btns = '<div style="margin-top:40px;margin-bottom:40px" class="col m12 s12"><button type="submit" class="waves-effect waves-light btn-small right gradient-45deg-green-teal"><i class="material-icons right">save</i>'.text(':'.$title).'</button>
	<a onclick="window.history.go(-1);" class="waves-effect waves-light btn-small left gradient-45deg-red-pink"><i class="material-icons left">arrow_back</i>Voltar</a>';
	return '<div id="np-form-msg"></div>'.$btns.'</div></form>';
}


/*Função para abrir um formulário*/
function form_modal($id='np-form-modal',$url=null,$method='POST'){
	  $url = url($url);
	  $form = '
	  <script>
	   $(document).ready(function() {
            var formModal = $("#'.$id.'"); 
			formModal.submit(function(){ 
			var values = formModal.serialize();
				$.ajax({
					 url : "'.$url.'",
                     type :"'.$method.'",
                     data :values,
                    beforeSend : function(){ $("#np-top-loading").show(); $("#np-main-menu-top").addClass("np-animate-fading"); },
					success : function(data){ $("#'.$id.'-msg").html(data); },
					complete : function(){ $("#np-top-loading").hide(); $("#np-main-menu-top").removeClass("np-animate-fading"); }
				});
				return false;
			});
      });
	  </script>
	  <form id="'.$id.'" action="'.$url.'" method="'.$method.'" class="np-row">
	  <div id="'.$id.'-msg"></div>';
	  return $form;
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
		
		$class = $required == 'required' ? 'input' : 'input';
		
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
	
	return '<div class="np-display-container np-card-2 np-col m12 np-padding np-margin-top np-animate-zoom np-white np-round-large">
	 <h5>Contatos</h5>
    <span class="np-display-topright np-button np-small np-padding-small np-round-large"><i class="material-icons">add</i></span>
	<table class="np-table np-striped">
	   <tr>
	      <td>ID</td><td>Nome</td>
	   </tr>
	    <tr>
	      <td><i class="material-icons np-hover-text-red">delete</i>01</td><td>Paulo Leonardo</td>
	   </tr>
	</table>
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
	
	$msg = lang($msg);
	
	if($type == 'success'){
		 $msg = (['msg'=>$msg,'type'=>'success']);
	}elseif($type == 'danger' || $type == 'error'){
		  $msg = (['msg'=>$msg,'type'=>'error']);
	}else{
		 $msg = (['msg'=>$msg,'type'=>'info']);
	}
	return json_encode($msg);
}
function view_header($title,$callback=null){
	$header = '<div class="center white" style="z-index:3;width:100%;position:fixed;left:0px;top:0px;padding:5px;min-height:50px">';
	$header .= '<h5>'.$title.'</h5>';
	
	if(is_array($callback)){
	foreach($callback as $item){
		$header .= $item;
	  }
	}else{
		$header .= $callback;
	}
	
  $header .= '</div><br>';
  return $header;
}

/*Cria um botão*/
function painel_btn($btn_name,$url=null)
{
	$btn_name = explode('|',$btn_name);
	$text = $btn_name[0];
	$class = isset($btn_name[1]) ? $btn_name[1] : 'btn';
	$target = isset($btn_name[2]) ? $btn_name[2] : '_self';
	$url = url($url);
	
	return "<a href='{$url}' class='{$class}' target='{$target}' title='{$text}'>{$text}</a>";
	
}

function painel_delete($url,$id=null,$class='btn white red-text')
{
	$url = url($url);
	$size = 'width:18px;height:18px;position:relative;top:5px;left:-5px;';
	$load = '<div id="np-item-view-page-load" class="preloader-wrapper active" style="'.$size.'">
    <div class="spinner-layer spinner-red-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>';
	$title = lang('delete');
	$title_load = 'Apagando...';
	$btn = "<a id='np-item-view-page' class='{$class}' title='{$title}'>{$title}</a>
	<a id='np-item-view-page-show' style='display:none' class='{$class}'>{$load}{$title_load}</a><div id='np-item-view-page-show-div'></div>";

$btn .= "<script>
	      $(function(){
		   var btnDelete = $('#np-item-view-page');
		   var div = $('#np-item-view-page-show-div');
		   btnDelete.click(function(){
			  $.ajax({
				  url:'{$url}',
				  data:{id:{$id}},
				  type:'DELETE',
				  dataType:'json',
				  beforeSend:function(){
					 $('#np-item-view-page').hide();
                     $('#np-item-view-page-show').show();					 
				  },
				  success:function(data){
					          $('.np-alert-msg-delete').show('fast'); 
					          $('#np-item-view-page').hide();
                              $('#np-item-view-page-show').hide();
					          var type = data.type;
							  var msg = data.msg;
							  if(type == 'success'){
								  $('.np-painel-item-'+{$id}).hide('fast');
								  $('.np-painel-del-'+{$id}).hide('fast');
								  div.html(\"<div class='card-alert card red'><div class='card-content white-text'><p>\"+msg+\"</p></div></div>\");
							  }else if(type == 'error'){
								  div.html(\"<div class='card-alert card orange'><div class='card-content white-text'><p>\"+msg+\"</p></div></div>\");
							  }else{
                                 div.html(\"<div class='card-alert card blue'><div class='card-content white-text'><p>\"+msg+\"</p></div></div>\");
					    }
				   }
			  });
		   });
	   });
	</script>";
   return $btn;
}

/*Executa ações do sistema ao clicar em um botão*/
function painel_click($btn_name,$url,$id,$class_hide=null)
{
	$btn_id = str_ireplace(['/','.'],'',$btn_name);
	$btn_id = str_url("np-painel-click-{$btn_id}-{$id}");
	$url = url($url);
	
	$btn_name = explode('|',$btn_name);
	
	$first_text = $btn_name[0];
	$last_text = isset($btn_name[1]) ? $btn_name[1] : $first_text;
	$first_class = isset($btn_name[2]) ? $btn_name[2] : null;
	$last_class = isset($btn_name[3]) ? $btn_name[3] : $first_class;
	
	return '
	<a href="#" class="'.trim($first_class.' '.$class_hide).'" id="'.$btn_id.'">'.$first_text.'</a>
	<script>
	     $(function(){
			 
			var btn = $("#'.$btn_id.'");
			btn.click(function(){

			var loading = document.createElement("div");
            loading.innerHTML = "<div class=\"preloader-wrapper big active\"><div class=\"spinner-layer spinner-blue-only\"><div class=\"circle-clipper left\"><div class=\"circle\"></div></div><div class=\"gap-patch\"><div class=\"circle\"></div></div><div class=\"circle-clipper right\"><div class=\"circle\"></div></div></div></div>";
					$.ajax({
					url : "'.$url.'",
                    type :"POST",
                    data :{id:'.$id.',_token:"'.csrf_token().'"},
					dataType: "json",
                    beforeSend : function(){ 
                         
						  swal({
                            content: loading,
							title: "Processando...",
                            button: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false
                            });

					},
					success : function(data){ 
                              var type = data.type;
							  var msg  = data.msg;
							  if(type == "success"){

								  swal("'.text(':success').'", msg, "success");
								  
							  }else if(type == "error"){
								   swal("'.text(':error').'", msg, "error");
							  }else{
								 swal("'.text(':info').'", msg, "info") 
							  }
					}
				});
				
                $(this).text("'.$last_text.'");
				$(this).removeClass("'.$first_class.'");
				$(this).addClass("'.$last_class.'");
				$("'.$class_hide.'").hide("fast");
			 });
		 });
	</script>';
}

function painel_view($values){
	$item = "<table class='striped col m12 s12'>";
	$item_pdf = $item;
	foreach($values as $name=>$value)
	{
		if(is_string($name) && $name == "@pdf"){
			 $item_pdf .= "<tr><td colspan='2'>{$value}</td></tr>";
		}elseif(!is_numeric($name)){
		$name = explode('|',$name);
		
		$icon = isset($name[1]) ? '<i class="material-icons" style="position:relative;top:5px">'.$name[1].'</i>' : null;
		$name = $name[0];
		$value = empty($value) && !is_numeric($value) ? '<span class="red-text">'.text(':'.'not_filled').'</span>' : $value;
		$item .= "<tr><td><b>{$icon}{$name}:</b></td><td class='left'>{$value}</td></tr>";
		$item_pdf .= "<tr><td><b>{$icon}{$name}:</b></td><td class='left'>{$value}</td></tr>";
		}else{
			$item .= "<tr><td colspan='2'>{$value}</td></tr>";
			$item_pdf .= "<tr><td colspan='2'>{$value}</td></tr>";
		}
	}
	
	np_pdf_del('np_painel_table');
	np_pdf_set('np_painel_view',"<table>{$item_pdf}</table>");
	$item .= "</table>";
	return $item;
}


function painel_header($title,$btns=null)
{
	$script = null;
	$btn_item = null;
	if(is_array($btns)){
		foreach($btns as $btn){
			$btn = explode('|',$btn);
			$url = url($btn[0]);
			if($btn[0] == '@pdf'){
				$script = '<script language=javascript type="text/javascript">
                            function newPopup(){
                            varWindow = window.open (
                            "'.url('np-painel-pdf-export').'",
                            "pagina",
                            "width=700, height=500, top=100, left=110, scrollbars=no,menubar=no, status=yes,location=no" );
							}
                             </script>';
			$btn_item .= "<li><a onclick='newPopup()'>PDF</a></li>";
			}else{
			  $text = isset($btn[1]) ? $btn[1] : $btn[0];
			  $icon = isset($btn[2]) ? "<i class='material-icons'>{$btn[2]}</i>" : null;
			  $btn_item .= "<li><a href='{$url}'>{$icon}{$text}</a></li>";
			}
		   }
	     }
	
	 $dropdown = !is_null($btn_item) ? '<a class="dropdown-trigger btn-small gradient-45deg-green-teal" data-coverTrigger="true" href="#" data-target="dropdown1">Editar</a>' : null;
	 
	
	return '<div class="" style="border-bottom:1px solid #bbb;padding-bottom:15px">
            <span style="font-size:30px;position:relative;top:5px">'.$title.'</span>
            <ul id="nav-mobile" class="right">
            '.$dropdown.'
           <!-- Dropdown Structure -->
           <ul id="dropdown1" class="dropdown-content">
           '.$btn_item.'
           </ul><a onclick="window.history.go(-1);" class="btn-small gradient-45deg-red-pink modal-trigger" href="#">Voltar</a></div>'.$script;
}
/*Loop de array*/
function painel_table($headers,$datas=null,$options=null,$replace=null){
	$tr = '<thead><tr>';
	$h = array();
	
	$action = (isset($options['edit']) || isset($options['view']) || isset($options['select'])) ? true : false;
	
	 if($action && isset($options['view']))
	 {
	      $tr .= '<th class="np-hide-element"><i class="material-icons">remove_red_eye</i></th>';
	 }
	$count_header = count($headers);
	foreach($headers as $header){
		$legend = explode('|',$header);
		$header = $legend[0];
		$h[] = $header;
	
		$legend = isset($legend[1]) ? $legend[1] : $legend[0];
		$legend = (substr($legend,0,1) == '!') ? substr($legend,1) : text(':'.$legend);
		
		$tr .= '<th>'.$legend.'</th>';
	}
	
	if($action && isset($options['edit']))
	 {
	      $tr .= '<th class="np-hide-element"><i class="material-icons">edit</i></th>';
	 }
	 
	 if($action && isset($options['delete']))
	 {
	      $tr .= '<th class="np-hide-element"><i class="material-icons">delete</i></th>';
	 }
	
	$tr .= '</tr></thead><tbody>';
    
    if(count($datas->results) > 0){
    foreach($datas->results as $data){
		$id = $data['id'];
		$class_item = 'np-painel-item-'.$id;
		$tr .= '<tr class="'.$class_item.'">';
       
	    if($action && isset($options['view'])){
	      $tr .= '<td class="np-hide-element"><a class="modal-trigger np-btn-view" title="'.text(':'.'to_view').'" id="'.$id.'" href="#modal1"><i class="material-icons">remove_red_eye</i></a></td>';
		}
		foreach($h as $row)
		{
			//href="'.get_uri(false).'/'.$id.'"
			if(isset($replace[$row])){

				$data[$row] = call_user_func($replace[$row], $data,$id);
				
			}
			
			$data[$row] = empty($data[$row]) && !is_numeric($data[$row]) ? '<span class="orange-text">'.text(':'.'not_filled').'</span>' : $data[$row];
			
			$tr .= "<td>{$data[$row]}</td>";
		}
		
		if($action && isset($options['edit'])){
	      $tr .= '<td class="np-hide-element"><a title="'.text(':'.'edit').'" href="'.get_uri(false).'/'.$id.'/edit"><i class="material-icons">edit</i></a></td>';
		}
		
		if($action && isset($options['delete'])){
	      $tr .= '<td class="np-hide-element"><a class="np-btn-delete-item" id="'.$id.'" title="'.text(':'.'delete').'" href="#"><i class="material-icons">delete</i></a></td>';
		}
		
		$tr .= '</tr>';
	}}else{
		$tr .= '<td colspan="'.$count_header.'"><h6 class="red-text">Não há registros para mostrar.</h6></td></tr>';
	}
	
      $tr .= '</tbody>';
	  $tr .= '
  <!-- Modal Structure -->
      <style>
	   @media (min-width: 993px){
		  .modal-fixed-footer { width: 75% !important; } 
	   }
	   @media (max-width: 600px){
		  .modal-fixed-footer { width: 100% !important; } 
	   }
	  </style>
      <div id="modal1" class="modal modal-fixed-footer">
         <div class="modal-content">
            <div id="np-table-view-more"></div>
         </div>
       <div class="modal-footer">
         <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">'.lang('close').'</a>
        </div>
  </div>';
	  /*Script JavaScript para deletar item*/
	 $tr .= '<script>
	 var loading = document.createElement("div");
            loading.innerHTML = "<div class=\"preloader-wrapper big center active\"><div class=\"spinner-layer spinner-blue-only\"><div class=\"circle-clipper left\"><div class=\"circle\"></div></div><div class=\"gap-patch\"><div class=\"circle\"></div></div><div class=\"circle-clipper right\"><div class=\"circle\"></div></div></div></div>";
	
	 $(function(){
		 
		$(".np-btn-view").click(function(){
			var view = $(this).attr("id");
			
			var url = "'.get_uri(false).'/"+view;
			
			$.ajax({
					url : url,
                    type :"GET",
					dataType: "html",
                    beforeSend : function(){ 
                        $("#np-table-view-more").html(loading);  
					},
					success : function(data){ 
                          $("#np-table-view-more").html(data); 
					}
				});
			
		});
		 
		 
        var btnDelete = $(".np-btn-delete-item");
		btnDelete.click(function(){
        var id = $(this).attr("id");
		
		 //Função para excluir
		 function deleteItem(id)
		 {
			
			 
			$.ajax({
					url : "'.get_uri(false).'",
                    type :"DELETE",
                    data :{id:id},
					dataType: "json",
                    beforeSend : function(){ 
                           //$(".np-progress").show();
						    swal({
                            content: loading,
							title: "Por favor, aguarde...",
                            button: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false
                            });
					},
					success : function(data){ 
                              var type = data.type;
							  var msg  = data.msg;
							  if(type == "success"){
								  swal("'.text(':success').'", msg, "success");
								  $(".np-painel-item-"+id).hide("fast");
							  }else if(type == "error"){
								   swal("'.text(':error').'", msg, "error");
							  }else{
								 swal("'.text(':info').'", msg, "info") 
							  }
					},
					complete : function(){ $(".np-progress").hide();  }
				});
		 }
       
		  swal({
          title: "Deseja Excluir?",
          icon: "warning",
          buttons: [
            "Cancelar",
            "Excluir"
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) {
          
		      deleteItem(id)
		  
          } else {
            swal("Cancelado com Sucesso", "", "success");
          }
        });
					   
			   });
		 });
	  </script>';
	  
	np_pdf_del('np_painel_view');
	np_pdf_set('np_painel_table',"<table class='striped'>{$tr}</table>");
	return $tr;
}


function paginate($datas){
	
	 if($datas->links)
	  {
	    return '<div class="col m12 s12 right">'.$datas->links.'</div>';
	  }
	  
}



