<?php

/**
 * Adds custom widgets
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 */

/**
 * Adds example custom widget.
 *
 * This class defines an example custom widgets.
 *
 * @since      1.0.0
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/includes
 * @author     Grit & Oyster <code@grit-oyster.co.uk>
 */
class OSS_Sitename_Widgets_ExampleWidget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	function __construct() {
		// Instantiate the parent object
		parent::__construct(
			// Base ID of your widget
			'sitename_examplewidget', 

			// Widget name will appear in UI
			__( 'Sitename Widget', 'plugin-text-domain' ), 

			// Widget description
			array( 'description' => __( 'An example custom widget', 'plugin-text-domain' ), ) 
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
	
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$output = $this->get_output( $instance );
		echo $output;

		echo $args['after_widget'];

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'plugin-text-domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Gets the output string for the widget
	 *
	 * @param array $instance The widget options
	 */
	public function get_output( $instance ) {

		$output = '';

		$output = $output . __( esc_attr( 'Hello, World!' ), 'plugin-text-domain' );

		return $output;
	}
}