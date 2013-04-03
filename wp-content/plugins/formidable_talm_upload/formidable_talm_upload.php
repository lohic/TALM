<?php
/*
Plugin Name: Talm Upload
Plugin URI: http://www.formidable-studio.net
Description: Plugin permettant d'autoriser l'upload d'autres formats de fichiers (SVG)
Version: 1.0
Author: FORMIDABLE
Author URI: http://www.formidable-studio.net
*/


class talm_upload {
	function  __construct() {
		// Rien pour l’instant
		//
		
		//wp_enqueue_style('talm_header', '/wp-content/plugins/formidable_talm_header/style.css');
		
		add_filter('upload_mimes', 'add_custom_upload_mimes');
	}  
}

if ( class_exists ( 'talm_upload' ) ) {
	$talm_header = new talm_upload();
}
 
 
if ( ! function_exists ( '' ) ) { 
	function add_custom_upload_mimes($existing_mimes){
		$existing_mimes['svg'] = 'image/svg+xml'; //allow svg files
		return $existing_mimes;
	}  
}
