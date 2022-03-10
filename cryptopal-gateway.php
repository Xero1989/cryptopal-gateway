<?php

/*
Plugin Name: Cryptopal Gateway
Plugin URI:
Description: This plugin is a crypto currency payment processor, wich allows you make payments with crypto currency
Version: 0.1
Author: Jorge Blanco Suárez
Author URI: jorgewebcuba.000webhostapp.com/curriculum-vitae/
License: GPL2+
*/


register_activation_hook(__FILE__, 'cpg_plugin_activation');

function cpg_plugin_activation()
{
   add_option("cpg_enable", true);
   add_option("cpg_description", "");
   add_option("cpg_merchant_id", "");
   add_option("cpg_webhook_url", "");
}

register_deactivation_hook(__FILE__, 'cpg_plugin_deactivation');


function cpg_plugin_deactivation()
{
    delete_option("cpg_enable");
    delete_option("cpg_description");
    delete_option("cpg_merchant_id");
    delete_option("cpg_webhook_url");
}

require __DIR__ . '/vendor/autoload.php';

require 'plugin_system/Init.php';

require 'controllers/AdminController.php';
//require 'controllers/CheckoutController.php';

new CPG_Init();