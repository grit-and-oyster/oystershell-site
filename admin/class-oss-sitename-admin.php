<?php

/**
 * The file that contains admin-specific functionality of the plugin
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/admin
 */

/**
 * The class that defines admin-specific functionality of the plugin.
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
	 * @since 	1.0.0
	 * @param   string    $plugin_name       The name of this plugin.
	 * @param   string    $version    The version of this plugin.
	 * @param 	string    $prefix    The field name prefix for this plugin.
	 */
	public function __construct( $plugin_name, $version, $prefix ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->prefix = $prefix;

	}

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Options screen tabs.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $tabs = array( 'general' );

	/**
	 * Register the administration menu for this plugin into the WordPress settings menu.
	 *
	 * Hooked to 'admin_menu' action.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * Hooked to 'admin_menu' action.
		 *
		 */
	    $page_title = __( 'Site Specific Settings', 'plugin-text-domain' );
	    $menu_title = __( 'Site Specific', 'plugin-text-domain' );
	    $capability = 'manage_options';
	    $menu_slug = $this->plugin_name;
	    $function = array( $this, 'display_plugin_admin_page' );

		$this->plugin_screen_hook_suffix = add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );

		/*
		 * Alternative: Add a page for this plugin to the main Admin menu.
		 *
		 */
	    // $icon_url = '';
	    // $position = 40;

		// $this->plugin_screen_hook_suffix = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Include CMB CSS in the head
		add_action( "admin_print_styles-{$this->plugin_screen_hook_suffix}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * Hooked to 'plugin_action_links_[plugin-name]' filter.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', 'plugin-text-domain' ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Set up plugin settings.
	 *
	 * Hooked to 'admin_init' action.
	 *
	 * @since    1.0.0
	 */
	public function initialize_plugin_options() {

		foreach ($this->tabs as $tab) {

			$key = $this->prefix . 'options_' . $tab;
			register_setting( $key, $key );
		}
	}

	/**
	 * Register custom metaboxes with WordPress.
	 *
	 * Hooked to 'cmb2_admin_init' action.
	 *
	 * @since    1.0.0
	 */
	public function register_metaboxes() {

		$metaboxes = new OSS_Sitename_Metaboxes( $this->prefix );
		$metaboxes->register_admin_metaboxes();

		//Add additional notices for CMB2 metaboxes
		$this->hook_save_notices();		
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		if ( !current_user_can( 'manage_options' ) )  { 
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'plugin-text-domain' ) );
		}

		$this->admin_switch();
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
			case 'general':
				$this->do_action_default( $action );
			break;	
			default:
				$this->do_action_default( 'general' );
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

		$key = $this->prefix . 'options_' . $action;
		$metabox_id = $key . '_metaboxes';

		include_once( 'partials/oss-sitename-admin-display.php' );
	}

	/*------------------------------------------------------------------------
	DISPLAY FUNCTIONS */

	/**
	 * Display tabs.
	 *
	 * @since    1.0.0
	 */
	public function display_tabs( $action ) {

		if ($action == '') {
			$action = 'general';
		}

		$output = '<h2 class="nav-tab-wrapper">';

		foreach ($this->tabs as $tab) {

			$link = admin_url( 'options-general.php?page=' . $this->plugin_name . '&action=' . $tab );
			$active = '';
			if ($action == $tab) {
				$active = 'nav-tab-active';
			}
			$output = $output . '<a href="' . $link . '" class="nav-tab ' . $active . '">' . __( ucfirst($tab), 'plugin-text-domain' ) . '</a>';
		}

		$output = $output . '</h2>';

		echo $output;
	}

	/**
	 * Hook in our save notices for options pages
	 *
	 * @since    1.0.0
	 */
	public function hook_save_notices() {
	
		foreach ($this->tabs as $tab) {

			$key = $this->prefix . 'options_' . $tab;
			$metabox_id = $key . '_metaboxes';
			add_action( "cmb2_save_options-page_fields_{$metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
		}
	}

	/**
	 * Register settings notices for display
	 *
	 * @since  0.1.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
	
		foreach ($this->tabs as $tab) {

			$key = $this->prefix . 'options_' . $tab;

			if ( $object_id !== $key || empty( $updated ) ) {
				// do nothing

			} else {
				add_settings_error( $key . '-notices', '', __( 'Settings updated.', 'plugin-text-domain' ), 'updated' );
				settings_errors( $key . '-notices' );				
			}
		}
	}

	/*------------------------------------------------------------------------
	MAKE LIST TABLE COLUMNS SORTABLE */

	/**
	* Defines which ldhg_events columns are sortable
	*
	* @param array $columns Existing sortable columns
	* @return array New sortable columns
	*/
	function book_cpt_define_sortable_table_columns( $columns ) {
	 
		$columns['_sitename_book_date'] = 'book_date';
	     
	    return $columns; 
	}

	/**
	* Inspect the request to see if we are on the ldhg_event WP_List_Table and attempting to
	* sort by historical date.  If so, amend the Posts query to sort by
	* that custom meta key
	*
	* @param array $vars Request Variables
	* @return array New Request Variables
	*/
	function orderby_sortable_table_columns( $vars ) {
	 
	    // Don't do anything if we are not on the Contact Custom Post Type
		if ( ! isset( $vars['post_type'] ) )  return $vars;
    	if ( 'oss_book' != $vars['post_type'] ) return $vars;
     
	    // Don't do anything if no orderby parameter is set
	    if ( ! isset( $vars['orderby'] ) ) return $vars;
	     
	    // Check if the orderby parameter matches one of our sortable columns
        switch ( $vars['orderby'] ) {
	    	case 'book_date':
		        // Add orderby meta_value and meta_key parameters to the query
		        $vars = array_merge( $vars, array(
		            'meta_key' => '_sitename_book_date',
		            'orderby' => 'meta_value_num',
		        ));
		  		break;
	    	default:
	    		return $vars; 
	    		break;
	    }
	     
	    return $vars; 
	}

	/*------------------------------------------------------------------------
	ENQUEUE STYLES AND SCRIPTS */

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}
}