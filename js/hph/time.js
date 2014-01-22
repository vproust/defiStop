////////////*FONCTION DE TEMPS*////////////
//variables globales de temps
var timestamp_debut_course = 1365174000;
var timestamp_fin_course = 1365368400;
var fake_current_time = 1365174000;

//FONCTION DE TEMPS
function timestamp_to_date(unix_timestamp){
	var date = new Date(unix_timestamp*1000);
	var hours = date.getHours();
	var hours_modulo = hours%24;
	var date = date.getDate();
	//vendredi
	switch (date){
		case 5:
			var day_display = "Vendredi";
			break;
		case 6:
			var day_display = "Samedi";
			break;
		case 7:
			var day_display = "Dimanche";
			break;
	}
	document.getElementById("date-heure").innerHTML = day_display +" "+ hours_modulo+"h";
}

//FONCTION DE MODIFICATION DU TEMPS
//fonction appelée lors du clic sur le bouton moins qui diminue le temps de 1 heure et actualise les positions en fonction
function fake_time_minus(){
	//si la fausse heure n'est pas inférieure à l'heure de départ
	if(fake_current_time>timestamp_debut_course){
		//on enlève 1 heure à la fausse heure
		fake_current_time = fake_current_time - 3600;
		//on change l'affichage de la fausse date/heure sur la page
		timestamp_to_date(fake_current_time);
		//on affiche toutes les dernieres positions et leur parcours
		display_all_teams();
		//on actualise le classement
		get_teams_sorted()
	}
}

//fonction appelée lors du clic sur le bouton plus qui augmente le temps de 1 heure et actualise les positions en fonction
function fake_time_plus(){
	//si la fausse heure n'est pas supérieure à l'heure de départ
	if(fake_current_time<timestamp_fin_course){
		//on ajoute 1 heure à la fausse heure
		fake_current_time = fake_current_time + 3600;
		//on change l'affichage de la fausse date/heure sur la page
		timestamp_to_date(fake_current_time);
		//on affiche toutes les dernieres positions et leur parcours
		display_all_teams();
		//on actualise le classement
		get_teams_sorted();
	}
}

//fonction qui renvoie "il y a " + le temps ecoulé entre le fake_current_time et la date passée en parametre sous la forme aaaa-mm-jj hh-mm-ss
function func_il_y_a(heure){
	if(heure==null){
		return "jamais actualisé";
	}
	//on recupere la fausse heure actuelle et on la met au bon format
	var time_now_format = new Date(fake_current_time*1000);
	
	//on met l'heure de la maj position au bon format
	var date_maj = new Date(heure*1000);

	//on calcule la difference de temps entre les 2 dates
	diff = dateDiff(date_maj, time_now_format);
	
	var il_y_a = "il y a ";
	
	//si il y a plus d'un jour
	if(diff.day>0){
		il_y_a=il_y_a+diff.day+" j";
	}
	//sinon si il y a plus d'une heure
	else if(diff.hour>0){
		il_y_a=il_y_a+diff.hour+" h";
	}
	//sinon si il y a plus d'une minute
	else if(diff.min>0){
		il_y_a=il_y_a+diff.min+" min";
	}
	//si il y a moins d'une minute
	else{
		il_y_a=il_y_a+"quelques secondes";
	}
	return il_y_a;
}

//fonction permettant de caluler la difference entre une date donnee et l'heure actuelle
function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;
 
    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
 
    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes
 
    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
     
    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;
     
    return diff;
}