<?php
/**
 * An interface for Crowdsignal Authentication
 *
 * @package WP_CROWDSIGNAL_FORMS\Auth
 * @since   0.9.0
 */

namespace WP_CROWDSIGNAL_FORMS\Auth;

interface Api_Auth_Provider_Interface {

	/**
	 * Return the user code to be used with the Crowdsignal API
	 *
	 * @param int $user_id WordPress User ID.
	 * @return string Crowdsignal user code
	 */
	public function fetch_user_code( $user_id );

	/**
	 * Return the user code to be used with the Crowdsignal API
	 *
	 * @param string $api_key Crowdsignal api key.
	 * @return string Crowdsignal user code
	 */
	public function fetch_user_code_for_key( $api_key );
}
