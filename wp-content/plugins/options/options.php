<?php

/* @author    2codeThemes
*  @package   WPQA/options
*  @version   1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Options */
add_filter("wpqa_the_options","wpqa_the_options",1,6);
function wpqa_the_options($options,$options_pages,$new_roles,$imagepath,$imagepath_theme,$new_sidebars) {
	
	$activate_currencies = discy_options("activate_currencies");
	$multi_currencies = discy_options("multi_currencies");
	$wp_editor_settings = array("media_buttons" => true,"textarea_rows" => 10);
	
	// Background Defaults
	$background_defaults = array(
		'color'      => '',
		'image'      => '',
		'repeat'     => 'repeat',
		'position'   => 'top center',
		'attachment' =>'scroll' 
	);

	// Share
	$share_array = array(
		"share_facebook" => array("sort" => "Facebook","value" => "share_facebook"),
		"share_twitter"  => array("sort" => "Twitter","value" => "share_twitter"),
		"share_linkedin" => array("sort" => "LinkedIn","value" => "share_linkedin"),
		"share_whatsapp" => array("sort" => "WhatsApp","value" => "share_whatsapp"),
	);

	// Currencies
	$currencies = array(
		'USD' => 'USD',
		'EUR' => 'EUR',
		'GBP' => 'GBP',
		'JPY' => 'JPY',
		'CAD' => 'CAD',
		'INR' => 'INR',
		'TRY' => 'TRY',
		'BRL' => 'BRL',
		'HUF' => 'HUF',
		'BDT' => 'BDT',
		'AUD' => 'AUD',
		'IDR' => 'IDR'
	);

	$currencies = apply_filters("wpqa_currencies",$currencies);
	$questions_settings = array(
		"general_setting"   => esc_html__('General settings','wpqa'),
		"question_slug"     => esc_html__('Question slugs','wpqa'),
		"add_edit_delete"   => esc_html__('Add - Edit - Delete','wpqa'),
		"question_meta"     => esc_html__('Question meta settings','wpqa'),
		"question_category" => esc_html__('Questions category settings','wpqa'),
		"questions_loop"    => esc_html__('Questions & Loop settings','wpqa'),
		"inner_question"    => esc_html__('Inner question','wpqa'),
		"share_setting_q"   => esc_html__('Share setting','wpqa'),
		"questions_layout"  => esc_html__('Questions layout','wpqa')
	);

	$options[] = array(
		'name'    => esc_html__('Question settings','wpqa'),
		'id'      => 'question',
		'icon'    => 'editor-help',
		'type'    => 'heading',
		'std'     => 'general_setting',
		'options' => apply_filters("discy_questions_settings",$questions_settings)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'general_setting',
		'name' => esc_html__('General settings','wpqa')
	);

	$options = apply_filters('discy_options_before_question_general_setting',$options);
	
	$options[] = array(
		'name' => esc_html__('Select ON if you need to choose the question at simple layout','wpqa'),
		'id'   => 'question_simple',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => esc_html__('Ajax file load from admin or theme','wpqa'),
		'desc'    => esc_html__('Choose ajax file load from admin or theme.','wpqa'),
		'id'      => 'ajax_file',
		'std'     => 'admin',
		'type'    => 'select',
		'options' => array("admin" => esc_html__("Admin","wpqa"),"theme" => esc_html__("Theme","wpqa"))
	);
	
	$options[] = array(
		'name' => esc_html__('Show filter at categories and archive pages','wpqa'),
		'desc' => esc_html__('Select ON to enable the filter at categories and archive pages.','wpqa'),
		'id'   => 'category_filter',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Tag description enable or disable','wpqa'),
		'desc' => esc_html__('Select ON to enable the tag description in the tag page.','wpqa'),
		'id'   => 'question_tag_description',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Tag rss enable or disable','wpqa'),
		'desc'      => esc_html__('Select ON to enable the tag rss in the tag page.','wpqa'),
		'id'        => 'question_tag_rss',
		'std'       => 'on',
		'condition' => 'question_tag_description:not(0)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Do you need to activate you might like options?','wpqa'),
		'desc' => esc_html__('Select ON if you want to activate you might like for the questions and answers.','wpqa'),
		'id'   => 'might_like',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Do you need to show the questions based on the date and answers updated?','wpqa'),
		'desc' => esc_html__('Select ON if you want to display the questions based on recently added and recent answers added.','wpqa'),
		'id'   => 'updated_answers',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'      => esc_html__('After new answer has been added, move this question to the top. It works for the recent questions, feed, and questions for you tabs or pages.','wpqa'),
		'condition' => 'updated_answers:not(0)',
		'type'      => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Do you need to hide the content only for the private question?','wpqa'),
		'desc' => esc_html__('Select ON if you want to hide the content only for the private question.','wpqa'),
		'id'   => 'private_question_content',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the best answer for the normal users in site?','wpqa'),
		'desc' => esc_html__('Best answer enable or disable.','wpqa'),
		'id'   => 'active_best_answer',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Activate user can choose own answer as the best answer','wpqa'),
		'desc'      => esc_html__('User can choose own answer as the best answer enable or disable.','wpqa'),
		'id'        => 'best_answer_userself',
		'std'       => "on",
		'condition' => 'active_best_answer:not(0)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the points system in site?','wpqa'),
		'desc' => esc_html__('The points system enable or disable.','wpqa'),
		'id'   => 'active_points',
		'std'  => "on",
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_points:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the points sort with specific days?','wpqa'),
		'desc' => esc_html__('The points sort with day, week, month or year enable or disable.','wpqa'),
		'id'   => 'active_points_specific',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the bump question','wpqa'),
		'desc' => esc_html__('Select ON if you want the bump question.','wpqa'),
		'id'   => 'question_bump',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_bump:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Add the points users must add to allow them to bump up the question.','wpqa'),
		'id'   => 'question_bump_points',
		'std'  => 0,
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Make the points for the bump question go to the user who has the best answer','wpqa'),
		'id'   => 'bump_best_answer',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('When the question or answer is deleted, if it has the best answer - remove it from the stats and user points?','wpqa'),
		'desc' => esc_html__('Select ON if you want to remove the best answer from the user points.','wpqa'),
		'id'   => 'remove_best_answer_stats',
		'type' => 'checkbox'
	);

	/*
	$options[] = array(
		'name' => esc_html__('Activate the extract link data?','wpqa'),
		'desc' => esc_html__('The extract link data enable or disable.','wpqa'),
		'id'   => 'extract_link',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the extract link data to save at cache?','wpqa'),
		'id'   => 'extract_link_cache',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__("Choose the cache limit for the links.","wpqa"),
		'id'        => 'extract_link_cache_limit',
		'std'       => 'month',
		'type'      => 'radio',
		'condition' => 'extract_link_cache:not(0)',
		'options'   => 
			array(
				"day"   => esc_html__("Day","wpqa"),
				"week"  => esc_html__("Week","wpqa"),
				"month" => esc_html__("Month","wpqa"),
				"year"  => esc_html__("Year","wpqa")
		)
	);
	*/
	
	$options[] = array(
		'name' => esc_html__('Activate the mention in site?','wpqa'),
		'desc' => esc_html__('Activate the mention enable or disable.','wpqa'),
		'id'   => 'active_mention',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the reports in site?','wpqa'),
		'desc' => esc_html__('Activate the reports enable or disable.','wpqa'),
		'id'   => 'active_reports',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_reports:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the reports in site for the "logged in users" only?','wpqa'),
		'desc' => esc_html__('Activate the reports in site for the "logged in users" only enable or disable.','wpqa'),
		'id'   => 'active_logged_reports',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_points:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the users having certain points can move the question or answer to trash or draft by reporting.','wpqa'),
		'id'   => 'active_trash_reports',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_trash_reports:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Move the question or answer to trash or draft when reported.','wpqa'),
		'id'      => 'trash_draft_reports',
		'options' => array("trash" => esc_html__("Trash","wpqa"),"draft" => esc_html__("Draft","wpqa")),
		'type'    => 'select'
	);
	
	$options[] = array(
		'name' => esc_html__('Add the points to allow the users which will let them move the question or answer to trash or draft when reported.','wpqa'),
		'id'   => 'trash_reports_points',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add minimum of the points if anyone which have them, their questions or answers will not move to trash or draft.','wpqa'),
		'id'   => 'reports_min_points',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Whitelist questions.','wpqa'),
		'desc' => esc_html__('Add here the whitelist question, Any questions here will not move to trash or draft.','wpqa'),
		'id'   => 'whitelist_questions',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'name' => esc_html__('Whitelist answers.','wpqa'),
		'desc' => esc_html__('Add here the whitelist answers, Any answers here will not move to trash or draft.','wpqa'),
		'id'   => 'whitelist_answers',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate poll for user only?','wpqa'),
		'desc' => esc_html__('Select ON if you want to allow poll to users only.','wpqa'),
		'id'   => 'poll_user_only',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Activate the vote in the site?','wpqa'),
		'desc' => esc_html__('The vote for questions and answers in the site enable or disable.','wpqa'),
		'id'   => 'active_vote',
		'std'  => "on",
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'      => esc_html__('Activate the vote in the site for the "unlogged users"?','wpqa'),
		'desc'      => esc_html__('The vote for questions and answers in the site for the "unlogged users" enable or disable.','wpqa'),
		'id'        => 'active_vote_unlogged',
		'std'       => "on",
		'type'      => 'checkbox',
		'condition' => 'active_vote:not(0)'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the pop up at the author image in the site?','wpqa'),
		'desc' => esc_html__('Pop up at the author image in site enable or disable.','wpqa'),
		'id'   => 'author_image_pop',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the separator for the numbers at the site?','wpqa'),
		'id'   => 'active_separator',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'      => esc_html__('Number separator','wpqa'),
		'desc'      => esc_html__('Add your number separator.','wpqa'),
		'id'        => 'number_separator',
		'std'       => ',',
		'type'      => 'text',
		'condition' => 'active_separator:not(0)'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Question slugs','wpqa'),
		'id'   => 'question_slug',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Questions archive slug','wpqa'),
		'desc' => esc_html__('Add your questions archive slug.','wpqa'),
		'id'   => 'archive_question_slug',
		'std'  => 'questions',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Click ON, if you need to remove the question slug and choose "Post name" from WordPress Settings/Permalinks.','wpqa'),
		'id'   => 'remove_question_slug',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Question slug','wpqa'),
		'desc'      => esc_html__('Add your question slug.','wpqa'),
		'id'        => 'question_slug',
		'std'       => 'question',
		'condition' => 'remove_question_slug:not(on)',
		'type'      => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Question category slug','wpqa'),
		'desc' => esc_html__('Add your question category slug.','wpqa'),
		'id'   => 'category_question_slug',
		'std'  => 'question-category',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Question tag slug','wpqa'),
		'desc' => esc_html__('Add your question tag slug.','wpqa'),
		'id'   => 'tag_question_slug',
		'std'  => 'question-tag',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'add_edit_delete',
		'name' => esc_html__('Add, edit and delete question','wpqa')
	);
	
	$options[] = array(
		'name' => esc_html__('Any one can ask question without register','wpqa'),
		'desc' => esc_html__('Any one can ask question without register enable or disable.','wpqa'),
		'id'   => 'ask_question_no_register',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Charge points for question settings','wpqa'),
		'desc' => esc_html__('Select ON if you want to charge points from users for asking questions.','wpqa'),
		'id'   => 'question_points_active',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_points_active:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Charge points for questions','wpqa'),
		'desc' => esc_html__("How many points should be taken from the user's account for asking questions.","wpqa"),
		'id'   => 'question_points',
		'std'  => '5',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Point back to the user when they select the best answer','wpqa'),
		'id'   => 'point_back',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Or type here the point the user should get back','wpqa'),
		'desc'      => esc_html__('Or type here the point user should get back. Type 0 to return all the points.','wpqa'),
		'id'        => 'point_back_number',
		'condition' => 'point_back:not(0)',
		'std'       => '0',
		'type'      => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name'    => esc_html__('Choose question status for users only','wpqa'),
		'desc'    => esc_html__('Choose question status after the user publishes the question.','wpqa'),
		'id'      => 'question_publish',
		'options' => array("publish" => esc_html__("Publish","wpqa"),"draft" => esc_html__("Draft","wpqa")),
		'std'     => 'publish',
		'type'    => 'select'
	);
	
	$options[] = array(
		'name'      => esc_html__('Choose question status for "unlogged user" only','wpqa'),
		'desc'      => esc_html__('Choose question status after "unlogged user" publish the question.','wpqa'),
		'id'        => 'question_publish_unlogged',
		'options'   => array("publish" => esc_html__("Publish","wpqa"),"draft" => esc_html__("Draft","wpqa")),
		'std'       => 'draft',
		'type'      => 'select',
		'condition' => 'ask_question_no_register:not(0)',
	);
	
	$options[] = array(
		'name'      => esc_html__('Send mail when the question needs a review','wpqa'),
		'desc'      => esc_html__('Mail for questions review enable or disable.','wpqa'),
		'id'        => 'send_email_draft_questions',
		'std'       => 'on',
		'operator'  => 'or',
		'condition' => 'question_publish:not(publish),question_publish_unlogged:not(publish)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Auto approve for the users who have a previously approved question.','wpqa'),
		'id'        => 'approved_questions',
		'condition' => 'question_publish:not(publish)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Send schedule mails for the users as a list with recent questions','wpqa'),
		'id'   => 'question_schedules',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_schedules:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Schedule mails time','wpqa'),
		'id'      => 'question_schedules_time',
		'type'    => 'multicheck',
		'std'     => array("daily" => "daily","weekly" => "weekly","monthly" => "monthly"),
		'options' => array("daily" => esc_html__("Daily","wpqa"),"weekly" => esc_html__("Weekly","wpqa"),"monthly" => esc_html__("Monthly","wpqa"))
	);

	$options[] = array(
		"name" => esc_html__("Set the hour to send the mail at this hour","wpqa"),
		"id"   => "schedules_time_hour",
		"type" => "sliderui",
		'std'  => 12,
		"step" => "1",
		"min"  => "1",
		"max"  => "24"
	);

	$options[] = array(
		'name'    => esc_html__('Select the day to send the mail at this day','wpqa'),
		'id'      => 'schedules_time_day',
		'type'    => "select",
		'std'     => "saturday",
		'options' => array(
			'saturday'  => esc_html__('Saturday','wpqa'),
			'sunday'    => esc_html__('Sunday','wpqa'),
			'monday'    => esc_html__('Monday','wpqa'),
			'tuesday'   => esc_html__('Tuesday','wpqa'),
			'wednesday' => esc_html__('Wednesday','wpqa'),
			'thursday'  => esc_html__('Thursday','wpqa'),
			'friday'    => esc_html__('Friday','wpqa')
		)
	);
	
	$options[] = array(
		'name'    => esc_html__('Send schedule mails for custom roles to send a list with recent questions','wpqa'),
		'id'      => 'question_schedules_groups',
		'type'    => 'multicheck',
		'std'     => array("editor" => "editor","administrator" => "administrator","author" => "author","contributor" => "contributor","subscriber" => "subscriber"),
		'options' => discy_options_roles()
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Send mail to the users about the notification of a new question','wpqa'),
		'desc' => esc_html__('Send mail enable or disable.','wpqa'),
		'id'   => 'send_email_new_question',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Send mail for custom roles about the notification of a new question','wpqa'),
		'id'        => 'send_email_question_groups',
		'type'      => 'multicheck',
		'condition' => 'send_email_new_question:not(0)',
		'std'       => array("editor" => "editor","administrator" => "administrator","author" => "author","contributor" => "contributor","subscriber" => "subscriber"),
		'options'   => discy_options_roles()
	);
	
	$options[] = array(
		'name' => esc_html__('Send notification to the users about the notification of a new question','wpqa'),
		'desc' => esc_html__('Send notification enable or disable.','wpqa'),
		'id'   => 'send_notification_new_question',
		'std'  => 'on',
		'type' => 'checkbox'
	);

	$send_notification_question_groups = discy_options("send_notification_question_groups");
	$send_notification_question_groups = (is_array($send_notification_question_groups) && !empty($send_notification_question_groups)?$send_notification_question_groups:discy_options("send_email_question_groups"));
	
	$options[] = array(
		'name'      => esc_html__('Send notification for custom roles about the notification of a new question','wpqa'),
		'id'        => 'send_notification_question_groups',
		'type'      => 'multicheck',
		'condition' => 'send_notification_new_question:not(0)',
		'std'       => $send_notification_question_groups,
		'options'   => discy_options_roles()
	);
	
	$options[] = array(
		'name' => esc_html__('Ask questions','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Make the ask question form works with popup','wpqa'),
		'desc' => esc_html__('Select ON if you want to make the ask question form works with popup.','wpqa'),
		'id'   => 'ask_question_popup',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Ask question slug','wpqa'),
		'desc' => esc_html__('Put the ask question slug.','wpqa'),
		'id'   => 'add_questions_slug',
		'std'  => 'add-question',
		'type' => 'text'
	
	);

	$options[] = array(
		'name' => '<a href="'.wpqa_add_question_permalink().'" target="_blank">'.esc_html__('Link For The Ask Question Page.','wpqa').'</a>',
		'type' => 'info'
	);

	$options = apply_filters('discy_options_after_question_link',$options);
	
	$ask_question_items = array(
		"title_question"       => array("sort" => esc_html__('Question Title','wpqa'),"value" => "title_question"),
		"categories_question"  => array("sort" => esc_html__('Question Categories','wpqa'),"value" => "categories_question"),
		"tags_question"        => array("sort" => esc_html__('Question Tags','wpqa'),"value" => "tags_question"),
		"poll_question"        => array("sort" => esc_html__('Question Poll','wpqa'),"value" => "poll_question"),
		"attachment_question"  => array("sort" => esc_html__('Question Attachment','wpqa'),"value" => "attachment_question"),
		"featured_image"       => array("sort" => esc_html__('Featured image','wpqa'),"value" => "featured_image"),
		"comment_question"     => array("sort" => esc_html__('Question content','wpqa'),"value" => "comment_question"),
		"anonymously_question" => array("sort" => esc_html__('Ask Anonymously','wpqa'),"value" => "anonymously_question"),
		"video_desc_active"    => array("sort" => esc_html__('Video Description','wpqa'),"value" => "video_desc_active"),
		"private_question"     => array("sort" => esc_html__('Private Question','wpqa'),"value" => "private_question"),
		"remember_answer"      => array("sort" => esc_html__('Remember Answer','wpqa'),"value" => "remember_answer"),
		"terms_active"         => array("sort" => esc_html__('Terms of Service and Privacy Policy','wpqa'),"value" => "terms_active"),
	);
	
	$ask_question_items_std = $ask_question_items;
	unset($ask_question_items_std["attachment_question"]);
	
	$options[] = array(
		'name'    => esc_html__("Select what to show at ask question form","wpqa"),
		'id'      => 'ask_question_items',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $ask_question_items_std,
		'options' => $ask_question_items
	);
	
	$options[] = array(
		'name'      => esc_html__('Activate suggested questions in the title when user is typing the question','wpqa'),
		'id'        => 'suggest_questions',
		'condition' => 'ask_question_items:has(title_question)',
		'type'      => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has_not(title_question)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Excerpt type for title from the content','wpqa'),
		'desc'    => esc_html__('Choose form here the excerpt type.','wpqa'),
		'id'      => 'title_excerpt_type',
		'type'    => "select",
		'options' => array(
			'words'      => esc_html__('Words','wpqa'),
			'characters' => esc_html__('Characters','wpqa')
		)
	);

	$options[] = array(
		'name' => esc_html__('Excerpt title from the content','wpqa'),
		'desc' => esc_html__('Put here the excerpt title from the content.','wpqa'),
		'id'   => 'title_excerpt',
		'std'  => 10,
		'type' => 'text'
	);

	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div'
	);

	$options[] = array(
		'name'    => esc_html__('Select the checked by default options at ask a new question','wpqa'),
		'id'      => 'add_question_default',
		'type'    => 'multicheck',
		'std'     => array(
			"notified" => "notified",
		),
		'options' => array(
			"poll"        => esc_html__('Poll','wpqa'),
			"video"       => esc_html__('Video','wpqa'),
			"notified"    => esc_html__('Notified','wpqa'),
			"private"     => esc_html__("Private question","wpqa"),
			"anonymously" => esc_html__("Ask anonymously","wpqa"),
			"terms"       => esc_html__("Terms","wpqa"),
			"sticky"      => esc_html__("Sticky","wpqa"),
		)
	);
	
	$options[] = array(
		'name'      => esc_html__("Category at ask question form single, multi, ajax 1 or ajax 2","wpqa"),
		'desc'      => esc_html__("Choose how category is shown at ask question form single, multi or ajax","wpqa"),
		'id'        => 'category_single_multi',
		'std'       => 'single',
		'type'      => 'radio',
		'condition' => 'ask_question_items:has(categories_question)',
		'options'   => 
			array(
				"single" => "Single",
				"multi"  => "Multi",
				"ajax"   => "Ajax 1",
				"ajax_2" => "Ajax 2"
		)
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(poll_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Poll setting','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the poll for specific roles','wpqa'),
		'id'   => 'custom_poll_groups',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'      => esc_html__("Choose the roles to allow them to add poll.","wpqa"),
		'id'        => 'poll_groups',
		'condition' => 'custom_poll_groups:not(0)',
		'type'      => 'multicheck',
		'options'   => $new_roles
	);
	
	$options[] = array(
		'name' => esc_html__('Activate image in the poll','wpqa'),
		'id'   => 'poll_image',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'poll_image:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the title in the poll images','wpqa'),
		'id'   => 'poll_image_title',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Make the title in the poll images required','wpqa'),
		'id'        => 'poll_image_title_required',
		'condition' => 'poll_image_title:not(0)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(comment_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Question content setting','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Details in ask question form is required','wpqa'),
		'id'   => 'comment_question',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable the editor for details in ask question form','wpqa'),
		'id'   => 'editor_question_details',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(terms_active)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Terms of Service and Privacy Policy','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name'    => esc_html__('Open the page in same page or a new page?','wpqa'),
		'id'      => 'terms_active_target',
		'std'     => "new_page",
		'type'    => 'select',
		'options' => array("same_page" => esc_html__("Same page","wpqa"),"new_page" => esc_html__("New page","wpqa"))
	);
	
	$options[] = array(
		'name'    => esc_html__('Terms page','wpqa'),
		'desc'    => esc_html__('Select the terms page','wpqa'),
		'id'      => 'terms_page',
		'type'    => 'select',
		'options' => $options_pages
	);
	
	$options[] = array(
		'name' => esc_html__("Type the terms link if you don't like a page","wpqa"),
		'id'   => 'terms_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate Privacy Policy','wpqa'),
		'desc' => esc_html__('Select ON if you want to activate Privacy Policy.','wpqa'),
		'id'   => 'privacy_policy',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'privacy_policy:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Open the page in same page or a new page?','wpqa'),
		'id'      => 'privacy_active_target',
		'std'     => "new_page",
		'type'    => 'select',
		'options' => array("same_page" => esc_html__("Same page","wpqa"),"new_page" => esc_html__("New page","wpqa"))
	);
	
	$options[] = array(
		'name'    => esc_html__('Privacy Policy page','wpqa'),
		'desc'    => esc_html__('Select the privacy policy page','wpqa'),
		'id'      => 'privacy_page',
		'type'    => 'select',
		'options' => $options_pages
	);
	
	$options[] = array(
		'name' => esc_html__("Type the privacy policy link if you don't like a page","wpqa"),
		'id'   => 'privacy_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(title_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Limitations for title','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Add minimum limit for the number of letters for the question title, like 15, 20, if you leave it empty, it will be not important','wpqa'),
		'id'   => 'question_title_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add limit for the number of letters for the question title, like 140, 200, if you leave it empty, it will be unlimited','wpqa'),
		'id'   => 'question_title_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(tags_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Limitations for tags','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Add minimum limit for the number of letters for the question tag word, like 15, 20, if you leave it empty it will be not important','wpqa'),
		'id'   => 'question_tags_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add word limit for the number of letters for the question tag, like 140, 200, if you leave it empty will be unlimited','wpqa'),
		'id'   => 'question_tags_limit',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Add minimum limit for the number of items for the question tags, like 2, 4, if you leave it empty will be not important','wpqa'),
		'id'   => 'question_tags_number_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add limit for the number of items for the question tags, like 4, 6, if you leave it empty it will be unlimited','wpqa'),
		'id'   => 'question_tags_number_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(poll_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Limitations for poll','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Add limit for the number of letters for the question poll title, like 140, 200, if you leave it empty it will be unlimited','wpqa'),
		'id'   => 'question_poll_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add limit for the number of letters for the question poll title, like 140, 200, if you leave it empty it will be unlimited','wpqa'),
		'id'   => 'question_poll_limit',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Add minimum limit for the number of items for the question poll title, like 2, 4, if you leave it empty it will be not important','wpqa'),
		'id'   => 'question_poll_number_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add limit for the number of items for the question poll title, like 4, 6, if you leave it empty it will be unlimited','wpqa'),
		'id'   => 'question_poll_number_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(comment_question)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Limitations for content','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Add minimum limit for the number of letters for the question content, like 15, 20, if you leave it empty it will be not important','wpqa'),
		'id'   => 'question_content_min_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Add limit for the number of letters for the question content, like 140, 200, if you leave it empty it will be unlimited','wpqa'),
		'id'   => 'question_content_limit',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Edit questions','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can edit the questions','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to edit the questions.','wpqa'),
		'id'   => 'question_edit',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_edit:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Edit question slug','wpqa'),
		'desc' => esc_html__('Put the edit question slug.','wpqa'),
		'id'   => 'edit_questions_slug',
		'std'  => 'edit-question',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('After edit auto approve question or need to be approved again?','wpqa'),
		'desc' => esc_html__('Press ON to auto approve','wpqa'),
		'id'   => 'question_approved',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('After the question is edited change the URL from the title?','wpqa'),
		'desc' => esc_html__('Press ON to edit the URL','wpqa'),
		'id'   => 'change_question_url',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Delete questions','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can delete the questions','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to delete the questions.','wpqa'),
		'id'   => 'question_delete',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('When the users delete the question send to the trash or delete it forever?','wpqa'),
		'id'        => 'delete_question',
		'options'   => array(
			'delete' => esc_html__('Delete','wpqa'),
			'trash'  => esc_html__('Trash','wpqa'),
		),
		'std'       => 'delete',
		'condition' => 'question_delete:not(0)',
		'type'      => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Question meta settings','wpqa'),
		'id'   => 'question_meta',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON if you want to activate the vote with meta.','wpqa'),
		'id'   => 'question_meta_vote',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON if you want icons only at the question meta.','wpqa'),
		'id'   => 'question_meta_icon',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => esc_html__('Select the meta options','wpqa'),
		'id'      => 'question_meta',
		'type'    => 'multicheck',
		'std'     => array(
			"author_by"         => "author_by",
			"question_date"     => "question_date",
			"asked_to"          => "asked_to",
			"category_question" => "category_question",
			"question_answer"   => "question_answer",
			"question_views"    => "question_views",
			"bump_meta"         => "bump_meta",
		),
		'options' => array(
			"author_by"         => esc_html__('Author by','wpqa'),
			"question_date"     => esc_html__('Date meta','wpqa'),
			"asked_to"          => esc_html__('Asked to meta','wpqa'),
			"category_question" => esc_html__('Category question','wpqa'),
			"question_answer"   => esc_html__('Answer meta','wpqa'),
			"question_views"    => esc_html__('Views stats','wpqa'),
			"bump_meta"         => esc_html__('Bump question meta','wpqa'),
		)
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can add the question to favorites','wpqa'),
		'desc' => esc_html__('Select ON if you want the user can add the questions to favorites.','wpqa'),
		'id'   => 'question_favorite',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can follow the questions','wpqa'),
		'desc' => esc_html__('Select ON if you want the user can follow the questions.','wpqa'),
		'id'   => 'question_follow',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the follow button at questions loop','wpqa'),
		'desc' => esc_html__('Select ON if you want to activate the follow button at questions loop.','wpqa'),
		'id'   => 'question_follow_loop',
		'type' => 'checkbox'
	);

	$options = apply_filters('discy_options_after_question_follow_loop',$options);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Questions category settings','wpqa'),
		'id'   => 'question_category',
		'type' => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Category description enable or disable','wpqa'),
		'desc' => esc_html__('Select ON to enable the category description in the category page.','wpqa'),
		'id'   => 'question_category_description',
		'std'  => 'on',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'      => esc_html__('Category rss enable or disable','wpqa'),
		'desc'      => esc_html__('Select ON to enable the category rss in the category page.','wpqa'),
		'id'        => 'question_category_rss',
		'std'       => 'on',
		'condition' => 'question_category_description:not(0)',
		'type'      => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Activate the points by category?','wpqa'),
		'desc' => esc_html__('The points for categories enable or disable.','wpqa'),
		'id'   => 'active_points_category',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Activate the follow for categories and tags?','wpqa'),
		'desc' => esc_html__('Follow for categories and tags enable or disable.','wpqa'),
		'id'   => 'follow_category',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => esc_html__('Categories style at home and search pages','wpqa'),
		'desc'    => esc_html__('Choose the categories style.','wpqa'),
		'id'      => 'cat_style_pages',
		'options' => array(
			"with_icon"     => esc_html__("With icon","wpqa"),
			"icon_color"    => esc_html__("With icon and colors","wpqa"),
			'with_icon_1'   => esc_html__('With icon 2','wpqa'),
			'with_icon_2'   => esc_html__('With colored icon','wpqa'),
			'with_icon_3'   => esc_html__('With colored icon and box','wpqa'),
			'with_icon_4'   => esc_html__('With colored icon and box 2','wpqa'),
			'with_cover_1'  => esc_html__('With cover','wpqa'),
			'with_cover_2'  => esc_html__('With cover and icon','wpqa'),
			'with_cover_3'  => esc_html__('With cover and small icon','wpqa'),
			'with_cover_4'  => esc_html__('With big cover','wpqa'),
			'with_cover_5'  => esc_html__('With big cover and icon','wpqa'),
			'with_cover_6'  => esc_html__('With big cover and small icon','wpqa'),
			'simple_follow' => esc_html__('Simple with follow','wpqa'),
			'simple'        => esc_html__('Simple','wpqa'),
		),
		'std'     => 'simple_follow',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'name' => esc_html__('Request a new category','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Activate the users to request a new category','wpqa'),
		'id'   => 'allow_user_to_add_category',
		'std'  => 'on',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'allow_user_to_add_category:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Activate the unlogged users to request a new category.','wpqa'),
		'id'   => 'add_category_no_register',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Add category slug','wpqa'),
		'desc' => esc_html__('Put the add category slug.','wpqa'),
		'id'   => 'add_category_slug',
		'std'  => 'add-category',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '<a href="'.wpqa_add_category_permalink().'" target="_blank">'.esc_html__('The Link For The Add Category Page.','wpqa').'</a>',
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Send mail when the category needs a review','wpqa'),
		'desc' => esc_html__('Mail for category review enable or disable.','wpqa'),
		'id'   => 'send_email_add_category',
		'std'  => 'on',
		'type' => 'checkbox'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Category cover','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Activate the cover for categories?','wpqa'),
		'desc' => esc_html__('Cover for categories enable or disable.','wpqa'),
		'id'   => 'active_cover_category',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_cover_category:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Cover full width or fixed','wpqa'),
		'desc'    => esc_html__('Choose the cover to make it work with full width or fixed.','wpqa'),
		'id'      => 'cover_category_fixed',
		'options' => array(
			'normal' => esc_html__('Full width','wpqa'),
			'fixed'  => esc_html__('Fixed','wpqa'),
		),
		'std'     => 'normal',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'name'    => esc_html__('Select the share options','wpqa'),
		'id'      => 'cat_share',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $share_array,
		'options' => $share_array
	);

	$options[] = array(
		'name' => esc_html__('Default cover enable or disable.','wpqa'),
		'desc' => esc_html__("Select ON to upload your default cover for the categories which doesn't have cover.","wpqa"),
		'id'   => 'default_cover_cat_active',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Upload default cover for the categories.','wpqa'),
		'id'        => 'default_cover_cat',
		'condition' => 'default_cover_cat_active:not(0)',
		'type'      => 'upload'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Category tabs','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Activate the tabs for questions categories?','wpqa'),
		'desc' => esc_html__('The tabs for questions categories enable or disable.','wpqa'),
		'id'   => 'tabs_category',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'tabs_category:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Put here the exclude categories ids','wpqa'),
		'id'   => 'exclude_categories',
		'type' => 'text'
	);

	$category_tabs = array(
		"recent-questions"   => array("sort" => esc_html__('Recent Questions','wpqa'),"value" => "recent-questions"),
		"most-answers"       => array("sort" => esc_html__('Most Answered','wpqa'),"value" => "most-answers"),
		"answers"            => array("sort" => esc_html__('Answers','wpqa'),"value" => "answers"),
		"no-answers"         => array("sort" => esc_html__('No Answers','wpqa'),"value" => "no-answers"),
		"most-visit"         => array("sort" => esc_html__('Most Visited','wpqa'),"value" => "most-visit"),
		"most-vote"          => array("sort" => esc_html__('Most Voted','wpqa'),"value" => "most-vote"),
		"random"             => array("sort" => esc_html__('Random Questions','wpqa'),"value" => "random"),
		"question-bump"      => array("sort" => esc_html__('Bump Question','wpqa'),"value" => ""),
		"new-questions"      => array("sort" => esc_html__('New Questions','wpqa'),"value" => ""),
		"sticky-questions"   => array("sort" => esc_html__('Sticky Questions','wpqa'),"value" => ""),
		"polls"              => array("sort" => esc_html__('Poll Questions','wpqa'),"value" => ""),
		"followed"           => array("sort" => esc_html__('Followed Questions','wpqa'),"value" => ""),
		"favorites"          => array("sort" => esc_html__('Favorites Questions','wpqa'),"value" => ""),
		
		"recent-questions-2" => array("sort" => esc_html__('Recent Questions With Time','wpqa'),"value" => ""),
		"most-answers-2"     => array("sort" => esc_html__('Most Answered With Time','wpqa'),"value" => ""),
		"answers-2"          => array("sort" => esc_html__('Answers With Time','wpqa'),"value" => ""),
		"no-answers-2"       => array("sort" => esc_html__('No Answers With Time','wpqa'),"value" => ""),
		"most-visit-2"       => array("sort" => esc_html__('Most Visited With Time','wpqa'),"value" => ""),
		"most-vote-2"        => array("sort" => esc_html__('Most Voted With Time','wpqa'),"value" => ""),
		"random-2"           => array("sort" => esc_html__('Random Questions With Time','wpqa'),"value" => ""),
		"question-bump-2"    => array("sort" => esc_html__('Bump Question With Time','wpqa'),"value" => ""),
		"new-questions-2"    => array("sort" => esc_html__('New Questions With Time','wpqa'),"value" => ""),
		"sticky-questions-2" => array("sort" => esc_html__('Sticky Questions With Time','wpqa'),"value" => ""),
		"polls-2"            => array("sort" => esc_html__('Poll Questions With Time','wpqa'),"value" => ""),
		"followed-2"         => array("sort" => esc_html__('Followed Questions With Time','wpqa'),"value" => ""),
		"favorites-2"        => array("sort" => esc_html__('Favorites Questions With Time','wpqa'),"value" => ""),
	);

	$options[] = array(
		'name'    => esc_html__('Select the tabs you want to show','wpqa'),
		'id'      => 'category_tabs',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $category_tabs,
		'options' => $category_tabs
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'category_tabs:has(recent-questions-2),category_tabs:has(most-answers-2),category_tabs:has(question-bump-2),category_tabs:has(new-questions-2),category_tabs:has(sticky-questions-2),category_tabs:has(polls-2),category_tabs:has(followed-2),category_tabs:has(favorites-2),category_tabs:has(answers-2),category_tabs:has(most-visit-2),category_tabs:has(most-vote-2),category_tabs:has(random-2),category_tabs:has(no-answers-2)',
		'operator'  => 'or',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'      => esc_html__('Order by','wpqa'),
		'desc'      => esc_html__('Select the answers order by.','wpqa'),
		'id'        => "orderby_answers",
		'std'       => "recent",
		'condition' => 'category_tabs:has(answers)',
		'type'      => "radio",
		'options'   => array(
			'recent' => esc_html__('Recent','wpqa'),
			'oldest' => esc_html__('Oldest','wpqa'),
			'votes'  => esc_html__('Voted','wpqa'),
		)
	);

	$options[] = array(
		'type' => 'info',
		'name' => esc_html__('Time frame for the tabs','wpqa')
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for recent questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for recent questions tab.','wpqa'),
		'id'        => "date_recent_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(recent-questions-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for most answered tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for most answered tab.','wpqa'),
		'id'        => "date_most_answered",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(most-answers-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for bump question tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for bump question tab.','wpqa'),
		'id'        => "date_question_bump",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(question-bump-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for answers tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for answers tab.','wpqa'),
		'id'        => "date_answers",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(answers-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for most visited tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for most visited tab.','wpqa'),
		'id'        => "date_most_visited",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(most-visit-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for most voted tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for most voted tab.','wpqa'),
		'id'        => "date_most_voted",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(most-vote-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for no answers tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for no answers tab.','wpqa'),
		'id'        => "date_no_answers",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(no-answers-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for random questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for random questions tab.','wpqa'),
		'id'        => "date_random_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(random-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for new questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for new questions tab.','wpqa'),
		'id'        => "date_new_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(new-questions-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for sticky questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for sticky questions tab.','wpqa'),
		'id'        => "date_sticky_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(sticky-questions-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for poll questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for poll questions tab.','wpqa'),
		'id'        => "date_poll_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(polls-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for followed questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for followed questions tab.','wpqa'),
		'id'        => "date_followed_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(followed-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'name'      => esc_html__('Specific date for favorites questions tab.','wpqa'),
		'desc'      => esc_html__('Select the specific date for favorites questions tab.','wpqa'),
		'id'        => "date_favorites_questions",
		'std'       => "all",
		'type'      => "radio",
		'condition' => 'category_tabs:has(favorites-2)',
		'options'   => array(
			'all'   => esc_html__('All The Time','wpqa'),
			'24'    => esc_html__('Last 24 Hours','wpqa'),
			'48'    => esc_html__('Last 2 Days','wpqa'),
			'72'    => esc_html__('Last 3 Days','wpqa'),
			'96'    => esc_html__('Last 4 Days','wpqa'),
			'120'   => esc_html__('Last 5 Days','wpqa'),
			'144'   => esc_html__('Last 6 Days','wpqa'),
			'week'  => esc_html__('Last Week','wpqa'),
			'month' => esc_html__('Last Month','wpqa'),
			'year'  => esc_html__('Last Year','wpqa'),
		)
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'category_tabs:has(recent-questions),category_tabs:has(most-answers),category_tabs:has(question-bump),category_tabs:has(new-questions),category_tabs:has(sticky-questions),category_tabs:has(polls),category_tabs:has(followed),category_tabs:has(favorites),category_tabs:has(answers),category_tabs:has(most-visit),category_tabs:has(most-vote),category_tabs:has(random),category_tabs:has(no-answers),category_tabs:has(recent-questions-2),category_tabs:has(most-answers-2),category_tabs:has(question-bump-2),category_tabs:has(new-questions-2),category_tabs:has(sticky-questions-2),category_tabs:has(polls-2),category_tabs:has(followed-2),category_tabs:has(favorites-2),category_tabs:has(answers-2),category_tabs:has(most-visit-2),category_tabs:has(most-vote-2),category_tabs:has(random-2),category_tabs:has(no-answers-2)',
		'operator'  => 'or',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'type' => 'info',
		'name' => esc_html__('Custom setting for the slugs','wpqa')
	);

	$options[] = array(
		'name'      => esc_html__('Recent questions slug','wpqa'),
		'id'        => 'recent_questions_slug',
		'std'       => 'recent-questions',
		'condition' => 'category_tabs:has(recent-questions)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most answered slug','wpqa'),
		'id'        => 'most_answers_slug',
		'std'       => 'most-answered',
		'condition' => 'category_tabs:has(most-answers)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Bump question slug','wpqa'),
		'id'        => 'question_bump_slug',
		'std'       => 'question-bump',
		'condition' => 'category_tabs:has(question-bump)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('New questions slug','wpqa'),
		'id'        => 'question_new_slug',
		'std'       => 'new',
		'condition' => 'category_tabs:has(new-questions)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question sticky slug','wpqa'),
		'id'        => 'question_sticky_slug',
		'std'       => 'sticky',
		'condition' => 'category_tabs:has(sticky-questions)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question polls slug','wpqa'),
		'id'        => 'question_polls_slug',
		'std'       => 'polls',
		'condition' => 'category_tabs:has(polls)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question followed slug','wpqa'),
		'id'        => 'question_followed_slug',
		'std'       => 'followed',
		'condition' => 'category_tabs:has(followed)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question favorites slug','wpqa'),
		'id'        => 'question_favorites_slug',
		'std'       => 'favorites',
		'condition' => 'category_tabs:has(favorites)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Answers slug','wpqa'),
		'id'        => 'category_answers_slug',
		'std'       => 'answers',
		'condition' => 'category_tabs:has(answers)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most visited slug','wpqa'),
		'id'        => 'most_visit_slug',
		'std'       => 'most-visited',
		'condition' => 'category_tabs:has(most-visit)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most voted slug','wpqa'),
		'id'        => 'most_vote_slug',
		'std'       => 'most-voted',
		'condition' => 'category_tabs:has(most-vote)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Random slug','wpqa'),
		'id'        => 'random_slug',
		'std'       => 'random',
		'condition' => 'category_tabs:has(random)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('No answers slug','wpqa'),
		'id'        => 'no_answers_slug',
		'std'       => 'no-answers',
		'condition' => 'category_tabs:has(no-answers)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Recent questions with time slug','wpqa'),
		'id'        => 'recent_questions_slug_2',
		'std'       => 'recent-questions-time',
		'condition' => 'category_tabs:has(recent-questions-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most answered with time slug','wpqa'),
		'id'        => 'most_answers_slug_2',
		'std'       => 'most-answered-time',
		'condition' => 'category_tabs:has(most-answers-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Bump question with time slug','wpqa'),
		'id'        => 'question_bump_slug_2',
		'std'       => 'question-bump-time',
		'condition' => 'category_tabs:has(question-bump-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('New questions with time slug','wpqa'),
		'id'        => 'question_new_slug_2',
		'std'       => 'new-time',
		'condition' => 'category_tabs:has(new-questions-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question sticky with time slug','wpqa'),
		'id'        => 'question_sticky_slug_2',
		'std'       => 'sticky-time',
		'condition' => 'category_tabs:has(sticky-questions-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question polls with time slug','wpqa'),
		'id'        => 'question_polls_slug_2',
		'std'       => 'polls-time',
		'condition' => 'category_tabs:has(polls-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question followed with time slug','wpqa'),
		'id'        => 'question_followed_slug_2',
		'std'       => 'followed-time',
		'condition' => 'category_tabs:has(followed-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Question favorites with time slug','wpqa'),
		'id'        => 'question_favorites_slug_2',
		'std'       => 'favorites-time',
		'condition' => 'category_tabs:has(favorites-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Answers with time slug','wpqa'),
		'id'        => 'answers_slug_2',
		'std'       => 'answers-time',
		'condition' => 'category_tabs:has(answers-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most visited with time slug','wpqa'),
		'id'        => 'most_visit_slug_2',
		'std'       => 'most-visited-time',
		'condition' => 'category_tabs:has(most-visit-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Most voted with time slug','wpqa'),
		'id'        => 'most_vote_slug_2',
		'std'       => 'most-voted-time',
		'condition' => 'category_tabs:has(most-vote-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('Random with time slug','wpqa'),
		'id'        => 'random_slug_2',
		'std'       => 'random-time',
		'condition' => 'category_tabs:has(random-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'name'      => esc_html__('No answers with time slug','wpqa'),
		'id'        => 'no_answers_slug_2',
		'std'       => 'no-answers-time',
		'condition' => 'category_tabs:has(no-answers-2)',
		'type'      => 'text'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'questions_loop',
		'name' => esc_html__('Questions & Loop settings','wpqa')
	);
	
	$options[] = array(
		'name'      => esc_html__('Columns in the archive, taxonomy and tags pages','wpqa'),
		'id'		=> "question_columns",
		'type'		=> 'radio',
		'options'	=> array(
			'style_1' => esc_html__('1 column','wpqa'),
			'style_2' => esc_html__('2 columns','wpqa')." - ".esc_html__('Works with sidebar, full width, and left menu only.','wpqa'),
		),
		'std'		=> 'style_1'
	);
	
	$options[] = array(
		'name'      => esc_html__("Activate the masonry style?","wpqa"),
		'id'        => 'masonry_style',
		'type'      => 'checkbox',
		'condition' => 'question_columns:is(style_2)',
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the author image in questions loop?','wpqa'),
		'desc' => esc_html__('Enable or disable author image in questions loop?','wpqa'),
		'id'   => 'author_image',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the vote in loop?','wpqa'),
		'desc' => esc_html__('Enable or disable vote in loop?','wpqa'),
		'id'   => 'vote_question_loop',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Select ON to hide the dislike at questions loop','wpqa'),
		'desc'      => esc_html__('If you put it ON the dislike will not show.','wpqa'),
		'id'        => 'question_loop_dislike',
		'condition' => 'vote_question_loop:not(0)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to show the poll in questions loop','wpqa'),
		'id'   => 'question_poll_loop',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to hide the excerpt in questions','wpqa'),
		'id'   => 'excerpt_questions',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'excerpt_questions:is(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Excerpt question','wpqa'),
		'desc' => esc_html__('Put here the excerpt question.','wpqa'),
		'id'   => 'question_excerpt',
		'std'  => 40,
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to active the read more button in questions','wpqa'),
		'id'   => 'read_more_question',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Select ON to activate the read more by jQuery in questions','wpqa'),
		'id'        => 'read_jquery_question',
		'type'      => 'checkbox',
		'condition' => 'read_more_question:not(0)',
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to activate to see some answers and add a new answer by jQuery in questions','wpqa'),
		'id'   => 'answer_question_jquery',
		'type' => 'checkbox',
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Video','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Video description settings at the question loop','wpqa'),
		'desc' => esc_html__('Select ON if you want to let users to add video with their question.','wpqa'),
		'id'   => 'video_desc_active_loop',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'video_desc_active_loop:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Video description position at the question loop','wpqa'),
		'desc'    => esc_html__('Choose the video description position.','wpqa'),
		'id'      => 'video_desc_loop',
		'options' => array("before" => "Before content","after" => "After content"),
		'std'     => 'after',
		'type'    => 'select'
	);
	
	$options[] = array(
		'name' => esc_html__('Set the video description to 100%?','wpqa'),
		'desc' => esc_html__('Select ON if you want to set the video description to 100%.','wpqa'),
		'id'   => 'video_desc_100_loop',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		"name"      => esc_html__("Set the width for the video description for the questions","wpqa"),
		"id"        => "video_description_width",
		'condition' => 'video_desc_100_loop:not(on)',
		"type"      => "sliderui",
		'std'       => 260,
		"step"      => "1",
		"min"       => "50",
		"max"       => "600"
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the video description for the questions","wpqa"),
		"id"   => "video_description_height",
		"type" => "sliderui",
		'std'  => 500,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div'
	);

	$options[] = array(
		'name' => esc_html__('Featured image','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to show featured image in the questions','wpqa'),
		'id'   => 'featured_image_loop',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'featured_image_loop:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to enable the lightbox for featured image','wpqa'),
		'id'   => 'featured_image_question_lightbox',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		"name" => esc_html__("Set the width for the featured image for the questions","wpqa"),
		"id"   => "featured_image_question_width",
		"type" => "sliderui",
		'std'  => 260,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the featured image for the questions","wpqa"),
		"id"   => "featured_image_question_height",
		"type" => "sliderui",
		'std'  => 185,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		'name'    => esc_html__('Featured image position','wpqa'),
		'desc'    => esc_html__('Choose the featured image position.','wpqa'),
		'id'      => 'featured_position',
		'options' => array("before" => "Before content","after" => "After content"),
		'std'     => 'before',
		'type'    => 'select'
	);
	
	$options[] = array(
		'name'      => esc_html__('Poll position','wpqa'),
		'desc'      => esc_html__('Choose the poll position.','wpqa'),
		'id'        => 'poll_position',
		'condition' => 'featured_position:not(after)',
		'options'   => array("before" => "Before featured image","after" => "After featured image"),
		'std'       => 'before',
		'type'      => 'select'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable Tags at loop?','wpqa'),
		'id'   => 'question_tags_loop',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the answer at the loop by best answer, most voted, last answer or first answer','wpqa'),
		'id'   => 'question_answer_loop',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_answer_loop:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Answer type','wpqa'),
		'desc'    => esc_html__("Choose what's the answer you need to show from here.","wpqa"),
		'id'      => 'question_answer_show',
		'options' => array(
			'best'   => esc_html__('Best answer','wpqa'),
			'vote'   => esc_html__('Most voted','wpqa'),
			'last'   => esc_html__('Last answer','wpqa'),
			'oldest' => esc_html__('First answer','wpqa'),
		),
		'std'     => 'best',
		'type'    => 'radio'
	);

	$options[] = array(
		'name'    => esc_html__('Answer place','wpqa'),
		'desc'    => esc_html__("Choose where's the answer to be placed - before or after question meta.","wpqa"),
		'id'      => 'question_answer_place',
		'options' => array(
			'before' => esc_html__('Before question meta','wpqa'),
			'after'  => esc_html__('After question meta','wpqa'),
		),
		'std'     => 'before',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name'    => esc_html__('Pagination style','wpqa'),
		'desc'    => esc_html__('Choose pagination style from here.','wpqa'),
		'id'      => 'question_pagination',
		'options' => array(
			'standard'        => esc_html__('Standard','wpqa'),
			'pagination'      => esc_html__('Pagination','wpqa'),
			'load_more'       => esc_html__('Load more','wpqa'),
			'infinite_scroll' => esc_html__('Infinite scroll','wpqa'),
			'none'            => esc_html__('None','wpqa'),
		),
		'std'     => 'pagination',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Inner question','wpqa'),
		'id'   => 'inner_question',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_question_items:has(video_desc_active)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('video description position','wpqa'),
		'desc'    => esc_html__('Choose the video description position.','wpqa'),
		'id'      => 'video_desc',
		'options' => array("before" => esc_html__("Before content","wpqa"),"after" => esc_html__("After content","wpqa")),
		'std'     => 'after',
		'type'    => 'select'
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the video description for the questions","wpqa"),
		"id"   => "video_desc_height",
		"type" => "sliderui",
		'std'  => 500,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to show featured image in the single question','wpqa'),
		'id'   => 'featured_image_single',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'featured_image_single:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		"name" => esc_html__("Set the width for the featured image for the questions","wpqa"),
		"id"   => "featured_image_inner_question_width",
		"type" => "sliderui",
		'std'  => 260,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the featured image for the questions","wpqa"),
		"id"   => "featured_image_inner_question_height",
		"type" => "sliderui",
		'std'  => 185,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the author image in single?','wpqa'),
		'desc' => esc_html__('Author image in single enable or disable.','wpqa'),
		'id'   => 'author_image_single',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the vote in single?','wpqa'),
		'desc' => esc_html__('Vote in single enable or disable.','wpqa'),
		'id'   => 'vote_question_single',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Select ON to hide the dislike at questions single','wpqa'),
		'desc'      => esc_html__('If you put it ON the dislike will not show.','wpqa'),
		'id'        => 'question_single_dislike',
		'condition' => 'vote_question_single:not(0)',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate close and open questions','wpqa'),
		'desc' => esc_html__('Select ON if you want activate close and open questions.','wpqa'),
		'id'   => 'question_close',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate close and open questions for the admin only','wpqa'),
		'desc' => esc_html__('Select ON if you want activate close and open questions for the admin only.','wpqa'),
		'id'   => 'question_close_admin',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Share style at the inner question page.','wpqa'),
		'id'        => 'share_style',
		'std'       => 'style_1',
		'type'      => 'radio',
		'condition' => 'question_simple:not(on)',
		'options'   => 
			array(
				"style_1" => esc_html__("Style 1","wpqa"),
				"style_2" => esc_html__("Style 2","wpqa"),
			)
	);
	
	$options[] = array(
		'name' => esc_html__('Tags at single question enable or disable','wpqa'),
		'desc' => esc_html__('Select ON if you want active tags at single question.','wpqa'),
		'id'   => 'question_tags',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Navigation question enable or disable','wpqa'),
		'desc' => esc_html__('Navigation question (next and previous questions) enable or disable.','wpqa'),
		'id'   => 'question_navigation',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('Navigation question for the same category only?','wpqa'),
		'desc'      => esc_html__('Navigation question (next and previous questions) for the same category only?','wpqa'),
		'id'        => 'question_nav_category',
		'condition' => 'question_navigation:not(0)',
		'std'       => 'on',
		'type'      => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Answers enable or disable','wpqa'),
		'desc' => esc_html__('Select ON if you want activate the answers.','wpqa'),
		'id'   => 'question_answers',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('Related questions','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Related questions after content enable or disable','wpqa'),
		'desc' => esc_html__('Select ON if you want to activate the related questions after the content.','wpqa'),
		'id'   => 'question_related',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'question_related:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Number of items to show','wpqa'),
		'id'   => 'related_number_question',
		'type' => 'text',
		'std'  => '5'
	);
	
	$options[] = array(
		'name'    => esc_html__('Query type','wpqa'),
		'id'      => 'query_related_question',
		'options' => array(
			'categories' => esc_html__('Questions in the same categories','wpqa'),
			'tags'       => esc_html__('Questions in the same tags (If not found, questions with the same categories will be shown)','wpqa'),
			'author'     => esc_html__('Questions by the same author','wpqa'),
		),
		'std'     => 'categories',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'name' => esc_html__('Excerpt title in related questions','wpqa'),
		'desc' => esc_html__('Type excerpt title in related questions from here.','wpqa'),
		'id'   => 'related_title_question',
		'std'  => '20',
		'type' => 'text'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Share setting','wpqa'),
		'id'   => 'share_setting_q',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Select the share options','wpqa'),
		'id'      => 'question_share',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $share_array,
		'options' => $share_array
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Questions layout','wpqa'),
		'id'   => 'questions_layout',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Question sidebar layout','wpqa'),
		'id'   => "question_sidebar_layout",
		'std'  => "default",
		'type' => "images",
		'options' => array(
			'default'      => $imagepath.'sidebar_default.jpg',
			'menu_sidebar' => $imagepath.'menu_sidebar.jpg',
			'right'        => $imagepath.'sidebar_right.jpg',
			'full'         => $imagepath.'sidebar_no.jpg',
			'left'         => $imagepath.'sidebar_left.jpg',
			'centered'     => $imagepath.'centered.jpg',
			'menu_left'    => $imagepath.'menu_left.jpg',
		)
	);
	
	$options[] = array(
		'name'      => esc_html__('Question Page sidebar','wpqa'),
		'id'        => "question_sidebar",
		'std'       => '',
		'options'   => $new_sidebars,
		'type'      => 'select',
		'condition' => 'question_sidebar_layout:not(full),question_sidebar_layout:not(centered),question_sidebar_layout:not(menu_left)'
	);
	
	$options[] = array(
		'name'      => esc_html__('Question Page sidebar 2','wpqa'),
		'id'        => "question_sidebar_2",
		'std'       => '',
		'options'   => $new_sidebars,
		'type'      => 'select',
		'operator'  => 'or',
		'condition' => 'question_sidebar_layout:is(menu_sidebar),question_sidebar_layout:is(menu_left)'
	);
	
	$options[] = array(
		'name'    => esc_html__('Choose Your Skin','wpqa'),
		'class'   => "site_skin",
		'id'      => "question_skin",
		'std'     => "default",
		'type'    => "images",
		'options' => array(
			'default'    => $imagepath.'default_color.jpg',
			'skin'       => $imagepath.'default.jpg',
			'violet'     => $imagepath.'violet.jpg',
			'bright_red' => $imagepath.'bright_red.jpg',
			'green'      => $imagepath.'green.jpg',
			'red'        => $imagepath.'red.jpg',
			'cyan'       => $imagepath.'cyan.jpg',
			'blue'       => $imagepath.'blue.jpg',
		)
	);
	
	$options[] = array(
		'name' => esc_html__('Primary Color','wpqa'),
		'id'   => 'question_primary_color',
		'type' => 'color'
	);
	
	$options[] = array(
		'name'    => esc_html__('Background Type','wpqa'),
		'id'      => 'question_background_type',
		'std'     => 'default',
		'type'    => 'radio',
		'options' => 
			array(
				"default"           => esc_html__("Default","wpqa"),
				"none"              => esc_html__("None","wpqa"),
				"patterns"          => esc_html__("Patterns","wpqa"),
				"custom_background" => esc_html__("Custom Background","wpqa")
			)
	);

	$options[] = array(
		'name'      => esc_html__('Background Color','wpqa'),
		'id'        => 'question_background_color',
		'type'      => 'color',
		'condition' => 'question_background_type:is(patterns)'
	);
		
	$options[] = array(
		'name'      => esc_html__('Choose Pattern','wpqa'),
		'id'        => "question_background_pattern",
		'std'       => "bg13",
		'type'      => "images",
		'condition' => 'question_background_type:is(patterns)',
		'class'     => "pattern_images",
		'options'   => array(
			'bg1'  => $imagepath.'bg1.jpg',
			'bg2'  => $imagepath.'bg2.jpg',
			'bg3'  => $imagepath.'bg3.jpg',
			'bg4'  => $imagepath.'bg4.jpg',
			'bg5'  => $imagepath.'bg5.jpg',
			'bg6'  => $imagepath.'bg6.jpg',
			'bg7'  => $imagepath.'bg7.jpg',
			'bg8'  => $imagepath.'bg8.jpg',
			'bg9'  => $imagepath_theme.'patterns/bg9.png',
			'bg10' => $imagepath_theme.'patterns/bg10.png',
			'bg11' => $imagepath_theme.'patterns/bg11.png',
			'bg12' => $imagepath_theme.'patterns/bg12.png',
			'bg13' => $imagepath.'bg13.jpg',
			'bg14' => $imagepath.'bg14.jpg',
			'bg15' => $imagepath_theme.'patterns/bg15.png',
			'bg16' => $imagepath_theme.'patterns/bg16.png',
			'bg17' => $imagepath.'bg17.jpg',
			'bg18' => $imagepath.'bg18.jpg',
			'bg19' => $imagepath.'bg19.jpg',
			'bg20' => $imagepath.'bg20.jpg',
			'bg21' => $imagepath_theme.'patterns/bg21.png',
			'bg22' => $imagepath.'bg22.jpg',
			'bg23' => $imagepath_theme.'patterns/bg23.png',
			'bg24' => $imagepath_theme.'patterns/bg24.png',
		)
	);

	$options[] = array(
		'name'      => esc_html__('Custom Background','wpqa'),
		'id'        => 'question_custom_background',
		'std'       => $background_defaults,
		'type'      => 'background',
		'options'   => $background_defaults,
		'condition' => 'question_background_type:is(custom_background)'
	);
		
	$options[] = array(
		'name'      => esc_html__('Full Screen Background','wpqa'),
		'desc'      => esc_html__('Select ON to enable Full Screen Background','wpqa'),
		'id'        => 'question_full_screen_background',
		'type'      => 'checkbox',
		'condition' => 'question_background_type:is(custom_background)'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options = apply_filters('discy_options_after_questions_layout',$options);

	$options[] = array(
		'name'    => esc_html__('Popup share','wpqa'),
		'id'      => 'popup_share',
		'icon'    => 'share',
		'type'    => 'heading',
	);

	$options[] = array(
		'type' => 'heading-2',
	);

	$options[] = array(
		'name' => esc_html__('Activate the popup share for the posts and questions?','wpqa'),
		'desc' => esc_html__('Popup share for the posts and questions enable or disable.','wpqa'),
		'id'   => 'active_popup_share',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_popup_share:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Select which page do you need it to work','wpqa'),
		'id'      => 'popup_share_pages',
		'type'    => 'multicheck',
		'std'     => array(
			"questions" => "questions",
			"posts"     => "posts",
		),
		'options' => array(
			"questions" => esc_html__('Questions','wpqa'),
			"posts"     => esc_html__("Posts","wpqa"),
		)
	);

	$options[] = array(
		'name'    => esc_html__('Popup share works for "unlogged users", "logged in users", or "unlogged users" and "logged in users"','wpqa'),
		'id'      => 'popup_share_users',
		'std'     => 'both',
		'type'    => 'radio',
		'options' => 
			array(
				"unlogged" => esc_html__('Unlogged users','wpqa'),
				"logged"   => esc_html__('Logged users','wpqa'),
				"both"     => esc_html__('Unlogged and logged in users','wpqa')
		)
	);

	$options[] = array(
		'name'    => esc_html__('Popup share shows only for the owner only or for all','wpqa'),
		'id'      => 'popup_share_type',
		'std'     => 'all',
		'type'    => 'radio',
		'options' => 
			array(
				"all"   => esc_html__('For all','wpqa'),
				"owner" => esc_html__('Owner','wpqa')
		)
	);

	$options[] = array(
		'name'    => esc_html__('Popup share works when visiting the questions and posts or when scroll down to comments or to the adding comment box','wpqa'),
		'id'      => 'popup_share_visits',
		'std'     => 'visit',
		'type'    => 'radio',
		'options' => 
			array(
				"visit"  => esc_html__('Visiting','wpqa'),
				"scroll" => esc_html__('Scroll down','wpqa')
		)
	);

	$options[] = array(
		"name"      => esc_html__("How many seconds to show the popup share for?","wpqa"),
		"desc"      => esc_html__("Type here the seconds to show the popup share and leave it to 0 to show when open the question or post.","wpqa"),
		"id"        => "popup_share_seconds",
		"type"      => "sliderui",
		'std'       => "30",
		"step"      => "1",
		"min"       => "0",
		"max"       => "60",
		"condition" => "popup_share_visits:is(visit)",
	);

	$options[] = array(
		'name'    => esc_html__('Popup share shows per day, week, month, or forever','wpqa'),
		'id'      => 'popup_share_shows',
		'std'     => 'day',
		'type'    => 'radio',
		'options' => 
			array(
				"day"     => esc_html__('Day','wpqa'),
				"week"    => esc_html__('Week','wpqa'),
				"month"   => esc_html__('Month','wpqa'),
				"forever" => esc_html__('Forever','wpqa')
		)
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options[] = array(
		'name'    => esc_html__('Category moderators','wpqa'),
		'id'      => 'category_moderators',
		'icon'    => 'businessperson',
		'type'    => 'heading',
	);

	$options[] = array(
		'type' => 'heading-2',
	);

	$options[] = array(
		'name' => esc_html__('Activate the moderators for categories?','wpqa'),
		'desc' => esc_html__('Moderators for categories enable or disable.','wpqa'),
		'id'   => 'active_moderators',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_moderators:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('User pending questions slug','wpqa'),
		'desc' => esc_html__('Put the user pending questions slug.','wpqa'),
		'id'   => 'pending_questions_slug',
		'std'  => 'pending-questions',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('User pending posts slug','wpqa'),
		'desc' => esc_html__('Put the user pending posts slug.','wpqa'),
		'id'   => 'pending_posts_slug',
		'std'  => 'pending-posts',
		'type' => 'text'
	);

	$options[] = array(
		'name'    => esc_html__('Select the moderators permissions','wpqa'),
		'id'      => 'moderators_permissions',
		'type'    => 'multicheck',
		'std'     => array(
			"delete"  => "delete",
			"approve" => "approve",
			"edit"    => "edit",
			"ban"     => "ban",
		),
		'options' => array(
			"delete"  => esc_html__('Delete questions or posts','wpqa'),
			"approve" => esc_html__('Approve questions or posts','wpqa'),
			"edit"    => esc_html__('Edit questions or posts','wpqa'),
			"ban"     => esc_html__("Ban users","wpqa"),
		)
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$paymeny_setting = array(
		"payments_settings" => esc_html__('Payment setting','wpqa'),
		"pay_to_ask"        => esc_html__('Pay to ask','wpqa'),
		"pay_to_sticky"     => esc_html__('Pay for sticky question','wpqa'),
		"pay_to_answer"     => esc_html__('Pay to answer','wpqa'),
		"subscriptions"     => esc_html__('Subscriptions','wpqa'),
		"pay_to_post"       => esc_html__('Pay to post','wpqa'),
		"buy_points"        => esc_html__('Buy points','wpqa'),
		"pay_to_users"      => esc_html__('Pay to users','wpqa'),
		"coupons_setting"   => esc_html__('Coupon settings','wpqa'),
	);

	$options[] = array(
		'name'    => esc_html__('Payment settings','wpqa'),
		'id'      => 'payment_setting',
		'icon'    => 'tickets-alt',
		'type'    => 'heading',
		'std'     => 'payments_settings',
		'options' => apply_filters("discy_payment_setting",$paymeny_setting)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'payments_settings',
		'name' => esc_html__('Payment setting','wpqa')
	);

	$options[] = array(
		'name' => esc_html__('Checkout slug','wpqa'),
		'desc' => esc_html__('Put the checkout slug.','wpqa'),
		'id'   => 'checkout_slug',
		'std'  => 'checkout',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable the transactions page for the users','wpqa'),
		'desc' => esc_html__('Click ON to activate the transactions page for the users to show their transactions on the site.','wpqa'),
		'id'   => 'transactions_page',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '<a href="'.wpqa_get_checkout_permalink().'" target="_blank">'.esc_html__('The Link For The Checkout Page.','wpqa').'</a>',
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable the transactions of the payments with points saved in the statements','wpqa'),
		'desc' => esc_html__('Click ON to activate the transactions of the payments with points saved in the statements.','wpqa'),
		'id'   => 'save_pay_by_points',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => esc_html__('Payment style','wpqa'),
		'desc'    => esc_html__('Choose the payment style for the design.','wpqa'),
		'id'      => 'payment_style',
		'std'     => 'style_1',
		'type'    => 'radio',
		'options' => 
			array(
				"style_1" => esc_html__('Style 1','wpqa'),
				"style_2" => esc_html__('Style 2','wpqa')
		)
	);

	$options[] = array(
		'name'     => esc_html__('Custom text after the payment button','wpqa'),
		'id'       => 'custom_text_payment',
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);

	$payment_methods = array(
		"paypal" => array("sort" => esc_html__('PayPal','wpqa'),"value" => "paypal"),
		"stripe" => array("sort" => esc_html__('Stripe','wpqa'),"value" => "stripe"),
		"bank"   => array("sort" => esc_html__('Bank Transfer','wpqa'),"value" => "bank"),
		"custom" => array("sort" => esc_html__('Custom Payment','wpqa'),"value" => "custom"),
	);

	$payment_methods_std = array(
		"paypal" => array("sort" => esc_html__('PayPal','wpqa'),"value" => "paypal"),
		"stripe" => array("sort" => esc_html__('Stripe','wpqa'),"value" => "stripe"),
	);
	
	$options[] = array(
		'name'    => esc_html__('Select the payment methods','wpqa'),
		'id'      => 'payment_methodes',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $payment_methods_std,
		'options' => $payment_methods,
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_methodes:has(paypal)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('PayPal','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Upload your PayPal logo','wpqa'),
		'desc' => esc_html__('Upload your custom logo for the PayPal.','wpqa'),
		'id'   => 'paypal_logo',
		'std'  => $imagepath_theme."logo.png",
		'type' => 'upload',
	);

	$options[] = array(
		'std'      => esc_url(home_url('/'))."?action=paypal",
		'name'     => esc_html__("Put this link at IPN","wpqa"),
		'readonly' => 'readonly',
		'type'     => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable PayPal sandbox','wpqa'),
		'desc' => esc_html__('PayPal sandbox can be used to test payments.','wpqa'),
		'id'   => 'paypal_sandbox',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'paypal_sandbox:is(on)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__("PayPal email","wpqa"),
		'desc' => esc_html__("put your PayPal email","wpqa"),
		'id'   => 'paypal_email_sandbox',
		'std'  => get_bloginfo("admin_email"),
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__("PayPal Identity Token","wpqa"),
		'desc' => esc_html__("Add your PayPal Identity Token","wpqa"),
		'id'   => 'identity_token_sandbox',
		'type' => 'text'
	);

	$options[] = array(
		'name' => sprintf(__('Enter your PayPal API credentials. Learn how to access your <a target="_blank" href="%s">PayPal API Credentials</a>.','wpqa'),'https://developer.paypal.com/webapps/developer/docs/classic/api/apiCredentials/#create-an-api-signature'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API username","wpqa"),
		'desc' => esc_html__("Add your PayPal live API username","wpqa"),
		'id'   => 'paypal_api_username_sandbox',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API password","wpqa"),
		'desc' => esc_html__("Add your PayPal live API password","wpqa"),
		'id'   => 'paypal_api_password_sandbox',
		'type' => 'password'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API signature","wpqa"),
		'desc' => esc_html__("Add your PayPal live API signature","wpqa"),
		'id'   => 'paypal_api_signature_sandbox',
		'type' => 'password'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'paypal_sandbox:is(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__("PayPal email","wpqa"),
		'desc' => esc_html__("put your PayPal email","wpqa"),
		'id'   => 'paypal_email',
		'std'  => get_bloginfo("admin_email"),
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__("PayPal Identity Token","wpqa"),
		'desc' => esc_html__("Add your PayPal Identity Token","wpqa"),
		'id'   => 'identity_token',
		'type' => 'text'
	);

	$options[] = array(
		'name' => sprintf(__('Enter your PayPal API credentials. Learn how to access your <a target="_blank" href="%s">PayPal API Credentials</a>.','wpqa'),'https://developer.paypal.com/docs/archive/nvp-soap-api/apiCredentials/#create-an-api-signature'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API username","wpqa"),
		'desc' => esc_html__("Add your PayPal live API username","wpqa"),
		'id'   => 'paypal_api_username',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API password","wpqa"),
		'desc' => esc_html__("Add your PayPal live API password","wpqa"),
		'id'   => 'paypal_api_password',
		'type' => 'password'
	);
	
	$options[] = array(
		'name' => esc_html__("Live API signature","wpqa"),
		'desc' => esc_html__("Add your PayPal live API signature","wpqa"),
		'id'   => 'paypal_api_signature',
		'type' => 'password'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_methodes:has(stripe)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Stripe','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Publishable key','wpqa'),
		'id'   => 'publishable_key',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Secret key','wpqa'),
		'id'   => 'secret_key',
		'type' => 'text'
	);

	$options[] = array(
		'std'      => esc_url(home_url('/'))."?action=stripe",
		'name'     => esc_html__("Put this link at webhooks","wpqa"),
		'readonly' => 'readonly',
		'type'     => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Activate the address info','wpqa'),
		'desc' => esc_html__("Select ON to active the address info, it's very important for some countries to activate it.","wpqa"),
		'id'   => 'stripe_address',
		'type' => 'checkbox'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_methodes:has(bank)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Bank transfer','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name'     => esc_html__('Bank transfer details','wpqa'),
		'id'       => 'bank_transfer_details',
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_methodes:has(custom)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Custom Payment','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		"name" => esc_html__("Custom payment tab name","wpqa"),
		"id"   => "custom_payment_tab",
		"type" => "text",
		'std'  => "Custom payment"
	);
	
	$options[] = array(
		'name'     => esc_html__('Custom payment details','wpqa'),
		'id'       => 'custom_payment_details',
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Currencies','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name'    => esc_html__('Default currency code','wpqa'),
		'desc'    => esc_html__('Choose form here the default currency code.','wpqa'),
		'id'      => 'currency_code',
		'std'     => 'USD',
		'type'    => "select",
		'options' => $currencies
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the multi currencies','wpqa'),
		'desc' => esc_html__('Select ON to activate multi currencies.','wpqa'),
		'id'   => 'activate_currencies',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'       => esc_html__('Select the multi currencies','wpqa'),
		'id'         => 'multi_currencies',
		'type'       => 'multicheck',
		'strtolower' => 'not',
		'condition'  => 'activate_currencies:not(0)',
		'options'    => $currencies,
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to ask','wpqa'),
		'id'   => 'pay_to_ask',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to ask question','wpqa'),
		'desc' => esc_html__('Select ON to activate pay to ask question.','wpqa'),
		'id'   => 'pay_ask',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'pay_ask:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Payment way','wpqa'),
		'desc'    => esc_html__('Choose the payment way for the ask question','wpqa'),
		'id'      => 'payment_type_ask',
		'std'     => 'payments',
		'type'    => 'radio',
		'options' => array(
			"payments"        => esc_html__('Payment methods','wpqa'),
			"points"          => esc_html__('By points','wpqa'),
			"payments_points" => esc_html__('Payment methods and points','wpqa')
		)
	);

	$options[] = array(
		'name'    => esc_html__('Question payment style','wpqa'),
		'desc'    => esc_html__('Choose the asking question payment style','wpqa'),
		'id'      => 'ask_payment_style',
		'std'     => 'once',
		'type'    => 'radio',
		'options' => array(
			"once"     => esc_html__('Once payment','wpqa'),
			"packages" => esc_html__('Packages payment','wpqa')
		)
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_payment_style:is(packages)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_ask:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);

	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$ask_packages_price[] = array(
					"name" => esc_html__("With price for","wpqa")." ".$value_currency,
					"id"   => "package_price_".strtolower($value_currency),
					"type" => "text",
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	if ($activate_currencies != "on" || ($activate_currencies == "on" && !isset($ask_packages_price))) {
		$ask_packages_price = array(array(
			"type" => "text",
			"id"   => "package_price",
			"name" => esc_html__('With price','wpqa')
		));
	}

	$ask_packages_array = array(
		array(
			"type" => "text",
			"id"   => "package_name",
			"name" => esc_html__('Package name','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_description",
			"name" => esc_html__('Package description','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_posts",
			"name" => esc_html__('Package questions','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_points",
			"name" => esc_html__('With points','wpqa')
		),
		array(
			'type' => 'checkbox',
			"id"   => "sticky",
			"name" => esc_html__('Make any question in this package sticky','wpqa')
		),
		array(
			"type"      => "slider",
			"name"      => esc_html__("How many days would you like to make the question sticky?","wpqa"),
			"id"        => "days_sticky",
			"std"       => "7",
			"step"      => "1",
			"min"       => "1",
			"max"       => "365",
			"value"     => "1",
			'condition' => '[%id%]sticky:is(on)',
		),
	);

	$ask_packages_elements = array_merge($ask_packages_array,$ask_packages_price);

	$options[] = array(
		'id'      => "ask_packages",
		'type'    => "elements",
		'sort'    => "no",
		'hide'    => "yes",
		'button'  => esc_html__('Add a new package','wpqa'),
		'options' => $ask_packages_elements,
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'ask_payment_style:not(packages)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		"name"      => esc_html__("What's the price to ask a new question?","wpqa"),
		"desc"      => esc_html__("Type here price to ask a new question","wpqa"),
		"id"        => "pay_ask_payment",
		"type"      => "text",
		'condition' => 'payment_type_ask:not(points),activate_currencies:is(0)',
		'std'       => 10
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_ask:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to ask a new question?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "pay_ask_payment_".strtolower($value_currency),
					"type" => "text",
					'std'  => 10
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		"name"      => esc_html__("How many points to ask a new question?","wpqa"),
		"desc"      => esc_html__("Type here points of the payment to ask a new question","wpqa"),
		"id"        => "ask_payment_points",
		"type"      => "text",
		'condition' => 'payment_type_ask:has(points),payment_type_ask:has(payments_points)',
		'operator'  => 'or',
		'std'       => 20
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay for sticky question','wpqa'),
		'id'   => 'pay_to_sticky',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay for sticky question at the top','wpqa'),
		'desc' => esc_html__('Select ON to active the pay for sticky question.','wpqa'),
		'id'   => 'pay_to_sticky',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'pay_to_sticky:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Payment way','wpqa'),
		'desc'    => esc_html__('Choose the payment way for the sticky the question','wpqa'),
		'id'      => 'payment_type_sticky',
		'std'     => 'payments',
		'type'    => 'radio',
		'options' => array(
			"payments"        => esc_html__('Payment methods','wpqa'),
			"points"          => esc_html__('By points','wpqa'),
			"payments_points" => esc_html__('Payment methods and points','wpqa')
		)
	);

	$options[] = array(
		"name"      => esc_html__("What is the price to make the question sticky?","wpqa"),
		"desc"      => esc_html__("Type here the price of the payment to make the question sticky.","wpqa"),
		"id"        => "pay_sticky_payment",
		"type"      => "text",
		'condition' => 'payment_type_sticky:not(points),activate_currencies:is(0)',
		'std'       => 5
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_ask:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What is the price to make the question sticky?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "pay_sticky_payment_".strtolower($value_currency),
					"type" => "text",
					'std'  => 5
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		"name"      => esc_html__("How many points to make the question sticky?","wpqa"),
		"desc"      => esc_html__("Type here points of the payment to sticky the question","wpqa"),
		"id"        => "sticky_payment_points",
		"type"      => "text",
		'condition' => 'payment_type_sticky:has(points),payment_type_sticky:has(payments_points)',
		'operator'  => 'or',
		'std'       => 10
	);
	
	$options[] = array(
		"name" => esc_html__("How many days would you like to make the question sticky?","wpqa"),
		"desc" => esc_html__("Type here days of the payment to sticky the question.","wpqa"),
		"id"   => "days_sticky",
		"type" => "sliderui",
		'std'  => "7",
		"step" => "1",
		"min"  => "1",
		"max"  => "365"
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to answer','wpqa'),
		'id'   => 'pay_to_answer',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to add answer','wpqa'),
		'desc' => esc_html__('Select ON to activate pay to answer.','wpqa'),
		'id'   => 'pay_answer',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'pay_answer:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Payment way','wpqa'),
		'desc'    => esc_html__('Choose the payment way for the answer','wpqa'),
		'id'      => 'payment_type_answer',
		'std'     => 'payments',
		'type'    => 'radio',
		'options' => array(
			"payments"        => esc_html__('Payment methods','wpqa'),
			"points"          => esc_html__('By points','wpqa'),
			"payments_points" => esc_html__('Payment methods and points','wpqa')
		)
	);
	
	$options[] = array(
		"name"      => esc_html__("What's the price to add a new answer?","wpqa"),
		"desc"      => esc_html__("Type here price to add a new answer","wpqa"),
		"id"        => "pay_answer_payment",
		"type"      => "text",
		'condition' => 'payment_type_answer:not(points),activate_currencies:is(0)',
		'std'       => 10
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_answer:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to add a new answer?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "pay_answer_payment_".strtolower($value_currency),
					"type" => "text",
					'std'  => 10
				);
			}
		}
	}
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		"name"      => esc_html__("How many points to add a new answer?","wpqa"),
		"desc"      => esc_html__("Type here points of the payment to add a new answer","wpqa"),
		"id"        => "answer_payment_points",
		"type"      => "text",
		'condition' => 'payment_type_answer:has(points),payment_type_answer:has(payments_points)',
		'operator'  => 'or',
		'std'       => 20
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Subscriptions','wpqa'),
		'id'   => 'subscriptions',
		'type' => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Subscriptions','wpqa'),
		'desc' => esc_html__('Select ON to activate subscriptions.','wpqa'),
		'id'   => 'subscriptions_payment',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_payment:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Subscriptions slug','wpqa'),
		'desc' => esc_html__('Put the subscriptions slug.','wpqa'),
		'id'   => 'subscriptions_slug',
		'std'  => 'subscriptions',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '<a href="'.wpqa_subscriptions_permalink().'" target="_blank">'.esc_html__('The Link For The Subscriptions Page.','wpqa').'</a>',
		'type' => 'info'
	);

	$options[] = array(
		'name' => '<a href="https://2code.info/docs/discy/subscription/" target="_blank">'.esc_html__('To make the paid subscriptions work well, check this link.','wpqa').'</a>',
		'type' => 'info'
	);

	$options[] = array(
		'name'    => esc_html__('Payment way','wpqa'),
		'desc'    => esc_html__('Choose the payment way for the subscriptions','wpqa'),
		'id'      => 'payment_type_subscriptions',
		'std'     => 'payments',
		'type'    => 'radio',
		'options' => array(
			"payments"        => esc_html__('Payment methods','wpqa'),
			"points"          => esc_html__('By points','wpqa'),
			"payments_points" => esc_html__('Payment methods and points','wpqa')
		)
	);

	$options[] = array(
		'name'    => esc_html__('Paid role for the subscriptions','wpqa'),
		'desc'    => esc_html__('Select the paid role for the subscriptions','wpqa'),
		'id'      => 'subscriptions_group',
		'std'     => 'author',
		'type'    => 'select',
		'options' => discy_options_roles()
	);

	$options[] = array(
		'name' => esc_html__('Cancel the subscription','wpqa'),
		'desc' => esc_html__('Select ON to active the cancel subscription button for the users.','wpqa'),
		'id'   => 'cancel_subscription',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Change the subscription plans','wpqa'),
		'desc' => esc_html__('Select ON to activate the change subscription plans for the users.','wpqa'),
		'id'   => 'change_subscription',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Trial subscription plans','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Allow the users to try the subscription plans','wpqa'),
		'desc' => esc_html__('Select ON to activate to allow the users to try the subscription plans.','wpqa'),
		'id'   => 'trial_subscription',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'trial_subscription:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Select the options for the free trial subscriptions','wpqa'),
		'id'      => 'trial_subscription_plan',
		'type'    => 'radio',
		'std'     => 'hour',
		'options' => array(
			"hour"  => esc_html__('Hour','wpqa'),
			"week"  => esc_html__('Week','wpqa'),
			"month" => esc_html__('Month','wpqa'),
		)
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of hours, weeks, or months for the trial plan','wpqa'),
		"id"   => "trial_subscription_rang",
		"type" => "sliderui",
		'std'  => '2',
		"step" => "1",
		"min"  => "1",
		"max"  => "10"
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Reward subscription','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Allow the users to join the subscription plans based on the activities','wpqa'),
		'desc' => esc_html__('Select ON to allow the users to join the subscription plans based on activities like asking questions and adding answers.','wpqa'),
		'id'   => 'reward_subscription',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'reward_subscription:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name'    => esc_html__('Select the plan to allow the user to join it automatically based on the activities','wpqa'),
		'id'      => 'reward_subscription_plan',
		'type'    => 'radio',
		'std'     => 'month',
		'options' => array(
			"week"  => esc_html__('Week','wpqa'),
			"month" => esc_html__('Month','wpqa'),
		)
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of weeks, or months for the reward plan','wpqa'),
		"id"   => "reward_subscription_rang",
		"type" => "sliderui",
		'std'  => '1',
		"step" => "1",
		"min"  => "1",
		"max"  => "12"
	);

	$options[] = array(
		'name' => esc_html__("Note: anything you don't need for the reward subscription only put on it 0","wpqa"),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of questions in the month to join the paid subscription plan','wpqa'),
		"id"   => "reward_questions_subscription",
		"type" => "text",
		'std'  => 40,
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of answers in the month to join the paid subscription plan','wpqa'),
		"id"   => "reward_answers_subscription",
		"type" => "text",
		'std'  => 100,
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of best answers in the month to join the paid subscription plan','wpqa'),
		"id"   => "reward_best_answers_subscription",
		"type" => "text",
		'std'  => 20,
	);

	$options[] = array(
		'name' => esc_html__('Choose the number of posts in the month to join the paid subscription plan','wpqa'),
		"id"   => "reward_posts_subscription",
		"type" => "text",
		'std'  => 30,
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Subscription plans','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name'    => esc_html__('Select the options for the subscriptions','wpqa'),
		'id'      => 'subscriptions_options',
		'type'    => 'multicheck',
		'std'     => array(
			"monthly"  => "monthly",
			"3months"  => "3months",
			"6months"  => "6months",
			"yearly"   => "yearly",
			"lifetime" => "lifetime",
		),
		'options' => array(
			"monthly"  => esc_html__('Monthly','wpqa'),
			"3months"  => esc_html__('Three months','wpqa'),
			"6months"  => esc_html__('Six months','wpqa'),
			"yearly"   => esc_html__('Yearly','wpqa'),
			"2years"  => esc_html__('Two years','wpqa'),
			"lifetime" => esc_html__('Lifetime','wpqa'),
		)
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'activate_currencies:is(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe monthly?",'wpqa'),
		"id"        => "subscribe_monthly",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(monthly)',
		'std'       => 10
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe for three months?",'wpqa'),
		"id"        => "subscribe_3months",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(3months)',
		'std'       => 25
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe for six months?",'wpqa'),
		"id"        => "subscribe_6months",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(6months)',
		'std'       => 45
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe yearly?",'wpqa'),
		"id"        => "subscribe_yearly",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(yearly)',
		'std'       => 80
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe for two years?",'wpqa'),
		"id"        => "subscribe_2years",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(2years)',
		'std'       => 80
	);

	$options[] = array(
		"name"      => esc_html__("What's the price to subscribe lifetime?",'wpqa'),
		"id"        => "subscribe_lifetime",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(lifetime)',
		'std'       => 200
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(monthly)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe monthly?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_monthly_".strtolower($value_currency),
					"type" => "text",
					'std'  => 10
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(3months)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe three months?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_3months_".strtolower($value_currency),
					"type" => "text",
					'std'  => 25
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(6months)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe six months?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_6months_".strtolower($value_currency),
					"type" => "text",
					'std'  => 45
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(yearly)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe yearly?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_yearly_".strtolower($value_currency),
					"type" => "text",
					'std'  => 80
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(2years)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe for two years?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_2years_".strtolower($value_currency),
					"type" => "text",
					'std'  => 80
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'subscriptions_options:has(lifetime)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to subscribe lifetime?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "subscribe_lifetime_".strtolower($value_currency),
					"type" => "text",
					'std'  => 200
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options = apply_filters("discy_filter_after_subscription",$options);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_subscriptions:has(points),payment_type_subscriptions:has(payments_points)',
		'operator'  => 'or',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__("Price with points to allow the users to subscribe","wpqa"),
		'type' => 'info'
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe monthly?",'wpqa'),
		"id"        => "subscribe_monthly_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(monthly)',
		'std'       => 100
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe for three months?",'wpqa'),
		"id"        => "subscribe_3months_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(3months)',
		'std'       => 250
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe for six months?",'wpqa'),
		"id"        => "subscribe_6months_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(6months)',
		'std'       => 400
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe yearly?",'wpqa'),
		"id"        => "subscribe_yearly_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(yearly)',
		'std'       => 700
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe for two years?",'wpqa'),
		"id"        => "subscribe_2years_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(2years)',
		'std'       => 700
	);

	$options[] = array(
		"name"      => esc_html__("What's the points to subscribe for lifetime?",'wpqa'),
		"id"        => "subscribe_lifetime_points",
		"type"      => "text",
		'condition' => 'subscriptions_options:has(lifetime)',
		'std'       => 2000
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to post','wpqa'),
		'id'   => 'pay_to_post',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to add post','wpqa'),
		'desc' => esc_html__('Select ON to activate the pay to add post.','wpqa'),
		'id'   => 'pay_post',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'pay_post:not(0)',
		'type'      => 'heading-2'
	);

	$options = apply_filters("discy_filter_inner_pay_post",$options);

	$options[] = array(
		'name'    => esc_html__('Payment way','wpqa'),
		'desc'    => esc_html__('Choose the payment way for the add post','wpqa'),
		'id'      => 'payment_type_post',
		'std'     => 'payments',
		'type'    => 'radio',
		'options' => array(
			"payments"        => esc_html__('Payment methods','wpqa'),
			"points"          => esc_html__('By points','wpqa'),
			"payments_points" => esc_html__('Payment methods and points','wpqa')
		)
	);

	$options[] = array(
		'name'    => esc_html__('Post payment style','wpqa'),
		'desc'    => esc_html__('Choose the adding post payment style','wpqa'),
		'id'      => 'post_payment_style',
		'std'     => 'once',
		'type'    => 'radio',
		'options' => array(
			"once"     => esc_html__('Once payment','wpqa'),
			"packages" => esc_html__('Packages payment','wpqa')
		)
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'post_payment_style:is(packages)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_post:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);

	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$post_packages_price[] = array(
					"name" => esc_html__("With price for","wpqa")." ".$value_currency,
					"id"   => "package_price_".strtolower($value_currency),
					"type" => "text",
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	if ($activate_currencies != "on" || ($activate_currencies == "on" && !isset($post_packages_price))) {
		$post_packages_price = array(array(
			"type" => "text",
			"id"   => "package_price",
			"name" => esc_html__('With price','wpqa')
		));
	}

	$post_packages_array = array(
		array(
			"type" => "text",
			"id"   => "package_name",
			"name" => esc_html__('Package name','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_description",
			"name" => esc_html__('Package description','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_posts",
			"name" => esc_html__('Package posts','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_points",
			"name" => esc_html__('With points','wpqa')
		),
		array(
			'type' => 'checkbox',
			"id"   => "sticky",
			"name" => esc_html__('Make any post in this package sticky','wpqa')
		),
		array(
			"type"      => "slider",
			"name"      => esc_html__("How many days would you like to make the post sticky?","wpqa"),
			"id"        => "days_sticky",
			"std"       => "7",
			"step"      => "1",
			"min"       => "1",
			"max"       => "365",
			"value"     => "1",
			'condition' => '[%id%]sticky:is(on)',
		),
	);

	$post_packages_elements = array_merge($post_packages_array,$post_packages_price);

	$options[] = array(
		'id'      => "post_packages",
		'type'    => "elements",
		'sort'    => "no",
		'hide'    => "yes",
		'button'  => esc_html__('Add a new package','wpqa'),
		'options' => $post_packages_elements,
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'post_payment_style:not(packages)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		"name"      => esc_html__("What's the price to add a new post?","wpqa"),
		"desc"      => esc_html__("Type here price to add a new post","wpqa"),
		"id"        => "pay_post_payment",
		"type"      => "text",
		'condition' => 'payment_type_post:not(points),activate_currencies:is(0)',
		'std'       => 10
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_post:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		$options[] = array(
			'name' => esc_html__("What's the price to add a new post?","wpqa"),
			'type' => 'info'
		);
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$options[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "pay_post_payment_".strtolower($value_currency),
					"type" => "text",
					'std'  => 10
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		"name"      => esc_html__("How many points to add a new post?","wpqa"),
		"desc"      => esc_html__("Type here points of the payment to add a new post","wpqa"),
		"id"        => "post_payment_points",
		"type"      => "text",
		'condition' => 'payment_type_post:has(points),payment_type_post:has(payments_points)',
		'operator'  => 'or',
		'std'       => 20
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Buy points','wpqa'),
		'id'   => 'buy_points',
		'type' => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Buy points','wpqa'),
		'desc' => esc_html__('Select ON to activate buy points.','wpqa'),
		'id'   => 'buy_points_payment',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'buy_points_payment:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Buy points slug','wpqa'),
		'desc' => esc_html__('Put the buy points slug.','wpqa'),
		'id'   => 'buy_points_slug',
		'std'  => 'buy-points',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '<a href="'.wpqa_buy_points_permalink().'" target="_blank">'.esc_html__('The Link For The Buy Points Page.','wpqa').'</a>',
		'type' => 'info'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'payment_type_ask:not(points),activate_currencies:not(0)',
		'type'      => 'heading-2'
	);
	
	if (is_array($multi_currencies) && !empty($multi_currencies)) {
		foreach ($multi_currencies as $key_currency => $value_currency) {
			if ($value_currency != "0") {
				$buy_points_price[] = array(
					"name" => esc_html__("Price for","wpqa")." ".$value_currency,
					"id"   => "package_price_".strtolower($value_currency),
					"type" => "text",
				);
			}
		}
	}

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	if ($activate_currencies != "on" || ($activate_currencies == "on" && !isset($buy_points_price))) {
		$buy_points_price = array(array(
			"type" => "text",
			"id"   => "package_price",
			"name" => esc_html__('Price','wpqa')
		));
	}

	$buy_points_array = array(
		array(
			"type" => "text",
			"id"   => "package_name",
			"name" => esc_html__('Package name','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_points",
			"name" => esc_html__('Points','wpqa')
		),
		array(
			"type" => "text",
			"id"   => "package_description",
			"name" => esc_html__('Package description','wpqa')
		)
	);

	$buy_points_elements = array_merge($buy_points_array,$buy_points_price);
	
	$options[] = array(
		'id'      => "buy_points",
		'type'    => "elements",
		'sort'    => "no",
		'hide'    => "yes",
		'button'  => esc_html__('Add a new package','wpqa'),
		'options' => $buy_points_elements,
	);

	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Pay to users','wpqa'),
		'id'   => 'pay_to_users',
		'type' => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Pay money to users','wpqa'),
		'desc' => esc_html__('Select ON to activate pay money to users.','wpqa'),
		'id'   => 'activate_pay_to_users',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'activate_pay_to_users:not(0)',
		'type'      => 'heading-2'
	);

	$edit_profile_items_5 = array(
		'paypal'   => array('sort' => esc_html__('PayPal','wpqa'),'value' => 'paypal'),
		'payoneer' => array('sort' => esc_html__('Payoneer','wpqa'),'value' => 'payoneer'),
		'bank'     => array('sort' => esc_html__('Bank Transfer','wpqa'),'value' => 'bank'),
	);
	
	$options[] = array(
		'name'    => esc_html__('Select what to show at edit profile to pay money for the users section','wpqa'),
		'id'      => 'edit_profile_items_5',
		'type'    => 'multicheck',
		'sort'    => 'yes',
		'std'     => $edit_profile_items_5,
		'options' => $edit_profile_items_5
	);

	$options[] = array(
		'name' => esc_html__("Number of points to be converted to money?","wpqa"),
		'id'   => 'pay_minimum_points',
		'type' => 'text',
		'std'  => 100
	);

	$options[] = array(
		'name' => esc_html__("What's the minimum money to allow the user to make the payment?","wpqa"),
		'id'   => 'pay_minimum_money',
		'type' => 'text',
		'std'  => 50
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options = apply_filters('discy_options_before_coupons_setting',$options);
	
	$options[] = array(
		'name' => esc_html__('Coupon settings','wpqa'),
		'id'   => 'coupons_setting',
		'type' => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate the Coupons','wpqa'),
		'desc' => esc_html__('Select ON to activate the coupons.','wpqa'),
		'id'   => 'active_coupons',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_coupons:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Show the free coupons when making any payment?','wpqa'),
		'desc' => esc_html__('Select ON to show the free coupons.','wpqa'),
		'id'   => 'free_coupons',
		'type' => 'checkbox'
	);
	
	$coupon_elements = array(
		array(
			"type" => "text",
			"id"   => "coupon_name",
			"name" => esc_html__('Coupons name','wpqa')
		),
		array(
			"type"    => "select",
			"id"      => "coupon_type",
			"name"    => esc_html__('Discount type','wpqa'),
			"options" => array("discount" => esc_html__("Discount","wpqa"),"percent" => esc_html__("% Percent","wpqa"))
		),
		array(
			"type" => "text",
			"id"   => "coupon_amount",
			"name" => esc_html__('Amount','wpqa')
		),
		array(
			"type" => "date",
			"id"   => "coupon_date",
			"name" => esc_html__('Expiry date','wpqa')
		)
	);
	
	$options[] = array(
		'id'      => "coupons",
		'type'    => "elements",
		'sort'    => "no",
		'hide'    => "yes",
		'button'  => esc_html__('Add a new coupon','wpqa'),
		'options' => $coupon_elements,
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options = apply_filters('discy_options_after_coupons_setting',$options);

	$groups_settings = array(
		"general_setting_g" => esc_html__('General settings','wpqa'),
		"group_slugs"       => esc_html__('Group slugs','wpqa'),
		"add_edit_delete_g" => esc_html__('Add - Edit - Delete','wpqa'),
		"group_posts"       => esc_html__('Group posts','wpqa'),
		"groups_layout"     => esc_html__('Groups layout','wpqa')
	);

	$options[] = array(
		'name'    => esc_html__('Group settings','wpqa'),
		'id'      => 'group',
		'icon'    => 'groups',
		'type'    => 'heading',
		'std'     => 'general_setting_g',
		'options' => apply_filters("discy_groups_settings",$groups_settings)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'general_setting_g',
		'name' => esc_html__('General settings','wpqa')
	);

	$options[] = array(
		'name' => esc_html__('Activate the groups','wpqa'),
		'id'   => 'active_groups',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_groups:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Activate the group rules in the top page of the group','wpqa'),
		'id'   => 'active_rules_groups',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name'    => esc_html__('Pagination style','wpqa'),
		'desc'    => esc_html__('Choose pagination style from here.','wpqa'),
		'id'      => 'group_pagination',
		'options' => array(
			'standard'        => esc_html__('Standard','wpqa'),
			'pagination'      => esc_html__('Pagination','wpqa'),
			'load_more'       => esc_html__('Load more','wpqa'),
			'infinite_scroll' => esc_html__('Infinite scroll','wpqa'),
			'none'            => esc_html__('None','wpqa'),
		),
		'std'     => 'pagination',
		'type'    => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'group_slugs',
		'name' => esc_html__('Group slugs','wpqa')
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_groups:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Groups archive slug','wpqa'),
		'desc' => esc_html__('Add your groups archive slug.','wpqa'),
		'id'   => 'archive_group_slug',
		'std'  => 'groups',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Group slug','wpqa'),
		'desc' => esc_html__('Add your group slug.','wpqa'),
		'id'   => 'group_slug',
		'std'  => 'group',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('User requests slug','wpqa'),
		'desc' => esc_html__('Add your user requests slug.','wpqa'),
		'id'   => 'group_requests_slug',
		'std'  => 'user-requests',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Group posts slug','wpqa'),
		'desc' => esc_html__('Add your group posts slug.','wpqa'),
		'id'   => 'posts_group_slug',
		'std'  => 'pending-posts',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Group users slug','wpqa'),
		'desc' => esc_html__('Add your group users slug.','wpqa'),
		'id'   => 'group_users_slug',
		'std'  => 'group-users',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Group admins slug','wpqa'),
		'desc' => esc_html__('Add your group admins slug.','wpqa'),
		'id'   => 'group_admins_slug',
		'std'  => 'group-admins',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Blocked user slug','wpqa'),
		'desc' => esc_html__('Add your blocked user slug.','wpqa'),
		'id'   => 'blocked_users_slug',
		'std'  => 'blocked-users',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('View group post slug','wpqa'),
		'desc' => esc_html__('Add your view group post slug.','wpqa'),
		'id'   => 'view_posts_group_slug',
		'std'  => 'view-post-group',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__('Edit group post slug','wpqa'),
		'desc' => esc_html__('Add your edit group post slug.','wpqa'),
		'id'   => 'edit_posts_group_slug',
		'std'  => 'edit-post-group',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'add_edit_delete_g',
		'name' => esc_html__('Add - Edit - Delete','wpqa')
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'active_groups:not(0)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Add groups','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Add group slug','wpqa'),
		'desc' => esc_html__('Put the add group slug.','wpqa'),
		'id'   => 'add_groups_slug',
		'std'  => 'add-group',
		'type' => 'text'
	
	);

	$options[] = array(
		'name' => '<a href="'.wpqa_add_group_permalink().'" target="_blank">'.esc_html__('Link For The Add Group Page.','wpqa').'</a>',
		'type' => 'info'
	);

	$options[] = array(
		'name'    => esc_html__('Choose group status for users only','wpqa'),
		'desc'    => esc_html__('Choose group status after the user publishes the group.','wpqa'),
		'id'      => 'group_publish',
		'options' => array("publish" => esc_html__("Publish","wpqa"),"draft" => esc_html__("Draft","wpqa")),
		'std'     => 'publish',
		'type'    => 'select'
	);
	
	$options[] = array(
		'name'      => esc_html__('Send mail when the group needs a review','wpqa'),
		'desc'      => esc_html__('Mail for groups review enable or disable.','wpqa'),
		'id'        => 'send_email_draft_groups',
		'std'       => 'on',
		'condition' => 'group_publish:not(publish)',
		'type'      => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Activate Terms of Service and privacy policy page?','wpqa'),
		'desc' => esc_html__('Select ON if you want active Terms of Service and privacy policy page.','wpqa'),
		'id'   => 'terms_active_group',
		'type' => 'checkbox'
	);

	$options[] = array(
		'div'       => 'div',
		'condition' => 'terms_active_group:is(on)',
		'type'      => 'heading-2'
	);

	$options[] = array(
		'name' => esc_html__('Terms of Service and Privacy Policy','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name'    => esc_html__('Open the page in same page or a new page?','wpqa'),
		'id'      => 'terms_active_target_group',
		'std'     => "new_page",
		'type'    => 'select',
		'options' => array("same_page" => esc_html__("Same page","wpqa"),"new_page" => esc_html__("New page","wpqa"))
	);
	
	$options[] = array(
		'name'    => esc_html__('Terms page','wpqa'),
		'desc'    => esc_html__('Select the terms page','wpqa'),
		'id'      => 'terms_page_group',
		'type'    => 'select',
		'options' => $options_pages
	);
	
	$options[] = array(
		'name' => esc_html__("Type the terms link if you don't like a page","wpqa"),
		'id'   => 'terms_link_group',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate Privacy Policy','wpqa'),
		'desc' => esc_html__('Select ON if you want to activate Privacy Policy.','wpqa'),
		'id'   => 'privacy_policy_group',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'privacy_policy_group:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name'    => esc_html__('Open the page in same page or a new page?','wpqa'),
		'id'      => 'privacy_active_target_group',
		'std'     => "new_page",
		'type'    => 'select',
		'options' => array("same_page" => esc_html__("Same page","wpqa"),"new_page" => esc_html__("New page","wpqa"))
	);
	
	$options[] = array(
		'name'    => esc_html__('Privacy Policy page','wpqa'),
		'desc'    => esc_html__('Select the privacy policy page','wpqa'),
		'id'      => 'privacy_page_group',
		'type'    => 'select',
		'options' => $options_pages
	);
	
	$options[] = array(
		'name' => esc_html__("Type the privacy policy link if you don't like a page","wpqa"),
		'id'   => 'privacy_link_group',
		'type' => 'text'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Edit groups','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can edit the groups','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to edit the groups.','wpqa'),
		'id'   => 'group_edit',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'group_edit:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Edit group slug','wpqa'),
		'desc' => esc_html__('Put the edit group slug.','wpqa'),
		'id'   => 'edit_groups_slug',
		'std'  => 'edit-group',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => esc_html__('After edit auto approve group or need to be approved again?','wpqa'),
		'desc' => esc_html__('Press ON to auto approve','wpqa'),
		'id'   => 'group_approved',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => esc_html__('After the group is edited change the URL from the title?','wpqa'),
		'desc' => esc_html__('Press ON to edit the URL','wpqa'),
		'id'   => 'change_group_url',
		'std'  => 'on',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Delete groups','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can delete the groups','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to delete the groups.','wpqa'),
		'id'   => 'group_delete',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('When the users delete the group send to the trash or delete it forever?','wpqa'),
		'id'        => 'delete_group',
		'options'   => array(
			'delete' => esc_html__('Delete','wpqa'),
			'trash'  => esc_html__('Trash','wpqa'),
		),
		'std'       => 'delete',
		'condition' => 'group_delete:not(0)',
		'type'      => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'group_posts',
		'name' => esc_html__('Group posts','wpqa')
	);

	$options[] = array(
		'name'      => esc_html__('Send mail when the posts on the group needs a review','wpqa'),
		'desc'      => esc_html__('Mail for posts on the group review enable or disable.','wpqa'),
		'id'        => 'send_email_draft_group_posts',
		'std'       => 'on',
		'type'      => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Activate user can edit the group posts','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to edit the group posts.','wpqa'),
		'id'   => 'posts_edit',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'posts_edit:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('After edit auto approve group posts or need to be approved again?','wpqa'),
		'desc' => esc_html__('Press ON to auto approve','wpqa'),
		'id'   => 'posts_approved',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => esc_html__("Choose if you want to allow the users to see the users on the group for public or private groups.","wpqa"),
		'id'      => 'view_users_group',
		'type'    => 'multicheck',
		'options' => array(
			"public"  => esc_html__("Public","wpqa"),
			"private" => esc_html__("Private","wpqa"),
		),
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable the editor for details in group posts form','wpqa'),
		'id'   => 'editor_group_posts',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Featured image for the group posts','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable the featured image in group posts form','wpqa'),
		'id'   => 'featured_image_group_posts',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'featured_image_group_posts:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to enable the lightbox for featured image','wpqa'),
		'desc' => esc_html__('Select ON to enable the lightbox for featured image.','wpqa'),
		'id'   => 'featured_image_group_posts_lightbox',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		"name" => esc_html__("Set the width for the featured image for the answers","wpqa"),
		"id"   => "featured_image_group_posts_width",
		"type" => "sliderui",
		'std'  => 260,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the featured image for the answers","wpqa"),
		"id"   => "featured_image_group_posts_height",
		"type" => "sliderui",
		'std'  => 185,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable the editor for the comments in the group posts','wpqa'),
		'id'   => 'editor_group_post_comments',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__('Featured image for the comments on the group posts','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Enable or disable the featured image for the comments in the group posts','wpqa'),
		'id'   => 'featured_image_group_post_comments',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'div'       => 'div',
		'condition' => 'featured_image_group_post_comments:not(0)',
		'type'      => 'heading-2'
	);
	
	$options[] = array(
		'name' => esc_html__('Select ON to enable the lightbox for featured image','wpqa'),
		'desc' => esc_html__('Select ON to enable the lightbox for featured image.','wpqa'),
		'id'   => 'featured_image_group_post_comments_lightbox',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		"name" => esc_html__("Set the width for the featured image for the answers","wpqa"),
		"id"   => "featured_image_group_post_comments_width",
		"type" => "sliderui",
		'std'  => 260,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		"name" => esc_html__("Set the height for the featured image for the answers","wpqa"),
		"id"   => "featured_image_group_post_comments_height",
		"type" => "sliderui",
		'std'  => 185,
		"step" => "1",
		"min"  => "50",
		"max"  => "600"
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'div'  => 'div',
		'end'  => 'end'
	);

	$options[] = array(
		'name' => esc_html__('Edit group posts and comments','wpqa'),
		'type' => 'info'
	);

	$options[] = array(
		'name'    => esc_html__("Choose the roles you allow for the owner of the group and moderators.","wpqa"),
		'id'      => 'edit_delete_posts_comments',
		'type'    => 'multicheck',
		'options' => array(
			"edit"   => esc_html__("Edit posts and comments","wpqa"),
			"delete" => esc_html__("Delete posts and comments","wpqa"),
		),
	);

	$options[] = array(
		'name' => esc_html__('Delete group posts','wpqa'),
		'type' => 'info'
	);
	
	$options[] = array(
		'name' => esc_html__('Activate user can delete the group posts','wpqa'),
		'desc' => esc_html__('Select ON if you want the user to be able to delete the group posts.','wpqa'),
		'id'   => 'posts_delete',
		'std'  => "on",
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'      => esc_html__('When the users delete the group posts send to the trash or delete it forever?','wpqa'),
		'id'        => 'delete_posts',
		'options'   => array(
			'delete' => esc_html__('Delete','wpqa'),
			'trash'  => esc_html__('Trash','wpqa'),
		),
		'std'       => 'delete',
		'condition' => 'posts_delete:not(0)',
		'type'      => 'radio'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'groups_layout',
		'name' => esc_html__('Group layout','wpqa')
	);

	$options[] = array(
		'name' => esc_html__('Group sidebar layout','wpqa'),
		'id'   => "group_sidebar_layout",
		'std'  => "default",
		'type' => "images",
		'options' => array(
			'default'      => $imagepath.'sidebar_default.jpg',
			'menu_sidebar' => $imagepath.'menu_sidebar.jpg',
			'right'        => $imagepath.'sidebar_right.jpg',
			'full'         => $imagepath.'sidebar_no.jpg',
			'left'         => $imagepath.'sidebar_left.jpg',
			'centered'     => $imagepath.'centered.jpg',
			'menu_left'    => $imagepath.'menu_left.jpg',
		)
	);
	
	$options[] = array(
		'name'      => esc_html__('Group Page sidebar','wpqa'),
		'id'        => "group_sidebar",
		'std'       => '',
		'options'   => $new_sidebars,
		'type'      => 'select',
		'condition' => 'group_sidebar_layout:not(full),group_sidebar_layout:not(centered),group_sidebar_layout:not(menu_left)'
	);
	
	$options[] = array(
		'name'      => esc_html__('Group Page sidebar 2','wpqa'),
		'id'        => "group_sidebar_2",
		'std'       => '',
		'options'   => $new_sidebars,
		'type'      => 'select',
		'operator'  => 'or',
		'condition' => 'group_sidebar_layout:is(menu_sidebar),group_sidebar_layout:is(menu_left)'
	);
	
	$options[] = array(
		'name'    => esc_html__('Choose Your Skin','wpqa'),
		'class'   => "site_skin",
		'id'      => "group_skin",
		'std'     => "default",
		'type'    => "images",
		'options' => array(
			'default'    => $imagepath.'default_color.jpg',
			'skin'       => $imagepath.'default.jpg',
			'violet'     => $imagepath.'violet.jpg',
			'bright_red' => $imagepath.'bright_red.jpg',
			'green'      => $imagepath.'green.jpg',
			'red'        => $imagepath.'red.jpg',
			'cyan'       => $imagepath.'cyan.jpg',
			'blue'       => $imagepath.'blue.jpg',
		)
	);
	
	$options[] = array(
		'name' => esc_html__('Primary Color','wpqa'),
		'id'   => 'group_primary_color',
		'type' => 'color'
	);
	
	$options[] = array(
		'name'    => esc_html__('Background Type','wpqa'),
		'id'      => 'group_background_type',
		'std'     => 'default',
		'type'    => 'radio',
		'options' => 
			array(
				"default"           => esc_html__("Default","wpqa"),
				"none"              => esc_html__("None","wpqa"),
				"patterns"          => esc_html__("Patterns","wpqa"),
				"custom_background" => esc_html__("Custom Background","wpqa")
			)
	);

	$options[] = array(
		'name'      => esc_html__('Background Color','wpqa'),
		'id'        => 'group_background_color',
		'type'      => 'color',
		'condition' => 'group_background_type:is(patterns)'
	);
		
	$options[] = array(
		'name'      => esc_html__('Choose Pattern','wpqa'),
		'id'        => "group_background_pattern",
		'std'       => "bg13",
		'type'      => "images",
		'condition' => 'group_background_type:is(patterns)',
		'class'     => "pattern_images",
		'options'   => array(
			'bg1'  => $imagepath.'bg1.jpg',
			'bg2'  => $imagepath.'bg2.jpg',
			'bg3'  => $imagepath.'bg3.jpg',
			'bg4'  => $imagepath.'bg4.jpg',
			'bg5'  => $imagepath.'bg5.jpg',
			'bg6'  => $imagepath.'bg6.jpg',
			'bg7'  => $imagepath.'bg7.jpg',
			'bg8'  => $imagepath.'bg8.jpg',
			'bg9'  => $imagepath_theme.'patterns/bg9.png',
			'bg10' => $imagepath_theme.'patterns/bg10.png',
			'bg11' => $imagepath_theme.'patterns/bg11.png',
			'bg12' => $imagepath_theme.'patterns/bg12.png',
			'bg13' => $imagepath.'bg13.jpg',
			'bg14' => $imagepath.'bg14.jpg',
			'bg15' => $imagepath_theme.'patterns/bg15.png',
			'bg16' => $imagepath_theme.'patterns/bg16.png',
			'bg17' => $imagepath.'bg17.jpg',
			'bg18' => $imagepath.'bg18.jpg',
			'bg19' => $imagepath.'bg19.jpg',
			'bg20' => $imagepath.'bg20.jpg',
			'bg21' => $imagepath_theme.'patterns/bg21.png',
			'bg22' => $imagepath.'bg22.jpg',
			'bg23' => $imagepath_theme.'patterns/bg23.png',
			'bg24' => $imagepath_theme.'patterns/bg24.png',
		)
	);

	$options[] = array(
		'name'      => esc_html__('Custom Background','wpqa'),
		'id'        => 'group_custom_background',
		'std'       => $background_defaults,
		'type'      => 'background',
		'options'   => $background_defaults,
		'condition' => 'group_background_type:is(custom_background)'
	);
		
	$options[] = array(
		'name'      => esc_html__('Full Screen Background','wpqa'),
		'desc'      => esc_html__('Select ON to enable Full Screen Background','wpqa'),
		'id'        => 'group_full_screen_background',
		'type'      => 'checkbox',
		'condition' => 'group_background_type:is(custom_background)'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);

	$options = apply_filters('discy_options_after_groups_layout',$options);

	return $options;
}?>