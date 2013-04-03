<?php
/*
Plugin Name: Talm Header
Plugin URI: http://www.formidable-studio.net
Description: Plugin permettant d'afficher une barre de retour sur la plateforme principale du site TALM.
Version: 1.0
Author: FORMIDABLE
Author URI: http://www.formidable-studio.net
*/


class talm_header {
	function  __construct() {
		// Rien pour l’instant
		//
		add_action('wp_head','talm_menu_head',99);
		
		wp_enqueue_style('talm_header', '/wp-content/plugins/formidable_talm_header/formidable_talm_header.css');
		
		add_action('wp_footer','talm_menu_html');
	}  
}

if ( class_exists ( 'talm_header' ) ) {
	$talm_header = new talm_header();
}
 
 
if ( ! function_exists ( 'talm_menu_html' ) ) { 
	function talm_menu_html(){
		if(get_bloginfo( 'url' ) != 'http://www.esba-talm.fr'){
		?>
      
        <div id="talm_header">&larr; Retour  site <a href="http://www.esba-talm.fr" title="TALM">TALM</a></div>
        
        <?php
        echo '<!-- PLUGIN TALM HEADER HTML-->'."\n";  
		}
	}
}

if ( ! function_exists ( 'talm_menu_head' ) ) { 
	function talm_menu_head(){
		if(get_bloginfo( 'url' ) != 'http://www.esba-talm.fr'){
		echo '<!-- PLUGIN TALM HEADER -->'."\n";
		
		global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() ) {
		?>
		<style type="text/css" media="screen">
			html { margin-top: 28px !important; }
			* html body { margin-top: 28px !important; }
			div#talm_header{ top:0px; }
		</style>
		<?php 
		}else{
		?>
		<style type="text/css" media="screen">
			html { margin-top: 56px !important; }
			* html body { margin-top: 56px !important; }
			div#talm_header{ top:28px; }
		</style>
		<?php 
		}
		}
	}
}