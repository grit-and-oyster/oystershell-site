<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/admin
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oss_Sitename_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oss_Sitename_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/oss-sitename-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oss_Sitename_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oss_Sitename_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/oss-sitename-admin.js', array( 'jquery' ), $this->version, false );

	}

	/*------------------------------------------------------------------------
	SITE SPECIFIC OPTIONS SCREEN */

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 */

	    $page_title = __( 'Site Specific Settings', $this->plugin_name );
	    $menu_title = __( 'Site Specific', $this->plugin_name );
	    $capability = 'manage_options';
	    $menu_slug = $this->plugin_name;
	    $function = array( $this, 'display_plugin_admin_page' );

		$this->plugin_screen_hook_suffix = add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		if ( !current_user_can( 'manage_options' ) )  { 
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$this->admin_switch();
	}

	/**
	 * Register custom metaboxes with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_metaboxes() {

		$metaboxes = new OSS_Sitename_Metaboxes();
		$metaboxes->register_admin_metaboxes();
	}

	/*------------------------------------------------------------------------
	SWITCH */

	/**
	 * Main process switch.
	 *
	 * @since    1.0.0
	 */
	public function admin_switch() {

		$action = '';

		if(isset($_GET["action"]))
			$action = $_GET["action"];

		if(isset($_POST["action"]))
			$action = $_POST["action"];

		switch($action) {
			case 'generic':
				$this->do_action_default( $action );
			break;	
			default:
				$this->do_action_default( $action );
			break;	
		}
	}

	/*------------------------------------------------------------------------
	DEFAULT */

	/**
	 * Display the default page.
	 *
	 * @since    1.0.0
	 */
	public function do_action_default( $action ) {

		include_once( 'partials/oss-sitename-admin-display.php' );
	}

}