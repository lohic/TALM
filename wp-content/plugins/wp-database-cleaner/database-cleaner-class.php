<?php

if ( !class_exists( 'cf_View' ) )
	require_once 'classes/View.php';

class DatabaseCleaner
{

	private $_conn = null;
	private $_view = null;
	private $_url;
	private $_plugin_name = 'database-cleaner';
	
	public function __construct()
	{
		global $wpdb;
		$this->_conn = &$wpdb;
		$this->_url = 'admin.php?page='.$this->_plugin_name.'/'.$this->_plugin_name.'-class.php';

		$this->_view = new cf_View( $this->_conn );
		$this->_view->load( dirname(__FILE__).'/views/main.html' );
	}
	
	public function install()
	{
		
	}
	
	public function uninstall()
	{
		
	}
	
	public function initialize()
	{
		add_menu_page( 'DatabaseCleaner', 'DatabaseCleaner', 8, __FILE__, array( $this, 'controller' ) );
	}
	
	public function controller()
	{
		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'main';
		$this->$action();
	}
	
	private function main()
	{		
		$this->_view->add( 'main' );
		
		if ( $_POST['go'] && $_POST['handler'] )
		{					
			foreach ( $_POST['handler'] as $handler => $val )
				if ( method_exists( __CLASS__, $handler ) ) $this->$handler();
		}
				
		$this->_view->content( true );
	}
	
	private function post_revisions()
	{
		$rows = 0;
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'posts` where `post_type` = "revision"' );
		$rows += mysql_affected_rows();
		$this->_conn->query( 'delete a,b,c from `'.$this->_conn->prefix.'posts` a left join `'.$this->_conn->prefix.'term_relationships` b on (a.`ID` = b.`object_id`) left join `'.$this->_conn->prefix.'postmeta` c on (a.`ID` = c.`post_id`) where a.`post_type` = "revision"' );
		$rows += mysql_affected_rows();
		$this->_view->message = $rows.' Posts revisions have been removed...';		
		$this->_view->add('message');		
	}
	
	private function auto_drafts()
	{
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'posts` where `post_status` = "auto-draft"' );
		$this->_view->message = mysql_affected_rows().' Auto drafts have been removed...';		
		$this->_view->add('message');		
	}
	
	private function pending_comments()
	{
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'comments` where `comment_approved` = 0' );
		$this->_view->message = mysql_affected_rows().' Pending comments have been removed...';		
		$this->_view->add('message');		
	}
	
	private function spam_comments()
	{
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'comments` where `comment_approved` = "spam"' );
		$this->_view->message = mysql_affected_rows().' Spam comments have been removed...';		
		$this->_view->add('message');
	}
	
	private function trash_comments()
	{
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'comments` where `comment_approved` = "trash"' );
		$this->_view->message = mysql_affected_rows().' Trash comments have been removed...';		
		$this->_view->add('message');
	}
	
	private function no_children_tags()
	{
		$rows = 0;
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'terms` where `term_id` in (select `term_id` from `'.$this->_conn->prefix.'term_taxonomy` where `count` = 0 )' );
		$rows += mysql_affected_rows();		
		$this->_conn->query( 'delete from `'.$this->_conn->prefix.'term_relationships` where `term_taxonomy_id` not in (select `term_taxonomy_id` from `'.$this->_conn->prefix.'term_taxonomy`)' );
		$rows += mysql_affected_rows();
		$this->_view->message = $rows.' Unlinked tags have been removed...';		
		$this->_view->add('message');
	}
	
	private function no_children_categories()
	{
		$this->_conn->query( 'delete t, x from `'.$this->_conn->prefix.'terms` as t, `'.$this->_conn->prefix.'term_taxonomy` AS x where t.`term_id` = x.`term_id` and x.`count` = 0' );
		$this->_view->message = mysql_affected_rows().' Empty categories have been removed...';		
		$this->_view->add('message');		
	}
	
	private function trash_posts()
	{
		$this->_conn->query( 'delete p from `'.$this->_conn->prefix.'posts` p left outer join `'.$this->_conn->prefix.'postmeta` pm on (p.`ID` = pm.`post_id`) where `post_status` = "trash"' );
		$this->_view->message = mysql_affected_rows().' Posts in the trash have been removed...';		
		$this->_view->add('message');
	}
	
	private function force_redirect( $url = '' )
	{
		$url = $url ? $url : $this->_url;
		echo '<script type="text/javascript">window.location.href="'.$url.'"</script>';
		exit();		
	}
		
}

?>