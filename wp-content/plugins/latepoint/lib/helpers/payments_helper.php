<?php 

class OsPaymentsHelper {

	public static function get_payment_processors($enabled_only = false){
		$payment_processors = [];
		$payment_processors = apply_filters('latepoint_payment_processors', $payment_processors, $enabled_only);
		return $payment_processors;
	}

	public static function get_default_payment_method(){
		$payment_methods = self::get_enabled_payment_methods();
		if(count($payment_methods) == 1){
			return reset($payment_methods)['code'];
		}else{
			return null;
		}
	}

	public static function is_local_payments_enabled(){
    return OsSettingsHelper::is_on('enable_payments_local');
	}

  public static function is_accepting_payments(){
  	$enabled_payment_methods = self::get_enabled_payment_methods(false);
  	return (empty($enabled_payment_methods)) ? false : true;
  }

  public static function is_payment_processor_enabled($processor_code){
		return OsSettingsHelper::is_on('enable_payment_processor_'.$processor_code);
  }
	

	public static function get_all_payment_methods(){
		$payment_methods = [];
		$payment_methods[LATEPOINT_PAYMENT_METHOD_LOCAL] = self::get_local_payment_method_info();
		$payment_methods = apply_filters('latepoint_all_payment_methods', $payment_methods);
		return $payment_methods;
	}

	public static function get_local_payment_method_info(){
		return [ 'label' => __('Pay Locally', 'latepoint'), 
						'image_url' => LATEPOINT_IMAGES_URL.'payment_later.png',
						'code' => LATEPOINT_PAYMENT_METHOD_LOCAL,
						'time_type' => LATEPOINT_PAYMENT_TIME_LATER,
						'css_class' => 'lp-payment-trigger-later' ];
	}

	public static function get_enabled_payment_methods($count_local = true){
		$enabled_payment_methods = [];
		if($count_local && self::is_local_payments_enabled()) $enabled_payment_methods[LATEPOINT_PAYMENT_METHOD_LOCAL] = self::get_local_payment_method_info();
    $enabled_payment_methods = apply_filters('latepoint_enabled_payment_methods', $enabled_payment_methods);
		return $enabled_payment_methods;
	}

	public static function get_enabled_payment_times(){
		// add local payment method if its enabled
		$enabled_payment_times = [];
		$enabled_payment_methods = self::get_enabled_payment_methods();
    foreach($enabled_payment_methods as $method_code => $payment_method){
      $enabled_payment_times[$payment_method['time_type']][$method_code] = $payment_method;
    }
	  return $enabled_payment_times;
	}

	public static function display_transaction_payment_method_info($payment_method){
		switch($payment_method){
			case LATEPOINT_PAYMENT_METHOD_CARD:
				echo '<div class="lp-method-logo"><i class="latepoint-icon latepoint-icon-credit-card"></i></div>';
			break;
			case LATEPOINT_PAYMENT_METHOD_PAYPAL:
				echo '<div class="lp-method-logo"><i class="latepoint-icon latepoint-icon-paypal"></i></div>';
			break;
			default:
				echo '<div class="lp-method-name">'.$payment_method.'</div>';
			break;
		}
	}

	public static function process_payment_for_booking($booking){
		$payment_processing_result = false;
  	$payment_processing_result = apply_filters('latepoint_process_payment_for_booking', $payment_processing_result, $booking, $booking->customer);
  	if($payment_processing_result && $payment_processing_result['status'] == LATEPOINT_STATUS_SUCCESS){
      $transaction = new OsTransactionModel();
      $transaction->customer_id = $booking->customer_id;
      $transaction->token = $payment_processing_result['charge_id'];
      $transaction->payment_method = $booking->payment_method;
      $transaction->amount = $booking->amount_to_charge();
      $transaction->processor = $payment_processing_result['processor'];
      $transaction->funds_status = isset($payment_processing_result['funds_status']) ? $payment_processing_result['funds_status'] : LATEPOINT_TRANSACTION_FUNDS_STATUS_CAPTURED;
      $transaction->status = LATEPOINT_TRANSACTION_STATUS_APPROVED;
  	}else{
  		$transaction = false;
  	}
  	return $transaction;
	}


	public static function convert_charge_amount_to_requirements($charge_amount, $payment_method){
		$charge_amount = apply_filters('latepoint_convert_charge_amount_to_requirements', $charge_amount, $payment_method);
		return $charge_amount;
	}
}