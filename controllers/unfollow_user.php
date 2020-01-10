<?php
session_start();
if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");

require_once("../models/usuario.php");
extract($_REQUEST);
extract($_SESSION);


if(User::unfollowUser($id_usuario, $id_followed_user)){
	echo "deixado de seguir usuário";
}else{
	echo "Erro na consulta";
}

?>