<?php

session_start();
require_once("../models/usuario.php");
extract($_SESSION);
extract($_REQUEST);
if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");
$users = User::retrieveUsers($txt_nome, $id_usuario);

if(isset($users)){
	
	foreach ($users as $user) {

		$isFollowing = isset($user["id_usuario_seguidor"]) && !empty($user["id_usuario_seguidor"]);

		echo '<a href="#" class="list-group-item">';
			echo '<strong>'.$user['usuario'].'</strong> <small> '.$user['email'].'</small>';
			echo '<p class="list-group-item-text pull-right">';

				$btn_seguir_display = 'block';
				$btn_deixar_seguir_display = 'block';

				if($isFollowing){
					$btn_seguir_display = 'none';
				}else {
					$btn_deixar_seguir_display = 'none';
				}

				echo '<button type="button" class="btn btn-default btn_seguir" id="seguir_'.$user['id'].'" data-id_usuario="'.$user['id'].'" style="display:'.$btn_seguir_display.'">Seguir</button>';
				echo '<button type="button" class="btn btn-primary btn_deixar_seguir" id="deixar_seguir_'.$user['id'].'" data-id_usuario="'.$user['id'].'" style="display:'.$btn_deixar_seguir_display.'">Deixar de seguir</button>';
			echo '</p>';
			echo '<div class="clearfix"></div>';
		echo '</a>';
	}

}else{
	echo "Erro na execução da consulta";
}

?>
