<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Oss_Sitename_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The prefix for field names to be used throughout the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prefix    The prefix for field names to be used throughout the plugin.
	 */
	protected $prefix;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'oss-sitename';
		$this->version = '1.0.0';
		$this->prefix = '_sitename_';

		$this->load_dependencies();
		$this->load_libraries();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Oss_Sitename_Loader. Orchestrates the hooks of the plugin.
	 * - Oss_Sitename_i18n. Defines internationalization functionality.
	 * - Oss_Sitename_Admin. Defines all hooks for the admin area.
	 * - Oss_Sitename_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-i18n.php';

		/**
		 * The class responsible for defining a custom post type
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-cpt-name.php';

		/**
		 * The class responsible for defining custom taxonomies
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-taxonomies.php';

		/**
		 * The class responsible for defining custom metaboxes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-metaboxes.php';

		/**
		 * The class responsible for defining post relationships
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-oss-sitename-relationships.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-oss-sitename-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-oss-sitename-public.php';

		$this->loader = new OSS_Sitename_Loader();

	}

	/**
	 * Load the required Oystershell Core libraries for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_libraries() {

		/**
		 * Load the CMB2 library
		 * CMB2 is a developer's toolkit for building metaboxes, custom fields, and forms for WordPress.
		 */
		add_action( 'plugins_loaded', 'osc_load_library_cmb2', 0 );

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Oss_Sitename_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new OSS_Sitename_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );		

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new OSS_Sitename_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_prefix() );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Initialize the settings options.
		$this->loader->add_action( 'admin_init', $plugin_admin, 'initialize_plugin_options' );

		// Register custom metaboxes used in the admin.
		$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'register_metaboxes' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new OSS_Sitename_Public( $this->get_plugin_name(), $this->get_version(), $this->get_prefix() );

		// Register custom post types.
		$this->loader->add_action( 'init', $plugin_public, 'register_post_types' );

		// Register custom taxonomies.
		$this->loader->add_action( 'init', $plugin_public, 'register_taxonomies' );

		// Register post relationships.
		$this->loader->add_action( 'plugins_loaded', $plugin_public, 'check_for_p2p_plugin' );
		$this->loader->add_action( 'p2p_init', $plugin_public, 'register_relationships' );

		// Register public facing custom metaboxes.
		$this->loader->add_action( 'cmb2_init', $plugin_public, 'register_metaboxes' );

		// Register shortcodes.
		$this->loader->add_action( 'init', $plugin_public, 'create_shortcodes' );

		// Define theme template specific hooks.
		$this->loader->add_action( 'wp', $plugin_public, 'init_page_templates' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Oss_Sitename_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the prefix for field names.
	 *
	 * @since     1.0.0
	 * @return    string    The prefix for field names.
	 */
	public function get_prefix() {
		return $this->prefix;
	}

}
