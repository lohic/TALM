<?php get_header(); ?> <!-- ouvrir header.php -->
    <div id="content" class="right">

    <div class="full sans">
        <div id="conteneur_isotope">
            <section id="options"> 
                <p>Catégorie&nbsp;:&nbsp;<?php single_cat_title(); ?></p>
            </section>
<?php
        
    

    if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
    elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
    else { $paged = 1; }

    //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    query_posts($query_string . '&posts_per_page=12&orderby=date&order=DESC&paged='.$paged);
        
    if ( have_posts() ) : 

        //$my_query_listing = new WP_Query(array('post_status'=>array('publish','future'), 'order' => 'DESC','orderby' => 'date', 'posts_per_page'=>12, 'paged' => $paged));
        
        $max_num_pages = $wp_query->max_num_pages;
        
        if($max_num_pages>1){
?>
        <section class="pagination_isotope smaller mb2">
            <span class="page">Page</span>
            <?php
                $big = 99999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?page=%#%',
                    'current' => max( 1, $paged ),
                    'total' => $max_num_pages,
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

        while ( have_posts() ) : the_post();

            $la_categorie="";
            $les_categories = get_the_category();
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
                            </footer>
                            <p class="type"><?php the_category(', ');?></p>
                        <?php
                        }
                        else {
                        ?>
                            <header id="header_<?php the_ID();?>">
                                <h3><?php echo $le_tag_name;?></h3>
                                <h2><?php echo CharacterLimiter(get_the_title(),30);?></h2>
                                <h4><?php the_field("sous_titre");?></h4>
                            </header>
                            <p class="type"><?php the_category(', ');?></p>
                        <?php
                        }
                        ?>
                            
                    </a>
                </article>
            <?php 
            endwhile;
            endif;
?>              
        </section>
<?php
        if($max_num_pages>1){
?>
            <section class="pagination_isotope basse smaller mb2">
                <span class="page">Page</span>
                <?php
                    $big = 99999999; // need an unlikely integer

                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total' => $max_num_pages,
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
    <!-- END CONTENT-->
    </div>
</div>
</div>
<?php get_footer(); ?>
