<?php
/**
	@brief		Base class for the Plainview Wordpress SDK.
	@details	Provides a framework with which to build Wordpress modules.

	To include this file, copy the complete SDK to a subdirectory and add the following line of code to the top of your source.

	@code
		if ( ! class_exists( '\\plainview\\sdk\\wordpress\\base' ) )	require_once( 'plainview_sdk/wordpress/base.php' );
	@encode

	Then extend this class.
	@code
		extends \\plainview\\sdk\\wordpress\\base
	@endcode

	@par	Changelog

	- 20131211				Better options handling (64 and 255 length checks).
	- 20131210				get_option_prefix allows for shortening of option names.
	- 20131019				table top().
	- 20131018				display_message uses pv_message div class.
	- 20131016				Added description_ to pot. Nicer admin_uninstall.
	- 20131015				Removed check_column_body and check_column_head. Added roles().
	- 20131007				Fixed add_submenu_pages bug.
	- 20131004				Converted submenu_pages to collection.
	- 20131004				cli_sdk_info(). Call using php PLUGIN.PHP --sdk_info
	- 20130811				$plugin_version
	- 20130810				time_to_string()
	- 20130809				No longer needs to be constructed with the __FILE__ as a parameter. \n
							admin_init action removed. \n
							$this->is_multisite added.
	- 20130723				Removed mail() method.
	- 20130722				New: _construct()
	- 20130605				New: yes_no()
	- 20130604				Code: add_shortcode() has an optional callback parameter.
	- 20130528				Fix: p() checks for sprintf problems.
	- 2013-05-07	07:45	New: check_column_* uses a th ID.
	- 2013-05-05	09:27	New: add_action, add_filter, add_shortcode. \n
					15:48	New: CLI handling. cli_pot(), do_cli(), pot_files(), pot_keywords().
	- 2013-05-04	15:53	Version moved into \\plainview\\sdk\\base.
	- 2013-05-03	15:38	Fix: display_form_table now calls cell->attribute() not attr() (which doesn't exist).
	- 2013-05-01	14:17	New: SDK version requirement tells the user which plugin is the SDK source. \n
							New: tabs() can return a \\tabs object.
	- 2013-04-30	08:54	New: ABSPATH check on construct().
	- 2013-04-25	08:53	New: string_to_emails() convert a string of e-mails to an array. \n
					12:19	New: instance() to retrieve the current instance of the object. \n
					20:14	Code: Lots of static, non-wordpress specific functions moved to \\plainview\\sdk\\base.
	- 2013-04-24	15:57	Code: Removed array_to_object. \n
							Code: Lots of functions have become static.
	- 2013-04-23	16:56	Code: mime_type() is now static.
	- 2013-04-22	17:02	New: db_aware_object added.
	- 2013-04-16	13:45	New: Added sdk_version and sdk_version_required.
							New: Added sdk version check on __construct().
							New: activate(), deactivate() and uninstall() should no longer call parent::.
							Code cleanup.
	- 2013-04-10	21:21	Fix: Converted to plainview\\sdk\\wordpress SDK.
							Fix: Removed object_to_array
							Fix: send_mail options are far more underscored.
							Fix: Functions better documented.
							New: open_close_tag(), h1(), h2(), h3()
	- 2013-04-08	20:20	New: sd_table classes.
							New: merge_objects
							Fix: check_column and check_column_body accept the table as a parameter.
	- 2013-03-07	15:43	New: add_submenu_page and add_submenu_pages
	- 2013-03-05	12:45	Fix: check_plain also stripslashes.
	- 2013-03-01	10:25	New: check_column() and check_column_body().
	- 2013-03-01	10:25	Fix: display_form_table inserted input names automatically (based on the array key).
	- 2013-02-15	04:51	Fix: role_at_least optimized for super admin queries.
	- 2012-12-14	08:47	Fix: role_at_least works again. It appears as current_user_can is broken somehow.
	- 2012-12-13	19:55	Fix: super admin can do everything when asked role_at_least
	- 2012-12-12	12:16	Added is_email function to check for e-mail validity.
	- 2012-12-10	19:37	Fixed mime typing when attaching files to mails.
	- 2012-11-07	16:36	Removed static styling from message boxes, added CSS classes.
	- 2012-11-07	12:39	Fix: error_ returns an error, not a message.
	- 2012-10-10	19:10	Added message()_ and error_().
	- 2012-09-17	15:35	Fix neverending loop in array_sort_subarrays.
	- 2012-05-25	11:20	All functions are now public. No more bickering about protected here and there.
	- 2012-05-21	20:00	tabs now work on tab_slugs, not slugged tab names.
	- 2012-05-18	13:54	Refactoring of tabs() variable names.
	- 2012-05-16	19:03	_() can act as sprint.
							Display form table now has ( $inputs, $options )
	- 2012-05-08	13:15	Tries to get mime type of attached files when sending mail.
	- 2012-02-10			display_form_table ignores hidden inputs.
	- 2011-08-03			tab functions can now be arrays (class, method).
	- 2011-08-02			array_to_object.
	- 2011-07-28			activate, decactivate and uninstall are public.
	- 2011-07-19			Documentation added.
	- 2011-05-12			displayMessage now uses now() instead of date.
	- 2011-04-30			Uses ThreeWP_Form instead of edwardForm.
	- 2011-04-29	09:19	site options are registered even when using single Wordpress.
	- 2011-01-25	13:14	load_language assumes filename as domain.
	- 2011-01-25	13:14	loadLanguages -> load_language.
	- 2011-09-19	12:43	No more need to register activation or deactivation hooks.
	- 2011-09-22	14:29	+roles_as_options
	- 2011-09-26	12:05	_() method made public.
	- 2011-09-29	21:16	role_at_least checks that there is a user logged in at all.
	- 2011-10-08	07:34	Uses SD_Form instead of ThreeWP_Form (name change).
	- 2011-10-17	09:34	paths also includes __FILE__.
	- 2011-10-22	19:16	get_site_option and get_local_option have default parameters.
	- 2011-10-28	14:00	URLMake removed. tabs() now uses Wordpress' add_query_arg and remove_query_arg.
	- 2011-11-04	09:42	now() is public
	- 2011-11-07	16:11	new: rmdir().

	@author		Edward Plainview	edward@plainview.se
	@copyright	GPL v3
	@version	20131015

*/

namespace plainview\sdk\wordpress;

