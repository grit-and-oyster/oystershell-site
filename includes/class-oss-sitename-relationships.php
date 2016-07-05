<?php

/**
 * Adds relationships between posts
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

/**
 * Adds relationships between posts.
 *
 * This class defines and adds relationships between post types.
 *
 * @since      1.0.0
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Relationships {

	/**
	 * 
	 */
	function register_relationships() {

		// Pages -> Books
	    p2p_register_connection_type( array(
	        'name' => 'posts_to_books',
	        'from' => 'post',
	        'to' => 'oss_book',
	        'cardinality' => 'one-to-many',
	        'sortable' => 'any',

	        'title' => array(
				'from' => __( 'Books', 'plugin-text-domain' ),
				'to' => __( 'Posts', 'plugin-text-domain' )
				),

	        'admin_box' => array(
			    'show' => 'any',
			    'context' => 'advanced'
			    )

	    ) );

	}

}