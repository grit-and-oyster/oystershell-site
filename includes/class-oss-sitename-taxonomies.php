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
			'taxonomy_name' => 'oss_custom_alpha',
			'object_type' => 'oss_book',
			'oystershell_taxonomy_type' => 'alpha',
			'tax_label_singular' => 'Books A to Z',
			'tax_label_plural' => 'Books A to Z',
			'slug' => 'books-atoz',
			'description' => '',
			'display_post_class' => false,
			);

		$custom_tax[5] = array(
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

		$is_alpha = false;
		
		foreach ( $custom_tax as $ctax ) {
 			
 			$taxonomy_name = $ctax['taxonomy_name'];
 			$object_type = $ctax['object_type'];
 			$oystershell_taxonomy_type = $ctax['oystershell_taxonomy_type'];
 			$tax_label_singular = $ctax['tax_label_singular'];
 			$tax_label_plural = $ctax['tax_label_plural'];
 			$slug = $ctax['slug'];
 			$description = $ctax['description'];

			$tax_class->register_taxonomy( $taxonomy_name, $object_type, $oystershell_taxonomy_type, $tax_label_singular, $tax_label_plural, $slug, $description );
			
			if ( 'alpha' == $oystershell_taxonomy_type ) {
				$is_alpha = true;
			}

		}

		add_filter( 'post_class', array( $this, 'taxonomy_post_class' ) );

		if ( true == $is_alpha ) {

			 add_action( 'save_post',  array( $this, 'alphaindex_save_alpha' ) );
		}
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

	/**
	 * Saves the first letter of the post field as the term in the alpha taxonomy for the defined post type
	 */
	function alphaindex_save_alpha( $post_id ) {

		// Exclude autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		// Define post types with alpha taxonomies
		$post_types = array( 'oss_book', );

		// Check we are saving one of the defined post types
		if ( isset( $_POST['post_type'] ) && ( !in_array( $_POST['post_type'], $post_types ) ) )
			return;

		// Check permissions
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		$letter = '';

		switch ( $_POST['post_type'] ) {
			case 'oss_book':
				$taxonomy = 'books-atoz';
				$post_field = 'post_title';
				break;
			default:
				# code...
				break;
		}

		// Get the title of the post
		$title = strtolower( $_POST[$post_field] );
		
		// The next few lines remove A, An, or The from the start of the title
		$splitTitle = explode(" ", $title);
		$blacklist = array("an ","a ","the ");
		$splitTitle[0] = str_replace($blacklist,"",strtolower($splitTitle[0]));
		$title = implode(" ", $splitTitle);
		
		// Get the first letter of the title
		$letter = substr( $title, 0, 1 );
		
		// Set to 0-9 if it's a number
		if ( is_numeric( $letter ) ) {
			$letter = '0-9';
		}
		//set term as first letter of post title, lower case
		wp_set_post_terms( $post_id, $letter, $taxonomy );
	}

}