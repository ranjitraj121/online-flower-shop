<?php
/**
 * Contains WP_CROWDSIGNAL_FORMS\Frontend\WP_CROWDSIGNAL_FORMS_Blocks
 *
 * @package WP_CROWDSIGNAL_FORMS\Frontend
 * @since   0.9.0
 */

namespace WP_CROWDSIGNAL_FORMS\Frontend;

use WP_CROWDSIGNAL_FORMS\Frontend\Blocks as Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles WP Crowdsignal Forms' Gutenberg blocks.
 *
 * @package WP_CROWDSIGNAL_FORMS\Frontend
 * @since   0.9.0
 */
class WP_CROWDSIGNAL_FORMS_Blocks {

	/**
	 * Collection of blocks to be registered.
	 *
	 * @var Blocks\WP_CROWDSIGNAL_FORMS_Poll_Block[]
	 */
	private static $blocks = array();

	/**
	 * Returns a list containing all block classes
	 *
	 * @return array
	 */
	public static function blocks() {
		if ( count( self::$blocks ) > 0 ) {
			return self::$blocks;
		}

		self::$blocks = array(
			new Blocks\WP_CROWDSIGNAL_FORMS_Poll_Block(),
			new Blocks\WP_CROWDSIGNAL_FORMS_Vote_Block(),
			new Blocks\WP_CROWDSIGNAL_FORMS_Vote_Item_Block(),
			new Blocks\WP_CROWDSIGNAL_FORMS_Applause_Block(),
			new Blocks\WP_CROWDSIGNAL_FORMS_Nps_Block(),
			new Blocks\WP_CROWDSIGNAL_FORMS_Feedback_Block(),
		);

		return self::$blocks;
	}

	/**
	 * Registers WP Crowdsignal Forms' custom Gutenberg blocks
	 */
	public function register() {
		foreach ( self::blocks() as $block ) {
			$block->register();
		}
	}
}
