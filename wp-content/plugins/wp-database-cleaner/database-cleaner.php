<?php
/*
Plugin Name: WP Database Cleaner
Plugin URI: http://www.wpmize.com/wordpress-plugins/optimize-wordpress-database-wp-database-cleaner/
Description: Easily cleanup and optimize WordPress database.
Author: WPMize
Author URI: http://www.wpmize.com/
Version: 1.0
Text Domain: wp-database-cleaner
*/

require_once 'database-cleaner-class.php';

$DatabaseCleaner = new DatabaseCleaner();
register_activation_hook( __FILE__, array( $DatabaseCleaner, 'install' ) );
register_deactivation_hook( __FILE__, array( $DatabaseCleaner, 'uninstall' ) );
add_action( 'admin_menu', array( $DatabaseCleaner, 'initialize' ) );
?>