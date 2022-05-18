<div class="os-form-sub-header"><h3><?php _e('Step Editing', 'latepoint'); ?></h3></div>
<div class="steps-ordering-w" data-step-order-update-route="<?php echo OsRouterHelper::build_route_name('settings', 'udpate_order_of_steps'); ?>">
	<?php
	foreach($steps as $step){
		OsStepsHelper::output_step_edit_form($step);
	}
	?>
</div>
<?php if(!apply_filters('latepoint_can_add_custom_steps', false)){ ?>
	<?php /* ?>
	<a href="<?php echo OsRouterHelper::build_link(['addons', 'index']); ?>" class="os-add-box" >
    <div class="add-box-graphic-w"><div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div></div>
    <div class="add-box-label"><?php _e('Install Custom Steps Add-on', 'latepoint'); ?></div>
  </a>
  */ ?>
  <?php
}else{
	do_action('latepoint_settings_steps_list_after');
} ?>
<div class="os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
  	<div class="white-box">
      <div class="white-box-header">
	      <div class="os-form-sub-header"><h3><?php _e('Booking Process Settings', 'latepoint'); ?></h3></div>
	    </div>
      <div class="white-box-content no-padding">
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Agent Display', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
						<?php echo OsFormHelper::toggler_field('settings[steps_show_agent_bio]', __('Show Agent Bio Popup', 'latepoint'), OsSettingsHelper::is_on('steps_show_agent_bio')); ?>
						<?php echo OsFormHelper::toggler_field('settings[steps_hide_agent_info]', __('Do not show Agent Name on Summary and Confirmation steps', 'latepoint'), OsSettingsHelper::is_on('steps_hide_agent_info')); ?>
				    <?php echo OsFormHelper::toggler_field('settings[allow_any_agent]', __('Add "Any Agent" option to agent selection', 'latepoint'), OsSettingsHelper::is_on('allow_any_agent'), 'lp-any-agent-settings'); ?>
          	<div id="lp-any-agent-settings" <?php echo (OsSettingsHelper::is_on('allow_any_agent')) ? '' : 'style="display: none;"' ?>>
				      <?php echo OsFormHelper::select_field('settings[any_agent_order]', __('If "Any Agent" is selected then assign booking to', 'latepoint'), [ 
				        LATEPOINT_ANY_AGENT_ORDER_RANDOM => __('Randomly picked agent', 'latepoint'),
				        LATEPOINT_ANY_AGENT_ORDER_PRICE_HIGH => __('Most expensive agent', 'latepoint'),
				        LATEPOINT_ANY_AGENT_ORDER_PRICE_LOW => __('Least expensive agent', 'latepoint'),
				        LATEPOINT_ANY_AGENT_ORDER_BUSY_HIGH => __('Agent with most bookings on that day', 'latepoint'),
				        LATEPOINT_ANY_AGENT_ORDER_BUSY_LOW => __('Agent with least bookings on that day', 'latepoint') ], OsSettingsHelper::get_any_agent_order()); ?>
				    </div>
          </div>
        </div>
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Other Settings', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
						<?php echo OsFormHelper::toggler_field('settings[steps_show_service_categories]', __('Show Service Categories', 'latepoint'), OsSettingsHelper::is_on('steps_show_service_categories')); ?>
				    <?php echo OsFormHelper::toggler_field('settings[steps_skip_verify_step]', __('Skip Verification Step', 'latepoint'), OsSettingsHelper::is_on('steps_skip_verify_step')); ?>
				    <?php echo OsFormHelper::toggler_field('settings[steps_show_timezone_info]', __('Show timezone information on verification, confirmation and datepicker steps', 'latepoint'), OsSettingsHelper::is_on('steps_show_timezone_info')); ?>
				    <?php do_action('latepoint_settings_steps_after'); ?>
          </div>
				</div>
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Left Panel', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
						<?php echo OsFormHelper::wp_editor_field('settings[steps_support_text]', 'settings_steps_support_text', __('Content for a bottom part of a booking side panel', 'latepoint'), OsSettingsHelper::get_steps_support_text(), array('editor_height' => 150)); ?>
          </div>
				</div>
        <div class="sub-section-row">
          <div class="sub-section-label">
            <h3><?php _e('Conversion Tracking', 'latepoint') ?></h3>
          </div>
          <div class="sub-section-content">
						  <div class="latepoint-message latepoint-message-subtle">
						    <div><?php _e('You can include some javascript or html that will be appended to the confirmation step. For example you can track ad conversions by triggering a tracking code or a facebook pixel. You can use these variables within your code. Click on the variable to copy.', 'latepoint'); ?></div>
						  </div>
					  <div class="tracking-info-w">
							<div class="available-vars-w">
							  <div class="available-vars-i">
							    <div class="available-vars-block">
							      <ul>
							        <li><span class="var-label"><?php _e('Appointment ID#:', 'latepoint'); ?></span> <span class="var-code os-click-to-copy">{booking_id}</span></li>
							        <li><span class="var-label"><?php _e('Service ID#:', 'latepoint'); ?></span> <span class="var-code os-click-to-copy">{service_id}</span></li>
							        <li><span class="var-label"><?php _e('Agent ID#:', 'latepoint'); ?></span> <span class="var-code os-click-to-copy">{agent_id}</span></li>
							        <li><span class="var-label"><?php _e('Customer ID#:', 'latepoint'); ?></span> <span class="var-code os-click-to-copy">{customer_id}</span></li>
							        <li><span class="var-label"><?php _e('Total Price:', 'latepoint'); ?></span> <span class="var-code os-click-to-copy">{total_price}</span></li>
										</ul>
									</div>
								</div>
							</div>
							<?php echo OsFormHelper::textarea_field('settings[confirmation_step_tracking_code]', false, OsSettingsHelper::get_settings_value('confirmation_step_tracking_code', ''), array('theme' => 'bordered', 'rows' => 9, 'placeholder' => __('Enter Tracking code here', 'latepoint')), ['class' => 'tracking-code-input-w']); ?>
						</div>
          </div>
        </div>
        <div class="sub-section-row">
          <div class="sub-section-label">
          </div>
          <div class="sub-section-content">
						<?php echo OsFormHelper::button('submit', __('Save Settings', 'latepoint'), 'submit', ['class' => 'latepoint-btn latepoint-btn-md'], 'latepoint-icon-checkmark'); ?>
          </div>
        </div>
			</div>
		</div>
	</form>
</div>
