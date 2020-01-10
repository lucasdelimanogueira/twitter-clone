<?php

class db{

	private $host = "localhost"; //host
	private $user = "root"; //usuario
	private $pass = ""; //senha
	private $database = "twitter_clone"; //banco

	//conecta ao banco de dados
	public function connect(){
		$connection = new mysqli($this->host, $this->user, $this->pass, $this->database);					 

		$connection->query("SET NAMES 'utf8'");
		$connection->query("SET character_set_connection = utf8");
		$connection->query("SET character_set_client = utf8");
		$connection->query("SET character_set_results = utf8");


		return $connection;
	}
}

?>