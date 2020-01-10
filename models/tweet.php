<?php

require_once("../helpers/db.php");
class Tweet{
	private $tweet;
	private $id_usuario;

	//postar tweet
	static function postTweet($id_usuario, $tweet){
		//banco de dados
		$db = new db();

		//cria tabela no db se não existir
		$sql = "CREATE TABLE IF NOT EXISTS tweets(
				id_tweet int not null primary key AUTO_INCREMENT,
				id_usuario int not null,
				tweet varchar(140) not null,
				data datetime default CURRENT_TIMESTAMP)";
		$db->connect()->query($sql);

		//consulta postar tweet
		$sql = "INSERT INTO tweets(id_usuario, tweet) VALUES($id_usuario, '$tweet')";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			return true;
		}else{//erro na consulta
			return false;
		}
	}

	//recuperar tweets
	static function retrieveTweets($id_usuario){
		//banco de dados
		$db = new db();

		//consulta
		$sql = "SELECT tweets.id_tweet, tweets.id_usuario, tweets.tweet, DATE_FORMAT(tweets.data, '%d %b %Y %T') AS data_formatada, usuarios.usuario FROM tweets JOIN usuarios ON (tweets.id_usuario = usuarios.id) WHERE tweets.id_usuario = $id_usuario OR tweets.id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE  id_usuario = $id_usuario) ORDER BY data DESC";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
			if($results['tweet'] = null){
				return false;
			}
			return $results;
		}else{//erro na consulta
			return false;
		}
	}

	//recuperar quantidade de tweets
	static function countTweets($id_usuario){
		//banco de dados
		$db = new db();

		//consulta
		$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweets WHERE id_usuario = $id_usuario";
		$result = $db->connect()->query($sql);

		if($result){//sem erro na consulta
			return $result->fetch_array(MYSQLI_ASSOC);
		}else{//erro na consulta
			return false;
		}
	}
}

?>
