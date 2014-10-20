<?php

require_once 'CRM/Core/Form.php';
require_once 'wci-helper-functions.php';
require_once 'CRM/Wci/BAO/ProgressBar.php';
require_once 'CRM/Wci/DAO/ProgressBarFormula.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_ProgressBar extends CRM_Core_Form {
  private $_id;  
  function preProcess() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE, NULL, 'REQUEST');
    CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.wci', 'addmore.js');
    parent::preProcess();
  }
  function fillData() {
    $count = 1;
    if (isset($this->_id)) {  
      /** Updating existing progress bar*/
      $query = "SELECT * FROM civicrm_wci_progress_bar where id=" . $this->_id;
      $params = array();
      
      $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_ProgressBar');

      while ($dao->fetch()) {
        $con_page[$dao->id] = array();
        CRM_Core_DAO::storeValues($dao, $con_page[$dao->id]);
        $this->setDefaults(array(
              'progressbar_name' => $con_page[$dao->id]['name']));
        $this->setDefaults(array(
              'starting_amount' => $con_page[$dao->id]['starting_amount']));
        $this->setDefaults(array(
              'goal_amount' => $con_page[$dao->id]['goal_amount']));
      }
       
      $query = "SELECT * FROM civicrm_wci_progress_bar_formula WHERE progress_bar_id =" . $this->_id;
      $params = array();

      $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_ProgressBarFormula');

      while ($dao->fetch()) {
        $for_page[$dao->id] = array();
        CRM_Core_DAO::storeValues($dao, $for_page[$dao->id]);

        $this->add(
          'select', // field type
          'contribution_page_'.$count, // field name
          'Contribution page', // field label
          getContributionPageOptions(), // list of options
          true // is required
        );
        $this->add(
          'text', // field type
          'percentage_'.$count, // field name
          'Percentage', // field label
          true // is required
        );
        //save formula id 
        $this->addElement('hidden', 'contrib_elem_'.$count , $for_page[$dao->id]['id']);

        $this->setDefaults(array(
              'contribution_page_'.$count => $for_page[$dao->id]['contribution_page_id']));
        $this->setDefaults(array(
              'percentage_'.$count => $for_page[$dao->id]['percentage']));

        $count++;
      }
      $count--; // because last iteration increments it to the next
    }  
    else {
      /** New progress bar*/
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
    }
    
    $this->addElement('hidden', 'contrib_count', $count);
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
/*    $this->add(
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
    );*/
    
    $this->fillData();
    
    $this->addElement('link', 'addmore_link',' ', 'addmore', 'Add more');

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
    $errorScope = CRM_Core_TemporaryErrorScope::useException();
    if (isset($this->_id)) {
      try {
        $sql = "UPDATE civicrm_wci_progress_bar SET name = '". $_REQUEST['progressbar_name'] . 
          "', starting_amount = '" . $_REQUEST['starting_amount'] . 
          "', goal_amount = '" . $_REQUEST['goal_amount'] . 
          "' where id =".$this->_id;

        $transaction = new CRM_Core_Transaction();
        CRM_Core_DAO::executeQuery($sql);

        for($i = 1; $i <= (int)$_REQUEST['contrib_count']; $i++):
          $page = 'contribution_page_' . (string)$i;
          $perc = 'percentage_' . (string)$i;
          if (isset($_REQUEST['contrib_elem_'.$i])) {
            $sql = "UPDATE civicrm_wci_progress_bar_formula SET contribution_page_id = '". $_REQUEST[$page] . "',
              percentage = '". $_REQUEST[$perc] . "'
              WHERE id = " . (int)$_REQUEST['contrib_elem_'.$i];
          } 
          else {
            $sql = "INSERT INTO civicrm_wci_progress_bar_formula (contribution_page_id, progress_bar_id, percentage) 
              VALUES ('" . $_REQUEST[$page] . "','" . $this->_id . "','" . $_REQUEST[$perc] . "')";
          }

          CRM_Core_DAO::executeQuery($sql);
        endfor;
        $transaction->commit();
        CRM_Utils_System::redirect('civicrm/wci/progress-bar?reset=1');
      }
      catch (Exception $e) {
        //TODO
        print_r($e->getMessage());
        $transaction->rollback();
      }
    
    } 
    else {
      $sql = "INSERT INTO civicrm_wci_progress_bar (name, starting_amount, goal_amount) 
      VALUES ('" . $_REQUEST['progressbar_name'] . "','" . $_REQUEST['starting_amount'] . "','" . $_REQUEST['goal_amount'] . "')";
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
        $transaction->commit();
        CRM_Utils_System::redirect('civicrm/wci/progress-bar?reset=1');
      }    
      catch (Exception $e) {
        //TODO
        print_r($e->getMessage());
        $transaction->rollback();
      }
      $elem = $this->getElement('contrib_count');
      $elem->setValue('1');    
    }
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

