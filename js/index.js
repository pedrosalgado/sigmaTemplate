// Temp avant lequel on démarre le scroll
var timeBeforeScroll = 800;

// Vitesses
// Vitesse de scroll
var scrollSpeed = 700;

// Vitesse de disparition du logo
var opacityHideLogo = 1000;

// Vitesse d'apparition de la div de texte
var opacityShowMsg = 500;

// Vitesse de déplacement du menu
var menuSpeed = 800;

// Vitesse d'arrivée du blog link
var blogLinkShowSpeed = 1500;

// Vitesse de départ du blog link
var blogLinkHideSpeed = 250;

// Effets
// Effets du scroll
var scrollEffect = "easeInOutExpo";

// Effets du menu
var menuEffect = "easeOutExpo";

// Effets d'arrivée du blog link
var blogLinkShowEffect = "easeOutCubic";

// Effets de départ du blog link
var blogLinkHideEffect = "easeOutCirc";

// Délais appartion/disparition des clients
var iDelayShowClient = 3300;
var iDelayHideClient = 5200;

// On se souvient de la page précédente
var iOldIdPage;
var iStartIdPage;

// Si passé a true, on bloque l'apparition/disparition des tetes
var aQueueFreezeAnim = new Array();

// Si on a inversé les têtes et les clients
var bInvert = false;

// Si on ne montre que les clients finaux
var bJustFinalClients = false;

// Liste des images de têtes existante
var aHeadsPictures = new Array(
	'big_head_long_blue.jpg',
	'big_head_long_orange.jpg',
	'big_head_long_pink.jpg',
	'big_head_long_yellow.jpg',
	'big_head_short_blue.jpg',
	'big_head_short_green.jpg',
	'big_head_short_pink.jpg',
	'big_head_short_red.jpg'
);

// Queue pour les images Client et Têtes
var aQueueClientsPicture = new Array();

