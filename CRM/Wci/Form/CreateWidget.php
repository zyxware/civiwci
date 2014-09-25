<?php

require_once 'CRM/Core/Form.php';
require_once 'wci-helper-functions.php';

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
    parent::preProcess();

    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, NULL, 'REQUEST'
    );

    $this->_colorFields = array('color_title' => array(ts('Title Text Color'),
        'text',
        FALSE,
        '#2786C2',
      ),
      'color_bar' => array(ts('Progress Bar Color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_main_text' => array(ts('Additional Text Color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_main' => array(ts('Background Color'),
        'text',
        FALSE,
        '#96C0E7',
      ),
      'color_main_bg' => array(ts('Background Color Top Area'),
        'text',
        FALSE,
        '#B7E2FF',
      ),
      'color_bg' => array(ts('Border Color'),
        'text',
        FALSE,
        '#96C0E7',
      ),
      'color_about_link' => array(ts('Button Link Color'),
        'text',
        FALSE,
        '#556C82',
      ),
      'color_button' => array(ts('Button Background Color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
      'color_homepage_link' => array(ts('Homepage Link Color'),
        'text',
        FALSE,
        '#FFFFFF',
      ),
    );
  }

  function setDefaultValues() {
    $defaults = array();
    
    $defaults['size_variant'] = 'normal';
    foreach ($this->_colorFields as $name => $val) {
      $defaults[$name] = $val[3];
    }

    return $defaults;
  }

  function buildQuickForm() {
    
    // add form elements
    $this->add('text', 'title', ts('Title'),true);
    $this->add('text', 'logo_image', ts('Logo image'));
    $this->add('text', 'image', ts('Image'));
    $this->add('select', 'button_link_to', ts('Contribution button'), getContributionPageOptions());
    $this->add('text', 'button_title', ts('Contribution button title'));
    $this->add('select', 'progress_bar', ts('Progress bar'), array('' => '- select -'));
    $this->addWysiwyg('description', ts('Description'), '');
    $this->add('select', 'email_signup_group_id', ts('Newsletter signup'), $this->getGroupOptions());
    $this->add('select', 'size_variant', ts('Size variant'), $this->getSizeOptions());
    foreach ($this->_colorFields as $name => $val) {
      $this->add($val[1],
        $name,
        $val[0],
        $name,
        $val[2]
      );
    }
    $this->add('textarea', 'style_rules', ts('Additional Style Rules'));
    $this->add('checkbox', 'override', ts('Override default template'));
    $this->addWysiwyg('custom_template', ts('Custom template'), '');
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

    $values = $this->exportValues();
    
    parent::postProcess();
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
    
    $result = civicrm_api3('group', 'get');    
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
