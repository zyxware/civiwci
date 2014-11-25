<?php
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

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 *
 */

class CRM_Wci_BAO_WidgetCache extends CRM_Wci_DAO_WidgetCache {

  public static function setWidgetCache($widgetId, $widget) {
    $timenow = time();
    $expire_on = PHP_INT_MAX;
    if ($widget['dynamic'] == TRUE) {
      $cacheTime = civicrm_api3('setting', 'getValue',
        array('group' => 'Wci Preference', 'name' => 'widget_cache_timeout'));
      $expire_on = $timenow + ($cacheTime * 60);
    }
    $query = "INSERT INTO civicrm_wci_widget_cache (widget_id, widget_code, expire, createdtime)
    VALUES (%1, %2, %3, %4)
    ON DUPLICATE KEY UPDATE widget_id = %1, widget_code = %2, expire = %3, createdtime = %4";
    $params = array(
      1 => array($widgetId, 'Integer'),
      2 => array($widget['code'], 'String'),
      3 => array($expire_on, 'Integer'),
      4 => array($timenow, 'Integer')
    );
    CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_WidgetCache');
  }

  public static function getWidgetCache($widgetId) {
    $code = "";
    $query = "SELECT widget_code FROM civicrm_wci_widget_cache where widget_id = %1
    AND expire >= %2";
    $dao = CRM_Core_DAO::executeQuery($query, array(1 => array($widgetId, 'Integer'),
      2 => array(time(), 'Integer')), TRUE, 'CRM_Wci_DAO_WidgetCache');
    if ($dao->fetch()) {
      $code = $dao->widget_code;
    }
    return $code;
  }

  public static function deleteWidgetCache($widgetId) {
    $code = "";
    $query = "DELETE FROM civicrm_wci_widget_cache where widget_id = %1";
    $dao = CRM_Core_DAO::executeQuery($query,
      array(1 => array($widgetId, 'Integer')), TRUE, 'CRM_Wci_DAO_WidgetCache');
  }

  public static function clearCache($pbId) {
    $query = "SELECT wc.widget_id FROM civicrm_wci_widget_cache as wc INNER JOIN civicrm_wci_widget w on w.id = wc.widget_id WHERE w.progress_bar_id =%1";
    $dao = CRM_Core_DAO::executeQuery($query, array(1 => array($pbId, 'Integer')), TRUE, 'CRM_Wci_DAO_WidgetCache');
    if ($dao->fetch()) {
      $widget_id = $dao->widget_id;
      CRM_Wci_BAO_WidgetCache::deleteWidgetCache($widget_id);
    }
  }
}
