<?php
/*
Template Name: Page modulable
*/
?>
<?php get_header(); ?> <!-- ouvrir header.php -->
	<div id="content" class="right">
            <!--<div id="ariane" class="module">
                <?php 
                    /*if(function_exists('bcn_display')){
                        bcn_display();
                    }*/
                ?>
            </div>-->
            
		<?php get_template_part( 'hierarchy' ); ?>
	</div>
</div>
    <!-- END CONTENT-->
</div>
<?php get_footer(); ?>
