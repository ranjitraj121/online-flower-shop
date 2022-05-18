<?php
/**
 * Contains WP_CROWDSIGNAL_FORMS\Frontend\Blocks\WP_CROWDSIGNAL_FORMS_Vote_Item_Block
 *
 * @package WP_CROWDSIGNAL_FORMS\Frontend\Blocks
 * @since   1.1.0
 */

namespace WP_CROWDSIGNAL_FORMS\Frontend\Blocks;

use WP_CROWDSIGNAL_FORMS\Frontend\WP_CROWDSIGNAL_FORMS_Blocks_Assets;
use WP_CROWDSIGNAL_FORMS\Frontend\WP_CROWDSIGNAL_FORMS_Block;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles WP Crowdsignal Forms' Vote Item child block.
 * This block will never be rendered in the public view, but its definition needs to be registered on the server to ensure its attribute defaults are available.
 *
 * @package  WP_CROWDSIGNAL_FORMS\Frontend\Blocks
 * @since    0.9.0
 */
class WP_CROWDSIGNAL_FORMS_Vote_Item_Block extends WP_CROWDSIGNAL_FORMS_Block {

	/**
	 * {@inheritDoc}
	 */
	public function asset_identifier() {
		return 'crowdsignal-forms-vote-item';
	}

	/**
	 * {@inheritDoc}
	 */
	public function assets() {
		return array(
			'config' => '/build/vote.asset.php', // same as vote block because they're compiled together.
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function register() {
		register_block_type(
			'crowdsignal-forms/vote-item',
			array(
				'attributes'      => $this->attributes(),
				'editor_script'   => WP_CROWDSIGNAL_FORMS_Blocks_Assets::EDITOR,
				'editor_style'    => WP_CROWDSIGNAL_FORMS_Blocks_Assets::EDITOR,
				'render_callback' => array( $this, 'render' ),
			)
		);
	}

	/**
	 * Renders the Vote Item dynamic block
	 *
	 * @param array $attributes The block's attributes.
	 *
	 * @return string
	 */
	public function render( $attributes ) {
		return sprintf(
			'<div data-crowdsignal-vote-item="%s"></div>',
			htmlentities( wp_json_encode( $attributes ) )
		);
	}

	/**
	 * Returns the attributes definition array for register_block_type
	 *
	 * Note: Any changes to the array returned by this function need to be
	 *       duplicated in client/blocks/vote-item/attributes.js.
	 *
	 * @return array
	 */
	private function attributes() {
		return array(
			'answerId'        => array(
				'type'    => 'string',
				'default' => null,
			),
			'type'            => array(
				'type' => 'string',
			),
			'textColor'       => array(
				'type' => 'string',
			),
			'backgroundColor' => array(
				'type' => 'string',
			),
			'borderColor'     => array(
				'type' => 'string',
			),
		);
	}
}
