<?php

// cf http://www.seomix.fr/fil-dariane-chemin-navigation/

//***Fil d'arianne
//Récupérer les catégories parentes
function myget_category_parents($id, $link = false,$separator = '/',$nicename = false,$visited = array()) {
	$chain = '';$parent = &get_category($id);
	if (is_wp_error($parent))return $parent;
	if ($nicename)$name = $parent->name;
	else $name = $parent->cat_name;
	if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
		$visited[] = $parent->parent;$chain .= myget_category_parents( $parent->parent, $link, $separator, $nicename, $visited );}
	if ($link) $chain .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link( $parent->term_id ) . '" title="Voir tous les articles de '.$parent->cat_name.'" rel="v:url" property="v:title">'.$name.'</a></span>' . $separator;
	else $chain .= $name.$separator;
	return $chain;
}

//Le rendu
function ariane() {
	// variables gloables
	global $wp_query;$ped=get_query_var('paged');$rendu = '<div xmlns:v="http://rdf.data-vocabulary.org/#">';  
	$debutlien = '<span typeof="v:Breadcrumb"><a title="'. get_bloginfo('name') .'" id="breadh" href="'.home_url().'" rel="v:url" property="v:title">'.get_bloginfo('name').'</a></span>';
	$debut = '<span typeof="v:Breadcrumb">'.get_bloginfo('name').'</span>';

	// si l'utilisateur a défini une page comme page d'accueil
	if ( is_front_page() ) {$rendu .= $debut;}

	// dans le cas contraire
	else {

	// on teste si une page a été définie comme devant afficher une liste d'article 
	if( get_option('show_on_front') == 'page') {
		$url = urldecode(substr($_SERVER['REQUEST_URI'], 1));
		$uri = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		$posts_page_id = get_option( 'page_for_posts');
		$posts_page_url = get_page_uri($posts_page_id);  
		$pos = strpos($uri,$posts_page_url);
		if($pos !== false) {
			//$rendu .= $debutlien.' <span typeof="v:Breadcrumb">Les articles</span>';
			$rendu .= $debutlien;
		}
		else {
			$rendu .= $debutlien;
		}
	}

	//Si c'est l'accueil
	elseif ( is_home()) {$rendu .= $debut;}

	//pour tout le reste
	else {$rendu .= $debutlien;}

    // les catégories
	if ( is_category() ) {
		$cat_obj = $wp_query->get_queried_object();$thisCat = $cat_obj->term_id;$thisCat = get_category($thisCat);$parentCat = get_category($thisCat->parent);
		if ($thisCat->parent != 0) $rendu .= " <span>".myget_category_parents($parentCat, true, " ", true).'</span>';
		if ($thisCat->parent == 0) {$rendu .= "";}
		if ( $ped <= 1 ) {$rendu .= '<span>'.single_cat_title("", false).'</span>';}
		elseif ( $ped > 1 ) {
			$rendu .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link( $thisCat ) . '" title="Voir tous les articles de '.single_cat_title("", false).'" rel="v:url" property="v:title">'.single_cat_title("", false).'</a></span>';
		}
	}

    // les auteurs
	elseif ( is_author()){
		global $author;$user_info = get_userdata($author);$rendu .= " <span>Articles de l'auteur ".$user_info->display_name."</span>";}  

	// les mots clés
	elseif ( is_tag()){
		$tag=single_tag_title("",FALSE);$rendu .= " <span>Articles sur le th&egrave;me ".$tag."</span>";
	}
	elseif ( is_date() ) {
		if ( is_day() ) {
			global $wp_locale;
			$rendu .= '<span typeof="v:Breadcrumb"><a href="'.get_month_link( get_query_var('year'), get_query_var('monthnum') ).'" rel="v:url" property="v:title">'.$wp_locale->get_month( get_query_var('monthnum') ).' '.get_query_var('year').'</a></span> ';
			$rendu .= " <span>Archives pour ".get_the_date().'</span>';}
		else if ( is_month() ) {
			$rendu .= " <span>Archives pour ".single_month_title(' ',false).'</span>';}
		else if ( is_year() ) {
			$rendu .= " <span>Archives pour ".get_query_var('year').'</span>';
		}
	}

	//les archives hors catégories
	elseif ( is_archive() && !is_category()){
		$posttype = get_post_type();
		$tata = get_post_type_object( $posttype );
		$var = '';
		$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
		$titrearchive = $tata->labels->menu_name;
		if (!empty($the_tax)){$var = $the_tax->labels->name.' ';}
		if (empty($the_tax)){$var = $titrearchive;}
		$rendu .= ' <span>Archives sur "'.$var.'"</span>';}

	// La recherche
	elseif ( is_search()) {
		$rendu .= " <span>R&eacute;sultats de votre recherche ".get_search_query()."</span>";}

	// la page 404
	elseif ( is_404()){
		$rendu .= " <span>Page non trouv&eacute;e</span>";}

	//Un article
	elseif ( is_single()){
		$category = get_the_category();
		$category_id = get_cat_ID( $category[0]->cat_name );
		if ($category_id != 0) {
			$rendu .= " ".myget_category_parents($category_id,TRUE,' ')."<span>".the_title('','',FALSE)."</span>";}
		elseif ($category_id == 0) {
			$post_type = get_post_type();
			$tata = get_post_type_object( $post_type );
			$titrearchive = $tata->labels->menu_name;
			$urlarchive = get_post_type_archive_link( $post_type );
			$rendu .= ' <span typeof="v:Breadcrumb"><a class="breadl" href="'.$urlarchive.'" title="'.$titrearchive.'" rel="v:url" property="v:title">'.$titrearchive.'</a></span> <span>'.the_title('','',FALSE).'</span>';
		}
	}

	//Une page
	elseif ( is_page()) {
		$post = $wp_query->get_queried_object();
		if ( $post->post_parent == 0 ){
			$rendu .= " <span>".the_title('','',FALSE)."</span>";
		}
		elseif ( $post->post_parent != 0 )
		{
			$title = the_title('','',FALSE);$ancestors = array_reverse(get_post_ancestors($post->ID));array_push($ancestors, $post->ID);
			foreach ( $ancestors as $ancestor ){
				if( $ancestor != end($ancestors) ){
					$rendu .= '<span typeof="v:Breadcrumb"><a href="'. get_permalink($ancestor) .'" rel="v:url" property="v:title">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a></span>';
				}
				else {
					$rendu .= ' <span>'.strip_tags(apply_filters('single_post_title',get_the_title($ancestor))).'</span>';
				}
			}
		}
	}
	if ( $ped >= 1 ) {
		$rendu .= ' <span>(Page '.$ped.')</span>';
	}
	}
	$rendu .= '</div>';
	echo $rendu;
}
  
  
  // POUR L'UTILISER :
//if (function_exists('ariane')) ariane();