<?php

/**
 * @var string $type
 * @var string $name
 * @var string $value
 * @var string $class
 * @var string $attr
 */

if ( empty( $id ) ) {
	$id = sanitize_key( $name );
}
if ( empty( $type ) ) {
	$type = 'text';
}
?>

<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<input type="<?php echo esc_html( $type ); ?>" id="<?php echo esc_html( $id ); ?>" class="<?php echo esc_html( $class ); ?>" name="<?php echo esc_html( $name ); ?>" value="<?php echo $type === 'text' ? esc_html( $value ) : $value; ?>" <?php echo $attr; ?> />

<?php if ( $type === 'color' ) : ?>
    <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<input type="text" id="<?php echo esc_attr( $id ) . '-text'; ?>" class="<?php echo esc_attr( $class ) . '_text'; ?>" name="<?php echo esc_attr( $name ) . '_text'; ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $attr; ?> />
<?php endif; ?>
