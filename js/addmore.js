/*
 +--------------------------------------------------------------------+
 | CiviCRM Widget Creation Interface (WCI) Version 1.0                |
 +--------------------------------------------------------------------+
 | Copyright Zyxware Technologies (c) 2014                            |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM WCI.                                |
 |                                                                    |
 | CiviCRM WCI is free software; you can copy, modify, and distribute |
 | it under the terms of the GNU Affero General Public License        |
 | Version 3, 19 November 2007.                                       |
 |                                                                    |
 | CiviCRM WCI is distributed in the hope that it will be useful,     |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of     |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License along with this program; if not, contact Zyxware           |
 | Technologies at info[AT]zyxware[DOT]com.                           |
 +--------------------------------------------------------------------+
*/

cj(function ( $ ) {
  $(document).ready(function(){
    var count = parseInt($('input[name=contrib_count]').val());
    for ( var i = 2; i <= count; i++ ) {
      $('#' + "contribution_page_" + i).parent().parent().before('<div class="crm-wci-pb"><hr></div>');
      $('#' + "contribution_page_" + i).after(
      '<a id=\"remove_link\" class=\"form-link\" href=\"remove\" name=\"remove_link-' + i + '\"> Remove</a>');
      $('#' + "contribution_page_" + i).parent().parent().attr("id", "crm-section-con-" + i);
      $('#' + "financial_type_" + i).parent().parent().attr("id", "crm-section-type-" + i);
      $('#' + "percentage_" + i).parent().parent().attr("id", 'crm-section-per-' + i);
      $('#' + "contribution_start_date_" + i).parent().parent().attr("id", 'crm-section-startdate-' + i);
      $('#' + "contribution_end_date_" + i).parent().parent().attr("id", 'crm-section-enddate-' + i);
    }
    $('#goal_amount').parent().after('<div class="crm-wci-pb"><hr></div><label><SMALL>Progressbar shows the sum of percentage of contributions done on each selected contribution page or financial type.</SMALL></label>');
  });
  $("#ProgressBar").validate({
    rules: {
      starting_amount: {
        required: true,
        number: true
      },
      progressbar_name: {
        required: true
      },
      goal_amount: {
        required: true,
        number: true
      },
      contribution_page_1: {
        required: true
      },
      percentage_1: {
        required: true,
        max: 100,
        number: true
      }
    }
  });

  $('#addmore_link').on('click', function( e ) {
    e.preventDefault();
    var count = parseInt($('input[name=contrib_count]').val());
    lastElem = "#percentage_"+ count;
    eval("fname = $('"+lastElem+"').parent();");

    count++;
    dataUrl = "/F4/civicrm/wci/progress-bar/add?PBSource_block=1&snippet=4&PBblockId=" + count;

    cj.ajax({
        url     : dataUrl,
        async   : false,
        success : function(html){
            cj(fname).after(html);
        }
    });
    $('input[name=contrib_count]').val(count);

  });

  $(document).on('click', '#remove_link', function( e ) {
    e.preventDefault();

    var rem_name = e.target.name;
    //assuming that - is the delimiter. second string will be the count
    var rem_name_ar = rem_name.split('-');
    var contri_page = "\"#percentage_" + rem_name_ar[1] + "\"";
    $('#crm-section-con-'+ rem_name_ar[1] +'').remove();
    $('#crm-section-type-'+ rem_name_ar[1] +'').remove();
    $('#crm-section-per-'+ rem_name_ar[1] +'').remove();
    $('#crm-section-startdate-'+ rem_name_ar[1] +'').remove();
    $('#crm-section-enddate-'+ rem_name_ar[1] +'').remove();
    var count = parseInt($('input[name=contrib_count]').val());
    count--;
    $('input[name=contrib_count]').val(count);
  });
});
