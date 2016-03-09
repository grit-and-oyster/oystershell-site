<?php

/**
 * Adds custom taxonomies.
 *
 * This class defines and adds custom taxonomies.
 *
 * @since      1.0.0
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Metaboxes {

	/**
	 * 
	 */
	function register_admin_metaboxes() {

		$prefix = '_oss_';

		$this->add_demo_metaboxes( $prefix, array( 'oss_book', ) );
	}

	function add_demo_metaboxes( $prefix, $post_types ) {

		/**
		 * Demo metabox
		 */
		$cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Test Metabox', 'cmb2' ),
			'object_types'  => $post_types, // Post type
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$cmb_demo->add_field( array(
			'name'       => __( 'Test Text', 'cmb2' ),
			'desc'       => __( 'field description (optional)', 'cmb2' ),
			'id'         => $prefix . 'text',
			'type'       => 'text',
		) );

	}
}