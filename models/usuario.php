<?php

require_once("../helpers/db.php");
class User{
	private $username;
	private $email;
	private $senha;

	function save(){
		//banco de dados
		$db = new db();

		//cria tabela no db se não existir
		$sql = "CREATE TABLE IF NOT EXISTS usuarios(
				id int not null primary key AUTO_INCREMENT,
				usuario varchar(50) not null,
				email varchar(100) not null,
				senha varchar(32) not null)";
		$db->connect()->query($sql);

		//verificar se já existe
		$sql = "SELECT * FROM usuarios WHERE usuario = '$this->username' OR email = '$this->email'";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			$result = $result->fetch_array(MYSQLI_ASSOC); //recupera dados do banco
			if(isset($result["usuario"])){
				return false; //usuario já cadastrado
			}else{//insere novo usuario
				$sql = "INSERT INTO usuarios(usuario, email, senha) VALUES('$this->username', '$this->email', '$this->senha')";
				$result = $db->connect()->query($sql);
				
				if($result){
					return true; //usuario cadastrado com sucesso
				}else{
					echo "Erro ao criar usuário";
				}
			}

		}else{//erro na consulta
			echo "Erro na consulta";
		}
		
	}

	//valida login
	static function login($usuario, $senha){
		//banco de dados
		$db = new db();

		//consulta
		$sql = "SELECT id, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			return $result->fetch_array(MYSQLI_ASSOC); //recupera dados do usuário no banco

		}else{//erro na consulta
			echo "Erro na consulta";
		}
	}

	//recuperar usuarios (pesquisa)
	static function retrieveUsers($nome, $id_current_user){
		//banco de dados
		$db = new db();

		//consulta
		$sql = "SELECT u.*, us.id_usuario_seguidor FROM usuarios AS u ";
		$sql .= "LEFT JOIN usuarios_seguidores AS us ON (u.id = us.seguindo_id_usuario AND us.id_usuario = $id_current_user)";
		$sql .= "WHERE u.usuario like '%$nome%' AND u.id <> $id_current_user";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
			return $results;
		}else{//erro na consulta
			return false;
		}
	}


	//seguir usuario
	function followUser($id_current_user, $id_followed_user){
		//banco de dados
		$db = new db();

		//cria tabela no db se não existir
		$sql = "CREATE TABLE IF NOT EXISTS usuarios_seguidores(
				id_usuario_seguidor int not null primary key AUTO_INCREMENT,
				id_usuario int not null,
				seguindo_id_usuario int not null,
				data_registro datetime default CURRENT_TIMESTAMP)";
		$db->connect()->query($sql);

		$sql = "INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario) VALUES($id_current_user, $id_followed_user)";
		$result = $db->connect()->query($sql);

		if($result){
			return true; //usuario seguido com sucesso
		}else{
			echo "Erro ao criar usuário";
		}		
	}

	//deixar de seguir usuario
	function unfollowUser($id_current_user, $id_followed_user){
		//banco de dados
		$db = new db();

		//cria tabela no db se não existir
		$sql = "CREATE TABLE IF NOT EXISTS usuarios_seguidores(
				id_usuario_seguidor int not null primary key AUTO_INCREMENT,
				id_usuario int not null,
				seguindo_id_usuario int not null,
				data_registro datetime default CURRENT_TIMESTAMP)";
		$db->connect()->query($sql);

		$sql = "DELETE FROM usuarios_seguidores where id_usuario = $id_current_user AND seguindo_id_usuario = $id_followed_user";
		$result = $db->connect()->query($sql);

		if($result){
			return true; //usuario seguido com sucesso
		}else{
			echo "Erro ao deixar de seguir usuário";
		}		
	}

	//recuperar quantidade de usuários
	static function countUsers($id_usuario){
		//banco de dados
		$db = new db();

		//consulta
		$sql = "SELECT COUNT(*) AS qtde_users FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			return $result->fetch_array(MYSQLI_ASSOC);
		}else{//erro na consulta
			return false;
		}
	}





	//getters and setters
	function setUsername($username){
		$this->username = $username;
	}
	function getUsername(){
		return $this->username;
	}

	function setEmail($email){
		$this->email = $email;
	}
	function getEmail(){
		return $this->email;
	}

	function setSenha($senha){
		$this->senha = $senha;
	}
	function getsenha(){
		return $this->senha;
	}
}

?>
