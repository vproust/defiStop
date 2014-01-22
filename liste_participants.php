<?php
session_start();  
include('./config.php');
$base = mysql_connect ($host, $user, $passwd); 
mysql_select_db ($bdd);

$result = mysql_query("SELECT * FROM geo AS g, equipes AS e WHERE g.id_equipe = e.id_equipe ORDER BY e.id_equipe") or exit(mysql_error( )) ;
 
//echo "<ul>";
echo '<div id="content">';
echo '<div class="section" id="example">';
$equipe = "NULL"; // On initialise la variable qui permet d'afficher le nom d'équipage.

while($row = mysql_fetch_array($result)) 
{
if($row['id_equipe'] != $equipe){ // On vérifie que le nom d'équipe est différent pour l'afficher.
echo "</div>";

echo "<h1>";
echo $row['nom_equipe'];
echo "</h1>";
echo '<div class="imageRow">';
}

$image=$row['photos'];
if($image!="none"){

//echo "<li>\n";
//echo $row['id_equipe'];


echo '<div class="single">';

echo '<a href="images/'.$image.'" rel="lightbox" title="my caption">';
print '<img src="./images/tb.'.$image.'" alt="texte alternatif" />';
echo '</a>';

echo '</div>';

//echo "</li>\n";
}
$equipe = $row['id_equipe']; 
}
//echo "</ul>\n";
echo "</div>";
echo '</div>';
?>


<html>
<head>
<link href="css/lightbox.css" rel="stylesheet" />
<link href="css/screen.css" rel="stylesheet" />
<title>Liste des participants</title>
</head>
 
<body>
<br>
<a href="images/next.png" rel="lightbox" title="my caption">image #1</a>
<br>
<a href="./index.php">Retour la page du defistop</a>
</body>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox.js"></script>
</html> 