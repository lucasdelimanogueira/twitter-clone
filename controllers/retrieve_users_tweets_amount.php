<?php

session_start();
require_once("../models/tweet.php");
require_once("../models/usuario.php");
extract($_SESSION);

if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");
$nome = $_SESSION["usuario"];
$tweetsAmount = Tweet::countTweets($id_usuario);
$usersAmount = User::countUsers($id_usuario);

if(isset($tweetsAmount) && isset($usersAmount)){
	
echo '<div class="panel panel-default">
	    <div class="panel-body">
	    	<h4>'.$nome.'</h4>
			<hr />
			<div class="col-md-6">
				TWEETS <br /> '.$tweetsAmount['qtde_tweets'].'
			</div>
			<div class="col-md-6">
				SEGUIDORES <br /> '.$usersAmount['qtde_users'].'
			</div>
		</div>
	</div>';
	
}else{
	echo "Erro na execução da consulta";
}

?>
