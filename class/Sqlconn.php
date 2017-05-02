<?php

abstract class SQL_Conn
{

	protected $host 	= HOST; 	//127.0.0.1
	protected $dbname 	= DBNAME; 	// nome_banco
	protected $user 	= USER; 	//root
	protected $pass 	= PASS; 	//root
	protected $driver 	= DRIVER; 	//mysql, postgre
	protected $conn 	= CONN;		// string conn
	protected $sql 		= SQL;		// query



/**
* Função que realiza a conexão com o banco de dados via PDO (PHP DATA OBJECT)
*
* @return string de conexão
*/
	public function conecta(){
		try{
			// drive de conexão PDO Postgres::pgsql. MySQL::mysql
			$this->conn = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbname};", $this->user, $this->pass);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo ('ERRO: Verifique os atributos de conexão na classe. <br/>'); 
			die ('PDO ERROR: '.$e->getMessage());
		}
		return $this->conn;
	}
}