<?php $current_page = (isset($_GET['page'])) ? $_GET['page'] : (isset($_GET['post_type']) ? $_GET['post_type'] : 'None'); ?>
<ul class="frm_form_nav">
<li class="last"> <a<?php if($current_page == 'formidable-reports') echo ' class="current_page"'; ?> href="<?php echo esc_url(admin_url('admin.php?page=formidable') . "-reports&frm_action=show&form=$id&show_nav=1") ?>"><?php _e('Reports', 'formidable') ?></a></li>
<li> <a<?php if($current_page == 'frm_display' or $pagenow == 'post.php' or $pagenow == 'post-new.php') echo ' class="current_page"'; ?> href="<?php echo esc_url(admin_url('edit.php?post_type=frm_display') . "&form=$id&show_nav=1") ?>"><?php _e('Displays', 'formidable') ?></a></li>
<li> <a<?php if($current_page == 'formidable-entries') echo ' class="current_page"'; ?> href="<?php echo admin_url('admin.php?page=formidable') ?>-entries&amp;frm_action=list&amp;form=<?php echo $id ?>"><?php _e('Entries', 'formidable') ?></a></li>
<li><a<?php if(($current_page == 'formidable' or $current_page == 'formidable-new') and isset($_GET['frm_action']) and $_GET['frm_action'] == 'settings') echo ' class="current_page"'; ?> href="<?php echo admin_url('admin.php?page=formidable') ?>&amp;frm_action=settings&amp;id=<?php echo $id ?>"><?php _e('Settings', 'formidable') ?></a> </li>
<li class="first"><a<?php if(($current_page == 'formidable' or $current_page == 'formidable-new') and isset($_GET['frm_action']) and (in_array($_GET['frm_action'], array('edit', 'new', 'duplicate')))) echo ' class="current_page"'; ?> href="<?php echo admin_url('admin.php?page=formidable') ?>&amp;frm_action=edit&amp;id=<?php echo $id ?>"><?php _e('Build', 'formidable') ?></a> </li>
</ul>
<div class="clear"></div>
