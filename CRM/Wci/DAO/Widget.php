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
   * Widget progress bar background color
   *
   * @var string
   */
  public $color_progress_bar_bg;

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
   * Flag to Hide title
   *
   * @var boolean
   */
  public $hide_title;
  /**
   * Flag to Hide widget border
   *
   * @var boolean
   */
  public $hide_border;
  /**
   * Flag to Hide pb caption
   *
   * @var boolean
   */
  public $hide_pbcap;
  /**
   * if true then shows pb in % else in collected amount
   *
   * @var boolean
   */
  public $show_pb_perc;
  /**
   * Custom template
   *
   * @var string
   */
  public $custom_template;

  /**
   * Newsletter Button text color
   *
   * @var string
   */
  public $color_btn_newsletter;

  /**
   * Newsletter Button color
   *
   * @var string
   */
  public $color_btn_newsletter_bg;

   /**
   * Newsletter text
   *
   * @var string
   */
  public $newsletter_text;

  /**
   * Newsletter msg text color
   *
   * @var string
   */
  public $color_newsletter_text;

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
      self::$_links = [
        new CRM_Core_EntityReference(self::getTableName() , 'button_link_to', 'civicrm_contribution_page', 'id') ,
        new CRM_Core_EntityReference(self::getTableName() , 'progress_bar_id', 'civicrm_wci_progress_bar', 'id') ,
        new CRM_Core_EntityReference(self::getTableName() , 'email_signup_group_id', 'civicrm_group', 'id') ,
      ];
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
      self::$_fields = [
        'widget_id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('WCI Widget Id', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
        ] ,
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 64,
        ] ,
        'logo_image' => [
          'name' => 'logo_image',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Image url of widget logo image', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
          'maxlength' => 255,
        ] ,
        'image' => [
          'name' => 'image',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Url of widget image', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
          'maxlength' => 255,
        ] ,
        'button_title' => [
          'name' => 'button_title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Contribute/Donate button title', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
          'maxlength' => 64,
        ] ,
        'button_link_to' => [
          'name' => 'button_link_to',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contribution/Donation page reference', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'progress_bar_id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('WCI Progress Bar Reference Id', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'description' => [
          'name' => 'description',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Widget description', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'email_signup_group_id' => [
          'name' => 'email_signup_group_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Group reference for email newsletter signup', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'size_variant' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget size variant', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_title' => [
          'name' => 'color_title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_title_bg' => [
          'name' => 'color_title_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget title background color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_progress_bar' => [
          'name' => 'color_progress_bar',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Progress bar color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_progress_bar_bg' => [
          'name' => 'color_progress_bar_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Progress bar background color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_widget_bg' => [
          'name' => 'color_widget_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget background color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_description' => [
          'name' => 'color_description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget description color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_border' => [
          'name' => 'color_border',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget border color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_button' => [
          'name' => 'color_button',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget button text color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_button_bg' => [
          'name' => 'color_button_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Widget button background color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'style_rules' => [
          'name' => 'style_rules',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Additional style rules', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'override' => [
          'name' => 'override',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Override default template', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'hide_title' => [
          'name' => 'hide_title',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Hide title, if 1.', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'hide_border' => [
          'name' => 'hide_border',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Hide widget border, if 1.', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'hide_pbcap' => [
          'name' => 'hide_pbcap',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Hide pb caption, if 1.', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'show_pb_perc' => [
          'name' => 'show_pb_perc',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('pb in %(1) or amount(0).', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,
        'custom_template' => [
          'name' => 'custom_template',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Widget custom template', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => false,
        ] ,

        'color_btn_newsletter' => [
          'name' => 'color_btn_newsletter',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Newsletter Button text color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'color_btn_newsletter_bg' => [
          'name' => 'color_btn_newsletter_bg',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Newsletter Button color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
        'newsletter_text' => [
          'name' => 'newsletter_text',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Newsletter text', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 64,
        ] ,
        'color_newsletter_text' => [
          'name' => 'color_newsletter_text',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Newsletter text color', ['domain' => 'com.zyxware.civiwci']) ,
          'required' => true,
          'maxlength' => 10,
        ] ,
      ];
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
      self::$_fieldKeys = [
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
        'color_progress_bar_bg' => 'color_progress_bar_bg',
        'color_widget_bg' => 'color_widget_bg',
        'color_description' => 'color_description',
        'color_border' => 'color_border',
        'color_button' => 'color_button',
        'color_button_bg' => 'color_button_bg',
        'style_rules' => 'style_rules',
        'override' => 'override',
        'hide_title' => 'hide_title',
        'hide_border' => 'hide_border',
        'hide_pbcap' => 'hide_pbcap',
        'show_pb_perc' => 'show_pb_perc',
        'custom_template' => 'custom_template',
      ];
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
      self::$_import = [];
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
      self::$_export = [];
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
