<?php 
namespace Modules\Files\Controllers; 

use Nopadi\Base\DB;
use Nopadi\Http\Request;
use Nopadi\FS\UploadImage;
use Nopadi\MVC\Controller;
use Modules\Files\Controllers\FolderController;

class ImageController extends Controller
{
   /*Exibe o formulário para upload de arquivos*/
   public function create()
   {
	  $folders = new FolderController;
	  $folders = options($folders->folders());
	  view('@Files/Views/upload-image-form',['folders'=>$folders]);
   }
   
   public function index(){
	  $images = DB::table('files')
	  ->where('type','image')
	  ->paginate();
	  $item = null;
	  if($images->results){
	     foreach($images->results as $image){
		   extract($image);
		   $item .= '<div class="col m2"><img class="file-image" id="'.$id.'" src="'.asset($path).'" style="width:100%;height:170px"></div>';
	    }
	  }
	  echo $item;
   }
   
   public function show(){
	   
	   
   }
   
   
   public function imageDest(){
	    view('@Files/Views/image-desc');
   }
   
   /*Faz o upload do arquivo*/
   public function store()
   {
	  
	  $options = array(
		'name'=>'userfile',
		'height'=>400,
		'width'=>600);
		
     $file = new  UploadImage($options);
	 $save = $file->save();
	 $message = ':'.$file->getMessage();
	 
	 if($save){

		 $request = new Request;
		 
		 $folder_id = $request->get('folder_id');

		 $image_id = $request->get('image_id');

		 $values = array(
		   'user_id'=>$request->get('user_id'),
		   'folder_id'=>$folder_id,
		   'name'=>$request->get('name'),
		   'type'=>'image',
		   'path'=>$save,
		   'created_in'=>NP_DATETIME
		 );
		 
         $db = DB::table('files')->insert($values);
		 
		 if($db){
			 hello($message, 'success');
			 if($image_id == 'yes'){
                $this->alterFolderImage($save,$folder_id);
			 }
			 
         }
		 else hello('Erro ao salvar imagem no banco de dados','danger');

	 }else{
		 hello($message,'danger');
	 }
   }
   
    /*Alterar pasta das imagens*/
   public function imageAlterFolder(){
	 $request = new Request;
     $images = $request->get('file_id');
	 $folder_id = $request->get('folder_id');
	 
	 $images = !is_null($images) && strlen($images) > 0 ? explode(',',$images) : false;
	 $folder_id = !is_null($folder_id) && strlen($folder_id) > 0 ? $folder_id : false; 
	 
	

	 if($images && $folder_id)
	 {
		 
	 $images = DB::table('files')->update(['folder_id'=>$folder_id],$images);
	 
	 if($images) hello('Imagens enviadas com sucesso para pasta selecionada.','success');
	 else hello('Erro ao enviar imagens.','danger');
	 
	 }else hello('Não foi selecionado nehuma pasta ou imagem','danger');
   }
   private function alterFolderImage($save,$folder_id){
	   
	   $path = DB::table('files')->find('path',$save);
     
	   if($path && is_numeric($folder_id)){
		  $id =  $path->id;
		  DB::table('folders')->update(['image_id'=>$id],$folder_id);
	   }
   }
} 




