<?php

class SpontanioAdmin
{
	const OPTION_GROUP = 'spontanio_settings';
	const OPTION_NAME = 'spontanio';
	const ROOM_NAME = 'room_name';
	const URI_ROOM_NAME = 'uri_room_name';
	const OPTION_SECTION = 'spontanio_section';

	/**
	 * SpontanioAdmin constructor.
	 */
	public function __construct()
	{
		//Adds admin page to define basic plugin settings.
		add_action( 'admin_menu', array( $this, 'addSettingsPage' ) );

		//Initializes form fields for plugin settings.
		add_action( 'admin_init', array( $this, 'optionsInit' ) );

		//Adds setting link to plugin page.
		add_filter( 'plugin_action_links_' . SPONTANIO_PLUGIN, array( $this, 'addSettingsLink' ) );

		//Redirects to Setting page after activation
		add_action( 'activated_plugin', array( $this, 'activation_redirect' ) );
	}

	/**
	 * Redirects to Setting page after activation.
	 */
	public function activation_redirect( $plugin ) {
		if( $plugin == SPONTANIO_PLUGIN ) {
			exit( wp_redirect( admin_url( 'admin.php?page=' . self::OPTION_GROUP ) ) );
		}
	}

	/**
	 * Adds admin page to define basic plugin settings.
	 */
	public function addSettingsPage()
	{
		$icon = base64_encode( include( SPONTANIO_PLUGIN_PATH . 'admin/templates/spontanio-logo.php' ) );
		add_menu_page(
			'Spontanio Plugin Settings',
			'Spontanio',
			'manage_options',
			self::OPTION_GROUP,
			array( $this, 'showSettingsPage'),
			'data:image/svg+xml;base64,' . $icon,
			90
		);
	}

	/**
	 * Shows plugin settings page.
	 */
	public function showSettingsPage()
	{
		if ( current_user_can( 'manage_options' ) ) {
			SpontanioView::showContent( 'admin/templates/settings-page' );
		}
	}

	/**
	 * Initializes form fields for plugin settings.
	 */
	public function optionsInit()
	{
		register_setting(
			self::OPTION_GROUP,
			self::OPTION_NAME,
			array( $this, 'sanitize' )
		);
		add_settings_section(
			self::OPTION_SECTION,
			'',
			array( $this, 'showSectionDescription' ),
			self::OPTION_GROUP
		);
		add_settings_field (
			self::ROOM_NAME,
			'Your Room Name',
			array( $this, 'showTextField' ),
			self::OPTION_GROUP,
			self::OPTION_SECTION,
			self::ROOM_NAME
		);
	}

	/**
	 * Sanitizes options.
	 */
	public function sanitize( $inputOptions )
	{
		$savedOptions = get_option( self::OPTION_NAME );

		foreach ( $inputOptions as $key => &$option ) {
			$userInputOption = $option;
			$option = sanitize_text_field( $option );
			if ( $key === self::ROOM_NAME ) {
				if ( ! self::isValidRoomName( $inputOptions[self::ROOM_NAME] ) ) {
					$option = isset( $savedOptions[$key] ) ? $savedOptions[$key] : null;
					add_settings_error( $key, '', 'Room Name "' . $userInputOption . '" is incorrect. It must be at least 6 characters long.' );
				}

				// save correct URI room name
				$inputOptions[self::URI_ROOM_NAME] = $savedOptions[self::URI_ROOM_NAME];
				if ( empty( $inputOptions[self::ROOM_NAME] ) ) {
					$inputOptions[self::URI_ROOM_NAME] = SpontanioActivator::getDefaultRoomName();
				} elseif ( empty( get_settings_errors() ) ) {
					$inputOptions[self::URI_ROOM_NAME] = self::convertToUriRoomName( $option );
				}
			}
		}
		return $inputOptions;
	}

	/**
	 * Defines a template of section description for configuration page.
	 */
	public function showSectionDescription()
	{
		SpontanioView::showContent( 'admin/templates/settings-section-description' );
	}

	/**
	 * Defines a template of text option field.
	 * @param $option
	 *  Option name.
	 */
	public function showTextField( $option )
	{
		$options = get_option( self::OPTION_NAME );
		$optionName = self::OPTION_NAME . '[' . $option . ']';
		$optionValue = isset( $options[$option] ) ? $options[$option] : '';
		SpontanioView::showContent( 'admin/templates/settings-text-field', array(
			'option_name' => esc_attr($optionName),
			'option_value' => esc_attr($optionValue),
		) );
	}

	/**
	 * Adds setting link to plugin page.
	 */
	public function addSettingsLink( $links )
	{
		$links[] = SpontanioView::getContent( 'admin/templates/settings-link', array(
			'settingsUrl' => admin_url( 'admin.php?page=' . self::OPTION_GROUP ),
		) );
		return $links;
	}

	/**
	 * Deletes settings option from database when plugin has been uninstalled.
	 */
	public static function deleteSettings()
	{
		global $wpdb;
		$wpdb->delete( 'wp_options', array( 'option_name' => self::OPTION_NAME ) );
	}

	/**
	 * Checks if entered room name is valid.
	 */
	public static function isValidRoomName( $roomName )
	{
		if ( ( strlen( self::convertToUriRoomName( $roomName ) ) >= 6 ) || ( strlen( $roomName ) === 0 ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Converts input room name to URI applicable string.
	 */
	public static function convertToUriRoomName( $roomName )
	{
		return preg_replace( '/[^0-9a-z]/', '', strtolower( $roomName ) );
	}
}
