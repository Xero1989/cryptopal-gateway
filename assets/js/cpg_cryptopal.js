var temp;

//alert("fdfd");

function load_product_id_into_modal(id_product) {
  jQuery("#product_id").val(id_product);
}

function get_app_url_from_cryptopal() {
  let action = "get_app_url_from_cryptopal";
  let product_id = jQuery("#modal_cryptopal #product_id").val();
  let amount = jQuery("#modal_cryptopal #amount").val();

  jQuery("#modal_cryptopal #bt_cryptopal").attr("disabled", true);
  // jQuery("#modal_cryptopal #bt_cryptopal").val("Sending Data...");

  console.log("enviando " + amount);

  jQuery.ajax({
    url: url_admin_ajax,
    type: "post",
    data: {
      action: action,
      product_id: product_id,
      amount: amount
    },
    success: function (server_response) {
      console.log("success");

      temp = server_response = JSON.parse(server_response);
      url = server_response["url"];

      if (url != "")
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=390,width=600,height=500");

      jQuery("#modal_cryptopal #bt_cryptopal").attr("disabled", false);
      jQuery("#modal_cryptopal #bt_cryptopal").val("Nastavi kupovinu");

      //show_message(server_response, "ajax_response_message");
    },
  });
}

function open_cryptopal_app_window(url_cryptopal_app) {
  console.log("success");
 // alert("open window cripto "+url_cryptopal_app);

  
 // if (url_cryptopal_app != "")
    window.open(url_cryptopal_app, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=390,width=600,height=500");
}
