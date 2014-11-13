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
   * class constructor
   */
  function __construct() {
    parent::__construct();
  }

  /**
   * Function to create embed code
   * takes an associative array 
   *
   * This function is invoked from within the web form layer and also from the api layer
   *
   * @param array   $params      (reference ) an assoc array of name/value pairs
   *
   * @return object CRM_Wci_BAO_EmbedCode object
   * @access public
   * @static
   */
  static function create(array $params) {

    // check required params
    if (!self::dataExists($params)) {
      CRM_Core_Error::fatal('Not enough data to create a progress bar formula entry.');
    }

    $embed_code = new CRM_Wci_BAO_EmbedCode();
    $embed_code->copyValues($params);

    $embed_code->save();

    return $embed_code;
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

    $progress_bar_formula = new CRM_Wci_BAO_ProgressBarFormula();
    $progress_bar_formula->copyValues($params);
    $progress_bar_formula->find();

    while ($progress_bar_formula->fetch()) {
      $result[(int) $progress_bar_formula->id] = clone $progress_bar_formula;
    }

    $progress_bar_formula->free();

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

    $embed_code = self::retrieve(array('id' => $id));

    if (!array_key_exists($id, $embed_code)) {
      CRM_Core_Error::fatal("No formula entry with ID $id exists.");
    }

    return $embed_code[$id];
  }

  /**
   * Check if there is absolute minimum of data to add the object
   *
   * @param array  $params         (reference ) an assoc array of name/value pairs
   *
   * @return boolean
   * @access public
   */
  public static function dataExists($params) {
    if (CRM_Utils_Array::value('contribution_page_id', $params) && CRM_Utils_Array::value('progress_bar_id', $params)) {
      return TRUE;
    }
    return FALSE;
  }
  
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
