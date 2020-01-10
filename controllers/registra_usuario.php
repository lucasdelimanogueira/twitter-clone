<?php

require_once("../models/usuario.php");

extract($_REQUEST);
$usuario = new User();
$usuario->setUsername($username);
$usuario->setEmail($email);
$usuario->setSenha(md5($senha));

if($usuario->save()){
	header("Location: ../index.php?sucess=1");
}else{
	header("Location: ../views/inscrevase.php?erro=1"); //usuário ou email ja cadastrados
}

?>