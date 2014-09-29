<?php

require_once 'CRM/Core/Form.php';
require_once 'wci-helper-functions.php';
require_once 'CRM/Wci/BAO/ProgressBar.php';

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
      'Percentage', // field label
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

    $sql = "INSERT INTO civicrm_wci_progress_bar (name, starting_amount, goal_amount) 
    VALUES ('" . $_REQUEST['progressbar_name'] . "','" . $_REQUEST['starting_amount'] . "','" . $_REQUEST['goal_amount'] . "')";
    $errorScope = CRM_Core_TemporaryErrorScope::useException();
    try {
      $transaction = new CRM_Core_Transaction();
      CRM_Core_DAO::executeQuery($sql);
      $progressbar_id = CRM_Core_DAO::singleValueQuery('SELECT LAST_INSERT_ID()');
      for($i = 1; $i <= (int)$_REQUEST['contrib_count']; $i++):
        $page = 'contribution_page_' . (string)$i;
        $perc = 'percentage_' . (string)$i;

        $sql = "INSERT INTO civicrm_wci_progress_bar_formula (contribution_page_id, progress_bar_id, percentage) 
        VALUES ('" . $_REQUEST[$page] . "','" . $progressbar_id . "','" . $_REQUEST[$perc] . "')";
        
        CRM_Core_DAO::executeQuery($sql);
      endfor;
    }    
    catch (Exception $e) {
      //TODO
      print_r($e->getMessage());
      $transaction->rollback();
    }      
    parent::postProcess();
    $elem = $this->getElement('contrib_count');
    $elem->setValue('1');    
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
