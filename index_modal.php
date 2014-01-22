<?php
session_start();
?>
<html>
	<head>
		<title>Défi Stop : Accueil</title>
		
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta id="viewport" name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/overlays.js"></script>

		
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
		<link href="css/jquery.pageslide.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" media="screen">
	
	</head>
	<body onload="initialize(); get_json();">

		<div id="offset" class="container-narrow">
			<!--Top bar responsive mobile-->
			<div id="topbar1">
				<img class="center" src="img/bar-title-i.png" alt="Logo" />
			</div>

			<!--Logo-->
			<div class="jumbotron">
				<img id="logo1" src="img/logo-petit.png">
			</div>
			
			<div class="masthead">
				<!--Bouton responsive mobile-->
				<a class="open" href="#nav">Menu</a>
				<a class="openusr" href="#userlist">Liste des utilisateurs</a>
				
				<!--Menu-->
				<ul id="nav" class="nav">
					<li><a href="javascript:$.pageslide.close()" class="accueil">Accueil</a></li>
					<?php
					if (isset($_SESSION['login'])) { 
					
					echo '<li><a href="php/deconnexion.php">Déconnexion</a></li>';
					}
					if (!isset($_SESSION['login'])) { 
					echo '<li><a href="connexion.php">Connexion</a></li>';
					}
					?>
					
					<li><a href="#">A propos</a></li>
				</ul>  	
			</div>
		</div>

		<!-- [Connecté] Modal upload photo -->
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form method="post" name="fileinfo" action="php/ajouterphoto.php" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="close_modal()">×</button>
					<h3 id="myModalLabel">Poster une photo</h3>
				</div>
				<div class="modal-body" id="modal-body">
						<h8>Sélectionne une photo :</h8>
						<input type="hidden" name="size" value="350000">
						
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input"><i class="icon-file fileupload-exists"></i> 
									<span class="fileupload-preview"></span>
								</div>
								<span class="btn btn-file">
									<span class="fileupload-new">Parcourir</span>
									<span class="fileupload-exists">Modifier</span>
									<input type="file" name="photo"/>
								</span>
								<!--<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Supprimer</a>-->
								
								
							</div>
							<div id="output"></div>
						</div>
						<div id="message_div">
							<h8>Tu peux ajouter un message :</h8></br>
							<input type="text" name="message"/>
						</div>
								
						<input id="form_lat" type="hidden" name="latitude" value="">
						<input id="form_lon" type="hidden" name="longitude" value="">
						
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true" onclick="close_modal()">Fermer</button>
					<input type="button" onclick="send_form()" name="upload" title="Add data to the Database" value="Envoyer" class="btn btn-success"/>
				</div>
			</form>
		</div>
		
		<!-- [Connecté] Bouton upload photo & upload position--> 
	<!--	<?php
		if (isset($_SESSION['login'])) {
			echo '<a href="#" id="map1" class="btn" onclick="upload_position()"><i id="maj_position" class="icon-map-marker"></i></a> 
			<a id="user1" class="second btn" onClick="upload_photo();"><i id="upload_photo" class="icon-camera"></i></a>';
		}
		?>-->
				<?php
		if (isset($_SESSION['login'])) {
			echo '<a href="#" id="map1" class="btn" onclick="upload_position()"><i id="maj_position" class="icon-map-marker"></i></a> 
			<a id="user1" class="second btn" data-toggle="modal" data-target="#myModal" onclick="upload_photo()"><i id="upload_photo" class="icon-camera"></i></a>';
		}
		?>
		
		<div id="map" style="position: absolute; overflow:hidden;"></div>
		<div id="userlist" class="userlist"></div>
		
		<script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key=Fmjtd%7Cluub216zn1%2Cbl%3Do5-96zgdw"></script> 
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-fileupload.js"></script>
		<script src="js/map.js"></script>
		<script src="js/actions.js"></script>
		<script src="js/jquery.pageslide.min.js"></script>
		<script>
			$(".openusr").pageslide({ direction: "left"});
		</script>
		<script>
			$(".open").pageslide({ direction: "right"});
		</script>

	</body>
</html>