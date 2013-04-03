<?php
class FrmProNotification{
    function FrmProNotification(){
        add_filter('frm_stop_standard_email', array(&$this, 'stop_standard_email'));
        add_action('frm_after_create_entry', array(&$this, 'entry_created'), 11, 2);
        add_action('frm_after_update_entry', array(&$this, 'entry_updated'), 11, 2);
        add_action('frm_after_create_entry', array(&$this, 'autoresponder'), 11, 2);
    }
    
    function stop_standard_email(){
        return true;
    }
    
    function entry_created($entry_id, $form_id, $create=true){
        if(defined('WP_IMPORTING'))
            return;
            
        global $frm_form, $frm_field, $frm_entry, $frm_entry_meta, $frm_notification, $frmpro_settings;

        $form = $frm_form->getOne($form_id);
        $form_options = maybe_unserialize($form->options);
        $entry = $frm_entry->getOne($entry_id, true);
        $sent_to = array();
        $notifications = (isset($form_options['notification'])) ? $form_options['notification'] : array(0 => $form_options);
        $fields = $frm_field->getAll(array('fi.form_id' => $form_id));
        
        $temp_fields = array();
        foreach($fields as $k => $f){
            if(!isset($entry->metas[$f->id])){
                $f->field_options = maybe_unserialize($f->field_options);
                if(isset($f->field_options['post_field']) and !empty($f->field_options['post_field'])){
                    //get value from linked post
                    $entry->metas[$f->id] = FrmProEntryMetaHelper::get_post_or_meta_value($entry, $f, array('links' => false));
                    if($entry->metas[$f->id] == '') //and !include_blank
                        unset($entry->metas[$f->id]);
                //}else if(include_blank){
                //    $entry->metas[$f->id] = '';
                }
            }
            
            $temp_fields[$f->id] = $f;
            unset($fields[$k]);
            unset($k);
            unset($f);
        }
        
        $fields = $temp_fields;
        unset($temp_fields);
        
        foreach($notifications as $notification){
            if(isset($notification['update_email'])){
                if($create and $notification['update_email'] == 2)
                    continue;
                
                if(!$create and empty($notification['update_email']))
                    continue;
            }
            
            //check if conditions are met
            $stop = $this->conditions_met($notification, $entry);
            if($stop)
                continue;
            
            $to_email = $notification['email_to'];
            $email_fields = (isset($notification['also_email_to'])) ? (array)$notification['also_email_to'] : array();
            $entry_ids = array($entry->id);
            $exclude_fields = array();
        
        foreach($email_fields as $key => $email_field){
            $email_fields[$key] = (int)$email_field;
            if(preg_match('/|/', $email_field)){
                $email_opt = explode('|', $email_field);
                if(isset($email_opt[1])){
                    if(isset($entry->metas[$email_opt[0]])){
                        $add_id = $entry->metas[$email_opt[0]];

                        $add_id = maybe_unserialize($add_id);
                        if(is_array($add_id)){
                            foreach($add_id as $add)
                                $entry_ids[] = $add;
                        }else{
                            $entry_ids[] = $add_id;
                        }
                    }

                    //skip the data field if it will be fetched through the other form
                    $exclude_fields[] = $email_opt[0];
                    $email_fields[$key] = (int)$email_opt[1];
                }
                unset($email_opt);
            }
        }

        if ($to_email == '' and empty($email_fields)) return;
        
        foreach($email_fields as $email_field){
            if(isset($notification['reply_to_name']) and preg_match('/|/', $email_field)){
                $email_opt = explode('|', $notification['reply_to_name']);
                if(isset($email_opt[1])){
                    if(isset($entry->metas[$email_opt[0]]))
                        $entry_ids[] = $entry->metas[$email_opt[0]];
                    //skip the data field if it will be fetched through the other form
                    $exclude_fields[] = $email_opt[0];
                }
                unset($email_opt);
            }
        }

        $where = '';
        if(!empty($exclude_fields))
            $where = " and it.field_id not in (".implode(',', $exclude_fields).")";
        $values = $frm_entry_meta->getAll("it.field_id != 0 and it.item_id in (". implode(',', $entry_ids).")". $where, " ORDER BY fi.field_order");
        
        $to_emails = array();
        if($to_email)
            $to_emails = explode(',', $to_email);
        
        $plain_text = (isset($notification['plain_text']) and $notification['plain_text']) ? true : false;
        $custom_message = false;
        $get_default = true;
        $mail_body = '';
        if(isset($notification['email_message']) and trim($notification['email_message']) != ''){
            if(!preg_match('/\[default-message\]/', $notification['email_message']))
                $get_default = false;
            
            if(isset($notification['ar']) and $notification['ar']){
                //don't continue with blank autoresponder message for reverse compatability
                if($notification['email_message'] == '') return;
                $notification['email_message'] = apply_filters('frm_ar_message', $notification['email_message'], array('entry' => $entry, 'form' => $form));
            }
            
            $custom_message = true;
            $shortcodes = FrmProAppHelper::get_shortcodes($notification['email_message'], $entry->form_id);
            $mail_body  = FrmProFieldsHelper::replace_shortcodes($notification['email_message'], $entry, $shortcodes);
        }
        
        $reply_to_name = $frm_blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);  //default sender name
        $odd = true;
        $attachments = array();
        
        foreach ($values as $value){
            $field = (isset($fields[$value->field_id])) ? $fields[$value->field_id] : false;
            $prev_val = maybe_unserialize($value->meta_value);
            
            if($value->field_type == 'file'){
                global $frmdb;
                if($field)
                    $file_options = $field->field_options;
                else
                    $file_options = $frmdb->get_var($frmdb->fields, array('id' => $value->field_id), 'field_options');
                $file_options = maybe_unserialize($file_options);
                if(isset($file_options['attach']) and $file_options['attach']){
                    foreach((array)$prev_val as $m){
                        $file = get_post_meta( $m, '_wp_attached_file', true);
                    	if($file){
                    	    if(!isset($uploads) or !isset($uploads['basedir']))
                    	        $uploads = wp_upload_dir();
                    	    $attachments[] = $uploads['basedir'] . "/$file";
                    	}
                    	unset($m);
                	}
                }
                    
            }
        
            $val = apply_filters('frm_email_value', $prev_val, $value, $entry);

            if($value->field_type == 'textarea' and !$plain_text)
                $val = str_replace(array("\r\n", "\r", "\n"), ' <br/>', $val);
            
            if (is_array($val))
                $val = implode(', ', $val);
                
            if(isset($notification['reply_to']) and (int)$notification['reply_to'] == $value->field_id){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $reply_to = $user_data->user_email;
                }else if(is_email($val)){
                    $reply_to = $val;
                }else if(is_email($prev_val)){
                    $reply_to = $prev_val;
                }
            }
            
            if(isset($notification['reply_to_name']) and (int)$notification['reply_to_name'] == $value->field_id){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $reply_to_name = $user_data->display_name;
                }else
                    $reply_to_name = $val;
            }

