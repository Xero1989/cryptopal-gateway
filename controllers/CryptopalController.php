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



  static function checkout_field_process()
  {
    CPG_Useful::log("checkout_field_process");
    CPG_Useful::log($_POST);

    $payment_method = $order->get_payment_method();
    CPG_Useful::log("payment method " . $payment_method);

    // if ($payment_method == "pago_efectivo_gateway") 

    $shipping_methods = $_POST['shipping_method'];

    CPG_CryptopalController::get_app_url_from_cryptopal();

    // if (!isset($_POST['billing_departamentos']) || $_POST['billing_departamentos'] == "")
    //   wc_add_notice(__('<b>Facturacion Departamento</b> es un campo requerido.'), 'error');

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
      // CPG_Useful::ajax_server_response(array("message" => "Settings has been saved correctly", "url" => $url_payment));
      wp_enqueue_script('js_cryptopal', plugin_dir_url(__FILE__) . '../assets/js/cpg_cryptopal.js', array(), '1.0');

      wp_add_inline_script('js_cryptopal', 'var url_cryptopal_app = "' . $url_payment . '";');
    } else {
      //  CPG_Useful::ajax_server_response(array("status" => "error", "message" => "There was an error consulting the data,please try again...", "url" => ""));

      wp_add_inline_script('js_cryptopal', 'var url_cryptopal_app = "";');
    }

    echo '<script type="text/javascript" >
              open_cryptopal_app_window();
            </script>';
  }


  static function get_api_info($items)
  {
    $url = "https://demo.teslacryptocap.com/cryptopalPayments";

    $payment_gateway_id = 'cryptopal_gateway';

    // Get an instance of the WC_Payment_Gateways object
    $payment_gateways   = WC_Payment_Gateways::instance();

    // Get the desired WC_Payment_Gateway object
    $payment_gateway    = $payment_gateways->payment_gateways()[$payment_gateway_id];

    //$webshop_id = get_option("cpg_webshop_id");
    $webshop_id = $payment_gateway->cpg_webshop_id;
    $currency = get_woocommerce_currency();

    $body = array(
      "items" => array($items),
      "webshopID" => 'K5xkG3DFfSpNMoi9Y',
      "currency" => $currency
    );

    CPG_Useful::log($body);
    // CPG_Useful::log($url);

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

  static function open_crypto_payment_window($text, $order)
  {
    session_start();
    $url = $_SESSION['cryptopal_url_payment'];

    $payment_method = $order->get_payment_method();


    if ($payment_method == "cryptopal_gateway") {

      wp_enqueue_script('js_cryptopal', plugin_dir_url(__FILE__) . '../assets/js/cpg_cryptopal.js', array(), '1.0');

      //wp_add_inline_script('js_cryptopal', 'var url_cryptopal_app = "'.$url_payment.'";');
      wp_add_inline_script('js_cryptopal', 'open_cryptopal_app_window("' . $url . '");');

      //return 'Hola mundo crypto '.$url.$payment_method;

    }

    return '';
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

    //Change order status
    $body = json_decode($body, true);

    CPG_Useful::log("webhook data");
    CPG_Useful::log($body);
    //{"paymentID":"WCZzs4JecoKtTif9W","status":"successful"}
    $paymentID = $body["paymentID"];        

    $args = array(
      'return' => 'ids',
      'payment_method' => 'cryptopal_gateway',
      'cryptopal_paymentID' => $paymentID
  );
  $orders = wc_get_orders( $args );

  //$orders = wc_get_orders( array( 'cryptopal_paymentID' => 'somevalue' ) );

  CPG_Useful::log('response del webhook '.$orders);
  CPG_Useful::log(json_decode($orders, true));
  

  //$order->get_id()

    // $order = wc_get_order($id_order);  
    // $order->set_status('wc-completed');
    // $order->save();

    return http_response_code(200);
  }
}