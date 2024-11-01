<?php

class SpontanioWidget extends \WP_Widget
{
	const DEFAULT_BUTTON_NAME = 'Video Chat';
	const DEFAULT_POSITION = 'spontanio-center-middle';

	/**
	 * SpontanioWidget constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			'SpontanioWidget',
			'Video Chat',
			array( 'description' => 'Shows Video Chat on your website' )
		);
		add_action( 'widgets_init', array( $this, 'registerSpontanioWidget' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueStyles' ) );
	}

	/**
	 * Registers Spontanio widget.
	 */
	public function registerSpontanioWidget()
	{
		register_widget( $this );
	}

	/**
	 * {@inheritdoc}
	 */
	public function widget( $args, $instance )
	{
		$buttonName = isset( $instance['button-name'] ) ? $instance['button-name'] : self::DEFAULT_BUTTON_NAME;

		$options = get_option( SpontanioAdmin::OPTION_NAME );
		$roomName = ( isset( $instance['room-name'] ) && ! empty ( $instance['room-name'] ) && SpontanioAdmin::isValidRoomName( $instance['room-name'] ) )
			? SpontanioAdmin::convertToUriRoomName( $instance['room-name'] ) : $options[SpontanioAdmin::URI_ROOM_NAME];

		$height = '100%';
		if ( isset ($instance['height-units'] ) && isset( $instance['height']) ) {
			if ((($instance['height-units'] == 'px') && (( int )$instance['height'] >= 300))
				|| (($instance['height-units'] == '%') && (( int )$instance['height'] <= 100))) {
				$height = $instance['height'] . $instance['height-units'];
			}
		}

		$width = '100%';
		if ( isset ($instance['width-units'] ) && isset( $instance['width']) ) {
			if ((($instance['width-units'] == 'px') && (( int )$instance['width'] >= 300))
				|| (($instance['width-units'] == '%') && (( int )$instance['width'] <= 100))) {
				$width = $instance['width'] . $instance['width-units'];
			}
		}

		$position = isset( $instance['position'] ) ? $instance['position'] : self::DEFAULT_POSITION;

		SpontanioView::showContent('public/templates/widget-iframe', array(
			'args' => $args,
			'buttonName' => $buttonName,
			'roomName' => $roomName,
			'height' => $height,
			'width' => $width,
			'position' => $position,
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function form( $instance ) {
		$buttonName = isset( $instance['button-name'] ) ? $instance['button-name'] : self::DEFAULT_BUTTON_NAME;
		$buttonNameFieldName = $this->get_field_name( 'button-name' );
		$buttonNameFieldId = $this->get_field_id( 'button-name' );

		$options = get_option( SpontanioAdmin::OPTION_NAME );
		$options['default_name'] = $options[SpontanioAdmin::URI_ROOM_NAME];
		if ( isset ( $options[SpontanioAdmin::ROOM_NAME] ) && ! empty( $options[SpontanioAdmin::ROOM_NAME] ) ) {
			$options['default_name'] = $options[SpontanioAdmin::ROOM_NAME];
		}

		$roomName = ( isset( $instance['room-name'] ) && ! empty( $instance['room-name'] ) ) ? $instance['room-name'] : $options['default_name'];
		$roomNameFieldName = $this->get_field_name( 'room-name' );
		$roomNameFieldId = $this->get_field_id( 'room-name' );

		if ( isset( $instance['height'] ) && isset( $instance['height-units'] ) )  {
			$height = $instance['height'];
			$heightUnits = $instance['height-units'];
		} else {
			$height = 100;
			$heightUnits = '%';
		}
		if ( isset( $instance['width'] ) && isset( $instance['width-units'] ) )  {
			$width = $instance['width'];
			$widthUnits = $instance['width-units'];
		} else {
			$width = 100;
			$widthUnits = '%';
		}

		$heightFieldName = $this->get_field_name( 'height' );
		$heightFieldId = $this->get_field_id( 'height' );
		$heightUnitsFieldName = $this->get_field_name( 'height-units' );
		$heightUnitsFieldId = $this->get_field_id( 'height-units' );
		$widthFieldName = $this->get_field_name( 'width' );
		$widthFieldId = $this->get_field_id( 'width' );
		$widthUnitsFieldName = $this->get_field_name( 'width-units' );
		$widthUnitsFieldId = $this->get_field_id( 'width-units' );

		$position = isset( $instance['position'] ) ? $instance['position'] : self::DEFAULT_POSITION;
		$positionFieldName = $this->get_field_name( 'position' );
		$positionFieldId = $this->get_field_id( 'position' );

		SpontanioView::showContent( 'public/templates/widget-form', array(
			'buttonName' => $buttonName,
			'buttonNameFieldName' => $buttonNameFieldName,
			'buttonNameFieldId' => $buttonNameFieldId,

			'roomName' => $roomName,
			'roomNameFieldName' => $roomNameFieldName,
			'roomNameFieldId' => $roomNameFieldId,

			'height' => $height,
			'heightFieldName' => $heightFieldName,
			'heightFieldId' => $heightFieldId,

			'heightUnits' => $heightUnits,
			'heightUnitsFieldName' => $heightUnitsFieldName,
			'heightUnitsFieldId' => $heightUnitsFieldId,

			'width' => $width,
			'widthFieldName' => $widthFieldName,
			'widthFieldId' => $widthFieldId,

			'widthUnits' => $widthUnits,
			'widthUnitsFieldName' => $widthUnitsFieldName,
			'widthUnitsFieldId' => $widthUnitsFieldId,

			'position' => $position,
			'positionFieldName' => $positionFieldName,
			'positionFieldId' => $positionFieldId,
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['button-name'] = ( strlen( strip_tags( $new_instance['button-name'] ) ) > 2 ) ? strip_tags( $new_instance['button-name'] ) : self::DEFAULT_BUTTON_NAME;

		$options = get_option( SpontanioAdmin::OPTION_NAME );
		$options['default_name'] = $options[SpontanioAdmin::URI_ROOM_NAME];
		if ( isset ( $options[SpontanioAdmin::ROOM_NAME] ) && ! empty( $options[SpontanioAdmin::ROOM_NAME] ) ) {
			$options['default_name'] = $options[SpontanioAdmin::ROOM_NAME];
		}

		$instance['room-name'] = SpontanioAdmin::isValidRoomName( $new_instance['room-name'] )
			? $new_instance['room-name']
			: $options['default_name'];

		$instance['height-units'] = strip_tags( $new_instance['height-units'] );

		if ( is_numeric( $new_instance['height'] ) ) {
			if ( ( ( $instance['height-units'] == 'px' ) && ( ( int ) $new_instance['height'] >= 300 ) )
				|| ( ( $instance['height-units'] == '%' ) && ( ( int ) $new_instance['height'] <= 100 ) && ( ( int ) $new_instance['height'] >= 20 ) ) ) {
				$instance['height'] = $new_instance['height'];
			} else {
				$instance['height'] = 100;
				$instance['height-units'] = '%';
			}
		}

		$instance['width-units'] = strip_tags( $new_instance['width-units'] );

		if ( is_numeric( $new_instance['width'] ) ) {
			if ( ( ( $instance['width-units'] == 'px' ) && ( ( int ) $new_instance['width'] >= 300 ) )
				|| ( ( $instance['width-units'] == '%' ) && ( ( int ) $new_instance['width'] <= 100 ) && ( ( int ) $new_instance['width'] >= 20 ) ) ) {
				$instance['width'] = $new_instance['width'];
			} else {
				$instance['width'] = 100;
				$instance['width-units'] = '%';
			}
		}

		$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? sanitize_text_field( $new_instance['position'] ) : self::DEFAULT_POSITION;

		return $instance;
	}

	/**
	 * Adds widget styles.
	 */
	public function enqueueStyles() {
		wp_enqueue_style( 'spontanio-style', SPONTANIO_PLUGIN_URL . 'public/css/styles.css', false );
		wp_enqueue_script( 'spontanio-script', SPONTANIO_PLUGIN_URL . 'public/js/scripts.js', false );
	}
}