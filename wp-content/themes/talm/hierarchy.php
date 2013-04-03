<?php

while(the_flexible_field("structure_page")){
	//echo 'ok ';				
	//get_template_part( 'module', 'onglets' );
	
	// on recupere le nom du module pour le template :
	$module_name = str_replace('module_','',get_row_layout());
	//echo "<p>$module_name</p>";

	
	switch (get_row_layout()){
	
		case 'module_page_view' :
			//echo 'ok texte';
			get_template_part( 'module',$module_name );
		break;
		
		case 'module_pages_tab' :
			get_template_part( 'module',$module_name );
		break;
		
		case 'module_image' :
			//echo 'ok image';
			get_template_part( 'module',$module_name );
		break;
		
		case 'module_posts_player' :
			get_template_part( 'module',$module_name );
		break;
		
		case 'module_posts_listing' :
			get_template_part( 'module',$module_name );
		break;
		
		default :
		
		break;
		
	}
	
}
