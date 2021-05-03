<?php
/*
**Descrição: Classe reponsável pela manipulação do banco de dados
**Autor:Paulo Leonardo da Silva Cassimiro
*/
namespace Nopadi\Base;

use PDO;
use Nopadi\Http\URI;
use Nopadi\Base\Where;
use Nopadi\Base\Select;
use Nopadi\Base\Connection;

class DB extends Connection
{
	private $sql;
	private $select;
	private $where = null;
	private $whereOr = null;
	private $innerJoin = null;
	private $leftJoin = null;
	private $rightJoin = null;
	private $orderBy = null;
	private $groupBy = null;
	private $having = null;
	private $limit = null;
	private $union = null;
	private $status = 0;
	private $table;
	private $driver = 'mysql';
	private $primary = 'id';
	private $total = 0;
	private $connect = null;
	private $firstQuery = null;
	private $links = null;

	public function __construct($table = null)
	{
		$this->table = is_null($table) ? $this->table : $table;
	}

	/*metodos para transfererir o nome das tabelas*/
	protected function tableName($table)
	{
		$this->table = $table;
	}

	protected function connectName($connect)
	{
		$this->connect = $connect;
	}
	protected function primaryName($primary)
	{
		$this->primary = $primary;
	}

	public static function table($table = null)
	{
		return new DB($table);
	}

	public function select($select = '*')
	{
		$drive = new Select($select);
		$this->select = $drive->results();
		return $this;
	}

	/*Aplica um filtro de clasula "where" com o valor AND na montagem da query*/
	public function where($key, $op = null, $val = null, $val2 = null)
	{
		$drive = new Where();
		$drive->setWhere($key, $op, $val, $val2);
		$this->where =  $drive->getWhere();
		return $this;
	}
   /*Aplica um filtro de clasula "where" com o valor OR na montagem da query*/
	public function whereOr($key, $op = null, $val = null, $val2 = null)
	{
		$drive = new Where();
		$drive->setWhere($key, $op, $val, $val2, 'OR');
		$this->whereOr =  $drive->getWhere('OR');
		return $this;
	}

   /*Faz a junção de tabelas com a clasula inner join*/
	public function join($table, $key1, $key2, $op = '=')
	{
		$drive = new Joins();
		$drive->setJoin($table, $key1, $key2, $op, 'INNER JOIN');
		$this->innerJoin =  $drive->getJoin();
		return $this;
	}
	/*Faz a junção de tabelas com a clasula left join*/
	public function leftJoin($table, $key1, $key2, $op = '=')
	{
		$drive = new Joins();
		$drive->setJoin($table, $key1, $key2, $op, 'LEFT JOIN');
		$this->innerJoin =  $drive->getJoin();
		return $this;
	}
	
	/*Faz a junção de tabelas com a clasula right join*/
	public function rightJoin($table, $key1, $key2, $op = '=')
	{
		$drive = new Joins();
		$drive->setJoin($table, $key1, $key2, $op, 'RIGHT JOIN');
		$this->innerJoin =  $drive->getJoin();
		return $this;
	}

    /*Aplica o filtro having com a clausula having*/
	public function having($select = null)
	{
		$drive = new Having();
		$drive->having($select);
		$this->having =  $drive->getHaving();
		return $this;
	}

    /*Agrupa a consulta com a clausula group by*/
	public function groupBy($select = null)
	{
		$drive = new Having();
		$drive->groupBy($select);
		$this->having =  $drive->getGroupBy();
		return $this;
	}

    /*Ordena a consulta com a clausula order by*/
	public function orderBy($select = null)
	{
		$drive = new Having();
		$drive->orderBy($select);
		$this->orderBy =  $drive->getOrderBy();
		return $this;
	}

    /*limita a conulta com a clausula limit*/
	public function limit($l = null, $o = null)
	{
		$drive = new Having();
		$drive->limit($l, $o);
		$this->limit =  $drive->getLimit();
		return $this;
	}

   /*Uni duas conultas com a clasula union*/
	public function union($query)
	{
		$this->union = 'UNION ' . $query;
		return $this;
	}
	
