<?php
/**
 * File containing the view for displaying the admin notice when user first activates crowdsignal.
 *
 * @package WP_CROWDSIGNAL_FORMS\Admin
 */

use WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin_Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="updated crowdsignal-message">
	<p>
		<?php
		echo wp_kses_post( __( 'You are nearly ready to start creating polls with <strong>Crowdsignal</strong>.', 'crowdsignal-forms' ) );
		?>
	</p>
	<p class="submit">
		<a href="<?php echo esc_url( admin_url( 'options-general.php?page=crowdsignal-settings#setup' ) ); ?>" class="button-primary"><?php esc_html_e( "Let's Get Started", 'crowdsignal-forms' ); ?></a>
		<a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'WP_CROWDSIGNAL_FORMS_hide_notice', WP_CROWDSIGNAL_FORMS_Admin_Notices::NOTICE_CORE_SETUP ), 'WP_CROWDSIGNAL_FORMS_hide_notices_nonce', '_WP_CROWDSIGNAL_FORMS_notice_nonce' ) ); ?>"><?php esc_html_e( 'Skip Setup', 'crowdsignal-forms' ); ?></a>
	</p>
</div>
