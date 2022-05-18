<div class="latepoint-settings-w os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
    <?php if(count($payment_processors)){ ?>
      <div class="os-form-sub-header"><h3><?php _e('Payment Processors', 'latepoint'); ?></h3></div>
        <div class="os-payment-processors-w">
        <?php foreach($payment_processors as $payment_processor_code => $payment_processor){ ?>
          <div class="os-payment-processor-w">
            <div class="os-payment-processor-head">
              <div class="os-toggler-w">
                <?php echo OsFormHelper::toggler_field('settings[enable_payment_processor_'.$payment_processor_code.']', false, OsPaymentsHelper::is_payment_processor_enabled($payment_processor_code), 'togglePaymentSettings_'.$payment_processor_code, 'large'); ?>
              </div>
              <div class="os-processor-logo" style="background-image: url('<?php echo esc_attr($payment_processor['image_url']); ?>')"></div>
              <div class="os-processor-name">'<?php $payment_processor['name']; ?>'</div>
            </div>
            <div class="os-payment-processor-body" style="<?php echo OsPaymentsHelper::is_payment_processor_enabled($payment_processor_code) ? '' : 'display: none'; ?>" id="togglePaymentSettings_<?php echo $payment_processor_code; ?>">
              <?php do_action('latepoint_payment_processor_settings', $payment_processor_code); ?>
            </div>
          </div>
        <?php } ?>
        </div>
        <div class="os-form-sub-header"><h3><?php _e('Other Payment Settings', 'latepoint'); ?></h3></div>
        <?php echo OsFormHelper::select_field('settings[payments_environment]', __('Environment', 'latepoint'), array(LATEPOINT_ENV_LIVE => __('Live (Production)', 'latepoint'), LATEPOINT_ENV_DEV => __('Sandbox (Development)', 'latepoint'), LATEPOINT_ENV_DEMO => __('Demo', 'latepoint')), OsSettingsHelper::get_payments_environment()); ?>
        <?php echo OsFormHelper::toggler_field('settings[enable_payments_local]', __('Allow Paying Locally', 'latepoint'), OsPaymentsHelper::is_local_payments_enabled()); ?>
      <?php }else{ ?>
        <a href="<?php echo OsRouterHelper::build_link(['addons', 'index']); ?>" class="os-add-box" >
          <div class="add-box-graphic-w"><div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div></div>
          <div class="add-box-label"><?php _e('Install Payment Gateway Add-on', 'latepoint'); ?></div>
        </a><?php
      } ?>
    <div class="os-form-buttons">
      <?php echo OsFormHelper::button('submit', __('Save Settings', 'latepoint'), 'submit', ['class' => 'latepoint-btn latepoint-btn-md'], 'latepoint-icon-checkmark'); ?>
    </div>
  </form>
</div>