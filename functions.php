<?php
/*
*Arquivo de funções do Nopadi
*Author: Paulo Leonardo Da Silva Cassimiro
*/

use Nopadi\MVC\View;
use Nopadi\Http\Route;
use Nopadi\Http\URI;
use Nopadi\Http\Param;
use Nopadi\Http\Auth;
use Nopadi\FS\Json;
use Nopadi\Http\Request;
use Nopadi\Support\Translation;
use Nopadi\Base\DB;

$GLOBALS['np_instance_of_view'] = new View;
$GLOBALS['np_instance_of_uri'] = new URI;
$GLOBALS['np_instance_of_json'] = new Json('config/app/hello.json');
$GLOBALS['np_instance_of_request'] = new Request;
$GLOBALS['np_instance_of_translater'] = new Translation;

/*Função para concatenat texto para exportação em PDF*/

function np_pdf_start(){
	if(!isset($_SESSION)) session_start();
	if(!isset($_SESSION['np_pdf_export'])) $_SESSION['np_pdf_export'] = array();
}

function np_pdf_set($key,$value=null){
    np_pdf_start();
	if(!array_key_exists($key,$_SESSION['np_pdf_export'])){
		$_SESSION['np_pdf_export'][$key] = $value;
	}
}

function intdate($date=null)
{
   $date = is_null($date) ? date('Ymd') : $date;
   $date = str_ireplace(['-','/','.'],'',$date);
   return intval($date);
}

function np_pdf_get($key=null){
	np_pdf_start();
	$values = $_SESSION['np_pdf_export'];
	$keys = "<link rel='stylesheet' type='text/css' href='".asset('app/css/themes/vertical-menu-nav-dark-template/materialize.css')."'>
	<style>.np-hide-element{display:none !important;}</style>";
	
	if(is_null($key)){
		foreach($values as $value){
			$keys .= $value;
		}
		return $keys;
	}else{
		if(array_key_exists($key,$_SESSION['np_pdf_export'])){
		   $keys .= $_SESSION['np_pdf_export'][$key];
		   return $keys;
		}
	}
}

function np_pdf_del($key=null){
	np_pdf_start();
	if(is_null($key)){
		unset($_SESSION['np_pdf_export']);
	}else{
		if(array_key_exists($key,$_SESSION['np_pdf_export'])){
			unset($_SESSION['np_pdf_export'][$key]);
		}
	}
}

/**/
function errors(){
	if (!isset($_SESSION)) session_start();
	
	if(isset($_SESSION['np_errors'])){
		return $_SESSION['np_errors'];
	}
}

function errors_message(){
	if(errors()){
		$text = implode(' e ',errors());
		$text = strtolower($text);
		$text = str_ireplace('. ',' ',$text);
		$text = ucfirst($text);
		$text = $text.'.';
		$text = str_ireplace('..','.',$text);
		return $text;
	}
}

/*Formatção para moedas*/
function format_money_sup($float,$sim='R$',$span='teal-text',$sup='teal-text'){
	 $float = floatval($float);
	 return '<span class="'.$span.'">'.$sim.' '.number_format($float, 2, '<sup class="'.$sup.'">,', '.').'</sup></span>'; 
}

function format_money($float,$sim='R$',$sep=','){
	 return $sim.' '.number_format($float, 2, $sep, '.'); 
}

function theme($color=null,$colors=array()){
     if(in_array(NP_THEME,$colors)){
		return $color;
	 }else{
		return NP_THEME;
	 }
}

function theme_null($color=null,$colors=array()){
     if(in_array(NP_THEME,$colors)){
		return $color;
	 }
}

function route_first()
{
	return Param::first();
}

function db_table($tableName)
{
	return DB::table($tableName);
}


/*Chama uma rota do tipo GET*/
function route($route, $controller, $args = null)
{
	Route::get($route, $controller, $args);
}

/*Chama uma rota do tipo POST*/
function post_route($route, $controller, $args = null)
{
	Route::post($route, $controller, $args);
}

/*Chama uma rota do tipo PUT*/
function put_route($route, $controller, $args = null)
{
	Route::put($route, $controller, $args);
}

/*Chama uma rota do tipo DELETE*/
function delete_route($route, $controller, $args = null)
{
	Route::delete($route, $controller, $args);
}

/*Chama uma rota com todos os tipos de verbos*/
function any_route($route, $controller, $args = null)
{
	Route::any($route, $controller, $args);
}

