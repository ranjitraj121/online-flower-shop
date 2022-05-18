<?php

/* @author    2codeThemes
*  @package   WPQA/templates/profile
*  @version   1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$wpqa_sidebar = wpqa_sidebars("sidebar_where");
$last_one = (isset($last_one) && $last_one != ""?$last_one:"");
if (wpqa_is_user_followers() || wpqa_is_user_following() || wpqa_is_user_blocking() || $last_one == "followers" || $last_one == "following" || $last_one == "blocking") {
	$user_style_pages = wpqa_options("user_style_pages");
	$masonry_user_style = wpqa_options("masonry_user_style");
	$get_users = get_user_meta($wpqa_user_id,(wpqa_is_user_followers() || $last_one == "followers"?"following_you":"following_me"),true);
	if (isset($get_users) && is_array($get_users) && !empty($get_users)) {
		include wpqa_get_template("users.php","profile/");
	}else {
		echo '<div class="alert-message warning"><i class="icon-flag"></i><p>'.(wpqa_is_user_followers() || $last_one == "followers"?esc_html__("User doesn't have any followers yet.","wpqa"):esc_html__("User doesn't follow anyone.","wpqa")).'</p></div>';
	}
}?>