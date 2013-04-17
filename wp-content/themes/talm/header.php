<!DOCTYPE HTML>
<html>
<head>
 
	<title><?php bloginfo('name') ?><?php if ( is_404() ) : ?> &raquo; <?php _e('Not Found') ?><?php elseif ( is_home() ) : ?> &raquo; <?php bloginfo('description') ?><?php else : ?><?php wp_title() ?><?php endif ?></title>
 
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="viewport" content="width=device-width, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/sliderkit-core.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/style_isotope.css" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /><?php wp_head(); ?>
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png" />
    <link rel="apple-touch-icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon-iphone.png"/>
 
	<?php wp_get_archives('type=monthly&format=link'); ?> 
	
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/html5shiv.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.serialScroll-min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.easing.1.3.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.sliderkit.1.9.2.pack.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/isotope.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.hoverIntent.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/script.js"></script>

	<script type="text/javascript" src="http://use.typekit.com/ndt5wdq.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<?php //comments_popup_script(); // off by default ?>
	
	<?php wp_head(); ?>
</head>
<body class="<?php echo getBlogSlug();?>">


<div id="page" class="">
	<ul id="liste-ecole">
        <?php if(get_field('url_tours', 'option')!='' ){?><li><span class="tours"></span><a href="<?php the_field('url_tours', 'option');?>" target="_blank" class="lien_tours">TOURS</a></li><?php } ?>
        <?php if(get_field('url_angers', 'option')!='' ){?><li><span class="angers"></span><a href="<?php the_field('url_angers', 'option');?>" target="_blank" class="lien_angers">ANGERS</a></li><?php } ?>
        <?php if(get_field('url_le_mans', 'option')!='' ){?><li><span class="lemans"></span><a href="<?php the_field('url_le_mans', 'option');?>" target="_blank" class="lien_lemans">LE MANS</a></li><?php } ?>
    </ul>
	<div id="header">
        <div class="left">
        </div>
    	<div class="right">
    		<h1><a href="<?php bloginfo( 'url' )?>"><img src="<?php  echo get_stylesheet_directory_uri();//bloginfo( 'template_url' ); ?>/img/logo.png" alt="logo TALM" id="logo"/><img src="<?php  echo get_stylesheet_directory_uri(); ?>/img/logo_villes.png" alt="logo TALM" id="logo_villes"/></a></h1>
            <nav id="menu_principal">
            	<?php
				if ( has_nav_menu( 'main_menu_gauche' ) ) {
					wp_nav_menu( array('theme_location'=>'main_menu_gauche', 'container' => 'false', 'menu_id' => 'menu_1', 'menu_class'=>'colonne','fallback_cb'=>false));
				}
				?>
            	<?php
				if ( has_nav_menu( 'main_menu_droite' ) ) {
					wp_nav_menu( array('theme_location'=>'main_menu_droite', 'container' => 'false', 'menu_id' => 'menu_2', 'menu_class'=>'colonne','fallback_cb'=>false));
				}
				?>
			</nav> 
			
			<nav id="menu_droit">
            	<ul class="social">
            		<?php if(get_field('url_facebook', 'option')!='' ){?><li><a href="<?php the_field('url_facebook', 'option');?>" target="_blank" id="facebook"></a></li><?php } ?>
	                <?php if(get_field('url_twitter', 'option')!='' ){?><li><a href="<?php the_field('url_twitter', 'option');?>" target="_blank" id="twitter"></a></li><?php } ?>
	                <?php if(get_field('url_vimeo', 'option')!='' ){?><li><a href="<?php the_field('url_vimeo', 'option');?>" target="_blank" id="viadeo"></a></li><?php } ?>
	            	<li><a href="<?php bloginfo('rss2_url'); ?>" id="RSS"></a></li>
	            </ul>
				<ul>
	            	<?php if(get_field('url_plateforme_etudiante', 'option')!='' ){?><li><a href="<?php the_field('url_plateforme_etudiante', 'option');?>">Plateforme étudiante</a></li><?php } ?>
	                <?php if(get_field('info_concours', 'option')!='' ){?><li><a href="<?php the_field('info_concours', 'option');?>">Concours d'entrée</a></li><?php } ?>
	            </ul>
			</nav>
        </div>
   	</div>
   	<?php get_search_form(); ?>
   	<div id="centre">
		<nav id="menu" class="left">
	            <ul> 
	            	<li class="filet"></li>
	            	<li>
	            		<?php
						if ( has_nav_menu( 'left_menu_dessus' ) ) {
							wp_nav_menu( array('theme_location'=>'left_menu_dessus', 'container' => 'false','fallback_cb'=>false));
						}
						?>
	                </li>
	                <li>
	                	<?php
						if ( has_nav_menu( 'left_menu_dessous' ) ) {
							wp_nav_menu( array('theme_location'=>'left_menu_dessous', 'container' => 'false','fallback_cb'=>false));
						}
						?>
		            </li>
	            </ul>
	            <ul id="adresse">
	            	<li class="filet"></li>
	       	  		<li>
						<?php the_field('adresse_epcc', 'option'); ?>
	                </li>
	            </ul>
	            <div id="logos_partenaires">
	            	<img src="<?php bloginfo( 'template_url' ); ?>/img/logo-ministere.png" alt="Ministère"/>
	            	<img src="<?php bloginfo( 'template_url' ); ?>/img/logo-lemans.png" alt="Le Mans"/>
	            	<img src="<?php bloginfo( 'template_url' ); ?>/img/logo-angers.png" alt="Angers"/>
	            	<img src="<?php bloginfo( 'template_url' ); ?>/img/logo-tours.png" alt="Tours"/>
	            </div>
	    </nav>
