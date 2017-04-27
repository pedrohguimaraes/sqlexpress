<?php 
/**
 *  PHP SQL EXPRESS 
 *
 *  Biblioteca com funções básicas e práticas para implementação de um CRUD
 *
 *  Esta biblitoca é distribuida na expectativa de ser útil, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPÓSITO EM           
 *  PARTICULAR.
 *
 *  Desenvolvida por: Pedro Guimarães
 */

// Diretório principal
define('APPPATH', getcwd().'/sqlexpress/');

require_once(APPPATH.'helpers/errors.php'); //Exibição de erros
require_once(APPPATH.'config/config.php');  //Configurações de parâmetros
 

class SQL
{

	private $host 	= HOST; 	//127.0.0.1
	private $dbname = DBNAME; 	// nome_banco
	private $user 	= USER; 	//root
	private $pass 	= PASS; 	//root
	private $driver = DRIVER; 	//mysql, postgre
	private $conn 	= CONN;		// string conn
	private $sql 	= SQL;		// query

	public function __construct(){
		if($this->conn == null){	
			$this->conecta();	
		}
	}

	public function conecta(){
		try{
			// drive de conexão PDO Postgres::pgsql. MySQL::mysql.
			$this->conn = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbname};", $this->user, $this->pass);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo ('ERRO: Verifique os atributos de conexão na classe. <br/>'); 
			die ('PDO ERROR: '.$e->getMessage());
		}
		return $this->conn;
	}

/**
* Função que realiza um CRUD simples
* 
* @param string - tipo de ação a ser executada [select, insert, update, delete]
* @param array - valores passados
* @param string - tabela
*
* @return string - query montada
*/
	public function query($method, $table, $values=array()){
		if($method == 'select'){	
			$newValues = implode(", ", $values);
			$this->sql = "SELECT ".$newValues." FROM ".$table;
		}else if($method == 'insert'){
			$posts = $_POST;

            // retirando valores passados do array "posts"
			if($values != null){
				foreach($posts as $keyp=>$valuep){
					foreach($values as $keyv => $valuev){
						if($keyp == $valuev){
							unset($posts[$keyp]);
						}
					}
				}
			} 

			foreach($posts as $key=>$value){
				$coluna[] = $key;
				$valor[]  = $value;
			}

			$newColuna = implode(", ", $coluna);
			$newValor = implode("', '", $valor);
			$this->sql = "INSERT INTO ".$table." (".$newColuna.") VALUES ('".$newValor."')";
		}else if($method == 'update'){

			foreach($values as $key=>$value){
				$valor[] = $key." = '".$value."'";
			}

			$newValor = implode(", ", $valor);
			$this->sql = "UPDATE ".$table." SET ".$newValor;
		}else if($method == 'delete'){
			$this->sql = "DELETE FROM ".$table;
		}
		return $this->sql;
	}

/**
* Função que realiza um acrescenta uma condição na query [AND]
*
* @param string - valor 
* @param string - campo
*
* @return string - query montada
*/
	public function where($campo, $value){

		if(strpos($campo, ">")){
			$op = ">";
		}else if(strpos($campo, "<")){ 
			$op = "<";
		}else{ 
			$op = "=";
		}  // Definição do operador

		if(!strpos($this->sql, "WHERE")){
			$pre = "WHERE";
		}else{
			$pre = "AND";
		}
		
		if(isset($op)){ $campo = str_replace($op, '', $campo);}
		// eliminar duplicação do operador

		$this->sql .= " {$pre} ".$campo." {$op} '".$value."'";
		return $this->sql;
	}

/**
* Função que acrescenta uma condição na query [OR]
* @param string - valor 
* @param string - campo
*
* @return string - query montada
*/
	public function or_where($campo, $value){

		if(strpos($campo, ">")){
			$op = ">";
		}else if(strpos($campo, "<")){ 
			$op = "<";
		}else{ 
			$op = "=";
		}  // Definição do operador

		if(isset($op)){ $campo = str_replace($op, '', $campo);}
		// eliminar duplicação do operador

		$this->sql .= " OR ".$campo." {$op} '".$value."'";
		return $this->sql;
	}

	public function assoc(){
		if($this->run() == false):
			return 'Nenhuma query para criar assoc';
		endif;
		$rs = $this->run();
		$i = 0;
		while ($row = $rs->fetch(PDO::FETCH_OBJ)){
			foreach($row as $key => $value){
               @$array[$i]->$key = $value;
			}
		$i++;
		}		
		return $array;
	}
/**
* Função que exibe a query do objeto
*
* @return string - query montada
*/	
	public function show(){
		if($this->sql != null){
			return $this->sql;
		}else{
			return false;
		}
	}
/**
* Função que executa a query do objeto
*
* @return string - query executada
*/
	public function run(){
		if($this->conn->query($this->sql))
			return $this->conn->query($this->sql);
		else
			echo $e->getMessage();
	}
}