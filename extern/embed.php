<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.4                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id$
 */


/*
<script type="text/javascript" src="http://drupal.local/sites/all/modules/civicrm/extensions/civicrm-wci/extern/wciwidget.php?widgetId=1"></script>
*/  

require_once '../../../civicrm.config.php';
require_once '../wci-helper-functions.php';
require_once 'CRM/Core/Config.php';
require_once 'CRM/Contribute/BAO/Widget.php';
require_once 'CRM/Utils/Request.php';

$wciembed_js = '// Cleanup functions for the document ready method
if ( document.addEventListener ) {
    DOMContentLoaded = function() {
        document.removeEventListener( "DOMContentLoaded", DOMContentLoaded, false );
        onReady();
    };
} else if ( document.attachEvent ) {
    DOMContentLoaded = function() {
        // Make sure body exists, at least, in case IE gets a little overzealous
        if ( document.readyState === "complete" ) {
            document.detachEvent( "onreadystatechange", DOMContentLoaded );
            onReady();
        }
    };
}
if ( document.readyState === "complete" ) {
    // Handle it asynchronously to allow scripts the opportunity to delay ready
    setTimeout( onReady, 1 );
}

// Mozilla, Opera and webkit support this event
if ( document.addEventListener ) {
    // Use the handy event callback
    document.addEventListener( "DOMContentLoaded", DOMContentLoaded, false );
    // A fallback to window.onload, that will always work
    window.addEventListener( "load", onReady, false );
    // If IE event model is used
} else if ( document.attachEvent ) {
    // ensure firing before onload,
    // maybe late but safe also for iframes
    document.attachEvent("onreadystatechange", DOMContentLoaded);

    // A fallback to window.onload, that will always work
    window.attachEvent( "onload", onReady );
}

function onReady( ) {
  document.getElementById("widgetwci").innerHTML = wciwidgetcode;
}';

$config = CRM_Core_Config::singleton();
$template = CRM_Core_Smarty::singleton();

$widgetId = CRM_Utils_Request::retrieve('widgetId', 'Positive', CRM_Core_DAO::$_nullObject);
if(empty($widgetId)) {
  $embed = CRM_Utils_Request::retrieve('id', 'Positive', CRM_Core_DAO::$_nullObject);
  $widgetId = CRM_Wci_BAO_EmbedCode::getWidgetId($embed);

  if(empty($widgetId)) {
    $widgetId = civicrm_api3('setting', 'getValue', array('group' => 'Wci Preference', 'name' => 'default_wci_widget'));
  }
}
$preview = CRM_Utils_Request::retrieve('preview', 'Positive', CRM_Core_DAO::$_nullObject);

if (isset($format)) {
  $jsonvar .= $cpageId;
} else {
  $data = CRM_Wci_BAO_Widget::getWidgetData($widgetId);
  $template->assign('wciform', $data);
  $template->assign('cpageId', $data['button_link_to']);
  $template->assign('preview', $preview);

  if ($data["override"] == '0') {
    $template->template_dir[] = getWciWidgetTemplatePath();
    $wcidata = $template->fetch('wciwidget.tpl');
  } else {
    $wcidata = $template->fetch('string:' . html_entity_decode($data['custom_template']));
  }
  $output = 'var wciwidgetcode =  ' . json_encode($wcidata) . ';';
  
  $output = $output . $wciembed_js;
  echo $output;
}

CRM_Utils_System::civiExit();
