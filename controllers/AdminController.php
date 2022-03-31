<?php

class CPG_AdminController
{

/**
 * Create and initialize cryptopal gateway
 *          
 * @return object returns the cryptopal gateway instance
 */
static function create_cryptopal_gateway()
{
  require 'class-cryptopal-gateway-main.php';

  $gateway = new Cryptopal_Gateway_Main();

  return $gateway;
}


/**
 * Add cryptopal gateway
 *          
 * @return object returns the cryptopal gateway instance
 */
function add_new_gateway($gateways)
{
  $gateways[] = 'Cryptopal_Gateway_Main';
  return $gateways;
}



  static function create_custom_menu()
  {
    add_menu_page('Cryptopal Gateway', 'Cryptopal Gateway', 'manage_options', 'cryptopal-gateway-settings', 'CPG_AdminController::index');
  }

  static function index()
  {
    wp_enqueue_style('css_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.css');
    wp_enqueue_script('js_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.js');

    wp_enqueue_style('css_admin', plugin_dir_url(__FILE__) . '../assets/css/cpg_admin.css');
    wp_enqueue_script('js_admin', plugin_dir_url(__FILE__) . '../assets/js/cpg_admin.js');
    wp_add_inline_script('js_admin', 'var url_admin_ajax = "' . admin_url('admin-ajax.php').'";');
    //wp_localize_script('js_admin', 'url_admin_ajax', admin_url('admin-ajax.php'));

    $cpg_enable = get_option("cpg_enable");
    $cpg_description = get_option("cpg_description");
    $cpg_webshop_id = get_option("cpg_webshop_id");
    $cpg_webhook_url = get_option("cpg_webhook_url");

    CPG_Useful::log("$cpg_enable - $cpg_description - $cpg_webshop_id - $cpg_webhook_url");

    CPG_Blade::view('cpg_admin', compact('cpg_enable','cpg_description','cpg_webshop_id','cpg_webhook_url'));
  }

  static function cpg_save_settings()
  {

    $cpg_enable = $_POST["cpg_enable"];
    $cpg_description = $_POST["cpg_description"];
    $cpg_webshop_id = $_POST["cpg_webshop_id"];
    $cpg_webhook_url = $_POST["cpg_webhook_url"];   

    CPG_Useful::log("$cpg_enable - $cpg_description - $cpg_webshop_id - $cpg_webhook_url");
    
    update_option("cpg_enable", $cpg_enable);
    update_option("cpg_description", $cpg_description);
    update_option("cpg_webshop_id", $cpg_webshop_id);
    update_option("cpg_webhook_url", $cpg_webhook_url);

    CPG_Useful::ajax_server_response(array("message" => "Settings has been saved correctly"));
  }
}
