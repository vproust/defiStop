<?php
// Connects to your Database
include('./config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);
	  
//This gets all the other information from the form
$id_equipe_pos=$_GET['id_equipe'];
$latitude=$_GET['latitude'];
$longitude=$_GET['longitude'];
$distance=$_GET['distance'];
$heure=time();
	
// on teste si le visiteur a soumis le formulaire
//if (isset($_SESSION['login'])) {

    $sql = "INSERT INTO geo (id_equipe, latitudes, longitudes, heures) VALUES($id_equipe_pos,'$latitude','$longitude',$heure)";
    mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
    
    //mise a jour de la distance si elle est plus grande
	$table_equipes = 'equipes';
	$query_dist = "UPDATE ".$table_equipes." SET distance=$distance WHERE id_equipe=$id_equipe_pos AND distance < $distance";
	$result_dist = mysql_query($query_dist);
	
	header('Location: administration.php');
	
//}
//else { echo "Pas de formulaire"; };
?>