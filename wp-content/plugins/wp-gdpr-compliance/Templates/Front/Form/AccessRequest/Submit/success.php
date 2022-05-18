<?php

use WPGDPRC\Utils\Template;

/**
 * @var array $chapters
 */

?>

<?php
foreach ( $chapters as $chapter ) :
	if ( empty( $chapter['content'] ) ) {
		$chapter['content'] = Template::get( 'Front/Form/AccessRequest/Submit/notice', [ 'notice' => $chapter['notice'] ] );
	}
	?>

	<?php if ( ! empty( $chapter['title'] ) ) : ?>
	<h2 class="wpgdprc-title">
		<?php echo esc_html( $chapter['title'] ); ?>
	</h2>
	<?php endif; ?>

	<?php
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Handelt by template
    echo $chapter['content'];
    ?>
<?php endforeach; ?>
