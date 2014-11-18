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
        '#BF0F0F',
      ),
      'color_title_bg' => array(ts('Title background color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_bar' => array(ts('Progress Bar Color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'color_bar_bg' => array(ts('Progress Bar Background Color'),
        'text',
        FALSE,
        '#FFFFFF',
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
        '#FFFFFF',
      ),
      'color_button_bg' => array(ts('Button background color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'color_btn_newsletter' => array(ts('Newsletter Button text color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_btn_newsletter_bg' => array(ts('Newsletter Button color'),
        'text',
        FALSE,
        '#BF0F0F',
      ),
      'newsletter_text' => array(ts('Newsletter text'),
        'text',
        FALSE,
        'Get the monthly newsletter',
      ),
      'color_newsletter_text' => array(ts('Newsletter text color'),
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
      $defaults['show_pb_perc'] = 1;
      foreach ($this->_colorFields as $name => $val) {
        $defaults[$name] = $val[3];
      }
    }
    return $defaults;
  }

  function buildQuickForm() {
    // add form elements
    $this->add('text', 'title', ts('Title'),true, true)->setSize(45);
    $this->add('text', 'logo_image', ts('Logo image'))->setSize(45);
    $this->add('text', 'image', ts('Image'))->setSize(45);
    $this->add('select', 'button_link_to', ts('Contribution button'), getContributionPageOptions());
    $this->add('text', 'button_title', ts('Contribution button title'))->setSize(45);
    $this->add('select', 'progress_bar', ts('Progress bar'), $this->getProgressBars());

    $pbtype = array();
    $pbtype[1] = "Percentage";
    $pbtype[0] = "Amount";
    $this->addRadio('show_pb_perc', ts('Progressbar caption type'), $pbtype,
        NULL, "&nbsp;");

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
    $this->add('textarea', 'style_rules', ts('Additional Style Rules'), 'style=width:94%')->setRows(5);
    $this->add('checkbox', 'override', ts('Override default template'));
    $this->add('textarea', 'custom_template', ts('Custom template:<br><SMALL><font color="red">Please customize the smarty v2 template only if you know what you are doing</font></SMALL>'), 'style=width:94%')->setRows(10);

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

      $query = "SELECT * FROM civicrm_wci_widget WHERE id=%1";
      $params = array(1 => array($this->_id, 'Integer'));
      
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
        $description = $wid_page[$dao->id]['description'];
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
              'color_bar_bg' => $wid_page[$dao->id]['color_progress_bar_bg']));
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
              'style_rules' => $wid_page[$dao->id]['style_rules']));
        $this->setDefaults(array(
              'override' => $wid_page[$dao->id]['override']));
        $this->setDefaults(array(
              'hide_title' => $wid_page[$dao->id]['hide_title']));
        $this->setDefaults(array(
              'hide_border' => $wid_page[$dao->id]['hide_border']));
        $this->setDefaults(array(
              'hide_pbcap' => $wid_page[$dao->id]['hide_pbcap']));
        $this->setDefaults(array(
              'show_pb_perc' => $wid_page[$dao->id]['show_pb_perc']));

        $this->setDefaults(array(
              'color_btn_newsletter' => $wid_page[$dao->id]['color_btn_newsletter']));
        $this->setDefaults(array(
              'color_btn_newsletter_bg' => $wid_page[$dao->id]['color_btn_newsletter_bg']));
        $this->setDefaults(array(
              'newsletter_text' => $wid_page[$dao->id]['newsletter_text']));
        $this->setDefaults(array(
              'color_newsletter_text' => $wid_page[$dao->id]['color_newsletter_text']));
                            
        if(true == $wid_page[$dao->id]['override']) {
          $cust_templ =  html_entity_decode($wid_page[$dao->id]['custom_template']);
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
      $cust_tmpl = str_replace("'", "''", $values['custom_template']);
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

    $title = str_replace("'", "''", $values['title']);
    $params = array(1 => array($title, 'String'),
      2 => array($values['logo_image'], 'String'),
      3 => array($values['image'], 'String'),
      4 => array($values['button_title'], 'String'),
      5 => array($values['button_link_to'], 'String'),
      6 => array($values['progress_bar'], 'Integer'),
      7 => array(str_replace("'", "''", $values['description']), 'String'),
      8 => array($values['email_signup_group_id'], 'String'),
      9 => array($values['size_variant'], 'String'),
      10 => array($values['color_title'], 'String'),
      11 => array($values['color_title_bg'], 'String'),
      12 => array($values['color_bar'], 'String'),
      13 => array($values['color_bar_bg'], 'String'),
      14 => array($values['color_widget_bg'], 'String'),
      15 => array($values['color_description'], 'String'),
      16 => array($values['color_border'], 'String'),
      17 => array($values['color_button'], 'String'),
      18 => array($values['color_button_bg'], 'String'),
      19 => array($hide_title, 'Integer'),
      20 => array($hide_border, 'Integer'),
      21 => array($hide_pbcap, 'Integer'),
      22 => array($values['color_btn_newsletter'], 'String'),
      23 => array($values['color_btn_newsletter_bg'], 'String'),
      24 => array($values['newsletter_text'], 'String'),
      25 => array($values['color_newsletter_text'], 'String'),
      26 => array($values['style_rules'], 'String'),
      27 => array($override, 'Integer'),
      28 => array($values['custom_template'], 'String'), 
      29 => array($values['show_pb_perc'], 'Integer'),);

    if (isset($this->_id)) {
      $sql = "UPDATE civicrm_wci_widget SET title = %1, logo_image =%2, 
      image = %3, button_title =%4, button_link_to =%5, 
      progress_bar_id = %6, description = %7, email_signup_group_id = %8,
      size_variant = %9, color_title = %10, color_title_bg = %11, 
      color_progress_bar = %12, color_progress_bar_bg = %13, 
      color_widget_bg=%14, color_description=%15, color_border = %16, 
      color_button = %17, color_button_bg = %18, hide_title = %19, 
      hide_border = %20, hide_pbcap = %21, color_btn_newsletter = %22, 
      color_btn_newsletter_bg = %23, newsletter_text = %24, 
      color_newsletter_text = %25, style_rules = %26, override = %27, 
      custom_template = %28, show_pb_perc = %29 where id = %30";
      
      $params += array(30 => array($this->_id, 'Integer'),);
    }
    else {
      $sql = "INSERT INTO civicrm_wci_widget (title, logo_image, image, 
      button_title, button_link_to, progress_bar_id, description, 
      email_signup_group_id, size_variant, color_title, color_title_bg, 
      color_progress_bar, color_progress_bar_bg, color_widget_bg, color_description, color_border, 
      color_button, color_button_bg, hide_title, hide_border, hide_pbcap, 
      color_btn_newsletter, color_btn_newsletter_bg, newsletter_text, 
      color_newsletter_text, style_rules, override, custom_template, show_pb_perc) 
      VALUES (%1, %2, %3, %4, %5, %6, %7, %8, %9, %10, %11, %12, %13, 
      %14, %15, %16, %17, %18, %19, %20, %21, %22, %23, %24, %25, %26, %27, %28, %29)";
    }

    $errorScope = CRM_Core_TemporaryErrorScope::useException();
    try {
      $transaction = new CRM_Core_Transaction();
      CRM_Core_DAO::executeQuery("SET foreign_key_checks = 0;");
      CRM_Core_DAO::executeQuery($sql, $params);
      CRM_Core_DAO::executeQuery("SET foreign_key_checks = 1;");
      $transaction->commit();
      if (isset($this->_id)) {
        $widget_id = $this->_id;
        CRM_Wci_BAO_WidgetCache::deleteWidgetCache($widget_id);
      }
      else {
        $widget_id = CRM_Core_DAO::singleValueQuery('SELECT LAST_INSERT_ID()');
      }
      CRM_Core_Session::setStatus(ts('Widget created successfuly'), '', 'success');
      
      if(isset($_REQUEST['_qf_CreateWidget_next'])) {
        CRM_Utils_System::redirect('?action=update&reset=1&id=' . $widget_id);
      } else {
        CRM_Utils_System::redirect('widget?reset=1');
      }
    }    
    catch (Exception $e) {
      CRM_Core_Session::setStatus(ts('Failed to create widget. ').
      $e->getMessage(), '', 'error');
      $transaction->rollback();
    }
     
    parent::postProcess();
  }
  
  function getProgressBars() {
    $options = array(
      0 => ts('- select -'),
    );
    $pbList = CRM_Wci_BAO_ProgressBar::getProgressbarList();
    foreach ($pbList as $pb) {
      $options[$pb['id']] = $pb['name'];
    }

    return $options;
  }

  function getGroupOptions() {
    $options = array(
      0 => ts('- select -'),
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
      'thin' => ts('Thin (150px)'),
      'normal' => ts('Normal (200px)'),
      'wide' => ts('Wide (250px)'),
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