$(document).ready(function(){
	// Transparence des PNG sous IE6
	$(document).pngFix();
	
	// On cache le menu
	$("#divMenu").css({
		top:-$("#divMenu").height()-20,
		left:-$("#divMenu").width()-20
	});
	
	// On check si on a une ancre
	curUrl = document.location.toString();
	if (curUrl.match('#')) {
		curAnchor = '#' + curUrl.split('#')[1];
		
		// On défini l'id de page en cours selon l'ancre
		setCurIdPageFromAnchor(curAnchor);
	}
	
	// On place les pages au milieu de leur backgroung
	$(window).load(function(){
		$("DIV.page").each(function(){
			// On recuper son id
			pageId = this.id.slice(5);

			// On recupere les coordonées du background correspondant
			bgTop = $("#page_bg_"+pageId).offset().top;
			bgLeft = $("#page_bg_"+pageId).offset().left;
			bgWidth = $("#page_bg_"+pageId).width();
			bgHeight = $("#page_bg_"+pageId).height();

			// On défini la position de la page
			pageTop = bgTop+(bgHeight/2)-($(this).height()/2);
			pageLeft = bgLeft+(bgWidth/2)-($(this).width()/2);
			
			// On place la page
			$(this).css({
				top:pageTop,
				left:pageLeft,
				display:"block"
			})
		});
			
		// Variable contenant le lien clické
		curClickedLink = "";
		
		// On boucle sur les liens
		$("A").each(function(){
		
				// Si le lien a une class btn_page, on change son lien et son événement de click
				if($(this).hasClass("btn_page_"+pageIdForWho) || $(this).hasClass("btn_page_"+pageIdForContact) || $(this).hasClass("btn_page_"+pageIdForWork) || $(this).hasClass("btn_page_"+pageIdForClient))
				{
					// On change l'url du lien
					$(this).attr("old_href", $(this).attr("href"));
					$(this).attr("href", "#"+$(this).attr("href").substring(baseURL.length+1));			
					
					$(this).click(function(event){
						// On ajoute l'url au stats google
						urlForGoogle = $(this).attr("old_href").substring(baseURL.length);
						pageTracker._trackPageview(urlForGoogle);
						
						// On recupere l'id de la page sur laquelle aller
						if($(this).hasClass("btn_page_"+pageIdForWho))
							curPageId = pageIdForWho;
						else if($(this).hasClass("btn_page_"+pageIdForContact))
							curPageId = pageIdForContact;
						else if($(this).hasClass("btn_page_"+pageIdForWork))
							curPageId = pageIdForWork;
						else if($(this).hasClass("btn_page_"+pageIdForClient))
							curPageId = pageIdForClient;
						
						// On bouge
						goToPage();
						
						// On empêche le click d'avoir lieu				
						if(bAnchorNav == "false")
							event.preventDefault();				
					});
				}
		});
	});
	
	$(window).resize(function(){
		// laisse un petit délais pour appeler la fonction une fois le resize fini
	    delay(function(){
	    	goToPage();
	    }, 500);
	});

	// On liste les clients directs
	for(var iClientDirect in aClientsPictures)
	{
		iIndexClientDirect = aClientsPictures[iClientDirect].length - 1;
		
		// On récupere le nom du client (Pour le alt et si jamais on veux mettre un titre)
		sClientDirectPicture = aClientsPictures[iClientDirect][iIndexClientDirect];
		sClientDirectName = sClientDirectPicture.substr(0, sClientDirectPicture.length-4);

		// On ajoute le client direct a la page
		// Si c'est une agence (avec sous-clients)
		if(iIndexClientDirect > 0){
			//alert(sClientDirectName+"  "+iClientDirect);
			// On ajoute les agences a la page
			$('.page.clients #list_agences').append('<img id="agence_'+sClientDirectName+'" class="client link" alt="'+sClientDirectName+'" src="img/clients/'+sClientDirectName+'_small.jpg">');
		// Sinon c'est un client direct
		}else{
			// EXEPTION, DDB n'as pas de sous clients mais c'est une agence
			if(sClientDirectName == "ddb_ciel_terre"){
				$('.page.clients #list_agences').append('<img class="client" alt="'+sClientDirectName+'" src="img/clients/'+sClientDirectName+'_small.jpg">');
			}else{
				$('.page.clients #list_clients').append('<img class="client" alt="'+sClientDirectName+'" src="img/clients/'+sClientDirectName+'_small.jpg">');
			}
		}
	}
	
	// Au clic du bouton "ShowAll", on affiche tous les clients
	$('#button_switch_client').bind('click', function(){
		showAllClients();
	});
	
	// Au clic des agences, on affiche les clients
	$('.page.clients #list_agences .client.link').bind('click', function(){
		// On récupere le nom de l'agence pour le passer en parametre
		sAgenceName = $(this).attr('id');
		sPrefix = 'agence_';
		sAgenceName = sAgenceName.substr(sPrefix.length);
		
		showFinalClients(sAgenceName);
	});
});
$(window).load(function(){

	// On met les infos de contact (caché pour éviter que les bot ne les récupère)
	$("#contact_info_only_js").html("01.83.62.02.89<br><a href='mailto:contact@jandk.fr'>contact@jandk.fr</a>");
	
	setTimeout(function(){
		goToPage();
		}, timeBeforeScroll);
	
	setInterval("showClients()", iDelayShowClient);
});

function goToPage()
{
	pageId = "#page_"+curPageId;
	
	// Si ce n'est pas la premiere fois que l'on arrive, et que c'est pas la page ou on était déjà
	if(iOldIdPage != undefined && iOldIdPage != curPageId){
		// Réinitialise le Bg
		initBG(curPageId);
	}
	
	// On recupère les coordonées de la page
	topLeftPositionTop = $(pageId).offset().top;
	topLeftPositionLeft = $(pageId).offset().left;

	/* Pour éviter que le menu ne se supperpose au contenu, 
	 * la différence entre la position "centrale" et la position "coin en haut à gauche" 
	 * ne peut être inférieur à un certain nombre
	 */

	// On determine la position centrale
	centralPositionTop = topLeftPositionTop - $(window).height()/2 + $(pageId).height()/2;
	centralPositionLeft = topLeftPositionLeft - $(window).width()/2 + $(pageId).width()/2;

	// Si le top est inférieur à la position de sécurité, on le remplace
	if(topLeftPositionTop-centralPositionTop < 120)
		finalPositionTop = topLeftPositionTop-120;
	else
		finalPositionTop = centralPositionTop;

	// Si le left est inférieur à la position de sécurité, on le remplace
	if(topLeftPositionLeft-centralPositionLeft < 350)
		finalPositionLeft = topLeftPositionLeft-350;
	else
		finalPositionLeft = centralPositionLeft;

	$('body').animate({
		scrollTop: finalPositionTop,
		scrollLeft: finalPositionLeft
		}, scrollSpeed, scrollEffect, function(){
		setMenuPosition(pageId);
	});
	
	// On se souvien de cette page
	iOldIdPage = curPageId;
}