            if(in_array($value->field_id, $email_fields)){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $to_emails[] = $user_data->user_email;
                }else{
                    $val = explode(',', $val);
                    $prev_val = explode(',', $prev_val);
                    
                    if(is_array($val) or is_array($prev_val)){
                        foreach((array)$val as $v){
                            $v = trim($v);
                            if(is_email($v))
                                $to_emails[] = $v;
                            unset($v);
                        }
                        
                        foreach((array)$prev_val as $v){
                            $v = trim($v);
                            if(is_email($v) and !in_array($v, $to_emails))
                                $to_emails[] = $v;
                            unset($v);
                        }
                    }else if(is_email($val)){
                        $to_emails[] = $val;
                    }else if(is_email($prev_val)){
                        $to_emails[] = $prev_val;
                    }
                }
            }
        }
        unset($prev_val);
        
        $attachments = apply_filters('frm_notification_attachment', $attachments, $form, array('entry' => $entry));
        if(isset($notification['ar']) and $notification['ar'])
            $attachments = apply_filters('frm_autoresponder_attachment', array(), $form);
        
        
        if(!isset($reply_to)){
            if($notification['reply_to'] == 'custom')
                $reply_to = isset($notification['cust_reply_to']) ? $notification['cust_reply_to'] : '[admin_email]';
            
            if(empty($reply_to))  
                $reply_to = '[admin_email]';
            
            //global $frm_settings;
            //$reply_to = $frm_settings->email_to;
        }
        
        if(empty($reply_to_name)){
            if($notification['reply_to_name'] == 'custom')
                $reply_to_name = isset($notification['cust_reply_to_name']) ? $notification['cust_reply_to_name'] : $reply_to_name;
        }
        
        if(isset($notification['inc_user_info']) and $notification['inc_user_info'] and !$get_default){
            $data = maybe_unserialize($entry->description);
            $mail_body .= "\r\n\r\n" . __('User Information', 'formidable') ."\r\n";
            $mail_body .= __('IP Address', 'formidable') . ": ". $entry->ip ."\r\n";
            $mail_body .= __('User-Agent (Browser/OS)', 'formidable') . ": ". $data['browser']."\r\n";
            $mail_body .= __('Referrer', 'formidable') . ": ". $data['referrer']."\r\n";
        }
        
        if(isset($notification['email_subject']) and $notification['email_subject'] != ''){
            $shortcodes = FrmProAppHelper::get_shortcodes($notification['email_subject'], $entry->form_id);
            $subject = FrmProFieldsHelper::replace_shortcodes($notification['email_subject'], $entry, $shortcodes);
            $subject = apply_filters('frm_email_subject', $subject, compact('form', 'entry'));
            
            if(isset($notification['ar']) and $notification['ar'])
                $subject = apply_filters('frm_ar_subject', $subject, $form);
        }else{
            //set default subject
            $subject = sprintf(__('%1$s Form submitted on %2$s', 'formidable'), stripslashes($form->name), $frm_blogname);
        }
        
        if($get_default){
            $default = FrmProEntriesController::show_entry_shortcode(array(
                'id' => $entry->id, 'entry' => $entry, 'plain_text' => $plain_text, 'fields' => $fields, 
                'user_info' => (isset($notification['inc_user_info']) ? $notification['inc_user_info'] : false)
            ));
            
            if($custom_message)
                $mail_body = str_replace('[default-message]', $default, $mail_body);
            else
                $mail_body = $default;
        }
        
        $to_emails = apply_filters('frm_to_email', $to_emails, $values, $form_id);
        foreach((array)$to_emails as $to_email){
            $sent_to[] = $to_email = apply_filters('frm_content', $to_email, $form, $entry_id);
            $frm_notification->send_notification_email(trim($to_email), $subject, $mail_body, $reply_to, $reply_to_name, $plain_text, $attachments);
        }
        unset($notification);
        }

        return $sent_to;
    }
    
    function entry_updated($entry_id, $form_id){
        //send update email notification
        global $frm_form;
        $form = $frm_form->getOne($form_id);
        $form->options = maybe_unserialize($form->options);
        $notifications = (isset($form->options['notification'])) ? $form->options['notification'] : array(0 => $form->options);
        
        $email = false;
        $ar = false;
        
        foreach($notifications as $notification){
            if($email and $ar)
                break;
                
            if(!$email and isset($notification['update_email']) and $notification['update_email'])
                $email = true;
                
            if(!$ar and isset($notification['ar_update_email']) and $notification['ar_update_email'])
                $ar = true;
                
            unset($notification);
        }
        
        if($email)
            $this->entry_created($entry_id, $form_id, false);
            
        if($ar)
            $this->autoresponder($entry_id, $form_id);
    }
    
    function autoresponder($entry_id, $form_id){
        if(defined('WP_IMPORTING'))
            return;
            
        global $frm_form, $frm_entry, $frm_entry_meta, $frm_notification;

        $form = $frm_form->getOne($form_id);
        $form_options = maybe_unserialize($form->options);

        if (!isset($form_options['auto_responder']) or !$form_options['auto_responder'] or !isset($form_options['ar_email_message']) or $form_options['ar_email_message'] == '') 
            return; //don't continue forward unless a message has been inserted
        
        $entry = $frm_entry->getOne($entry_id, true);
        $entry_ids = array($entry->id);
        
        $email_field = (isset($form_options['ar_email_to'])) ? $form_options['ar_email_to'] : 0;
        if(preg_match('/|/', $email_field)){
            $email_fields = explode('|', $email_field);
            if(isset($email_fields[1])){
                if(isset($entry->metas[$email_fields[0]])){
                    $add_id = $entry->metas[$email_fields[0]];
                
                    $add_id = maybe_unserialize($add_id);
                    if(is_array($add_id)){
                        foreach($add_id as $add)
                            $entry_ids[] = $add;
                    }else{
                        $entry_ids[] = $add_id;
                    }
                }
                
                $email_field = $email_fields[1];
            }
            unset($email_fields);
        }
        
        $inc_fields = array();
        foreach(array($email_field) as $inc_field){
            if($inc_field)
                $inc_fields[] = $inc_field;
        }
        
        $where = "it.item_id in (". implode(',', $entry_ids).")";
        if(!empty($inc_fields)){
            $inc_fields = implode(',', $inc_fields);
            $where .= " and it.field_id in ($inc_fields)";
        }
        
        $values = $frm_entry_meta->getAll($where, " ORDER BY fi.field_order");

        $plain_text = (isset($form_options['ar_plain_text']) and $form_options['ar_plain_text']) ? true : false;
        
        $message = apply_filters('frm_ar_message', $form_options['ar_email_message'], array('entry' => $entry, 'form' => $form));
        $shortcodes = FrmProAppHelper::get_shortcodes($message, $form_id);
        $mail_body  = FrmProFieldsHelper::replace_shortcodes($message, $entry, $shortcodes);
        
        $frm_blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $reply_to_name = (isset($form_options['ar_reply_to_name'])) ? $form_options['ar_reply_to_name'] : $frm_blogname; //default sender name
        $reply_to = (isset($form_options['ar_reply_to'])) ? $form_options['ar_reply_to'] : '[admin_email]';  //default sender email

        foreach ($values as $value){
            /*
            if((int)$reply_field == $value->field_id){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $reply_to = $user_data->user_email;
                }else{
                    $val = apply_filters('frm_email_value', maybe_unserialize($value->meta_value), $value, $entry);
                    if(is_email($val))
                        $reply_to = $val;
                }
            }
            
            if((int)$reply_name_field == $value->field_id){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $reply_to_name = $user_data->display_name;
                }else
                    $reply_to_name = apply_filters('frm_email_value', maybe_unserialize($value->meta_value), $value, $entry);
            } */

            if((int)$email_field == $value->field_id){
                if($value->field_type == 'user_id'){
                    $user_data = get_userdata($value->meta_value);
                    $to_email = $user_data->user_email;
                }else{
                    $val = apply_filters('frm_email_value', maybe_unserialize($value->meta_value), $value, $entry);
                    if(is_email($val))
                        $to_email = $val;
                }
            }
        }
        
        if(!isset($to_email)) return;
        
        if(isset($form_options['ar_email_subject']) and $form_options['ar_email_subject'] != ''){
            $shortcodes = FrmProAppHelper::get_shortcodes($form_options['ar_email_subject'], $form_id);
            $subject = FrmProFieldsHelper::replace_shortcodes($form_options['ar_email_subject'], $entry, $shortcodes);
        }else{
            $subject = sprintf(__('%1$s Form submitted on %2$s', 'formidable'), stripslashes($form->name), $frm_blogname); //subject
        }
        
        $subject = apply_filters('frm_ar_subject', $subject, $form);
        $attachments = apply_filters('frm_autoresponder_attachment', array(), $form);
        
        $frm_notification->send_notification_email($to_email, $subject, $mail_body, $reply_to, $reply_to_name, $plain_text, $attachments);
        
        return $to_email;
    }
    
    //check if conditions are met
    function conditions_met($notification, $entry){
        $stop = false;
        $met = array();
        
        if(!isset($notification['conditions']) or !empty($notification['conditions']))
            return $stop;
            
        foreach($notification['conditions'] as $k => $condition){
            if(!is_numeric($k))
                continue;
                
            if($stop and $notification['conditions']['any_all'] == 'any' and $notification['conditions']['send_stop'] == 'stop')
                continue;

            $observed_value = (isset($entry->metas[$condition['hide_field']])) ? $entry->metas[$condition['hide_field']] : '';

            $stop = FrmProFieldsHelper::value_meets_condition($observed_value, $condition['hide_field_cond'], $condition['hide_opt']);

            if($notification['conditions']['send_stop'] == 'send')
                $stop = $stop ? false : true;
            
            $met[$stop] = $stop;
        }
        
        if($notification['conditions']['any_all'] == 'all' and !empty($met) and isset($met[0]) and isset($met[1]))
            $stop = ($notification['conditions']['send_stop'] == 'send') ? true : false;
        else if($notification['conditions']['any_all'] == 'any' and $notification['conditions']['send_stop'] == 'send' and isset($met[0]))
            $stop = false;
  
        return $stop;
    }

}
?>