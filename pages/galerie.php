<?php 
session_start();  
include('../config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Galerie</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<link href="../css/style-photoswipe.css" type="text/css" rel="stylesheet" />
	<link href="../css/photoswipe.css" type="text/css" rel="stylesheet" />
	<link href="../css/style.css" rel="stylesheet" media="screen">
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="../js/klass.min.js"></script>
	<script type="text/javascript" src="../js/code.photoswipe-3.0.5.min.js"></script>
	<link href="../css/jquery.pageslide.css" rel="stylesheet" type="text/css">
	<script src="../js/jquery.pageslide.min.js"></script>

	<link rel="icon" type="image/png" href="../img/favicon.png">

	<script type="text/javascript">

		(function(window, PhotoSwipe){
		
			document.addEventListener('DOMContentLoaded', function(){
			
				var
					options = {},
					instance = PhotoSwipe.attach( window.document.querySelectorAll('#Gallery a'), options );
			
			}, false);
			
			
		}(window, window.Code.PhotoSwipe));
		
	</script>
	
</head>
<body>



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
				<a class="back" href="../index.php">Menu</a>

				
				<!--Menu-->
				<ul id="nav" class="nav">
					<li><a href="../index.php" class="accueil">Accueil</a></li>
					<li><a href="../pages/galerie.php">Galerie</a></li>
					<li><a href="./heure-par-heure.php">Heure par heure</a></li>
					<?php
					if (isset($_SESSION['login'])) { 
						echo '<li><a href="../php/deconnexion.php">Déconnexion</a></li>';
					}
					if (!isset($_SESSION['login'])) { 
						echo '<li><a href="../connexion.php">Connexion</a></li>';
					}
					?>
				</ul>  	
			</div>
		
				
	<ul id="Gallery" class="gallery">
		
		<?php


$result = mysql_query("SELECT * FROM geo AS g, equipes AS e WHERE g.id_equipe = e.id_equipe AND g.photos <> 'none' ORDER BY e.id_equipe") or exit(mysql_error( )) ;


$equipe = "NULL"; // On initialise la variable qui permet d'afficher le nom d'équipage.

while($row = mysql_fetch_array($result)) 
{
if($row['id_equipe'] != $equipe){ // On vérifie que le nom d'équipe est différent pour l'afficher

echo "<h1>";
echo $row['nom_equipe'];
echo "</h1>";

}

$image=$row['photos'];
$message=$row['messages'];
if($image!="none"){
echo "<li>";

echo '<a href="../images/md.'.$image.'" title="">';
print '<img src="../images/tb.'.$image.'" alt="'.$message.'" />';
echo '</a>';

echo "</li>";
}
$equipe = $row['id_equipe']; }
?>
		
	</ul>
	
</body>
</html>
