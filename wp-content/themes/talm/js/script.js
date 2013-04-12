$(document).ready(function(){
	//$(".fluxcontent").width($(".tweet").length*$(".tweet").outerWidth(true));
	//$("#flux").css("width", "0%");
    //$("#fluxmenu").css("width", "130px");

	
	$('#screen').serialScroll({
        target:'#sections',
        items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
        prev:'a.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
        next:'a.next',// Selector to the 'next' button (absolute too)
        axis:'x',// The default is 'y' scroll on both ways
        navigation:'#navigation li a',
        duration:700,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
        force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
        
      
        onBefore:function( e, elem, $pane, $items, pos ){
           
            e.preventDefault();
            if( this.blur )
                this.blur(); 
        },
        onAfter:function( elem ){

        }
    });
    
    
    $('#slideshow').serialScroll({
        items:'li',
        prev:'#screen2 a.prev',
        next:'#screen2 a.next',
        offset:-230, //when scrolling to photo, stop 230 before reaching it (from the left)
        start:1, //as we are centering it, start at the 2nd
        duration:1200,
        force:true,
        stop:true,
        lock:false,
        cycle:false, //don't pull back once you reach the end
        easing:'easeOutQuart', //use this easing equation for a funny effect
        jump: true //click on the images to scroll to them
    });
	
	$('.more a').click(function(){
		$('#ajax_content').load($(this).attr('href'));
		
		return false;
	});
		
	/*$("#viewflux").click(function(){
		
		if($("#flux").hasClass("close")){
			$("#flux").removeClass("close").addClass("open");
		}else{
			$("#flux").removeClass("open").addClass("close");
		}
		
		$("#flux.open").animate({
			width:"100%"
		},function(){
			$("#viewflux").addClass("ouvert");
		});
		
		$("#flux.close").animate({
			width:0
		},function(){
			$("#viewflux").removeClass("ouvert");
		});
		
		return false;
	});*/
	

	function makeTall(){  
		//$(this).animate({"height":75},200);
		var tableau_id = $(this).attr("id").split('_');
		var identifiant = "#footer_"+tableau_id[1];
		
		$(identifiant+':not(.inverted) .titre').animate({opacity:0},300, function(){
			$(identifiant+':not(.inverted)').animate({
				top: 130
			},300,function(){
				
			});
		});
		
		
		$(identifiant+'.inverted').animate({
			top: 0
		},300,function(){
			$(identifiant+' .titre').animate({opacity:100},300, function(){
			});
		});
	}

	function makeShort(){ 
		//$(this).animate({"height":50},200);
		var tableau_id = $(this).attr("id").split('_');
		var identifiant = "#footer_"+tableau_id[1];
		
		$(identifiant+':not(.inverted)').animate({
			top: 0
		},300,function(){
			$(identifiant+':not(.inverted) .titre').animate({opacity:100},300, function(){
				
			});
		});
		
		$(identifiant+' .titre').animate({opacity:0},300, function(){
			$(identifiant+'.inverted').animate({
				top: 130
			},300,function(){
				
			});
		});
	}

	

	/*$(".element").mouseenter(function(){
		var tableau_id=$(this).attr("id").split('_');
		var identifiant = "#footer_"+tableau_id[1];

		$(identifiant).animate({
			top: '+=130'
		},300,function(){
			
		});
		
	}).mouseleave(function(){
		var tableau_id=$(this).attr("id").split('_');
		var identifiant = "#footer_"+tableau_id[1];
	    $(identifiant).animate({
			top: '-=130'
		},300,function(){
				
		});
    });*/

	
	/* SCRIPT POUR LA GALLERIE */
	$('.next').click(function(){
		return false;
	});
	
	$('.prev').click(function(){
		return false;
	});
	
	
	// ONGLETS
	
	var hauteur = $(".lien_onglet:first>.content").innerHeight() + 50;

	$(".texte_avec_onglet").css("height", hauteur);

	$(".lien_onglet div.content").css("display", "none");

	$(".texte_avec_onglet aside > ul").find(':first').addClass("actif");

	$(".texte_avec_onglet aside > ul").find(':first div.content').css("display", "block");

	
	$(".lien_onglet").click(function(e){
		e.preventDefault();
		$(".lien_onglet").removeClass("actif");
		$(".lien_onglet div.content").css("display", "none");
		$(this).addClass("actif");
		var tableau_id=$(this).attr("id").split('_');
		var identifiant = "content_onglet_"+tableau_id[1];
		document.getElementById(identifiant).style.display="block";
		//$('.lien_onglet.actif .content').scrollTo('0',500, { axis:"x" });
		hauteur = $("#"+identifiant).innerHeight() + 50;
		$(".texte_avec_onglet").css("height", hauteur);
	});
	
	/*$('.texte_avec_onglet .previous').click(function(){
		$('.lien_onglet.actif .content').scrollTo('-=220',500, { axis:"x" });
		return false;
	});
	
	$('.texte_avec_onglet .next').click(function(){
		$('.lien_onglet.actif .content').scrollTo('+=220',500, { axis:"x" });
		return false;
	});*/
	
	$('.photoslider-mini .sliderkit-panel').mouseenter(function(){
		$(this).find('div.credits').animate({
			bottom: '+=35'
		},300,function(){
			
		});
	});

	$('.photoslider-mini .sliderkit-panel').mouseleave(function(){
		$(this).find('div.credits').animate({
			bottom: '-=35'
		},300,function(){
			
		});
	});
	
	// LOIC
	// on adapte le contenu des éléments du menu
	// en fonction de la largeur de la fenetre
	$('#menu_principal a').each(function(){
		$(this).attr('original_title',$(this).text());
		
		var attr = $(this).attr('title');
		
		if (typeof attr !== 'undefined' && attr !== false) {
			// on ne fait rien si l'attribut title est defini
		}else{
			$(this).attr('title',$(this).text());	
		}
	});

	menuSize();

	overIsotope();
	$(".element:not(.smartphone)").hoverIntent( makeTall, makeShort );
	$(window).resize(function() {
		
		menuSize();
		overIsotope();
		
		$(".element").unbind("mouseenter").unbind("mouseleave");
		$(".element").removeProp('hoverIntent_t');
		$(".element").removeProp('hoverIntent_s');
		
		$(".element:not(.smartphone)").hoverIntent( makeTall, makeShort );
		
		// on adapte la taille des SVG
		$('.hasSVG').each(function(){
			var ratio = $(this).find('svg').attr('ratio',ratio);
			
			newW = $(this).width();
			newH = newW / ratio;
						
			$(this).find('svg').attr('width',newW);
			$(this).find('svg').attr('height',newH);
			
			window.status = newW + ' '+ newH;
		});		


		$('.photoslider-mini .sliderkit-panels .sliderkit-panel').each(function(){
			var decalimage = ($(this).find('img').width() - $('.sliderkit-panels').width())/2;
			if(decalimage<0){
				decalimage=0;
			}
			$(this).find('img').css( 'margin-left',  -decalimage);
		});

		resizePlayerActus();

		$('.image_texte .conteneur_image').each(function(){
			var decalimage = ($(this).find('img').width() - $('.image_texte .conteneur_image').width())/2;
			if(decalimage<0){
				decalimage=0;
			}
			$(this).find('img').css( 'margin-left',  -decalimage);
		});

		$('.texte_image .conteneur_image').each(function(){
			var decalimage = ($(this).find('img').width() - $('.texte_image .conteneur_image').width())/2;
			if(decalimage<0){
				decalimage=0;
			}
			$(this).find('img').css( 'margin-left',  -decalimage);
		});



		hauteur = $(".lien_onglet.actif div.content").innerHeight() + 50;
		$(".texte_avec_onglet").css("height", hauteur);

		/*$('article.image_texte .conteneur_image a').each(function(){
			var decalimage = ($(this).find('img').width() - $('article.image_texte .conteneur_image').width())/2;
			$(this).find('img').css( 'margin-left',  -decalimage);
		});*/

		var $container = $('#container');
		
		$container.isotope({
			itemSelector: '.element'
		});
		
		//console.log($(document).width());
	});
});

