<?php

/*
Plugin Name:       Spontanio
Plugin URI:        https://spontan.io
Description:       Free group video chat for your website! Super easy to set up and use. Customize for your brand. Options for selling, scheduling, and more.
Version:           1.2.2
Requires at least: 5.4
Requires PHP:      5.6
Author:            Spontanio
Author URI:        https://spontan.io/about
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( ! defined( 'WPINC' ) ) {
	die( 'Access denied.' );
}

define( 'SPONTANIO_PLUGIN', plugin_basename( __FILE__ ) );
define( 'SPONTANIO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'SPONTANIO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once SPONTANIO_PLUGIN_PATH . 'includes/SpontanioActivator.php';

/**
 * Activates the plugin.
 */
function spontanio_activate() {
	SpontanioActivator::activate();
}
register_activation_hook( __FILE__, 'spontanio_activate' );

/**
 * Deactivates the plugin.
 */
function spontanio_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'spontanio_deactivate' );

/**
 * Runs the plugin.
 */
require SPONTANIO_PLUGIN_PATH . 'includes/Spontanio.php';
Spontanio::run();
