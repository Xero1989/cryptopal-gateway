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
}

register_deactivation_hook(__FILE__, 'cpg_plugin_deactivation');

function cpg_plugin_deactivation()
{
}

require 'plugin_system/Init.php';

require 'controllers/CryptopalController.php';

new CPG_Init();
