//fonction permettant de calculer la distance parcourue par une equipe a partir de sa latitude et longitude
function distance_vol_doiseau(latitude,longitude){

	//calcul de la distance avec le point de depart
	//saint nazaire
	lat_point_de_depart = 47.279928;
	lon_point_de_depart = -2.214775;
	
	var latitudes=new Array(lat_point_de_depart,latitude);
	var longitudes=new Array(lon_point_de_depart,longitude);

	//saint nazaire
	var start={lat:latitudes[0], lng:longitudes[0]};
	//position actuelle
	var position={lat:latitudes[1], lng:longitudes[1]};
	
	//calcul de la distance
	var dist = Math.floor(MQA.Util.distanceBetween(start, position, 'KM' ));

	return dist;
}