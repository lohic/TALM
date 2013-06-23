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
				//on affiche que les catégories racine (on teste si la catégorie a un parent)
				if($cat->parent==0){
				?>
					<li><a href="#" data-option-value=".<?php echo $cat->slug;?>"><?php echo $cat->name;?></a></li>
				<?php
				}
			}

			$liste_categories = implode(',',$slugs);
?>
				
			</ul> 
		</section>
<?php
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		$posts_per_page = get_sub_field('nbr_articles');
		//$my_query_listing = new WP_Query( array('category_name'=>$liste_categories, 'meta_key'=>'date_de_debut', 'order' => 'ASC','orderby' => 'meta_value', 'posts_per_page'=>-1));
		$my_query_listing = new WP_Query( array('post_status'=>array('publish','future'),'category_name'=>$liste_categories, 'order' => 'DESC','orderby' => 'date', 'posts_per_page'=>$posts_per_page, 'paged' => $paged));
		if($my_query_listing->max_num_pages>1){
?>
			<section class="pagination_isotope smaller mb2">
				<span class="page">Page</span>
				<?php
					$big = 99999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('page') ),
						'total' => $my_query_listing->max_num_pages,
						'prev_text'    => ' ',
						'next_text'    => ' ',
					) );
				?>
			</section>
<?php		
		}
?>
		<section id="container" class="super-list variable-sizes clearfix">
<?php 
			while( $my_query_listing->have_posts() ) : $my_query_listing->the_post();
					$la_categorie="";
					$les_categories = get_the_category();
					foreach($les_categories as $une_categorie){
						if(in_array($une_categorie->slug, $slugs)) {
							$la_categorie = $une_categorie->name;
							// Pour que les filtres fonctionnent. 
							// Si catégorie mère on affiche directement son slug
							// Sinon on récupère le slug de l'ancetre racine (peu importe le niveau de profondeur de la sous-catégorie)
							if($une_categorie->parent==0){
								$la_categorie_slug = $une_categorie->slug;
							}
							else{
								$ancetres = get_ancestors( $une_categorie->term_id, 'category' );
								$categorie_mere=get_term_by('id', $ancetres[count($ancetres)-1], 'category');
								$la_categorie_slug = $categorie_mere->slug;
							}
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
?>				
		</section>
<?php
		if($my_query_listing->max_num_pages>1){
?>
			<section class="pagination_isotope basse smaller mb2">
				<span class="page">Page</span>
				<?php
					$big = 99999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('page') ),
						'total' => $my_query_listing->max_num_pages,
						'prev_text'    => ' ',
						'next_text'    => ' ',
					) );
				?>
			</section>
<?php		
		}
?>
	</div>
</div>

