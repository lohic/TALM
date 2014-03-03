<?php
/**
 * @package Formidable
 */ 

if(!defined('ABSPATH')) die(__('You are not allowed to call this page directly.', 'formidable'));

if(class_exists('FrmFormsController'))
    return;
 
class FrmFormsController{
    function FrmFormsController(){
        add_action('admin_menu', 'FrmFormsController::menu', 10);
        add_action('admin_menu', 'FrmFormsController::mid_menu', 40);
        add_action('admin_head-toplevel_page_formidable', 'FrmFormsController::head');
        add_action('wp_ajax_frm_form_key_in_place_edit', 'FrmFormsController::edit_key');
        add_action('wp_ajax_frm_form_desc_in_place_edit', 'FrmFormsController::edit_description');
        add_action('wp_ajax_frm_delete_form_wo_fields', 'FrmFormsController::destroy_wo_fields');
        add_action('wp_ajax_frm_save_form', 'FrmFormsController::route');
        add_filter('frm_submit_button', 'FrmFormsController::submit_button_label');
        add_filter('media_buttons_context', 'FrmFormsController::insert_form_button');
        //add_action('media_buttons', 'FrmFormsController::show_form_button', 20);
        add_action('admin_footer',  'FrmFormsController::insert_form_popup');
        
        add_filter('set-screen-option', 'FrmFormsController::save_per_page', 10, 3);
        
        add_action('wp_ajax_frm_forms_preview', 'FrmFormsController::preview');
        add_action('wp_ajax_nopriv_frm_forms_preview', 'FrmFormsController::preview');
    }
    
    public static function menu(){
        global $frm_settings;
        add_submenu_page('formidable', $frm_settings->menu .' | '. __('Forms', 'formidable'), __('Forms', 'formidable'), 'frm_view_forms', 'formidable', 'FrmFormsController::route');
        
        add_action('admin_head-'. sanitize_title($frm_settings->menu) .'_page_formidable-templates', 'FrmFormsController::head');
        
        add_filter('manage_toplevel_page_formidable_columns', 'FrmFormsController::get_columns', 0 );
	    add_filter('manage_'. sanitize_title($frm_settings->menu) .'_page_formidable-templates_columns', 'FrmFormsController::get_columns', 0 );
	    add_filter('manage_toplevel_page_formidable_sortable_columns', 'FrmFormsController::get_sortable_columns');
	    add_filter('manage_'. sanitize_title($frm_settings->menu) .'_page_formidable-templates_sortable_columns', 'FrmFormsController::get_sortable_columns');
	    add_filter('get_user_option_managetoplevel_page_formidablecolumnshidden', 'FrmFormsController::hidden_columns');
	    add_filter('get_user_option_manage'. sanitize_title($frm_settings->menu) .'_page_formidable-templatescolumnshidden', 'FrmFormsController::hidden_columns');
    }
    
    public static function mid_menu(){
        global $frm_settings;
        add_submenu_page('formidable', $frm_settings->menu .' | '. __('Templates', 'formidable'), __('Templates', 'formidable'), 'frm_view_forms', 'formidable-templates', 'FrmFormsController::template_list');
    }
    
    public static function head(){
        global $frm_settings;

        wp_enqueue_script('formidable-editinplace');
        wp_enqueue_script('jquery-frm-themepicker');
    }
    
    public static function list_form(){
        $params = self::get_params();
        $errors = apply_filters('frm_admin_list_form_action', array());
        return self::display_forms_list($params, '', false, false, $errors);
    }
    
    public static function template_list(){
        $_POST['template'] = 1;
        $errors = apply_filters('frm_admin_list_form_action', array());
        return self::display_forms_list();
    }
    
    public static function new_form($values=false){
        global $frm_vars;
        
        $action = isset($_REQUEST['frm_action']) ? 'frm_action' : 'action';
        $action = ($values) ? $values[$action] : FrmAppHelper::get_param($action);
        $frm_form = new FrmForm();
        
        if ($action == 'create'){
            return self::create($values);
        }else if ($action == 'new'){
            $frm_field_selection = FrmFieldsHelper::field_selection();  
            $values = FrmFormsHelper::setup_new_vars($values);
            $id = $frm_form->create( $values );
            $values['id'] = $id;
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/new.php');
        }else{
            $all_templates = $frm_form->getAll(array('is_template' => 1), 'name');
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/new-selection.php');
        }
    }
    
