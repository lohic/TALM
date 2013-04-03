<?php 
/**
 * Main plugin file.
 * This plugin adds a few useful admin links to the WordPress Toolbar / Admin Bar in Multisite or Network installs.
 *
 * @package   Multisite Toolbar Additions
 * @author    David Decker
 * @link      http://deckerweb.de/twitter
 * @copyright Copyright (c) 2012-2013, David Decker - DECKERWEB
 *
 * Plugin Name: Multisite Toolbar Additions
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/multisite-toolbar-additions/
 * Description: This plugin adds a few useful admin links to the WordPress Toolbar / Admin Bar in Multisite or Network installs.
 * Version: 1.3.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: multisite-toolbar-additions
 * Domain Path: /languages/
 *
 * Copyright (c) 2012-2013 David Decker - DECKERWEB
 *
 *     This file is part of Multisite Toolbar Additions,
 *     a plugin for WordPress.
 *
 *     Multisite Toolbar Additions is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Multisite Toolbar Additions is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Setting constants
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'MSTBA_PLUGIN_DIR', dirname( __FILE__ ) );

/** Plugin base directory */
define( 'MSTBA_PLUGIN_BASEDIR', dirname( plugin_basename( __FILE__ ) ) );


add_action( 'init', 'ddw_mstba_init' );
/**
 * Setup the plugin.
 *
 * Load the text domain for translation of the plugin.
 * Load admin helper functions - only within 'wp-admin'.
 * Add a WordPress custom menu to the toolbar - only do and display stuff for super admins.
 * 
 * @since 1.0.0
 *
 * @uses load_plugin_textdomain() To load the textdomain for translations.
 *
 * @param $mstba_wp_lang_dir
 * @param $mstba_lang_dir
 */
function ddw_mstba_init() {

	/** Set filter for WordPress languages directory */
	$mstba_wp_lang_dir = MSTBA_PLUGIN_BASEDIR . '/../../languages/multisite-toolbar-additions/';
	$mstba_wp_lang_dir = apply_filters( 'mstba_filter_wp_lang_dir', $mstba_wp_lang_dir );

	/** Set filter for plugin's languages directory */
	$mstba_lang_dir = MSTBA_PLUGIN_BASEDIR . '/languages/';
	$mstba_lang_dir = apply_filters( 'mstba_filter_lang_dir', $mstba_lang_dir );

	/** First look in WordPress' "languages" folder = custom & update-secure! */
	load_plugin_textdomain( 'multisite-toolbar-additions', false, $mstba_wp_lang_dir );

	/** Then look in plugin's "languages" folder = default */
	load_plugin_textdomain( 'multisite-toolbar-additions', false, $mstba_lang_dir );

	/** Include admin helper functions */
	if ( is_admin() ) {

		require_once( MSTBA_PLUGIN_DIR . '/includes/mstba-admin.php' );

	}  // end-if is_admin check

	/** Add "Custom Menu" menus page link to plugin page */
	if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , 'ddw_mstba_custom_menu_link' );
	}

	/** Define constants and set defaults for removing all or certain sections */
	if ( ! defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) ) {
		define( 'MSTBA_DISPLAY_NETWORK_ITEMS', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SUBSITE_ITEMS' ) ) {
		define( 'MSTBA_DISPLAY_SUBSITE_ITEMS', TRUE );
	}

	if ( ! defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) ) {
		define( 'MSTBA_SUPER_ADMIN_NAV_MENU', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SITE_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_SITE_GROUP', TRUE );
	}


	/** Check for Custom Menus support */
	if ( ! current_theme_supports( 'menus' ) ) {
		add_theme_support( 'menus' );
	}

	/** Only register additional toolbar menu for super admins */
	if ( ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && MSTBA_SUPER_ADMIN_NAV_MENU ) && is_super_admin() ) {
		register_nav_menu( 'mstba_menu', __( 'Multisite Toolbar Menu', 'multisite-toolbar-additions' ) );
		add_action( 'admin_bar_menu', 'ddw_mstba_build_custom_menu', 9999 );
	}

}  // end of function ddw_mstba_init


