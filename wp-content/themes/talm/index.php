<?php get_header(); ?> <!-- ouvrir header.php -->
	<div id="content" class="right">
		<?php
				echo create_gallery();
					if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="full">
                        	<div class="column1">
                        		<div>
					            	<div id="ariane">
					            		<?php 
					            			/*if(function_exists('bcn_display')){
									        	bcn_display();
									    	}*/
											
											ariane();
									    ?>
					   	  			</div>
									<div id="telechargement">
										
                                        <?php create_attachement_list(get_the_ID(), 'Documents attachés'); ?>
									</div>
									<div id="voir_aussi">
										<?php $posts = get_field('pages_en_relation');
 
										if( $posts ): ?>
                                        	<h3>Voir aussi</h3>
											<ul>
											<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
												<?php setup_postdata($post); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
											<?php endforeach; ?>
											</ul>
											<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
										<?php endif;?>
                                        
									</div>
                                    <?php get_sidebar(); ?>
								</div>
							</div>
				            <div class="column2">
				                <article>
				                    <header>
				                        <h2><?php the_title(); ?></h2>
				                        <?php get_field('sous_titre');?>
				                    </header>
				                    <content>
										<?php the_content(); ?>
									</content>
				                </article>
				            </div>
				        	
						</div>
						<div class="reset"></div>
				<?php endwhile; ?>
				<?php endif;        
			
		?>   
	</div>
    <!-- END CONTENT-->
</div>
</div>
<?php get_footer(); ?>