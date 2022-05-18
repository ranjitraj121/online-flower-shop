<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}


if ( ! class_exists( 'OsAddonsController' ) ) :


  class OsAddonsController extends OsController {



    function __construct(){
      parent::__construct();

      $this->views_folder = LATEPOINT_VIEWS_ABSPATH . 'addons/';
      $this->vars['page_header'] = __('Available Add-ons', 'latepoint');
    }

    function delete_addon(){
      if(!isset($this->params['addon_name']) || empty($this->params['addon_name'])) return;
      delete_plugins($this->params['addon_name']);
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

    function missing_locations(){
      $this->vars['page_header'] = __('Locations', 'latepoint');
      $this->format_render('missing');
    }


    function deactivate_addon(){
      if(!isset($this->params['addon_name']) || empty($this->params['addon_name'])) return;

      $result = OsAddonsHelper::deactivate_addon( $this->params['addon_path'] );
      $status = is_wp_error( $result ) ? LATEPOINT_STATUS_ERROR : LATEPOINT_STATUS_SUCCESS;
      $response_html = is_wp_error($result) ? $result->get_error_message() : __('Addon deactivated', 'latepoint');

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

    function activate_addon(){
      if(!isset($this->params['addon_path']) || empty($this->params['addon_path'])) return;

      $result = OsAddonsHelper::activate_addon( $this->params['addon_path'] );
      $status = is_wp_error( $result ) ? LATEPOINT_STATUS_ERROR : LATEPOINT_STATUS_SUCCESS;
      $response_html = is_wp_error($result) ? $result->get_error_message() : __('Addon activated', 'latepoint');
      if($this->get_return_format() == 'json'){
        $this->send_json(['status' => $status, 'message' => $response_html]);
      }
    }

    function install_addon(){
      if(!isset($this->params['addon_name']) || empty($this->params['addon_name'])) return;

      $addon_name = $this->params['addon_name'];

      $license = OsLicenseHelper::get_license_info();

      if(OsLicenseHelper::is_license_active()){
        $addon_info = OsAddonsHelper::get_addon_download_info($addon_name);
        $result = OsAddonsHelper::install_addon($addon_info);
        if(is_wp_error( $result )){
          $status = LATEPOINT_STATUS_ERROR;
          $response_html = $result->get_error_message();
          $code = '500';
        }else{
          $status = LATEPOINT_STATUS_SUCCESS;
          $code = '200';
          $response_html = __('Addon installed successfully.', 'latepoint');
        }
      }else{
        $this->vars['license'] = $license;
        $status = LATEPOINT_STATUS_ERROR;
        $response_html = $this->render(LATEPOINT_VIEWS_ABSPATH.'updates/_license_form', 'none');
        $code = '404';
      }

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'code' => $code, 'message' => $response_html));
      }

    }


    function index(){

      $this->format_render(__FUNCTION__);
    }

    function load_addons_list(){

      $addons = OsUpdatesHelper::get_list_of_addons();
      $this->vars['addons'] = $addons;
      OsUpdatesHelper::check_addons_latest_version($addons);
      $this->format_render(__FUNCTION__);
    }
	}



endif;