    public static function create($values=false){
        global $frm_entry, $frm_field, $frm_vars;
        if(!$values)
            $values = $_POST;
        
        if($_POST and (!isset($values['frm_save_form']) or !wp_verify_nonce($values['frm_save_form'], 'frm_save_form_nonce'))){
            global $frm_settings;
            $errors['form'] = $frm_settings->admin_permission;
        }
        
        $id = isset($values['id']) ? (int)$values['id'] : (int)FrmAppHelper::get_param('id');
        
        $frm_form = new FrmForm();
        $errors = $frm_form->validate($values);
        
        if( count($errors) > 0 ){
            $hide_preview = true;
            $frm_field_selection = FrmFieldsHelper::field_selection();
            $record = $frm_form->getOne( $id );
            $fields = $frm_field->getAll(array('fi.form_id' => $id), 'field_order');
            $values = FrmAppHelper::setup_edit_vars($record, 'forms', $fields, true);
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/new.php');
        }else{    
            $record = $frm_form->update( $id, $values, true );
            die(FrmAppHelper::js_redirect(admin_url('admin.php?page=formidable&frm_action=settings&id='. $id)));
            //$message = __('Form was Successfully Created', 'formidable');
            //return self::settings($record, $message);
        }
    }
    
    public static function edit($values=false){
        $id = isset($values['id']) ? (int)$values['id'] : (int)FrmAppHelper::get_param('id');
        return self::get_edit_vars($id);
    }
    
    public static function settings($id=false, $message=''){
        if(!$id or !is_numeric($id))
            $id = isset($values['id']) ? (int)$values['id'] : (int)FrmAppHelper::get_param('id');
        return self::get_settings_vars($id, '', $message);
    }
    
    public static function update_settings(){
        $id = FrmAppHelper::get_param('id');
        
        $frm_form = new FrmForm();
        $errors = $frm_form->validate($_POST);
        
        if( count($errors) > 0 ){
            return self::get_settings_vars($id, $errors);
        }else{
            $record = $frm_form->update( $_POST['id'], $_POST );
            $message = __('Settings Successfully Updated', 'formidable');
            return self::get_settings_vars($id, '', $message);
        }
    }
    
    public static function edit_key(){
        global $wpdb;
        $values = array('form_key' => trim($_POST['update_value']));
        $frm_form = new FrmForm();
        $form = $frm_form->update($_POST['form_id'], $values);
        $key = $wpdb->get_var($wpdb->prepare("SELECT form_key FROM {$wpdb->prefix}frm_forms WHERE id=%d", $_POST['form_id']));
        echo stripslashes($key);  
        die();
    }

    public static function edit_description(){
        $frm_form = new FrmForm();
        $form = $frm_form->update($_POST['form_id'], array('description' => $_POST['update_value']));
        $description = stripslashes($_POST['update_value']);
        if(apply_filters('frm_use_wpautop', true))
            $description = wpautop(str_replace( '<br>', '<br />', $description));
        echo $description;
        die();
    }
    
    public static function update($values=false){
        $frm_form = new FrmForm();

        if(!$values)
            $values = $_POST;
        
        $errors = $frm_form->validate($values);
        
        if($_POST and (!isset($values['frm_save_form']) or !wp_verify_nonce($values['frm_save_form'], 'frm_save_form_nonce'))){
            global $frm_settings;
            $errors['form'] = $frm_settings->admin_permission;
        }
        
        $id = isset($values['id']) ? (int)$values['id'] : (int)FrmAppHelper::get_param('id');
        
        if( count($errors) > 0 ){
            return self::get_edit_vars($id, $errors);
        }else{
            $record = $frm_form->update( $id, $values );
            $message = __('Form was Successfully Updated', 'formidable');
            return self::get_edit_vars($id, '', $message);
        }
    }
    
