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

class CRM_Wci_BAO_ProgressBar extends CRM_Wci_DAO_ProgressBar {

  /**
   * Returns array of progressbars
   * Fields : id, name, starting_amount, goal_amount
   * @return progressbar array
   * @access public
   */  
  public static function getProgressbarList() {
    $query = "SELECT * FROM civicrm_wci_progress_bar";
    $params = array();
    $pbList = array();
    
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_ProgressBar');

    while ($dao->fetch()) {
      $pbList[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $pbList[$dao->id]);
    }

    return $pbList;
  }
  
  /**
   * Returns percentage value of a progressbar
   * @param integer progressbar id
   * @return decimal percentage value
   * @access public
   */  
  public static function getPBCollectedAmount($pbId) {
    $bp = 0;
    $query = "SELECT * FROM civicrm_wci_progress_bar_formula WHERE progress_bar_id =" . $pbId;
    $params = array();

    $daoPbf = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_ProgressBarFormula');
      while ($daoPbf->fetch()) {
        $for_page[$daoPbf->id] = array();
        CRM_Core_DAO::storeValues($daoPbf, $for_page[$daoPbf->id]);
        $px = $for_page[$daoPbf->id]['percentage'];
        
        $query = "SELECT * FROM civicrm_contribution where contribution_page_id =" . $for_page[$daoPbf->id]['contribution_page_id'];
        $params = array();

        $daoCon = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Contribute_DAO_Contribution');

        while ($daoCon->fetch()) {
          $contributions[$daoCon->id] = array();
          CRM_Core_DAO::storeValues($daoCon, $contributions[$daoCon->id]);
          $bx = $contributions[$daoCon->id]['total_amount'];

          $bp += $bx * $px / 100;
        }
     }
     return floor($bp);
  }
  
  public static function getProgressbarInfo($pbId) {
    $ga = 0;
    $query = "SELECT * FROM civicrm_wci_progress_bar where id=" . $pbId;
    $params = array();
    $pbInfo = array();
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_ProgressBar');

    while ($dao->fetch()) {
      $con_page[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $con_page[$dao->id]);
      $pbInfo['name'] = $con_page[$dao->id]['name'];
      $pbInfo['starting_amount'] = $con_page[$dao->id]['starting_amount'];
      $pbInfo['goal_amount'] = $con_page[$dao->id]['goal_amount'];
    }

     return $pbInfo;
  }
  public static function getProgressbarPercentage($pbId, &$pbInfo) {

    $pbInfo = CRM_Wci_BAO_ProgressBar::getProgressbarInfo($pbId);
    $ga = $pbInfo['goal_amount'];
    $currAmnt = CRM_Wci_BAO_ProgressBar::getPBCollectedAmount($pbId)
      + $pbInfo['starting_amount'];
    (0 == $ga) ? $currAmt = 0: $perc = ($currAmnt / $ga ) * 100;
    if (100 < $perc){
      $perc = 100; 
    }

     return floor($perc);  
  }
  public static function getProgressbarData($pbId, &$pbData) {
    if(0 != $pbId) {
      $pbInfo = array();//CRM_Wci_BAO_ProgressBar::getProgressbarInfo($pbId);
      $pbData["pb_percentage"] = CRM_Wci_BAO_ProgressBar::getProgressbarPercentage($pbId, $pbInfo);
      $pbData["starting_amount"] = floor($pbInfo['starting_amount']);
      $pbData["goal_amount"] = ceil($pbInfo['goal_amount']);
      
      ($pbData["show_pb_perc"]) ? $pbData["pb_caption"] = $pbData["pb_percentage"]
        : $pbData["pb_caption"] = CRM_Wci_BAO_ProgressBar::getPBCollectedAmount($pbId)
        + $pbData["starting_amount"];

      $pbData["no_pb"] = False;
    } else {
      $pbData["no_pb"] = True;
    }

    return $pbData;
  }
}
