<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Wci/DAO/ProgressBar.php';

class CRM_Wci_Page_ProgressBarList extends CRM_Core_Page {
  private static $_actionLinks;
  function run() {
    // get the requested action
    $action = CRM_Utils_Request::retrieve('action', 'String',
      // default to 'browse'
      $this, FALSE, 'browse'
    );
    echo $action;
    // assign vars to templates
    $this->assign('action', $action);
    $id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, 0
    );


    if ($action & CRM_Core_Action::UPDATE) {
      echo "UPDATE clicked";
      $controller = new CRM_Core_Controller_Simple('CRM_Wci_Form_ProgressBar',
        'Edit Progressbar',
        CRM_Core_Action::UPDATE
      );
      $controller->set('id', $id);
      $controller->process();
      return $controller->run();
//      return;
    } elseif ($action & CRM_Core_Action::DELETE) {
      echo "delete clicked";
//      return;
    } 
  
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('ProgressBarList'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    $query = "SELECT * FROM civicrm_wci_progress_bar";
    $params = array();
    
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_WCI_DAO_ProgressBar');

    while ($dao->fetch()) {
      $con_page[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $con_page[$dao->id]);
      //print_r($con_page[$dao->id]['starting_amount']);
      
      $action = array_sum(array_keys($this->actionLinks())); 
      //build the normal action links.
      $con_page[$dao->id]['action'] = CRM_Core_Action::formLink(self::actionLinks(),
        $action,
        array('id' => $dao->id),
        ts('more'),
        TRUE
      );
    }

    if (isset($con_page)) {
      $this->assign('rows', $con_page);
    }

/*
    $query = "SELECT * FROM civicrm_wci_progress_bar";
    $dao = CRM_Core_DAO::singleValueQuery($query);
      print_r($dao);
*/
    return parent::run();
  }
  
function &actionLinks() {
    // check if variable _actionsLinks is populated
    if (!isset(self::$_actionLinks)) {
      // helper variable for nicer formatting
      $deleteExtra = ts('Are you sure you want to delete this Contribution page?');
      $copyExtra = ts('Are you sure you want to make a copy of this Contribution page?');

      self::$_actionLinks = array(
        CRM_Core_Action::UPDATE => array(
          'name' => ts('Update'),
          'url' => CRM_Utils_System::currentPath(),
          'qs' => 'action=update&reset=1&id=%%id%%',
          'title' => ts('Update'),
        ),
        CRM_Core_Action::DELETE => array(
          'name' => ts('Delete'),
          'url' => CRM_Utils_System::currentPath(),
          'qs' => 'action=delete&reset=1&id=%%id%%',
          'title' => ts('Delete Custom Field'),
          'extra' => 'onclick = "return confirm(\'' . $deleteExtra . '\');"',
        ),
      );
    }
    return self::$_actionLinks;
  }
}