    public static function duplicate(){
        $frm_form = new FrmForm();
        
        $params = self::get_params();
        $record = $frm_form->duplicate( $params['id'], $params['template'], true );
        $message = ($params['template']) ? __('Form template was Successfully Created', 'formidable') : __('Form was Successfully Copied', 'formidable');
        if ($record)
            return self::get_edit_vars($record, '', $message, true);
        else
            return self::display_forms_list($params, __('There was a problem creating new template.', 'formidable'));
    }
    
    public static function page_preview(){
        $params = self::get_params();
        if (!$params['form']) return;
        
        $frm_form = new FrmForm();
        $form = $frm_form->getOne($params['form']);
        if(!$form) return;
        return FrmEntriesController::show_form($form->id, '', true, true);
    }

    public static function preview(){
        do_action('frm_wp');
        
        global $frm_settings, $frm_vars;
        $frm_vars['preview'] = true;
        
        $frm_form = new FrmForm();
        if ( !defined( 'ABSPATH' ) && !defined( 'XMLRPC_REQUEST' )) {
            global $wp;
            $root = dirname(dirname(dirname(dirname(__FILE__))));
            include_once( $root.'/wp-config.php' );
            $wp->init();
            $wp->register_globals();
        }
        
        if($frm_vars['pro_is_installed'])
            FrmProEntriesController::register_scripts();
            
        header("Content-Type: text/html; charset=". get_option( 'blog_charset' ));

        $plugin     = FrmAppHelper::get_param('plugin');
        $controller = FrmAppHelper::get_param('controller');
        $key = (isset($_GET['form']) ? $_GET['form'] : (isset($_POST['form']) ? $_POST['form'] : ''));
        $form = $frm_form->getAll(array('form_key' => $key), '', 1);
        if (!$form) $form = $frm_form->getAll(array(), '', 1);
        
        require(FrmAppHelper::plugin_path() .'/classes/views/frm-entries/direct.php');
        die(); 
    }
    
    public static function destroy(){
        if(!current_user_can('frm_delete_forms')){
            global $frm_settings;
            wp_die($frm_settings->admin_permission);
        }
            
        $frm_form = new FrmForm();
        $params = self::get_params();
        $message = '';
        if ($frm_form->destroy( $params['id'] ))
            $message = __('Form was Successfully Deleted', 'formidable');
        self::display_forms_list($params, $message, '', 1);
    }
    
    public static function destroy_wo_fields(){
        global $frm_field, $frmdb, $wpdb;
        $id = $_POST['form_id'];
        if ($frmdb->get_count($wpdb->prefix . 'frm_fields', array('form_id' => $id)) <= 0){
            $frm_form = new FrmForm();
            $frm_form->destroy($id);
        }
        die();
    }
    
    public static function submit_button_label($submit){
        if (!$submit or empty($submit)){ 
            global $frm_settings;
            $submit = $frm_settings->submit_value;
        }
        return $submit;
    }
    
    public static function insert_form_button($content){
        if(current_user_can('frm_view_forms'))
            $content .= '<a href="#TB_inline?width=450&height=550&inlineId=frm_insert_form" class="thickbox button add_media frm_insert_form" title="' . __("Add Formidable Form", 'formidable') . '"><span class="frm-buttons-icon wp-media-buttons-icon"></span> '. __('Add Form', 'formidable') . '</a>';
        return $content;
    }
    
    public static function show_form_button($id){
        if($id != 'content')
            return;
        echo '<a href="#TB_inline?width=450&height=550&inlineId=frm_insert_form" class="thickbox" title="' . __("Add Formidable Form", 'formidable') . '"><img src="'. esc_url(FrmAppHelper::plugin_url() .'/images/form_16.png') .'" alt="' . __("Add Formidable Form", 'formidable') . '" /></a>';
    }
    
    public static function insert_form_popup(){
        $page = basename($_SERVER['PHP_SELF']);
        if(in_array($page, array('post.php', 'page.php', 'page-new.php', 'post-new.php')) or (isset($_GET) and isset($_GET['page']) and $_GET['page'] == 'formidable-entry-templates')){
            if(class_exists('FrmProDisplay')){
                global $frmpro_display;
                $displays = $frmpro_display->getAll('', 'post_title');
            }
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/insert_form_popup.php');   
        }
    }