function addGoogleTrackPageView()
{
	curUrlAnchor = "/"+$("A.btn_page_"+curPageId).attr("href");

	pageTracker._trackPageview(curUrlAnchor);
}

function showMsg(divId)
{
	$(divId).animate({
		opacity:0.1
		}, opacityHideLogo, "swing", function(){
			// On recupère les coordonées de la div en cours
			divOffsetTop = $(divId).offset().top();
			divOffsetLeft = $(divId).offset().left();

			// On recupère la taille du message
			textHeight = $("#divMsg > SPAN").outerHeight();

			// On recupère la différence avec la taille de la div en cours
			difToCurDiv = $(divId).outerHeight()-textHeight;

			// On place la div du message
			$("#divMsg").css({
				top:(divOffsetTop+difToCurDiv/2),
				left:divOffsetLeft
				});
				
			$("#divMsg").animate({
				opacity:1
				}, opacityShowMsg)
		});
}

function setMenuPosition(divId)
{
	// Page en cours
	pageId = "#page_"+curPageId;

	// On recupere la position du contenu de la page
	pagePositionTop = $(pageId).offset().top;
	pagePositionLeft = $(pageId).offset().left;

	// Taille du menu
	menuWidth = $("#divMenu").outerWidth();
	menuHeight = $("#divMenu").css("height");
	menuHeight = menuHeight.substr(0, menuHeight.length-2);

	// On place le menu en fonction de la position du contenu
	menuPositionTop = pagePositionTop-menuHeight+85;
	menuPositionLeft = pagePositionLeft-menuWidth-120;

	$("#divMenu").animate({
		top: menuPositionTop,
		left: menuPositionLeft
	},menuSpeed, menuEffect, function(){
		showBlogLink(divId);
	});
}

function setCurIdPageFromAnchor(sAnchor)
{
	switch(sAnchor)
	{
		case "#qui_sont_jackson_and_kent":
			curPageId = pageIdForWho;
			break;
			
		case "#contacter_jackson_and_kent":
			curPageId = pageIdForContact;
			break;

		case "#travailler_pour_jackson_and_kent":
			curPageId = pageIdForWork;
			break;
			
		case "#les_clients_de_jackson_and_kent":
			curPageId = pageIdForClient;
			break;
	}
}


/*--
--FONCTIONS DU MENU
--*/
function initMenu(){
	switch(curPageId)
	{
		case 1:
			$("#img_who").attr("src", "img/menu_bulle_who_on.png");
			break;
			
		case 2:
			$("#img_work").attr("src", "img/menu_bulle_work_on.png");
			break;

		case 3:
			$("#img_contact").attr("src", "img/menu_bulle_contact_on.png");
			break;
			
		case 5:
			$("#img_client").attr("src", "img/menu_bulle_contact_on.png");
			break;	
	}
}

function clearAllmenu(){
	$("#img_who").attr("src", "img/menu_bulle_who.png");
	$("#img_contact").attr("src", "img/menu_bulle_contact.png");
	$("#img_work").attr("src", "img/menu_bulle_work.png");
	$("#img_client").attr("src", "img/menu_bulle_work.png");
}

function switchMenu(idMenu){
	switch(idMenu)
	{
		case 'who':
			clearAllmenu();
			setTimeout('$("#img_who").attr("src", "img/menu_bulle_who_on.png")', 150);
			break;
			
		case 'contact':
			clearAllmenu();
			setTimeout('$("#img_contact").attr("src", "img/menu_bulle_contact_on.png")', 150);
			break;

		case 'work':
			clearAllmenu();
			setTimeout('$("#img_work").attr("src", "img/menu_bulle_work_on.png")', 150);
			break;
			
		case 'client':
			clearAllmenu();
			setTimeout('$("#img_client").attr("src", "img/menu_bulle_work_on.png")', 150);
			break;
	}
}

