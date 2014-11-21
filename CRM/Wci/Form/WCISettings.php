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
require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_WCISettings extends CRM_Core_Form {
  function buildQuickForm() {
    $this->add('text', 'default_profile', ts('Default profile'),true)->setSize(45);
    $this->add('text', 'widget_cache_timeout', ts('Widget cache timeout'),true)->setSize(45);
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
    ));
$cacheTime = 1;
    $cacheTime = civicrm_api3('setting', 'getValue', array('group' => 'Wci Preference', 'name' => 'widget_cache_timeout'));
    $defProf =   civicrm_api3('setting', 'getValue', array('group' => 'Wci Preference', 'name' => 'default_wci_profile'));
    $this->setDefaults(array(
              'default_profile' => $defProf));
    $this->setDefaults(array(
              'widget_cache_timeout' => $cacheTime));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    CRM_Utils_System::setTitle(ts('Widget Settings'));

    parent::buildQuickForm();
  }

  function postProcess() {
    $values = $this->exportValues();
    civicrm_api3('setting', 'create', array('sequential' => 1, 'default_wci_profile' => $values['default_profile']));
    civicrm_api3('setting', 'create', array('sequential' => 1, 'widget_cache_timeout' => $values['widget_cache_timeout']));
    CRM_Core_Session::setStatus(ts('Widget settings are saved to database'), '', 'success');
    parent::postProcess();
  }

  function getProfiles() {
    /* not API to get all profiles now.
    $params = array();
    $result = civicrm_api3('Profile', 'get', $params);
    $result = civicrm_api('Profile', 'getcount', $params);
    print_r($result);*/
  }
  function getWidgets() {
    $query = "SELECT * FROM civicrm_wci_widget";
    $params = array();

    $widgetlist = array(
      '' => ts('- select -'),
    );

    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_Widget');

    while ($dao->fetch()) {
      $widgetlist[$dao->id] = $dao->title;
    }
    return $widgetlist;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