/**
 * Build the custom menu for the toolbar and hook it in.
 *
 * @since 1.0.0
 *
 * @uses has_nav_menu() To check if menu is registered.
 * @uses get_nav_menu_locations() To get menu locations.
 * @uses wp_get_nav_menu_object() To get menu object.
 * @uses wp_get_nav_menu_items() To get menu args.
 *
 * @param $mstba_menu_name
 * @param $mstba_menu_locations
 * @param $mstba_menu
 * @param $mstba_menu_items
 * @param $mstba_menu_item
 * @param $mstba_menu_args
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_build_custom_menu( $wp_admin_bar ) {

	global $wp_admin_bar;
	
	/** Set unique menu slug */
	$mstba_menu_name = 'mstba_menu';

	/** Only add menu items if location exists and an actual menu is applied to it */
	if ( has_nav_menu( 'mstba_menu' ) ) {

		if ( ( $mstba_menu_locations = get_nav_menu_locations() ) && isset( $mstba_menu_locations[ $mstba_menu_name ] ) ) {

			$mstba_menu_locations = get_nav_menu_locations();
			$mstba_menu = wp_get_nav_menu_object( $mstba_menu_locations[ $mstba_menu_name ] );
			$mstba_menu_items = (array) wp_get_nav_menu_items( $mstba_menu->term_id );

			foreach( $mstba_menu_items as $mstba_menu_item ) {

				/** Retrieve the args from the custom menu */
				$mstba_menu_args = array(
							'id'    => 'mstba_' . $mstba_menu_item->ID,
							'title' => $mstba_menu_item->title,
							'href'  => esc_url_raw( $mstba_menu_item->url ),
							'meta'  => array(
										'target' => $mstba_menu_item->target,
										'title'  => $mstba_menu_item->attr_title ),
			                					'class'  => implode( ' ', $mstba_menu_item->classes ),
				);  // end of array

				/** Check for parent menu items to allow for threaded menus */
				if ( $mstba_menu_item->menu_item_parent ) {
					$mstba_menu_args[ 'parent' ] = 'mstba_' . $mstba_menu_item->menu_item_parent;
				}

				/** Only hook items if the menu is setup for our menu location */
				if ( $mstba_menu_item ) {
					$wp_admin_bar->add_node( $mstba_menu_args );
				}

				unset( $mstba_menu_args );

			}  // end foreach

		}  // end-if menu location check

	}  // end-if check if a 'mstba_menu' menu exists

}  // end of function ddw_mstba_build_custom_menu


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_toolbar_main_site_remove_view_site' );
/**
 * Remove original 'View Site' for main site within Network Admin.
 *
 * @since 1.2.0
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_main_site_remove_view_site() {

	global $wp_admin_bar;

	/** Only for super admins within network_admin & if network our items are enabled */
	if ( is_network_admin()
		&& MSTBA_DISPLAY_NETWORK_ITEMS
		&& is_super_admin()
		&& is_user_logged_in()
		&& is_admin_bar_showing()
	) {

		$wp_admin_bar->remove_menu( 'view-site' );

	}  // end-if network_admin check

}  // end of function ddw_mstba_toolbar_main_site_remove_view_site


add_action( 'admin_bar_menu', 'ddw_mstba_toolbar_main_site_dashboard' );
/**
 * Adding 'Dashboard' for main site within Network Admin.
 *
 * @since 1.2.0
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_main_site_dashboard() {

	global $wp_admin_bar;

	/** Only for super admins within network_admin & if network our items are enabled */
	if ( is_network_admin()
		&& MSTBA_DISPLAY_NETWORK_ITEMS
		&& is_super_admin()
		&& is_user_logged_in()
		&& is_admin_bar_showing()
	) {

		/** Add 'Dashboard' for main site */
		$wp_admin_bar->add_menu( array(  
			'parent' => 'site-name',  
			'id'     => 'ddw-mstba-main-site-dashboard',  
			'title'  => __( 'Dashboard', 'multisite-toolbar-additions' ),  
			'href'   => admin_url( '/' ),  
			'meta'   => array( 'target' => '', 'title' => _x( 'Dashboard (Main Site)', 'Translators: For the tooltip', 'multisite-toolbar-additions' ) ) )  
		);

		/** Re-add 'View Site' item */
		$wp_admin_bar->add_menu( array(  
			'parent' => 'site-name',  
			'id'     => 'ddw-mstba-main-site-view',  
			'title'  => __( 'View Site', 'multisite-toolbar-additions' ),  
			'href'   => get_home_url(),  
			'meta'   => array( 'target' => '_blank', 'title' => _x( 'View Site (Main Site)', 'Translators: For the tooltip', 'multisite-toolbar-additions' ) ) )  
		);

	}  // end-if network_admin check

}  // end of function ddw_mstba_toolbar_main_site_dashboard


