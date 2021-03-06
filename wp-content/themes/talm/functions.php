<?php


// LOIC
// J'ai ajouté ces fonctionnalités
// ça permet de sécuriser un peu plus le fichier functions.php
add_action( 'after_setup_theme', 'talm_setup' );

	
if ( ! function_exists( 'talm_setup' ) ){

	/**
	 * Fonction d'initialisation du theme
	 * @return [type] [description]
	 */
	function talm_setup() {
		
		// pour inclure le fichier ACF uniquement quand on n'est pas sur la plateforme de dev		
		if(is_file(dirname(__File__) . '/fields/acf.php') && network_site_url() != 'http://talm.dev/'){
			define( 'ACF_LITE', true );
			include(dirname(__File__) . '/fields/acf.php');	
		}
		include(dirname(__File__) . '/inc/ariane.php');
		
		if ( function_exists('register_sidebar') )
		register_sidebar(array('name'=>'Sidebar',
			'before_widget' => '<div>',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
			
		// permet d'activer le support des b-vignettes pour les pages et les posts
		// on peut ainsi supprimer le champ ACF Image principale
		// cf image à la une
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(235, 160, true);
		
		add_image_size('talm-thumb', 235, 160, true);
		add_image_size('talm-small', 530, 300, true);
		add_image_size('talm-medium', 695, 400, true);
		add_image_size('talm-large', 975, 485, true);
		
		add_filter('the_content', 'use_more_as_header', 999);
		//add_filter('upload_mimes', 'addUploadMimes');
 

		if( function_exists( 'register_field' ) )
		{
			register_field('Tax_field', dirname(__File__) . '/fields/acf-tax.php');
		}
		add_action('init', 'update_newsletter_user');
		add_action('init', 'register_my_menus' );
		
		add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
				 
	}
	
}

if( ! function_exists ( 'register_my_menus') ) {
	/**
	 * [register_my_menus description]
	 * @return [type] [description]
	 */
	function register_my_menus(){
		register_nav_menus(
			array(
				'main_menu_gauche' 		=> __('Menu principal gauche','talm'),
				'main_menu_droite'		=> __('Menu principal droite','talm'),
				'left_menu_dessus'		=> __('Menu gauche dessus','talm'),
				'left_menu_dessous'		=> __('Menu gauche dessous','talm')
			)
		);
	}
}

function custom_excerpt_length( $length ) {
	return 20;
}


if( ! function_exists ( 'update_newsletter_user') ) {
	/**
	 * [update_newsletter_user description]
	 * @return [type] [description]
	 */
	function update_newsletter_user(){
		if(isset($_POST['item_meta'][91]) && isset($_POST['item_meta'][90])) {
			// RIEN
		}
	}
}

 
if( ! function_exists ( 'use_more_as_header') ) {
	/**
	 * pour signaler les entêtes avec la balise more
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	function use_more_as_header($content) {
		// on verifie qu'il y a un <span> correspondant au tag more
		$test = preg_match('/<span id\=\"(more\-\d+)"><\/span>/', $content);
		
		// si il est présent on encadre le texte précédé par more avec une balise <header>
		if($test==1){		
			$myMarkup = "</header>";
			$content = '<header>'.preg_replace('/<span id\=\"(more\-\d+)"><\/span>/', '<span id="\1"></span>'."\n\n". $myMarkup ."\n\n", $content);
		}
		return $content;
	}
}

if( ! function_exists ( 'get_the_content_by_id' ) ) {
	/**
	 * [get_the_content_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function get_the_content_by_id($id) {
		
		$content_post = get_post($id);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		
		return $content;
		
	}
}

/**
 * Adds new supported media types for upload.
 *
 * @see wp_check_filetype() or get_allowed_mime_types()
 * @param array $mimes Array of mime types keyed by the file extension regex corresponding to those types.
 * @return array
 */
/*if( ! function_exists ( 'addUploadMimes') ) {
	function addUploadMimes($mimes)
	{
		$mimes = array_merge($mimes, array(
			'svg' => 'image/svg+xml'
		));
	 
		return $mimes;
	}
}*/
		

if( ! function_exists ( 'create_gallery') ) {
	/**
	 * Crée une gallerie avec toutes les images uploadées.
	 * @param  [type] $size ref corresponding to the image size needed.
	 * @return html       
	 */
	function create_gallery($size = large){
		if ( $images = get_children ( array (
			'post_parent'	=> get_the_ID(),
			'post_type'		=> 'attachment',
			'numberposts'	=> -1 ,
			'post_status'	=> null,
			'post_mime_type'=> 'image',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC'
		) ) ) {
			foreach($images as $image){
				$dont_show = get_field('masquer_liste_galerie', $image->ID);
				if(!$dont_show){
					$list_images[] = $image;
				}
			}
		}
		if($list_images){
			echo '<div class="sliderkit photoslider-mini">'."\n";
			
			$media_count = 0;
			
			echo '<div class="sliderkit-panels">'."\n";
			if(count($list_images)>1){
				echo '<div class="sliderkit-btn sliderkit-go-btn sliderkit-go-prev"><a href="#" title="Previous"><span>Previous</span></a></div>'."\n";
				echo '<div class="sliderkit-btn sliderkit-go-btn sliderkit-go-next"><a href="#" title="Next"><span>Next</span></a></div>'."\n";
			}

			foreach ( $list_images as $image ){
				echo '<div class="sliderkit-panel" id="panel_'.$image->ID.'">'."\n";
				echo wp_get_attachment_image  ( $image->ID , 'talm-large');
				echo '<div class="credits" id="credit_'.$image->ID.'"><p>'.apply_filters( 'the_title' , $image->post_title ).'</p></div>'."\n";
				//$ref = wp_get_attachment_image_src ( $image->ID , $size );
				echo '</div>'."\n";
			}

			echo '</div>'."\n";
			echo '</div>'."\n";
		}
	}
}
 
if( ! function_exists ( 'create_attachement_list') ) {
	/**
	 * [create_attachement_list description]
	 * @param  string $identifiant [description]
	 * @param  string $titre       [description]
	 * @return [type]              [description]
	 */
	function create_attachement_list($identifiant = '', $titre = ''){
		if($identifiant == ''){
			$identifiant = get_the_ID();
		}
		
		//echo get_the_ID();

		if ( $documents = get_children ( array (
			'post_parent'	=> $identifiant,
			'post_type'		=> 'attachment',
			'numberposts'	=> -1 ,
			'post_status'	=> null,
			'post_mime_type'=> 'application/zip, application/msword, application/vnd.ms-excel, application/pdf, application/rtf',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
		) ) ) {
			foreach($documents as $document){
				$dont_show = get_field('masquer_liste_galerie', $document->ID);
				if(!$dont_show){
					$list_documents[] = $document;
				}
			}
		}

		if($list_documents){
			if($titre != '')
			//echo '<h3>' . $titre .'</h3>';
			echo '<ul>'."\n";
			
			$media_count = 0;
			
			foreach ( $list_documents as $document ){
				echo '<li class="telechargement">' . wp_get_attachment_link ( $document->ID , '', false , false ) . '</li>'."\n";
				//echo '<li class="telechargement">' . wp_get_attachment_url ( $document->ID  ) . '</li>'."\n";
			}
		
			echo '</ul>'."\n";
		}
	}
}

/**
 * Pour ajouter un attribut target="_blank" aux liens des fichiers attachés
 * @param  [type] $markup [description]
 * @return [type]         [description]
 */
function modify_attachment_link($markup) {
    return preg_replace('/^<a([^>]+)>(.*)$/', '<a\\1 target="_blank">\\2', $markup);
}
add_filter( 'wp_get_attachment_link', 'modify_attachment_link', 10, 6 );


if( ! function_exists ( 'the_excerpt_max_charlength') ) {
	/**
	 * [the_excerpt_max_charlength description]
	 * @param  [type] $charlength [description]
	 * @return [type]             [description]
	 */
	function the_excerpt_max_charlength($charlength) {
		$contenu_resume = get_the_content();
		$charlength++;

		if ( mb_strlen( $contenu_resume ) > $charlength ) {
			$subex = mb_substr( $contenu_resume, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo "$contenu_resume";
		}
	}
}

if( ! function_exists ( 'the_excerpt_max_charlength_by_param') ) {
	/**
	 * [the_excerpt_max_charlength_by_param description]
	 * @param  [type] $charlength [description]
	 * @param  [type] $pageID     [description]
	 * @return [type]             [description]
	 */
	function the_excerpt_max_charlength_by_param($charlength, $pageID) {
		$contenu_resume = get_the_content_by_id($pageID);
		$contenu_resume = strip_tags($contenu_resume);
		$charlength++;

		if ( mb_strlen( $contenu_resume ) > $charlength ) {
			$subex = mb_substr( $contenu_resume, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo "$contenu_resume";
		}
	}
}

/**
 * [WordLimiter description]
 * @param [type]  $text  [description]
 * @param integer $limit [description]
 */
function WordLimiter($text,$limit=20){ 
    $explode = explode(' ',$text); 
    $string  = ''; 
        
    $dots = '...'; 
    if(count($explode) <= $limit){ 
        $dots = ''; 
    } 
    for($i=0;$i<$limit;$i++){ 
        $string .= $explode[$i]." "; 
    } 
        
    return $string.$dots; 
} 

/**
 * [CharacterLimiter description]
 * @param [type]  $text  [description]
 * @param integer $limit [description]
 */
function CharacterLimiter($text,$limit=50){ 
    $string  = '';         
    $dots = '...';
    $text = html_entity_decode($text);
    if(strlen($text) <= $limit){ 
        $dots = ''; 
    } 
    $string=substr($text, 0, $limit);
        
    return $string.$dots; 
}

/**
 * [getBlogSlug description]
 * @return [type] [description]
 */
function getBlogSlug(){
	$slug = "";
	
	if(!empty($GLOBALS['path']) && !SUBDOMAIN_INSTALL){
		$slug = str_replace('/','',$GLOBALS['path']); 
	}
	if(SUBDOMAIN_INSTALL){
		$subject = get_bloginfo( 'url' );
		$pattern = "/([a-z0-9_\-]{1,5}:\/\/)?(([a-z0-9_\-]{1,}):([a-z0-9_\-]{1,})\@)?((www\.)|([a-z0-9_\-]{1,}\.)+)?([a-z0-9_\-]{3,})(\.[a-z]{2,4})(\/([a-z0-9_\-]{1,}\/)+)?([a-z0-9_\-]{1,})?(\.[a-z]{2,})?(\?)?(((\&)?[a-z0-9_\-]{1,}(\=[a-z0-9_\-]{1,})?)+)?/";
		preg_match($pattern, $subject, $matches);	
		$slug = substr($matches[5],0,-1);	
	}
	return $slug;
}

/**
 * Pour activer le gestionnaire de liens
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );