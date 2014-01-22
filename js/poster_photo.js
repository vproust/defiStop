////////////*FONCTIONS D'ENVOI D'UNE PHOTO*////////////
//fonction qui permet l'upload d'une photo
function get_location(){

	//si le navigateur gere la geo localisation
	if (navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(photo_successCallback, photo_errorCallback);
	}
	else{
		alert("Votre navigateur ne prend pas en compte la géolocalisation");
		document.getElementById("submit-button").disabled="disabled";
	}
}

//si la geolocalisation a marché et a été acceptée
function photo_successCallback(position){
	document.getElementById("form_lat").value=position.coords.latitude;
	document.getElementById("form_lon").value=position.coords.longitude;
}
 
//si une erreur a ete detectee
function photo_errorCallback(error){
	//le bouton envoyer devient disabled (inclickable)
	document.getElementById("submit-button").disabled="disabled";

	switch(error.code){
		case error.PERMISSION_DENIED:
		  alert("Vous devez autoriser la localisation pour envoyer une photo");
		  break;      
		case error.POSITION_UNAVAILABLE:
		  alert("Votre position n'a pas pu être déterminée");
		  break;
		case error.TIMEOUT:
		  alert("Le service n'a pas répondu à temps");
		  break;
	}
	
}

//fonction qui envoie le formulaire
function send_form(){
	
	var oOutput = document.getElementById("output");
	var oData = new FormData(document.forms.namedItem("fileinfo"));
	
	var lat_photo = document.getElementById("form_lat").value;
	var lon_photo = document.getElementById("form_lon").value;
	
	if(lat_photo!=""&&lon_photo!=""){

		//calcul de la distance a vol d'oiseau depuis saint nazaire
		dist = distance_vol_doiseau(lat_photo,lon_photo);
		
		oData.append("latitude", lat_photo);
		oData.append("longitude", lon_photo);
		oData.append("distance", dist);
		
		var oReq = new XMLHttpRequest();
		oReq.upload.addEventListener("progress", updateProgress, false);
		
		oOutput.innerHTML = "<div class=\"progress progress-striped active\"><div id=\"bar\" class=\"bar\" style=\"width: 40%;\"></div></div>";
		
		//information de l'utilisateur que son envoi est en cours
		/*oOutput.innerHTML = "Envoi en cours ";
		var nb_petits_points = 2;
		setInterval(function(){
			nb_petits_points++;
			var nb_petits_points_modulo = nb_petits_points%3;
			var chaine_petits_points = "";
			for(i=0;i<=nb_petits_points_modulo;i++){
				chaine_petits_points = chaine_petits_points + ".";
			}
			oOutput.innerHTML = "Envoi en cours " + chaine_petits_points;
		},1000);*/
		
		oReq.open("POST", "../php/ajouterphoto.php", true);
		oReq.onload = function(oEvent) {
			if (oReq.status == 200) {
				var response=oReq.responseText;
				if(response==0){
					document.getElementById("content").innerHTML = "<div class=\"alert alert-success\">Ta photo a bien été postée!</div>";	
				}
				else if(response==1){
					oOutput.innerHTML = "<div class=\"alert alert-error\">Oops, on dirait qu'il y a eu un problème.</div>";
				}
				else if(response==2){
					oOutput.innerHTML = "<div class=\"alert alert-error\">Ton fichier n'est pas une photo.</div>";
				}
				else if(response==3){
					oOutput.innerHTML = "<div class=\"alert alert-error\">Ton fichier est trop gros.</div>";
				}
			} 
			else {
			  oOutput.innerHTML = "<div class=\"alert alert-error\">Oops, on dirait qu'il y a eu un problème.</div>";
			}
		};
		oReq.send(oData);
	}
	else{
		alert("Votre emplacement n'a pas pu être déterminé");
		document.getElementById("submit-button").disabled="disabled";
	}
}

//fonction cool qui mais qui marche que sous safari mobile et navigateur laptops
// progress on transfers from the server to the client (downloads)
function updateProgress(evt) {
  if (evt.lengthComputable) {
    var percentComplete = evt.loaded / evt.total;
    document.getElementById("bar").style.width = (percentComplete*100+"%");
    //alert(percentComplete*100+"%");
  } else {
    document.getElementById("output").innerHTML = "Envoi en cours ...";
  }
}