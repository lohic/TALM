<?php
//Gabarit du formulaire de recherche
?>
<form action="<?php echo home_url( '/' ); ?>" method="get" id="recherche">
    <fieldset>
        <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" title="recherche" />
        <input type="submit" value="OK" />
    </fieldset>
</form>