function rollMenu(idMenu, idEtat){
	switch(curPageId){
		case 1:
			activeMenu = "who";
			break;
		
		case 2:
			activeMenu = "work";
			break;

		case 3:
			activeMenu = "contact";
			break;
			
		case 5:
			activeMenu = "client";
			break;
	}
	
	switch(idEtat){
		case 'over':
			$("#img_"+idMenu).attr("src", "img/menu_bulle_"+idMenu+"_on.png");
			break;
			
		case 'out':
			if(activeMenu == idMenu)
				$("#img_"+idMenu).attr("src", "img/menu_bulle_"+idMenu+"_on.png");
			else
				$("#img_"+idMenu).attr("src", "img/menu_bulle_"+idMenu+".png");
			break;
	}
}

function showBlogLink(pageId){
	// Position de la page en cours
	curPageTop = $(pageId).offset().top;
	curPageLeft = $(pageId).offset().left;

	// Dimensions de la page en cours
	curPageWidth = $(pageId).outerWidth();

	// Position de début du blog link
	blogLinkStartTop = 0-$("#blog_link").outerHeight()-50;
	blogLinkStartLeft = curPageLeft+curPageWidth-20;

	// On le positionne au départ
	$("#blog_link").css({
		'top':blogLinkStartTop,
		'left':blogLinkStartLeft
	});
	
	// On l'affiche
	$("#blog_link").show();
	
	// Position de fin du blog link
	blogLinkEndTop = curPageTop-50;
	blogLinkEndLeft = curPageLeft+curPageWidth-20;

	// On affiche le blog link
	$("#blog_link").animate({
		'top':blogLinkEndTop,
		'left':blogLinkEndLeft
	}, blogLinkShowSpeed, blogLinkShowEffect, "");
}

function hideBlogLink(pageId){
	// Position de la page en cours
	curPageTop = $(pageId).offset().top;
	curPageLeft = $(pageId).offset().left;

	// Dimensions de la page en cours
	curPageWidth = $(pageId).outerWidth();

	// Position de fin du blog link
	blogLinkEndTop = 0-$("#blog_link").outerHeight()-50;
	blogLinkEndLeft = curPageLeft+curPageWidth-20;

	// On affiche le blog link
	$("#blog_link").animate({
		'top':blogLinkEndTop,
		'left':blogLinkEndLeft
	}, blogLinkHideSpeed, blogLinkHideEffect, "");
}

/**
 * On affiche le client
 * @param bInvert -- True si on est en mode ShowAllClient => Inverse etat client/Tête
 * @param curDiv
 * @param sCurImageClient
 * @param bShowAllEnCour
 * @return
 */
