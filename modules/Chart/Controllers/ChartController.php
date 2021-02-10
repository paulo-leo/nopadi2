<?php 
namespace Modules\Chart\Controllers; 

use Nopadi\Http\Param;
use Nopadi\MVC\Controller;
use Nopadi\Http\Request;
use Modules\Chart\Models\ChartModel;

class ChartController extends Controller
{
  public function index()
   {
	   
	   $list = ChartModel::model()
	      ->orderBy('id desc')
	      ->paginate(12,true); 
		  
		  
       view("@Chart/Views/index",['list'=>$list]);
   } 
   
   public function show()
   {
	   $id = Param::last();
	   $model = ChartModel::model();
	   $chart = $model->find($id);
	   
	   $query = $model->query($chart->code);
	   $title = $chart->name;
	   $type = $chart->type;
	   
       $labels = [];
	   $datas = [];
	   
	   foreach($query as $id)
	   {
		   array_push($labels,"'".text(':'.$id['label'])."'");
		   array_push($datas,$id['total']);
	   }
	   $labels = implode(",",$labels);
	   $datas = implode(",",$datas);
	   

	
       view("@Chart/Views/show",['type'=>$type,'title'=>$title,'datas'=>$datas,'labels'=>$labels]);
   } 
  
  public function create()
   {
       view("@Chart/Views/create");
   }
  /*Cria um grafico*/
    public function store()
	{
	   $request = new Request();
	   $name = $request->get('name');
	   $code = $request->get('code');
	   
	   if($request){
	      hello(alert('Gráfico criado com sucesso!','success')); 
	   }else{
		   hello(alert('Erro ao criar gráfico.','danger'));  
	   }  
   }   
} 





