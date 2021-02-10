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
function id_value($array, $val, $id = 'id')
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
	$instance->render($file, $scope);
}

/*Função para verificar se um token crsf de sessão existe. Caso exista, a função retornará o token no formato de string, caso contário, a funçã retonará falso*/
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
	$x = $GLOBALS['np_instance_of_uri'];
	$uri = (is_null($uri) || $uri == '/') ? null : $uri;
	return $x->base() . $uri;
}

/*Retorna os gets(querys) da URL para aplicar um filtro nos botões de paginação*/
function pag_filter($pag)
{
	$x = $GLOBALS['np_instance_of_uri'];
	$uri = explode('?', $x->uri());
	$uri = isset($uri[1]) ? $uri[1] : false;

	if ($uri) {
		$uri = preg_replace("/(page=[0-9]+)/simU", '', $uri);
		return str_ireplace(['&&&', '&&'], '&', $pag . '&' . $uri);
	} else return $pag;
}

/*verfifica se a URL atual pertence a uma API*/
function is_api($api = 'api')
{
	$x = $GLOBALS['np_instance_of_uri'];
	$api = $x->base() . $api;
	$uri = $x->uri();
	$api = str_ireplace('/', '\/', $api);

	return preg_match("/^({$api})(\/[A-Za-zÀ-ú0-9\.\-\_]+)*$/i", $uri);
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

function int_param($key)
{
	return call_user_func('Nopadi\Http\Param::int', $key);
}
function float_param($key)
{
	return call_user_func('Nopadi\Http\Param::float', $key);
}

function is_param($key,$val)
{
	return call_user_func('Nopadi\Http\Param::is', $key,$val);
}

/*Retorna os dados de sessão aberta do usuário*/
function user($role = null)
{
	return call_user_func('Nopadi\Http\Auth::user', $role);
}

/*Retorna o id do usuário da sessão atual*/
function user_id()
{
	if(user()->id) 
		return user()->id;
	else 
		return 0;
}

function user_name()
{
	if(user()->name) 
		return user()->name;
	else 
		return 0;
}

/*Retorna o nome do diretório publico (public_html/ ou public/)da aplicação*/
function dir_public()
{
	$uri = $GLOBALS['np_instance_of_uri'];
	return is_dir($uri->local("public_html/")) ? "public_html/" : "public/";
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

/*Remove a imagem de usuário da sessão atual*/
function user_image_remove($path = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];

	$path = is_null($path) ? user()->image : $path;

	$image = $uri->local(dir_public() . $path);

	if (file_exists($image)) {
		if (unlink($image)) return true;
		else return false;
	}
	return false;
}

/*Retorna o nome da função/tipo do usuário da sessão atual*/
function user_role()
{
	return user()->role;
}

/*Retorna o caminho base da pasta public/public_html do site*/
function asset($path = null)
{
	$uri = $GLOBALS['np_instance_of_uri'];
	return $uri->asset($path);
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

/* Função para saída do tipo json. Essa função também declara um cabeçalho/header para o browser*/
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

/*Função para formatar uma saída de acordo com o arquivo de tradução 'app.json'*/
function format($string, $format)
{
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
	$active = isset($options['active']) ? $options['active'] : 'np-teal np-animate-left';
	$active = trim($class . ' ' . $active);
	$div_class = isset($options['div_class']) ? $options['div_class'] : 'np-card np-dropdown-content np-bar-block np-animate-left';

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
		    if($auth){
				if (is_url($link)) {
					$link = url($link);
					$menu .= '<a href="' . $link . '" class="' . $active . '"' . $title_link . '>' . $icon . $title . '</a>';
				} else {
					
					$link = url($link);
					 $menu .= '<a href="' . $link . '" class="' . $class . '"' . $title_link . '>' . $icon . $title . '</a>';
                  }
			  
			  }
		}
	}
	return '<div class="' . $div_class . '">' . $menu . '</div>';
}

/*Função para exibir uma simples lista de menu. Essa função não aceita submenus, mas aceita traduções*/
function dropdown_menu($item, $options = null)
{

	$class = isset($options['class']) ? $options['class'] : 'np-button np-bar-item';
	$icon_class = isset($options['icon']) ? $options['icon'] : 'material-icons';
	$route = isset($options['route']) ? $options['route'] : '';
	$active = isset($options['active']) ? $options['active'] : 'np-teal np-animate-left';
	$active = trim($class . ' ' . $active);
	$div_class = isset($options['div_class']) ? $options['div_class'] : 'np-dropdown-hover';
	$itens = isset($options['items']) ? $options['items'] : null;

	$menu = null;


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

	if ($auth) {
		if (is_url($link, true)) {
			$link = url($link);
			$menu .= '<a href="' . $link . '" class="' . $active . '"' . $title_link . '>' . $icon . $title . '</a>';
		} else {
			$link = url($link);
			$menu .= '<a href="' . $link . '" class="' . $class . '"' . $title_link . '>' . $icon . $title . '</a>';
		}
		return '<div class="' . $div_class . '">' . $menu . $itens . '</div>';
	}
}

function open_menu($title,$icon='link',$color='np-blue'){
	return '<nav class="np-sidebar np-collapse '.$color.' np-animate-left np-card  np-sidebar-menu" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="np-bar-block" style="position:relative;top:-25px">
  <h2 class="np-center np-border-bottom"><i class="material-icons np-xxlarge">'.$icon.'</i>'.$title.'</h2>';
}

function close_menu(){
	return ' </div></nav>';
}

/*Oculta uma parte do texto*/
function text_more($string,$qtd=150,$more='...'){
	return (strlen($string) > $qtd) ? substr($string,0,$qtd - 3).$more : $string; 
}