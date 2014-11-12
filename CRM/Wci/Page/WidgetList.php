<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Wci/DAO/Widget.php';

class CRM_Wci_Page_WidgetList extends CRM_Core_Page {
  private static $_actionLinks;
  function run() {
    // get the requested action
    $action = CRM_Utils_Request::retrieve('action', 'String',
      // default to 'browse'
      $this, FALSE, 'browse'
    );
    // assign vars to templates
    $this->assign('action', $action);
    $id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, 0
    );

    if ($action & CRM_Core_Action::UPDATE) {
      $controller = new CRM_Core_Controller_Simple('CRM_Wci_Form_CreateWidget',
        'Edit Widget',
        CRM_Core_Action::UPDATE
      );
      $controller->set('id', $id);
      $controller->process();
      return $controller->run();
    } 
    elseif ($action & CRM_Core_Action::DELETE) {
      try {
        $transaction = new CRM_Core_Transaction();
        
        $sql = "DELETE FROM civicrm_wci_widget where id = %1";
        $params = array(1 => array($id, 'Integer'));
        CRM_Core_DAO::executeQuery($sql, $params);
        $transaction->commit();
      }
      catch (Exception $e) {
        //TODO
        print_r($e->getMessage());
        $transaction->rollback();      
      } 
    }  
  
    CRM_Utils_System::setTitle(ts('Widget List'));
    $query = "SELECT * FROM civicrm_wci_widget";
    $params = array();
    
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_Widget');

    while ($dao->fetch()) {
      $wid_page[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $wid_page[$dao->id]);
      $wid_page[$dao->id]['title'] = $wid_page[$dao->id]['title'];
      $description = $wid_page[$dao->id]['description'];
      $wid_page[$dao->id]['description'] = strip_tags($description);
     
      $action = array_sum(array_keys($this->actionLinks())); 
      //build the normal action links.
      $wid_page[$dao->id]['action'] = CRM_Core_Action::formLink(self::actionLinks(),
        $action, array('id' => $dao->id));
    }
   
    if (isset($wid_page)) {
      $this->assign('rows', $wid_page);
    }
    
    parent::run();
  }
  
  function &actionLinks() {
    // check if variable _actionsLinks is populated
    if (!isset(self::$_actionLinks)) {
      // helper variable for nicer formatting
      $deleteExtra = ts('Are you sure you want to delete this Widget?');

      self::$_actionLinks = array(
        CRM_Core_Action::UPDATE => array(
          'name' => ts('Edit'),
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
