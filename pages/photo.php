<?php
session_start();
if (!isset($_SESSION['login'])) { 
   header ('Location: ../index.php'); 
   exit();  
}
?>
<html>
	<head>
		<title>Défi Stop : Poster photo</title>
		
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta id="viewport" name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		
		<script src="http://code.jquery.com/jquery.js"></script>
		
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
		<link href="../css/jquery.pageslide.css" rel="stylesheet" type="text/css">
		<link href="../css/style.css" rel="stylesheet" media="screen">
		
		<style type="text/css">
		      body {
		        background-image: url(../img/bg.png);
		        background-color: #f5f5f5;
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
	<body onload="get_location()">

		<div id="offset" class="container-narrow">
			<!--Top bar responsive mobile-->
			<div id="topbar1">
				<img class="center" src="../img/bar-title-i.png" alt="Logo" />
			</div>

			<!--Logo-->
			<div class="jumbotron">
				<img id="logo1" src="../img/logo-petit.png">
			</div>
			
			<div class="masthead">
				<!--Bouton responsive mobile-->
				<a class="back" href="../">Retour</a>
				
			</div>
			
			<div id="content" class="container">
			
				<form class="form-signin" method="post" name="fileinfo" action="../php/ajouterphoto.php" enctype="multipart/form-data" onsubmit="return false">
					<div id="form-body">
							<h8>Sélectionne une photo :</h8>
							<input type="hidden" name="size" value="350000">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input"><i class="icon-file fileupload-exists"></i> 
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-file">
										<span class="fileupload-new">Parcourir</span>
										<span class="fileupload-exists">Modifier</span>
										<input type="file" name="photo"/>
									</span>
									<!--<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Supprimer</a>-->
								
								</div>
								
							</div>
							
							<div id="message_div">
								<h8>Commente cette photo...</h8></br>
								<input type="text" name="message"/>
							</div>
							
							<div id="output"></div>
							
							<input id="form_lat" type="hidden" name="latitude" value="">
							<input id="form_lon" type="hidden" name="longitude" value="">
							
					</div>
					<div id="form-bottom">
						<input type="button" id="submit-button" onclick="send_form()" name="upload" title="Add data to the Database" value="Envoyer" class="btn btn-success"/>
					</div>
				</form>
			
			</div>
		</div>
		
		<script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key=Fmjtd%7Cluub216zn1%2Cbl%3Do5-96zgdw"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-fileupload.js"></script>
		<script src="../js/poster_photo.js"></script>
		<script src="../js/distance.js"></script>
		<script src="../js/jquery.pageslide.min.js"></script>

	</body>
</html>