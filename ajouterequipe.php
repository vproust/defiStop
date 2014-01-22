<?php
// Connects to your Database
include('./config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);
	  
//This gets all the other information from the form
$id_equipe=$_POST['id_equipe'];
$IDconnexion=$_POST['IDconnexion'];
$nomequipe=$_POST['nomequipe'];
$participant1=$_POST['participant1'];
$participant2=$_POST['participant2'];
$about=$_POST['aboutMember'];
$MDPconnexion=rand(1000, 9999);

 // Testons si le fichier n'est pas trop gros
        /*if ($_FILES['monfichier']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                if (strrchr(basename( $_FILES['photo']['name']),'.') == '.jpg' || strrchr(basename( $_FILES['photo']['name']),'.') == '.jpeg' || strrchr(basename( $_FILES['photo']['name']),'.') == '.png' || strrchr(basename( $_FILES['photo']['name']),'.') == '.JPG' || strrchr(basename( $_FILES['photo']['name']),'.') == '.JPEG' || strrchr(basename( $_FILES['photo']['name']),'.') == '.PNG')
                {

                	//This is the directory where images will be saved
			$target = "images/";
			$date = getdate();
			$target = $target . $nomequipe . strrchr(basename( $_FILES['photo']['name']),'.');


			//Writes the photo to the server
				if(move_uploaded_file($_FILES['photo']['tmp_name'], $target ))
				{

				//Tells you if its all ok
					echo "The file ". basename( $_FILES['photo']['name']). " has been uploaded, and your information has been added to the directory";
					
					mysql_query("INSERT INTO equipes (photo) VALUES ('$target')") ;
				}
				else {

					//Gives and error if its not
					echo "Sorry, there was a problem uploading your file.";
				}
                }
		else{
			echo "Ton fichier est pas une photo";
		}
        }
	else
	{
	echo "Ton fichier est trop gros";
	}*/
	
// on teste si le visiteur a soumis le formulaire
//if (isset($_POST['upload']) && $_POST['upload'] == 'Envoyer') { 

            $sql = 'INSERT INTO equipes (id_equipe, IDconnexion,MDPconnexion, nom_equipe, participant_1, participant_2) VALUES("'.$id_equipe.'","'.$IDconnexion.'", "'.$MDPconnexion.'", "'.$nomequipe.'" , "'.$participant1.'", "'.$participant2.'")'; 
            mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
		header('Location: administration.php');
	
//}
//else { echo "Pas de formulaire"; };


?>