<?php

/**
 * Adds custom taxonomies
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

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
class OSS_Sitename_Taxonomies {

	/**
	 * Registers the custom taxonomies with WordPress
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function define_taxonomies() {

		$custom_tax = array();

		$custom_tax[0] = array(
			'taxonomy_name' => 'oss_custom_categories',
			'object_type' => 'oss_book',
			'oystershell_taxonomy_type' => 'category',
			'tax_label_singular' => 'Custom Category',
			'tax_label_plural' => 'Custom Category',
			'slug' => 'custom-cats',
			'description' => '',
			'display_post_class' => true,
			);

		$custom_tax[1] = array(
			'taxonomy_name' => 'oss_custom_tags',
			'object_type' => array( 'post', 'oss_book' ),
			'oystershell_taxonomy_type' => 'tag',
			'tax_label_singular' => 'Custom Tag',
			'tax_label_plural' => 'Custom Tags',
			'slug' => 'custom-tags',
			'description' => '',
			'display_post_class' => false,
			);

		$custom_tax[2] = array(
			'taxonomy_name' => 'oss_custom_status',
			'object_type' => 'oss_book',
			'oystershell_taxonomy_type' => 'hidden',
			'tax_label_singular' => 'Custom Status',
			'tax_label_plural' => 'Custom Status',
			'slug' => '',
			'description' => '',
			'display_post_class' => false,
			);

		$custom_tax[3] = array(
			'taxonomy_name' => 'oss_custom_type',
			'object_type' => 'oss_book',
			'oystershell_taxonomy_type' => 'custom_metabox',
			'tax_label_singular' => 'Custom Type',
			'tax_label_plural' => 'Custom Types',
			'slug' => 'custom-type',
			'description' => '',
			'display_post_class' => true,
			);

		$custom_tax[4] = array(
			'taxonomy_name' => 'oss_custom_args',
			'object_type' => 'oss_book',
			'oystershell_taxonomy_type' => array(
				'label' => 'Custom Args',
				'public' => true,
	            'show_ui' => true,
	            'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud' => true,
				'show_in_quick_edit' => true,
				'meta_box_cb' => null,
				'show_admin_column' => true,
				'description' => '',
				'hierarchical' => true,
				'query_var' => true,
	            'rewrite' => array(
						'slug' => 'custom-args',
						'with_front' => true,
						'hierarchical' => true 
						),
			),
			'tax_label_singular' => null,
			'tax_label_plural' => null,
			'slug' => null,
			'description' => null,
			'display_post_class' => true,
			);

		return $custom_tax;
	}

	/**
	 * Registers the custom taxonomies with WordPress
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomies( $custom_tax ) {

		$tax_class = new OSC_Taxonomies();
		
		foreach ( $custom_tax as $ctax ) {
 			
 			$taxonomy_name = $ctax['taxonomy_name'];
 			$object_type = $ctax['object_type'];
 			$oystershell_taxonomy_type = $ctax['oystershell_taxonomy_type'];
 			$tax_label_singular = $ctax['tax_label_singular'];
 			$tax_label_plural = $ctax['tax_label_plural'];
 			$slug = $ctax['slug'];
 			$description = $ctax['description'];

			$tax_class->register_taxonomy( $taxonomy_name, $object_type, $oystershell_taxonomy_type, $tax_label_singular, $tax_label_plural, $slug, $description );
		}

		add_filter( 'post_class', array( $this, 'taxonomy_post_class' ) );

	}

	/**
	 * Adds terms from a custom taxonomy to post_class
	 */
	function taxonomy_post_class( $classes ) {
		global $post;

		$custom_tax = $this->define_taxonomies();

		foreach ( $custom_tax as $ctax ) {

			if ( true == $ctax['display_post_class'] ) {

				$taxonomy = $ctax['taxonomy_name'];

			    $terms = get_the_terms( (int) $post->ID, $taxonomy );
			    if( !empty( $terms ) ) {
			        foreach( (array) $terms as $order => $term ) {
			            if( !in_array( $term->slug, $classes ) ) {
			                $classes[] = $term->slug;
			            }
			        }
			    }
			}
		}
	    return $classes;

	} // end taxonomy_post_class

}