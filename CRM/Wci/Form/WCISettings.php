<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_WCISettings extends CRM_Core_Form {
  function buildQuickForm() {

    // add form elements
    /*$this->add(
      'select', // field type
      'default_profile', // field name
      'Default profile', // field label
      $this->getProfiles(), // list of options
      true // is required
    );*/
   
    $this->add(
      'select', // field type
      'default_widget', // field name
      'Default widget', // field label
      $this->getWidgets(), // list of options
      false // is required
    );
    $this->add('text', 'default_profile', ts('Default profile'),true)->setSize(45);
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    $widgetId = civicrm_api3('setting', 'getValue', array('group' => 'extensions', 'name' => 'default_wci_widget'));
    $defProf = civicrm_api3('setting', 'getValue', array('group' => 'extensions', 'name' => 'default_wci_profile'));

    $this->setDefaults(array(
              'default_widget' => $widgetId));
    $this->setDefaults(array(
              'default_profile' => $defProf));
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    CRM_Utils_System::setTitle(ts('WCI Settings'));
    
    parent::buildQuickForm();
  }

  function postProcess() {
    $values = $this->exportValues();
    civicrm_api3('setting', 'create', array('domain_id' => 1, 'default_wci_widget' => $values['default_widget'],));
    civicrm_api3('setting', 'create', array('domain_id' => 1, 'default_wci_profile' => $values['default_profile'],));
    parent::postProcess();
  }
  
  function getProfiles() {
    /*$params = array();
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
