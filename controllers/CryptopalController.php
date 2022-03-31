<?php

class CPG_CryptopalController
{

  static function show_crypto_payment_button()
  {
    global $product;

    $id = $product->get_id();

    //CPG_Useful::log("woocommerce_checkout_fields");

    //CPG_Useful::log("id producto $id");

    echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
             <div class="text-center">
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_cryptopal" data-whatever="@mdo" onclick="javascript:load_product_id_into_modal(' . $id . ')">Kupi</button>
             </div>
           </div>';
  }

  static function write_modal()
  {
    wp_enqueue_script('js_cryptopal', plugin_dir_url(__FILE__) . '../assets/js/cpg_cryptopal.js', array(), '1.0');
    //wp_localize_script('js_cryptopal', 'url_admin_ajax', admin_url('admin-ajax.php'));
    wp_add_inline_script('js_cryptopal', 'var url_admin_ajax = "' . admin_url('admin-ajax.php') . '";');

    //die(plugin_dir_url(__FILE__) . '../assets/js/cpg_cryptopal.js');

    CPG_Blade::view('cpg-modal-payment');
  }

  static function get_app_url_from_cryptopal()
  {
    CPG_Useful::log("get_app_url_from_cryptopal");
    //CPG_Useful::log($_POST);

    $id_product = $_POST["product_id"];
    $product = wc_get_product($id_product);

    $name = $product->get_title();
    $price = $product->get_price();
    $amount = $_POST["amount"];

    // CPG_Useful::log("id producto $id_product name $name price $price currency $currency");

    $items = array("name" => $name, "amount" => $amount, "price" => $price);

    $response = CPG_CryptopalController::get_api_info($items);

    $url_payment = $response["url"];

    CPG_Useful::log("url $url_payment");

    if ($response != false) {
      CPG_Useful::ajax_server_response(array("message" => "Settings has been saved correctly", "url" => $url_payment));
    } else CPG_Useful::ajax_server_response(array("status" => "error", "message" => "There was an error consulting the data,please try again...", "url" => ""));
  }


  static function get_api_info($items)
  {
    $url = "https://demo.teslacryptocap.com/cryptopalPayments";

    $webshop_id = get_option("cpg_webshop_id");
    $currency = get_woocommerce_currency();

    $body = array(
      "items" => array($items),
      "webshopID" => $webshop_id,
      "currency" => $currency
    );

    CPG_Useful::log($body);
    CPG_Useful::log($url);

    $response = wp_remote_post(
      $url,
      array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => wp_json_encode($body),
      )
    );

    $response_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($response_code == 200) {
      $body = wp_remote_retrieve_body($response);

      $body = json_decode($body, true);
      CPG_Useful::log($body);

      return $body;
    } else {
      CPG_Useful::log("Ocurrio un error consultando el API crytopal...");
      CPG_Useful::log($response);
      CPG_Useful::log($body);

      $body = json_decode($body, true);

      return false;
    }
  }


  static function checkout_field_process()
  {
    CPG_Useful::log("checkout_field_process");
    CPG_Useful::log($_POST);

    // $payment_method = $order->get_payment_method();

    // if ($payment_method == "pago_efectivo_gateway") 

    $shipping_methods = $_POST['shipping_method'];

    // if (!isset($_POST['billing_departamentos']) || $_POST['billing_departamentos'] == "")
    //   wc_add_notice(__('<b>Facturacion Departamento</b> es un campo requerido.'), 'error');

  }

  static function cryptopal_notification()
  {
    CPG_Useful::log("register webhhook");

    register_rest_route(
      "cryptopal_gateway/v1/", //Namespace
      "receive_callback",    //Endpoint
      //WEBHOOK EXMPLE
      //https://staging2.xdsclients.com/wp-json/xirect_pagoefectivo/v1/receive_callback
      array(
        "methods" => "POST",
        "callback" => "CPG_CryptopalController::cryptopal_gateway_receive_callback"

      )
    );
  }

  static function cryptopal_gateway_receive_callback(WP_REST_Request $req)
  {
    $headers = $req->get_headers();
    $body = $req->get_body();

    // $header_signature = $req->get_header('pe_signature');

    // $gateway = create_xirect_pagoefectivo_gateway();
    // $secret_key = $gateway->settings['xpeg_secret_key'];

    // $mix_signature = hash_hmac('sha256', $body, $secret_key);

    // //Check pagoefectivo token its correct
    // if ($header_signature != $mix_signature)
    //   return http_response_code(401);


    //Change order status
    $body = json_decode($body, true);

    CPG_Useful::log("webhhook data");
    CPG_Useful::log($body);
    //{"paymentID":"WCZzs4JecoKtTif9W","status":"successful"}

    // $id_order = $body["data"]["transactionCode"];

    // $order = wc_get_order($id_order);
    // $order->set_status('wc-completed');
    // $order->save();

    return http_response_code(200);
  }
}
