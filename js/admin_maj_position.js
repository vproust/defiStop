//si la geolocalisation a marché et a été acceptée
function maj_position_manuelle(){

	var lat = document.getElementById("latitude").value;
	var lon = document.getElementById("longitude").value;
	var id_equipe_pos = document.getElementById("id_equipe_pos").value;
	
	

	if(lat!=""&&lon!=""&&id_equipe_pos!=""){
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
		dist = distance_vol_doiseau(lat,lon);
		
		//on envoie la requete
		xhr_object.open("GET","./admin_position_manuelle.php?id_equipe="+id_equipe_pos+"&latitude="+encodeURIComponent(lat)+"&longitude="+encodeURIComponent(lon)+"&distance="+encodeURIComponent(dist), true);
		
		xhr_object.onreadystatechange = function() {
			if(xhr_object.readyState == 4 && xhr_object.status == 200){	
				alert("La position a bien ete ajoutee a la carte");
				document.getElementById("latitude").value="";
				document.getElementById("longitude").value="";
				document.getElementById("id_equipe_pos").value="";
			}
		}
		xhr_object.send(null);
	}
}