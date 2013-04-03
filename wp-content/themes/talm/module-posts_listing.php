<div class="full">
	<div id="conteneur_isotope">
		<section id="options"> 
			<p>Trier par</p>
			<ul id="filters" class="option-set clearfix " data-option-key="filter">
				<li class="selected"><a href="#filter-color-any" data-option-value="*">Tout afficher</a></li> 
<?php 
			$categories = get_sub_field('posts_categories');
			preg_match_all ("/a[\s]+[^>]*?href[\s]?=[\s\"\']+".
			                "(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/",
			                $categories, &$matches);

			$matches = $matches[1];
			$slugs = array();

			foreach($matches as $var)
			{  
				$temp = explode('/',$var);
				$slugs[] = $temp[count($temp)-2];
			}
			$liste_categories = "";
			for($i=0; $i<count($slugs); $i++){
				if($i<count($slugs)-1){
					$liste_categories .= $slugs[$i].",";
				}
				else{
					$liste_categories .= $slugs[$i];
				}
				
				$cat_info = get_category_by_slug($slugs[$i]);
				if($cat_info->count>0){
?>
				<li><a href="#" data-option-value=".<?php echo $slugs[$i];?>"><?php echo $cat_info->name;?></a></li>
<?php
				}
			}
?>
				
			</ul> 
		</section>
		<section id="container" class="super-list variable-sizes clearfix">
<?php 
			//$my_query_listing = new WP_Query( array('category_name'=>$liste_categories, 'meta_key'=>'date_de_debut', 'order' => 'ASC','orderby' => 'meta_value', 'posts_per_page'=>-1));
			$my_query_listing = new WP_Query( array('post_status'=>array('publish','future'),'category_name'=>$liste_categories, 'order' => 'DESC','orderby' => 'date', 'posts_per_page'=>20));
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

					$tags = get_the_tags();
					if($tags){
						foreach($tags as $tag){
							$le_tag_class = str_replace(' ','',$tag->name);
							$le_tag_name = $tag->name;
						} 
					}
				?>
				<article class="element <?php echo $le_tag_class;?> <?php echo $la_categorie_slug;?>" id="article_<?php the_ID();?>">
					<a href="<?php the_permalink();?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail();
						?>
							<footer id="footer_<?php the_ID();?>">
								<h3><?php echo $le_tag_name;?></h3>
								<h2><?php echo CharacterLimiter(get_the_title(),30);?></h2>
								<h4><?php the_field("sous_titre");?></h4>
								<p class="type"><?php echo $la_categorie;?></p>
							</footer>
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

