<?php

use WPGDPRC\Utils\Elements;
use WPGDPRC\WordPress\Plugin;

/**
 * @var string $name
 * @var string $value
 * @var string $class
 * @var array $args
 */

if ( empty( $id ) ) {
	$id = sanitize_key( $name );
}
if ( empty( $value ) ) {
	$value = '';
}

wp_dropdown_pages(
	[
		'id'               => $id, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'name'             => $name, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'selected'         => $value, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'class'            => $class, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'post_status'      => $args['post_status'] ?? 'publish', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'show_option_none' => $args['show_option_none'] ?? _x( 'Select a page', 'admin', 'wp-gdpr-compliance' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	]
);

?>

<span class="
<?php
if ( empty( $value ) ) {
	echo 'hidden';}
?>
">
	<?php
	Elements::editLink(
		(int) $value,
		_x( 'Edit page', 'admin', 'wp-gdpr-compliance' ),
		[
			'target' => '_blank',
			'class'  => 'wpgdprc-link wpgdprc-link--edit',
		]
	);
	?>
</span>
