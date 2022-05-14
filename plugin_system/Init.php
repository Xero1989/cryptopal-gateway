<?php

class CPG_Init
{

    function __construct()
    {
        $this->load_helpers();

        $this->load_filters();

        $this->load_actions();

        $this->load_shortcodes();
    }


    function load_helpers()
    {
        foreach (glob(__DIR__ . "/Helpers/*.php") as $filename) {
            require $filename;
        }
    }

    function load_filters()
    {
        //   add_filter('woocommerce_checkout_fields', 'CPG_CheckoutController::woocommerce_checkout_fields',10,2);

        add_filter('woocommerce_payment_gateways', 'CPG_AdminController::add_new_gateway');

        add_filter('woocommerce_thankyou_order_received_text', 'CPG_CryptopalController::open_crypto_payment_window', 10, 2);

        
    }

    function load_actions()
    {
        //Admin menu version
      //  add_action('admin_menu', 'CPG_AdminController::create_custom_menu');
       // add_action('wp_ajax_cpg_save_settings', 'CPG_AdminController::cpg_save_settings');

        //Gateway version
        add_action('plugins_loaded', 'CPG_AdminController::create_cryptopal_gateway', 11);

        $plugin_enable = get_option("cpg_enable");

        if ($plugin_enable == "true") {

            // add_action('woocommerce_after_shop_loop_item', "CPG_CryptopalController::show_crypto_payment_button");
            // add_action('woocommerce_after_main_content', 'CPG_CryptopalController::write_modal');
          //  add_action('wp_ajax_get_app_url_from_cryptopal', 'CPG_CryptopalController::get_app_url_from_cryptopal');

           // add_action('woocommerce_checkout_process', 'CPG_CryptopalController::checkout_field_process');

         //  add_action( 'woocommerce_thankyou', 'CPG_CryptopalController::open_crypto_payment_window', 4 );
          
          
            //Webhook
            add_action("rest_api_init", "CPG_CryptopalController::cryptopal_notification");
        }
    }

    function load_shortcodes()
    {
    }
}
