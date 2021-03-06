<?php
session_start();
?>
<html>
	<head>
		<title>Défi Stop : Heure par heure</title>
		
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
		<script src="http://code.jquery.com/jquery.js" type="text/javascript"></script>
		<script src="../js/hph/overlays.js" type="text/javascript"></script>
		<script src="../js/hph/time.js" type="text/javascript"></script>
		<script src="../js/hph/distance.js" type="text/javascript"></script>

		
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
		<link href="../css/jquery.pageslide.css" rel="stylesheet" type="text/css">
		<link href="../css/style.css" rel="stylesheet" media="screen">
		
		<link rel="icon" type="image/png" href="../img/favicon.png">
	
	</head>
	<body onload="initialize(); get_json(true)">

		<div id="offset" class="container-narrow">
			<!--Top bar responsive mobile-->
			<div id="topbar1">
				<img class="center" src="../img/bar-title-i.png" alt="Logo">
			</div>

			<!--Logo-->
			<div class="jumbotron">
				<img id="logo1" src="../img/logo-petit-i.png" alt="Logo">
			</div>
			
			<div class="masthead">
				<!--Bouton responsive mobile-->
				<a class="open" href="#nav">Menu</a>
				<a class="openusr" href="#userlist">Liste des utilisateurs</a>
				
				<!--Menu-->
				<ul id="nav" class="nav">
					<li><a href="../index.php" class="accueil">Accueil</a></li>
					<li><a href="./galerie.php">Galerie</a></li>
					<li><a href="javascript:$.pageslide.close()" class="accueil">Heure par heure</a></li>
					<?php
					if (isset($_SESSION['login'])) { 
					
					echo '<li><a href="php/deconnexion.php">Déconnexion</a></li>';
					}
					if (!isset($_SESSION['login'])) { 
					echo '<li><a href="connexion.php">Connexion</a></li>';
					}
					?>
					
					
				</ul>  	
			</div>
		</div>

			<a id="map1" class="btn" onclick="fake_time_plus()"><i id="maj_position" class="icon-plus"></i></a>
			<a id="date-heure" class="badge badge-info" style="font-size:1.3em">Vendredi 17h</a>
			<a id="user1" class="btn" onclick="fake_time_minus()"><i id="upload_photo" class="icon-minus"></i></a>

		
		<div id="map" style="position: absolute; overflow:hidden;"></div>
		<div id="userlist" class="userlist"></div>
		
		<script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key=Fmjtd%7Cluub216zn1%2Cbl%3Do5-96zgdw" type="text/javascript"></script> 
		<script src="../js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-fileupload.js" type="text/javascript"></script>
		<script src="../js/hph/map.js" type="text/javascript"></script>
		<script src="../js/jquery.pageslide.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(".openusr").pageslide({ direction: "left"});
		</script>
		<script type="text/javascript">
			$(".open").pageslide({ direction: "right"});
		</script>

	</body>
</html>