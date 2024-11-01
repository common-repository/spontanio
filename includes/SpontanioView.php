<?php

class SpontanioView
{
	/**
	 * Prints prepared template.
	 *
	 * @param string $template
	 *	Name of template file.
	 * @param array $args
	 *	Arguments which will be passed to template.
	 */
	public static function showContent( $template, array $args = array() )
	{
		echo self::getContent( $template, $args );
	}

	/**
	 * Returns prepared template.
	 *
	 * @param string $template
	 *	Name of template file.
	 * @param array $args
	 *	Arguments which will be passed to template.
	 * @return string
	 *	Template prepared to output.
	 */
	public static function getContent( $template, $args = array() )
	{
		foreach( $args as $key => $value ) {
			$$key = $value;
		}
		$file = SPONTANIO_PLUGIN_PATH . $template . '.php';
		if ( ! file_exists( $file ) ) {
			die( 'The file does not exist.' );
		}
		ob_start();
		include( $file );
		$content = ob_get_clean();
		return $content;
	}
}