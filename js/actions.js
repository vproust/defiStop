//fonction qui met a jour la position
function upload_position(){

	//l'icone de maj position devient une icone de chargement
	document.getElementById("maj_position").className="icon-refresh";

	//si le navigateur gere la geo localisation
	if (navigator.geolocation)
	{
		//on recupere les coordonnees de position du peripherique
		navigator.geolocation.getCurrentPosition(position_successCallback, position_errorCallback);
	}
	else{
		alert("Votre navigateur ne prend pas en compte la géolocalisation");
	}

}

//si la geolocalisation a marché et a été acceptée
function position_successCallback(position){

	var xhr_object = null;
	
	// creer l'objet qui va faire la requette
	if(window.XMLHttpRequest) // Firefox
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else { // XMLHttpRequest non supportÈ par le navigateur
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;
	}
	
	//calcul de la distance a vol d'oiseau depuis saint nazaire
	dist = distance_vol_doiseau(position.coords.latitude,position.coords.longitude);
	
	//on envoie la requete
	xhr_object.open("GET","./php/maj_position.php?latitude="+encodeURIComponent(position.coords.latitude)+"&longitude="+encodeURIComponent(position.coords.longitude)+"&distance="+encodeURIComponent(dist), true);
	
	xhr_object.onreadystatechange = function() {
		if(xhr_object.readyState == 4 && xhr_object.status == 200){	
			//l'icone de maj position redevient l'icone de maj position
			document.getElementById("maj_position").className="icon-ok-sign";
			//apres 5 sec il redevient l'icone normal
			setTimeout(function() {document.getElementById("maj_position").className="icon-map-marker";},5000);
			//on recharge toutes les données, on actualise la carte et on zoom sur la position mise a jour
			//le parametre false permet de dire qu'on ne veut pas appliquer le bestfit
			get_json(false);
			//on centre la carte sur le dernier marqueur et on applique le zoom
			maj_zoom(position.coords.latitude,position.coords.longitude);
		}
	}
	xhr_object.send(null);
	
}
 
//si une erreur a ete detectee lors de la mise a jour de la position
function position_errorCallback(error){
	//l'icone de maj position devient une icone d'impossibilité
	document.getElementById("maj_position").className="icon-ban-circle";
	//on afiiche une alerte avec l'erreur
	switch(error.code){
		case error.PERMISSION_DENIED:
		  alert("Vous devez autoriser la localisation pour mettre à jour votre position");
		  break;      
		case error.POSITION_UNAVAILABLE:
		  alert("Votre position n'a pas pu être déterminée");
		  break;
		case error.TIMEOUT:
		  alert("Le service n'a pas répondu à temps");
		  break;
	}
}

//fonction permettant de zoomer sur une position donnee
function maj_zoom(lat_zoom,lon_zoom){
	map.setCenter({lat:lat_zoom, lng:lon_zoom},17);
}