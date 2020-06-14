<?php
/**
 * Extend WordPress' "WP_Widget" class for our Flipboard Magazine Widget.
 *
 * @package Flipboard Magazine Widget
 */

namespace taupecat;

/**
 * Create Widget
 */
class Flipboard_Magazine_Widget extends \WP_Widget {

	/**
	 * Register widget with WordPress
	 */
	public function __construct() {

		parent::__construct(
			'flipboard_magazine_widget',
			__( 'Flipboard Magazine Widget', 'fmw' ),
			array(
				'description' => __( 'Add a Flipboard magazine widget into your sidebar.', 'fmw' ),
			)
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

		$title        = apply_filters( 'widget_title', $instance['title'] );
		$magazine_url = esc_url( $instance['magazine_url'] );
		$output       = '';

		$output .= $args['before_widget'];

		if ( ! empty( $title ) ) {

			$output .= $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$output = wp_kses_post(
			sprintf(
				'<a data-flip-widget="mag" href="%1$s">%2$s</a>',
				$magazine_url,
				esc_html__( 'View my Flipboard Magazine.', 'fmw' )
			)
		);

		$output .= $args['after_widget'];

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {

			$title = $instance['title'];

		} else {

			$title = __( 'Flipboard Magazine Widget', 'fmw' );
		}

		$magazine_url = $instance['magazine_url'];
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'fmw' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'magazine_url' ) ); ?>"><?php esc_html_e( 'Magazine URL:', 'fmw' ); ?></label>
			<input class="widefat" id="<?php echo esc_url( $this->get_field_id( 'magazine_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'magazine_url' ) ); ?>" type="url" value="<?php echo esc_attr( $magazine_url ); ?>">
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

		// Initialize the returning instance array.
		$instance                 = array();
		$instance['title']        = '';
		$instance['magazine_url'] = '';

		// Update the title.
		if ( ! empty( $new_instance['title'] ) ) {

			$instance['title'] = strip_tags( $new_instance['title'] );
		}

		// Update the magazine URL.
		if ( ! empty( $new_instance['magazine_url'] ) ) {

			$instance['magazine_url'] = strip_tags( esc_url( $new_instance['magazine_url'] ) );
		}

		return $instance;
	}
}
