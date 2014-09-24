<?php

require_once 'CRM/Core/Form.php';
require_once 'wci-helper-functions.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_ProgressBar extends CRM_Core_Form {
  
  function preProcess() {
    CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.wci', 'addmore.js');
    parent::preProcess();
  }
  function buildQuickForm() {
    $this->add(
      'text', // field type
      'progressbar_name', // field name
      'Name', // field label
      true // is required
    );
    $this->add(
      'text', // field type
      'starting_amount', // field name
      'Starting amount', // field label
      true // is required
    );
    $this->add(
      'text', // field type
      'goal_amount', // field name
      'Goal amount', // field label
      true // is required
    );
    $this->add(
      'select', // field type
      'contribution_page_1', // field name
      'Contribution page', // field label
      getContributionPageOptions(), // list of options
      true // is required
    );
    $this->add(
      'text', // field type
      'percentage_1', // field name
      'percentage', // field label
      true // is required
    );
    
    $this->addElement('link', 'addmore_link',' ', 'addmore', 'Add more');

    $this->addElement('hidden', 'contrib_count', '1');

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    parent::buildQuickForm();
  }

  function postProcess() {
  echo "post pro";
    $values = $this->exportValues();
    $options = $this->getColorOptions();

    parent::postProcess();
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

