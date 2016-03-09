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
class OSS_Sitename_Taxonomies {

	/**
	 * Registers the custom taxonomies with WordPress
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function define_taxonomies() {

		// Define the custom taxonomies in an array
		$custom_tax = array(
				0 => array(
					'tax_name' => 'oss_custom',
					'tax_label_singular' => 'Custom Tag',
					'tax_label_plural' => 'Custom Tags',
					// Hierarchical taxonomy (like categories)
					'tax_harch' => false,
					'tax_slug' => 'custom',
					// Display the category base in URLs
					'display_tax_base' => true,
					// Allow hierarchical URLs
					'display_tax_hrach' => false,
					// Display terms in post class
					'display_post_class' => false,
					// Object type (post, pages, custom post types)
					'object' => 'post',
					),
				1 => array(
					'tax_name' => 'oss_custom_post',
					'tax_label_singular' => 'Custom Post Tag',
					'tax_label_plural' => 'Custom Post Tags',
					// Hierarchical taxonomy (like categories)
					'tax_harch' => false,
					'tax_slug' => 'custom-post',
					// Display the category base in URLs
					'display_tax_base' => true,
					// Allow hierarchical URLs
					'display_tax_hrach' => false,
					// Display terms in post class
					'display_post_class' => true,
					// Object type (post, pages, custom post types)
					'object' => 'oss_book',
					),
				);

		return $custom_tax;
	}

	/**
	 * Defines the labels for a custom taxonomy.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function define_labels( $ctax ) {

		$labels = array(

				'name' => _x( $ctax['tax_label_plural'], 'taxonomy general name' ),
				'singular_name' => _x( $ctax['tax_label_singular'], 'taxonomy singular name' ),
				'search_items' =>  __( 'Search '.$ctax['tax_label_plural'] ),
				'all_items' => __( 'All '.$ctax['tax_label_plural'] ),
				'parent_item' => __( 'Parent '.$ctax['tax_label_singular'] ),
				'parent_item_colon' => __( 'Parent '.$ctax['tax_label_singular'].':' ),
				'edit_item' => __( 'Edit '.$ctax['tax_label_singular'] ),
				'update_item' => __( 'Update '.$ctax['tax_label_singular'] ),
				'add_new_item' => __( 'Add New '.$ctax['tax_label_singular'] ),
				'new_item_name' => __( 'New '.$ctax['tax_label_singular'] ),
				'menu_name' => __( $ctax['tax_label_plural'] )
		); 

		return $labels;
	}

	/**
	 * Registers the custom taxonomies with WordPress
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomies( $custom_tax ) {

		foreach ( $custom_tax as $key => $ctax) {

			$labels = $this->define_labels( $ctax );

			$args = array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => $ctax['tax_harch'],
				// The labels displayed in the WordPress Admin UI			
				'labels' => $labels,
				// Control the slugs used for this taxonomy
				'rewrite' => array(
					'slug' => $ctax['tax_slug'], // This controls the base slug that will display before each term
					'with_front' => $ctax['display_tax_base'], // Display the category base before "/locations/"
					'hierarchical' => $ctax['display_tax_hrach'] // This will allow URL's like "/locations/boston/cambridge/"
				)
			  );
			register_taxonomy($ctax['tax_name'], null, $args );
			register_taxonomy_for_object_type( $ctax['tax_name'], $ctax['object'] );
			add_filter( 'post_class', array( $this, 'taxonomy_post_class' ) );
		}
	}

	/**
	 * Adds terms from a custom taxonomy to post_class
	 */
	function taxonomy_post_class( $classes ) {
		global $post;

		$custom_tax = $this->define_taxonomies();

		foreach ( $custom_tax as $key => $ctax ) {

			if ( true == $ctax['display_post_class'] ) {

				$taxonomy = $ctax['tax_name'];

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