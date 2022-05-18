<?php
/**
 * File containing the view for step 2 of the setup wizard.
 *
 * @package WP_CROWDSIGNAL_FORMS\Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use WP_CROWDSIGNAL_FORMS\Auth\WP_CROWDSIGNAL_FORMS_Api_Authenticator;
$WP_CROWDSIGNAL_FORMS_api_auth_provider = new WP_CROWDSIGNAL_FORMS_Api_Authenticator();

if ( $WP_CROWDSIGNAL_FORMS_api_auth_provider->get_api_key() ) {
	$WP_CROWDSIGNAL_FORMS_msg = 'connected';
} else {
	$WP_CROWDSIGNAL_FORMS_msg = 'api-key-not-added';
}
?>
<script type='text/javascript'>
window.close();
if (window.opener && !window.opener.closed) {
	var querystring = window.opener.location.search;
	querystring += ( querystring ? '&' : '?' ) + 'msg=<?php echo esc_js( $WP_CROWDSIGNAL_FORMS_msg ); ?>';
	window.opener.location.search = querystring;
}
</script>
<noscript><h3><?php esc_html_e( "You're ready to start using Crowdsignal!", 'crowdsignal-forms' ); ?></h3></noscript>