    public static function display_forms_list($params=false, $message='', $page_params_ov = false, $current_page_ov = false, $errors = array()){
        global $wpdb, $frmdb, $frm_entry, $frm_vars;
        
        if(!$params)
            $params = self::get_params();
        
        $page_params = '&action=0&&frm_action=0&page=formidable';
        
        $frm_form = new FrmForm();
        if ($params['template']){
            $default_templates = $frm_form->getAll(array('default_template' => 1));
            $all_templates = $frm_form->getAll(array('is_template' => 1), 'name');
        }
        
        require( FrmAppHelper::plugin_path() .'/classes/helpers/FrmListHelper.php' );
            
        $args = array('table_name' => $wpdb->prefix .'frm_forms', 'params' => $params);
        $args['page_name'] = $params['template'] ? '-template' : '';
        $wp_list_table = new FrmListHelper($args);
        unset($args);

        $pagenum = $wp_list_table->get_pagenum();

        $wp_list_table->prepare_items();

        $total_pages = $wp_list_table->get_pagination_arg( 'total_pages' );
        if ( $pagenum > $total_pages && $total_pages > 0 ) {
            wp_redirect( add_query_arg( 'paged', $total_pages ) );
            die();
        }
            
        if ( ! empty( $_REQUEST['s'] ) )
            $page_params .= '&s='. urlencode($_REQUEST['s']);
        
        require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/list.php');
    }
    
    public static function get_columns($columns){
	    $columns['cb'] = '<input type="checkbox" />';
        $columns['id'] = 'ID';
        $columns['name'] = __('Name');
        $columns['description'] = __('Description');
        $columns['form_key'] = __('Key', 'formidable');
        
        if($_GET['page'] == 'formidable-templates'){
            add_screen_option( 'per_page', array('label' => __('Templates', 'formidable'), 'default' => 10, 'option' => 'formidable_page_formidable_templates_per_page') );
        }else{
            $columns['entries'] = __('Entries', 'formidable');
            $columns['link'] = __('Actions', 'formidable');
            $columns['shortcode'] = __('Shortcodes', 'formidable');
            add_screen_option( 'per_page', array('label' => __('Forms', 'formidable'), 'default' => 20, 'option' => 'formidable_page_formidable_per_page') );
        }
        
        $columns['created_at'] = __('Date', 'formidable');
        
        return $columns;
	}
	
	public static function get_sortable_columns() {
		return array(
		    'id'        => 'id',
			'name'      => 'name',
			'description'   => 'description',
			'form_key'   => 'form_key',
			'created_at' => 'created_at'
		);
	}
	
	public static function hidden_columns($result){
        $return = false;
        foreach((array)$result as $r){
            if(!empty($r)){
                $return = true;
                break;
            }
        }
        
        if($return)
            return $result;

        $result[] = 'created_at';
        if($_GET['page'] == 'formidable-templates'){
            $result[] = 'id';
            $result[] = 'form_key';
        } 
               
        return $result;
    }
	
	public static function save_per_page($save, $option, $value){
        if($option == 'formidable_page_formidable_per_page' or $option == 'formidable_page_formidable_templates_per_page')
            $save = (int)$value;
        return $save;
    }

    private static function get_edit_vars($id, $errors = '', $message='', $create_link=false){
        global $frm_entry, $frm_field, $frm_vars;
        $frm_form = new FrmForm();
        $record = $frm_form->getOne( $id );
        $frm_field_selection = FrmFieldsHelper::field_selection();
        $fields = $frm_field->getAll(array('fi.form_id' => $record->id), 'field_order');
        $values = FrmAppHelper::setup_edit_vars($record, 'forms', $fields, true);
        
        $edit_message = __('Form was Successfully Updated', 'formidable');
        if ($values['is_template'] and $message == $edit_message)
            $message = __('Template was Successfully Updated', 'formidable');
        
        if (isset($values['default_template']) && $values['default_template'])
            wp_die(__('That template cannot be edited', 'formidable'));
        else if(defined('DOING_AJAX'))
            die();
        else if($create_link)
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/new.php');
        else
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/edit.php');
    }
    
