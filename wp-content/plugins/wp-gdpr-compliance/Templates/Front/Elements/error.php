<?php

use WPGDPRC\WordPress\Plugin;

/**
 * @var string $message
 */

?>

<div class="wpgdprc-message wpgdprc-message--error">
	<p>
		<?php
			/* translators: %1s: error message */
			wp_kses(sprintf( __( '<strong>ERROR</strong>: %1s', 'wp-gdpr-compliance' ), esc_html( $message ) ), \WPGDPRC\Utils\AdminHelper::getAllowedHTMLTags() );
		?>
	</p>
</div>
