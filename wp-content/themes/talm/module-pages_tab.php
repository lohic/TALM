<?php

if(get_sub_field("titre_du_bloc")){
	$compteur=0;
	$titre = get_sub_field("titre_du_bloc");

	echo 	'<div class="full">
				<article class="texte_avec_onglet">
	            	<header>
	                	<h2>'.$titre.'</h2>
	            	</header>
					<nav>
						<a class="previous" href="javascript:">previous</a>
						<a class="next" href="javascript:">next</a>
					</nav>
	            	<aside>
	                <ul>';

	$pages = get_sub_field("pages_liees");
	//var_dump($pages[0]);
	/*for($i=0;$i<count($pages);$i++){
		$compteur++;
		
		echo '<li class="lien_onglet" id="onglet_'.$compteur.'">
	                        <a href="#" class="">'.$pages[$i]->post_title.'</a>
	                        <div class="content" id="content_onglet_'.$compteur.'">
	                        	<div class="bordure_droite">
		                            <h3>'.$pages[$i]->post_title.'</h3>
		                            <p>'.$pages[$i]->post_content.'</p>
		                            <div class="filet_onglet">
		                            </div>
		                        </div>
	                        </div>
	                    </li>';
		
	}*/
	
	foreach( $pages as $page):
						
		echo '<li class="lien_onglet" id="onglet_'.$page->ID.'">
	                        <a href="#" class="">'.get_the_title($page->ID).'</a>
	                        <div class="content" id="content_onglet_'.$page->ID.'">
	                        	<div class="bordure_droite">
		                            <h3>'.get_the_title($page->ID).'</h3>
		                            <div>'.get_the_content_by_id($page->ID).'</div>
		                            <div class="filet_onglet">
		                            </div>
		                        </div>
	                        </div>
	                    </li>';
	
	endforeach;
	
	                    
	echo '</ul>
				</aside> 
	            <span class="bas_ombre"></span>
	        </article>
	    </div>';
	
	
	
	
}
?>
