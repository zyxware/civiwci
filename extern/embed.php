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
$embed = CRM_Utils_Request::retrieve('embed', 'Positive', CRM_Core_DAO::$_nullObject);

if (isset($format)) {
  $jsonvar .= $cpageId;
} else {
  $widData = CRM_Wci_BAO_Widget::getWidgetData($widgetId);
  $pbData = CRM_Wci_BAO_ProgressBar::getProgressbarData($widData["progress_bar_id"]);
  $data = array_merge($widData, $pbData);

  $template->assign('wciform', $data);
  $template->assign('cpageId', $data['button_link_to']);
  $template->assign('embed', $embed);

  if ($data["override"] == '0') {
    $template->template_dir[] = getWciWidgetTemplatePath();
    $wcidata = $template->fetch('wciwidget.tpl');
  } else {
    $wcidata = $template->fetch('string:' . html_entity_decode($data['custom_template']));
  }
  $output = 'var wciwidgetcode =  ' . json_encode($wcidata) . ';';
  
  $wciembed = file_get_contents('wciembed.js',FILE_USE_INCLUDE_PATH);
  $output = $output . $wciembed;
  echo $output;
}

CRM_Utils_System::civiExit();
