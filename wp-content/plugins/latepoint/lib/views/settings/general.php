<div class="latepoint-settings-w os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Appointment Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[default_booking_status]', __('Default Appointment Status', 'latepoint'), OsBookingHelper::get_statuses_list(), OsBookingHelper::get_default_booking_status(), array('placeholder' => __('Set Default Status', 'latepoint'))); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[time_system]', __('Time System', 'latepoint'), OsTimeHelper::get_time_systems_list_for_select(), OsTimeHelper::get_time_system()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[date_format]', __('Date Format', 'latepoint'), OsTimeHelper::get_date_formats_list_for_select(), OsSettingsHelper::get_date_format()); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::text_field('settings[timeblock_interval]', __('Selectable Time Intervals in Minutes', 'latepoint'), OsSettingsHelper::get_default_timeblock_interval()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::checkbox_field('settings[show_booking_end_time]', __('Show Appointment End Time', 'latepoint'), 'on', OsSettingsHelper::is_on('show_booking_end_time')); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::checkbox_field('settings[disable_verbose_date_output]', __('Disable Verbose Date Output', 'latepoint'), 'on', OsSettingsHelper::is_on('disable_verbose_date_output')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Restrictions', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="latepoint-message latepoint-message-subtle"><?php _e('You can set restrictions on earliest/latest dates in the future when your customer can place an appointment. You can either use a relative values like for example "+1 month", "+5 days", "+2 weeks", or you can use a fixed date in format YYYY-MM-DD. Leave blank to remove any limitations.', 'latepoint'); ?></div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[earliest_possible_booking]', __('Earliest Possible Booking', 'latepoint'), OsSettingsHelper::get_settings_value('earliest_possible_booking')); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[latest_possible_booking]', __('Latest Possible Booking', 'latepoint'), OsSettingsHelper::get_settings_value('latest_possible_booking')); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[max_future_bookings_per_customer]', __('Maximum Number of Future Bookings per Customer', 'latepoint'), OsSettingsHelper::get_settings_value('max_future_bookings_per_customer')); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::checkbox_field('settings[one_location_at_time]', __('Agents can only be present in one location at a time', 'latepoint'), 'on', OsSettingsHelper::is_on('one_location_at_time')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Currency Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[currency_symbol_before]', __('Currency symbol in front of price', 'latepoint'), OsSettingsHelper::get_settings_value('currency_symbol_before', '$')); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[currency_symbol_after]', __('Currency symbol after the price', 'latepoint'), OsSettingsHelper::get_settings_value('currency_symbol_after')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Phone Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[phone_format]', __('Phone Input Mask', 'latepoint'), OsSettingsHelper::get_phone_format()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::checkbox_field('settings[disable_phone_formatting]', __('Disable Phone Formatting', 'latepoint'), 'on', OsUtilHelper::is_phone_formatting_disabled()); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[country_phone_code]', __('Phone code for your country', 'latepoint'), OsSettingsHelper::get_country_phone_code()); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Appearance Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[color_scheme_for_booking_form]', __('Color Scheme for Booking Form', 'latepoint'), ['blue' => 'Blue', 'black' => 'Black', 'teal' => 'Teal', 'green' => 'Green', 'purple' => 'Purple', 'red' => 'Red', 'orange' => 'Orange'], OsSettingsHelper::get_booking_form_color_scheme()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[border_radius]', __('Border Style', 'latepoint'), ['rounded' => 'Rounded Corners', 'flat' => 'Flat'], OsSettingsHelper::get_booking_form_border_radius()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[time_pick_style]', __('Show Time Slots as', 'latepoint'), ['timeline' => 'Timeline', 'timebox' => 'Time Boxes'], OsSettingsHelper::get_time_pick_style()); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-12">
            <?php echo OsFormHelper::checkbox_field('settings[hide_timepicker_when_one_slot_available]', __('Do not show time picker when only one time slot is available', 'latepoint'), 'on', OsSettingsHelper::is_on('hide_timepicker_when_one_slot_available')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Setup Pages', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[page_url_customer_dashboard]', __('Customer Dashboard Page URL', 'latepoint'), OsSettingsHelper::get_customer_dashboard_url()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[page_url_customer_login]', __('Customer Login Page URL', 'latepoint'), OsSettingsHelper::get_customer_login_url()); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Customer Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content no-padding">
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Cancellation', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
            <?php echo OsFormHelper::toggler_field('settings[allow_customer_booking_cancellation]', __('Allow customers cancel their bookings', 'latepoint'), OsSettingsHelper::is_on('allow_customer_booking_cancellation'), 'cancellation_settings'); ?>
            <div id="cancellation_settings" <?php echo OsSettingsHelper::is_on('allow_customer_booking_cancellation') ? '' : 'style="display:none"' ?>>
              <?php echo OsFormHelper::toggler_field('settings[limit_when_customer_can_cancel]', __('Set restriction on when customer can cancel', 'latepoint'), OsSettingsHelper::is_on('limit_when_customer_can_cancel'), 'cancellation_limit_settings'); ?>
            </div>
            <div id="cancellation_limit_settings" <?php echo OsSettingsHelper::is_on('limit_when_customer_can_cancel') ? '' : 'style="display:none"' ?>>
              <div class="merged-fields">
                <div class="merged-label"><?php _e('At least', 'latepoint'); ?></div>
                <?php echo OsFormHelper::text_field('settings[cancellation_limit_value]', false, OsSettingsHelper::get_settings_value('cancellation_limit_value', 5), ['placeholder' => __('Value', 'latepoint')]); ?>
                <?php echo OsFormHelper::select_field('settings[cancellation_limit_unit]', false, 
                                                      array( 'minute' => __('minutes', 'latepoint'), 
                                                              'hour' => __('hours', 'latepoint'),
                                                              'day' => __('days', 'latepoint')), 
                                                      OsSettingsHelper::get_settings_value('cancellation_limit_unit', 'hour')); ?>
                <div class="merged-label"><?php _e('before appointment time', 'latepoint'); ?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Authentication', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
            <?php echo OsFormHelper::toggler_field('settings[wp_users_as_customers]', __('Use WordPress users as customers', 'latepoint'), OsSettingsHelper::is_on('wp_users_as_customers')); ?>
            <?php echo OsFormHelper::toggler_field('settings[steps_require_setting_password]', __('Require Customers to Set Account Password', 'latepoint'), OsSettingsHelper::is_on('steps_require_setting_password')); ?>
            <?php echo OsFormHelper::toggler_field('settings[steps_hide_login_register_tabs]', __('Remove Login/Register Tabs on Contact Info Step', 'latepoint'), OsSettingsHelper::is_on('steps_hide_login_register_tabs')); ?>
            <?php echo OsFormHelper::toggler_field('settings[steps_hide_registration_prompt]', __('Hide "Create Account" Prompt on Confirmation Step', 'latepoint'), OsSettingsHelper::is_on('steps_hide_registration_prompt')); ?>
          </div>
        </div>
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Social Login', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
            <?php echo OsFormHelper::toggler_field('settings[enable_google_login]', __('Enable Login with Google', 'latepoint'), (OsSettingsHelper::get_settings_value('enable_google_login') == 'on'), 'lp-google-settings'); ?>
            <div id="lp-google-settings" <?php echo (OsSettingsHelper::get_settings_value('enable_google_login') == 'on') ? '' : 'style="display: none;"' ?>>
              <?php echo OsFormHelper::text_field('settings[google_client_id]', __('Google Client ID', 'latepoint'), OsSettingsHelper::get_settings_value('google_client_id')); ?>
              <?php echo OsFormHelper::password_field('settings[google_client_secret]', __('Google Client Secret', 'latepoint'), OsSettingsHelper::get_settings_value('google_client_secret')); ?>
            </div>
            <?php echo OsFormHelper::toggler_field('settings[enable_facebook_login]', __('Enable Login with Facebook', 'latepoint'), (OsSettingsHelper::get_settings_value('enable_facebook_login') == 'on'), 'lp-facebook-settings'); ?>
            <div id="lp-facebook-settings" <?php echo (OsSettingsHelper::get_settings_value('enable_facebook_login') == 'on') ? '' : 'style="display: none;"' ?>>
              <?php echo OsFormHelper::text_field('settings[facebook_app_id]', __('Facebook App ID', 'latepoint'), OsSettingsHelper::get_settings_value('facebook_app_id')); ?>
              <?php echo OsFormHelper::password_field('settings[facebook_app_secret]', __('Facebook App Secret', 'latepoint'), OsSettingsHelper::get_settings_value('facebook_app_secret')); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Other Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[day_calendar_min_height]', __('Daily Calendar Minimum Height (in pixels)', 'latepoint'), OsSettingsHelper::get_day_calendar_min_height()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[customer_dashboard_book_shortcode]', __('Shortcode for a book button on customer dashboard', 'latepoint'), OsSettingsHelper::get_settings_value('customer_dashboard_book_shortcode', '[latepoint_book_button]')); ?>
          </div>
        </div>
        <div class="latepoint-message latepoint-message-subtle"><?php _e('You can use variables in your booking template, they will be replaced with a value for the booking. ', 'latepoint-google-calendar') ?><?php echo OsUtilHelper::template_variables_link_html(); ?></div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[booking_template_for_calendar]', __('Booking template to display on calendar', 'latepoint'), OsSettingsHelper::get_booking_template_for_calendar()); ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo OsFormHelper::button('submit', __('Save Settings', 'latepoint'), 'submit', ['class' => 'latepoint-btn']); ?>
  </form>
</div>