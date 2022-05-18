<?php 

class OsBookingIntentHelper {

  public static function generate_continue_intent_url($booking_intent_key){
    return OsRouterHelper::build_admin_post_link(['bookings', 'continue_booking_intent'], ['booking_intent_key' => $booking_intent_key]);
  }

  public static function create_or_update_booking_intent($booking_data = [], $restrictions_data = [], $payment_data = [], $booking_form_page_url = ''){
    $booking_intent = new OsBookingIntentModel();

    if(isset($booking_data['intent_key']) && !empty($booking_data['intent_key'])){
      $booking_intent = $booking_intent->get_by_intent_key($booking_data['intent_key']);
      if(!$booking_intent) $booking_intent = new OsBookingIntentModel();
    }

    $booking_intent->booking_data           = json_encode($booking_data);
    $booking_intent->restrictions_data      = json_encode($restrictions_data);
    $booking_intent->payment_data           = json_encode($payment_data);
    $booking_intent->booking_form_page_url  = $booking_form_page_url;
    $booking_intent->customer_id            = OsAuthHelper::get_logged_in_customer_id();

    $booking_intent->save();
    return $booking_intent;
  }

  public static function convert_intent_to_booking($intent_key){
    $booking_intent = new OsBookingIntentModel();
    $booking_intent = $booking_intent->where(['intent_key' => $intent_key])->set_limit(1)->get_results_as_models();
    if($booking_intent){
      if(empty($booking_intent->booking_id)){
        OsStepsHelper::set_booking_object(json_decode($booking_intent->booking_data, true));
        OsStepsHelper::set_restrictions(json_decode($booking_intent->restrictions_data, true));
        if(!OsStepsHelper::$booking_object->save_from_booking_form()){
          // ERROR SAVING BOOKING 
          OsDebugHelper::log(OsStepsHelper::$booking_object->get_error_messages());
          return false;
        }else{
          $booking_intent->update_attributes(['booking_id' => OsStepsHelper::$booking_object->id]);
          return $booking_intent->booking_id;
        }
      }else{
        // has already converted to a booking
        return $booking_intent;
      }
    }else{
      return false;
    }
  }

}