function showClients(curNoDiv, sCurImageClient, bShowAllEnCour)
{
	// Si la queue des images est vide, on la recréé
	if(aQueueClientsPicture.length == 0){
		if(bInvert == true || (!bShowAllEnCour && bJustFinalClients == true))
			aQueuePictures = aHeadsPictures;
		else
			aQueuePictures = aAllClientsPictures;
		for (var i = 0; i < aQueuePictures.length; i++){
			aQueueClientsPicture[i] = aQueuePictures[i];
		}
		aQueueClientsPicture  = shuffleArray(aQueueClientsPicture);
	}
	// On execute si on a pas bloqué avec le bouton ShowAll
	if(aQueueFreezeAnim.length == 0 || bShowAllEnCour==true)
	{
		// Page en cours
		if(bShowAllEnCour == true)
			pageBgId = "#page_bg_"+iStartIdPage;
		else
			pageBgId = "#page_bg_"+curPageId;
		
		// Choisit une image au hasard sauf si on l'a déjà passé en parametre (cas des "showFinalClient")
		if(!sCurImageClient){
			if(bInvert == true || (!bShowAllEnCour && bJustFinalClients == true)){
				sCurImageClient	= 'img/'+aQueueClientsPicture.pop();
			}else
				sCurImageClient	= 'img/clients/'+aQueueClientsPicture.pop();
		}
		// On recupère le nombre de div de logos dans cette page
		curNbrPageBackgroundDiv = $(pageBgId+" DIV:not(.logoClient)").length;
		
		// Si on a pas indiquer de div, on en séléctionne une au hasard, sinon toutes
		if(curNoDiv){
			curDiv = $(pageBgId+" DIV:eq("+curNoDiv+")");
		}else{
			curNoDiv = Math.round(Math.random()*(curNbrPageBackgroundDiv-1));
			curDiv = $(pageBgId+" DIV:not(.logoClient):eq("+curNoDiv+")");
		}
		
		// récupère l'image précédente
		curHeadPicture	= curDiv.css("background-image");
	
		// On cache
		finalHeight = curDiv.height();
		finalWidth = curDiv.width();
		$(this).css("background-position", '35px -210px');
		// Si on n'est pas en train de faire l'anim ShowAll
		if(bShowAllEnCour != true)
			curDiv.addClass("logoClient");
		$(curDiv).animate({
			backgroundPosition: "35px -210px"
		}, 700, "easeInCirc", function(){
			$(this).css("background-image", 'url("'+sCurImageClient+'")');
			$(this).css("background-repeat", 'no-repeat');
			$(this).css("background-position", '35px -210px');

			// On affiche
			setTimeout("animateShowClient('"+pageBgId+"', '"+$(this).parent().children().index(this)+"', '"+curHeadPicture+"')", 500);
		});
	}
}
function animateShowClient(pageBgId, iDivIndex, curHeadPicture)
{
	// On récupere la div courante
	curDiv = $(pageBgId+" DIV:eq("+iDivIndex+")");
	
	// On affiche
	curDiv.animate({
		backgroundPosition: "35px 35px"
	}, 700, "easeOutCirc", function(){
		setTimeout("removeClient('"+pageBgId+"', '"+iDivIndex+"', '"+curHeadPicture+"')", iDelayHideClient);
	});
}
/**
 * On Supprime le client
 * @param pageBgId
 * @param curNoDiv
 * @param sHeadPicture
 * @return
 */
function removeClient(pageBgId, curNoDiv, sHeadPicture)
{
	// Si l'anim n'est pas bloquée ("showAllClients" en cours)
	if(aQueueFreezeAnim.length == 0)
	{
		// Page en cours
		pageBgId = "#page_bg_"+curPageId;
		// Div en cours
		curDiv = $(pageBgId+" DIV:eq("+curNoDiv+")");

		// On cache
		finalHeight = curDiv.height();
		finalWidth = curDiv.width();
		$(this).css("background-position", '35px 35px');
		$(curDiv).animate({
			backgroundPosition: "35px -210px"
		}, 700, "easeInCirc", function(){
			$(this).css("background-image", sHeadPicture);
			$(this).css("background-repeat", 'no-repeat');
			$(this).css("background-position", '35px -210px');

			// On affiche
			setTimeout("animateRemoveClient('"+pageBgId+"', '"+$(this).parent().children().index(this)+"')", 500);
			
		});
	}else{
		// Si l'anim est bloquée et qu'on est à la dernière div du "ShowAll", on débloque les animations.
		if(aQueueFreezeAnim.length > 0 && curNoDiv == $(pageBgId+" DIV").length - 1){
			aQueueFreezeAnim.pop();
			// On vide le tableau d'image
			aQueueClientsPicture = new Array();
		}
	}
}
function animateRemoveClient(pageBgId, iDivIndex)
{
	// On récupere la div courante et on affiche l'image
	curDiv = $(pageBgId+" DIV:eq("+iDivIndex+")");
	curDiv.animate({
		backgroundPosition: "35px 35px"
	}, 700, "easeOutCirc", function(){
		$(this).removeClass("logoClient");
	});
}