/*Cria recuros de rota*/
function resources_route($route, $controller, $args = null)
{
	Route::resources($route, $controller, $args);
}

/*Retorna a instancia da classe Request. Com essa função não é necessário instanciar uma nova classe Request na aplicação*/
function get_instance()
{
	return $GLOBALS['np_instance_of_request'];
}

/*Função para retornar todos os índices de request. Se infomado uma chave, a função só retonará a chave informada no parametro*/
function request($key = null)
{
	return is_null($key) ? get_instance()->all() : get_instance()->get($key);
}

/*Extrai os ID's das linhas colocando em um novo array com ID e value. Essa função é geralmente usada nos retornos do banco de dados*/
function id_value($array, $val='name', $id = 'id')
{
	$x = array();
	if (count($array) > 0) {
		foreach ($array as $row) {
			$x[$row[$id]] = $row[$val];
		}
		return $x;
	} else return $x;
}

/*Retonar o id numerico do recurso*/
function get_id()
{
	$uri = $GLOBALS['np_instance_of_uri'];
	$uri = $uri->uri();
	$route = explode('/', $uri);
	$count = count($route) - 1;

	if ($route[$count] == 'edit' && isset($route[$count - 1]))
		return is_numeric($route[$count - 1]) ? $route[$count - 1] : false;
	else return is_numeric($route[$count]) ? $route[$count] : false;
}

/*Função para pegar um request  especifico da aplicação*/
function get($x, $dafault = null)
{
	$instance = $GLOBALS['np_instance_of_request'];
	return $instance->get($x, $dafault);
}

function get_search(){
	$search = get('search');
	$search = ($search != 'search' && !is_null($search)) ? $search : false;
	return $search;
}

/*Função para pegar todos os requests da aplicação*/
function get_all($except = null)
{
	$instance = $GLOBALS['np_instance_of_request'];
	return $instance->all($except);
}

/*Função para verficar se uma variável request existe*/
function has_get($x)
{
	$instance = $GLOBALS['np_instance_of_request'];
	return $instance->has($x);
}

/*Função para renderização de arquivos de visualização da camada VIEW*/
function view($file, $scope = null)
{
	$instance = $GLOBALS['np_instance_of_view'];
	ob_start();
	$instance->render($file, $scope);	
	$view = ob_get_clean();
	return $view;
}

function template($html,$np_scope=null){
	
	$np_scope = !is_null($np_scope) && is_array($np_scope) ? $np_scope : array();
	extract($np_scope);
	ob_start();

    $var_html_open = 'echo "<div>"; ';
	$var_html_end = 'echo " </div>";';
    $html = $var_html_open.$html.$var_html_end;
    eval($html);	
	$template = ob_get_clean();
	return $template;
}

/*Função para verificar se um token crsf de sessão existe. Caso exista, a função retornará o token no formato de string, caso contário, a função retonará falso*/
//{{csrf_field()}}
function csrf_token()
{

	if (!isset($_SESSION)) session_start();
	$csrf = isset($_SESSION['np_csrf_token']) ? $_SESSION['np_csrf_token'] : false;
	return $csrf;
}

/*Função para validar token de sessão*/
function csrf_check($token)
{
	return (csrf_token() == $token) ? true : false;
}

/*Função para verfificar se um  usuário está autenticado. Se informado o tipo de usuário no parametro, a função irá verficar se o usuário está autenticado e se ele pertence ao tipo informado no parametro da função. Pode ser informado um array do tipo vetor com os nomes das função*/
function auth($role = null)
{
	return call_user_func('Nopadi\Http\Auth::check', $role);
}

/*Retorna a URL(base) da aplicação*/
function url($uri = null)
{
	if('#' == substr($uri,0,1))
	{
		return $uri;
	}
	elseif('https:' == strtolower(substr($uri,0,6)) || 'http:' == strtolower(substr($uri,0,5)))
	{
		return $uri;
	}
	else
	{
		$x = $GLOBALS['np_instance_of_uri'];
	    $uri = (is_null($uri) || $uri == '/') ? null : $uri;
	    return $x->base() . $uri;
	}
}

function href($uri = null){
	if('@show:' == strtolower(substr($uri,0,6)))
	{
		$id = substr($uri,6);
		return 'onclick="document.getElementById(\''.$id.'\').style.display=\'block\'"';
	}
	elseif('@hide:' == strtolower(substr($uri,0,6)))
	{
		$id = substr($uri,6);
		return 'onclick="document.getElementById(\''.$id.'\').style.display=\'none\'"';
	}
	elseif('@id:' == strtolower(substr($uri,0,4)))
	{
		$id = substr($uri,4);
		return 'id="'.$id.'"';
	}
	else{
		return 'href="'.url($uri).'"';
	}
}

