<?php
		$args = array(
			'post_type' => 'page',
			'page_id' => 75,
		);

		$the_query = new WP_Query( $args );

		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
			
			echo '<h1>' . get_the_title() . '</h1>';

			while( the_flexible_field("structure_page") ) :
								
				if ( get_row_layout() == 'module_posts_listing' ) :					
					$categories = get_sub_field('posts_categories');
								
					$liste_categories = array();
					$slugs = array();
										
					if($categories) foreach($categories as $cat)
					{  
						$slugs[] = $cat->slug;
					}
		
					$liste_categories = implode(',',$slugs);
		
		
					$posts_per_page = get_sub_field('nbr_articles');
					$posts_per_page = 20;
					
					//$my_query_listing = new WP_Query( array('category_name'=>$liste_categories, 'meta_key'=>'date_de_debut', 'order' => 'ASC','orderby' => 'meta_value', 'posts_per_page'=>-1));
					$my_query_listing = new WP_Query( array('post_status'=>array('publish','future'),'category_name'=>$liste_categories, 'order' => 'DESC','orderby' => 'date', 'posts_per_page'=>$posts_per_page));
					while( $my_query_listing->have_posts() ) : $my_query_listing->the_post();
							$la_categorie="";
							$les_categories = get_the_category();
							foreach($les_categories as $une_categorie){
								if(in_array($une_categorie->slug, $slugs)) {
									$la_categorie = $une_categorie->name;
									$la_categorie_slug = $une_categorie->slug;
								}
							}
							$le_tag = "";
							$tagTheme = false;
		
							$tags = get_the_tags();
							if($tags){
								foreach($tags as $tag){
									$le_tag_class = str_replace(' ','',$tag->name);
									$le_tag_name = $tag->name;
									// pour détecter si le tag correspond au site
									// par exemple angers == angers
									// dans ce cas on va inverser la vignette							
									if($tag->name == getBlogSlug() && !$tagTheme && $tag->name != 'talm'){
										$tagTheme = true;
									}
								} 
							}
							$tagTheme = $tagTheme ? 'inverted' : '';
						?>
						<article class="element <?php echo $le_tag_class;?> <?php echo $la_categorie_slug;?>" id="article_<?php the_ID();?>">
							<a href="<?php the_permalink();?>">
								<?php
								if ( has_post_thumbnail() ) {
									$id = get_post_thumbnail_id();
									echo wp_get_attachment_image  ( $id, 'talm-thumb');
									//the_post_thumbnail();
								?>
									<footer id="footer_<?php the_ID();?>" class="<?php echo $tagTheme;?>">
										<h3 class="titre"><?php echo $le_tag_name;?></h3>
										<h2 class="titre"><?php echo CharacterLimiter(get_the_title(),30);?></h2>
										<h4 class="titre"><?php the_field("sous_titre");?></h4>
										<!--<p class="type"><?php echo $la_categorie;?></p>-->
									</footer>
									<p class="type"><?php echo $la_categorie;?></p>
								<?php
								}
								else {
								?>
									<header id="header_<?php the_ID();?>">
										<h3><?php echo $le_tag_name;?></h3>
										<h2><?php echo CharacterLimiter(get_the_title(),30);?></h2>
										<h4><?php the_field("sous_titre");?></h4>
									</header>
									<p class="type"><?php echo $la_categorie;?></p>
								<?php
								}
								?>
									
							</a>
						</article>
					<?php 
					endwhile;
					wp_reset_postdata();
				endif;
			endwhile;
		endwhile;