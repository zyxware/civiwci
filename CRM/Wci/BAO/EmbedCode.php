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
 *
 */
require_once 'CRM/Wci/DAO/NewEmbedCode.php';

class CRM_Wci_BAO_EmbedCode extends CRM_Wci_DAO_EmbedCode {
  
  /**
   * Returns widget id for the embed code
   * Fields : id
   * @return widget id
   * @access public
   */  
  public static function getWidgetId($embed_id) {
  
    $widgetId = 0;
    $query = "SELECT * FROM civicrm_wci_embed_code where id=".$embed_id;
    $params = array();
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_EmbedCode');
    if ($dao->fetch()) {
      $widgetId = $dao->widget_id;
    }  
   
    return $widgetId;
  }    
}