class base
	extends \plainview\sdk\base
{
	/**
		@brief		Stores whether this blog is a network blog.
		@since		20130416
		@var		$is_network
	**/
	protected $is_network;

	/**
		@brief		Text domain of .PO translation.
		If left unset will be set to the base filename minus the .php
		@var		$language_domain
		@since		20130416
	**/
	protected $language_domain = '';

	/**
		@brief		Array of options => default_values that this plugin stores locally.
		@since		20130416
		@var		$local_options
	**/
	protected $local_options = array();

	/**
		@brief		Contains the paths to the plugin and other places of interest.

		The keys in the array are:

		name<br />
		filename<br />
		filename_from_plugin_directory<br />
		path_from_plugin_directory<br />
		path_from_base_directory<br />
		url<br />

		@since		20130416
		@var		$paths
	**/
	public $paths = array();

	/**
		@brief		The version of the plugin.
		@since		20130811
		@var		$plugin_version
	**/
	public $plugin_version = 20000101;

	/**
		@brief		Use this property in your extended class to require that the SDK is a specific version.
		@since		20130416
		@var		$sdk_version_required
	**/
	protected $sdk_version_required = 20000101;

	/**
		@brief		Links to Wordpress' database object.
		@since		20130416
		@var		$wpdb
	**/
	protected $wpdb;

	/**
		@brief		The list of the standard user roles in Wordpress.

		First an array of role_name => array

		And then each role is an array of name => role_name and current_user_can => capability.

		@since		20130416
		@var		$roles
	**/
	protected $roles = array(
		'administrator' => array(
			'name' => 'administrator',
			'current_user_can' => 'manage_options',
		),
		'editor' => array(
			'name' => 'editor',
			'current_user_can' => 'manage_links',
		),
		'author' => array(
			'name' => 'author',
			'current_user_can' => 'publish_posts',
		),
		'contributor' => array(
			'name' => 'contributor',
			'current_user_can' => 'edit_posts',
		),
		'subscriber' => array(
			'name' => 'subscriber',
			'current_user_can' => 'read',
		),
	);

	/**
		@brief		Array of options => default_values that this plugin stores sitewide.
		@since		20130416
		@var		$site_options
	**/
	protected $site_options = array();

	/**
		@brief		Construct the class.
		@param		string		$filename		The __FILE__ special variable of the parent.
		@since		20130416
	**/
	public function __construct( $filename = null )
	{
		// If no filename was specified, try to get the parent's filename.
		if ( $filename === null )
		{
			$stacktrace = @debug_backtrace( false );
			$filename = $stacktrace[ 0 ][ 'file' ];
		}

		if ( ! defined( 'ABSPATH' ) )
		{
			// Was this run from the command line?
			if ( isset( $_SERVER[ 'argc'] ) )
			{
				$this->paths = array(
					'__FILE__' => $filename,
					'name' => get_class( $this ),
					'filename' => basename( $filename ),
				);
				$this->do_cli();
			}
			else
				wp_die( 'ABSPATH is not defined!' );
		}

		parent::__construct();

		global $wpdb;
		$this->wpdb = $wpdb;

		$this->is_network = MULTISITE;
		$this->is_multisite = MULTISITE;

		$this->submenu_pages = new \plainview\sdk\collections\collection;

		$this->paths = array(
			'__FILE__' => $filename,
			'name' => get_class( $this ),
			'filename' => basename( $filename ),
			'filename_from_plugin_directory' => basename( dirname( $filename ) ) . '/' . basename( $filename ),
			'path_from_plugin_directory' => basename( dirname( $filename ) ),
			'path_from_base_directory' => PLUGINDIR . '/' . basename( dirname( $filename ) ),
			'url' => WP_PLUGIN_URL . '/' . basename( dirname( $filename ) ),
		);

		if ( $this->sdk_version_required > $this->sdk_version )
			wp_die( sprintf( 'This plugin requires Plainview SDK version %s, but only %s from the plugin %s is available.',
				$this->sdk_version_required,
				$this->sdk_version,
				dirname( __FILE__ )
			) );

		register_activation_hook( $this->paths['filename_from_plugin_directory'],	array( $this, 'activate_internal' ) );
		register_deactivation_hook( $this->paths['filename_from_plugin_directory'],	array( $this, 'deactivate_internal' ) );

		$this->_construct();
	}

	/**
		@brief		Overloadable method called after __construct.
		@details

		A convenience method that is called after the base is constructed.

		This method has the advantage of not requiring neither parameters nor parent::.

		@since		20130722
	**/
	public function _construct()
	{
	}

	/**
		@brief		Overridable activation function.
		@see		activate_internal()
		@since		20130416
	**/
	public function activate()
	{
	}

	/**
		@brief		Internal activation function.

		Child plugins should override activate().

		@since		20130416
	**/
	public function activate_internal()
	{
		$this->register_options();
		$this->activate();
	}

	/**
		@brief		Queues a submenu page for adding later.

		@details	Used to ensure alphabetic sorting of submenu pages independent of language.

		Uses the same parameters as Wordpress' add_submenu_page. Uses the menu title as the sorting key.

		After all pages have been add_submenu_page'd, call add_submenu_pages to actually sort and add them.

		@since		20130416
	**/
	public function add_submenu_page()
	{
		$args = func_get_args();
		$key = $args[ 4 ];
		$key = $this->strtolower( $key );
		$this->submenu_pages->set( $key, $args );
	}

	/**
		@brief		Flush the add_submenu_page cache.
		@details	Will first sort by key and then add the subpages.
		@since		20130416
	**/
	public function add_submenu_pages()
	{
		$this->submenu_pages->sortBy( function( $item )
		{
			return $item[ 2 ];
		} );
		foreach( $this->submenu_pages as $submenu )
			call_user_func_array( 'add_submenu_page', $submenu );
	}

	/**
		@brief		Shows the uninstall form.
		@since		20130416
	**/
	public function admin_uninstall()
	{
		$r = '';
		$form = $this->form2();
		$form->prefix( get_class( $this ) );

		$form->markup( 'uninstall_info' )
			->p_( 'This page will remove all the plugin tables and settings from the database and then deactivate the plugin.' );

		$form->checkbox( 'sure' )
			->label_( "Yes, I'm sure I want to remove all the plugin tables and settings." )
			->required();

		$form->primary_button( 'uninstall' )
			->value_( "Uninstall plugin" );

		if ( $form->is_posting() )
		{
			$form->post();
			if ( $form->input( 'uninstall' )->pressed() )
			{
				if ( $form->input( 'sure' )->get_post_value() != 'on' )
					$this->error_( 'You have to check the checkbox in order to uninstall the plugin.' );
				else
				{
					$this->uninstall_internal();
					$this->deactivate_me();
					if( is_network_admin() )
						$url ='ms-admin.php';
					else
						$url ='index.php';
					$this->message_( 'The plugin and all associated settings and database tables have been removed. Please %sfollow this link to complete the uninstallation procedure%s.',
						sprintf( '<a href="%s" title="%s">', $url, $this->_( 'This link will take you to the index page' ) ),
						'</a>' );
					return;
				}
			}
		}

		$r .= $form->open_tag();
		$r .= $form->display_form_table();
		$r .= $form->close_tag();
		echo $r;
	}

	/**
		@brief		Overridable deactivation function.
		@see		deactivate_internal()
		@since		20130416
	**/
	public function deactivate()
	{
	}

	/**
		@brief		Internal function that runs when deactivating the plugin.
		@since		20130416
	**/
	public function deactivate_internal()
	{
		$this->deactivate();
	}

	/**
		@brief		Deactivates the plugin.
		@since		20130416
	**/
	public function deactivate_me()
	{
		deactivate_plugins( [
			$this->paths['filename_from_plugin_directory']
		] );
	}

	/**
		@brief		Loads this plugin's language files.

		Reads the language data from the class's name domain as default.

		@param		$domain
					Optional domain.
		@since		20130416
	**/
	public function load_language( $domain = '' )
	{
		if ( $domain != '' )
			$this->language_domain = $domain;

		if ( $this->language_domain == '' )
			$this->language_domain = str_replace( '.php', '', $this->paths['filename'] );
		load_plugin_textdomain( $this->language_domain, false, $this->paths[ 'path_from_plugin_directory' ] . '/lang' );
	}

	/**
		@brief		Translate a string, if possible.

		Like Wordpress' internal _() method except this one automatically uses the plugin's domain.

		Can function like sprintf, if any %s are specified.

		@param		string		$string		String to translate. %s will require extra arguments to the method.
		@since		20130416
		@return		string					Translated string, or the untranslated string.
	**/
	public function _( $string )
	{
		$new_string = __( $string, $this->language_domain );

		$count = substr_count( $string, '%s' );
		if ( $count > 0 )
		{
			$args = func_get_args();
			array_shift( $args );

			if ( $count != count( $args ) )
				throw new \Exception( sprintf(
					'_() requires the same amount of arguments as occurrences of %%s. Needed: %s, given %s',
					$count,
					count( $args )
				) );

			array_unshift( $args, $new_string );
			$new_string =  call_user_func_array( 'sprintf', $args );
		}

		return $new_string;
	}

	/**
		@brief		Internal function to handle uninstallation (database removal) of module.
		@since		20130416
	**/
	public function uninstall_internal()
	{
		$this->deregister_options();
		$this->uninstall();
	}

	/**
		@brief		Overridable uninstall method.
		@since		20130416
	**/
	public function uninstall()
	{
	}

	// -------------------------------------------------------------------------------------------------
	// ----------------------------------------- USER
	// -------------------------------------------------------------------------------------------------

	/**
		@brief		Returns the user's role as a string.
		@return					User's role as a string.
		@since		20130416
	**/
	public function get_user_role()
	{
		foreach( $this->roles as $role )
			if ( current_user_can( $role['current_user_can'] ) )
				return $role['name'];
	}

	/**
		@brief		Returns the user roles as a select options array.
		@return		The user roles as a select options array.
		@since		20130416
	**/
	public function roles_as_options()
	{
		$r = array();
		if ( function_exists( 'is_super_admin' ) )
			$r['super_admin'] = $this->_( 'Super admin' );
		foreach( $this->roles as $role )
			$r[ $role[ 'name' ] ] = _( ucfirst( $role[ 'name' ] ) );		// See how we ask WP to translate the roles for us? See also how it doesn't. Sometimes.
		return $r;
	}

	/**
		@brief		Checks whether the user's role is at least $role.
		@param		$role		Role as string.
		@return					True if role is at least $role.
		@since		20130416
	**/
	public function role_at_least( $role )
	{
		global $current_user;
		wp_get_current_user();

		if ( $current_user === null )
		    return false;

		if ( $role == '' )
			return true;

		if (function_exists( 'is_super_admin' ) && is_super_admin() )
			return true;

		if ( $role == 'super_admin' )
			return false;

		// This was previously done by current_user_can, but for some reason it doesn't work all the time in WP3.5.
		// So now I have to check "manually", which probably means that filters are rendered ineffective.
		$role_cap = $this->roles[$role]['current_user_can'];
		return isset( $current_user->allcaps[ $role_cap ] ) && $current_user->allcaps[ $role_cap ] == true;
	}

	/**
		@brief		Return the user_id of the current user.
		@return		int						The user's ID.
		@since		20130416
	**/
	public function user_id()
	{
		global $current_user;
		get_current_user();
		return $current_user->ID;
	}

	// -------------------------------------------------------------------------------------------------
	// ----------------------------------------- MESSAGES
	// -------------------------------------------------------------------------------------------------

	/**
		@brief		Displays a message.

		Autodetects HTML / text.

		@param		$type
					Type of message: error, warning, whatever. Free content.

		@param		$string
					The message to display.
		@since		20130416
	**/
	public function display_message( $type, $string )
	{
		// If this string has html codes, then output it as it.
		$stripped = strip_tags( $string );
		if ( strlen( $stripped ) == strlen( $string ) )
		{
			$string = explode("\n", $string);
			$string = implode( '</p><p>', $string);
		}
		echo '<div class="message_box '.$type.'">
			<p class="message_timestamp">'.$this->now().'</p>
			<p>'.$string.'</p></div>';
	}

	/**
		@brief		Displays an informational message.
		@param		string		$string		String to create into a message.
		@since		20130416
	**/
	public function message( $string )
	{
		$this->display_message( 'updated pv_message', $string );
	}

	/**
		@brief		Convenience function to translate and then create a message from a string and optional sprintf arguments.
		@param		string		$string		String to translate and create into a message.
		@param		string		$args		One or more arguments.
		@return		A translated message.
		@since		20130416
	**/
	public function message_( $string, $args = '' )
	{
		$args = func_get_args();
		$string = call_user_func_array( array( &$this, '_' ), $args );
		return $this->message( $string );
	}

	/**
		@brief		Displays an error message.
		@details	The only thing that makes it an error message is that the div has the class "error".
		@param		string		$string		String to create into a message.
		@since		20130416
	**/
	public function error( $string )
	{
		$this->display_message( 'error', $string );
	}

	/**
		@brief		Convenience function to translate and then create an error message from a string and optional sprintf arguments.
		@param		string		$string		String to translate and create into a message.
		@param		string		$args		One or more arguments.
		@return		A translated error message.
		@since		20130416
	**/
	public function error_( $string, $args = null )
	{
		$args = func_get_args();
		$string = call_user_func_array( array( &$this, '_' ), $args );
		return $this->error( $string );
	}

	// -------------------------------------------------------------------------------------------------
	// ----------------------------------------- OPTIONS
	// -------------------------------------------------------------------------------------------------

	/**
		Deletes a site option.

		If this is a network, the site option is preferred.

		@param		$option		Name of option to delete.
		@since		20130416
	**/
	public function delete_option( $option )
	{
		if ( $this->is_network )
			$this->delete_site_option( $option );
		else
			$this->delete_local_option( $option );
	}

	/**
		Deletes a local option.

		@param		$option		Name of option to delete.
		@since		20130416
	**/
	public function delete_local_option( $option )
	{
		$option = $this->fix_local_option_name( $option );
		delete_option( $option );
	}

	/**
		Deletes a site option.

		@param		$option		Name of option to delete.
		@since		20130416
	**/
	public function delete_site_option( $option )
	{
		$option = $this->fix_site_option_name( $option );
		delete_site_option( $option );
	}

	/**
		@brief		Removes all the options this plugin uses.
		@since		20130416
	**/
	public function deregister_options()
	{
		if ( isset( $this->options ) )
			foreach( $this->options as $option=>$value )
				$this->delete_option( $option );

		foreach( $this->local_options as $option=>$value )
		{
			$option = $this->fix_local_option_name( $option );
			delete_option( $option );
		}

		if ( $this->is_network )
			foreach( $this->site_options as $option=>$value )
			{
				$option = $this->fix_site_option_name( $option );
				delete_site_option( $option );
			}
		else
		{
			foreach( $this->site_options as $option=>$value )
			{
				$option = $this->fix_local_option_name( $option );
				delete_option( $option, $value );
			}
		}
	}

	/**
		@brief		Gets the proper option name for a local option.
		@details	Does a 64 char length check and outputs an error in WP_DEBUG mode.
		@since		20131211
	**/
	public function fix_local_option_name( $option )
	{
		$max = 64;
		$name = $this->get_local_option_prefix() . '_' . $option;
		if ( defined( 'WP_DEBUG' ) && strlen( $name ) > $max )
		{
			$text = sprintf( '%s<code>%s</code>',
				substr( $text, 0, $max ),
				substr( $text, $max )
			);
			echo "Option $text is longer than $max characters.\n<br />";
		}
		return $name;
	}

	/**
		Normalizes the name of an option.

		Will prepend the class name in front, to make the options easily findable in the table.

		@param		$option		Option name to fix.
		@since		20130416
	**/
	public function fix_option_name( $option )
	{
		if ( $this->is_network )
			$name = $this->get_site_option_prefix() . '_' . $option;
		else
			$name = $this->get_local_option_prefix() . '_' . $option;
		return $name;
	}

	/**
		@brief		Gets the proper option name for a site option.
		@details	Does a 255 char length check and outputs an error in WP_DEBUG mode.
		@since		20131211
	**/
	public function fix_site_option_name( $option )
	{
		$max = 255;
		$name = $this->get_site_option_prefix() . '_' . $option;
		if ( defined( 'WP_DEBUG' ) && strlen( $name ) > $max )
		{
			$text = sprintf( '%s<code>%s</code>',
				substr( $text, 0, $max ),
				substr( $text, $max )
			);
			echo "Option $text is longer than $max characters.\n<br />";
		}
		return $name;
	}

	/**
		@brief		Returns the prefix for local options.
		@since		20131211
	**/
	public function get_local_option_prefix()
	{
		return $this->get_option_prefix();
	}

	/**
		@brief		Returns the options prefix.
		@details

		Override this is you find that your options are a bit too long.
		@since		20130416
	**/
	public function get_option_prefix()
	{
		return $this->paths['name'];
	}

	/**
		@brief		Returns the prefix for site options.
		@since		20131211
	**/
	public function get_site_option_prefix()
	{
		return $this->get_option_prefix();
	}

	/**
		Get a site option.

		If this is a network, the site option is preferred.

		@param		$option		Name of option to get.
		@return					Value.
		@since		20130416
	**/
	public function get_option( $option )
	{
		if ( $this->is_network )
			return $this->get_site_option( $option );
		else
			return $this->get_local_option( $option );
	}

	/**
		Gets the value of a local option.

		@param		$option			Name of option to get.
		@param		$default		The default value if the option === false
		@return						Value.
		@since		20130416
	**/
	public function get_local_option( $option, $default = false)
	{
		$option = $this->fix_local_option_name( $option );
		$value = get_option( $option );
		if ( $value === false )
			return $default;
		else
			return $value;
	}

	/**
		Gets the value of a site option.

		@param		$option		Name of option to get.
		@param		$default	The default value if the option === false
		@return					Value.
		@since		20130416
	**/
	public function get_site_option( $option, $default = false )
	{
		$option = $this->fix_site_option_name( $option );
		$value = get_site_option( $option );
		if ( $value === false )
			return $default;
		else
			return $value;
	}

	/**
		Registers all the options this plugin uses.
		@since		20130416
	**/
	public function register_options()
	{
		foreach( $this->local_options as $option=>$value )
		{
			$option = $this->fix_local_option_name( $option );
			if ( get_option( $option ) === false )
				update_option( $option, $value );
		}

		if ( $this->is_network )
		{
			foreach( $this->site_options as $option=>$value )
			{
				$option = $this->fix_site_option_name( $option );
				if ( get_site_option( $option ) === false )
					update_site_option( $option, $value );
			}
		}
		else
		{
			foreach( $this->site_options as $option=>$value )
			{
				$option = $this->fix_local_option_name( $option );
				if (get_option( $option ) === false)
					update_option( $option, $value );
			}
		}
	}

	/**
		Updates a site option.

		If this is a network, the site option is preferred.

		@param		$option		Name of option to update.
		@param		$value		New value
		@since		20130416
	**/
	public function update_option( $option, $value )
	{
		if ( $this->is_network )
			$this->update_site_option( $option, $value );
		else
			$this->update_local_option( $option, $value );
	}

	/**
		Updates a local option.

		@param		option		Name of option to update.
		@param		$value		New value
		@since		20130416
	**/
	public function update_local_option( $option, $value )
	{
		$option = $this->fix_local_option_name( $option );
		update_option( $option, $value );
	}

	/**
		Updates a site option.

		@param		$option		Name of option to update.
		@param		$value		New value
		@since		20130416
	**/
	public function update_site_option( $option, $value )
	{
		$option = $this->fix_site_option_name( $option );
		update_site_option( $option, $value );
	}

	// -------------------------------------------------------------------------------------------------
	// ----------------------------------------- SQL
	// -------------------------------------------------------------------------------------------------

	/**
		Sends a query to wpdb and return the results.

		@param		$query		The SQL query.
		@param		$wpdb		An optional, other WPDB if the standard $wpdb isn't good enough for you.
		@return		array		The rows from the query.
		@since		20130416
	**/
	public function query( $query , $wpdb = null )
	{
		if ( $wpdb === null )
			$wpdb = $this->wpdb;
		$results = $wpdb->get_results( $query, 'ARRAY_A' );
		return (is_array( $results) ? $results : array());
	}

	/**
		Fire an SQL query and return the results only if there is one row result.

		@param		$query			The SQL query.
		@return						Either the row as an array, or false if more than one row.
		@since		20130416
	**/
	public function query_single( $query)
	{
		$results = $this->wpdb->get_results( $query, 'ARRAY_A' );
		if ( count( $results) != 1)
			return false;
		return $results[0];
	}

	/**
		Fire an SQL query and return the row ID of the inserted row.

		@param		$query		The SQL query.
		@return					The inserted ID.
		@since		20130416
	**/
	public function query_insert_id( $query)
	{
		$this->wpdb->query( $query);
		return $this->wpdb->insert_id;
	}

	/**
		Converts an object to a base64 encoded, serialized string, ready to be inserted into sql.

		@param		$object		An object.
		@return					Serialized, base64-encoded string.
		@since		20130416
	**/
	public function sql_encode( $object )
	{
		return base64_encode( serialize( $object) );
	}

	/**
		Converts a base64 encoded, serialized string back into an object.
		@param		$string			Serialized, base64-encoded string.
		@return						Object, if possible.
		@since		20130416
	**/
	public function sql_decode( $string )
	{
		return unserialize( base64_decode( $string) );
	}

	/**
		Returns whether a table exists.

		@param		$table_name		Table name to check for.
		@return						True if the table exists.
		@since		20130416
	**/
	public function sql_table_exists( $table_name )
	{
		$query = "SHOW TABLES LIKE '$table_name'";
		$result = $this->query( $query );
		return count( $result) > 0;
	}

	// -------------------------------------------------------------------------------------------------
	// ----------------------------------------- TOOLS
	// -------------------------------------------------------------------------------------------------

	/**
		@brief		Convenience function to add a Wordpress action.
		@details	Using almost the same parameters as add_action(), this method can be used if the action has the same base method name as the callback.

		If that is the case, then $callback can be skipped. Priority and parameters can also be skipped if you are using the same default values as Wordpress' add_action().

		Example:

		@code
			$this->add_action( 'plainview_enter_castle', 'action_plainview_enter_castle', 10, 1 );		// All parameters specified
			$this->add_action( 'plainview_enter_castle', 'action_plainview_enter_castle' );				// Priority and parameter count skipped (using Wordpress defaults)
			$this->add_action( 'plainview_enter_castle', 10, 1 );										// Calls $base->plainview_enter_castle
			$this->add_action( 'plainview_enter_castle' );												// Calls $base->plainview_enter_castle
			$this->add_action( 'plainview_enter_castle', null, 3 );										// Uses Wordpress default priority and three parameters.
		@endcode

		@param		string		$action			The name of the action to create.
		@param		mixed		$callback		Either the callback, or the priority, or nothing.
		@param		mixed		$priority		If $callback is specified, then this is the priority. Else this is the amount of parameters.
		@param		mixed		$parameters		Used only if callback and priority are specified.
		@since		20130505
	**/
	public function add_action( $action, $callback = null, $priority = null, $parameters = null )
	{
		$args = array_merge( array( 'action' ), func_get_args() );
		return call_user_func_array( array( $this, 'add_thing' ), $args );
	}

	/**
		@brief		Convenience function to add a Wordpress filter.
		@details	Using almost the same parameters as add_filter(), this method can be used if the filter has the same base method name as the callback.

		If that is the case, then $callback can be skipped. Priority and parameters can also be skipped if you are using the same default values as Wordpress' add_filter().

		Example:

		@code
			$this->add_filter( 'plainview_enter_castle', 'filter_plainview_enter_castle', 10, 1 );		// All parameters specified
			$this->add_filter( 'plainview_enter_castle', 'filter_plainview_enter_castle' );				// Priority and parameter count skipped (using Wordpress defaults)
			$this->add_filter( 'plainview_enter_castle', 10, 1 );										// Calls $base->plainview_enter_castle
			$this->add_filter( 'plainview_enter_castle' );												// Calls $base->plainview_enter_castle
			$this->add_filter( 'plainview_enter_castle', null, 3 );										// Uses Wordpress default priority and three parameters.
		@endcode

		@param		string		$filter			The name of the filter to create.
		@param		mixed		$callback		Either the callback, or the priority, or nothing.
		@param		mixed		$priority		If $callback is specified, then this is the priority. Else this is the amount of parameters.
		@param		mixed		$parameters		Used only if callback and priority are specified.
		@since		20130505
	**/
	public function add_filter( $filter, $callback = null, $priority = null, $parameters = null )
	{
		$args = array_merge( array( 'filter' ), func_get_args() );
		return call_user_func_array( array( $this, 'add_thing' ), $args );
	}

	/**
		@brief		Convenience method to add a shortwith with the same method name as the shortcode.
		@param		string		$shortcode		Name of the shortcode, which should be the same name as the method to be called in the base.
		@param		string		$callback		An optional callback method. If null the callback is assumed to have the same name as the shortcode itself.
		@since		20130505
	**/
	public function add_shortcode( $shortcode, $callback = null )
	{
		if ( $callback === null )
			$callback = $shortcode;
		return add_shortcode( $shortcode, array( $this, $callback ) );
	}

	/**
		@brief		Adds a Wordpress action or filter.
		@see		add_action
		@see		add_filter
		@since		20130505
	**/
	public function add_thing()
	{
		$args = func_get_args();
		// The add type is the first argument
		$type = 'add_' . array_shift( $args );
		$thing = $args[ 0 ];
		// If the callback is not specified, then assume the same callback as the thing.
		if ( ! isset( $args[ 1 ] ) )
			$args[ 1 ] = $args[ 0 ];
		// Is the callback anything but a string? That means parameter 1 is the priority.
		if ( ! is_string( $args[ 1 ] ) )
			array_splice( $args, 1, 0, $thing );
		// * ... which is then turned into a self callback.
		if ( ! is_array( $args[ 1 ] ) )
			$args[ 1 ] = array( $this, $args[ 1 ] );
		// No parameter count set? Unset it to allow add_* to use the default Wordpress value.
		if ( isset( $args[ 3 ] ) && $args[ 3 ] === null )
			unset( $args[ 3 ] );
		// Is the priority set to null? Then use the Wordpress default.
		if ( isset( $args[ 2 ] ) && $args[ 2 ] === null )
			$args[ 2 ] = 10;
		return call_user_func_array( $type, $args );
	}

	/**
		@brief		Display the time ago as human-readable string.
		@param		$time_string	"2010-04-12 15:19"
		@param		$time			An optional timestamp to base time difference on, if not now.
		@return						"28 minutes ago"
		@since		20130416
	**/
	public static function ago( $time_string, $time = null)
	{
		if ( $time_string == '' )
			return '';
		if ( $time === null )
			$time = current_time( 'timestamp' );
		$diff = human_time_diff( strtotime( $time_string), $time );
		return '<span title="'.$time_string.'">' . sprintf( __( '%s ago' ), $diff) . '</span>';
	}

	/**
		@brief		Return an xgettext command line that will generate all strings necessary for translation.
		@details	Will collect keywords from the SDK and the subclass.
		@return		string		xgettext command line suggestion.
		@see		pot_files()
		@see		pot_keyswords()
		@since		20130505
	**/
	public function cli_pot()
	{
		$basedir = dirname( $this->paths[ '__FILE__' ] ) . '/';
		$files = array_merge( array(
			basename( $this->paths[ '__FILE__' ] ),									// subclass.php
			str_replace( $basedir, '', dirname( dirname( __FILE__ ) ) . '/*php' ),	// plainview/*php
			str_replace( $basedir, '', dirname( dirname( __FILE__ ) ) . '/form2/inputs/*php' ),
			str_replace( $basedir, '', dirname( dirname( __FILE__ ) ) . '/form2/inputs/traits/*php' ),
			str_replace( $basedir, '', dirname( __FILE__ ) . '/*php' ),				// plainview_sdk/wordpress/*.php
		), $this->pot_files() );

		$filename = preg_replace( '/\.php/', '.pot', $this->paths[ '__FILE__' ] );

		$keywords = array_merge( array(
			'_',
			'error_',
			'description_',	// form2
			'message_',
			'heading_',		// tabs
			'label_',		// form2
			'name_',		// tabs
			'option_',		// form2
			'p_',
			'text_',		// table
			'value_',		// form2
		), $this->pot_keywords() );

		$pot = dirname( $filename ) . '/lang/' . basename( $filename );

		$command = sprintf( 'xgettext -s -c --no-wrap -d %s -p lang -o "%s" --omit-header%s %s',
			get_class( $this ),
			$pot,
			$this->implode_html( $keywords, ' -k', '' ),
			implode( ' ', $files )
		);
		echo $command;
		echo "\n";
	}

	/**
		@brief		Return the version of the SDK required by the plugin.
		@details	Will examine the plugin file and try to figure out which version of the SDK the plugin requires.
		@return		string		The version required by the Wordpress plugin.
		@since		20131004
	**/
	public function cli_sdk_info()
	{
		$version_required = 20010101;
		$because_of = 'undefined';

		$file = $this->paths[ '__FILE__' ];

		// Find all of the function of the plugin.
		$functions = new \plainview\sdk\collections\collection;
		$lines = file_get_contents( $file );
		$lines = explode( "\n", $lines );
		$lines = array_filter( $lines );
		foreach( $lines as $line )
		{
			// Find all "$this->ABC(" strings.
			preg_match_all( '/\$this-\>[A-Z_a-z?]*\(/', $line, $matches );
			foreach( $matches[ 0 ] as $function )
			{
				// Clean up the string
				$function = preg_replace( '/.*-\>([A-Z_a-z_]*)\(/', '\1', $function );
				// And store it.
				$functions->put( $function, $function );
			}
		}

		// Now read the Wordpress SDK and the base.
		foreach( [
			__FILE__,
			__DIR__ . '/../base.php',
		] as $file )
		{
			$contents = file_get_contents( $file );
			$lines = explode( "\n", $contents );
			$lines = array_reverse( $lines );

			$since = null;
			foreach( $lines as $line )
			{
				$line = trim( $line );

				if ( $since !== null )
				{
					if ( strpos( $line, '@since' ) !== 0 )
						continue;
					$date = preg_replace( '/([^0-9])/', '', $line );
					if ( $date > $version_required )
					{
						$version_required = $date;
						$because_of = $function;
					}
					$since = null;
				}

				foreach( $functions as $function )
				{
					if ( strpos( $line, 'function ' . $function . '(' ) === false )
						continue;
					$since = $function;
					// We've found this function in the SDK file. Remove it so we don't look it up later.
					$functions->forget( $function );
				}
			}
				// Are we looking for a @since?
		}

		echo sprintf( "Version %s is required because of the function %s().", $version_required, $because_of );
		echo "\n";
	}

	/**
		@brief		Displays an array of inputs using Wordpress table formatting.
		@param		array		$inputs		Array of \\plainview\\sdk\\wordpress\\form inputs.
		@param		array		$options	Array of options.
		@since		20130416
	**/
	public function display_form_table( $inputs, $options = array() )
	{
		$options = \plainview\sdk\base::merge_objects( array(
			'form' => null,
			'header' => '',
			'header_level' => 'h3',
		), $options );

		$r = '';

		if ( $options->form === null )
			$options->form = $this->form();

		$table = $this->table()->set_attribute( 'class', 'form-table' );

		foreach( $inputs as $name => $input )
		{
			if ( ! isset( $input[ 'name' ] ) )
				$input[ 'name' ] = $name;

			if ( $input[ 'type' ] == 'hidden' )
			{
				$r .= $options->form->make_input( $input );
				continue;
			}
			$o = new \stdClass();
			$o->input = $input;
			$o->form = $options->form;

			if ( $input[ 'type' ] == 'markup' )
			{
				$table->body()->row()->td()->set_attribute( 'colspan', 2 )->text( $options->form->make_input( $input ) );
				continue;
			}

			$table->body()->row()
				->th()->text( $options->form->make_label( $input ) )->row()
				->td()->textf( '<div class="input_itself">%s</div><div class="input_description">%s</div>',
					$options->form->make_input( $input ),
					$options->form->make_description( $input )
				);
		}

		if ( $options->header != '' )
			$r .= sprintf( '<%s>%s</%s>',
				$options->header_level,
				$options->header,
				$options->header_level
			);

		$r .= $table;

		return $r;
	}

	/**
		@brief		Handles command line arguments.
		@details	Using an array of long options, will call the respective method to handle the option.

		For example: `php Inherited_Class.php --pot` will call do_pot().
		@see		long_options
		@since		20130505
	**/
	public function do_cli()
	{
		$long_options = array_merge( [ 'pot', 'sdk_info' ], $this->long_options() );
		$options = (object) getopt( '', $long_options );

		foreach( $options as $option => $value )
		{
			$f = 'cli_' . $option;
			$this->$f( $options );
		}

		die();
	}

	/**
		@brief		Output a file to the browser for downloading.
		@param		string		$file			Path to file on disk.
		@param		string		$name			Downloaded file's name.
		@param		string		$mime_type		Optional mime_type.
		@author		http://w-shadow.com/blog/2007/08/12/how-to-force-file-download-with-php/
		@since		20130416
		@todo		Have another look at this some time...
	**/
	public function download( $filepath, $options = array() )
	{
		if ( ! is_readable( $filepath ) )
			throw new \Exception( "The file $filepath could not be read!" );

		$o = (object) array_merge( array(
			'cache' => true,
			'content_disposition' => 'attachment',
			'content_type' => '',
			'etag' => true,
			'expires' => 3600 * 24 * 7,		// one week
			'filemtime' => filemtime( $filepath ),
			'filename' => '',
			'filesize' => filesize( $filepath ),
			'md5_file' => true,
		), $options );

		// 304 support
		if ( $o->cache && isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) )
		{
			$since = $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ];
			$since = strtotime( $since );
			if ( $since >= $o->filemtime )
			{
				header( 'HTTP/1.1 304 Not Modified' );
				return;
			}
		}

		if ( $o->filename == '' )
			$o->filename = basename( $filepath );

		$headers = array(
			'Accept-Ranges: bytes',
			'Content-Disposition: ' . $o->content_disposition . '; filename="' . $o->filename . '"',
			'Content-Transfer-Encoding: binary',
			'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $o->filemtime ) . ' GMT',
		);

		if ( $o->content_type == '' )
		{
			$mime_types = array
			(
				'doc' => 'application/msword',
				'exe' => 'application/octet-stream',
				'gif' => 'image/gif',
				'htm' => 'text/html',
				'html' => 'text/html',
				'jpeg'=> 'image/jpg',
				'jpg' => 'image/jpg',
				'pdf' => 'application/pdf',
				'php' => 'text/plain',
				'ppt' => 'application/vnd.ms-powerpoint',
				'png' => 'image/png',
				'txt' => 'text/plain',
				'xls' => 'application/vnd.ms-excel',
				'zip' => 'application/zip',
			);
			$file_extension = strtolower( substr( strrchr( $o->filename, '.' ), 1 ) );
			if ( isset( $mime_types[ $file_extension ] ) )
				$o->content_type = $mime_types[ $file_extension ];
			else
				$o->content_type = 'application/octet-stream';
		}
		$headers[] = 'Content-Type: ' . $o->content_type;

		if ( $o->cache === false )
		{
			$headers[] = 'Cache-Control: no-cache, no-store';
	 		$headers[] = 'Pragma: private';
	 		$headers[] = 'Expires: Mon, 26 Jul 1995 00:00:00 GMT';
		}
		else
		{
			$expires = $o->filemtime + $o->expires;
			$headers[] = 'Expires: ' . gmdate( 'D, d M Y H:i:s', $expires ) . ' GMT';
			$headers[] = 'Cache-Control: max-age=' . $o->expires;
		}

		if ( $o->etag !== false )
		{
			$etag = ( $o->etag !== true ? $o->etag : md5( filesize( $o->filepath ) . filemtime( $o->filepath ) ) );
			$headers[] = 'ETag: ' . $etag;
		}

		if ( $o->md5_file == true )
			$headers[]  = 'Content-MD5: ' . base64_encode( md5_file( $filepath ) );

		// Resume support.
