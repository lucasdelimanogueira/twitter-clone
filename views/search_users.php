<?php
session_start();
if(!isset($_SESSION["usuario"])) header("Location: ../index.php?erro=2");
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready(function(){

				//se btn tweet clicado
				$("#btn_search").click(function(){
					//verificar se campo texto está digitado
					if($("#txt_nome").val().length > 0){
						
						$.ajax({
							url: "../controllers/retrieve_users.php/",
							type: "POST",
							data: $("#form_search_users").serialize(),

							success: function(data){
								$("#users").html(data);

								$(".btn_seguir").click(function(){
									var id_usuario = $(this).data("id_usuario");

									$.ajax({
										url: "../controllers/follow_user.php",
										type: "POST",
										data: {id_followed_user: id_usuario},

										success: function(data){
											$('#seguir_'+id_usuario).hide();
											$('#deixar_seguir_'+id_usuario).show();
										}
									});
								});

								$(".btn_deixar_seguir").click(function(){
									var id_usuario = $(this).data("id_usuario");

									$.ajax({
										url: "../controllers/unfollow_user.php",
										type: "POST",
										data: {id_followed_user: id_usuario},

										success: function(data){
											$('#seguir_'+id_usuario).show();
											$('#deixar_seguir_'+id_usuario).hide();
										}
									});
								});
							}
						});
					}
				});

				//recuperar quantidade de tweets e usuarios
				function updateAmounts(){
					$.ajax({
						url: "../controllers/retrieve_users_tweets_amount.php/",
						type: "POST",

						success: function(data){
							$('#tweets_users_amount').html(data);
						}
					});
				}
				updateAmounts();
			});
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="../imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li><a href="home.php">Home</a></li>
	            <li><a href="../controllers/sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div id="tweets_users_amount" class="col-md-3">
	    		
	    	</div>
	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">

	    				<form id="form_search_users">
		    				<div class="input-group">
		    					<input type="text" class="form-control" id="txt_nome" name="txt_nome" placeholder="Quem você está procurando?" maxlength="140" name="">
		    					<span class="input-group-btn">
		    						<button class="btn btn-default" id="btn_search" type="button">Procurar</button>
		    					</span>
		    				</div>
		    			</form>
	    			</div>
	    		</div>

	    		<div id="users" class="list-group"></div>
	    	</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>