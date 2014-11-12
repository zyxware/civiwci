<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Wci/DAO/NewEmbedCode.php';

class CRM_Wci_Page_ManageEmbedCode extends CRM_Core_Page {
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
      $controller = new CRM_Core_Controller_Simple('CRM_Wci_Form_NewEmbedCode',
        'Edit Embed Code',
        CRM_Core_Action::UPDATE
      );
      $controller->set('id', $id);
      $controller->process();
      return $controller->run();
    } 
    elseif ($action & CRM_Core_Action::DELETE) {
      try {
        $transaction = new CRM_Core_Transaction();
        
        $sql = "DELETE FROM civicrm_wci_embed_code where id = " . $id;
        CRM_Core_DAO::executeQuery($sql);
        $transaction->commit();
      }
      catch (Exception $e) {
        //TODO
        print_r($e->getMessage());
        $transaction->rollback();
      } 
    }


    CRM_Utils_System::setTitle(ts('Embed Code List'));
    $query = "SELECT * FROM civicrm_wci_embed_code";
    $params = array();
    
    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_EmbedCode');

    while ($dao->fetch()) {
      $emb_code[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $emb_code[$dao->id]);
      $emb_code[$dao->id]['id'] = $emb_code[$dao->id]['id'];
      $emb_code[$dao->id]['name'] = $emb_code[$dao->id]['name'];
     
      $action = array_sum(array_keys($this->actionLinks())); 
      //build the normal action links.
      $emb_code[$dao->id]['action'] = CRM_Core_Action::formLink(self::actionLinks(),
        $action, array('id' => $dao->id));     
    }
   
    if (isset($emb_code)) {
      $this->assign('rows', $emb_code);
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
