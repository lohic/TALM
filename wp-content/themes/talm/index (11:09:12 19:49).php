<?php get_header(); ?> <!-- ouvrir header.php -->
	<div id="content" class="right">
		<?php
			$ancetre=get_post_ancestors($post);
			if (count($ancetre)>0 || $post->ID==13){
				echo 	'<div class="gallery">
             				<img src="'.get_field('image_principale').'" alt=""/>
				        </div>';
					if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="full">
				            <div class="column2">
				                <article>
				                    <header>
				                        <h2><?php the_title(); ?></h2>
				                        <?php get_field('chapo');?>
				                    </header>
				                    <content>
										<?php the_content(); ?>
									</content>
				                </article>
				            </div>
				        	<div class="column1">
				            	<div id="ariane">
				            		<?php 
				            			if(function_exists('bcn_display')){
								        	bcn_display();
								    	}
								    ?>
				   	  			</div>
								<div id="telechargement">
									<?php 
										$fichiers = get_field('fichiers_liés');
										if ($fichiers!=false){
											foreach($fichiers as $fichier){
											?>
												<a href="<?php echo $fichier['fichier'];?>"><?php echo $fichier['titre_fichier'];?></a>		
											<?php		
											}
										}
									?>	
								</div>
								<div id="voir_aussi">
									<?php 
										$liens = get_field('liste_liens');
										if ($liens!=false){
									?>
											<h3>Voir aussi</h3>
											<ul>
									<?php
											foreach($liens as $lien){
									?>
												<li><a href="<?php echo $lien['url_lien'];?>"><?php echo $lien['titre_lien'];?></a></li>		
									<?php		
											}
										}
									?>
									</ul>
								</div>
							</div>
						</div>
						<div class="reset"></div>
				<?php endwhile; ?>
				<?php endif;        
			}
			else{
				while(the_flexible_field("structure_page")){
					if(get_row_layout() == "bloc_texte_seul"){
						if(get_sub_field("page_liee")){
							foreach(get_sub_field("page_liee") as $p){	

								
								echo '<div class="full">
							            <article class="texte_seul">
							                <header>
							                    <h2>'.get_the_title($p->ID).'</h2>
							                </header>
							                <div class="colonnes">
							                    <div class="content">
							                        <div class="chapo">'.get_field('chapo',$p->ID).'</div>
							                        '.$p->post_content.'
							                    </div>
							                    <aside>';

							    if(get_field('liste_liens',$p->ID)){
								    foreach(get_field('liste_liens',$p->ID) as $lien){
								    	echo '<a href="'.$lien['url_lien'].'" class="lien_normal">'.$lien['titre_lien'].'</a>';
								    }
								}
								if(get_field('fichiers_lies',$p->ID)){
								    foreach(get_field('fichiers_lies',$p->ID) as $fichier){
						    			echo '<a href="'.$fichier['fichier'].'" class="telechargement">'.$fichier['titre_fichier'].'</a>';
						    		}
								}
							    
							                        
							    echo '</aside>
							                </div>
							                <span class="bas_ombre"></span>
							            </article>
									</div>';
									
							}	
						}
					}

					if(get_row_layout() == "bloc_image"){
						if(get_sub_field("page_liee_image")){
							foreach(get_sub_field("page_liee_image") as $p){	
								echo '<div class="full image">
							        	<img src="'.get_field('image_principale',$p->ID).'" alt="Image"/>    
									</div>';
									
							}	
						}
					}

					if(get_row_layout() == "bloc_texte-image"){
						if(get_sub_field("page_liee_texte_image")){
							foreach(get_sub_field("page_liee_texte_image") as $p){	
								echo '<div class="full">
							            <article class="texte_image">
							                <div class="conteneur_ombre">
							                    <div>
							                        <header>
							                            <h2>'.get_the_title($p->ID).'</h2>
							                        </header>
							                        <div class="content">
							                            '.$p->post_content.'
							                        </div>
							                        <aside>';

							    if(get_field('liste_liens',$p->ID)){
								    foreach(get_field('liste_liens',$p->ID) as $lien){
								    	echo '<a href="'.$lien['url_lien'].'" class="lien_normal">'.$lien['titre_lien'].'</a>';
								    }
								}
								if(get_field('fichiers_lies',$p->ID)){
								    foreach(get_field('fichiers_lies',$p->ID) as $fichier){
						    			echo '<a href="'.$fichier['fichier'].'" class="telechargement">'.$fichier['titre_fichier'].'</a>';
						    		}
								}
							                        	
							    echo '</aside>
							                        <aside class="lire_plus">
							                            <a href="'.$value['url_lien_lire_plus'].'">Lire</a>
							                        </aside>
							                    </div>
							                    <span class="bas_ombre"></span>
							                </div>
							                
							                <aside class="en_plus">';
							    
							                
							    echo '</aside>
							                <img src="'.get_field('image_principale',$p->ID).'" alt="'.get_the_title($p->ID).'"/>
							            </article>
									</div>';
									
							}	
						}
					}

					if(get_row_layout() == "bloc_texte-image_réduit"){
						if(get_sub_field("page_liee_texte-image_reduit")){
							foreach(get_sub_field("page_liee_texte-image_reduit") as $p){	
								echo '<div class="full">
							            <article class="texte_image_reduit">
							                <div class="conteneur_ombre">
						                        <header>
						                            <h2>'.get_the_title($p->ID).'</h2>
						                        </header>
						                        <content>
						                            '.$p->post_content.'
						                        </content>
						                        <aside>';
						    if(get_field('liste_liens',$p->ID)){
							    foreach(get_field('liste_liens',$p->ID) as $lien){
							    	echo '<a href="'.$lien['url_lien'].'" class="lien_normal">'.$lien['titre_lien'].'</a>';
							    }
							}
							if(get_field('fichiers_lies',$p->ID)){
							    foreach(get_field('fichiers_lies',$p->ID) as $fichier){
					    			echo '<a href="'.$fichier['fichier'].'" class="telechargement">'.$fichier['titre_fichier'].'</a>';
					    		}
							}
						                        	
						    echo '</aside>
						                <span class="bas_ombre"></span>
						                </div>
						                <img src="'.get_field('image_principale',$p->ID).'" alt="'.get_the_title($p->ID).'"/>
						            </article>
								</div>';
									
							}	
						}
					}

					if(get_row_layout() == "bloc_image-texte"){
						if(get_sub_field("page_liee_image-texte")){
							foreach(get_sub_field("page_liee_image-texte") as $p){	
								echo '<div class="full">
							            <article class="image_texte">
							            	<img src="'.get_field('image_principale',$p->ID).'" alt="'.get_the_title($p->ID).'"/>
							                <div class="conteneur_ombre">
							                    <div>
							                        <header>
							                            <h2>'.get_field('image_principale',$p->ID).'</h2>
							                        </header>
							                        <content>
							                        	<div class="chapo">'.get_field('chapo',$p->ID).'</div>
							                            '.$p->post_content.'
							                        </content>
							                        <aside class="lire_plus">
							                            <a href="'.$value['lien_lire_plus'].'">Lire</a>
							                        </aside>
							                    </div>
							                    <span class="bas_ombre"></span>
							                </div>
							                <aside>';
							    if(get_field('liste_liens',$p->ID)){
								    foreach(get_field('liste_liens',$p->ID) as $lien){
								    	echo '<a href="'.$lien['url_lien'].'" class="lien_normal">'.$lien['titre_lien'].'</a>';
								    }
								}
								if(get_field('fichiers_lies',$p->ID)){
								    foreach(get_field('fichiers_lies',$p->ID) as $fichier){
						    			echo '<a href="'.$fichier['fichier'].'" class="telechargement">'.$fichier['titre_fichier'].'</a>';
						    		}
								}
							                        	
							    echo '</aside>  
							            </article>
									</div>';
							}	
						}
					}


					if(get_row_layout() == "bloc_onglet"){
						if(get_sub_field("onglet")){
							echo '<div class="full">
							            <article class="texte_avec_onglet">
							                <header>
							                    <h2></h2>
							                </header>
							                <aside>
							                    <ul>';
							$compteur=0;
							foreach(get_sub_field("onglet") as $p){
									foreach ($p['page_liee_onglet'] as $page){
										$compteur++;
							    		echo '<li class="lien_onglet" id="onglet_'.$compteur.'">
							                            <a href="#" class="">'.get_the_title($page->ID).'</a>
							                            <div class="content" id="content_onglet_'.$compteur.'">
							                                <h3>'.get_the_title($page->ID).'</h3>
							                                '.$page->post_content.'
							                            </div>
							                        </li>';	
									}
    								
							}
							                        
							echo '</ul>
							    			</aside> 
							                <span class="bas_ombre"></span>
							            </article>
							        </div>';	
						}
					}
				}				
			}
			echo '<div class="reset"></div>';
		?>   
	</div>
    <!-- END CONTENT-->
</div>
<?php get_footer(); ?>
