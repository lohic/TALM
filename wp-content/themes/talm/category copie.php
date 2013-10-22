<?php get_header(); ?> <!-- ouvrir header.php -->
    <div id="content" class="right">                       
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
                    <div id="navigation">
					<?php posts_nav_link(' / ','page suivante','page pr&eacute;c&eacute;dente'); ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
            <div class="column2">
                <?php
                    global $query_string;
                    $query_args = explode("&", $query_string);
                    $search_query = array();
                ?>
                <h1 class="titre"><?php single_cat_title(); ?> </h1>
                <?php if ( have_posts() ) :     
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    global $query_string;
                ?>
                          
                <?php while ( have_posts() ) : the_post() ?>
                        <article class="search">
                            <header>
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
                            </header>
                            <content>
                                <?php the_excerpt(); ?> 
                                <a href="<?php the_permalink(); ?>" class="suite">Lire la suite</a>
                            </content>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Aucun résultat pour votre recherche</p>
                <?php endif; ?>                
            </div>
        </div>
        <div class="reset"></div>
    </div>
</div>
    <!-- END CONTENT-->
</div>
<?php get_footer(); ?>