/**
		if ( isset( $_SERVER['HTTP_RANGE']) )
		{
			if ( ! function_exists( 'download_416' ) )
				function download_416( $filesize )
				{
					header( 'HTTP/1.1 416 Requested Range Not Satisfiable' );
					header( 'Content-Range: bytes *\/' . $o->filesize); // Required in 416.		*\/ *\/ *\/
				}

			if (!preg_match( '^bytes=\d*-\d*(,\d*-\d*)*$', $_SERVER['HTTP_RANGE'])) {
			{
				download_416( $o->filesize );
				return;
			}

			$ranges = explode( ',', substr( $_SERVER['HTTP_RANGE'], 6) );
			foreach ( $ranges as $range )
			{
				$parts = explode( '-', $range);
				$start = $parts[0];		// If this is empty, this should be 0.
				$end = $parts[1];		// If this is empty or greater than than filelength - 1, this should be filelength - 1.

				if ( $start > $end)
				{
					download_416( $o->filesize );
					return;
				}
			}
		}
		else
**/
		{
			$size_to_send = $o->filesize;
		}
		$headers[] = 'Content-Length: ' . $size_to_send;

		foreach( $headers as $header )
			header( $header );

		$chunksize = 65536;
		$bytes_sent = 0;
		$file = fopen( $filepath, 'r' );
		if ( ! $file )
			throw new \Exception( "File $filepath could not be opened for reading!" );
