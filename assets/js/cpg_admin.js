var temp;

jQuery(document).ready(function () {
  
});


function cpg_save_settings() {
  
  var action = "cpg_save_settings";  
  let cpg_enable = jQuery("#cpg_enable").prop("checked");
  let cpg_description = jQuery("#cpg_description").val();
  let cpg_merchant_id = jQuery("#cpg_merchant_id").val();
  let cpg_webhook_url = jQuery("#cpg_webhook_url").val();

  jQuery(".bt_save_settings").attr("disabled", true);
  jQuery(".bt_save_settings").val("Sending Data...");

  jQuery.ajax({
    url: url_admin_ajax,
    type: "post",
    data: {
      action: action,
      cpg_enable: cpg_enable,      
      cpg_description: cpg_description,      
      cpg_merchant_id: cpg_merchant_id,      
      cpg_webhook_url: cpg_webhook_url,      
    },
    success: function (server_response) {
      server_response = JSON.parse(server_response);      

      jQuery(".bt_save_settings").attr("disabled", false);
      jQuery(".bt_save_settings").val("Save Settings");
      
      show_message(server_response, "ajax_response_message");
    },
  });
}

