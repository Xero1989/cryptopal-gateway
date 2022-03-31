<?php

class Cryptopal_Gateway_Main extends WC_Payment_Gateway
{
    public $api_pagoefectivo;

    /**
     * Initialize this class
     *          
     */
    public function __construct()
    {

        $img_centros_1 = array("BBVA", "BCP", "INTERBANK", "SCOTIABANK", "BANBIF", "CAJA AREQUIPA", "BANCO PICHINCHA");
        $img_centros_2 = array("BBVA", "BCP", "INTERBANK", "SCOTIABANK", "BANBIF", "WESTERN UNION", "TAMBO", "KASNET", "YA GANASTE", "AGENTE RED DIGITAL", "NIUBIZ", "MONEY GRAM", "CAJA AREQUIPA", "DISASHOP", "CELLPOWER");

        // $description_html = '<div class="div_title">
        // <h3>
        // Genera un código de 8 dígitos y págalo a través de:
        // </h3>

        // <a class="label_how_it_work"> ¿Cómo funciona? </a>

        // </div>

        // <p>
        // <b class="check_sign"> Banca Móvil / Internet -</b> Paga en BBVA, BCP, Interbank, Scotiabank,BanBif, Caja Arequipa y Banco Pichincha, a través de la opción pago de servicios.
        // </p>

        // <div class="div_payment_center">';
        // foreach($img_centros_1 as $img){
        //    $description_html .= '<img src="' . plugin_dir_url(__FILE__) . 'assets/images/centros_de_pago/'.$img.'.png" />';
        // }

        // $description_html .= '

        // </div>

        // <p style="margin-top: 2em;">
        // <b class="check_sign"> Agentes y Bodegas -</b> Deposita en BBVA, BCP, Interbank, Scotiabank, BanBif, Western Union, Tambo+, Kasnet, Ya Ganaste, Red Digital, Comercio Niubiz Multiservicio, MoneyGram, Caja Arequipa, Disashop, Cellpower.        
        // </p>

        // <div class="div_payment_center" id="div_payment_center_2">';
        // foreach($img_centros_2 as $img){
        //     $description_html .= '<img src="' . plugin_dir_url(__FILE__) . 'assets/images/centros_de_pago/'.$img.'.png" />';
        //  }

        //  $description_html .= '

        // </div>';

        $description_html = "Cryptopal gateway allows you to pay on crypto-currency";

        // $this->api_pagoefectivo = new PagoEfectivoGatewayApi();
        $this->id = 'cryptopal_gateway'; // payment gateway plugin ID
        $this->title = "Cryptopal Gateway";
        $this->description = $description_html;
        $this->icon = plugin_dir_url(__FILE__) . '../assets/img/antonella-icon.png'; // URL of the icon that will be displayed on checkout page near your gateway name
        $this->has_fields = true; // in case you need a custom credit card form
        $this->method_title = 'Cryptopal Gateway';
        $this->method_description = 'This gateway allows you to make payments with Cryptopal App'; // will be displayed on the options page

        // Method with all the options fields
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();

        // wp_enqueue_style("css_pagoefectivo_gateway", plugin_dir_url(__FILE__) . "assets/css/pagoefectivo_gateway.css");

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * Declare the form settings for the plugin     *          
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title'       => 'Enable/Disable',
                'label'       => 'Enable Cryptopal Gateway',
                'type'        => 'checkbox',
                'description' => '',
                'default'     => 'no'
            ),

            'cpg_description' => array(
                'title'       => 'Description',
                'type'        => 'textarea',
                'description' => 'Description of this Cryptopal Gateway',
                'default'     => '',
                'desc_tip'    => true,
            ),

            'cpg_webshop_id' => array(
                'title'       => 'Webshop ID',
                'type'        => 'text',
                'description' => 'The id of the cryptopal webshop',
                'default'     => '',
                'desc_tip'    => true,
            ),

            'cpg_webhook' => array(
                'title'       => 'Webhook URL',
                'type'        => 'text',
                'description' => 'The webhook URL of the cryptopal webshop',
                'default'     => '',
                'desc_tip'    => true,
            ),
        );
    }

    /**
     * Process the form settings for the plugin
     *          
     */
    public function process_admin_options()
    {
        $post_data = $this->get_post_data();

        $description = $post_data["woocommerce_cryptopal_gateway_cpg_description"];
        $webshop_id = $post_data["woocommerce_cryptopal_gateway_cpg_webshop_id"];
        $webhook = $post_data["woocommerce_cryptopal_gateway_cpg_webhook"];

        $settings = new WC_Admin_Settings();

        if ($description == "") {
            $settings->add_error('You must enter a "Description"');
        }

        if ($webshop_id == "") {
            $settings->add_error('You must enter a "Webshop ID"');
        }

        if ($webhook == "") {
            $settings->add_error('You must enter a "Webhook"');
        }

        return parent::process_admin_options();
    }

    /**
     * Try to get the authentication token for pago efectivo gateway
     *     
     * @param int $order_id number wich identify an unique order     
     */
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        $products = array();
        foreach ($order->get_items() as $item_id => $item) {
            //$id_product = $item->get_product_id();
            $product = $item->get_product();

            $name = $product->get_title();
            $price = $product->get_price();
            $amount = $item->get_total();

            //$product_name = $item->get_name();
            //$quantity = $item->get_quantity();
            //$subtotal = $item->get_subtotal();

            $product = array("name" => $name, "amount" => $amount, "price" => $price);
            array_push($products,$product);
        }

        //$settings = compact('xpeg_api_token_url', 'xpeg_api_payment_url', 'xpeg_id_service', 'xpeg_access_key', 'xpeg_secret_key', 'xpeg_expiration_day', 'xpeg_merchant_name', 'xpeg_payment_concept', 'xpeg_merchant_category', 'xpeg_user_ubigeo', 'xpeg_user_document_type', 'xpeg_user_code_country');

        CPG_Useful::log($products);
        $response = CPG_CryptopalController::get_api_info($products);

       

        if (!$response) {
            return;
        } else {

            $url_payment = $response["url"];        

            CPG_Useful::log("All good $url_payment");

            return;
            // session_start();

            // //  update_post_meta($id_order, 'xup_departamento', $departamento);

            // $_SESSION["xpeg_cip"] = $result["data"]["cip"];
            // $_SESSION["xpeg_cip_url"] = $result["data"]["cipUrl"];
            // $_SESSION["xpeg_numero_pedido"] = $result["data"]["transactionCode"];

            // Mark as on-hold (we're awaiting the payment)
            $order->update_status('on-hold', __('Awaiting offline payment', 'wc-gateway-offline'));

            // Reduce stock levels
            $order->reduce_order_stock();

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect

            return array(
                'result'    => 'success',
                'message' => "personalizado",
                'redirect'  => $this->get_return_url($order)
            );
        }
    }

    public function get_api_info($products)
    {
        $url = "https://demo.teslacryptocap.com/cryptopalPayments";

        $webshop_id = $this->settings['cpg_webshop_id'];
        //        $webshop_id = get_option("cpg_webshop_id");
        $currency = get_woocommerce_currency();

        $body = array(
            "items" => $products,
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
}
