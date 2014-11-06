<?php

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
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function wci_civicrm_xmlMenu(&$files) {
  _wci_civix_civicrm_xmlMenu($files);
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
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function wci_civicrm_uninstall() {
  return _wci_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function wci_civicrm_enable() {
  return _wci_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function wci_civicrm_disable() {
  return _wci_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function wci_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _wci_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function wci_civicrm_managed(&$entities) {
  return _wci_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function wci_civicrm_caseTypes(&$caseTypes) {
  _wci_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function wci_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _wci_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

function wci_civicrm_navigationMenu( &$params ) {
 
  $navId = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_navigation");
  if (is_integer($navId)) {
    $navId++;
  }
  // Find the Help menu
  $helpID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Help', 'id', 'name');
  $params[$navId] = $params[$helpID]; 
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
    'navID' => $navId,
    'active' => 1),
    'child' =>  array (
        '1' => array (
        'attributes' => array (
        'label' => ts('New Widget'),
        'name' => 'new_widget',
        'url' => 'civicrm/wci/widget/add',
        'permission' => 'access CiviReport,access CiviContribute',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $navId, 
        'navID' => $navId+1,
        'active' => 1)),
        
        '2' => array (
        'attributes' => array (
        'label' => ts('Manage Widget'),
        'name' => 'manage_widget',
        'url' => 'civicrm/wci/widget?reset=1',
        'permission' => 'access CiviReport,access CiviContribute',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $navId, 
        'navID' => $navId+2,
        'active' => 1)),
        
        '3' => array (
        'attributes' => array (
        'label' => ts('New Progress Bar'),
        'name' => 'new_progress_bar',
        'url' => 'civicrm/wci/progress-bar/add',
        'permission' => 'access CiviReport,access CiviContribute',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $navId, 
        'navID' => $navId+3,
        'active' => 1)),
        
        '4' => array (
        'attributes' => array (
        'label' => ts('Manage Progress Bar'),
        'name' => 'manage_progress_bar',
        'url' => 'civicrm/wci/progress-bar?reset=1',
        'permission' => 'access CiviReport,access CiviContribute',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $navId, 
        'navID' => $navId+4,
        'active' => 1)),
        
        '5' => array (
        'attributes' => array (
        'label' => ts('Widget Settings'),
        'name' => 'manage_progress_bar',
        'url' => 'civicrm/wci/settings?reset=1',
        'permission' => 'access CiviReport,access CiviContribute',
        'operator' => 'OR',
        'separator' => 1,
        'parentID' => $navId, 
        'navID' => $navId+5,
        'active' => 1)),
        ),
  );
}

