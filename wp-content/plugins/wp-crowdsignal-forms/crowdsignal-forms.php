<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://automattic.com
 * @since             0.9.0
 * @package           WP_CROWDSIGNAL_FORMS
 *
 * @wordpress-plugin
 * Plugin Name:       WP Crowdsignal Forms
 * Plugin URI:        https://crowdsignal.com/crowdsignal-forms/
 * Description:       Crowdsignal Form Blocks
 * Version:           1.5.15
 * Author:            Automattic
 * Author URI:        https://automattic.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       crowdsignal-forms
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define( 'WP_CROWDSIGNAL_FORMS_VERSION', '1.5.15' );
define( 'WP_CROWDSIGNAL_FORMS_PLUGIN_FILE', __FILE__ );
define( 'WP_CROWDSIGNAL_FORMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

$WP_CROWDSIGNAL_FORMS_plugin_dir = dirname( __FILE__ );

require_once $WP_CROWDSIGNAL_FORMS_plugin_dir . '/includes/class-autoloader.php';

WP_CROWDSIGNAL_FORMS\Autoloader::get_instance()
	->set_plugin_dir( $WP_CROWDSIGNAL_FORMS_plugin_dir )
	->register();

WP_CROWDSIGNAL_FORMS\WP_CROWDSIGNAL_FORMS::init();
