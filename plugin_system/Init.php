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
    }

    function load_actions()
    {
        add_action('admin_menu', 'CPG_AdminController::create_custom_menu');
        add_action('wp_ajax_cpg_save_settings', 'CPG_AdminController::cpg_save_settings');          
    }

    function load_shortcodes(){       
        
    }
}