add_action( 'admin_bar_menu', 'ddw_mstba_toolbar_additions', 99 );
/**
 * Add new menu items to the WordPress Toolbar / Admin Bar.
 * 
 * @since 1.0.0
 *
 * @param $mstba_prefix
 * @param $mstba_tb_items
 * @param $mstba_tb_item
 * @param $mstba_menu_id
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_additions() {

	global $wp_admin_bar;

	/**
	 * Required WordPress cabability to display new toolbar bar entries
	 * Only showing items if toolbar / admin bar is activated and super admin user is logged in!
	 *
	 * @since 1.0.0
	 */
	
	if ( ! is_super_admin()
		|| ! is_user_logged_in()
		|| ! is_admin_bar_showing()
		|| ! MSTBA_DISPLAY_NETWORK_ITEMS	// allows for custom disabling
	) {
		return;
	}


	/** Remove original "Visit Network" menu item (only to re-add later on as last item!) */
	$wp_admin_bar->remove_menu( 'network-admin-v' );

	/** Set unique prefix for toolbar ID */
	$mstba_prefix = 'ddw-mstba-';
	
	/** Create parent menu item references */
	$networkplugins = $mstba_prefix . 'networkplugins';				// sub level: network plugins
	$networkthemes = $mstba_prefix . 'networkthemes';				// sub level: network themes
	$networkextgroup = $mstba_prefix . 'networkextgroup';				// sub level: network extend group ("hook" place)
		$networkext_quickcache = $mstba_prefix . 'networkext_quickcache';		// third level: quick cache (network)
		$networkext_wpsupercache = $mstba_prefix . 'networkext_wpsupercache';		// third level: wp super cache (network)
		$networkext_wppiwik = $mstba_prefix . 'networkext_wppiwik';			// third level: wp-piwik (network)
		$networkext_orgmessagenotifier = $mstba_prefix . 'networkext_orgmessagenotifier';	// third level: o.messg.not (network)
		$networkext_codesnippets = $mstba_prefix . 'networkext_codesnippets';		// third level: code snippets (network)
		$networkext_backwpup = $mstba_prefix . 'networkext_backwpup';			// third level: backwpup (network)
		$networkext_snapshot = $mstba_prefix . 'networkext_snapshot';			// third level: snapshot (network)
		$networkext_snapshot_destinations = $mstba_prefix . 'networkext_snapshot_destinations';	// third level: snapshot dest. (nw.)
		$networkext_ubranding = $mstba_prefix . 'networkext_ubranding';			// third level: ultimate branding (network)
		$networkext_smartadmintweaks = $mstba_prefix . 'networkext_smartadmintweaks';	// third level: smart admin tweaks (network)
		$networkext_smartcleanuptools = $mstba_prefix . 'networkext_smartcleanuptools';	// third level: smart cleanup tools (network)
	$siteextgroup = $mstba_prefix . 'siteextgroup';					// sub level: site extend group ("hook" place)
		$siteext_quickcache = $mstba_prefix . 'siteext_quickcache';			// third level: quick cache (site)
		$siteext_wpsupercache = $mstba_prefix . 'siteext_wpsupercache';			// third level: wp super cache (site)
		$siteext_wppiwik = $mstba_prefix . 'siteext_wppiwik';				// third level: wp-piwik (site)
		$siteext_wprcinstaller = $mstba_prefix . 'siteext_wprcinstaller';		// third level: wprc installer
		$siteext_relevanssi = $mstba_prefix . 'siteext_relevanssi';			// third level: relevanssi/premium
		$siteext_codesnippets = $mstba_prefix . 'siteext_codesnippets';			// third level: code snippets (site)
		$siteext_cwwpcsnippets = $mstba_prefix . 'siteext_cwwpcsnippets';		// third level: cwwp code snippets
		$siteext_backwpup = $mstba_prefix . 'siteext_backwpup';				// third level: backwpup (site)
		$siteext_snapshot = $mstba_prefix . 'siteext_snapshot';				// third level: snapshot (site)
		$siteext_snapshot_destinations = $mstba_prefix . 'siteext_snapshot_destinations';	// third level: snapshot dest. (si
		$siteext_ubranding = $mstba_prefix . 'siteext_ubranding';			// third level: ultimate branding (site)
		$siteext_smartadmintweaks = $mstba_prefix . 'siteext_smartadmintweaks';	// third level: smart admin tweaks (site)
		$siteext_smartcleanuptools = $mstba_prefix . 'siteext_smartcleanuptools';	// third level: smart cleanup tools (site)
		$siteext_rvgoptimizedb = $mstba_prefix . 'siteext_rvgoptimizedb';	// third level: rvg optimize db (site)
	$sitegroup = $mstba_prefix . 'sitegroup';						// sub level: site group ("hook" place)
	$addnewgroup = $mstba_prefix . 'addnewgroup';					// sub level: add new group ("hook" place)
		$addnew_plugin = $mstba_prefix . 'addnew_plugin';					// third level: add new plugin
		$addnew_theme = $mstba_prefix . 'addnew_theme';					// third level: add new theme


	/**
	 * Display additional network-specific items, load only for Multisite installs.
	 *
	 * @since 1.0.0
	 */
	if ( is_multisite() ) {

		/** Sites > Dashboard > Settings */
		$mstba_tb_items[ 'network-settings' ] = array(
			'parent' => 'network-admin-d',
			'title'  => __( 'Network Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Network Settings', 'multisite-toolbar-additions' ) )
		);

			/** Sites > Dashboard > Check for Updates */
			$mstba_tb_items[ 'network-updatecheck' ] = array(
				'parent' => 'network-admin-d',
				'title'  => __( 'Check for Updates', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'update-core.php' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Check for Updates', 'multisite-toolbar-additions' ) )
			);

			/** Sites > Dashboard > Update Sites */
			$mstba_tb_items[ 'network-updatesites' ] = array(
				'parent' => 'network-admin-d',
				'title'  => __( 'Updates all Sites', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'upgrade.php' ),
				'meta'   => array( 'target' => '', 'title' => _x( 'Updates all Sites', 'Translators: For the tooltip', 'multisite-toolbar-additions' ) )
			);

		/** Sites > Add Site */
		$mstba_tb_items[ 'network-addsite' ] = array(
			'parent' => 'network-admin-s',
			'title'  => __( 'Add Site', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'site-new.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Add Site', 'multisite-toolbar-additions' ) )
		);

		/** Users > Add User */
		$mstba_tb_items[ 'network-adduser' ] = array(
			'parent' => 'network-admin-u',
			'title'  => __( 'Add User', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'user-new.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Add User', 'multisite-toolbar-additions' ) )
		);

		/** Users > Super Admins */
		$mstba_tb_items[ 'network-superadmins' ] = array(
			'parent' => 'network-admin-u',
			'title'  => __( 'Super Admins', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'users.php?role=super' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Super Admins', 'multisite-toolbar-additions' ) )
		);

		/** Manage Network > Network wide plugins */
		$mstba_tb_items[ 'networkplugins' ] = array(
			'parent' => 'network-admin',
			'title'  => __( 'Network Plugins', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'plugins.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Network Plugins', 'multisite-toolbar-additions' ) )
		);

			/** Manage Network > Network wide plugins > Install: Search */
			$mstba_tb_items[ 'networkplugins-install' ] = array(
				'parent' => $networkplugins,
				'title'  => __( 'Install Plugins: Search', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'plugin-install.php?tab=dashboard' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Plugins - Search on WordPress.org', 'multisite-toolbar-additions' ) )
			);

			/** Manage Network > Network wide plugins > Install: ZIP upload */
			$mstba_tb_items[ 'networkplugins-installupload' ] = array(
				'parent' => $networkplugins,
				'title'  => __( 'Install Plugins: Upload', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'plugin-install.php?tab=upload' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Plugins - Upload ZIP file', 'multisite-toolbar-additions' ) )
			);

			/** Manage Network > Network wide plugins > Install: Favorites */
			$mstba_tb_items[ 'networkplugins-installfaves' ] = array(
				'parent' => $networkplugins,
				'title'  => __( 'Install Plugins: Favorites', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'plugin-install.php?tab=favorites' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Plugins - Favorites (via WordPress.org)', 'multisite-toolbar-additions' ) )
			);

		/** Manage Network > Network wide themes */
		$mstba_tb_items[ 'networkthemes' ] = array(
			'parent' => 'network-admin',
			'title'  => __( 'Network Themes', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'themes.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Network Themes', 'multisite-toolbar-additions' ) )
		);

			/** Manage Network > Network wide themes > Install: Search */
			$mstba_tb_items[ 'networkthemes-install' ] = array(
				'parent' => $networkthemes,
				'title'  => __( 'Install Themes: Search', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'theme-install.php?tab=dashboard' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Themes - Search on WordPress.org', 'multisite-toolbar-additions' ) )
			);

			/** Manage Network > Network wide themes > Install: ZIP upload */
			$mstba_tb_items[ 'networkthemes-installupload' ] = array(
				'parent' => $networkthemes,
				'title'  => __( 'Install Themes: Upload', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'theme-install.php?tab=upload' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Themes - Upload ZIP file', 'multisite-toolbar-additions' ) )
			);

		/** Manage Network > Network Theme Editor */
		if ( !( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) && current_user_can( 'edit_themes' ) ) {
			$mstba_tb_items[ 'network-themeeditor' ] = array(
				'parent' => 'network-admin',
				'title'  => __( 'Network Theme Editor', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'theme-editor.php' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Network Theme Editor', 'multisite-toolbar-additions' ) )
			);
		}  // end-if cap check

		/** Network Extend Group: Main Entry */
		if ( MSTBA_DISPLAY_NETWORK_EXTEND_GROUP ) {
			$wp_admin_bar->add_group( array(
				'parent' => 'my-sites-super-admin',
				'id'     => $networkextgroup,
			) );

			/** Action Hook 'mstba_custom_network_items' - allows for hooking in other network-specific items */
			do_action( 'mstba_custom_network_items' );

		}  // end-if constant check


		/** Manage Network > Visit Network (re-adding as last item!) - opening in a blank window/tab! */
		$mstba_tb_items[ 'network-visit' ] = array(
			'parent' => 'network-admin',
			'title'  => __( 'Visit Network', 'multisite-toolbar-additions' ),
			'href'   => network_home_url(),
			'meta'   => array( 'target' => '_blank', 'title' => __( 'Visit Network', 'multisite-toolbar-additions' ) )
		);

	}  // end-if is_multisite check


	/**
	 * Display additional site-specific items (as sub level items on subsite ? item)
	 *
	 * @since 1.0.0
	 */
		/** Site Group: Main Entry */
		if ( MSTBA_DISPLAY_SITE_GROUP ) {

			$wp_admin_bar->add_group( array(
				'parent' => 'site-name',
				'id'     => $sitegroup,
			) );

		}  // end-if constant check

		$mstba_tb_items[ 'media-new' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Media Library', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'media-new.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Media Library', 'multisite-toolbar-additions' ) )
		);

		$mstba_tb_items[ 'edit-posts' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Edit Posts', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'edit.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Edit Posts', 'multisite-toolbar-additions' ) )
		);

		$mstba_tb_items[ 'edit-pages' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Edit Pages', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'edit.php?post_type=page' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Edit Pages', 'multisite-toolbar-additions' ) )
		);

	/** Subsite-specific: Theme Editor */
	if ( !( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) && current_user_can( 'edit_themes' ) ) {

		$mstba_tb_items[ 'edit-themes' ] = array(
			'parent' => ! is_admin() ? 'themes' : $sitegroup,
			'title'  => __( 'Theme Editor', 'multisite-toolbar-additions' ),
			'href'   => is_multisite() ? network_admin_url( 'theme-editor.php?file=style.css&amp;theme=' . get_stylesheet() ) : admin_url( 'theme-editor.php?file=style.css&amp;theme=' . get_stylesheet() ),
			'meta'   => array( 'target' => '', 'title' => __( 'Theme Editor', 'multisite-toolbar-additions' ) )
		);

	}  // end-if cap check

	/**
	 * Display additional site-specific "New Content/ Add New" items (as sub level items on subsite ? item)
	 *
	 * @since 1.3.0
	 */
		/** Show only if "Site Group" is not hidden */
		if ( MSTBA_DISPLAY_SITE_GROUP ) {

			$wp_admin_bar->add_group( array(
				'parent' => 'new-content',
				'id'     => $addnewgroup,
			) );

		}  // end-if constant check

		$mstba_tb_items[ 'addnew_plugin' ] = array(
			'parent' => $addnewgroup,
			'title'  => __( 'Install Plugin', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'plugin-install.php?tab=dashboard' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Install Plugin - Search via WordPress.org', 'multisite-toolbar-additions' ) )
		);

			$mstba_tb_items[ 'addnew_plugin_upload' ] = array(
				'parent' => $addnew_plugin,
				'title'  => __( 'Upload ZIP file', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'plugin-install.php?tab=upload' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Plugin - Upload ZIP file', 'multisite-toolbar-additions' ) )
			);

			$mstba_tb_items[ 'addnew_plugin_faves' ] = array(
				'parent' => $addnew_plugin,
				'title'  => __( 'Install Favorites', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'plugin-install.php?tab=favorites' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Plugins - Favorites (via WordPress.org)', 'multisite-toolbar-additions' ) )
			);

		$mstba_tb_items[ 'addnew_theme' ] = array(
			'parent' => $addnewgroup,
			'title'  => __( 'Install Theme', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'theme-install.php?tab=dashboard' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Install Theme - Search via WordPress.org', 'multisite-toolbar-additions' ) )
		);

			$mstba_tb_items[ 'addnew_theme_upload' ] = array(
				'parent' => $addnew_theme,
				'title'  => __( 'Upload ZIP file', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'theme-install.php?tab=upload' ),
				'meta'   => array( 'target' => '', 'title' => __( 'Install Theme - Upload ZIP file', 'multisite-toolbar-additions' ) )
			);

	/** Site Extend Group: Main Entry */
	if ( MSTBA_DISPLAY_SITE_EXTEND_GROUP ) {

		$wp_admin_bar->add_group( array(
			'parent' => 'site-name',
			'id'     => $siteextgroup,
		) );

		/** Action Hook 'mstba_custom_network_items' - allows for hooking in other site-specific items */
		do_action( 'mstba_custom_network_items' );

	}  // end-if constant check


	/** Include code part with plugin support items */
	require_once( MSTBA_PLUGIN_DIR . '/includes/mstba-plugins.php' );


	/** Action Hook 'mstba_custom_plugin_items' - allows for hooking in other plugin items */
	do_action( 'mstba_custom_plugin_items' );


	/** Allow menu items to be filtered, but pass in parent menu item IDs */
	$mstba_tb_items = (array) apply_filters( 'ddw_mstba_menu_items', $mstba_tb_items,
									$networkplugins,
									$networkthemes,
									$networkextgroup,
										$networkext_quickcache,
										$networkext_wpsupercache,
										$networkext_wppiwik,
										$networkext_orgmessagenotifier,
										$networkext_codesnippets,
										$networkext_backwpup,
										$networkext_snapshot,
										$networkext_snapshot_destinations,
										$networkext_smartadmintweaks,
										$networkext_smartcleanuptools,
									$siteextgroup,
										$siteext_quickcache,
										$siteext_wpsupercache,
										$siteext_wppiwik,
										$siteext_wprcinstaller,
										$siteext_relevanssi,
										$siteext_codesnippets,
										$siteext_cwwpcsnippets,
										$siteext_backwpup,
										$siteext_snapshot,
										$siteext_snapshot_destinations,
										$siteext_smartadmintweaks,
										$siteext_smartcleanuptools,
										$siteext_rvgoptimizedb,
									$sitegroup,
									$addnewgroup,
										$addnew_plugin,
										$addnew_theme
			);  // end of array


	/** Loop through the menu items */
	foreach ( $mstba_tb_items as $mstba_menu_id => $mstba_tb_item ) {
		
		/** Add in the item ID */
		$mstba_tb_item[ 'id' ] = $mstba_prefix . $mstba_menu_id;

		/** Add meta target to each item where it's not already set, so links open in new window/tab */
		if ( ! isset( $mstba_tb_item[ 'meta' ][ 'target' ] ) )		
			$mstba_tb_item[ 'meta' ][ 'target' ] = '_blank';

		/** Add class to links that open up in a new window/tab */
		if ( '_blank' === $mstba_tb_item[ 'meta' ][ 'target' ] ) {
			if ( ! isset( $mstba_tb_item[ 'meta' ][ 'class' ] ) )
				$mstba_tb_item[ 'meta' ][ 'class' ] = '';
			$mstba_tb_item[ 'meta' ][ 'class' ] .= $mstba_prefix . 'mstba-new-tab';
		}

		/** Add menu items */
		$wp_admin_bar->add_menu( $mstba_tb_item );

	}  // end foreach menu items

}  // end of function ddw_mstba_toolbar_additions


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_toolbar_subsite_items' );
/**
 * Adding subsite items within "My Sites/[Site Name]"
 *
 * @since 1.0.0
 *
 * @uses $blog To get Site ID.
 *
 * @param $mstba_blog_menu_id
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_subsite_items() {

	global $wp_admin_bar;

	/**
	 * Required WordPress cabability to display new toolbar bar entries
	 * Only showing items if toolbar / admin bar is activated and super admin user is logged in!
	 *
	 * @since 1.0.0
	 */
	if ( ! is_super_admin()
		|| ! is_user_logged_in()
		|| ! is_admin_bar_showing()
		|| ! MSTBA_DISPLAY_SUBSITE_ITEMS	// allows for custom disabling
	) {
		return;
	}

	/** Adding new items for each subsite */
	foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {

		/** Get ID of subsite/blog */
		$mstba_blog_menu_id = 'blog-' . $blog->userblog_id;

		/** Remove original "Visit Site" menu item (only to re-add later on as last item!) */
		$wp_admin_bar->remove_menu( $mstba_blog_menu_id . '-v' );

		/** Site > Dashboard > Settings */
		$wp_admin_bar->add_menu( array(
			'parent' => $mstba_blog_menu_id . '-d',
			'id'     => $mstba_blog_menu_id . '-mstba_site_settings',
			'title'  => __( 'Site Settings', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'options-general.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Site Settings', 'multisite-toolbar-additions' ) )
		) );

		/** Site > Widgets */
		$wp_admin_bar->add_menu( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_widgets',
			'title'  => __( 'Site Widgets', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'widgets.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Site Widgets', 'multisite-toolbar-additions' ) )
		) );

		/** Site > Menus */
		$wp_admin_bar->add_menu( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_menus',
			'title'  => __( 'Site Menus', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'nav-menus.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Site Menus', 'multisite-toolbar-additions' ) )
		) );

		/** Site > Plugins */
		$wp_admin_bar->add_menu( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_plugins',
			'title'  => __( 'Site Plugins', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'plugins.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Site Plugins', 'multisite-toolbar-additions' ) )
		) );

		/** Site > Themes */
		$wp_admin_bar->add_menu( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_themes',
			'title'  => __( 'Site Themes', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'themes.php' ),
			'meta'   => array( 'target' => '', 'title' => __( 'Site Themes', 'multisite-toolbar-additions' ) )
		) );

		/** Re-add "Visit Site" item as the last one - and opening in blank window/tab */
		$wp_admin_bar->add_menu( array(  
			'parent' => $mstba_blog_menu_id,  
			'id'     => $mstba_blog_menu_id . '-v',  
			'title'  => __( 'Visit Site', 'multisite-toolbar-additions' ),  
			'href'   => get_home_url( $blog->userblog_id, '/' ),  
			'meta'   => array( 'target' => '_blank', 'title' => __( 'Visit Site', 'multisite-toolbar-additions' ) ) )  
		); 

	}  // end foreach

}  // end of function ddw_mstba_subsite_items


