//variable globales
//l'objet json qui contient toutes les infos de la base de données recuperees par la requete xhtmlrequest
var resultat_json;
//tableau stockant les lignes
var lines = new Array();
var nblines = 0;
//tableau stockant les marqueurs
var markers = new Array();
var nbmarkers = 0;
//variable globale stockant l'equipe dont les marqueurs sont affiches
var team_markers_displayed = 0;
//tableau stockant les marqueur de derniere position
var lasts = new Array();
var nblasts = 0;
//couleurs
var line_default_color = "#A4A4A4";
var line_enhanced_color = "#B40431";
var line_colors = ["#e173bf","#FA5858","#dd962e","#acda27","#45bff3"];

////////////*FONCTION DE RECUPERATION DES DONNEES*////////////
//fonction permettant de recuperer les infos dans la base de donnees puis d'actualiser la liste et afficher les parcours et dernieres positions
function get_json(bestfit){

	var xhr_object = null;
	
	// creer l'objet qui va faire la requette
	if(window.XMLHttpRequest) // Firefox
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else { // XMLHttpRequest non supportÈ par le navigateur
		alert("Utilisez un navigateur plus récent comme Chrome ou Firefox");
		return;
	}

	//on envoie la requete
	xhr_object.open("GET",  "./php/json_creator.php", true);

	xhr_object.onreadystatechange = function() {
		if(xhr_object.readyState == 4 && xhr_object.status == 200){
			//une fois pret, on parse tous les resulats
			resultat_json = JSON.parse(xhr_object.responseText);
			//on affiche toutes les equipes et leur parcours
			display_all_teams();
			//on recupere leur classement pour le mettre dans le page slide
			get_teams_sorted();
			//le parametre best fit permet d'activer le best fit (rechargement des resultats) ou non (mise a jour de la postion)
			if(bestfit){
				MQA.withModule('shapes', function() {
					map.bestFit();
				});
			}
		}
	}
	xhr_object.send(null);
}


////////////*FONCTION D'AFFICHAGE LORS DU CHARGEMENT DE LA PAGE*////////////
//fonction permettant d'afficher toutes les equipes avec leur parcours en tres pal et leur derniere position
function display_all_teams(){
	//si des resultats on ete retournes
	if(resultat_json.resultats.length != 0){
		
		//on enleve toutes les formes de la carte
		map.removeAllShapes();

		//on remet l'indice du nombre de lignes, du nombre de marqueurs et du nombre de dernières positions sur la carte a 0
		nblines = 0;
		nblasts = 0;
		nbmarkers = 0;
		
		//pour chaque equipe
		for(i=0; i < resultat_json.resultats.length; i++){
		
			//on creer les tableaux nécessaire le stockage des informations retournees par le json
			var latitudes = new Array;
			var longitudes = new Array;
			var photos = new Array;
			var messages = new Array;
			var heures = new Array;
			var id_equipe,nom_equipe,photo_equipe,distance,en_course;
			
			//valeurs propres a une equipe
			id_equipe=resultat_json.resultats[i].id_equipe;
			nom_equipe=resultat_json.resultats[i].nom_equipe;
			photo_equipe=resultat_json.resultats[i].photo_equipe;
			distance=resultat_json.resultats[i].distance;
			en_course=resultat_json.resultats[i].en_course;
			
			//on definit la couleur du trait en fonction du numéro d'équipe (5 couleurs disponibles)
			var line_color = line_colors[(id_equipe%5)];
			
			//pour chaque coordonnee
			for(var j=0; j < resultat_json.resultats[i].geo.latitudes.length; j++){
			
				//on recupere les infos dans le json et on les stocke dans un tableau pour pouvoir traiter les infos
				latitudes[j]=resultat_json.resultats[i].geo.latitudes[j];
				longitudes[j]=resultat_json.resultats[i].geo.longitudes[j];
				photos[j]=resultat_json.resultats[i].geo.photos[j];
				heures[j]=resultat_json.resultats[i].geo.heures[j];
				messages[j]=resultat_json.resultats[i].geo.messages[j];
				
				//si l'equipe est en course on affiche sa derniere position
				if(en_course==1){
					//si c'est la derniere position
					if(j==resultat_json.resultats[i].geo.latitudes.length-1){
						if(photos[j]!="none"){
							type="photo";
						}
						else{
							type="position";
						}
						//on affiche un marqueur de derniere position
						add_last(type,latitudes[j],longitudes[j],id_equipe,nom_equipe,photo_equipe,distance,heures[j],photos[j],messages[j]);
					}
				}
				//sinon on affiche son drapeau de meilleure position
				else{
					//avec photo
					if(photos[j]!="none"){
						type="photo";
					}
					//sans photo
					else{
						type="position";
					}
					//calcul de la distance pour savoir si c'est la meilleure position
					dist_marker = distance_vol_doiseau(latitudes[j],longitudes[j]);
					//meilleure position
					if(dist_marker == distance){
						add_marker(type,true,latitudes[j],longitudes[j],id_equipe,nom_equipe,photo_equipe,distance,heures[j],photos[j],messages[j]);
					}
				}
				
			}
			//on relit toutes les positions entre elles
			display_team_route(latitudes,longitudes,line_color,3,0.3,id_equipe);	
		}
	}
}

