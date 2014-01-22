function initialize() {
	
	setMapSize();
	
	window.onresize = function(event) {
		setMapSize();
		var resizeMap = new MQA.Size(document.getElementById('map').style.width,document.getElementById('map').style.height);
		window.map.setSize(resizeMap);
	}
	
	/*Create an object for options*/
        var options={
			elt:document.getElementById('map'),       /*ID of element on the page where you want the map added*/ 
			zoom:6,                                  /*initial zoom level of the map*/ 
			latLng:{lat:47.228428, lng:-1.554565},   /*center of map in latitude/longitude */ 
			mtype:'osm',                              /*map type (osm)*/ 
			zoomOnDoubleClick:true 
        };

        /*Construct an instance of MQA.TileMap with the options object*/
        window.map = new MQA.TileMap(options);
       
        //module de controle du zoom
		MQA.withModule('smallzoom', 'mousewheel', function() {
		
			map.addControl(
			  new MQA.SmallZoom(),
			  new MQA.MapCornerPlacement(MQA.MapCorner.TOP_LEFT, new MQA.Size(5,5))
			);
			
			//active le zoom au scroll
			map.enableMouseWheelZoom();
		
		});
		
		//la position de map doit etre absolue pour que la carte s'affiche
		document.getElementById('map').style.position = "absolute";
}

//fonction permettant de reperer le navigateur (msie ou non) et d'adapter la taille en fonction
function setMapSize(){
	//si la fenetre est inferieur a x alors on met la carte en largeur max (typiquement on est sur un smartphone)
	if(window.innerWidth < 769){
		var largeur_a_enlever_a_la_carte = 0;
		var hauteur_a_rajouter_a_la_liste = 50;
	}
	else{
		var largeur_a_enlever_a_la_carte = 300;
		var hauteur_a_rajouter_a_la_liste = 0;
	}
	//si le navigateur est internet explorer
	if (MQA.browser.name == "msie"){
		document.getElementById('map').style.width = document.body.offsetWidth - 20 - largeur_a_enlever_a_la_carte;
		document.getElementById('map').style.height = document.body.offsetHeight - $('#offset').height() - 20;
		alert("Internet Explorer ne permet pas d'afficher les équipes et leur parcours. Utilisez un navigateur plus récent comme Chrome ou Firefox.");
		//meme chose pour la liste
		document.getElementById('userlist').style.height = document.body.offsetHeight - $('#offset').height() - 20;
	} else {
		document.getElementById('map').style.width = window.innerWidth - largeur_a_enlever_a_la_carte;
		document.getElementById('map').style.height = window.innerHeight - $('#offset').height();
		//meme chose pour la liste
		document.getElementById('userlist').style.height = window.innerHeight - $('#offset').height() + hauteur_a_rajouter_a_la_liste;	
	}
	
}