/*Retorna os gets(querys) da URL para aplicar um filtro nos botões de paginação*/
function pag_filter($pag)
{
	$x = $GLOBALS['np_instance_of_uri'];
	$uri = explode('?', $x->uri());
	$uri = isset($uri[1]) ? $uri[1] : false;

	if ($uri)
	{
		$uri = preg_replace("/(page=[0-9]+)/simU", '', $uri);
		return str_ireplace(['&&&', '&&'], '&', $pag . '&' . $uri);
	} else return $pag;
}
/*Obtem a URI atual da página ou rota*/
function get_uri($query=true)
{
	$x = $GLOBALS['np_instance_of_uri'];
	$x = $x->uri();
	
	if($query){
		return $x;
	}else{
		$query = explode('?',$x);
		return $query[0];
	}
}

/*Define um valor padrão se o campo for nulo ou vazio*/
function if_null($value,$default=""){
	return is_null($value) || empty($value) || $value == "" ? $default : $value; 
}


/*verfifica se a URL atual pertence a uma API*/
function is_api($api = 'api')
{
	$route = Param::first();
	if($route == $api) return true;
	else return false;
}
function is_method($method='get')
{
	return Request::isMethod($method);
}

/*Verifica se está na rota atual. Se o segundo parametro for 'true', a função irá ignorar a query na URL*/
function is_url($route = null, $ignoreType = false)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	$url = $uri->base();
	$uri = $uri->uri();

	/*Inicio do Código para aceitar o parâmetro 'type'*/
	$route_type = false;
	$uri_type = false;
	$param_route_type = explode('?type=', $route);

	if (isset($param_route_type[1])) {
		$route = $param_route_type[0] . '/type-' . $param_route_type[1];
		$route_type = true;
	}

	$type = $GLOBALS['np_instance_of_request'];
	$type  = $type->get('type') ? $type->get('type') : false;

	if ($type && $route_type) {

		$param_uri = explode('?', $uri);
		$param_uri = $param_uri[0];

		$uri_type = true;

		$uri = $param_uri . '/type-' . $type;
	}

	if ($ignoreType) {

		$route = explode('?', $route);
		$route = $route[0];

		$uri = explode('?', $uri);
		$uri = $uri[0];
	}

	/*Fim do Código para aceitar o parâmetro 'type'*/

	if (substr($route, 0, 4) != 'http') {

		$route = str_ireplace('.', '/', $route);
		$route = ($route == '/' || is_null($route)) ? $uri : $url . $route;

		$route = str_ireplace('/{loop}', '{loop}', $route);
		$route = str_ireplace('/', '\/', $route);
		$route = str_ireplace(array('{id}', '{int}'), '([0-9]+)', $route);
		$route = str_ireplace('{string}', '([A-Za-zÀ-ú0-9\.\-\_]+)', $route);
		$route  = str_ireplace('{letter}', '([A-Za-z]+)', $route);
		$route = str_ireplace('{loop}', '(\/[A-Za-zÀ-ú0-9\.\-\_]+)*', $route);
		/*ira aplicar em tudo, menos na api*/
		$route = str_ireplace('{!api}', '([^api]+)', $route);


		if (preg_match("/^{$route}$/i", $uri)) return true;
		else return false;
	} else {
		if ($route == $uri) return true;
		else return false;
	}
}

/*Redireciona o usuário para uma URL especifica informada*/
function to_url($to = null)
{
	$base = $GLOBALS['np_instance_of_uri'];
	$base = $base->base();
	$to = ($to == '/') ? null : $to;
	$base = $base . $to;
	header('Location:' . $base);
}

/*Retorna os parâmetros das rotas*/
function param($key)
{
	return call_user_func('Nopadi\Http\Param::get', $key);
}
/*Retorna os parâmetros das rotas se for inteiro*/
function int_param($key)
{
	return call_user_func('Nopadi\Http\Param::int', $key);
}
/*Retorna os parâmetros das rotas se for float*/
function float_param($key)
{
	return call_user_func('Nopadi\Http\Param::float', $key);
}
/*Verifica se o nome do parâmetro da rota existe e qual é o seu valor*/
function is_param($key,$val)
{
	return call_user_func('Nopadi\Http\Param::is', $key,$val);
}