//fonction permettant de recuperer les equipes classees par distance et de les inserer dans la page
function get_teams_sorted(){
	var contenu_liste="<h2 id='classement'>Classement</h2><ul>";
	//si des resultats on ete retournes
	if(resultat_json.resultats.length != 0){
		
		//pour chaque equipe
		for(i=0; i < resultat_json.resultats.length; i++){	
			id_equipe=resultat_json.resultats[i].id_equipe;
			nom_equipe=resultat_json.resultats[i].nom_equipe;
			photo_equipe=resultat_json.resultats[i].photo_equipe;
			distance=resultat_json.resultats[i].distance;
			//on recupere la derniere heure de maj de la position
			var dernier_indice=resultat_json.resultats[i].geo.heures.length-1;
			var heure=resultat_json.resultats[i].geo.heures[dernier_indice];
			il_y_a=func_il_y_a(heure);
				contenu_liste = contenu_liste+"<li><a onmouseover=\"enhance_route("+id_equipe+")\" onmouseout=\"reduce_route()\" href='javascript:pre_display_markers_from_list("+id_equipe+");javascript:$.pageslide.close()'><div id='ptr_div'><img class='ptr' src='./img/marqueurs/marqueur"+id_equipe+".png'></div><div id='info_div'><span class='team'>"+nom_equipe+" "+distance+" Km</span><br/><span class='times'>"+il_y_a+"</span></div></a></li>";
		}
	}
	else{
		contenu_liste=contenu_liste+"<li>Aucun équipage</li>";
	}
	document.getElementById("userlist").innerHTML=contenu_liste;
}


////////////*FONCTIONS D'AFFICHAGE DES PARCOURS*////////////
//fonction permettant d'afficher le parcours d'une equipe donnne avec comme parametre la couleur du trait, sa taille et son opacite. l'id equipe sert a la definition du className
function display_team_route(latitudes,longitudes,color,width,opacity,id_equipe){
	//on recupere le nombre de lignes qu'il faudra afficher
	var length = latitudes.length;
	
	//on charge le module pour les formes
	MQA.withModule('shapes', function() {
		for(k=0;k<length;k++){
			//on trace un trait entre chaque marqueur
		    lines[nblines] = new MQA.LineOverlay();
		    //pour le premier trait, il est dessiné entre le depart (saint naz) et le premier marqueur
		    if(k==0){
			    lines[nblines].setShapePoints([latitudes[k], longitudes[k], 47.276667,-2.212372]);
		    }
		    //tous les autres sont relies entre eux
		    else{
			    lines[nblines].setShapePoints([latitudes[k], longitudes[k], latitudes[k-1], longitudes[k-1]]);
		    }
		    //definition des paramtres de la ligne (recus en arguments)
		    lines[nblines].color=color;
		    lines[nblines].borderWidth=width;
		    lines[nblines].colorAlpha=opacity;
		    //la definition du className est utile pour la mise en valeur des parcours
		    lines[nblines].className=id_equipe;
		    //on ajoute la forme a la carte
		    map.addShape(lines[nblines]);
		    //on incremente l'indice du nombre de lignes sur la carte
			nblines++;
		}
	});
}

//utilisee pour le survol d'un marqueur (mouseover)
function pre_enhance_route(){
	//on recupere l'id de l'équipe dont le marqueur a été cliqué
	id_equipe=this.className;
	//on met en valeur son parcours
	enhance_route(id_equipe);
}

