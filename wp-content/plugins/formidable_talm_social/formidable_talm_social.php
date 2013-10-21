<?php
/*
Plugin Name: Talm Social
Plugin URI: http://www.formidable-studio.net
Description: Plugin permettant d'afficher une barre contenant les dernières actualités Facebook, Twitter ou Vimeo du site TALM.
Version: 1.0
Author: FORMIDABLE
Author URI: http://www.formidable-studio.net
*/


class talm_social {
	function  __construct() {
		// Rien pour l’instant
		//
		
		// on ne charge les dépendances que si on est pas en admin
		if(!is_admin()){

			add_action('wp_head','talm_menu_head',99);
			wp_enqueue_style('talm_social', '/wp-content/plugins/formidable_talm_social/style.css');
			wp_enqueue_script('talm_social_js','/wp-content/plugins/formidable_talm_social/script.js',array('jquery'),false,true);
			add_action('wp_footer','talm_social_html');

		}
		
	}  
}

if ( class_exists ( 'talm_social' ) ) {
	$talm_header = new talm_social();
}
 
 
if ( ! function_exists ( 'talm_social_html' ) ) { 
	function talm_social_html(){
		?>
        <!-- PLUGIN TALM SOCIAL -->
        <div id="bottombar">
            <div id="bottommenu">
                <div id="fluxmenu" class="left">
                    <div> 
                        <p>Les derniers flux</p>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) . 'talm_facebook.php';?>" id="viewflux" class="close"></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) . 'talm_facebook.php';?>" id="flux_facebook" class="fluxselect"></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) . 'talm_twitter.php';?>" id="flux_twitter" class="fluxselect"></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) . 'talm_vimeo.php';?>" id="flux_vimeo" class="fluxselect"></a>
                    </div>
                </div>
                
                <div class="right">
                    <div id="flux" class="close carousel" style="width: 0%; display: block; ">
                        <div class="nav">
                            <div class="btn nav-btn nav-prev"><a href="#" title="Scroll to the left"><span>Previous</span></a></div>
                            <div class="fluxcontent">
                            </div>
                            <div class="btn nav-btn nav-next"><a href="#" title="Scroll to the right"><span>Next</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="bottombackground">
		</div>
        
        <!-- FIN PLUGIN TALM SOCIAL -->
        
        <?php
	}
}

if ( ! function_exists ( 'talm_menu_head' ) ) { 
	function talm_menu_head(){
		echo '<!-- PLUGIN TALM SOCIAL -->'."\n";
		
		global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() ) {
		?>
		
		<?php 
		}else{
		?>
		
		<?php 
		}
	}
}