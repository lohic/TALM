<?php

//echo 'module texte';
if(get_sub_field("page_liee")){
	$p = get_sub_field("page_liee");
	
	$resume = get_sub_field("texte_resume");
	$position = get_sub_field("image_position");

	$my_query = new WP_Query('page_id='.$p->ID);
	while( $my_query->have_posts() ) : $my_query->the_post();
		//$contenu_resume = get_the_content("Lire la suite");
		$titre = get_the_title();		
		if(!$resume){
?>
			<div class="full">
					<article class="texte_seul">
						<header>
							<h2><?php echo $titre;?></h2>
						</header>
						<div class="colonnes">
							<div class="content">
								<?php echo get_the_content_by_id($p->ID);?>
							</div>
							<aside>
								<?php $posts = get_field('pages_en_relation');
 
								if( $posts ): ?>
									<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
										<?php setup_postdata($post); ?>
										<a href="<?php the_permalink(); ?>" class="lien_normal"><?php the_title(); ?></a>
									<?php endforeach; ?>
									<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
								<?php endif;

								create_attachement_list($p->ID);
?>		
							</aside>
						</div>
						<span class="bas_ombre"></span>
					</article>
				</div>
<?php
		}
		else{
			if($position=="droite"){
?>
				<div class="full">
		            <article class="texte_image">
		                <div class="conteneur_ombre">
		                    <div class="contenu">
		                        <header>
		                            <h2><a href="<?php echo get_permalink();?>"><?php echo $titre;?></a></h2>
		                        </header>
		                        <div class="content">
		                        	<p><?php the_excerpt_max_charlength(400);?></p>
		                        	<a href="<?php echo get_permalink();?>" class="suite">Lire la suite</a>
		                        </div>
		                        <span class="bas_ombre"></span>
		                    </div>
		                    <div id="filet_bas">
		                    </div>
		                </div>
		                <div class="conteneur_image">
		                	<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($p->ID, 'talm-small');?></a>
		                </div>
		    		</article>
				</div>
<?php
			}	
			else{
?>
				<div class="full">
		            <article class="image_texte">
		            	<div class="conteneur_image">
		            		<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($p->ID, 'talm-small');?></a>
		          		</div>
		                <div class="conteneur_ombre">
		                    <div class="contenu">
		                        <header>
		                            <h2><a href="<?php echo get_permalink();?>"><?php echo $titre;?></a></h2>
		                        </header>
		                        <content>
		                        	<p><?php the_excerpt_max_charlength(500);?></p>
		                        	<a href="<?php echo get_permalink();?>" class="suite">Lire la suite</a>
		                        </content>
		                        
		                        <span class="bas_ombre"></span>
		                    </div>
		                    <div id="filet_bas">
		                    </div>
		    			</div> 
		    			
		        	</article>
				</div>
<?php
			}
		}	
	endwhile;
	wp_reset_postdata();	
}

?>