//fonction factorisee permettant de mettre en valeur le parcours d'une equipe
function enhance_route(id_equipe){
	var options={colorAlpha:0.9, borderWidth:4};
	for(var i=0;i<nblines;i++){
		if(lines[i].className==id_equipe){
		    lines[i].updateProperties(options);
		}
	}
}

//utilisee pour le survol d'un marqueur (mouseout)
function pre_reduce_route(){
	//on recupere l'id de l'équipe dont le marqueur a été cliqué
	id_equipe=this.className;
	//on enleve la mise en valeur de toutes les autres equipes
	reduce_route(id_equipe);
}

//fonction factorisee permettant d'enlever la mise en valeur le parcours d'une equipe seulement si ses marqueurs ne sont pas affiches
function reduce_route(){
	//definition des parametre d'affichage du parcours sans mise en valeur
	var options={colorAlpha:0.3, borderWidth:3};
	//pour chaque ligne stockee dans le tableau
	for(var i=0;i<nblines;i++){
		//si son className correspond a l'id de l'equipe selectionee
		if(lines[i].className!=team_markers_displayed){
			//on change ses propriétés d'affichage
		    lines[i].updateProperties(options);
		}
	}
}


////////////*FONCTIONS D'AFFICHAGE DES MARQUEURS*////////////
//fonction permettant d'utiliser display_markers() pour un drapeau
function pre_display_markers(){
	//on recupere l'id de l'equipe sur laquelle on a clique
	var id_equipe = this.className;
	//on affiche tous les marqueurs pour cette equipe
	display_markers(id_equipe);
}

//fonction permettant d'utiliser display_markers() pour une liste
function pre_display_markers_from_list(id_equipe){
	//l'id de l'equipe est renseignee par le "bouton" de l'équipe dans la liste
	display_markers(id_equipe);
}

//fonction permettant a partir de l'id d'une equipe d'afficher tous ses marqueurs
function display_markers(id_equipe){
	//on actualise le l'id de l'équipe qui est actuellement affichee
	team_markers_displayed=id_equipe;

	//on enleve tous les marqueurs de la carte
	for(h=0;h<nbmarkers;h++){
		map.removeShape(markers[h]);
	}
	//le nombre de marqueurs sur la carte est desormais de 0
	nbmarkers=0;
	
	//on enleve toutes les surbrillances de route
	reduce_route();
	//on met en surbrillance la route de l'equipe cliquee
	enhance_route(id_equipe);

	//pour chaque equipe
	for(i=0; i < resultat_json.resultats.length; i++){
	
		//si c'est l'equipe correspondante
		if(id_equipe==resultat_json.resultats[i].id_equipe){
		
			//on definit la couleur du trait en fonction du numéro d'équipe (5 couleurs disponibles)
			var line_color = line_colors[(id_equipe%5)];
			
			//on creer les tableaux nécessaire le stockage des informations retournees par le json
			var latitudes = new Array;
			var longitudes = new Array;
			var photos = new Array;
			var messages = new Array;
			var heures = new Array;
			var id_equipe,nom_equipe,photo_equipe,distance;
			
			//infos propres a une equipe
			id_equipe=resultat_json.resultats[i].id_equipe;
			nom_equipe=resultat_json.resultats[i].nom_equipe;
			photo_equipe=resultat_json.resultats[i].photo_equipe;
			distance=resultat_json.resultats[i].distance;
			
			//pour chaque coordonnee
			for(j=0; j < resultat_json.resultats[i].geo.latitudes.length; j++){
			
				//on recupere les infos dans le json et on les stocke dans un tableau pour pouvoir les traiter
				latitudes[j]=resultat_json.resultats[i].geo.latitudes[j];
				longitudes[j]=resultat_json.resultats[i].geo.longitudes[j];
				photos[j]=resultat_json.resultats[i].geo.photos[j];
				messages[j]=resultat_json.resultats[i].geo.messages[j];
				heures[j]=resultat_json.resultats[i].geo.heures[j];
			}
			//on affiche tous les marqueurs de l'équipe
			display_team_markers(latitudes,longitudes,id_equipe,nom_equipe,photo_equipe,distance,heures,photos,messages);
		}
	}
}

