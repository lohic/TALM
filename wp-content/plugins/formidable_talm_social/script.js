/* SCRIPT TALM SOCIAL */
$(document).ready(function(){
	$(".fluxcontent ul").width($(".social_item").length*$(".social_item").outerWidth(true));
	//$("#flux").css("width", "0%");
   	//$("#fluxmenu").css("width", "130px");
	
	//$('#viewflux').hide();
	
	$("#viewflux").click(function(e){
		e.preventDefault();
		if($("#flux").hasClass("close")){
			$("#flux").removeClass("close").addClass("open");
			$('.fluxselect').removeClass('actif');
			$('.fluxcontent').load( $(this).attr('href') , function(){
				$(".fluxcontent ul").width($(".social_item").length*$(".social_item").outerWidth(true));
				
				if($("#flux").hasClass("close")){
					$("#flux").removeClass("close").addClass("open");
				}
				
				$("#flux.open").animate({
					width:"100%"
				},function(){
					$("#viewflux").addClass("actif");
					$("#flux_facebook").addClass("actif");
					$('.fluxcontent').serialScroll({
						items:'li',
						prev:'#flux .nav-prev a',
						next:'#flux .nav-next a',
						duration:1200,
						force:true,
						cycle:false, //don't pull back once you reach the end
						easing:'easeOutQuart', //use this easing equation for a funny effect
					});
				});
			});
		}else{
			$("#flux").removeClass("open").addClass("close");
			$("#flux.close").animate({
				width:0
			},function(){
				$("#viewflux").removeClass("actif");
				$('.fluxselect').removeClass('actif');
			});
		}
	});
	
	$('.fluxselect').click(function(e){
		e.preventDefault();
		$('.fluxselect').removeClass('actif');
		$(this).addClass('actif');
		$('#viewflux').show();
		
		//alert($(this).attr('href'));
		
		$('.fluxcontent').load( $(this).attr('href') , function(){
			$(".fluxcontent ul").width($(".social_item").length*$(".social_item").outerWidth(true));
			
			if($("#flux").hasClass("close")){
				$("#flux").removeClass("close").addClass("open");
			}
			
			$("#flux.open").animate({
				width:"100%"
			},function(){
				$("#viewflux").addClass("actif");
				$('.fluxcontent').serialScroll({
					items:'li',
						prev:'#flux .nav-prev a',
						next:'#flux .nav-next a',
						duration:1200,
						force:true,
						cycle:false, //don't pull back once you reach the end
						easing:'easeOutQuart', //use this easing equation for a funny effect
				});
			});
		});
	});	
});

$(window).load(function(){
	$(".fluxcontent ul").width($(".social_item").length*$(".social_item").outerWidth(true));
	$("#flux").css("width", "0%");

	$('.fluxcontent').serialScroll({
		items:'li',
						prev:'#flux .nav-prev a',
						next:'#flux .nav-next a',
						duration:1200,
						force:true,
						cycle:false, //don't pull back once you reach the end
						easing:'easeOutQuart', //use this easing equation for a funny effect
	});

    //$("#fluxmenu").css("width", "130px");
});
