<?php
session_start();

include('./config.php');
$base = mysql_connect ($host, $user, $passwd); 
	  mysql_select_db ($bdd);
      
      // on teste si une entrée de la base contient ce login
      $sql = 'SELECT count(*) FROM administrateurs WHERE login= \'' . $_SESSION['login_admin'] . '\''; 
      $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
      $data = mysql_fetch_array($req); 
      
      mysql_free_result($req); 
      mysql_close(); 
      
      // si on obtient une réponse, alors l'utilisateur est un membre
      if ($data[0] != 1) {
         header('Location: index.php');
         exit(); 
      }

$base = mysql_connect ($host, $user, $passwd); 
	  mysql_select_db ($bdd);

  $sql2 = "DELETE 
            FROM equipes
	    WHERE id_equipe = ".$_GET["id_equipe"];
  //exécution de la requête:
  $requete = mysql_query( $sql2 ) ;
  header('Location: administration.php');
?>

