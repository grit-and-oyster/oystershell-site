<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/public
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Public {

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
	 * The field name prefix for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $prefix    The field name prefix for this plugin.
	 */
	private $prefix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $prefix ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->prefix = $prefix;

	}

	/**
	 * Register custom post types with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types() {

		$cpt = new OSS_Sitename_Cpt_Name();
		$cpt->create( $cpt->name(), $cpt->labels(), $cpt->config());
	}

	/**
	 * Register custom taxonomies with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomies() {

		$taxonomies = new OSS_Sitename_Taxonomies();
		$taxonomies->register_taxonomies( $taxonomies->define_taxonomies() );
	}

	/**
	 * Check that Posts2Posts plugin is active.
	 *
	 * @since    1.0.0
	 */
	public function check_for_p2p_plugin() {

		$active = true;
		if( !function_exists( '_p2p_init' ) ) {
			 if ( current_user_can( 'activate_plugins' ) ) {
				add_action( 'admin_notices', array( $this, 'p2p_plugin_admin_notice' ) );
			}
			$active = false;
		}

		define( 'OSS_P2P_ACTIVE', $active );
	}

	/**
	 * Error notice if Posts2Posts plugin is not active.
	 *
	 * @since    1.0.0
	 */
	public function p2p_plugin_admin_notice() {

		$class = 'notice notice-warning';
		$message = __( 'Relationships between posts have not been registered as the Posts 2 Posts plugin is not active.', 'plugin-text-domain' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 

	}

	/**
	 * Register post to post relationships with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_relationships() {

		if ( true == OSS_P2P_ACTIVE ) {

			$relationships = new OSS_Sitename_Relationships();
			$relationships->register_relationships();
		}
	}

	/**
	 * Register custom metaboxes with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_metaboxes() {

		$metaboxes = new OSS_Sitename_Metaboxes( $this->prefix );
		$metaboxes->register_public_metaboxes();
	}

	/**
	 * Register custom widgets with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function register_widgets() {

		register_widget( 'OSS_Sitename_Widgets_ExampleWidget' );

	}

	/**
	 * Register shortcodes with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function create_shortcodes() {

		//add_shortcode( $args ) );

	}

	/**
	 * Register page template specific actions to available hooks
	 *
	 * @since    1.0.0
	 */
	public function init_page_templates() {

		if ( is_page_template('page-[template].php') ) {

			//add_action( 'wp_enqueue_scripts', 'page_template_function' );

		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/oss-sitename-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/oss-sitename-public.js', array( 'jquery' ), $this->version, false );

	}

}