	/*busca um registro pelo id ou uma outra coluna com valor especificado*/
	public function find($id, $value = null)
	{
		if (!is_null($value) && !is_numeric($id)) {
			$value = is_string($value) ? "'{$value}'" : $value;
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $id . ' = ' . $value;
		} else {
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primary . ' = ' . $id;
		}

		return $this->query($sql, 'OBJ');
	}
	
	/*busca um registro pelo id ou uma outra coluna com valor especificado, com a diferença que o retorno será um array*/
	public function one($id, $value = null)
	{
		if (!is_null($value) && !is_numeric($id)) {
			$value = is_string($value) ? "'{$value}'" : $value;
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $id . ' = ' . $value;
		} else {
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primary . ' = ' . $id;
		}

		$sql = $this->query($sql, 'ASSOC');
		
	     return array('results'=>$sql);
	}
	
	/*retorna todos os registros da tabela*/
	public function all($filter=null,$or=false)
	{
		$op = $or ? 'OR' : 'AND';
		
		if(is_array($filter))
		{
			$w =null;
			foreach($filter as $key=>$val)
			{
				$val = is_string($val) ? "'{$val}'" : $val;
				$w .= "$key=$val {$op} ";
			}
			$w = trim($w);
			$w = $or ? substr($w,0,-2) : substr($w,0,-3);
			$filter = $w;
		}
		
		
		$sql = is_null($filter) ? 'SELECT * FROM ' . $this->table 
		: 'SELECT * FROM ' . $this->table.' WHERE '.$filter;
		
		return  $this->query($sql);
	}
	
	public function allSearch($input,$value)
	{
		
		$sql = "SELECT * FROM {$this->table} WHERE {$input} LIKE '%{$value}%'";

		return  $this->query($sql);
	}
	
	public function value($key, $value = null)
	{
		if (is_null($value)) {
			$sql = 'SELECT ' . $key . ' FROM ' . $this->table;
			$results = $this->query($sql);
		} else {
			$sql = "SELECT " . $key . " FROM " . $this->table . " WHERE " . $key . " = '" . $value . "'";
			$results = $this->query($sql, 'OBJ');
		}
		return $results;
	}
	
	/*Retonar o id pelo chave e valor informado*/
	public function id($key, $value)
	{
		$sql = 'SELECT ' . $this->primary . ' FROM ' . $this->table . ' WHERE ' . $key . ' = "' . $value . '"';
		$results = $this->query($sql, 'OBJ');
		if ($results) {
			$id = $this->primary;
			return intval($results->$id);
		} else return 0;
	}
	
	/*Retonar o valor de uma linha pelo ID infomado*/
	public function rowId($key, $id)
	{
		$sql = 'SELECT ' . $key . ' FROM ' . $this->table . ' WHERE ' . $this->primary . ' = ' . $id;
		$results = $this->query($sql, 'OBJ');
		if ($results) {
			return $results->$key;
		} else return false;
	}
	
	/*Verfica se existe o registro pela chave e valor infomado*/
	public function have($key, $value, $id = null)
	{
		$value = is_string($value) ? "'{$value}'" : $value;

		if (!is_null($id) && is_numeric($id)) {
			$sql = "SELECT " . $key . " FROM " . $this->table . " WHERE " . $key . " = " . $value . " AND " . $this->primary . " != " . $id;
		} else {
			$sql = "SELECT " . $key . " FROM " . $this->table . " WHERE " . $key . " = " . $value;
		}

		$result =  $this->query($sql, 'ASSOC');
		if ($result) return true;
		else return false;
	}

	/*Verfica se existe o registro pela chave e valor infomado*/
	public function exists($values, $id = null)
	{

		if (is_array($values) && count($values) >= 1) {
			$where = null;

			foreach ($values as $key => $val) {
				$val = is_string($val) ? '\'' . $val . '\'' : $val;
				if (!is_null($val)) $where .= $key . ' = ' . $val . ' AND ';
			}

			$where = trim(substr($where, 0, -4));

			$where = (!is_null($id) && is_numeric($id)) ? $where . ' AND ' . $this->primary . ' != ' . $id : $where;

			$where = trim('SELECT ' . $this->primary . ' FROM ' . $this->table . ' WHERE ' . $where);

			$where = $this->query($where);

			if ($where) {
				return intval($where[0][$this->primary]);
			} else return false;
		} else return false;
	}

