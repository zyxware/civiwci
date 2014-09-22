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
    //$this->getElement('percentage')->setAttribute("id", "percentage");
    
    $this->addElement('link', 'addmore_link',' ', 'addmore', 'Add more');
//    $this->addElement('link', 'remove_link',' ', 'remove', 'Remove');

    $this->addElement('hidden', 'contrib_count', '1');
    //$this->getElement('contrib_count')->setAttribute("id", "count");

    $this->addButtons(array(
      array(
        'type' => 'text',
        'name' => ts('Add More'),
        'isDefault' => FALSE,
      ),
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
/*    CRM_Core_Session::setStatus(ts('You picked color "%1"', array(
      1 => $options[$values['favorite_color']]
    )));*/
    parent::postProcess();
  }
  
/*
  function getColorOptions() {
    $options = array(
      '' => ts('- select -'),
      '#f00' => ts('Red'),
      '#0f0' => ts('Green'),
      '#00f' => ts('Blue'),
      '#f0f' => ts('Purple'),
    );
    foreach (array('1','2','3','4','5','6','7','8','9','a','b','c','d','e') as $f) {
      $options["#{$f}{$f}{$f}"] = ts('Grey (%1)', array(1 => $f));
    }
    return $options;
  }*/

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

function wci__civicrm_buildForm( $formName, &$form )
{
echo "hi<br>";
    //CRM_Core_Resources::singleton()->addScriptFile('wci', 'addmore.js');
    CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.wci', 'addmore.js');  
}
