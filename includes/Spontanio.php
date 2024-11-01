<?php

class Spontanio
{
	/**
	 * Stores all classes for plugin initialization in array.
	 */
	public static function getComponents()
	{
		return array(
			'SpontanioView'            => 'includes/SpontanioView.php',
			'SpontanioWidget' => 'includes/SpontanioWidget.php',
			'SpontanioShortcode' => 'includes/SpontanioShortcode.php',
			'SpontanioBlock' => 'includes/SpontanioBlock.php',
			'SpontanioAdmin'  => 'admin/SpontanioAdmin.php',
		);
	}

	/**
	 * Initialize the objects required for plugin work.
	 */
	public static function run()
	{
		foreach ( self::getComponents() as $className => $classPath ) {
			require_once SPONTANIO_PLUGIN_PATH . $classPath;
			new $className;
		}
	}
}
