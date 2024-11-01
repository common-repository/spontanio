<?php

class SpontanioShortcode
{
	const DEFAULT_VALUE = '100%';
	const DEFAULT_BUTTON_TEXT = 'Video Chat';
	const DEFAULT_POSITION = 'spontanio-center-middle';

	private $positionValues = array(
		'spontanio-left-top' => array( 'lefttop', 'topleft' ),
		'spontanio-left-middle' => array( 'leftmiddle', 'middleleft', 'leftcenter', 'centerleft' ),
		'spontanio-left-bottom' => array( 'leftbottom', 'bottomleft' ),
		'spontanio-center-top' => array( 'centertop', 'topcenter', 'middletop', 'topmiddle' ),
		'spontanio-center-middle' => array( 'centermiddle', 'middlecenter' ),
		'spontanio-center-bottom' => array( 'centerbottom', 'bottomcenter', 'middlebottom', 'bottommiddle' ),
		'spontanio-right-top' => array( 'righttop', 'topright' ),
		'spontanio-right-middle' => array( 'rightmiddle', 'middleright', 'rightcenter', 'centerright' ),
		'spontanio-right-bottom' => array( 'rightbottom', 'bottomright' ),
	);

	/**
	 * SpontanioShortcode constructor.
	 */
	public function __construct()
	{
		add_shortcode( 'video-chat', array( $this, 'videoChatShortcode' ) );
	}

	/**
	 * Defines shortcode handle actions.
	 */
	public function videoChatShortcode( $attributes ) {
		$options = get_option( SpontanioAdmin::OPTION_NAME );

		$attributes = shortcode_atts( array(
			'roomname' => $options[SpontanioAdmin::URI_ROOM_NAME],
			'buttontext' => self::DEFAULT_BUTTON_TEXT,
			'autolaunch' => true,
			'width' => self::DEFAULT_VALUE,
			'height'  => self::DEFAULT_VALUE,
			'position'  => self::DEFAULT_POSITION,
		), $attributes );

		$attributes['roomname'] = ( ( SpontanioAdmin::isValidRoomName( $attributes['roomname'] ) ) && ( ! empty ( $attributes['roomname'] ) ) ) ? SpontanioAdmin::convertToUriRoomName( $attributes['roomname'] ) : $options[SpontanioAdmin::URI_ROOM_NAME];
		$attributes['buttontext'] = ( strlen( trim( $attributes['buttontext'] ) ) > 2 ) ? trim( $attributes['buttontext'] ) : self::DEFAULT_BUTTON_TEXT;

		$falseFlags = array( '0', 'false', 'off', 'no' );
		$attributes['autolaunch'] = ! in_array( trim( strtolower( $attributes['autolaunch'] ) ), $falseFlags );

		$attributes['width'] = $this->getSize( $attributes['width'] );
		$attributes['height'] = $this->getSize( $attributes['height'] );

		$attributes['position'] = $this->getPosition( $attributes['position'] );

		return SpontanioView::getContent( 'public/templates/shortcode-iframe', array(
			'roomName' => $attributes['roomname'],
			'buttonText' => $attributes['buttontext'],
			'autoLaunch' => $attributes['autolaunch'],
			'width' => $attributes['width'],
			'height' => $attributes['height'],
			'position' => $attributes['position'],
			) );
	}

	/**
	 * Returns validated input size.
	 */
	private function getSize( $sizeStyle )
	{
		$inputStyle = trim ( strtolower( $sizeStyle ) );
		if ( substr( $inputStyle, -2 ) === 'px' ) {
			$value = trim( substr( $inputStyle, 0, strlen( $inputStyle ) - 2 ) );
			return ( ( is_numeric( $value ) ) && ( ( int ) $value >= 300 ) ) ? $value . 'px' : self::DEFAULT_VALUE;
		}
		if ( substr( $inputStyle, -1 ) === '%' ) {
			$value = trim( substr( $inputStyle, 0, strlen( $inputStyle ) - 1 ) );
			return ( ( is_numeric( $value ) ) && ( ( int ) $value >= 20 || ( int ) $value <= 100 ) ) ? $value . '%' : self::DEFAULT_VALUE;
		}

		return self::DEFAULT_VALUE;
	}

	/**
	 * Returns validated class name for position.
	 */
	private function getPosition( $position )
	{
		$inputPosition = preg_replace( '/[^0-9a-z]/', '', strtolower( $position ) );
		$classDefinition = array_filter( $this->positionValues, function( $classValues ) use ( $inputPosition ) {
			return in_array( $inputPosition, $classValues );
		} );

		return ( !empty( $classDefinition ) ) ? key( $classDefinition ) : self::DEFAULT_POSITION;
	}
}