function showAllClients(aQueuePictures)
{
	// On se souvient de la page ou on était quand on a lancé l'annimation
	iStartIdPage = curPageId;
	
	// On bloque la fonction showClient / removeClient
	aQueueFreezeAnim.push(true);
	bJustFinalClients = false;
	
	// Si le paramètre aQueuePictures existe, c'est que l'on ne montre que les clients finaux
	if(aQueuePictures){
		bJustFinalClients = true;
	}else{
		// Change le bouton
		if($("#button_switch_client #show_clients_on").hasClass("hidden") == true){
			$("#button_switch_client #show_clients_on").removeClass("hidden");
			$("#button_switch_client #show_clients_off").addClass("hidden");
		}else{
			$("#button_switch_client #show_clients_on").addClass("hidden");
			$("#button_switch_client #show_clients_off").removeClass("hidden");
		}
		// On interverti client/têtes
		bInvert = !bInvert;
	}
	
	// Instancie la liste des images
	aQueueClientsPicture = new Array();
	
	// Page en cours
	pageBgId = "#page_bg_"+curPageId;
	
	// Création d'un compteur pour le délais de l'animation
	iCountDelay = 1000;
	
	// On change toutes les div
	$(pageBgId+" DIV").each(function(index)
	{
		$(this).removeClass("logoClient");
		// Si la queue des images est vide, on la recrée
		if(aQueueClientsPicture.length == 0){
			// Si on veux tous les clients ou les têtes
			if(bJustFinalClients == false){
				if(bInvert)
					aQueuePictures = aAllClientsPictures;
				else
					aQueuePictures = aHeadsPictures;
			}
			for (var i = 0; i < aQueuePictures.length; i++){
				aQueueClientsPicture[i] = aQueuePictures[i];
			}
			aQueueClientsPicture	= shuffleArray(aQueueClientsPicture);
		}
		// Choisit une image au hasard
		if(bInvert == true || bJustFinalClients == true){
			sCurImageClient	= 'img/clients/'+aQueueClientsPicture.pop();
		}else{
			sCurImageClient	= 'img/'+aQueueClientsPicture.pop();
		}
		
		// On affiche le client (en forçant les bons paramètres)
		setTimeout("showClients('"+$(this).parent().children().index(this)+"', '"+sCurImageClient+"', true)", iCountDelay);
		// on incrémente le conteur pour le délay
		iCountDelay += 50;
	});
}

/**
 * Remplace le BG par les clients finaux
 * @param iClientDirect
 * @return
 */
function showFinalClients(sAgenceName)
{
	// On garde que les clients fiaux (le tableau contient également les clients direct)
	aFinalClientsPictures = new Array();
	
	for (var i = 0; i < aClientsPictures[sAgenceName+".jpg"].length - 1; i++){
		aFinalClientsPictures[i] = sAgenceName+'-'+aClientsPictures[sAgenceName+".jpg"][i];
	}
	
	// Si ce client direct à des clients finaux, on affiche
	if(aFinalClientsPictures.length > 0){
		showAllClients(aFinalClientsPictures);
	}
}

/**
 * Réinitialise le BG avec toutes les têtes (Pour le changement de page)
 * @param iPageBgId - id de la page en cours ex: #page_bg_1
 * @return
 */
function initBG(iPageBgId)
{
	// Réinitialise les variables
	aQueueClientsPicture = new Array();
	sPageBgId = '#page_bg_'+iPageBgId;
	
	// On change toutes les div
	$(sPageBgId+" DIV").each(function(index)
	{
		$(this).removeClass("logoClient");
		// Si la queue des images est vide, on la recrée
		if(aQueueClientsPicture.length == 0){
			// Séléctionne la bonne liste d'image
			if(bInvert)
				aQueuePictures = aAllClientsPictures;
			else
				aQueuePictures = aHeadsPictures;
			
			for (var i = 0; i < aQueuePictures.length; i++){
				aQueueClientsPicture[i] = aQueuePictures[i];
			}
			aQueueClientsPicture	= shuffleArray(aQueueClientsPicture);
		}
		// Choisit une image au hasard
		if(bInvert == true)
			sCurImageClient	= 'img/clients/'+aQueueClientsPicture.pop();
		else
			sCurImageClient	= 'img/'+aQueueClientsPicture.pop();

		curDiv = $(sPageBgId+" DIV:eq("+index+")");
		
		// On met la bonne image
		$(this).css("background-image", 'url("'+sCurImageClient+'")');
		$(this).css("background-repeat", 'no-repeat');
		$(this).css("background-position", '35px 35px');
	});
}

// Délais pour ne pas surcharger la fonction resize du browser
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

// Fonction permetant de mélanger des tableau
function shuffleArray(o){ //v1.0
	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
};
