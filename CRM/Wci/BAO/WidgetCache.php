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

class CRM_Wci_BAO_WidgetCache extends CRM_Wci_DAO_WidgetCache {

  /**
   * class constructor
   */
  function __construct() {
    parent::__construct();
  }

  /**
   * Function to create widget cache
   * takes an associative array 
   *
   * This function is invoked from within the web form layer and also from the api layer
   *
   * @param array   $params      (reference ) an assoc array of name/value pairs
   *
   * @return object CRM_Wci_BAO_WidgetCache object
   * @access public
   * @static
   */
  static function create(array $params) {

    // check required params
    if (!self::dataExists($params)) {
      CRM_Core_Error::fatal('Not enough data to create a progress bar formula entry.');
    }

    $widget_cache = new CRM_Wci_BAO_WidgetCache();
    $widget_cache->copyValues($params);

    $widget_cache->save();

    return $widget_cache;
  }

  /**
   * Get a list of Widgets matching the params, where params keys are column
   * names of civicrm_wci_widget.
   *
   * @param array $params
   * @return array of CRM_Wci_BAO_ProgressBarFormula objects
   */
  static function retrieve(array $params) {
    $result = array();

    $widget_cache = new CRM_Wci_BAO_WidgetCache();
    $widget_cache->copyValues($params);
    $widget_cache->find();

    while ($widget_cache->fetch()) {
      $result[(int) $widget_cache->id] = clone $widget_cache;
    }

    $widget_cache->free();

    return $result;
  }

  /**
   * Wrapper method for retrieve
   *
   * @param mixed $id Int or int-like string representing widget ID
   * @return CRM_Wci_BAO_ProgressBarFormula
   */
  static function retrieveByID($id) {
    if (!is_int($id) && !ctype_digit($id)) {
      CRM_Core_Error::fatal(__CLASS__ . '::' . __FUNCTION__ . ' expects an integer.');
    }
    $id = (int) $id;

    $widget_cache = self::retrieve(array('id' => $id));

    if (!array_key_exists($id, $widget_cache)) {
      CRM_Core_Error::fatal("No formula entry with ID $id exists.");
    }

    return $widget_cache[$id];
  }

  public static function setWidgetCache($widgetId, $code) {
    $cacheTime = civicrm_api3('setting', 'getValue',
      array('group' => 'Wci Preference', 'name' => 'widget_cache_timeout'));
    $expire_on = time() + ($cacheTime * 60);
    $query = "INSERT INTO civicrm_wci_widget_cache (widget_id, widget_code, expire)
    VALUES (%1, %2, %3)
    ON DUPLICATE KEY UPDATE widget_id = %1, widget_code = %2, expire = %3";
    $params = array(
      1 => array($widgetId, 'Integer'),
      2 => array($code, 'String'),
      3 => array($expire_on, 'Integer')
    );
    CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_WidgetCache');
  }
  
  public static function getWidgetCache($widgetId) {
    $code = "";
    $query = "SELECT widget_code FROM civicrm_wci_widget_cache where widget_id = %1
    AND expire >= %2";
    $cacheTime = civicrm_api3('setting', 'getValue',
      array('group' => 'Wci Preference', 'name' => 'widget_cache_timeout'));
    $expire_on = time() + ($cacheTime * 60);
    $dao = CRM_Core_DAO::executeQuery($query, array(1 => array($widgetId, 'Integer'),
      2 => array($expire_on, 'Integer')), TRUE, 'CRM_Wci_DAO_WidgetCache');
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
}
