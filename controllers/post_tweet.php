<?php
session_start();
if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");

require_once("../models/tweet.php");
extract($_REQUEST);
extract($_SESSION);

if(Tweet::postTweet($id_usuario, $txt_tweet)){
	echo "tweet postado";
}else{
	echo "Erro na consulta";
}

?>