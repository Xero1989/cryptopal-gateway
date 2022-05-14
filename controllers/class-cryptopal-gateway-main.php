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

        $this->id = 'cryptopal_gateway'; // payment gateway plugin ID
        $this->title = "Cryptopal Gateway";
        $this->description = "Cryptopal gateway allows you to pay on crypto-currency";
        $this->icon = plugin_dir_url(__FILE__) . '../assets/img/antonella-icon.png'; // URL of the icon that will be displayed on checkout page near your gateway name
        $this->has_fields = true; // in case you need a custom credit card form
        $this->method_title = 'Cryptopal Gateway';
        $this->method_description = 'This gateway allows you to make payments with Cryptopal App'; // will be displayed on the options page

        // Method with all the options fields
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();

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

            /*'cpg_webhook' => array(
                'title'       => 'Webhook URL',
                'type'        => 'text',
                'description' => 'The webhook URL of the cryptopal webshop',
                'default'     => '',
                'desc_tip'    => true,
            ),*/
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
        // $webhook = $post_data["woocommerce_cryptopal_gateway_cpg_webhook"];

        $settings = new WC_Admin_Settings();

        if ($description == "") {
            $settings->add_error('You must enter a "Description"');
        }

        if ($webshop_id == "") {
            $settings->add_error('You must enter a "Webshop ID"');
        }

        /*  if ($webhook == "") {
            $settings->add_error('You must enter a "Webhook"');
        }*/

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
            array_push($products, $product);
        }

        //$settings = compact('xpeg_api_token_url', 'xpeg_api_payment_url', 'xpeg_id_service', 'xpeg_access_key', 'xpeg_secret_key', 'xpeg_expiration_day', 'xpeg_merchant_name', 'xpeg_payment_concept', 'xpeg_merchant_category', 'xpeg_user_ubigeo', 'xpeg_user_document_type', 'xpeg_user_code_country');

        CPG_Useful::log($products);
        $response = CPG_CryptopalController::get_api_info($products);



        if (!$response) {
            return;
        } else {

            $url_payment = $response["url"];
            $paymentID = $response["paymentID"];

           // CPG_Useful::log("URL de pago $url_payment");



            //return;
            session_start();
            $_SESSION['cryptopal_url_payment'] = $url_payment;

            $order->update_meta_data('cryptopal_paymentID', $paymentID);

            // $meta_data = $order->get_meta('cryptopal_paymentID');

            // CPG_Useful::log("metadata created >> $meta_data");

            // $args = array(
            //   'return' => 'ids',
            //   //  'payment_method' => 'cryptopal_gateway',
            //    // 'cryptopal_paymentID' => '$paymentID123456'
            //    'paginate' => false
            // );
            // $orders = wc_get_orders($args);

          

            //$orders = wc_get_orders( array( 'cryptopal_paymentID' => 'somevalue' ) );

           // CPG_Useful::log('response del webhook ' . $orders);
            //CPG_Useful::log(json_decode($orders, true));

            // CPG_Useful::log('json_encode($orders)');
            // CPG_Useful::log(json_encode($orders));
        //     CPG_Useful::log("orders");
        //     CPG_Useful::log($orders);    
        //     CPG_Useful::log("orders [0][0]");       
        //    // CPG_Useful::log($orders[0][0]);   
        //     CPG_Useful::log("orders [0]");       
        //     CPG_Useful::log($orders[0]['ID']);   



            // Mark as on-hold (we're awaiting the payment)
            $order->update_status('on-hold', __('Awaiting for Cryptopal online payment...', 'wc-gateway-offline'));

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
}
