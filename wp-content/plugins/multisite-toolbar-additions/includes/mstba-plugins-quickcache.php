<?php
/**
 * Display links to active plugins/extensions settings' pages: Quick Cache.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright 2012, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://genesisthemes.de/en/wp-plugins/multisite-toolbar-additions/
 * @link       http://twitter.com/deckerweb
 *
 * @since 1.0.0
 */

/**
 * Quick Cache (free, by PriMoThemes.com / WebSharks, Inc.)
 *
 * @since 1.0.0
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( is_super_admin() &&
	( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'quick-cache/quick-cache.php' ) )
) {

	$mstba_tb_items[ 'networkext_quickcache' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=ws-plugin--qcache-options' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Quick Cache Options', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_quickcache_info' ] = array(
		'parent' => $networkext_quickcache,
		'title'  => __( 'Plugin Info', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=ws-plugin--qcache-info' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Plugin Info', 'multisite-toolbar-additions' ) )
	);

}  // end-if multisite check

	/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
elseif ( current_user_can( 'administrator' ) ) {

	$mstba_tb_items[ 'siteext_quickcache' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=ws-plugin--qcache-options' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Quick Cache Options', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_quickcache_info' ] = array(
		'parent' => $siteext_quickcache,
		'title'  => __( 'Plugin Info', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=ws-plugin--qcache-info' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Plugin Info', 'multisite-toolbar-additions' ) )
	);

}  // end-if ! multisite check