	/*faz a união total de duas consultas*/
	public function unionAll($query)
	{
		$this->union = 'UNION ALL ' . $query;
		return $this;
	}

    /*Monta funções encadeadas*/
	public function __toString()
	{
		return $this->mounted();
	}
	
	/*Monta a query para execução*/
	private function mounted()
	{
		
		$table = $this->table;

		$select = is_null($this->select) ? '*' : $this->select;

		$join = $this->innerJoin;
		$left = $this->leftJoin;
		$right = $this->rightJoin;

		$where = $this->where;
		$whereOr = $this->whereOr;

		$orderBy = $this->orderBy;

		$groupBy = $this->groupBy;

		$limit = $this->limit;

		$having = $this->having;


		if (!is_null($where)) $where = ' WHERE ' . $where;
		if (is_null($where) && !is_null($whereOr)) {
			$whereOr = (is_null($where)) ? ' WHERE ' . $whereOr : null;
		} elseif (!is_null($where) && !is_null($whereOr)) {
			$whereOr = ' OR ' . $whereOr;
		}
		
		
	if(is_null($this->firstQuery)){
		
		$sql = 'SELECT ' . $select . ' FROM ' . $table . ' ' . $join . $left . $right . $where . $whereOr . $groupBy . $having . $orderBy . $limit;

		$this->sql = trim($sql . ' ' . $this->union);
      
		return $this->sql;
	   }else{
		   return trim($this->firstQuery . $join . $left . $right . $where . $whereOr . $groupBy . $having . $orderBy . $limit);
	   }
	}
	
	/*Prioriza uma query fora da tabela*/
	public static function firstQuery($sql)
	{
	   $first = new DB(null);
	   $sql =  str_ireplace('  ','',$sql);
	   return $first->setFirstQuery($sql);
	}
	
	/*Prioriza uma query fora da tabela*/
	public function setFirstQuery($sql)
	{
	   $this->firstQuery = $sql;
	   return $this;
	}
	
	/*Retona e executa a query montada*/
	public function get($type_of_return=null)
	{
		return $this->query($this->mounted(),$type_of_return);
	}
	