add_action( 'wp_head', 'ddw_mstba_admin_style' );
add_action( 'admin_head', 'ddw_mstba_admin_style' );
/**
 * Add the styles for new WordPress Toolbar / Admin Bar entry
 * 
 * @since 1.3.0
 */
function ddw_mstba_admin_style() {

	/** No styles if admin bar is disabled or user is not logged in or items are disabled via constant */
	if ( ! is_admin_bar_showing()
		|| ! is_user_logged_in()
		|| ! MSTBA_DISPLAY_NETWORK_EXTEND_GROUP
	) {
		return;
	}

	?>
	<style type="text/css">
		#wpadminbar #wp-admin-bar-my-sites-super-admin.ab-submenu {
			border-top: 0 none !important;
		}
	</style>
	<?php

}  // end of function ddw_mstba_admin_style


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since 1.1.0
 *
 * @uses get_plugins()
 *
 * @param $mstba_plugin_value
 * @param $mstba_plugin_folder
 * @param $mstba_plugin_file
 *
 * @return string Plugin version
 */
function ddw_mstba_plugin_get_data( $mstba_plugin_value ) {

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$mstba_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$mstba_plugin_file = basename( ( __FILE__ ) );

	return $mstba_plugin_folder[ $mstba_plugin_file ][ $mstba_plugin_value ];

}  // end of function ddw_mstba_plugin_get_data