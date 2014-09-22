// Updated to wait until the document is loaded. addmore_link

jQuery(document).ready(function () {
//  var text = jQuery('h1').text();
//  alert(text);

});

cj(function ( $ ) { 

//  var text = jQuery('h1').text();
//  alert(text);

      $('#addmore_link').on('click', function( e ) {
        e.preventDefault();
//      $('#addmore_link').click(function () {
      var count = parseInt($('input[name=contrib_count]').val());
      count++;
            
      //$('#myDiv').append('<input type="text" id="p_scnt" size="20" name="p_scnt_' + count +'" value="" placeholder="Input Value" /><br>'); 

      //$('#myDiv').append('<select id=\"selectId\" name=\"selectName\" />');
//      $('select[name=contribution_page_1]').parent('div').append('<select name="selectName" />');
//      var contr_name = "contribution_page_" + count.toString();
      //$('input[name=percentage_1]').parent('div').parent('div').parent('div').append('<label>Contribution page</label>');
//      $('#crm-container').append('<label>Contribution page</label>');
      
      var c_page = $('select[name=contribution_page_1]').clone().attr('id', 'choices_' + $(this).index());
      c_page.attr("id", "contribution_page_" + count);
      c_page.attr("name", "contribution_page_" + count);    
      //.insertAfter("select[name=contribution_page_1]");


      $('input[name=percentage_1]').parent().parent().append("<br>")
      $('input[name=percentage_1]').parent().parent().append(c_page);
//      $('input[name=percentage_1]').parent('div').append('<br><select name="contribution_page_' + count +'" />');

      $('input[name=percentage_1]').parent().parent().append('<br><input type="text" size="20" name="percentage_' + count +'" value="" />');
//      $('input[name=contribution_page_' + count + ']').text($('input[name=contribution_page_1]').text());
      
      $('input[name=percentage_1]').parent().parent().append('<a id="#remove_link" href="test" > Remove</a>');
      
      $('input[name=contrib_count]').val(count);
      alert(count);
      //alert(contr_sel);
      //alert($('input[name=contrib_count]').val());
      //alert($('select[name=contribution_page]').val());
      //alert($("select[name=contribution_page] option:selected").text());
      //alert($("#count").val());
      //$('select[name=contribution_page]').
      
      
  });

  $('#remove_link').on('click', function( e ) {
    e.preventDefault();
    alert("hi");
  })
/*  
  $(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        
        $('#addmore_link').live('click', function() {
                $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                i++;
                return false;
      });  
  */
  
});
