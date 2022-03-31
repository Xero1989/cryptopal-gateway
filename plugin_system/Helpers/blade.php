<?php

class CPG_Blade
{

    static function view($BladePage, $Attributes = array())
    {
        $blade = new Jenssegers\Blade\Blade(plugin_dir_path(dirname(dirname(__FILE__))) . 'views', plugin_dir_path(dirname(dirname(__FILE__))) . 'storage/cache');
        echo $blade->render($BladePage, $Attributes);
    }
}
