<?php

/**
 * Adds custom metaboxes
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

/**
 * Adds custom metaboxes.
 *
 * This class defines and adds custom metaboxes using the CMB2 library.
 *
 * @since      1.0.0
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Metaboxes {

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
	 * @param 	string    $prefix    The field name prefix for this plugin.
	 */
	public function __construct( $prefix ) {

		$this->prefix = $prefix;

	}

	/**
	 * Register metaboxes for the WordPress admin.
	 *
	 * @since 	1.0.0
	 */
	function register_admin_metaboxes() {

		$this->add_cpt_metaboxes( $this->prefix, array( 'oss_book', ) );

		$this->add_options_general_metaboxes( $this->prefix );

		$this->add_user_metaboxes( $this->prefix, array( 'user', ) );
	}

	/**
	 * Register metaboxes for the front end.
	 *
	 * @since 	1.0.0
	 */
	function register_public_metaboxes() {

	}

	/**
	 * Specify the demonstration metaboxes.
	 *
	 * @since 	1.0.0
	 * @param 	string    $prefix    The field name prefix for this plugin.
	 * @param 	array    $post_types   The post types that use these metaboxes.
	 */
	function add_cpt_metaboxes( $prefix, $post_types ) {

		$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Test Metabox', 'plugin-text-domain' ),
			'object_types'  => $post_types, // Post type
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$cmb->add_field( array(
			'name'       => __( 'Test Text', 'plugin-text-domain' ),
			'desc'       => __( 'field description (optional)', 'plugin-text-domain' ),
			'id'         => $prefix . 'text',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
		    'name'     => __( 'Status', 'plugin-text-domain' ),
		    //'desc'     => 'Description Goes Here',
		    'id'       => $prefix . 'custom_status',
		    'taxonomy' => 'oss_custom_status', //Enter Taxonomy Slug
		    'type'     => 'taxonomy_select',
		) );

		$cmb->add_field( array(
		    'name'     => __( 'Type', 'plugin-text-domain' ),
		    //'desc'     => 'Description Goes Here',
		    'id'       => $prefix . 'custom_type',
		    'taxonomy' => 'oss_custom_type', //Enter Taxonomy Slug
		    'type'     => 'taxonomy_select',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Date', 'plugin-text-domain' ),
			//'desc'       => __( 'field description (optional)', 'plugin-text-domain' ),
			'id'         => $prefix . 'book_date',
			'type'       => 'text_date_timestamp',
		    'column' => array(
		        'position' => 2,
		        'name'     => 'Book Date',
		    ),
			'date_format' => 'd/m/Y',
		) );
	}

	/**
	 * Specify the metaboxes for the General tab on the settings page.
	 *
	 * @since 	1.0.0
	 * @param 	string    $prefix    The field name prefix for this plugin.
	 */
	function add_options_general_metaboxes( $prefix ) {

		$key =  $prefix . 'options_general';

		$cmb = new_cmb2_box( array(
			'id'         => $key . '_metaboxes',
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $key, )
			),
		) );

		$cmb->add_field( array(
				'name'     => __( 'General Settings', 'plugin-text-domain' ),
				//'desc' => __( 'field description (optional)', 'myprefix' ),
				'id'       => $prefix . '_title',
				'type'     => 'title',
			) );

		$cmb->add_field( array(
			'name'       => __( 'Test Text', 'plugin-text-domain' ),
			'desc'       => __( 'field description (optional)', 'plugin-text-domain' ),
			'id'         => 'test_text',
			'type'       => 'text',
		) );

	}

	/**
	 * Specify the metaboxes for users.
	 *
	 * @since 	1.0.0
	 * @param 	string    $prefix    The field name prefix for this plugin.
	 * @param 	array    $post_types   The post types (should be 'user') that use these metaboxes.
	 */
	function add_user_metaboxes( $prefix, $post_types ) {

		$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'user_metabox',
			'title'         => __( 'User Metabox', 'plugin-text-domain' ),
			'object_types'  => $post_types, // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
		) );

		$cmb->add_field( array(
			'name'     => __( 'User Settings', 'plugin-text-domain' ),
			'id'       => $prefix . 'settings',
			'type'     => 'title',
			'on_front' => false,
	        'show_on_cb' => 'osc_cmb_only_show_on_admin_user_profile', // function should return a bool value
		) );

		$cmb->add_field( array(
			'name'       => __( 'Test Text', 'plugin-text-domain' ),
			'desc'       => __( 'field description (optional)', 'plugin-text-domain' ),
			'id'         => 'test_text',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Test Text 2', 'plugin-text-domain' ),
			'desc'       => __( 'field description (optional)', 'plugin-text-domain' ),
			'id'         => 'test_text_2',
			'type'       => 'text',
			'show_on_cb' => 'osc_cmb_only_show_on_admin_user_profile', // function should return a bool value
		) );

		$cmb->add_field( array(
		    'name'       => __( 'Test Display Name', 'plugin-text-domain' ),
		    'desc'       => __( 'Display name publicly as', 'plugin-text-domain' ),
		    'id'         => 'display_name',
		    'type'       => 'select',
		    'default'    => 'custom',
		    'options_cb' => 'osc_cmb_show_user_display_name_options',
			'show_on_cb' => 'osc_cmb_only_show_on_admin_user_profile', // function should return a bool value
		) );
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
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}
		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'plugin-text-domain' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}
}