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
?>

<html>
<head>
	<title>Admin</title>
	<script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key=Fmjtd%7Cluub216zn1%2Cbl%3Do5-96zgdw"></script>
	<script src="./js/distance.js"></script>
	<script src="./js/admin_maj_position.js"></script>
</head> 
<body>

<form method="post" action="ajouterequipe.php" enctype="multipart/form-data">
    <h2>Defi Stop 2013</h2>
    <h3>Ajouter une équipe</h3>
	ID equipe : <input type="text" name="id_equipe"/><br/>
              Nom de l'équipe : <input type="text" name="nomequipe"/><br/>
	      Login de l'équipe : <input type="text" name="IDconnexion"/><br/>

            <p>
              Nom des membres de l'équipe:
            </p>
            <input type="text" name="participant1"/>
            <input type="text" name="participant2"/>
            <!--<p>
              Merci de choisir une photo de l'équipe
            </p>
            <p>
              Photo:
            </p>
            <input type="hidden" name="size" value="350000">
            <input type="file" name="photo">
            <p>
              Si vous le souhaitez, vous pouvez entrer une description de l'équipe:
            </p>
<textarea rows="10" cols="35" name="aboutMember">
</textarea> -->
            
            <input TYPE="submit" name="upload" title="Ajouter l'équipe" value="Ajouter"/>
          </form>
          
          <h3>Ajouter une position manuellement</h3>
          <form method="post" action="admin_position_manuelle.php" enctype="multipart/form-data" onsubmit="return false">
          	Numéro de l'équipe (ID) : <input type="text" id="id_equipe_pos" name="id_equipe_pos"/><br/>
            <p>
              <a title="Taper un lieu dans google map, cliquer droit sur le marqueur, puis sur afficher plus d'informations. La latitude et la longitude s'affichent à la place du lieu dans la barre de recherche">Géolocalisation :</a>
            </p>
            lat:<input type="text" id="latitude" name="latitude"/>
            , lon:<input type="text" id="longitude" name="longitude"/>
            
            <input type="button" id="submit-button" onclick="maj_position_manuelle()" title="Ajouter cette position" value="Envoyer"/>
          </form>
		  <h3>Equipes inscrites :</h3>
		  
<?php  

include('./config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);

$result = mysql_query("SELECT * FROM equipes ORDER BY id_equipe") or exit(mysql_error( )) ;
 
echo "<table>\n";
while($row = mysql_fetch_array($result)) 
{  
echo "<tr>\n";
echo "<td>\n";
echo $row['id_equipe'] ,") ",$row['nom_equipe']," <a href='supprimer.php?id_equipe=".$row['id_equipe']."'>  supprimer</a><br/>login: ",$row['IDconnexion']," mdp: ",$row['MDPconnexion'];
echo "</td>\n";
echo "</tr>\n";
}
echo "</table>\n"; ?>

</body>
</html>