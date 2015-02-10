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
    lastElem = "#addmore_link";
    eval("fname = $('"+lastElem+"').parent().parent();");

    count++;
    dataUrl = "civicrm/wci/progress-bar/add?PBSource_block=1&snippet=4&PBblockId=" + count;

    cj.ajax({
        url     : dataUrl,
        async   : false,
        success : function(html){
            cj(fname).before(html);
        }
    });
    $('input[name=contrib_count]').val(count);

  });

  $(document).on('click', '#remove_link', function( e ) {
    e.preventDefault();

    var rem_name = e.target.name;
    //assuming that - is the delimiter. second string will be the count
    var rem_name_ar = rem_name.split('-');

    $('input[name=rem_ids]').val($('input[name=contrib_elem_'+ rem_name_ar[1]+']').val() + ',' + $('input[name=rem_ids]').val());

    $('#PBSource-'+ rem_name_ar[1]).remove();
    $('#contrib_elem_'+ rem_name_ar[1]).remove();

    $('input[name=contrib_elem_'+ rem_name_ar[1]+']').remove();

    var count = parseInt($('input[name=contrib_count]').val());
    count--;
    $('input[name=contrib_count]').val(count);
  });
});
