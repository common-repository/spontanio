<?php

class SpontanioBlock
{
	/**
	 * Spontanio custom Gutenberg block constructor.
	 */
	public function __construct()
	{
		add_action( 'init', array( $this, 'registerSpontanioBlock' ) );
		add_action( 'admin_head', array( $this, 'enqueueStyles' ) );
		add_action( 'wp_footer', array( $this, 'setDefaultSettings' ) );
	}

	/**
	 * Registers custom block.
	 */
	public function registerSpontanioBlock()
	{
		$options = get_option( SpontanioAdmin::OPTION_NAME );
		$options['default_name'] = $options[SpontanioAdmin::URI_ROOM_NAME];
		if ( isset ( $options[SpontanioAdmin::ROOM_NAME] ) && ! empty( $options[SpontanioAdmin::ROOM_NAME] ) ) {
			$options['default_name'] = $options[SpontanioAdmin::ROOM_NAME];
		}

		wp_register_script( 'spontanio-block', SPONTANIO_PLUGIN_URL . 'public/js/block-scripts.js', array( 'wp-blocks', 'wp-element' ) );
		wp_localize_script( 'spontanio-block', 'options', $options );
		register_block_type( 'spontanio/iframe-block', array( 'editor_script' => 'spontanio-block', ) );
	}

	/**
	 * Adds block styles.
	 */
	public function enqueueStyles()
	{
		wp_enqueue_style( 'spontanio-block-style', SPONTANIO_PLUGIN_URL . 'public/css/block-styles.css', false );
	}

	/**
	 * Adds div with default settings to the pages.
	 */
	public function setDefaultSettings()
	{
		$options = get_option( SpontanioAdmin::OPTION_NAME );
		SpontanioView::showContent( 'public/templates/default-settings', $options );
	}
}