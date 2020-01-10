<?php

session_start();
require_once("../models/tweet.php");
extract($_SESSION);

if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");
$tweets = Tweet::retrieveTweets($id_usuario);

if(isset($tweets)){
	
	foreach ($tweets as $tweet) {
	echo '<a href="#" class="list-group-item">';
	echo '<h4 class="list-group-item-heading">'.$tweet['usuario'].'<small> '.$tweet['data_formatada'].'</small></h4>';
	echo '<p class="list-group-item-text">'.$tweet['tweet'].'</p>';
	echo '</a>';
	}
	
}else{
	echo "Erro na execução da consulta";
}

?>
