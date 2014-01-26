<?php
/**
 * Plugin Name: Flipboard Magazine Widget
 * Description: Add a Flipboard magazine widget (https://share.flipboard.com/) to your sidebar
 * Author Name: Tracy Rotton
 * Author URI: http://www.taupecat.com
 * Plugin URI: https://github.com/taupecat/flipboard-magazine-widget
 * License: MIT
 * Version: 1.0
 */


/**
 * Load required JavaScript
 */
function fmw_load_js() {
	wp_enqueue_script( 'fmw-js', '//d2jsycj2ly2vqh.cloudfront.net/web/buttons/js/flbuttons.min.js', array(), false, 'true' );
}
add_action( 'wp_enqueue_scripts', 'fmw_load_js' );


/**
 * Create Widget
 */
class Flipboard_Magazine_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress
	 */
	function __construct() {
		parent::__construct(
			'flipboard_magazine_widget', // Base Name
			__('Flipboard Magazine Widget', 'fmw' ), // Name
			array( 'description' => __( 'Add a Flipboard magazine widget into your sidebar.', 'fmw' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$magazine_url = esc_url( $instance['magazine_url'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo '<a data-flip-widget="mag" href="' . $magazine_url . '">' . __( 'View my Flipboard Magazine.', 'fmw' ) . '</a>';
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Flipboard Magazine Widget', 'fmw' );
		}

		$magazine_url = $instance['magazine_url'];
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'magazine_url' ); ?>"><?php _e( 'Magazine URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'magazine_url' ); ?>" name="<?php echo $this->get_field_name( 'magazine_url' ); ?>" type="url" value="<?php echo esc_attr( $magazine_url ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['magazine_url'] = ( ! empty( $new_instance['magazine_url'] ) ) ? strip_tags( esc_url( $new_instance['magazine_url'] ) ) : '';

		return $instance;
	}
}

/**
 * Function to reference new widget
 */
function fmw_widget_init() {
	register_widget( 'Flipboard_Magazine_Widget' );
}
add_action( 'widgets_init', 'fmw_widget_init' );
