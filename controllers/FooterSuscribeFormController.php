<?php

class XIS_FooterSuscribeFormController{


    function show_form(){

        wp_enqueue_script('js_footer_suscribe_form', plugin_dir_url(__FILE__) . '../assets/js/xis_footer_suscribe_form.js');
    wp_localize_script('js_footer_suscribe_form', 'url_admin_ajax', admin_url('admin-ajax.php'));
     
        return XIS_Blade::view("xis_form_suscribe_form",compact(''));
    }
}

