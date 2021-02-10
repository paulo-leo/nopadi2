<?php 
namespace Modules\Files\Controllers; 

use Nopadi\Base\DB;
use Nopadi\Http\Request;
use Nopadi\FS\UploadImage;
use Nopadi\MVC\Controller;
use Modules\Files\Controllers\FolderController;

class FileController extends Controller
{
   /*Exibe o formulário para upload de arquivos*/
   public function create()
   {
	  $folders = new FolderController;
	  $folders = options($folders->folders());
	  view('@Files/Views/upload-image-form',['folders'=>$folders]);
   }
   
   public function index(){
	   
	   $type = new Request;
	   $type = $type->get('type');
	   
	   if(is_null($type)){
		   
		    $images = DB::table('files')
			->orderBy('id desc')
	       ->paginate(10);
		   
	   }else{
		   
		   $images = DB::table('files')
		   ->where('type',$type)
		   ->orderBy('id desc')
	       ->paginate(10);
		   
	   }
	   
	  $item = null;
	  if($images->results){
	     foreach($images->results as $image){
		   extract($image);
		   $item .= '<div style="width:92px" class="left border border-white"><img id="'.$id.'" src="'.asset($path).'" style="width:100%;height:70px" class="hover-opacity link" alt="'.$name.'"></div>';
	    }
	  }
	  
	  $item .= '<div class="bar col m12 margin-top">';
	  
	  if($images->previous){
		 $item .= '<span  class="btn-files bar-item btn indigo small hover-blue" id="'.pag_filter($images->previous).'"><</span>'; 
	  }
	  
	  if($images->next){
		 $item .= '<span  class="btn-files bar-item btn indigo small hover-blue" id="'.pag_filter($images->next).'">></span>'; 
	  }
	  
	  $item .= '</div>';
	  echo $item;
	  
	  
   }
   
   public function show(){
	   
	   $id = $this->id();
	   $id = DB::table('files')->find($id);
	   
	   if($id){
		   if($id->type == 'image'){
			   echo '<img src="'.asset($id->path).'" style="heigth:150px;width:200px">';
		   }
	   }   
   }

    /*Faz o upload do arquivo*/
   public function store()
   {
	 
    $request = new Request;
	$type = $request->get('type');
  	
	if($type == 'image'){
		
	  $options = array(
		'name'=>'userfile',
		'height'=>400,
		'width'=>600);
		
     $file = new  UploadImage($options);
	 $save = $file->save();
	 $message = ':'.$file->getMessage();
	 
	 if($save){


		 $values = array(
		   'user_id'=>$request->get('user_id'),
		   'name'=>$request->get('name'),
		   'type'=>'image',
		   'path'=>$save,
		   'created_in'=>NP_DATETIME
		 );
		 
         $db = DB::table('files')->insert($values);
		 
		 if($db){
			 hello($message,'success');
         }

	 }else{
		 hello($message,'danger');
	   }
	 }
   }
} 




