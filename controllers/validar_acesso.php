<?php
session_start();

require_once("../models/usuario.php");
extract($_REQUEST);
$dados_usuario = User::login($usuario, md5($senha));

if(isset($dados_usuario["usuario"])){ //se usuario encontrado

	$_SESSION["id_usuario"] = $dados_usuario["id"]; //recupera id do usuário no banco
	$_SESSION["usuario"] = $dados_usuario["usuario"]; //recupera informação de usuario do banco
	$_SESSION["email"] = $dados_usuario["email"]; //recupera informação de email do banco
	header("Location: ../views/home.php");

}else{//se usuario não existe, volta pro index com parametro 1 (usuário não existe)
	header("Location: ../index.php?erro=1"); 
}
?>