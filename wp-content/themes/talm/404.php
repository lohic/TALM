<?php get_header(); ?> <!-- ouvrir header.php -->
	<div id="content" class="right">
		<div class="full">
            
        	<div class="column1">
        		<div>
	            	
				</div>
			</div>
			<div class="column2">
                <article>
                    <header>
                        <h2>Erreur 404</h2>
                    </header>
                    <content>
						<p><em>La page recherchée est introuvable. Peut-être souhaitez-vous faire une recherche?</em></p>
						<form action="<?php echo home_url( '/' ); ?>" method="get" id="recherche_404">
						    <fieldset>
						        <input type="text" name="s" id="search_404" value="<?php the_search_query(); ?>" title="recherche" />
						        <input type="submit" value="OK" />
						    </fieldset>
						</form>
					</content>
                </article>
            </div>
		</div>
		<div class="reset"></div>
	</div>
</div>
    <!-- END CONTENT-->
</div>
<?php get_footer(); ?>
