<?php

class CPG_Useful
{

    function ajax_server_response($server_response = array())
    {
        if (!isset($server_response["status"])) {
            $server_response["status"] = "success";
        }
        if (!isset($server_response["message"])) {
            $server_response["message"] = "The operation has been successful";
        }

        echo json_encode($server_response);
        die();
    }

    function log($data, $to_json = true)
    {

        $path = ABSPATH . '/log.json';
        //$path = plugin_dir_url(__FILE__) . 'log.json';

        //$size = filesize($path);

        //$obj = fopen($path, 'a');

        $obj = fopen($path, 'a');

        // session_start();

        // if ($_SESSION["is_first_write_log"]) {
        //     $obj = fopen($path, 'w');
        //     $_SESSION["is_first_write_log"] = false;
        // } else {
        //     $obj = fopen($path, 'a');
        // }

        if ($to_json)
            $data = json_encode($data);
        // fwrite($obj, "sicze ".$size);
        fwrite($obj, $data);
        fwrite($obj, "\n\n");

        fclose($obj);
    }
}
