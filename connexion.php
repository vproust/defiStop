<?php
// on teste si le visiteur a soumis le formulaire de connexion
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') { 
   if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) { 
 
	  //on inclut les infos de connexion
	  include('./config.php');
      $base = mysql_connect ($host, $user, $passwd); 
      mysql_select_db ($bdd); 
      
      // on teste si une entrée de la base contient ce couple login / pass
      $sql = 'SELECT count(*) FROM equipes WHERE IDconnexion="'.strtolower(mysql_escape_string($_POST['login'])).'" AND MDPconnexion="'.mysql_escape_string($_POST['pass']).'"'; 
      $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
      $data = mysql_fetch_array($req); 
      
      mysql_free_result($req); 
      mysql_close(); 
      
      // si on obtient une réponse, alors l'utilisateur est un membre
      if ($data[0] == 1) { 
         session_start(); 
         $_SESSION['login'] = strtolower($_POST['login']); 
         header('Location: index.php'); 
         exit(); 
      } 
      // si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
      elseif ($data[0] == 0) { 
         $erreur = 'Compte non reconnu.';
      } 
      // sinon, alors la, il y a un gros problème :)
      else { 
         $erreur = 'Problème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion.'; 
      } 
   } 
   else { 
      $erreur = 'Au moins un des champs est vide.'; 
   }
}  
?>
<html>
	<head>
		<title>Accueil</title>
		
	    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	    <meta id="viewport" name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	    
	    
	    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <link href="css/style.css" rel="stylesheet" media="screen">
		<style type="text/css">
		      body {
		        padding-bottom: 40px;
		        background-image: url(img/bg.png);
		        background-color: #f5f5f5;
		      }
		      
		      .container {
			      padding-top: 40px;
		      }
		      .form-signin {
		        max-width: 300px;
		        padding: 19px 29px 29px;
		        margin: 0 auto 20px;
		        background-color: #fff;
		        border: 1px solid #e5e5e5;
		        -webkit-border-radius: 5px;
		           -moz-border-radius: 5px;
		                border-radius: 5px;
		        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		                box-shadow: 0 1px 2px rgba(0,0,0,.05);
		      }
		      .form-signin .form-signin-heading,
		      .form-signin .checkbox {
		        margin-bottom: 10px;
		      }
		      .form-signin input[type="text"],
		      .form-signin input[type="password"] {
		        font-size: 16px;
		        height: auto;
		        margin-bottom: 15px;
		        padding: 7px 9px;
		      }
		      
		      a {color:red;}
		</style>
	</head> 
	<body>
		<div id="topbar1">
			<img class="center" src="img/bar-title-i.png" alt="Logo" />
		</div>
		<a class="back" href="./index.php">Retour</a>
		<div class="container">
		
			<form action="connexion.php" method="post" class="form-signin">
			
				<h2 class="form-signin-heading">Connexion :</h2>
				<input type="text" class="input-block-level" placeholder="Nom équipe" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>">
				<input type="password" class="input-block-level" placeholder="Mot de passe" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>">
				<div class="text-center">
					<input type="submit" name="connexion"  class="btn btn-large btn-danger " value="Connexion">
					<!--<a href="inscription.php">Vous inscrire</a>-->
				</div>
				
			</form>
		</div>
		
		<?php if (isset($erreur)) echo '<br /><br />',$erreur; ?>
		
	</body>
</html>