function menuSize(){
	var largeur = $(window).width();
		
	if (largeur <= 550) {
		
		$('#menu_principal a').each(function(){
			$(this).text( $(this).attr('title') );
		});
		
	}else{
		
		$('#menu_principal a').each(function(){
			$(this).text( $(this).attr('original_title') );
		});
		
	}
}

function resizePlayerActus(){
	var largeur = $(window).width();
		
	if (largeur <= 550) {
		$('.contentslider-std .conteneur_image_slider').each(function(){
			var decalimage = ($(this).find('img').width() - $('.conteneur_image_slider').width())/2;
			if(decalimage<0){
				decalimage=0;
			}
			$(this).find('img').css( 'margin-left',  0);
		});
		
		$('.element .inverted').css('top',0);
		$('.element .inverted .titre').css('opacity',100);
		
	}else{
		$('.contentslider-std .conteneur_image_slider').each(function(){
			var decalimage = ($(this).find('img').width() - $('.conteneur_image_slider').width())/2;
			if(decalimage<0){
				decalimage=0;
			}
			$(this).find('img').css( 'margin-left',  -decalimage);
		});
		
		$('.element .inverted').css('top',130);
		$('.element .inverted .titre').css('opacity',0);
	}
}



function overIsotope(){
	var largeur = $(window).width();
		
	if (largeur <= 550) {
		$('.element').each(function(){
			$(this).addClass('smartphone');
		});
		
	}else{
		$('.element').each(function(){
			$(this).removeClass('smartphone');
		});
	}
	
}

