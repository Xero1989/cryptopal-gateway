var temp;

jQuery(document).ready(function () {
  jQuery("#xis_footer_suscribe_form #agree_checkbox").change(function () {
    let status = jQuery(this).prop("checked");

    jQuery("#xis_footer_suscribe_form #bt_suscribe").prop("disabled", !status);

    console.log(status);
  });

  jQuery("#xis_footer_suscribe_form #bt_suscribe").prop("disabled", true);
  jQuery("#xis_footer_suscribe_form #agree_checkbox").prop("checked", false);
});

function xis_save_products_ids() {
  var action = "xis_save_products_ids";
  let xis_products_ids = jQuery("#xis_products_ids").val();

  jQuery(".bt_save_settings").attr("disabled", true);
  jQuery(".bt_save_settings").val("Sending Data...");

  jQuery.ajax({
    url: url_admin_ajax,
    type: "post",
    data: {
      action: action,
      xis_products_ids: xis_products_ids,
    },
    success: function (server_response) {
      server_response = JSON.parse(server_response);

      jQuery(".bt_save_settings").attr("disabled", false);
      jQuery(".bt_save_settings").val("Save Settings");

      show_message(server_response, "ajax_response_message");
    },
  });
}

jQuery(document).ready(function () {
  jQuery("#sb_footer_form_suscribe_agree_checkbox").change(function () {
    let status = jQuery(this).prop("checked");

    jQuery(".sib-default-btn").prop("disabled", !status);
  });

  jQuery(".sib-default-btn").prop("disabled", true);
  jQuery("#sb_footer_form_suscribe_agree_checkbox").prop("checked", false);
});
