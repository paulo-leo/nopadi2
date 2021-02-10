<?php
class Dates{
    /*Calcula a quantidade de dias em um intervalo entre duas datas*/
	public function sumDay($date_i,$date_f)
	{
    
	 $date = strtotime($date_f) - strtotime($date_i);
     return floor($date / (60 * 60 * 24)); 
	
	}
	
	/*Soma dias a uma data e retorna a nova data*/
	public function sumQtd($date,$qtd)
	{
	   return $this->op($date,$qtd,'+');
	}
	
	/*Subtrai dias a uma data e retorna a nova data*/
	public function subQtd($date,$qtd)
	{
	   return $this->op($date,$qtd,'-');
	}
	
	private function op($date,$qtd,$op)
	{
		return date("Y-m-d", strtotime("{$op}{$qtd} days",strtotime($date)));
	}
	
	/*Soma dias,meses ou anos a uma data e retorna a nova data*/
	public function sum($date,$num,$type='d')
	{
        switch ($type)
		{
          case 'd': $type = ' day'; break;
          case 'm': $type = ' month'; break;
          case 'y': $type = ' year'; break;
        }
	
      $date = "+".$num.$type;
      return date('Y-m-d', strtotime($date));
   }
   public function sumH($hora)
   {

      // Soma 30 Minutos
      return date('H:i:s', strtotime("{$hora} minute", strtotime($hora)));
	   
   }
}


$x = new Dates();

echo $x->sum(date('Y-m-d'),-30);



?>