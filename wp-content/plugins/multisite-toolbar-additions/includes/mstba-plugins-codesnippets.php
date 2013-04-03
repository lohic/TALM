<?php
/**
 * Display links to active plugins/extensions settings' pages: Code Snippets.
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
 * Code Snippets (free, by Shea Bunge)
 *
 * @since 1.1.0
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( current_user_can( 'manage_network_snippets' ) ) {

	$mstba_tb_items[ 'networkext_codesnippets' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Network Code Snippets', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=snippets' ),
		'meta'   => array( 'target' => '', 'title' => __( 'Network Code Snippets', 'multisite-toolbar-additions' ) )
	);

	/** Check for snippets network install capability */
	if ( current_user_can( 'install_network_snippets' ) ) {
		$mstba_tb_items[ 'networkext_codesnippets_add' ] = array(
			'parent' => $networkext_codesnippets,
			'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=snippet' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Add new Snippet', 'multisite-toolbar-additions' ) )
		);
		$mstba_tb_items[ 'networkext_codesnippets_import' ] = array(
			'parent' => $networkext_codesnippets,
			'title'  => __( 'Import', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=import-snippets' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Import', 'multisite-toolbar-additions' ) )
		);
	}  // end-if cap check

}  // end-if multisite check

/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
if ( current_user_can( 'manage_snippets' ) ) {

	$mstba_tb_items[ 'siteext_codesnippets' ] = array(
		'parent' => $siteextgroup,
		'title'  => $mstba_multisite_check . __( 'Code Snippets', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=snippets' ),
		'meta'   => array( 'target' => '', 'title' => $mstba_multisite_check . __( 'Code Snippets', 'multisite-toolbar-additions' ) )
	);

	/** Check for snippets site install capability */
	if ( current_user_can( 'install_snippets' ) ) {
		$mstba_tb_items[ 'siteext_codesnippets_add' ] = array(
			'parent' => $siteext_codesnippets,
			'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=snippet' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Add new Snippet', 'multisite-toolbar-additions' ) )
		);
		$mstba_tb_items[ 'siteext_codesnippets_import' ] = array(
			'parent' => $siteext_codesnippets,
			'title'  => __( 'Import', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=import-snippets' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Import', 'multisite-toolbar-additions' ) )
		);
	}  // end-if cap check

}  // end-if ! multisite check
