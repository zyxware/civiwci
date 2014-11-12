// 
cj(function ( $ ) {
  function setState() {
    if ($('#override').is(':checked') == true) {
      $('#custom_template').attr("disabled",false);
    }
    else {
      $('#custom_template').attr("disabled",true);
    }
    if( $('#progress_bar').val() != "") {
      $('#embd_code').parents('.crm-section').show();    
    } else {
      $('#embd_code').parents('.crm-section').hide();
    }
    
    $('#image').after('<label><br><SMALL>Select a smaller image than Size variant</SMALL></label>');
    $('#logo_image').after('<label><br><SMALL>Select smaller image appropriate for logo</SMALL></label>');
    $('#email_signup_group_id').after("<label><br><SMALL>Those groups that are 'Mailing List' selected are shown.</SMALL></label>");
    $('#size_variant').after("<label><br><SMALL>Fixed width. Height depends on what contents selected.</SMALL></label>");
    
  }
  $(document).ready(setState)
  $('#override').click(setState);

});

