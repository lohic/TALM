<div id="frm-dynamic-values" class="tabs-panel" style="display:none;max-height:none;padding-right:0;">
	<p class="howto"><?php _e('Use dynamic default values by entering the shortcodes below as the default text.', 'formidable') ?>
    <ul style="margin-bottom:0;">
        <?php foreach ($tags as $tag => $label){ ?>
            <li><strong><?php echo $label ?>:</strong>
            <?php if ($tag == 'get param=whatever'){ ?>
                <img src="<?php echo FRM_IMAGES_URL ?>/tooltip.png" alt="?" class="frm_help" title="<?php _e('A variable from the URL or value posted from previous page.', 'formidable') ?>" />
            <?php } ?>
            [<?php echo $tag ?>]
            <?php if ($tag == 'get param=whatever'){ ?>
                <img src="<?php echo FRM_IMAGES_URL ?>/tooltip.png" alt="?" class="frm_help" title="<?php _e('Replace \'whatever\' with the parameter name. In url.com?product=form, the variable is \'product\'. You would use [get param=product] in your field.', 'formidable') ?>" />
            <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>