$(window).load(function(){
	$(".contentslider-std").sliderkit({
        auto:1,
        autospeed:15000,
        panelfxspeed:2000,
        tabs:1,
        circular:1,
        panelfx:"sliding",
        panelfxfirst:"fading",
        panelfxeasing:"easeInOutExpo",
        fastchange:0,
        keyboard:0
    });

    $(".carousel-timeline").sliderkit({
        auto:0,
        shownavitems:6,
        scroll:1,
        mousewheel:true,
        circular:false,
        start:2
    });

    $(".photoslider-mini").sliderkit({
		auto:true,
		autospeed:15000,
		panelfxspeed:2000,
		panelfxeasing:"easeInOutExpo",
		panelbtnshover:true,
		circular:true,
		fastchange:false
	});
	
	
	//$(".fluxcontent").width($(".tweet").length*$(".tweet").outerWidth(true));
	//$("#flux").css("width", "0%");
    //$("#fluxmenu").css("width", "130px");
});



$(function($){
	var $container = $('#container');
	
	$container.isotope({
		itemSelector: '.element'
	});
	
	var $optionSets = $('#options .option-set'),
		$optionLinks = $optionSets.find('a');
	
	$optionLinks.click(function(){
		var $this = $(this);
		// don't proceed if already selected
		if ( $this.hasClass('selected') ) {
			return false;
		}
		var $optionSet = $this.parents('.option-set');
		$optionSet.find('.selected').removeClass('selected');
		$this.addClass('selected');
	
		// make option object dynamically, i.e. { filter: '.my-filter-class' }
		var options = {},
			key = $optionSet.attr('data-option-key'),
			value = $this.attr('data-option-value');
		// parse 'false' as false boolean
		value = value === 'false' ? false : value;
		options[ key ] = value;
		if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			// changes in layout modes need extra logic
			changeLayoutMode( $this, options )
		} else {
			// otherwise, apply new options
			$container.isotope( options );
		}
		return false;
	});
});


// Easing equation, borrowed from jQuery easing plugin
// http://gsgd.co.uk/sandbox/jquery/easing/
jQuery.easing.easeOutQuart = function (x, t, b, c, d) {
	return -c * ((t=t/d-1)*t*t*t - 1) + b;
};