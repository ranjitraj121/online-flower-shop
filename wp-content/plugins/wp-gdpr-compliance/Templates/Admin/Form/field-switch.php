<?php

use WPGDPRC\Utils\Template;

/**
 * @var string $name
 * @var string $value
 * @var string $class
 * @var string $data
 * @var array $args
 */

if ( empty( $id ) ) {
	$id = sanitize_key( $name );
}
if ( empty( $value ) ) {
	$value = 0;
}

$classes = [ 'wpgdprc-switch' ];
if ( ! empty( $class ) ) {
	$classes[] = $class;
}
if ( ! empty( $args['border'] ) ) {
	$classes[] = 'wpgdprc-switch--border';
}
if ( ! empty( $args['no_margin_right'] ) ) {
	$classes[] = ' wpgdprc-switch--no-margin-right';
}
$class = implode( ' ', $classes );

?>

<?php if ( ! empty( $args['description'] ) ) : ?>
	<?php $args['description']; ?>
<?php endif; ?>

<label class="<?php echo esc_attr( $class ); ?>" for="<?php echo esc_attr( $id ); ?>">
	<span class="wpgdprc-switch__text"><?php echo $args['label']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<span class="wpgdprc-switch__switch">
		<input class="wpgdprc-switch__input" type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( '1', $value, true ); ?>
			<?php echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>/>
		<span class="wpgdprc-switch__slider round">
			<?php Template::renderIcon( 'check', 'fontawesome-pro-regular' ); ?>
			<?php Template::renderIcon( 'times', 'fontawesome-pro-regular' ); ?>
		</span>
	</span>
</label>