/*
		if ( isset( $_SERVER['HTTP_RANGE'] ) )
			fseek( $file, $range );
**/
		while ( ! feof( $file ) && ( ! connection_aborted() ) && ( $bytes_sent < $size_to_send ) )
		{
			$buffer = fread( $file, $chunksize );
			echo ( $buffer );
			flush();
			$bytes_sent += strlen( $buffer );
		}
		fclose( $file );
	}

	/**
		@brief		Convenience function to call apply_filters.
		@details	Has same parameters as apply filters. Will insert a null if there are no arguments.
		@since		20130416
	**/
	public static function filters()
	{
		$args = func_get_args();

		if ( count( $args ) < 2 )
			$args[] = null;

		return call_user_func_array( 'apply_filters', $args );
	}

	/**
		@brief		Creates a new form.
		@param		array		$options	Default options to send to the form constructor.
		@return		object					A new \\plainview\\sdk\\wordpress\\form object.
		@since		20130416
	**/
	public function form( $options = array())
	{
		$options = array_merge( $options, array( 'language' => preg_replace( '/_.*/', '', get_locale())) );

		if ( ! class_exists( '\\plainview\\sdk\\wordpress\\form' ) )
			require_once( 'form.php' );

		return new \plainview\sdk\wordpress\form( $options );
	}

	/**
		@brief		Creates a form2 object.
		@return		\\plainview\\sdk\\form2\\form		A new form object.
		@since		20130509
	**/
	public function form2()
	{
		$form = new \plainview\sdk\wordpress\form2\form( $this );
		return $form;
	}

	/**
		@brief		An array of command line options that this subclass can handle via do_LONGOPTION().
		@return		array		Array of long options that this subclass handles.
		@see		do_cli()
		@since		20130505
	**/
	public function long_options()
	{
		return array();
	}

	/**
		@brief		Returns WP's current timestamp (corrected for UTC)
		@return		string		Current timestamp in MYSQL datetime format.
		@since		20130416
	**/
	public static function now()
	{
		return date( 'Y-m-d H:i:s', current_time( 'timestamp' ));
	}

	/**
		@brief		wpautop's a string, using sprintf to replace arguments.
		@param		string		$string		String to wpautop.
		@param		mixed		$args		Optional arguments to sprintf.
		@return		The wpautop'd sprintf string.
		@since		20130416
	**/
	public function p( $string, $args = '' )
	{
		$args = func_get_args();
		$s2 = @ call_user_func_array( 'sprintf', $args );
		if ( $s2 == '' )
			$s2 = $string;
		return wpautop( $s2 );
	}

	/**
		@brief		Translate and wpautop a string, using sprintf to replace arguments.
		@param		string		$string		String to translate and then wpautop.
		@param		mixed		$args		Optional arguments to sprintf.
		@return		The translated, wpautop'd string.
		@since		20130416
	**/
	public function p_( $string, $args = '' )
	{
		$args = func_get_args();
		return wpautop( call_user_func_array( array( &$this, '_' ), $args ) );
	}

	/**
		@brief		Return a list of files that are to be included when creating the .pot file.
		@return		array		List of files (including wildcards) that must be including when preparing the .pot file.
		@since		20130505
	**/
	public function pot_files()
	{
		return array();
	}

	/**
		@brief		Return a list of translation keywords used when creating the .pot file.
		@return		array		Array of translation keywords to use when creating the .pot file.
		@since		20130505
	**/
	public function pot_keywords()
	{
		return array();
	}

	/**
		@brief		Return a roles collection.
		@return		roles\collection		The collection of roles.
		@since		20131015
	**/
	public function roles()
	{
		$roles = new roles\collection;

		$role = new roles\subscriber;
		$roles->put( $role::$id, $role );

		$role = new roles\contributor;
		$roles->put( $role::$id, $role );

		$role = new roles\author;
		$roles->put( $role::$id, $role );

		$role = new roles\editor;
		$roles->put( $role::$id, $role );

		$role = new roles\administrator;
		$roles->put( $role::$id, $role );

		if ( function_exists( 'is_super_admin' ) )
		{
			$role = new roles\superadmin;
			$roles->put( $role::$id, $role );
		}

		return $roles;
	}

	/**
		@brief		Sends mail via SMTP.
		@param		array		$mail_data					Mail data.
		@since		20130416
	**/
	public function send_mail( $mail_data )
	{
		require_once ABSPATH . WPINC . '/class-phpmailer.php';
		$mail = new \PHPMailer();

		// Mandatory
		$from_email		= key( $mail_data[ 'from' ] );
		$from_name		= reset( $mail_data[ 'from' ] );
		$mail->From		= $from_email;
		$mail->FromName	= $from_name;
		$mail->Sender	= $from_email;
		$mail->Subject  = $mail_data[ 'subject' ];

		if ( isset( $mail_data[ 'to' ] ) )
			foreach( $mail_data[ 'to' ] as $email => $name )
			{
				if ( is_int( $email) )
					$email = $name;
				$mail->AddAddress( $email, $name );
			}

		if ( isset( $mail_data[ 'cc' ] ) )
			foreach( $mail_data[ 'cc' ] as $email => $name )
			{
				if ( is_int( $email) )
					$email = $name;
				$mail->AddCC( $email, $name );
			}

		if ( isset( $mail_data[ 'bcc' ] ) )
			foreach( $mail_data[ 'bcc' ] as $email => $name )
			{
				if ( is_int( $email) )
					$email = $name;
				$mail->AddBCC( $email, $name );
			}

		if ( isset( $mail_data[ 'body_html' ] ) )
			$mail->MsgHTML( $mail_data[ 'body_html' ] );

		if ( isset( $mail_data[ 'body' ] ) )
			$mail->Body = $mail_data[ 'body' ];

		if ( isset( $mail_data[ 'attachments' ] ) )
			foreach( $mail_data[ 'attachments' ] as $filepath => $filename )
			{
				$encoding = 'base64';
				$mime_type = self::mime_type ( $filepath );

				if ( is_numeric( $filepath ) )
					$mail->AddAttachment( $filename, '', $encoding, $mime_type );
				else
					$mail->AddAttachment( $attachment, $filepath, $encoding, $mime_type );
			}

		if ( isset( $mail_data[ 'reply_to' ] ) )
		{
			foreach( $mail_data[ 'reply_to' ] as $email => $name )
			{
				if ( is_int( $email) )
					$email = $name;
				$mail->AddReplyTo( $email, $name );
			}
		}

		// Seldom used settings...

		if ( isset( $mail_data[ 'wordwrap' ] ) )
			$mail->WordWrap = $mail_data[ 'wordwrap' ];

		if ( isset( $mail_data[ 'confirm_reading_to' ] ) )
			$mail->ConfirmReadingTo = true;

		if ( isset( $mail_data[ 'single_to' ] ) )
		{
			$mail->SingleTo = true;
			$mail->SMTPKeepAlive = true;
		}

		if ( isset( $mail_data[ 'SMTP' ] ) )									// SMTP? Or just plain old mail()
		{
			$mail->IsSMTP();
			$mail->Host	= $mail_data[ 'smtp_server' ];
			$mail->Port = $mail_data[ 'smtp_port' ];
		}
		else
			$mail->IsMail();

		if ( isset( $mail_data[ 'charset' ] ) )
			$mail->CharSet = $mail_data[ 'charset' ];
		else
			$mail->CharSet = 'UTF-8';

		if ( isset( $mail_data[ 'content_type' ] ) )
			$mail->ContentType  = $mail_data[ 'content_type' ];

		if ( isset( $mail_data[ 'encoding' ] ) )
			$mail->Encoding  = $mail_data[ 'encoding' ];

		// Done setting up.

		if ( !$mail->Send() )
			$r = $mail->ErrorInfo;
		else
			$r = true;

		$mail->SmtpClose();

		return $r;
	}

	/**
		@brief		Sanitizes (slugs) a string.
		@param		string		$string		String to sanitize.
		@return		string					Sanitized string.
		@since		20130416
	**/
	public static function slug( $string )
	{
		return sanitize_title( $string );
	}

	/**
		@brief		Sanitizes the name of a tab.

		@param		string		$string		String to sanitize.
		@return		string					Sanitized string.
		@since		20130416
	**/
	public static function tab_slug( $string )
	{
		return self::slug( $string );
	}

	/**
		@brief		Creates a new table.
		@return		object		A new \\plainview\\sdk\\wordpress\\table object.
		@since		20130416
	**/
	public function table()
	{
		$table = new \plainview\sdk\wordpress\table\table( $this );
		$table->css_class( 'widefat' );
		return $table;
	}

	/**
		@brief		Displays Wordpress tabs OR creates a tabs instance.
		@details	The \\tabs functionality was introduced 20130501.
		@param		array		$options		See options.
		@since		20130416
	**/
	public function tabs( $options = array() )
	{
		if ( count( $options ) == 0 )
		{
			$tabs = new \plainview\sdk\wordpress\tabs\tabs( $this );
			return $tabs;
		}

		$options = $this->merge_objects(array(
			'count' =>			array(),			// Optional array of a strings to display after each tab name. Think: page counts.
			'default' => null,						// Default tab index.
			'descriptions' =>	array(),			// Descriptions (link titles) for each tab
			'display' => true,						// Display the tabs or return them.
			'display_tab_name' => true,				// If display==true, display the tab name.
			'display_before_tab_name' => '<h2>',	// If display_tab_name==true, what to display before the tab name.
			'display_after_tab_name' => '</h2>',	// If display_tab_name==true, what to display after the tab name.
			'functions' =>	array(),				// Array of functions associated with each tab name.
			'get_key' =>	'tab',					// $_GET key to get the tab value from.
			'page_titles' =>	array(),			// Array of page titles associated with each tab.
			'tabs' =>			array(),			// Array of tab names
			'valid_get_keys' => array(),			// Display only these _GET keys.
		), $options);

		$get = $_GET;						// Work on a copy of the _GET.
		$get_key = $options->get_key;		// Convenience.

		// Is the default not set or set to something stupid? Fix it.
		if ( ! isset( $options->tabs[ $options->default ] ) )
			$options->default = key( $options->tabs );

		// Select the default tab if none is selected.
		if ( ! isset( $get[ $get_key ] ) )
			$get[ $get_key ] = $options->default;
		$selected = $get[ $get_key ];

		$options->valid_get_keys['page'] = 'page';

		$r = '';

		if ( count( $options->tabs ) > 1 )
		{
			$r .= '<ul class="subsubsub">';
			$original_link = $_SERVER['REQUEST_URI'];

			foreach( $get as $key => $value )
				if ( !in_array( $key, $options->valid_get_keys) )
					$original_link = remove_query_arg( $key, $original_link );

			$index = 0;
			foreach( $options->tabs as $tab_slug => $text )
			{
				// Make the link.
				// If we're already on that tab, just return the current url.
				if ( $get[ $get_key ]  == $tab_slug )
					$link = remove_query_arg( time() );
				else
				{
					if ( $tab_slug == $options->default )
						$link = remove_query_arg( $get_key, $original_link );
					else
						$link = add_query_arg( $get_key, $tab_slug, $original_link );
				}

				if ( isset( $options->count[ $tab_slug ] ) )
					$text .= ' <span class="count">( ' . $options->count[ $tab_slug ] . ' )</span>';

				$separator = ( $index+1 < count( $options->tabs) ? ' | ' : '' );

				$current = ( $tab_slug == $selected ? ' class="current"' : '' );

				if ( $current)
					$selected_index = $tab_slug;

				$title = '';
				if ( isset( $options->descriptions[ $tab_slug ] ) )
					$title = 'title="' . $options->descriptions[ $tab_slug ] . '"';

				$r .= '<li><a'.$current.' '. $title .' href="'.$link.'">'.$text.'</a>'.$separator.'</li>';
				$index++;
			}
			$r .= '</ul>';
		}

		if ( !isset( $selected_index) )
			$selected_index = $options->default;

		if ( $options->display)
		{
			ob_start();
			echo '<div class="wrap">';
			if ( $options->display_tab_name)
			{
				if ( isset( $options->page_titles[ $selected_index ] ) )
					$page_title = $options->page_titles[ $selected_index ];
				else
					$page_title = $options->tabs[ $selected_index ];

				echo $options->display_before_tab_name . $page_title . $options->display_after_tab_name;
			}
			echo $r;
			echo '<div style="clear: both"></div>';
			if ( isset( $options->functions[ $selected_index ] ) )
			{
				$functionName = $options->functions[ $selected_index ];
				if ( is_array( $functionName ) )
				{
					$functionName[0]->$functionName[1]();
				}
				else
					$this->$functionName();
			}
			echo '</div>';
			ob_end_flush();
		}
		else
			return $r;
	}

	/**
		@brief		Returns the current time(), corrected for UTC and DST.
		@return		int		Current, corrected timestamp.
		@since		20130416
	**/
	public static function time()
	{
		return current_time( 'timestamp' );
	}

	/**
		@brief		Displays a time difference as a human-readable string.
		@param		$current		"2010-04-12 15:19" or a UNIX timestamp.
		@param		$reference		An optional timestamp to base time difference on, if not now.
		@param		$wrap			Wrap the real time in a span with a title?
		@return						"28 minutes"
		@since		20130810
	**/
	public static function time_to_string( $current, $reference = null, $wrap = false )
	{
		if ( $current == '' )
			return '';
		if ( ! is_int( $current ) )
			$current = strtotime( $current );
		if ( $reference === null )
			$reference = current_time( 'timestamp' );
		$diff = human_time_diff( $current, $reference );
		if ( $wrap )
			$diff = '<span title="'.$current.'">' . $diff . '</span>';
		return $diff;
	}

	/**
		@brief		Outputs the text in Wordpress admin's panel format.
		@details	To remember the correct parameter order: wrap THIS in THIS.
		@param		string		$title		H2 title to display.
		@param		string		$text		Text to display.
		@return		HTML wrapped HTML.
		@since		20130416
	**/
	public static function wrap( $text, $title )
	{
		echo "<h2>$title</h2>
			<div class=\"wrap\">
				$text
			</div>
		";
	}

	/**
		@brief		Return a yes or no string.
		@param		bool		$bool		Boolean value to convert to a word.
		@return		string		"Yes" is $bool is true. "No" if false.
		@since		20130605
	**/
	public function yes_no( $bool )
	{
		return $bool ? $this->_( 'yes' ) : $this->_( 'no' );
	}
}