    public static function get_settings_vars($id, $errors = '', $message=''){
        global $frm_entry, $frm_field, $frm_vars;
        $frm_form = new FrmForm();
        $form = $frm_form->getOne( $id );
        $fields = $frm_field->getAll(array('fi.form_id' => $id), 'field_order');
        $values = FrmAppHelper::setup_edit_vars($form, 'forms', $fields, true);
        $sections = apply_filters('frm_add_form_settings_section', array(), $values);
        $pro_feature = $frm_vars['pro_is_installed'] ? '' : ' class="pro_feature"';
        if (isset($values['default_template']) && $values['default_template'])
            wp_die(__('That template cannot be edited', 'formidable'));
        else
            require(FrmAppHelper::plugin_path() .'/classes/views/frm-forms/settings.php');
    }
    
    public static function get_params(){
        $values = array();
        foreach (array('template' => 0, 'id' => '', 'paged' => 1, 'form' => '', 'search' => '', 'sort' => '', 'sdir' => '') as $var => $default)
            $values[$var] = FrmAppHelper::get_param($var, $default);

        return $values;
    }
    
    public static function add_default_templates($path, $default=true, $template=true){
        global $frm_field;
        $path = untrailingslashit(trim($path));
        $templates = glob($path."/*.php");
        
        $frm_form = new FrmForm();
        for($i = count($templates) - 1; $i >= 0; $i--){
            $filename = str_replace('.php', '', str_replace($path.'/', '', $templates[$i]));
            $template_query = array('form_key' => $filename);
            if($template) $template_query['is_template'] = 1;
            if($default) $template_query['default_template'] = 1;
            $form = $frm_form->getAll($template_query, '', 1);
            
            $values = FrmFormsHelper::setup_new_vars();
            $values['form_key'] = $filename;
            $values['is_template'] = $template;
            $values['status'] = 'published';
            if($default) $values['default_template'] = 1;
            
            include($templates[$i]);
            
            //get updated form
            if($form)
                $form = $frm_form->getOne($form->id);
            else
                $form = $frm_form->getAll($template_query, '', 1);
            
            if($form)
                do_action('frm_after_duplicate_form', $form->id, (array)$form);
        }
    }

    public static function route(){
        $action = isset($_REQUEST['frm_action']) ? 'frm_action' : 'action';
        $vars = false;
        if(isset($_POST['frm_compact_fields'])){
            if(!current_user_can('frm_edit_forms') and !is_super_admin()){
                global $frm_settings;
                wp_die($frm_settings->admin_permission);
            }
            $json_vars = htmlspecialchars_decode(nl2br(stripslashes($_POST['frm_compact_fields'])));
            $json_vars = json_decode($json_vars, true);
            $vars = FrmAppHelper::json_to_array($json_vars);
            $action = $vars[$action];
        }else{
            $action = FrmAppHelper::get_param($action);
        }
        
        if($action == 'new' or $action == 'new-selection')
            return self::new_form($vars);
        else if($action == 'create')
            return self::create($vars);
        else if($action == 'edit')
            return self::edit($vars);
        else if($action == 'update')
            return self::update($vars);
        else if($action == 'duplicate')
            return self::duplicate();
        else if($action == 'destroy')
            return self::destroy();
        else if($action == 'list-form')
            return self::list_form(); 
        else if($action == 'settings')
            return self::settings();
        else if($action == 'update_settings')
            return self::update_settings();
        else{
            do_action('frm_form_action_'. $action);
            if(apply_filters('frm_form_stop_action_'. $action, false))
                return;
            
            $action = FrmAppHelper::get_param('action');
            if($action == -1)
                $action = FrmAppHelper::get_param('action2');
                
            if(strpos($action, 'bulk_') === 0){
                if(isset($_GET) and isset($_GET['action']))
                    $_SERVER['REQUEST_URI'] = str_replace('&action='.$_GET['action'], '', $_SERVER['REQUEST_URI']);
                if(isset($_GET) and isset($_GET['action2']))
                    $_SERVER['REQUEST_URI'] = str_replace('&action='.$_GET['action2'], '', $_SERVER['REQUEST_URI']);
                    
                return self::list_form();
            }else{
                return self::display_forms_list();
            }
        }
    }

}