function user_set($key,$value=null)
{
		if(Auth::check()){
			if(isset($_SESSION['np_user_logged'][$key])) $_SESSION['np_user_logged'][$key] = $value; 
		}
}

/*Retorna os dados de sessão aberta do usuário*/
function user($role = null)
{
	return call_user_func('Nopadi\Http\Auth::user', $role);
}
/*Retorna todos os dados dos usuários no formato de array(associativo)*/
function user_all($role = null)
{
	return user($role)->all;
}

/*Retorna o nome da função/tipo do usuário da sessão atual*/
function user_role()
{
	return user()->role;
}

/*Retorna o id do usuário da sessão atual*/
function user_id()
{
	if(user()->id) 
		return user()->id;
	else 
		return 0;
}
/*Retorna o nome do usuário da sessão atual*/
function user_name()
{
	if(user()->name) 
		return user()->name;
	else 
		return 0;
}
/*Retorna o primeiro nome do usuário da sessão atual*/
function user_first($name=null)
{
	$name = is_null($name) ? user_name() : $name;
	if($name)
	{
		$name = explode(' ',$name);
        return $name[0];
	}
}

/*Retorna o caminho em URL da imagem do usuário da sessão atual*/
function user_image($path = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	
	$path = is_null($path) ? user()->image : $path;

	$image = $uri->local(dir_public() . $path);

	if (file_exists($image) && !is_null($path)) {
		return $uri->base() . $path;
	}
	return false;
}

/*Retorna o nome do diretório publico (public_html/ ou public/)da aplicação*/
function dir_public()
{
	$uri = $GLOBALS['np_instance_of_uri'];
	return is_dir($uri->local("public_html/")) ? "public_html/" : "public/";
}

/*Remove a imagem de usuário da sessão atual*/
function user_image_remove($path = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	$path = is_null($path) ? user()->image : $path;

	$image = $uri->local(dir_public() . $path);
	$public = substr($image,-7,8);

	$public_html = substr($image,-12,12);
	if($public != 'public/' && $public_html != 'public_html/'){
		if (file_exists($image) && !is_null(user_image())) {
		if (unlink($image)) return true;
		else return false;
	}
	return false;
	}else return false;
}

/*Retorna o caminho base da pasta public/public_html do site*/
function asset($path = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	return $uri->asset($path);
}
function options_checkbox($name,$items,$checked=false,$class='')
{
	$checkbox = null;
	$checked = $checked ? 'checked="checked"' : null;
	if(count($items) > 0)
	{
		foreach($items as $key=>$val){
			$checkbox .= "<p><label>
                          <input type='checkbox' name='{$name}[]' value='{$key}' {$checked}/>
                          <span>{$val}</span></label></p>";
		}
	}
	return $checkbox;
}

function options_string($items)
{
	$ids = null;
	if(is_array($items)){
	if(count($items) > 0)
	{
		foreach($items as $key)
		{
			$ids .= $key.',';
		}
		$ids = trim($ids);
		$ids = substr($ids,0,-1);
	}}
	return $ids;
}

function options_post($name)
{
	if(isset($_POST)){
	  if(isset($_POST[$name])){
		   return $_POST[$name];
	   }	
	}
}

function options_get($name)
{
	if(isset($_GET)){
	  if(isset($_GET[$name])){
		   return $_GET[$name];
	   }	
	}
}


/*Transformação um array associativo em options do HTML. O segundo parametro é a chave(ínice do array) do elemento option que está selecionado, retonando assim, um valor já checado.*/
function options($array = null, $check = null)
{
	$option = null;
	foreach ($array as $key => $val) {
		if ($key == $check) {
			$option .=  '<option value="' . $key . '" selected>' . $val . '</option>';
		} else {
			$option .=  '<option value="' . $key . '">' . $val . '</option>';
		}
	}
	return $option;
}
/*Mapea um array associativo e retonando somente o valor do elemento que teve a sua chave informada na segundo parêmetro*/
function options_text($array = null, $check = null)
{
	$option = null;
	foreach ($array as $key => $val) {
		if ($key == $check) {
			$option = $val;
		} 
	}
	return $option;
}

/*Retonar somente um índice especifco do array ou o valor da chave informada no caso de não existir o índice no array especificado no segundo parâmetro*/
function array_one($key, $array)
{
	$array = array_key_exists($key, $array) ? $array[$key] : $key;
	return $array;
}

