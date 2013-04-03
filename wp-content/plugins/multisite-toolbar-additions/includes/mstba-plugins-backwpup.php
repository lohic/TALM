<?php
/**
 * Display links to active plugins/extensions settings' pages: BackWPup.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright 2012, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://genesisthemes.de/en/wp-plugins/multisite-toolbar-additions/
 * @link       http://twitter.com/deckerweb
 *
 * @since 1.1.0
 */

/**
 * BackWPup (free, by Daniel Hüsken)
 *
 * @since 1.1.0
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'backwpup/backwpup.php' ) ) {

	$mstba_tb_items[ 'networkext_backwpup' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'BackWPup Jobs', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpup' ),
		'meta'   => array( 'target' => '', 'title' => __( 'BackWPup Jobs', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_add' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Add new Job', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpupeditjob' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Add new Job', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_working' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Job Working...', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpupworking' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Job Working...', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_logs' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Log Files', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpuplogs' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Log Files', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_archive' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Backups Archive', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpupbackups' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Backups Archive', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_tools' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Tools', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpuptools' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Tools', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'networkext_backwpup_settings' ] = array(
		'parent' => $networkext_backwpup,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=backwpupsettings' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Settings', 'multisite-toolbar-additions' ) )
	);

}  // end-if multisite check

	/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
else {

	$mstba_tb_items[ 'siteext_backwpup' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'BackWPup Jobs', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpup' ),
		'meta'   => array( 'target' => '', 'title' => __( 'BackWPup Jobs', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_add' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Add new Job', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpupeditjob' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Add new Job', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_working' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Job Working...', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpupworking' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Job Working...', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_logs' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Log Files', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpuplogs' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Log Files', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_archive' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Backups Archive', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpupbackups' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Backups Archive', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_tools' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Tools', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpuptools' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Tools', 'multisite-toolbar-additions' ) )
	);
	$mstba_tb_items[ 'siteext_backwpup_settings' ] = array(
		'parent' => $siteext_backwpup,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=backwpupsettings' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Settings', 'multisite-toolbar-additions' ) )
	);

}  // end-if ! multisite check
