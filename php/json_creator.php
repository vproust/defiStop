<?php		
	include('../config.php');
	//on lance la requete a la base de donnees
	$id_connexion = mysql_connect($host, $user, $passwd)
	or die('Impossible de se connecter');
	mysql_select_db($bdd)
	or die('Erreur de connexion a la base de donnees');
	
	//on creer le tableau
	$arr = array('timestamp'=>time(),'resultats'=> array());

	
	//on selectionne chaque equipe
	$table='equipes';
	$query = "SELECT * FROM ".$table." ORDER BY distance DESC";
	$result = mysql_query($query);
	$i=0;
	while ($donnees = mysql_fetch_assoc($result))
	{
		$id_equipe = $donnees['id_equipe']; //numero d'equipe
		$nom_equipe = $donnees['nom_equipe']; //nom d'equipe
		$participant_1 = $donnees['participant_1']; //participant 1
		$participant_2 = $donnees['participant_2']; //participant 2
		$photo_equipe = $donnees['photo_equipe']; //photo equipe
		$distance = $donnees['distance']; //distance max a vol d'oiseau depuis saint nazaire
		$en_course = $donnees['en_course']; //1 si equipe en course, 0 si equipe arrivee
		$arr['resultats'][$i] = array("id_equipe" => $id_equipe,
											"nom_equipe" => $nom_equipe,
											"participant_1" => $participant_1,
											"participant_2" => $participant_2,
											"photo_equipe" => $photo_equipe,
											"distance" => $distance,
											"en_course" => $en_course,
											"geo" => array('latitudes'=>array(),'longitudes'=> array(),'photos'=> array(),'messages'=> array(),'heures'=> array()));
											
		//on selectionne les positions
		$table_geo='geo';
		$query_geo = "SELECT * FROM ".$table_geo." WHERE id_equipe = '".$id_equipe."' ORDER BY heures ASC";
		$result_geo = mysql_query($query_geo);
		$j=0;
		while ($donnees_geo = mysql_fetch_assoc($result_geo))
		{
			$latitude = $donnees_geo['latitudes']; //numero d'equipe
			$longitude = $donnees_geo['longitudes']; //nom d'equipe
			$heure = $donnees_geo['heures']; //date et heure de la maj
			$photo = $donnees_geo['photos']; //photo
			$message = $donnees_geo['messages']; //message
			$arr['resultats'][$i]['geo']['latitudes'][$j]=$latitude;
			$arr['resultats'][$i]['geo']['longitudes'][$j]=$longitude;
			$arr['resultats'][$i]['geo']['photos'][$j]=$photo;
			$arr['resultats'][$i]['geo']['messages'][$j]=$message;
			$arr['resultats'][$i]['geo']['heures'][$j]=$heure;
			$j++;
		}
		$i++;
	}
	echo json_encode($arr);
?>