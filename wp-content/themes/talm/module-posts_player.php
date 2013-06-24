<div class="full sans">
    <article class="slider">
        <div class="sliderkit contentslider-std">
			<div class="sliderkit-nav">
				<div class="sliderkit-nav-clip">
					<ul>
<?php
						$pages = get_sub_field("posts");
						for($i=0;$i<count($pages);$i++){	
?>
							<li><a href="#" title=""></a></li>
<?php
						}
?>
		    		</ul>
				</div>
			</div>
			<div class="sliderkit-panels">
<?php
				for($i=0;$i<count($pages);$i++){	
					$la_categorie="";
					$les_categories = get_the_category($pages[$i]->ID);

					foreach($les_categories as $une_categorie){
						$la_categorie = $une_categorie->slug;
					}

					$le_tag = "";

					$tags = get_the_tags($pages[$i]->ID);
					if($tags){
						foreach($tags as $tag){
							$le_tag = str_replace(' ','',$tag->name);
						} 
					}
?>
					<div class="sliderkit-panel">
						<div class="conteneur_image_slider">
							<?php 
								if(has_post_thumbnail($pages[$i]->ID)){
									echo get_the_post_thumbnail($pages[$i]->ID, 'talm-medium');
								}
								else{
									if($le_tag=="lemans"){
							?>
										<img src="<?php bloginfo( 'template_url' ); ?>/img/image-player-defaut-LEMANS.png" alt="Le Mans"/>
							<?php		
									}
									if($le_tag=="angers"){
							?>
										<img src="<?php bloginfo( 'template_url' ); ?>/img/image-player-defaut-ANGERS.png" alt="Angers"/>
							<?php		
									}
									if($le_tag=="tours"){
							?>
										<img src="<?php bloginfo( 'template_url' ); ?>/img/image-player-defaut-TOURS.png" alt="Tours"/>
							<?php		
									}
									if($le_tag=="talm"){
							?>
										<img src="<?php bloginfo( 'template_url' ); ?>/img/image-player-defaut-TALM.png" alt="TALM"/>
							<?php		
									}
								}
							?> 
						</div>
						<div class="textes">
							<h3 class="actu_<?php echo $le_tag;?>"><?php echo $le_tag;?></h3>
							<h2><a href="<?php echo get_permalink($pages[$i]->ID);?>"><?php echo get_the_title($pages[$i]->ID);?></a></h2>
							<p class="type"><?php echo $la_categorie;?></p>
							<h4><?php echo get_field("sous_titre",$pages[$i]->ID);?></h4>

							
							<p class="resume"><?php the_excerpt_max_charlength_by_param(250,$pages[$i]->ID);?><?php //echo $pages[$i]->post_excerpt;?></p>
							<a href="<?php echo get_permalink($pages[$i]->ID);?>" class="suite">lire la suite</a>
						</div>
					</div>
<?php
				}
?>
			</div>
		</div>
	</article>
</div>
