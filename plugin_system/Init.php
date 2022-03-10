<?php

class XIS_Init
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
     //   add_filter('woocommerce_checkout_fields', 'XIS_CheckoutController::woocommerce_checkout_fields',10,2);
    }

    function load_actions()
    {
        add_action('admin_menu', 'XIS_AdminController::create_custom_menu');
        add_action('wp_ajax_xis_save_products_ids', 'XIS_AdminController::save_products_ids');          
    }

    function load_shortcodes(){
        
        add_shortcode('xis_footer_form_suscribe', 'XIS_FooterSuscribeFormController::show_form');
    }
}
