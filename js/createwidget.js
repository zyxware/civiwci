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