/*Retorna uma tradução de um item formatado ou de uma variável. Para que a tradução seja realizada é necessário colocar no inicio da string o :*/
function text($value = null, $alert = null)
{
	$instance = $GLOBALS['np_instance_of_translater'];

	if (substr($value, 0, 1) == ':') {
		$value = trim(str_ireplace(':', '', $value));
		$value = $instance->text($value);
	} else {
		$value = str_ireplace('!:', ':', $value);
	}

	if (is_object($value)) $value = get_object_vars($value);
	if (is_array($value)) $value = implode(', ', $value);


	if (!is_null($alert)) {

		$hello = $GLOBALS['np_instance_of_json'];
		$alert = $hello->val('hello', $alert);

		$value = '<div class="' . $alert . '">' . $value . '</div>';
	}
	return $value;
}

function lang($lang){
	return text(':'.$lang);	
}

/*Similar a text, com a diferença que essa função imprime o valor em tela*/
function hello($value = null, $alert = null)
{
	echo text($value, $alert);
}

/*Similar a text, com a diferença que a tradução é feito em um array*/
function array_text($array)
{
	foreach ($array as $key => $val) {
		$array[$key] = text($val);
	}
	return $array;
}

/*Carrega os arquivos de css da aplicação que estão configurados no diretório config/app/hello.json*/
function style($only = null)
{
	$instance = $GLOBALS['np_instance_of_json'];
	$uri = $GLOBALS['np_instance_of_uri'];

	$style = is_null($only) ? $instance->val('styles') : [$instance->val('styles', $only)];
	$css = null;

	if (is_array($style)) {
		foreach ($style as $key => $val) {

			$val = trim($val);

			if (substr($val, -4, 4) != '.css') $val = $val . '.css';

			if (substr($val, 0, 4) != 'http') {
				$css .= '<link rel="stylesheet" href="' . $uri->asset('css/' . $val) . '">';
			} else {
				$css .= '<link rel="stylesheet" href="' . $val . '">';
			}
		}
	}
	return $css;
}

/*Função para saída do tipo json. Essa função também declara um cabeçalho/header para o browser*/
function json($value = null)
{
	if (is_numeric($value) || is_string($value)) {
		$value = array($value);
	} elseif (is_object($value)) {
		$value = get_object_vars($value);
	}

	header('Content-Type: application/json;charset=utf-8');
	echo json_encode($value);
}

/*Carrega os arquivos de js da aplicação que estão configurados no diretório config/app/hello.json*/
function script($only = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	$instance = $GLOBALS['np_instance_of_json'];

	$script = is_null($only) ? $instance->val('scripts') : [$instance->val('scripts', $only)];

	$js = null;

	if (is_array($script)) {
		foreach ($script as $key => $val) {

			$val = trim($val);

			if (substr($val, -3, 3) != '.js') $val = $val . '.js';

			if (substr($val, 0, 4) != 'http') {
				$js .= '<script src="' . $uri->asset('js/' . $val) . '"></script>';
			} else {
				$js .= '<script src="' . $val . '"></script>';
			}
		}
	}
	return $js;
}

/*Inicio das funções para formatação*/

/*Transforma uma string comum no formato URL*/
function str_url($strTitle, $ignorePonto = true)
{
	/* Remove pontos e underlines */
	$arrEncontrar = array(".", "_");
	$arrSubstituir = null;

	if ($ignorePonto == true) $strTitle = str_ireplace($arrEncontrar, $arrSubstituir, $strTitle);

	/* Caracteres minúsculos */
	$strTitle = strtolower($strTitle);
	/* Remove os acentos */
	$acentos = array("á", "Á", "ã", "Ã", "â", "Â", "à", "À", "é", "É", "ê", "Ê", "è", "È", "í", "Í", "ó", "Ó", "õ", "Õ", "ò", "Ò", "ô", "Ô", "ú", "Ú", "ù", "Ù", "û", "Û", "ç", "Ç", "º", "ª");
	$letras = array("a", "A", "a", "A", "a", "A", "a", "A", "e", "E", "e", "E", "e", "E", "i", "I", "o", "O", "o", "O", "o", "O", "o", "O", "u", "U", "u", "U", "u", "U", "c", "C", "o", "a");
	$strTitle = str_ireplace($acentos, $letras, $strTitle);
	$strTitle = preg_replace("/[^a-zA-Z0-9._$, ]/", "", $strTitle);
	$strTitle = iconv("UTF-8", "UTF-8//TRANSLIT", $strTitle);
	/* Remove espaços em branco*/
	$strTitle = strip_tags(trim($strTitle));
	$strTitle = str_ireplace(" ", "-", $strTitle);
	$strTitle = str_ireplace(array("-----", "----", "---", "--"), "-", $strTitle);
	return $strTitle;
}
function to_datetime($string,$final=true){
	if(strlen($string) == 10)
	{
		$final = $final ? '23:59:59' : '00:00:00';
		$string = $string.' '.$final;
	}
	return $string;
}


