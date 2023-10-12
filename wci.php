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
require_once 'wci.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function wci_civicrm_config(&$config) {
  _wci_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function wci_civicrm_install() {
  return _wci_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function wci_civicrm_enable() {
  return _wci_civix_civicrm_enable();
}

function _getMenuKeyMax($menuArray) {
  $max = array(max(array_keys($menuArray)));
  foreach($menuArray as $v) {
    if (!empty($v['child'])) {
      $max[] = _getMenuKeyMax($v['child']);
    }
  }
  return max($max);
}

function wci_civicrm_permission(&$permissions) {
  $prefix = ts('CiviWCI') . ': '; // name of extension or module
  $permissions += array(
    'access CiviWCI Widget' => $prefix . ts('Access CiviWCI Widget'),
    'administer CiviWCI' => $prefix . ts('Administer CiviWCI'),
  );
}

function wci_civicrm_navigationMenu( &$params ) {

  $maxKey = _getMenuKeyMax($params);
  // Find the Help menu
  $helpID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Help', 'id', 'name');
  $params[$maxKey] = $params[$helpID];
  // inserting WCI menu at the place of old help location
  $params[$helpID] = array (
    'attributes' => array (
    'label' => ts('Widgets and Progress Bars'),
    'name' => 'WCI',
    'url' => null,
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
    'parentID' => 0,
    'navID' => $maxKey,
    'active' => 1),
    'child' =>  array (
        '1' => array (
        'attributes' => array (
        'label' => ts('New Widget'),
        'name' => 'new_widget',
        'url' => 'civicrm/wci/widget/add',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+1,
        'active' => 1)),

        '2' => array (
        'attributes' => array (
        'label' => ts('Manage Widgets'),
        'name' => 'manage_widget',
        'url' => 'civicrm/wci/widget?reset=1',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+2,
        'active' => 1)),

        '3' => array (
        'attributes' => array (
        'label' => ts('New Progress Bar'),
        'name' => 'new_progress_bar',
        'url' => 'civicrm/wci/progress-bar/add',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+3,
        'active' => 1)),

        '4' => array (
        'attributes' => array (
        'label' => ts('Manage Progress Bars'),
        'name' => 'manage_progress_bar',
        'url' => 'civicrm/wci/progress-bar?reset=1',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+4,
        'active' => 1)),

        '5' => array (
        'attributes' => array (
        'label' => ts('New Embed Code'),
        'name' => 'new_embed-code',
        'url' => 'civicrm/wci/embed-code/add',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+5,
        'active' => 1)),

        '6' => array (
        'attributes' => array (
        'label' => ts('Manage Embed Code'),
        'name' => 'manage-emebed-code',
        'url' => 'civicrm/wci/embed-code?reset=1',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+6,
        'active' => 1)),

        '7' => array (
        'attributes' => array (
        'label' => ts('Widget Settings'),
        'name' => 'widget-settings',
        'url' => 'civicrm/wci/settings?reset=1',
        'permission' => 'administer CiviWCI',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $maxKey,
        'navID' => $maxKey+7,
        'active' => 1)),
        ),
  );
}
