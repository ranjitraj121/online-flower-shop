<div class="step-verify-w latepoint-step-content" data-step-name="verify">
  <div class="latepoint-step-content-text-left">
    <div><?php _e('Double check your booking information, you can go back to edit it or click submit button to confirm your booking.', 'latepoint'); ?></div>
  </div>
  <div class="confirmation-info-w">
  	<div class="confirmation-app-info">
		  <h5 class="confirmation-section-heading"><?php _e('Appointment Info', 'latepoint'); ?></h5>
		  <ul>
		  	<li><?php _e('Date:', 'latepoint'); ?> <strong><?php echo $booking->format_start_date_and_time(OsSettingsHelper::get_readable_date_format(), false, OsTimeHelper::get_timezone_from_session()); ?></strong></li>
		  	<li>
          <?php _e('Time:', 'latepoint'); ?> 
          <strong>
            <?php echo OsTimeHelper::minutes_to_hours_and_minutes($booking->get_start_time_shifted_for_customer()); ?>
            <?php if(OsSettingsHelper::get_settings_value('show_booking_end_time') == 'on') echo ' - '. OsTimeHelper::minutes_to_hours_and_minutes($booking->get_end_time_shifted_for_customer()); ?>
          </strong>
        </li>
        <?php if(OsSettingsHelper::is_on('steps_show_timezone_info')){
          echo '<li>'.__('Timezone:', 'latepoint').'<strong>'.OsTimeHelper::get_timezone_name_from_session().'</strong></li>';
        } ?>
        <?php if(!OsSettingsHelper::is_on('steps_hide_agent_info')){ ?>
    	  	<li><?php _e('Agent:', 'latepoint'); ?> <strong><?php echo $booking->get_agent_full_name(); ?></strong></li>
        <?php } ?>
		  	<li><?php _e('Service:', 'latepoint'); ?> <strong><?php echo $booking->service->name; ?></strong></li>
        <?php do_action('latepoint_step_verify_appointment_info', $booking); ?>
		  </ul>
  	</div>
  	<div class="confirmation-customer-info">
		  <h5 class="confirmation-section-heading"><?php _e('Customer Info', 'latepoint'); ?></h5>
		  <ul>
		  	<?php if($default_fields_for_customer['first_name']['active'] || $default_fields_for_customer['last_name']['active']) echo '<li>'.__('Name:', 'latepoint').'<strong>'.$customer->full_name.'</strong></li>'; ?>
        <?php if($default_fields_for_customer['phone']['active']) echo '<li>'.__('Phone:', 'latepoint').'<strong>'.$customer->formatted_phone.'</strong></li>'; ?>
		  	<li><?php _e('Email:', 'latepoint'); ?> <strong><?php echo $customer->email; ?></strong></li>
        <?php do_action('latepoint_step_verify_customer_info', $customer, $booking); ?>
		  </ul>
  	</div>
    <?php if(($booking->full_amount_to_charge(false) > 0) || ($booking->deposit_amount_to_charge() > 0)){ ?>

        <?php $price_html = ($booking->formatted_full_price() < $booking->formatted_full_price(false)) ? '<span class="lp-strike">'.$booking->formatted_full_price(false).'</span> '.$booking->formatted_full_price() : $booking->formatted_full_price(); ?>
        <div class="payment-summary-info">
          <h5 class="confirmation-section-heading"><?php _e('Payment Info', 'latepoint'); ?></h5>
          <div class="confirmation-info-w">
            <div class="confirmation-app-info">
              <ul>
                <?php if(OsPaymentsHelper::is_accepting_payments()){ 
                  // payment gateways/methods exist ?>
                  <?php if($booking->payment_method_nice_name){ ?>
                    <li><?php _e('Payment Method:', 'latepoint'); ?> <strong><?php echo $booking->payment_method_nice_name; ?></strong></li>
                  <?php } ?>
                  <?php if($booking->payment_method == LATEPOINT_PAYMENT_METHOD_LOCAL){
                    echo '<li>'.__('Balance Due:', 'latepoint').'<strong>'.$booking->formatted_full_price().'</strong></li>';
                  }else{
                    if($booking->payment_portion == LATEPOINT_PAYMENT_PORTION_DEPOSIT){
                      echo '<li>'.__('Deposit Now:', 'latepoint').'<strong>'.$booking->formatted_deposit_price().'</strong></li>';
                      if($booking->full_amount_to_charge(false) > 0){
                        echo '<li>'.__('Total Price:', 'latepoint').'<strong>'.$price_html.'</strong></li>';
                      }
                    }else{
                      echo '<li>'.__('Charge Amount:', 'latepoint').'<strong>'.$price_html.'</strong></li>';
                    }
                  }
                }else{ 
                  // no payment methods/gateways, but if a price is not 0 - show info ?>
                  <li>
                    <?php _e('Total Price:', 'latepoint'); ?> 
                    <strong><?php echo $price_html; ?></strong>
                  </li>
                  <?php 
                } ?>
                <?php do_action('latepoint_step_verify_payment_info', $booking); ?>
              </ul>
            </div>
          </div>
        </div>
    <?php } ?>
  </div>
</div>