//fonction permettant d'afficher tous les marqueurs d'une equipe donnee
function display_team_markers(latitudes,longitudes,id_equipe,nom_equipe,photo_equipe,distance,heures,photos,messages){

	//on recupere le nombre de marqueurs qu'il faudra afficher
	var length = latitudes.length;
	
	//on charge le module pour les formes
	MQA.withModule('shapes', function() {
		for(k=0;k<length;k++){
			//si ce n'est pas la derniere position
			if(k!=length-1){
				//calcul de la distance pour savoir si c'est la meilleure position
				dist_marker = distance_vol_doiseau(latitudes[k],longitudes[k]);
				//meilleure position
				if(dist_marker == distance){
					best = true;
				}
				//pas meilleure position
				else{
					best = false;
				}
				//avec photo
				if(photos[k]!="none"){
					type="photo";
				}
				//sans photo
				else{
					type="position";
				}
				//on ajoute un marqueur qui sera different selon son type (photo ou position) et selon qu'il soit ou non la meilleure position
				add_marker(type,best,latitudes[k],longitudes[k],id_equipe,nom_equipe,photo_equipe,distance,heures[k],photos[k],messages[k]);
			}
		}
	});
}

//fonction qui permet d'ajouter le dernier marqueur d'une equipe
function add_last(type,latitude,longitude,id_equipe,nom_equipe,photo_equipe,distance,heure,photo,message){

	//calcul de la difference de temps avec aujourd'hui et affichage sous la forme 'il y a x j'
	var il_y_a=func_il_y_a(heure);
	//on definit la position du marqueur, on instancie le marqueur et on le stocke dans le tableau de dernieres positions
	lasts[nblasts]=new MQA.Poi({lat:latitude, lng:longitude});
	//on creer un raccourcis pour l'acces au marqueur
	var last_marker=lasts[nblasts];
	//on incremente le nombre de dernieres positons (correspond au nombre d'équipe sur la carte)
	nblasts++;
	
	//on differencie les type de marqueurs (photo ou position) et meilleure position ou non
	switch (type) {
		//marqueur de photo last
		case "photo":
			//on definit la taille de l'infowindow a partir de la taille de la carte
			var infowindow_height = (0.5*document.getElementById('map').offsetHeight);
			var infowindow_width = (0.5*document.getElementById('map').offsetWidth);
			//definition du contenu
			var contenu_info = "<div style='min-height:"+infowindow_height+"px;min-width:"+infowindow_height+"px'><center><b>"+message+"</b><br/>"+il_y_a+"<br/><a href='./pages/galerie.php'><img src='./images/th."+photo+"'></a></center></div>";
			//definition de l'icone
			var last_icon=new MQA.Icon('./img/marqueurs/marqueur'+id_equipe+'.png',35,35);
			//on definit l'icone du marqueur
			last_marker.setIcon(last_icon);
			//on definit le offset pour centrer le drapeau
			last_marker.setIconOffset(new MQA.Point(-17,-33));
		break;
		
		//marqueur de position last
		case "position":
			//definition du contenu
			var contenu_info = "<div id='div_contenu_info' style='min-width:60px'><b>"+nom_equipe+"</b></br>"+distance+" km</br>"+il_y_a+"</div>";
			//definition de l'icone
			var last_icon=new MQA.Icon('./img/marqueurs/marqueur'+id_equipe+'.png',35,35);
			//on definit l'icone du marqueur
			last_marker.setIcon(last_icon);
			//on definit le offset pour centrer le drapeau
			last_marker.setIconOffset(new MQA.Point(-17,-33));
		break;
	}
	//contenu lorsque qu'on clique sur un marqueur
	last_marker.setInfoContentHTML(contenu_info);
	//pour les dernieres positions on evite le chevauchement
	last_marker.setDeclutterMode(true);
	//desactivation de l'ombre
	last_marker.setShadow();
	//definition de la "classe" qui sera utile pour la mise en valeur (enhance) du parcours
	last_marker.className=id_equipe;
	//ajout du marqueur
	map.addShape(last_marker);
	//lors du survol d'un marqueur de derniere position on met en valeur le parcours de l'équipe
	MQA.EventManager.addListener(last_marker, 'mouseover', pre_enhance_route);
	//lorsqu'on quitte le survol du marqueur de derniere position on enleve la mise en valeur du parcours de l'équipe
	MQA.EventManager.addListener(last_marker, 'mouseout', reduce_route);
	//lorsqu'on clique sur un marqueur de derniere position, on affiche tous les marqueurs de l'équipe
	MQA.EventManager.addListener(last_marker, 'infowindowopen', pre_display_markers);
}

