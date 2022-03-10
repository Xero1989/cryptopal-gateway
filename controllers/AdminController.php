<?php

class CPG_AdminController
{

  function create_custom_menu()
  {
    add_menu_page('Cryptopal Gateway', 'Cryptopal Gateway', 'manage_options', 'cryptopal-gateway-settings', 'CPG_AdminController::index');
  }

  function index()
  {
    wp_enqueue_style('css_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.css');
    wp_enqueue_script('js_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.js');

    wp_enqueue_style('css_admin', plugin_dir_url(__FILE__) . '../assets/css/cpg_admin.css');
    wp_enqueue_script('js_admin', plugin_dir_url(__FILE__) . '../assets/js/cpg_admin.js');
    wp_localize_script('js_admin', 'url_admin_ajax', admin_url('admin-ajax.php'));

    $cpg_enable = get_option("cpg_enable");
    $cpg_description = get_option("cpg_description");
    $cpg_merchant_id = get_option("cpg_merchant_id");
    $cpg_webhook_url = get_option("cpg_webhook_url");

    CPG_Useful::log("$cpg_enable - $cpg_description - $cpg_merchant_id - $cpg_webhook_url");

    CPG_Blade::view('cpg_admin', compact('cpg_enable','cpg_description','cpg_merchant_id','cpg_webhook_url'));
  }

  function cpg_save_settings()
  {

    $cpg_enable = $_POST["cpg_enable"];
    $cpg_description = $_POST["cpg_description"];
    $cpg_merchant_id = $_POST["cpg_merchant_id"];
    $cpg_webhook_url = $_POST["cpg_webhook_url"];   

    update_option("cpg_enable", $cpg_enable);
    update_option("cpg_description", $cpg_description);
    update_option("cpg_merchant_id", $cpg_merchant_id);
    update_option("cpg_webhook_url", $cpg_webhook_url);

    CPG_Useful::ajax_server_response(array("message" => "Settings has been saved correctly"));
  }
}
