<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.4                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2013                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 */
class CRM_Wci_DAO_Widget extends CRM_Core_DAO
{
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'civicrm_wci_widget';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = null;
  /**
   * static instance to hold the keys used in $_fields for each field.
   *
   * @var array
   * @static
   */
  static $_fieldKeys = null;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = null;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = null;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = null;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = true;
  /**
   * Widget Id
   *
   * @var int unsigned
   */
  public $id;
  /**
   * Widget title
   *
   * @var string
   */
  public $title;
  /**
   * Widget title logo
   *
   * @var string
   */
  public $logo_image;
  /**
   * Widget image
   *
   * @var string
   */
  public $image;
  /**
   * Widget contribute/donate button title
   *
   * @var string
   */
  public $button_title;
  /**
   * Contribution/donate page reference id
   *
   * @var int unsigned
   */
  public $button_link_to;
  /**
   * WCI Progress bar reference id
   *
   * @var int unsigned
   */
  public $progress_bar_id;
  /**
   * Widget description
   *
   * @var string
   */
  public $description;
  /**
   * Newsletter signup group reference id
   *
   * @var int unsigned
   */
  public $email_signup_group_id;
  /**
   * Widget size (Thin/Normal/Wide)
   *
   * @var string
   */
  public $size_variant;
  /**
   * Widget title color
   *
   * @var string
   */
  public $color_title;
  /**
   * Widget title background color
   *
   * @var string
   */
  public $color_title_bg;
  /**
   * Widget progress bar color
   *
   * @var string
   */
  public $color_progress_bar;
  /**
   * Widget background color
   *
   * @var string
   */
  public $color_widget_bg;
  /**
   * Widget description color
   *
   * @var string
   */
  public $color_description;
  /**
   * Widget border color
   *
   * @var string
   */
  public $color_border;
  /**
   * Widget button color
   *
   * @var string
   */
  public $color_button;
  /**
   * Widget button background color
   *
   * @var string
   */
  public $color_button_bg;
  /**
   * Additional custom style rules
   *
   * @var int unsigned
   */
  public $style_rules;
  /**
   * Flag to override default widget template
   *
   * @var boolean
   */
  public $override;
  /**
   * Custom template
   *
   * @var string
   */
  public $custom_template;
  function __construct()
  {
    $this->__table = 'civicrm_wci_widget';
    parent::__construct();
  }
  /**
   * return foreign keys and entity references
   *
   * @static
   * @access public
   * @return array of CRM_Core_EntityReference
   */
  static function getReferenceColumns()
  {
    if (!self::$_links) {
      self::$_links = array(
        new CRM_Core_EntityReference(self::getTableName() , 'button_link_to', 'civicrm_contribution_page', 'id') ,
        new CRM_Core_EntityReference(self::getTableName() , 'progress_bar_id', 'civicrm_wci_progress_bar', 'id') ,
        new CRM_Core_EntityReference(self::getTableName() , 'email_signup_group_id', 'civicrm_group', 'id') ,
      );
    }
    return self::$_links;
  }
  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields()
  {
    if (!(self::$_fields)) {
      self::$_fields = array(
        'widget_id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('WCI Widget Id', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
        ) ,
        'title' => array(
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 64,
        ) ,
        'logo_image' => array(
          'name' => 'logo_image',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Image url of widget logo image', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
          'maxlength' => 255,
        ) ,
        'image' => array(
          'name' => 'image',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Url of widget image', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
          'maxlength' => 255,
        ) ,
        'button_title' => array(
          'name' => 'button_title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Contribute/Donate button title', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
          'maxlength' => 64,
        ) ,
        'button_link_to' => array(
          'name' => 'button_link_to',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contribution/Donation page reference', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'progress_bar_id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('WCI Progress Bar Reference Id', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'description' => array(
          'name' => 'description',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Widget description', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'email_signup_group_id' => array(
          'name' => 'email_signup_group_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Group reference for email newsletter signup', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'size_variant' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget size variant', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_title' => array(
          'name' => 'color_title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_title_bg' => array(
          'name' => 'color_title_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title background color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_progress_bar' => array(
          'name' => 'color_progress_bar',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Progress bar color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_widget_bg' => array(
          'name' => 'color_widget_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget background color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_description' => array(
          'name' => 'color_description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget description color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_border' => array(
          'name' => 'color_border',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget border color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_button' => array(
          'name' => 'color_button',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget button text color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'color_button_bg' => array(
          'name' => 'color_button_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget button background color', array('domain' => 'org.civicrm.wci')) ,
          'required' => true,
          'maxlength' => 10,
        ) ,
        'style_rules' => array(
          'name' => 'style_rules',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Additional style rules', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'override' => array(
          'name' => 'override',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Override default template', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
        'custom_template' => array(
          'name' => 'custom_template',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Widget custom template', array('domain' => 'org.civicrm.wci')) ,
          'required' => false,
        ) ,
      );
    }
    return self::$_fields;
  }
  /**
   * Returns an array containing, for each field, the arary key used for that
   * field in self::$_fields.
   *
   * @access public
   * @return array
   */
  static function &fieldKeys()
  {
    if (!(self::$_fieldKeys)) {
      self::$_fieldKeys = array(
        'id' => 'widget_id',
        'title' => 'title',
        'logo_image' => 'logo_image',
        'image' => 'image',
        'button_title' => 'button_title',
        'button_link_to' => 'button_link_to',
        'progress_bar_id' => 'progress_bar_id',
        'description' => 'description',
        'email_signup_group_id' => 'email_signup_group_id',
        'size_variant' => 'size_variant',
        'color_title' => 'color_title',
        'color_title_bg' => 'color_title_bg',
        'color_progress_bar' => 'color_progress_bar',
        'color_widget_bg' => 'color_widget_bg',
        'color_description' => 'color_description',
        'color_border' => 'color_border',
        'color_button' => 'color_button',
        'color_button_bg' => 'color_button_bg',
        'style_rules' => 'style_rules',
        'override' => 'override',
        'custom_template' => 'custom_template',
      );
    }
    return self::$_fieldKeys;
  }
  /**
   * returns the names of this table
   *
   * @access public
   * @static
   * @return string
   */
  static function getTableName()
  {
    return self::$_tableName;
  }
  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  function getLog()
  {
    return self::$_log;
  }
  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   * @static
   */
  static function &import($prefix = false)
  {
    if (!(self::$_import)) {
      self::$_import = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['wci_widget'] = & $fields[$name];
          } else {
            self::$_import[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }
  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   * @static
   */
  static function &export($prefix = false)
  {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['wci_widget'] = & $fields[$name];
          } else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
