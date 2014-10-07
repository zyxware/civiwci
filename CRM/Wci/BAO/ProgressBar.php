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
require_once 'CRM/Wci/DAO/ProgressBar.php';

class CRM_WCI_BAO_ProgressBar extends CRM_WCI_DAO_ProgressBar {

  /**
   * class constructor
   */
  function __construct() {
    parent::__construct();
  }

  /**
   * Function to create a ProgressBar
   * takes an associative array and creates a ProgressBar object
   *
   * This function is invoked from within the web form layer and also from the api layer
   *
   * @param array   $params      (reference ) an assoc array of name/value pairs
   *
   * @return object CRM_WCI_BAO_ProgressBar object
   * @access public
   * @static
   */
  static function create(array $params) {

    // check required params
    if (!self::dataExists($params)) {
      CRM_Core_Error::fatal('Not enough data to create a progress bar.');
    }

    $progress_bar = new CRM_WCI_BAO_ProgressBar();
    $progress_bar->copyValues($params);

    $progress_bar->save();

    return $progress_bar;
  }

  /**
   * Get a list of Widgets matching the params, where params keys are column
   * names of civicrm_wci_widget.
   *
   * @param array $params
   * @return array of CRM_WCI_BAO_ProgressBar objects
   */
  static function retrieve(array $params) {
    $result = array();

    $progress_bar = new CRM_WCI_BAO_ProgressBar();
    $progress_bar->copyValues($params);
    $progress_bar->find();

    while ($progress_bar->fetch()) {
      $result[(int) $progress_bar->id] = clone $progress_bar;
    }

    $progress_bar->free();

    return $result;
  }

  /**
   * Wrapper method for retrieve
   *
   * @param mixed $id Int or int-like string representing widget ID
   * @return CRM_WCI_BAO_ProgressBar
   */
  static function retrieveByID($id) {
    if (!is_int($id) && !ctype_digit($id)) {
      CRM_Core_Error::fatal(__CLASS__ . '::' . __FUNCTION__ . ' expects an integer.');
    }
    $id = (int) $id;

    $progress_bars = self::retrieve(array('id' => $id));

    if (!array_key_exists($id, $progress_bars)) {
      CRM_Core_Error::fatal("No Progress bar with ID $id exists.");
    }

    return $progress_bars[$id];
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
    if (CRM_Utils_Array::value('name', $params)) {
      return TRUE;
    }
    return FALSE;
  }
  
  public static function getProgressbarPercentage($idPB) {
    $bp = 0;
    $query = "SELECT * FROM civicrm_wci_progress_bar where id=" . $idPB;
    $params = array();
    //echo $query."<br>";
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_WCI_DAO_ProgressBar');

    while ($dao->fetch()) {
      $con_page[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $con_page[$dao->id]);
      $con_page[$dao->id]['name'];
      $sa = $con_page[$dao->id]['starting_amount'];
      //echo "stat amount ".$sa.'<br>';
      $ga = $con_page[$dao->id]['goal_amount'];
      //echo "goal amt ".$ga.'<br>';
    }
     
    $query = "SELECT * FROM civicrm_wci_progress_bar_formula WHERE progress_bar_id =" . $idPB;
    $params = array();

    //echo $query."<br>";
    $daoPbf = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_WCI_DAO_ProgressBarFormula');
      while ($daoPbf->fetch()) {
        $for_page[$daoPbf->id] = array();
        CRM_Core_DAO::storeValues($daoPbf, $for_page[$daoPbf->id]);
        //echo "contribution_page_id ".$for_page[$daoPbf->id]['contribution_page_id'].'<br>';
        $px = $for_page[$daoPbf->id]['percentage'];
        //echo "percentage ".$px.'<br>';
        
        $query = "SELECT * FROM civicrm_contribution where contribution_page_id =" . $for_page[$daoPbf->id]['contribution_page_id'];
        $params = array();

        //echo $query."<br>";
        $daoCon = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Contribute_DAO_Contribution');

        while ($daoCon->fetch()) {
          $contributions[$daoCon->id] = array();
          CRM_Core_DAO::storeValues($daoCon, $contributions[$daoCon->id]);
          $bx = $contributions[$daoCon->id]['total_amount'];
          //echo "total_amount".$bx ."<br>";
          //echo "status".$contributions[$daoCon->id]['contribution_status_id'] ."<br>";
          $bp += $bx * $px / 100;
        }
     }
     $perc = (($sa + $bp) / $ga ) * 100;
     //echo "percentate " .  . "<br>"; 
     
     return $perc;
  }
}
