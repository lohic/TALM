<div id="taxonomy-linkcategory" class="categorydiv">
	<ul id="category-tabs" class="category-tabs frm-category-tabs">
		<li class="tabs" ><a href="#frm-insert-fields"><?php _e( 'Insert Fields', 'formidable' ); ?></a></li>
		<li class="hide-if-no-js"><a href="#frm-conditionals"><?php _e( 'Conditionals', 'formidable' ); ?></a></li>
		<li class="hide-if-no-js"><a href="#frm-adv-info-tab"><?php _e( 'Advanced', 'formidable' ); ?></a></li>
	</ul>

	<div id="frm-insert-fields" class="tabs-panel" style="max-height:none;padding-right:0;">
	    <?php include(FRM_VIEWS_PATH .'/shared/mb_insert_fields.php') ?>
	</div>

	<div id="frm-conditionals" class="tabs-panel" style="display:none;max-height:none;padding-right:0;">
	    <ul class="subsubsub" style="float:right;margin:0;">
	        <li><a class="current frmids" onclick="frmToggleKeyID('frmids');"><?php _e('IDs', 'formidable') ?></a> |</li>
	        <li><a class="frmkeys" onclick="frmToggleKeyID('frmkeys');"><?php _e('Keys', 'formidable') ?></a></li>
	    </ul>
	    <ul class="alignleft" style="margin:5px 0 0;"><li><?php _e('Fields from your form', 'formidable') ?>:</li></ul>
	    <ul class="frm_code_list frm_full_width" style="clear:both;max-height:150px;overflow:auto;">
		    <?php if(!empty($fields)){
		        foreach($fields as $f){ 
		            $f->field_options = maybe_unserialize($f->field_options);
                    if($f->type == 'data' and (!isset($f->field_options['data_type']) or $f->field_options['data_type'] == 'data' or $f->field_options['data_type'] == ''))
                        continue;
                ?>
                <li>
                    <a class="frmids alignright" onclick="frmInsertFieldCode(jQuery(this),'if <?php echo $f->id ?>]<?php _e('Conditional text here', 'formidable') ?>[/if <?php echo $f->id ?>');return false;" href="#">[if <?php echo $f->id ?>]</a>
                	<a class="frmkeys alignright" onclick="frmInsertFieldCode(jQuery(this),'if <?php echo $f->field_key ?>]something[/if <?php echo $f->field_key ?>');return false;" href="#">[if <?php echo FrmAppHelper::truncate($f->field_key, 10) ?>]</a>
                	<a onclick="frmInsertFieldCode(jQuery(this),'<?php echo $f->id ?>');return false;" href="#"><?php echo FrmAppHelper::truncate($f->name, 60) ?></a>
                </li>
                <?php
                
                if($f->type == 'user_id')
                    $uid = $f;
                else if($f->type == 'file')
                    $file = $f;
                    
		        unset($f);
		        }
		    } ?>
        </ul>
        
        <p class="howto"><?php _e('Click a button below to insert sample logic into your custom display', 'formidable') ?></p>
        <ul class="frm_code_list">
        <?php
        $col = 'one';
        foreach($cond_shortcodes as $skey => $sname){
	    ?>
	    <li class="frm_col_<?php echo $col ?>">
	        <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'if 125 <?php echo $skey ?>][/if 125');return false;" href="#"><?php echo $sname ?></a>
	    </li>
	    <?php
	        $col = ($col == 'one') ? 'two' : 'one';
	        unset($skey);
	        unset($sname);
	    }
        ?>
        </ul>
        
	</div>
	
	<div id="frm-adv-info-tab" class="tabs-panel" style="display:none;max-height:355px;">
		<ul class="frm_code_list">
        <?php
        $col = 'one';
        foreach($adv_shortcodes as $skey => $sname){
	    ?>
	    <li class="frm_col_<?php echo $col ?>">
	        <a class="frmbutton button <?php echo is_array($sname) ? 'frm_help' : ''; ?>" onclick="frmInsertFieldCode(jQuery(this),'125 <?php echo $skey ?>');return false;" href="#" <?php echo is_array($sname) ? 'title="'. $sname['title'] .'"' : ''; ?>><?php echo is_array($sname) ? $sname['label'] : $sname; ?></a>
	    </li>
	    <?php
	        $col = ($col == 'one') ? 'two' : 'one';
	        unset($skey);
	        unset($sname);
	    }
        ?>
        <?php if(isset($file)){ ?>
        <li class="frm_col_<?php echo $col ?>">
	        <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $file->id ?> size=thumbnail html=1');return false;" href="#"><?php _e('Image Size', 'formidable') ?></a>
	    </li>
	    <li class="frm_col_<?php echo $col = (($col == 'one') ? 'two' : 'one') ?>">
	        <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $file->id ?> show=id');return false;" href="#"><?php _e('Image ID', 'formidable') ?></a>
	    </li>
	    <li class="frm_col_<?php echo $col = (($col == 'one') ? 'two' : 'one') ?>">
	        <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $file->id ?> show=label');return false;" href="#"><?php _e('Image Name', 'formidable') ?></a>
	    </li>
	    <?php } ?>
        </ul>

        <?php if(isset($uid)){ 
            $col = 'one'; ?>
        <div class="clear"></div>
        <p class="howto"><?php _e('Insert user information', 'formidable') ?></p>    
        <ul class="frm_code_list">
        <?php foreach($user_fields as $uk => $uf){ ?>
            <li class="frm_col_<?php echo $col ?>">
                <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $uid->id .' show=&#34;'. $uk .'&#34;' ?>');return false;" href="#"><?php echo $uf ?></a>
    	    </li>
        <?php 
            $col = ($col == 'one') ? 'two' : 'one';   
            unset($uf);
            unset($uk);
        } 
        unset($uid); ?>
        </ul>
        <?php } 
        
        if(isset($dfe)){ ?>
            
        <div class="clear"></div>
        <p class="howto"><?php _e('Data From Entries options', 'formidable') ?></p>
            <ul class="frm_code_list">
        	    <li class="frm_col_one">
                    <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $dfe .' show=&#34;created-at&#34;' ?>');return false;" href="#"><?php _e('Creation Date', 'formidable')?></a>
        	    </li>
        	    <li class="frm_col_two">
                    <a class="frmbutton button" onclick="frmInsertFieldCode(jQuery(this),'<?php echo $dfe .' show=&#34;'. $ldfe .'&#34;' ?>');return false;" href="#"><?php _e('Field From Entry', 'formidable')?></a>
        	    </li>
            </ul>
        <?php } ?>

	</div>

</div>
