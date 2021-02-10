<?php 
namespace Modules\Files\Controllers; 

use Nopadi\Base\DB;
use Nopadi\Http\Auth;
use Nopadi\Http\Request;
use Nopadi\FS\UploadImage;
use Nopadi\MVC\Controller;

class FolderController extends Controller
{
   public function index()
   {
	   
	    if(Auth::check(['admin','dev','editor','author','collaborator'])){
		
		$edit = Auth::check(['admin','dev','editor']);
		
		$list = DB::table('folders')->paginate();
	    view('@Files/Views/folders',['list'=>$list,'page_title'=>'Pastas','edit'=>$edit]);
	}else view('dashboard/401');	 
	   
   }
   /*Exibe o formulário para upload de arquivos*/
   public function create()
   {
	  view('@Files/Views/folder-form');
   }
   
   /*Faz o upload do arquivo*/
   public function store()
   {
	 
	   $request = new Request;
	   $privacy = $request->get('privacy') ? $request->get('privacy') : 'public';

		 $values = array(
		   'user_id'=>$request->get('user_id'),
		   'name'=>$request->get('name'),
           'privacy'=>$privacy
		 );
		 
         $db = DB::table('folders')->insert($values);
		 
		 if($db) hello('Pasta criada com sucesso','success');
		 else hello('Erro ao salvar imagem no banco de dados','danger');


   }
   
   /*retona todas as pastas*/
    public function folders(){
		
		$folders = DB::table('folders')
		->select('id,name')->get();
		
		$arr = array();
		
		if($folders){
			foreach($folders as $id){
				$arr[$id['id']] = $id['name'];
			}
		}
		return $arr;
	}
} 




