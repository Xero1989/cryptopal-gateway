<?php

class XIS_AdminController
{

  function create_custom_menu()
  {
    add_menu_page('Xirect Inkamall Scripts', 'Xirect Inkamall Scripts', 'manage_options', 'xirect-inkamall-scripts-settings', 'XIS_AdminController::index');
  }

  function index()
  {
    wp_enqueue_style('css_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.css');
    wp_enqueue_script('js_ajax_response_message_box', plugin_dir_url(__FILE__) . '../assets/libraries/ajax_response_message_box/ajax_response_message_box.js');

    wp_enqueue_script('js_admin', plugin_dir_url(__FILE__) . '../assets/js/xis_admin.js');
    wp_localize_script('js_admin', 'url_admin_ajax', admin_url('admin-ajax.php'));

    //$xis_products_ids = get_option("xis_products_ids");

    XIS_Blade::view('xis_admin', compact(''));
  }

  function save_products_ids()
  {

    $xis_products_ids = $_POST["xis_products_ids"];

    if ($xis_products_ids != "") {
      $explode = explode(",", $xis_products_ids);      

      foreach ($explode as $element) {
        if (!is_numeric($element)) {
          XIS_Useful::ajax_server_response(array("status" => "wrong", "message" => "You must enter an string of products IDs separated by a comma"));
        }
      }
    }

    update_option("xis_products_ids", $xis_products_ids);

    XIS_Useful::ajax_server_response(array("message" => "Settings has been saved correctly"));
  }
}