/*Função para formatar uma saída de acordo com o arquivo de tradução 'app.json'*/
function format($string, $format)
{
	$string = trim($string);
	$string = $format == 'date' ? substr($string,0,10) : $string;
	
	if($format == 'datetime' && strlen($string) == 10)
	{
		$string = $string.' 00:00:00';
	}
	
	$instance = $GLOBALS['np_instance_of_translater'];
	$format = $instance->val('function.format', $format);
	if ($format) {
		$format = explode('=', $format);
		$er = "/{$format[0]}/simU";
		$replace = isset($format[1]) ? $format[1] : null;
		$string = preg_replace($er, $replace, $string);
	}
	return $string;
}

/*Função para exibir uma simples lista de menu. Essa função não aceita submenus, mas aceita traduções*/
function items_menu($items, $options = null)
{

	$class = isset($options['class']) ? $options['class'] : 'np-bar-item np-button';
	$icon_class = isset($options['icon']) ? $options['icon'] : 'material-icons';
	$route = isset($options['route']) ? $options['route'] : '';
	

	$menu = null;
	if (is_array($items)) {
		foreach ($items as $item) {
	
			$item = explode('|', $item);

			$link = str_ireplace('.', '/', $item[0]);

			$link = $route . $link;

			$title = (isset($item[1]) && '!' != $item[1]) ? text($item[1]) : null;
			$title_link = $title ? ' title="' . $title . '"' : null;
			$icon = isset($item[2]) ? '<i class="' . $icon_class . '">' . $item[2] . '</i>' : null;

			//Define o nível de acesso
			$access = isset($item[3]) ? $item[3] : null;
			if (!is_null($access)) $access = explode(',', $access);
			$auth = is_array($access) ? Auth::check($access) : true;
			
			
			/*
			 <li><a href="dashboard-analytics.html"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Analytics</span></a></li>
			*/
			
		    if($auth){
				$link = url($link);
				if (is_url($link)) {
					$menu .= "<li><a href='{$link}' class='bold'><span data-i18n='Analytics'>{$title}</span></a></li>";
				} else {
					$menu .= "<li><a href='{$link}'><span data-i18n='Analytics'>{$title}</span></a></li>";
                  }
			  
			  }
		}
	}
	return $menu;
}

/*Função para exibir uma simples lista de menu. Essa função não aceita submenus, mas aceita traduções*/
function dropdown_menu($item, $options = null)
{
	$route = isset($options['route']) ? $options['route'] : '';
	$itens = isset($options['items']) ? $options['items'] : null;
	$item = explode('|', $item);

	$link = str_ireplace('.', '/', $item[0]);

	//$link = $route . $link;

	$title = (isset($item[1]) && '!' != $item[1]) ? text($item[1]) : null;
	$icon = isset($item[2]) ? $item[2] : 'link';

	//Define o nível de acesso
	$access = isset($item[3]) ? $item[3] : null;
	if (!is_null($access)) $access = explode(',', $access);
	$auth = is_array($access) ? Auth::check($access) : true;

	if ($auth) {
		$link = url($link);
		$active = null;
		if (is_url($link, true)) {
			$active = 'active bold';
		} 
		return '<li class="'.$active.'"><a class="'.$active.' collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">'.$icon.'</i><b class="menu-title" data-i18n="Dashboard">'.$title.'</b></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">'.$itens.'</ul>				
                </div>
            </li>';
	}
}

function open_menu($title,$icon='link',$color='np-blue'){
	$title = explode('|',$title);
	$home = isset($title[1]) ? url($title[1]) :false;
	$active = $home && is_url($home, true) ? 'active bold' : null;
	
	$title = $home ? "<a href='{$home}' style='margin-top:6px' class='".$active." waves-effect waves-cyan'><i class='material-icons'>{$icon}</i>".text($title[0])."</a>" : text($title[0]); 
	
	
	return '<li class="bold">'.$title.'</li>';
}

function close_menu(){
}

/*Oculta uma parte do texto*/
function text_more($string,$qtd=150,$more='...'){
	return (strlen($string) > $qtd) ? substr($string,0,$qtd - 3).$more : $string; 
}


