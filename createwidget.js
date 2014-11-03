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
  }
  $(document).ready(setState)
  $('#override').click(setState);

});

