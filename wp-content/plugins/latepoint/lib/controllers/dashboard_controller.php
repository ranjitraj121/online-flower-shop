<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}


if ( ! class_exists( 'OsDashboardController' ) ) :


  class OsDashboardController extends OsController {

    private $booking;

    function __construct(){
      parent::__construct();

      $this->views_folder = LATEPOINT_VIEWS_ABSPATH . 'dashboard/';
      $this->vars['page_header'] = __('Dashboard', 'latepoint');
    }

    public function for_agent(){
      if(!$this->logged_in_agent_id) return;

      $this->vars['page_header'] = false;

      ob_start();
      $this->widget_agent_availability_timeline_for_period();
      $this->vars['widget_agent_availability_timeline_for_period'] = ob_get_clean();

      ob_start();
      $this->widget_agents_bookings_timeline();
      $this->vars['widget_agents_bookings_timeline'] = ob_get_clean();

      ob_start();
      $wdb_date_from = new OsWpDateTime('-1 month');
      $wdb_date_to = new OsWpDateTime('now');
      $this->widget_daily_bookings_chart($wdb_date_from, $wdb_date_to);
      $this->vars['widget_daily_bookings_chart'] = ob_get_clean();

      ob_start();
      $this->widget_upcoming_appointments();
      $this->vars['widget_upcoming_appointments'] = ob_get_clean();
      $this->set_layout('admin');
      $this->format_render(__FUNCTION__);
    }



    /*
      Index
    */

    public function index(){
      $services = new OsServiceModel();
      $agents = new OsAgentModel();
      $locations = new OsLocationModel();


      $this->vars['page_header'] = false;

      ob_start();
      $this->widget_top_agents();
      $this->vars['widget_top_agents'] = ob_get_clean();

      ob_start();
      $this->widget_agents_availability_timeline();
      $this->vars['widget_agents_availability_timeline'] = ob_get_clean();

      ob_start();
      $this->widget_agents_bookings_timeline();
      $this->vars['widget_agents_bookings_timeline'] = ob_get_clean();

      ob_start();
      $this->widget_daily_bookings_chart();
      $this->vars['widget_daily_bookings_chart'] = ob_get_clean();

      ob_start();
      $this->widget_upcoming_appointments(6);
      $this->vars['widget_upcoming_appointments'] = ob_get_clean();

      ob_start();
      $this->widget_performance_charts();
      $this->vars['widget_performance_charts'] = ob_get_clean();


      ob_start();
      $this->widget_stats();
      $this->vars['widget_stats'] = ob_get_clean();

      $this->set_layout('admin');
      $this->format_render(__FUNCTION__);
    }

    public function widget_stats($date_from = false, $date_to = false){
      if($date_from == false){
        $date_from = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('-10 days');
      }
      if($date_to == false){
        $date_to = isset($this->params['date_to']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_to']) : new OsWpDateTime('now');
      }

      $this->vars['date_from'] = $date_from->format('Y-m-d');
      $this->vars['date_to'] = $date_to->format('Y-m-d');

      $this->vars['date_period_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_from).' - '.OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_to);

      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }

    public function widget_performance_charts($date_from = false, $date_to = false){
      if($date_from == false){
        $date_from = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('-10 days');
      }
      if($date_to == false){
        $date_to = isset($this->params['date_to']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_to']) : new OsWpDateTime('now');
      }

      $agent_id = isset($this->params['agent_id']) ? $this->params['agent_id'] : false;
      $service_id = isset($this->params['service_id']) ? $this->params['service_id'] : false;

      $agents = new OsAgentModel();
      $services = new OsServiceModel();
      if($this->logged_in_agent_id) $agents->where(['id' => $this->logged_in_agent_id]);

      $this->vars['agents'] = $agents->get_results_as_models();
      $this->vars['services'] = $services->get_results_as_models();

      $this->vars['agent_id'] = $agent_id;
      $this->vars['service_id'] = $service_id;


      $this->vars['date_from'] = $date_from->format('Y-m-d');
      $this->vars['date_to'] = $date_to->format('Y-m-d');

      $this->vars['date_period_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_from).' - '.OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_to);

      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }



    public function widget_upcoming_appointments($limit = 6){
      $agents = new OsAgentModel();
      $services = new OsServiceModel();
      $bookings = new OsBookingModel();

      $agent_id = isset($this->params['agent_id']) ? $this->params['agent_id'] : false;
      if($this->logged_in_agent_id) $agent_id = $this->logged_in_agent_id;

      $service_id = isset($this->params['service_id']) ? $this->params['service_id'] : false;
      $location_id = isset($this->params['location_id']) ? $this->params['location_id'] : false;

      $this->vars['upcoming_bookings'] = $bookings->get_upcoming_bookings($agent_id, false, $service_id, $location_id, $limit);

      if($this->logged_in_agent_id) $agents->where(['id' => $this->logged_in_agent_id]);

      $this->vars['agents'] = $agents->get_results_as_models();
      $this->vars['services'] = $services->get_results_as_models();

      $this->vars['agent_id'] = $agent_id;
      $this->vars['service_id'] = $service_id;


      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }



    public function widget_daily_bookings_chart($date_from = false, $date_to = false){
      if($date_from == false){
        $date_from = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('-7 days');
      }
      if($date_to == false){
        $date_to = isset($this->params['date_to']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_to']) : new OsWpDateTime('now');
      }

      $agent_id = ($this->logged_in_agent_id) ? ($this->logged_in_agent_id) : (isset($this->params['agent_id']) ? $this->params['agent_id'] : false);
      $service_id = isset($this->params['service_id']) ? $this->params['service_id'] : false;

      $locations = OsLocationHelper::get_locations(OsAuthHelper::get_logged_in_agent_id());
      $this->vars['locations'] = $locations;
      $selected_location_id = isset($this->params['location_id']) ? $this->params['location_id'] : false;
      $this->vars['selected_location_id'] = $selected_location_id;

      $daily_bookings = OsBookingHelper::get_bookings_per_day_for_period($date_from->format('Y-m-d'), $date_to->format('Y-m-d'), $service_id, $agent_id, $selected_location_id);

      $daily_chart_data = [];
      // fill data array with all the days
      for($day_date=clone $date_from; $day_date<$date_to; $day_date->modify('+1 day')){
        $daily_chart_data[OsTimeHelper::get_nice_date_with_optional_year($day_date->format('Y-m-d'), false)] = 0;
      }
      // update the days with count of bookings
      foreach($daily_bookings as $bookings_for_day){
        $daily_chart_data[OsTimeHelper::get_nice_date_with_optional_year(date( 'Y-m-d', strtotime($bookings_for_day->start_date)), false)] = $bookings_for_day->bookings_per_day;
      }

      $this->vars['total_bookings'] = OsBookingHelper::get_stat_for_period('bookings', $date_from->format('Y-m-d'), $date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);
      $this->vars['total_price'] = OsBookingHelper::get_stat_for_period('price', $date_from->format('Y-m-d'), $date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);
      $this->vars['total_duration'] = OsBookingHelper::get_stat_for_period('duration', $date_from->format('Y-m-d'), $date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);

      $day_difference = $date_from->diff($date_to);
      $day_difference = ($day_difference->d > 0) ? $day_difference->d : 1;

      $prev_date_from = clone $date_from;
      $prev_date_from->modify('-'.$day_difference.' days');
      $prev_date_to = clone $date_to;
      $prev_date_to->modify('-'.$day_difference.' days');

      $this->vars['prev_total_bookings'] = OsBookingHelper::get_stat_for_period('bookings', $prev_date_from->format('Y-m-d'), $prev_date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);
      $this->vars['prev_total_price'] = OsBookingHelper::get_stat_for_period('price', $prev_date_from->format('Y-m-d'), $prev_date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);
      $this->vars['prev_total_duration'] = OsBookingHelper::get_stat_for_period('duration', $prev_date_from->format('Y-m-d'), $prev_date_to->format('Y-m-d'), false, $service_id, $agent_id, $selected_location_id);


      $agents = new OsAgentModel();
      $services = new OsServiceModel();
      if($this->logged_in_agent_id) $agents->where(['id' => $this->logged_in_agent_id]);

      $this->vars['agents'] = $agents->get_results_as_models();
      $this->vars['services'] = ($this->logged_in_agent) ? $this->logged_in_agent->get_services() : $services->get_results_as_models();

      $this->vars['agent_id'] = $agent_id;
      $this->vars['service_id'] = $service_id;

      $this->vars['date_from'] = $date_from->format('Y-m-d');
      $this->vars['date_to'] = $date_to->format('Y-m-d');

      $this->vars['daily_bookings_chart_labels_string'] = implode(',', array_keys($daily_chart_data));
      $this->vars['daily_bookings_chart_data_values_string'] = implode(',', array_values($daily_chart_data));

      $pie_labels = [];
      $pie_colors = [];
      $pie_values = [];
      $pie_chart_data = OsBookingHelper::get_stat_for_period('bookings', $date_from->format('Y-m-d'), $date_to->format('Y-m-d'), 'service_id', $service_id, $agent_id, $selected_location_id);
      foreach($pie_chart_data as $pie_data){
        $service = new OsServiceModel($pie_data['service_id']);
        $pie_labels[] = $service->name;
        $pie_colors[] = $service->bg_color;
        $pie_values[] = $pie_data['stat'];
      }

      $this->vars['pie_chart_data'] = ['labels' => $pie_labels, 'colors' => $pie_colors, 'values' => $pie_values];

      $this->vars['date_period_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_from).' - '.OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_to);

      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }


    public function widget_agent_availability_timeline_for_period($period_length_in_days = 8){
      $agent = OsAuthHelper::get_logged_in_agent();
      $services = new OsServiceModel();
      $services = ($this->logged_in_agent) ? $this->logged_in_agent->get_services() : $services->get_results_as_models();

      if($services){
        $selected_service_id = isset($this->params['service_id']) ? $this->params['service_id'] : $services[0]->id;
      }else{
        $selected_service_id = false;
      }
      $this->vars['service_id'] = $selected_service_id;

      $selected_service = new OsServiceModel($selected_service_id);
      $this->vars['selected_service'] = $selected_service;


      $locations = OsLocationHelper::get_locations(OsAuthHelper::get_logged_in_agent_id());
      $this->vars['locations'] = $locations;
      if($locations){
        $selected_location_id = isset($this->params['location_id']) ? $this->params['location_id'] : $locations[0]->id;
      }else{
        $selected_location_id = false;
      }

      $this->vars['selected_location_id'] = $selected_location_id;
      $selected_location = $selected_location_id ? new OsLocationModel($selected_location_id) : false;
      $this->vars['selected_location'] = $selected_location;

      $calendar_start_date_obj = isset($this->params['date_from']) ? new OsWpDateTime($this->params['date_from']) : new OsWpDateTime('today');
      $calendar_start_date = $calendar_start_date_obj->format('Y-m-d');
      $calendar_end_date_obj = clone $calendar_start_date_obj;
      $calendar_end_date = $calendar_end_date_obj->modify('+'.$period_length_in_days.' days')->format('Y-m-d');
      
      $dated_work_periods_arr = OsBookingHelper::get_work_periods_for_date_range($calendar_start_date, $calendar_end_date, ['service_id' => $selected_service_id, 'agent_id' => $agent->id, 'location_id' => $selected_location_id]);
      $work_start_end = OsBookingHelper::get_work_start_end_time_for_date_range($dated_work_periods_arr);

      $this->vars['services'] = $services;

      $this->vars['work_start_end'] = $work_start_end;
      $this->vars['show_days_only'] = isset($this->params['show_days_only']) ? true : false;
      
      $this->vars['timeblock_interval'] = $selected_service->get_timeblock_interval();
      $this->vars['days_availability_html'] = OsBookingHelper::get_quick_availability_days($calendar_start_date, $agent, $selected_service, $selected_location, $work_start_end, $period_length_in_days, $selected_service->duration );
      $this->vars['target_date'] = $calendar_start_date;
      $this->vars['target_date_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $calendar_start_date_obj);

      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }

    public function widget_agents_availability_timeline(){
      $target_date = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('now');

      $agents = new OsAgentModel();
      $services = new OsServiceModel();

      if($this->logged_in_agent_id) $agents->where(['id' => $this->logged_in_agent_id]);
      $agents = $agents->get_results_as_models();
      $services = ($this->logged_in_agent) ? $this->logged_in_agent->get_services() : $services->get_results_as_models();

      if($services){
        $selected_service_id = isset($this->params['service_id']) ? $this->params['service_id'] : $services[0]->id;
      }else{
        $selected_service_id = false;
      }
      $this->vars['service_id'] = $selected_service_id;

      $selected_service = new OsServiceModel($selected_service_id);
      $this->vars['selected_service'] = $selected_service;


      $locations = OsLocationHelper::get_locations(OsAuthHelper::get_logged_in_agent_id());
      $this->vars['locations'] = $locations;
      if($locations){
        $selected_location_id = isset($this->params['location_id']) ? $this->params['location_id'] : $locations[0]->id;
      }else{
        $selected_location_id = false;
      }

      $this->vars['selected_location_id'] = $selected_location_id;
      $this->vars['selected_location'] = $selected_location_id ? new OsLocationModel($selected_location_id) : false;

      $this->vars['target_date'] = $target_date->format('Y-m-d');
      $this->vars['target_date_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $target_date);

      $this->vars['agents'] = $agents;
      $this->vars['services'] = $services;

      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }


    public function widget_agents_bookings_timeline(){
      $target_date = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('now');

      $agents = new OsAgentModel();
      if($this->logged_in_agent_id) $agents->where(['id' => $this->logged_in_agent_id]);
      $this->vars['agents'] = $agents->get_results_as_models();

      $locations = OsLocationHelper::get_locations(OsAuthHelper::get_logged_in_agent_id());
      $this->vars['locations'] = $locations;
      if($locations){
        $default_location_id = OsSettingsHelper::is_on('one_location_at_time') ? false : $locations[0]->id;
        $this->vars['selected_location_id'] = isset($this->params['location_id']) ? $this->params['location_id'] : $default_location_id;
      }else{
        $this->vars['selected_location_id'] = false;  
      }

      $this->vars['show_day_info'] = OsAuthHelper::is_admin_logged_in();
      $this->vars['target_date_obj'] = $target_date;
      $this->vars['target_date'] = $target_date->format('Y-m-d');
      $this->vars['target_date_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $target_date);

      $this->set_layout('none');

      $this->format_render(__FUNCTION__);
    }


    public function widget_top_agents(){
      $date_from = isset($this->params['date_from']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_from']) : new OsWpDateTime('-1 week');
      $date_to = isset($this->params['date_to']) ? OsWpDateTime::os_createFromFormat('Y-m-d', $this->params['date_to']) : new OsWpDateTime('now');

      $this->vars['top_agents'] = OsAgentHelper::get_top_agents($date_from->format('Y-m-d'), $date_to->format('Y-m-d'), 3, false);
      $this->vars['date_from'] = $date_from->format('Y-m-d');
      $this->vars['date_to'] = $date_to->format('Y-m-d');
      $this->vars['date_period_string'] = OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_from).' - '.OsTimeHelper::format_date_with_locale(OsSettingsHelper::get_readable_date_format(), $date_to);

      $bookings = new OsBookingModel();
      $this->vars['total_bookings'] = $bookings->should_be_approved()->where(['start_date >=' => $date_from->format('Y-m-d'), 'start_date <=' => $date_to->format('Y-m-d')])->count();

      $this->set_layout('none');

      $this->format_render(__FUNCTION__);
    }


  }

endif;