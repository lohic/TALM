<div class="full">
	<div id="conteneur_isotope">
		<section id="options"> 
			<p>Trier par</p>
			<ul id="filters" class="option-set clearfix " data-option-key="filter">
				<li class="selected"><a href="#filter-color-any" data-option-value="*">Tout afficher</a></li> 
<?php 
			$categories = get_sub_field('posts_categories');
			
			$liste_categories = array();
			$slugs = array();
			
			foreach($categories as $cat)
			{  
				$slugs[] = $cat->slug;
				?>
				<li><a href="#" data-option-value=".<?php echo $cat->slug;?>"><?php echo $cat->name;?></a></li>
				<?php
			}

			$liste_categories = implode(',',$slugs);
?>
				
			</ul> 
		</section>
		<section id="container" class="super-list variable-sizes clearfix">
<?php 
			$posts_per_page = get_sub_field('nbr_articles');
			
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
							if($tag->name == getBlogSlug() && !$tagTheme){
								$tagTheme = true;
							}
						} 
					}
					$tagTheme = $tagTheme == true ? 'inverted' : '';
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
								<p class="type"><?php echo $la_categorie;?></p>
							</header>
						<?php
						}
						?>
							
					</a>
				</article>
			<?php 
			endwhile;
			wp_reset_postdata();
?>				
		</section>
	</div>
</div>

