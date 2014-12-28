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
require_once 'wci-helper-functions.php';
require_once 'CRM/Wci/DAO/NewEmbedCode.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_NewEmbedCode extends CRM_Core_Form {
  protected $_id;

  function preProcess() {
      if(isset($_REQUEST['id'])) {
        $this->assign('emb_id', $_REQUEST['id']);
      }

      $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this,
          FALSE, NULL, 'REQUEST' );
  }

  function buildQuickForm() {
    $this->add('text', 'title', ts('Title'),true, true)->setSize(45);
    // add form elements
    $this->add(
      'select', // field type
      'widget', // field name
      'Widget', // field label
      $this->getWidgets(), // list of options
      true // is required
    );
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
        array(
          'type' => 'next',
          'name' => ts('Save & Preview'),
        ),
    ));

    if (isset($this->_id)) {
      $query = "SELECT * FROM civicrm_wci_embed_code WHERE id= %1";
      $params = array(1 => array($this->_id, 'Integer'));

      $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_EmbedCode');

      while ($dao->fetch()) {

        $emb_code[$dao->id] = array();
        CRM_Core_DAO::storeValues($dao, $emb_code[$dao->id]);

        $this->setDefaults(array(
              'title' => $emb_code[$dao->id]['name']));
        $this->setDefaults(array(
              'widget' => $emb_code[$dao->id]['widget_id']));
      }
      CRM_Utils_System::setTitle(ts('Edit embed code'));
      $this->assign('widget_id', $emb_code[$dao->id]['widget_id']);
    }
    else {
      CRM_Utils_System::setTitle(ts('New embed code'));
    }
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  function postProcess() {
    $values = $this->exportValues();

    $title = str_replace("'", "''", $values['title']);
    $params = array(1 => array($title, 'String'),
      2 => array($values['widget'], 'Integer'),
    );
    if (isset($this->_id)) {
      $params += array(3 => array($this->_id, 'Integer'),);
      $sql = "UPDATE civicrm_wci_embed_code SET name = %1, widget_id = %2 where id = %3" ;
    }
    else {
      $sql = "INSERT INTO civicrm_wci_embed_code (name, widget_id)VALUES (%1, %2)";
    }
    $errorScope = CRM_Core_TemporaryErrorScope::useException();
    try {
      $transaction = new CRM_Core_Transaction();
      CRM_Core_DAO::executeQuery($sql, $params);
      $transaction->commit();
      CRM_Core_Session::setStatus(ts('Embed code created successfully'), '', 'success');
      if(isset($_REQUEST['_qf_NewEmbedCode_next'])) {
        (isset($this->_id)) ? $embed_id = $this->_id :
              $embed_id = CRM_Core_DAO::singleValueQuery('SELECT LAST_INSERT_ID()');
        CRM_Utils_System::redirect('?action=update&reset=1&id=' . $embed_id);
      } else {
        CRM_Utils_System::redirect('embed-code?reset=1');
      }
    }
    catch (Exception $e) {
      CRM_Core_Session::setStatus(ts('Failed to create embed code'), '', 'error');
      $transaction->rollback();
    }
    parent::postProcess();
  }

  function getWidgets() {
    $options = array(
      '' => ts('- select -'),
    );
    $widgList = CRM_Wci_BAO_Widget::getWidgetList();
    foreach ($widgList as $widg) {
      $options[$widg['id']] = $widg['title'];
    }

    return $options;
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
