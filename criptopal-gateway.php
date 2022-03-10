<?php

/*
Plugin Name: CryXirect Inkamall Scripts
Plugin URI:
Description: This plugin allows to implement aditional functionalities to Inkamall.com
Version: 0.1
Author: Xirect
License: GPL2+
*/


register_activation_hook(__FILE__, 'xis_plugin_activation');

function xis_plugin_activation()
{
   // add_option("xis_products_ids", "");
}

register_deactivation_hook(__FILE__, 'xis_plugin_deactivation');


function xis_plugin_deactivation()
{
   // delete_option("xis_products_ids");
}

require __DIR__ . '/vendor/autoload.php';

require 'plugin_system/Init.php';

require 'controllers/AdminController.php';
require 'controllers/CheckoutController.php';
require 'controllers/FooterSuscribeFormController.php';

new xis_Init();