//fonction qui ajoute un marker pour une equipe donnee
function add_marker(type,best,latitude,longitude,id_equipe,nom_equipe,photo_equipe,distance,heure,photo,message){

	//on calcul le modulo 5 de l'id equipe pour la couleur des marqueurs
	var id_equipe_modulo5 = (id_equipe%5);

	//si la photo d'équipe n'a pas été renseignée alors on la définie comme étant nulle
	if(photo_equipe==null){
		photo_equipe="defaut.png";
	}
	//on definit la position du marqueur, on instancie le marqueur et on le stocke dans le tableau de dernieres positions
	markers[nbmarkers] = new MQA.Poi({lat:latitude, lng:longitude});
	//on creer un raccourcis pour l'acces au marqueur
	var team_marker=markers[nbmarkers];
	//on incremente le nombre de maarqueurs sur la carte
	nbmarkers++;
	
	var il_y_a=func_il_y_a(heure);
	
	dist_marker = distance_vol_doiseau(latitude,longitude);
	
	//soit c'est un marqueur de photo soit un marqueur de position
	switch (type) {
		//marqueur de photo lambda
		case "photo":
			//on definit la taille de l'infowindow a partir de la taille de la carte
			var infowindow_height = (0.5*document.getElementById('map').offsetHeight);
			var infowindow_width = (0.5*document.getElementById('map').offsetWidth);
			//definition du contenu
			var contenu_info = "<div style='height:"+infowindow_height+"px;width:"+infowindow_height+"px'><center><b>"+message+"</b><br/>"+il_y_a+"<br/><a href='./pages/galerie.php'><img src='./images/th."+photo+"'></a></center></div>";
			//definition de l'icone
			if(best){
				//c'est la plus lointaine position, on affiche un drapeau a la place du marqueur
				var marker_icon=new MQA.Icon('./img/marqueurs/flag'+id_equipe_modulo5+'.png',35,37);
				//on definit l'icone du marqueur
				team_marker.setIcon(marker_icon);
				//on definit le offset pour centrer le drapeau
				team_marker.setIconOffset(new MQA.Point(-4,-32));
			}
			else{
				//ce n'est pas la plus lointaine position
				var marker_icon=new MQA.Icon('./img/camera.png',17,20);
				//on definit l'icone du marqueur
				team_marker.setIcon(marker_icon);
			}
		break;
		
		//marqueur de position lambda
		case "position":
			//definition de l'icone
			if(best){
				//c'est la plus lointaine position, on affiche un drapeau a la place du marqueur
				var marker_icon=new MQA.Icon('./img/marqueurs/flag'+id_equipe_modulo5+'.png',35,37);
				//on definit l'icone du marqueur
				team_marker.setIcon(marker_icon);
				//on definit le offset pour centrer le drapeau
				team_marker.setIconOffset(new MQA.Point(-4,-32));
				//definition du contenu
				var contenu_info = "<div id='div_contenu_info' style='min-width:60px'>"+distance+" km</br>"+il_y_a+"</div>";
			}
			else{
				//ce n'est pas la plus lointaine position, on affiche un drapeau a la place du marqueur
				var marker_icon=new MQA.Icon('./img/marqueurs/dot'+id_equipe_modulo5+'.png',10,10);
				//on definit l'icone du marqueur
				team_marker.setIcon(marker_icon);
				//definition du contenu
				var contenu_info = "<div id='div_contenu_info' style='min-width:40px'>"+il_y_a+"</div>";
			}
		break;
	}

	//contenu lorsque qu'on clique sur un marqueur
	team_marker.setInfoContentHTML(contenu_info);
	//desactivation de l'ombre
	team_marker.setShadow();
	//definition de la "classe" qui sera utile pour la mise en valeur (enhance) du parcours
	team_marker.className=id_equipe;
	//ajout du marqueur sur la carte
	map.addShape(team_marker);
	//lors du survol d'un marqueur on met en valeur le parcours de l'équipe
	MQA.EventManager.addListener(team_marker, 'mouseover', pre_enhance_route);
	//lorsqu'on quitte le survol du on enleve la mise en valeur du parcours de l'équipe
	MQA.EventManager.addListener(team_marker, 'mouseout', reduce_route);
	//lorsqu'on clique sur un marqueur, on affiche tous les marqueurs de l'équipe
	MQA.EventManager.addListener(team_marker, 'infowindowopen', pre_display_markers);
}