	/*metodo para executar a query SQL, o segundo parametro é o tipo de retorno da query execultada*/
	public static function sql($sql,$type_of_return=null)
	{
		 $sql =  str_ireplace('  ','',$sql);
		 $db = new DB(null);
		 return $db->query($sql,$type_of_return);
	}
	
	
	public static function connect()
	{
		return self::getConn(null);
	}
	public static function myQuery($sql, $re = null)
	{
		$query = new DB;
		return $query->query($sql, $re);
	}
	/*metodo para executar a query SQL, o segundo parametro é o tipo de retorno da query execultada*/
	public function query($sql, $re = null)
	{

		$d = self::getConn($this->connect);

		$query = $d->prepare($sql);
		$re = is_null($re) ? "ASSOC-ALL" : strtoupper($re);
		$rows = null;
		if ($query->execute()) {
			switch ($re) {
				case "ASSOC":
					$rows = $query->fetch(PDO::FETCH_ASSOC);
					break;
				case "ASSOC-ALL":
					$rows = $query->fetchAll(PDO::FETCH_ASSOC);
					break;
				case "OBJ":
					$rows = $query->fetch(PDO::FETCH_OBJ);
					break;
				case "OBJ-ALL":
					$rows = $query->fetchAll(PDO::FETCH_OBJ);
					break;
				case "NUM":
					$rows = $query->fetchAll(PDO::FETCH_NUM);
					break;
				case "BOTH":
					$rows = $query->fetchAll(PDO::FETCH_BOTH);
					break;
				default:
					$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			}
			return $rows;
		} else {
			return false;
		}
	}
	/*Executa um comando SQL e retorna "true" no caso de sucesso e "false" no caso de falha */
	public function execute($sql)
	{
		$self = self::getConn($this->connect);
		if ($self->exec($sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	/*Executa um comando SQL e retorna "true" no caso de sucesso e "false" no caso de falha */
	public static function executeSql($sql)
	{
		$self = self::getConn();
		$self = $self->query($sql);
		if ($self) {
			return true;
		} else {
			return false;
		}
	}
	
	/*Metodo para paginação. O primeiro parametro é um inteiro que reperesenta a quantidade de registros a ser exibidos por páginas, o segundo parametro é se o botões de links de paginação serão exibidos, e o terceiro parametro é se terá retorno dos objetos de botões para paginação*/
	public function paginate($total = 10, $btns = false,$btnObject=true)
	{

		$page = isset($_GET['page']) ? $_GET['page'] : 1;

		if (empty($page) || !is_numeric($page)) {
			$pc = 1;
		} else {
			$pc = $page;
		}

		$inicio = $pc - 1;
		$inicio = $inicio * $total;

		$this->limit($inicio, $total);
		$query = $this->mounted();

		/*Contagem*/
		$this->total = $this->count();

		/*Total de registros por páginas*/
		$tp = ceil($this->total / $total);
		$previous = $pc - 1;
		$next =  $pc + 1;

		$base = new URI();
		$uri = $base->uri();
		$uri = explode('?', $uri);
		$uri = $uri[0]; 

		/*numero de botões*/

		if (is_bool($btns) && $btns == true) {
			$btns = array();
			if ($tp > 1) {
				for ($i = 1; $i <= $tp; $i++) {
					$btns[$i] = $uri . '?page=' . $i;
				}
			}
		}
		
		$this->links['btns'] = $btns;
		
		$previous = ($pc > 1) ? $uri . '?page=' . $previous : null;
		$next = ($pc < $tp) ? $uri . '?page=' . $next : null;

		$results = $this->query($query);
		
        $this->links['page'] = $pc; 
		$this->links['next'] = $next; 
		$this->links['previous'] = $previous;

		
		if($btnObject){
			$config = is_array($btnObject) ? $btnObject : null;
			$results = array(
			'count' => (int)$this->total,
			'page' => (int)$pc,
			'total' => (int)$tp,
			'next' => $next,
			'numbers' => $btns,
			'previous' => $previous,
			'links'=>$this->links($config),
			'results' => $results
		  );
		}else{
			$results = array(
			'count' => (int)$this->total,
			'page' => (int)$pc,
			'total' => (int)$tp,
			'results' => $results
		    );
	      }
		  
		return (object) $results;
	}
	/*Metodo para criar botões de paginação*/
	public function links($config=null){
		
		$div_class = isset($config['div_class']) ? $config['div_class'] : 'pagination';
		$btn_class = isset($config['btn_class']) ? $config['btn_class'] : 'waves-effect';
		$btn_active_class = isset($config['btn_active_class']) ? $config['btn_active_class'] : 'active btn';
		$previous = isset($config['previous_text']) ? $config['previous_text'] : '<i class="material-icons">chevron_left</i>';
		$next = isset($config['previous_next']) ? $config['previous_next'] : '<i class="material-icons">chevron_right</i>';
		
		$links = $this->links;
		$btns = null;
		
		if($links['previous'] || $links['btns'] || $links['next']){
			$btns .= '<ul class="'.$div_class.'">';
		}
		
		if($links['previous']){
			$btns .= '<a class="'.$btn_class.'" href="'.pag_filter($links['previous']).'">'.$previous.'</a>';
		}
		
		if($links['btns']){
			foreach($links['btns'] as $key=>$val){
			if($links['page'] != $key){
				$btns .= '<li class="'.$btn_class.'"><a href="'.pag_filter($val).'">'.$key.'</a></li>';
			}else{
				$btns .= '<li class="'.$btn_active_class.'" href="'.pag_filter($val).'">'.$key.'</a></li>';
			   }
			}
		}
		
		if($links['next']){
			$btns .= '<li class="'.$btn_class.'"><a href="'.pag_filter($links['next']).'">'.$next.'</a></li>';
		}
		
		if($links['previous'] || $links['btns'] || $links['next']){
			$btns .= '</ul>';
		}
		
		return $btns;
	}
	
	//Contagem de registros
	public function count($key = '*',$where=null)
	{
		$where = !is_null($where) ? ' WHERE '.$where : null;
		$count = $this->mounted();
		$count = explode('FROM', $count);
		$count = 'SELECT COUNT(' . $key . ') AS total FROM' . $count[1].$where;
		$count = explode('LIMIT', $count);
		$count = trim($count[0]);
		$count = $this->query($count, 'OBJ');
		return (int)$count->total;
	}
	//Soma
	public function sum($key,$where=null)
	{
		$where = !is_null($where) ? ' WHERE '.$where : null; 
		$count = $this->mounted();
		$count = explode('FROM', $count);
		$count = 'SELECT SUM(' . $key . ') AS total FROM' . $count[1].$where;
		$count = explode('LIMIT', $count);
		$count = trim($count[0]);
		$count = $this->query($count, 'OBJ');
		return (float)$count->total;
	}
	//Média
	public function avg($key)
	{
		$count = $this->mounted();
		$count = explode('FROM', $count);
		$count = 'SELECT AVG(' . $key . ') AS total FROM' . $count[1];
		$count = explode('LIMIT', $count);
		$count = trim($count[0]);
		$count = $this->query($count, 'OBJ');
		return (float)$count->total;
	}
	//Máximo
	public function max($key)
	{
		$count = $this->mounted();
		$count = explode('FROM', $count);
		$count = 'SELECT MAX(' . $key . ') AS total FROM' . $count[1];
		$count = explode('LIMIT', $count);
		$count = trim($count[0]);
		$count = $this->query($count, 'OBJ');
		return (float)$count->total;
	}
	//Minimo
	public function min($key)
	{
		$count = $this->mounted();
		$count = explode('FROM', $count);
		$count = 'SELECT MIN(' . $key . ') AS total FROM' . $count[1];
		$count = explode('LIMIT', $count);
		$count = trim($count[0]);
		$count = $this->query($count, 'OBJ');
		return (float)$count->total;
	}
	/*Metodo para inserção de dados*/
	public function insert($values, $id = true)
	{
		$table = $this->table;
		//Sepera os indices pela chave e valor
		foreach ($values as $key => $val) {
			$k[] = htmlspecialchars($key, ENT_QUOTES);
			$val = str_ireplace('\\','\\\\',$val);
			$val = is_string($val) ? "'" . htmlspecialchars($val, ENT_QUOTES) . "'" : $val;
			if (is_null($val)) $val = "'" . $val . "'";
			$v[] = $val;
		}
		$k = implode(", ", $k);
		$v = implode(", ", $v);
		//Monta a query
		$sql = "INSERT INTO {$table} ({$k}) VALUES ({$v})";
		
		//Retornar V ou F 
		if ($this->execute($sql)) {
			if ($id) return $this->max($this->primary);
			else return true;
		} else return false;
	}
	/*Metodo para deletar*/
	public function delete($id = null)
	{
		$table = $this->table;
		//Monta a condição de atualização da tabela
		if ($id == null) {
			$w = null;
		} elseif (is_numeric($id)) {
			$w = "WHERE " . $this->primary . " = " . $id;
		} else {
			$w = " WHERE {$id}";
		}
		//Monta a query
		$sql = trim("DELETE FROM {$table} {$w}");
		//Retornar V ou F 
		if ($this->execute($sql))
			return 1;
		else
			return 0;
	}
	//Metodo do tipo booleano para montar e execultar uma query do tipo UPDATE
	public function update($values, $id = null)
	{
		$table = $this->table;
		//Sepera os indices pela chave e valor
		foreach ($values as $key => $value) {
			$value = str_ireplace('\\','\\\\',$value);
			$t[] = htmlspecialchars($key, ENT_QUOTES) . " = '" . htmlspecialchars($value, ENT_QUOTES) . "'";
		}
		$t = implode(", ", $t);
		//Monta a condição de atualização da tabela
		if ($id == null) {
			$w = null;
		} elseif (is_numeric($id)) {
			$w = "WHERE " . $this->primary . " = " . $id;
		} elseif (is_array($id)){
			$id = implode(',',$id);
			$w = "WHERE " . $this->primary . " IN(".$id.")";
		}else {
			$w = " WHERE {$id}";
		}
		//Monta a query
		$sql = trim("UPDATE {$table} SET {$t}{$w}");
		if ($this->execute($sql))
			return true;
		else
			return false;
	}
}
