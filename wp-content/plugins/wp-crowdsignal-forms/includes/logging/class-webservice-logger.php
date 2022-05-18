<?php
/**
 * File containing \WP_CROWDSIGNAL_FORMS\Logging\Webservice_Logger
 *
 * @package crowdsignal-forms/Logging
 * @since 0.9.0
 */

namespace WP_CROWDSIGNAL_FORMS\Logging;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Webservice_Logger
 *
 * @package WP_CROWDSIGNAL_FORMS\Logging
 */
class Webservice_Logger {
	/**
	 * Hook the default stuff.
	 *
	 * @since 0.9.0
	 *
	 * @return $this
	 */
	public function hook_defaults() {
		add_filter( 'WP_CROWDSIGNAL_FORMS_webservice_logging_enabled', '__return_false', 10, 1 );
		return $this;
	}

	/**
	 * Unhook the defaults. Used when implementing logging in a companion plugin.
	 *
	 * @since 0.9.0
	 *
	 * @return $this
	 */
	public function unhook_defaults() {
		remove_filter( 'WP_CROWDSIGNAL_FORMS_webservice_logging_enabled', '__return_false', 10 );
		return $this;
	}

	/**
	 * Log the webservice event.
	 *
	 * @param string $name The event we want to log.
	 * @param array  $data The data we want to log.
	 * @since 0.9.0
	 *
	 * @return $this
	 */
	public function log( $name, $data ) {
		/**
		 * Figure if we should log anything.
		 *
		 * @param bool $should_log Should we log events at all.
		 *
		 * @return array $data The event data to log.
		 *
		 * @since 0.9.0
		 */
		$should_log = (bool) apply_filters( 'WP_CROWDSIGNAL_FORMS_webservice_logging_enabled', false );

		if ( $should_log ) {
			/**
			 * Record the webservice event using some form of "backend".
			 *
			 * @param string $name The event name to log.
			 * @param array $data The event data to log.
			 *
			 * @since 0.9.0
			 */
			do_action( 'WP_CROWDSIGNAL_FORMS_webservice_log_event', $name, $data );
		}

		return $this;
	}
}


