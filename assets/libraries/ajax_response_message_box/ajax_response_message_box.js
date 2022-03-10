let show_message = (
  server_response,
  id_message_box = "ajax_response_message"
) => {
  let status = server_response["status"];
  let message = server_response["message"];

  jQuery("#" + id_message_box).hide();
  jQuery("#" + id_message_box).removeClass();

  jQuery("#" + id_message_box).addClass("ajax_response_message_box");
  jQuery("#" + id_message_box).addClass(status);
  jQuery("#" + id_message_box).text(message);

  jQuery("#" + id_message_box).show(800);

  setTimeout(() => {
    jQuery("#" + id_message_box).hide(800);
  }, 4000);
};
