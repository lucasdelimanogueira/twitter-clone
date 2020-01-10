<?php
session_start();
if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");

require_once("../models/usuario.php");
extract($_REQUEST);
extract($_SESSION);


if(User::followUser($id_usuario, $id_followed_user)){
	echo "usuário seguido";
}else{
	echo "Erro na consulta";
}

?>