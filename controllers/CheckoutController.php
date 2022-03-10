<?php

class XIS_CheckoutController
{

  function woocommerce_checkout_fields($fields)
    {
       CPG_Useful::log("woocommerce_checkout_fields");
        // XIS_Useful::log($fields);

      //   $fields['shipping']['shipping_distritos'] = [
      //     'type' => 'select',
      //     'label' => "Distrito",
      //     'required' => false,
      //     'class' => array('form-row-wide'),
      //     'clear' => true,
      //     'options' => $distritos,
      //     'priority' => 43
      // ];


      return $fields;
    }

}
