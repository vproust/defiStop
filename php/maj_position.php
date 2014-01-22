<?php
	session_start(); 
	
	$heure=time();
	
	include('../config.php');
	//on lance la requete a la base de donnees
	$id_connexion = mysql_connect($host, $user, $passwd)
	or die('Impossible de se connecter');
	mysql_select_db($bdd)
	or die('Erreur de connexion a la base de donnees');
	
	//on recupere le login
	$IDconnexion=$_SESSION['login'];
	
	$latitude=$_REQUEST['latitude'];
	$longitude=$_REQUEST['longitude'];
	$distance=$_REQUEST['distance'];
	
	//mise a jour de la distance si elle est plus grande
	$table_equipes = 'equipes';
	$query_dist = "UPDATE ".$table_equipes." SET distance=$distance WHERE IDconnexion='$IDconnexion' AND distance < $distance";
	$result_dist = mysql_query($query_dist);
	
	//recuperation de l'id equipe
	$query_id_equipe = "SELECT id_equipe FROM ".$table_equipes." WHERE IDconnexion='$IDconnexion'";
	$result_id_equipe = mysql_query($query_id_equipe);
	$data = mysql_fetch_assoc($result_id_equipe);
	$id_equipe = $data['id_equipe'];

	//ajout d'une position
	$table_geo = 'geo';
	$query = "INSERT INTO ".$table_geo." (id_equipe, latitudes, longitudes, heures) VALUES('$id_equipe','$latitude','$longitude',$heure)";
	$result = mysql_query($query);
?>