<html>
	<head>
		<title>Défi Stop : Heure par heure</title>
		
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
		<script src="http://code.jquery.com/jquery.js" type="text/javascript"></script>

		
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
		<link href="../css/jquery.pageslide.css" rel="stylesheet" type="text/css">
		<link href="../css/style.css" rel="stylesheet" media="screen">
		
		<link rel="icon" type="image/png" href="../img/favicon.png">
	
	</head>
	<body>

		<div id="offset" class="container-narrow">
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
				<a class="open" href="#nav">Menu</a>
				<a class="openusr" href="#userlist">Liste des utilisateurs</a>
				
				<!--Menu-->
				<ul id="nav" class="nav">
					<li><a href="../index.php">Accueil</a></li>
					<li><a href="./galerie.php">Galerie</a></li>
					<li><a href="./heure-par-heure.php">Heure par heure</a></li>
					<?php
					if (isset($_SESSION['login'])) { 
					
					echo '<li><a href="php/deconnexion.php">Déconnexion</a></li>';
					}
					if (!isset($_SESSION['login'])) { 
					echo '<li><a href="connexion.php">Connexion</a></li>';
					}
					?>
					<li><a href="javascript:$.pageslide.close()" class="accueil">A propos</a></li>
					
				</ul>  	
			</div>
		</div>
<div class="featurette" >
        <img class="featurette-image pull-right" src="./img/web_development.png" style="margin-top:-10px;">
        <h2 class="featurette-heading">Web development <span class="muted">skills</span></h2>
        <p class="lead">Proficient in a lot of web programming languages such as <strong>HTML</strong>, <strong>Javascript</strong>, <strong>CSS</strong>, <strong>PHP</strong>, <strong>JSON</strong> and <strong>Ajax</strong>. Ability to adapt myself to <strong>web API</strong> such as Google Maps, Twitter, Flickr or Instagram. I took web design classes to learn how to use CSS and Javascript. However, I taught myself PHP, JSON and Ajax through several personal web projects.</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <img class="featurette-image pull-left" src="./img/database_skills.png">
        <h2 class="featurette-heading" >Database <span class="muted">skills</span></h2>
        <p class="lead">Extended knowledge in databases. Summer internship at Bullseye Computing near Washington, DC where I worked on <strong>large databases</strong> with <strong>Oracle</strong>. Currently taking <strong>SQL</strong>, <strong>graph theory</strong> and <strong>relational model</strong> classes. Developed a few personal web projects requiring databases.</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <img class="featurette-image pull-right" src="./img/programming_skills.png">
        <h2 class="featurette-heading">Programing <span class="muted">skills</span></h2>
        <p class="lead">Familiar with <strong>Linux</strong>, <strong>Windows</strong> and <strong>Mac OS</strong> environments. Currently taking <strong>system</strong>, <strong>C</strong>, <strong>C++</strong>, <strong>Java</strong>, <strong>algorithm theory</strong>, <strong>object oriented programming</strong> and <strong>UML</strong> classes. Developed programs in C for school projects.</p>
      </div>

      <hr class="featurette-divider">
		
		<script src="../js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-fileupload.js" type="text/javascript"></script>
		<script src="../js/jquery.pageslide.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(".openusr").pageslide({ direction: "left"});
		</script>
		<script type="text/javascript">
			$(".open").pageslide({ direction: "right"});
		</script>

	</body>
</html>