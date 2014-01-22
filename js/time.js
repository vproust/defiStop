////////////*FONCTION DE TEMPS*////////////
//fonction qui renvoie "il y a " + le temps ecoulé entre maintenant et la date passée en parametre sous la forme aaaa-mm-jj hh-mm-ss
function func_il_y_a(heure){
	if(heure==null){
		return "jamais actualisé";
	}
	//on recupere l'heure actuelle et on la met au bon format
	var time_now=new Date().getTime();
	var time_now_format = new Date(time_now);
	
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