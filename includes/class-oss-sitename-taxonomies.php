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
					'tax_name' => 'oss_custom_tags',
					'tax_label_singular' => 'Custom Tag',
					'tax_label_plural' => 'Custom Tags',
					// Hierarchical taxonomy (like categories)
					'tax_harch' => false,
					// Private taxonomy (for internal use only)
					'private' => false,
					//These apply when 'private' = false:
						//Whether to generate a default UI for managing this taxonomy
						'show_ui' => true,
						//These apply when 'show_ui' = true:
 							//Whether to show the taxonomy in the admin menu.
							'show_in_menu' => true,
							//available for selection in navigation menus
							'show_in_nav_menus' => true,
							//Whether to allow the Tag Cloud widget to use this taxonomy
							'show_tagcloud' => true,
							//Whether to show the taxonomy in the quick/bulk edit panel.
							'show_in_quick_edit' => true,
						'tax_slug' => 'custom-tags',
						// Display the category base in URLs
						'display_tax_base' => true,
						// Allow hierarchical URLs
						'display_tax_hrach' => false,
						// Display terms in post class
					//Whether to allow automatic creation of taxonomy columns on associated post-types table.
					'show_admin_column' => false,
					// Whether to add terms from the custom taxonomy to post_class
					'display_post_class' => false,
					// Object type (post, pages, custom post types)
					'object' => 'post',
					),
				1 => array(
					'tax_name' => 'oss_custom_categories',
					'tax_label_singular' => 'Custom Category',
					'tax_label_plural' => 'Custom Category',
					// Hierarchical taxonomy (like categories)
					'tax_harch' => true,
					// Private taxonomy (for internal use only)
					'private' => false,
					//These apply when 'private' = false:
						//Whether to generate a default UI for managing this taxonomy
						'show_ui' => true,
						//These apply when 'show_ui' = true:
 							//Whether to show the taxonomy in the admin menu.
							'show_in_menu' => true,
							//available for selection in navigation menus
							'show_in_nav_menus' => true,
							//Whether to allow the Tag Cloud widget to use this taxonomy
							'show_tagcloud' => false,
							//Whether to show the taxonomy in the quick/bulk edit panel.
							'show_in_quick_edit' => true,
						'tax_slug' => 'custom-cats',
						// Display the category base in URLs
						'display_tax_base' => true,
						// Allow hierarchical URLs
						'display_tax_hrach' => true,
						// Display terms in post class
					//Whether to allow automatic creation of taxonomy columns on associated post-types table.
					'show_admin_column' => false,
					// Whether to add terms from the custom taxonomy to post_class
					'display_post_class' => false,
					// Object type (post, pages, custom post types)
					'object' => 'post',
					),
				2 => array(
					'tax_name' => 'oss_custom_status',
					'tax_label_singular' => 'Custom Status',
					'tax_label_plural' => 'Custom Status',
					// Hierarchical taxonomy (like categories)
					'tax_harch' => true,
					// Private taxonomy (for internal use only)
					'private' => true,
					//These apply when 'private' = false:
						//Whether to generate a default UI for managing this taxonomy
						'show_ui' => null,
						//These apply when 'show_ui' = true:
 							//Whether to show the taxonomy in the admin menu.
							'show_in_menu' => null,
							//available for selection in navigation menus
							'show_in_nav_menus' => null,
							//Whether to allow the Tag Cloud widget to use this taxonomy
							'show_tagcloud' => null,
							//Whether to show the taxonomy in the quick/bulk edit panel.
							'show_in_quick_edit' => null,
						'tax_slug' => null,
						// Display the category base in URLs
						'display_tax_base' => null,
						// Allow hierarchical URLs
						'display_tax_hrach' => null,
						// Display terms in post class
					//Whether to allow automatic creation of taxonomy columns on associated post-types table.
					'show_admin_column' => true,
					// Whether to add terms from the custom taxonomy to post_class
					'display_post_class' => true,
					// Object type (post, pages, custom post types)
					'object' => 'post',
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

		if ( true == $ctax['tax_harch'] ) {

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

		} else {

			$labels = array(

					'name' => _x( $ctax['tax_label_plural'], 'taxonomy general name' ),
					'singular_name' => _x( $ctax['tax_label_singular'], 'taxonomy singular name' ),
					'search_items' =>  __( 'Search '.$ctax['tax_label_plural'] ),
					'all_items' => __( 'All '.$ctax['tax_label_plural'] ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item' => __( 'Edit '.$ctax['tax_label_singular'] ),
					'update_item' => __( 'Update '.$ctax['tax_label_singular'] ),
					'add_new_item' => __( 'Add New '.$ctax['tax_label_singular'] ),
					'new_item_name' => __( 'New '.$ctax['tax_label_singular'] ),
					'separate_items_with_commas' => __( 'Separate '. strtolower($ctax['tax_label_plural']) . ' with commas' ),
					'add_or_remove_items'        => __( 'Add or remove ' . strtolower($ctax['tax_label_plural']) ),
					'choose_from_most_used'      => __( 'Choose from the most used ' . strtolower($ctax['tax_label_plural']) ),
					'not_found'                  => __( 'No '. strtolower($ctax['tax_label_plural']) . ' found.' ),
					'menu_name' => __( $ctax['tax_label_plural'] )
			);

		} 

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

			if ( true == $ctax['tax_harch'] ) {
				$update_count_callback = '';
			} else {
				$update_count_callback = '_update_post_term_count';
			}

			if ( true == $ctax['private'] ) {
				$public = false;
            	$rewrite = false;
			} else {
				$public = true;
				$rewrite = array(
					'slug' => $ctax['tax_slug'], // This controls the base slug that will display before each term
					'with_front' => $ctax['display_tax_base'], // Display the category base before "/locations/"
					'hierarchical' => $ctax['display_tax_hrach'] // This will allow URL's like "/locations/boston/cambridge/"
					);
			}

			$args = array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => $ctax['tax_harch'],
				// The labels displayed in the WordPress Admin UI			
				'labels' => $labels,
	            'public' => $public,
	            'show_ui' => $ctax['show_ui'],
	            'rewrite' => $rewrite,
				'show_in_menu' => $ctax['show_in_menu'],
				'show_in_nav_menus' => $ctax['show_in_nav_menus'],
				'show_tagcloud' => $ctax['show_tagcloud'],
				'show_in_quick_edit' => $ctax['show_in_quick_edit'],
				'show_admin_column' => $ctax['show_admin_column'],
				'update_count_callback' => $update_count_callback,
			  );

			register_taxonomy($ctax['tax_name'], null, $args );
			if (is_array( $ctax['object'] )) {
				foreach ( $ctax['object'] as $object ) {
					register_taxonomy_for_object_type( $ctax['tax_name'], $object );
				}
			} else {
				register_taxonomy_for_object_type( $ctax['tax_name'], $ctax['object'] );
			}
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