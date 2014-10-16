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
require_once 'CRM/Core/Config.php';
require_once 'CRM/Contribute/BAO/Widget.php';
require_once 'CRM/Utils/Request.php';

$config = CRM_Core_Config::singleton();
$template = CRM_Core_Smarty::singleton();

$widgetId = CRM_Utils_Request::retrieve('widgetId', 'Positive', CRM_Core_DAO::$_nullObject);
$embed = CRM_Utils_Request::retrieve('embed', 'Positive', CRM_Core_DAO::$_nullObject);

if (isset($format)) {
  $jsonvar .= $cpageId;
}

$data = "";
if (isset($embed) && (true == $embed)) {

} else {
  $data = CRM_Wci_BAO_Widget::getWidgetData($widgetId);
  $template->assign('wciform', $data);

  $template->template_dir[] = $_SERVER['DOCUMENT_ROOT'] . "/F3/sites/all/modules/civicrm/extensions/civicrm-wci/templates/CRM/Wci/Page";
  $wcidata = $template->fetch('wciwidget.tpl');
  $output = 'var wciwidgetcode =  ' . json_encode($wcidata) . ';';
  echo $output;

}

CRM_Utils_System::civiExit();
