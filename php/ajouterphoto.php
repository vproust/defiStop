<?php
session_start();  
if (!isset($_SESSION['login'])) { 
   header ('Location: ../index.php'); 
   exit();  
}

//This gets all the other information from the form
$latitude=$_POST['latitude'];
$longitude=$_POST['longitude'];
$message=$_POST['message'];
if($message==""){
	$message="none";
}
$distance=$_POST['distance'];
$heure=time();

// Connects to your Database
include('../config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);

//on recupere le login
$IDconnexion=strtolower($_SESSION['login']);

//recuperation de l'id equipe
$table_equipes = "equipes";
$query_id_equipe = "SELECT id_equipe FROM ".$table_equipes." WHERE IDconnexion='$IDconnexion'";
$result_id_equipe = mysql_query($query_id_equipe);
$data = mysql_fetch_assoc($result_id_equipe);
$id_equipe = $data['id_equipe'];

 // Testons si le fichier n'est pas trop gros
if ($_FILES['monfichier']['size'] <= 1000000)
{
    // Testons si l'extension est autorisée
    if (strrchr(basename( $_FILES['photo']['name']),'.') == '.jpg' || strrchr(basename( $_FILES['photo']['name']),'.') == '.jpeg' || strrchr(basename( $_FILES['photo']['name']),'.') == '.png' || strrchr(basename( $_FILES['photo']['name']),'.') == '.JPG' || strrchr(basename( $_FILES['photo']['name']),'.') == '.JPEG' || strrchr(basename( $_FILES['photo']['name']),'.') == '.PNG')
    {
        //This is the directory where images will be saved
		$dossier_dest = "../images/";
		$date = getdate();
		$target = $dossier_dest . $date[seconds] . $date[minutes] . $date[hours]. $date[mday].$_SESSION['login'] . strrchr(basename( $_FILES['photo']['name']),'.');
		$photo_name = $date[seconds] . $date[minutes] . $date[hours]. $date[mday].$_SESSION['login'] . strrchr(basename( $_FILES['photo']['name']),'.');
		$mini = $dossier_dest . 'tb.' . $date[seconds] . $date[minutes] . $date[hours]. $date[mday].$_SESSION['login'] . strrchr(basename( $_FILES['photo']['name']),'.');
		$medium = $dossier_dest . 'md.' . $date[seconds] . $date[minutes] . $date[hours]. $date[mday].$_SESSION['login'] . strrchr(basename( $_FILES['photo']['name']),'.');


		//Writes the photo to the server
		if(move_uploaded_file($_FILES['photo']['tmp_name'], $target ))
		{
			mysql_query("INSERT INTO geo (id_equipe,latitudes,longitudes,photos,messages,heures) VALUES ('$id_equipe','$latitude','$longitude','$photo_name','$message','$heure')");
			
			//mise a jour de la distance si elle est plus grande
			$table_equipes = 'equipes';
			$query_dist = "UPDATE ".$table_equipes." SET distance=$distance WHERE IDconnexion='$IDconnexion' AND distance < $distance";
			$result_dist = mysql_query($query_dist);
			
			// Si l'extention est = à ... alors on définie notre imagecreatefrom(jpeg|png|gif)
			$extention = strrchr(basename( $_FILES['photo']['name']),'.');
			
                    if($extention == '.jpg' || $extention == '.jpeg')
                    {
                        $source = imagecreatefromjpeg($target);
                    }
                    elseif($extention == '.png')
                    {
                        $source = imagecreatefrompng($target);
                    }
                    elseif($extention == '.gif')
                    {
                        $source = imagecreatefromgif($target);
                    }
                     
                    // On récupère la largeur et la hauteur de l'image
                    list($largeur,$hauteur) = getimagesize($target);
                     
                    //ratio pour réduire à une taille voulue
                    $ratio = 350/$largeur;
 
                    $vignette_largeur = $largeur * $ratio;
                    $vignette_hauteur = $hauteur * $ratio;
 
                    //largeur de l'image réduite
                    $n_image_largeur = $largeur * $ratio;
                    //hauteur de l'image réduite
                    $n_image_hauteur = $hauteur * $ratio;
                     
                    // On crée la miniature vide
                    $destination = imagecreatetruecolor($n_image_largeur, $n_image_hauteur);
 
                    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
                    $largeur_source = imagesx($source);
                    $hauteur_source = imagesy($source);
                    $largeur_destination = imagesx($destination);
                    $hauteur_destination = imagesy($destination);

                    
                    // On crée la miniature
                    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                    
                                         // On enregistre la miniature sous le nom de "tb.time().(jpg|png|gif)
                    imagejpeg($destination, $mini);
 
                    //On cree la photoa afficher en taille raisonnable
	                    //ratio pour réduire à une taille voulue
	                    $ratio = 650/$largeur;
	 
	                    $vignette_largeur = $largeur * $ratio;
	                    $vignette_hauteur = $hauteur * $ratio;
	 
	                    //largeur de l'image réduite
	                    $n_image_largeur = $largeur * $ratio;
	                    //hauteur de l'image réduite
	                    $n_image_hauteur = $hauteur * $ratio;
	                     
	                    // On crée la miniature vide
	                    $destination = imagecreatetruecolor($n_image_largeur, $n_image_hauteur);
	 
	                    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	                    $largeur_source = imagesx($source);
	                    $hauteur_source = imagesy($source);
	                    $largeur_destination = imagesx($destination);
	                    $hauteur_destination = imagesy($destination);
	 
	                    // On crée la miniature
	                    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

	                 // On enregistre la miniature sous le nom de "tb.time().(jpg|png|gif)
                    imagejpeg($destination, $medium);

			
			//Tells you if its all ok
			echo "0";
		}
		else {
			//Gives and error if its not
			echo "1";
		}
    }
	else{
		echo "2";
	}
}
else{
	echo "3";
}
?>