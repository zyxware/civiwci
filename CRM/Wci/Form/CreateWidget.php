<?php

require_once 'CRM/Core/Form.php';
require_once 'wci-helper-functions.php';
require_once 'CRM/Wci/BAO/ProgressBar.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Wci_Form_CreateWidget extends CRM_Core_Form {
  
  /**
   * the widget id saved to the session for an update
   *
   * @var int
   * @access protected
   */
  protected $_id;
  
  function preProcess() {
    CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.wci', 'createwidget.js');
    parent::preProcess();
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, 
          FALSE, NULL, 'REQUEST' );

    $this->_colorFields = array('color_title' => array(ts('Title Text Color'),
        'text',
        FALSE,
        '#2786C2',
      ),
      'color_title_bg' => array(ts('Title background color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'color_bar' => array(ts('Progress Bar Color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'color_widget_bg' => array(ts('Background color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_description' => array(ts('Description color'),
        'text',
        FALSE,
        '#000000',
      ),
      'color_border' => array(ts('Border color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'color_button' => array(ts('Button text color'),
        'text',
        FALSE,
        '#000000',
      ),
      'color_button_bg' => array(ts('Button background color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      );
  }

  function setDefaultValues() {
    $defaults = array();
    if (!isset($this->_id)) {
      $defaults['size_variant'] = 'normal';
      foreach ($this->_colorFields as $name => $val) {
        $defaults[$name] = $val[3];
      }
    }
    return $defaults;
  }

  function buildQuickForm() {
    // add form elements
    $this->add('text', 'title', ts('Title'),true)->setSize(45);
    $this->add('text', 'logo_image', ts('Logo image'))->setSize(45);
    $this->add('text', 'image', ts('Image'))->setSize(45);
    $this->add('select', 'button_link_to', ts('Contribution button'), getContributionPageOptions());
    $this->add('text', 'button_title', ts('Contribution button title'))->setSize(45);
    $this->add('select', 'progress_bar', ts('Progress bar'), $this->getProgressBars());
    $this->addWysiwyg('description', ts('Description'), '');
    $this->add('select', 'email_signup_group_id', ts('Newsletter signup'), $this->getGroupOptions());
    $this->add('select', 'size_variant', ts('Size variant'), $this->getSizeOptions());
    // $fieldset = $this->addElement('fieldset')->setLabel('Advanced Settings');
    $this->add('checkbox', 'hide_title', ts('Hide Title'));
    $this->add('checkbox', 'hide_border', ts('Hide border'));
    $this->add('checkbox', 'hide_pbcap', ts('Hide progress bar caption'));
    foreach ($this->_colorFields as $name => $val) {
      $this->addElement($val[1],
        $name,
        $val[0],
        $name,
        $val[2]
      );
    }
    $this->add('textarea', 'style_rules', ts('Additional Style Rules'))->setRows(5);
    $this->add('checkbox', 'override', ts('Override default template'));
    $this->add('textarea', 'custom_template', ts('Custom template:<br><SMALL><font color="red">Please customize the smarty v2 template only if you know what you are doing</font></SMALL>'))->setRows(10);

    $this->addElement('submit','preview','name="Save and Preview" id="preview"');
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
    
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    if (isset($this->_id)) {  
      /** Updating existing widget*/
      
      /*$query = "SELECT pb.id as pbid, w.*  FROM civicrm_wci_widget w INNER JOIN civicrm_wci_progress_bar pb on pb.id = w.progress_bar_id 
where w.id=" . $this->_id;*/

      $query = "SELECT * FROM civicrm_wci_widget WHERE id=" . $this->_id;
      $params = array();
      
      $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_Widget');

      while ($dao->fetch()) {

        $wid_page[$dao->id] = array();
        CRM_Core_DAO::storeValues($dao, $wid_page[$dao->id]);

        $this->setDefaults(array(
              'title' => $wid_page[$dao->id]['title']));
        $this->setDefaults(array(
              'logo_image' => $wid_page[$dao->id]['logo_image']));
        $this->setDefaults(array(
              'image' => $wid_page[$dao->id]['image']));
        $this->setDefaults(array(
              'button_link_to' => $wid_page[$dao->id]['button_link_to']));
        $this->setDefaults(array(
              'button_title' => $wid_page[$dao->id]['button_title']));

        $this->setDefaults(array(
              'progress_bar' => $dao->progress_bar_id/*$dao->pbid*/));
        $description = base64_decode($wid_page[$dao->id]['description']);
        $this->setDefaults(array(
              'description' => $description));
        $this->setDefaults(array(
              'email_signup_group_id' => $wid_page[$dao->id]['email_signup_group_id']));
        $this->setDefaults(array(
              'size_variant' => $dao->size_variant));
        $this->setDefaults(array(
              'color_title' => $wid_page[$dao->id]['color_title']));
        $this->setDefaults(array(
              'color_title_bg' => $wid_page[$dao->id]['color_title_bg']));
        $this->setDefaults(array(
              'color_bar' => $wid_page[$dao->id]['color_progress_bar']));
        $this->setDefaults(array(
              'color_widget_bg' => $wid_page[$dao->id]['color_widget_bg']));
        $this->setDefaults(array(
              'color_description' => $wid_page[$dao->id]['color_description']));
        $this->setDefaults(array(
              'color_border' => $wid_page[$dao->id]['color_border']));
        $this->setDefaults(array(
              'color_button' => $wid_page[$dao->id]['color_button']));
        $this->setDefaults(array(
              'color_button_bg' => $wid_page[$dao->id]['color_button_bg']));
        $this->setDefaults(array(
              'style_rules' => base64_decode($wid_page[$dao->id]['style_rules'])));
        $this->setDefaults(array(
              'override' => $wid_page[$dao->id]['override']));
        $this->setDefaults(array(
              'hide_title' => $wid_page[$dao->id]['hide_title']));
        $this->setDefaults(array(
              'hide_border' => $wid_page[$dao->id]['hide_border']));
        $this->setDefaults(array(
              'hide_pbcap' => $wid_page[$dao->id]['hide_pbcap']));
        if(true == $wid_page[$dao->id]['override']) {
          $cust_templ = base64_decode($wid_page[$dao->id]['custom_template']);
          $this->setDefaults(array(
              'custom_template' => $cust_templ));
        } else {
          $output = file_get_contents('templates/CRM/Wci/Page/wciwidget.tpl',FILE_USE_INCLUDE_PATH);
          $elem = $this->getElement('custom_template');
          $elem->setValue($output);
        }
      }
      CRM_Utils_System::setTitle(ts('Edit Widget'));
    }
    else {
      CRM_Utils_System::setTitle(ts('Create Widget'));
      /** Keep template in civicrm-wci/templates folder*/
      $output = file_get_contents('templates/CRM/Wci/Page/wciwidget.tpl',FILE_USE_INCLUDE_PATH);
      $elem = $this->getElement('custom_template');
      $elem->setValue($output);
    }
    parent::buildQuickForm();
  }

  function postProcess() {
    $values = $this->exportValues();
    $override = 0;
    $hide_title = 0;
    $hide_border = 0;
    $hide_pbcap = 0;
    $cust_tmpl = "";
    $cust_tmpl_col = "";
    $sql = "";
    $coma = "";
    $equals = "";
    $quote = "";
    /** If override check is checked state then only save the custom_template to the
        database. otherwise wci uses default tpl file.
    */
    if(isset($values['override'])){
      $override = $values['override'];
      $cust_tmpl = base64_encode(html_entity_decode($values['custom_template']));
      $cust_tmpl_col = "custom_template";
      $coma = ",";
      $equals = " = ";
      $quote = "'";
    }
    if(isset($values['hide_title'])){
        $hide_title = $values['hide_title'];
    }
    if(isset($values['hide_border'])){
        $hide_border = $values['hide_border'];
    }
    if(isset($values['hide_pbcap'])){
        $hide_pbcap = $values['hide_pbcap'];
    }
    
    if (isset($this->_id)) {
      $sql = "UPDATE civicrm_wci_widget SET title = '". base64_encode($values['title']) 
        . "', logo_image = '" . $values['logo_image'] . "', image = '" 
        . $values['image'] . "', button_title = '" . $values['button_title'] 
        . "', button_link_to = '" . $values['button_link_to'] 
        . "', progress_bar_id = '" . $values['progress_bar'] 
        . "', description = '" . base64_encode($values['description']) 
        . "', email_signup_group_id = '" . $values['email_signup_group_id'] 
        . "', size_variant = '" . $values['size_variant'] 
        . "', color_title = '" . $values['color_title'] 
        . "', color_title_bg = '" . $values['color_title_bg'] 
        . "', color_progress_bar = '" . $values['color_bar'] 
        . "', color_widget_bg = '" . $values['color_widget_bg'] 
        . "', color_description = '" . $values['color_description'] 
        . "', color_border = '" . $values['color_border'] 
        . "', color_button = '" . $values['color_button'] 
        . "', color_button_bg = '" . $values['color_button_bg']
        . "', hide_title = '" . $hide_title
        . "', hide_border = '" . $hide_border
        . "', hide_pbcap = '" . $hide_pbcap
        . "', style_rules = '" . base64_encode($values['style_rules']) . "', override = '" 
        . $override . $quote . $coma . $cust_tmpl_col . $equals . $quote . $cust_tmpl . "' where id =" . $this->_id ;
    }
    else {
      $sql = "INSERT INTO civicrm_wci_widget (title, logo_image, image, 
      button_title, button_link_to, progress_bar_id, description, 
      email_signup_group_id, size_variant, color_title, color_title_bg, 
      color_progress_bar, color_widget_bg, color_description, color_border, 
      color_button, color_button_bg, hide_title, hide_border, hide_pbcap, style_rules, override" . $coma . $cust_tmpl_col ." ) 
      VALUES ('" . base64_encode($values['title']) . "','" . $values['logo_image'] . "','" . 
      $values['image'] . "','" . $values['button_title'] . "','" . 
      $values['button_link_to'] . "','" . $values['progress_bar'] . "','" . 
      base64_encode($values['description']) . "','" . 
      $values['email_signup_group_id'] . "','" . 
      $values['size_variant'] . "','" . $values['color_title'] . "','" . 
      $values['color_title_bg'] . "','" . $values['color_bar'] . "','" . 
      $values['color_widget_bg'] . "','" . $values['color_description'] . "','" .
      $values['color_border'] . "','" . $values['color_button'] . "','" . 
      $values['color_button_bg'] . "','" . $values['hide_title'] . "','" .
      $values['hide_border'] . "','" . $values['hide_pbcap'] . "','"
      . base64_encode($values['style_rules']) . "','" . 
      $override . $quote . $coma . $quote . $cust_tmpl
        . "')";
    }

    $errorScope = CRM_Core_TemporaryErrorScope::useException();
    try {
      $transaction = new CRM_Core_Transaction();
      CRM_Core_DAO::executeQuery("SET foreign_key_checks = 0;");
      CRM_Core_DAO::executeQuery($sql);
      CRM_Core_DAO::executeQuery("SET foreign_key_checks = 1;");
      $transaction->commit();
      
      if(isset($_REQUEST['_qf_CreateWidget_next'])) {
        (isset($this->_id)) ? $widget_id = $this->_id : 
              $widget_id = CRM_Core_DAO::singleValueQuery('SELECT LAST_INSERT_ID()');
        CRM_Utils_System::redirect('?action=update&reset=1&id=' . $widget_id);
      } else {
        CRM_Utils_System::redirect('widget?reset=1');
      }
    }    
    catch (Exception $e) {
      //TODO
      print_r($e->getMessage());
      $transaction->rollback();
    }
     
    parent::postProcess();
  }
  
  function getProgressBars() {
    $options = array(
      '' => ts('- select -'),
    );
    $pbList = CRM_Wci_BAO_ProgressBar::getProgressbarList();
    foreach ($pbList as $pb) {
      $options[$pb['id']] = $pb['name'];
    }

    return $options;
  }
  function getContributionPageOptions() {
    $options = array(
      '' => ts('- select -'),
    );
    
    $result = civicrm_api3('contribution_page', 'get');
    foreach ($result['values'] as $contribution_page) {
      $options[$contribution_page['id']] = $contribution_page['title'];
    }
    
    return $options;
  }

  function getGroupOptions() {
    $options = array(
      '' => ts('- select -'),
    );
    
    $result = civicrm_api3('group', 'get', array(
      'group_type' => '2'
    ));
    
    foreach ($result['values'] as $group) {
      $options[$group['id']] = $group['title'];
    }
    
    return $options;
  }

  function getSizeOptions() {
    $options = array(
      'thin' => ts('Thin'),
      'normal' => ts('Normal'),
      'wide' => ts('Wide'),
    );
    
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
