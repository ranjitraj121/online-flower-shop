<?php
/**
 * File containing the class WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin.
 *
 * @package WP_CROWDSIGNAL_FORMS\Admin
 * @since   0.9.0
 */

namespace WP_CROWDSIGNAL_FORMS\Admin;

use WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles front admin page for Crowdsignal.
 *
 * @since 0.9.0
 */
class WP_CROWDSIGNAL_FORMS_Admin {

	/**
	 * The settings class.
	 *
	 * @var WP_CROWDSIGNAL_FORMS_Settings
	 * @since  0.9.0
	 */
	private $settings_page = null;

	/**
	 * The setup page
	 *
	 * @var Crowdsignal_Admin
	 */
	private $setup_page = null;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->setup_page    = new WP_CROWDSIGNAL_FORMS_Setup();
		$this->settings_page = new WP_CROWDSIGNAL_FORMS_Settings();
	}

	/**
	 * Set up actions during admin initialization.
	 *
	 * @todo for future use
	 */
	public function admin_init() {
		add_filter( 'plugin_action_links_' . plugin_basename( WP_CROWDSIGNAL_FORMS_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Enqueues CSS and JS assets.
	 *
	 * @todo for future use
	 */
	public function admin_enqueue_scripts() {
	}

	/**
	 * Adds pages to admin menu.
	 */
	public function admin_menu() {
		if (
			isset( $_GET['page'] )
			&& ( 'crowdsignal-forms-settings' === $_GET['page'] || 'crowdsignal-forms-setup' === $_GET['page'] )
		) {
			wp_safe_redirect( admin_url( 'options-general.php?page=crowdsignal-settings' ) );
			die();
		}

		if ( ! is_plugin_active( 'polldaddy/polldaddy.php' ) ) {
			// Add settings pages.
			add_options_page( 'Crowdsignal', 'Crowdsignal', 'manage_options', 'crowdsignal-settings', array( $this->settings_page, 'output' ) );
		}
	}

	/**
	 * Adds to the Action links in the plugin page.
	 *
	 * @param array $links
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		return array_merge(
			array(
				sprintf( '<a href="%s">' . __( 'Settings', 'crowdsignal-forms' ) . '</a>', admin_url( 'options-general.php?page=crowdsignal-settings' ) ),
			),
			$links
		);
	}
}
