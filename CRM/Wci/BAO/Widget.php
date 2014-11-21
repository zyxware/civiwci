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
 *
 */

class CRM_Wci_BAO_Widget extends CRM_Wci_DAO_Widget {

  public static function getWidgetData($widgetId) {

    $query = "SELECT * FROM civicrm_wci_widget where id=".$widgetId;
    $params = array();

    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_Widget');

    $data = array();
    while ($dao->fetch()) {
      $data["title"] = $dao->title;
      $data["logo_image"] = $dao->logo_image;
      $data["image"] = $dao->image;

      (empty($dao->button_title)) ? $contrin_title = "Donate" :
      $contrin_title = $dao->button_title;

      $data["button_title"] = $contrin_title;

      $data["button_link_to"] = $dao->button_link_to;
      $data["progress_bar_id"] = $dao->progress_bar_id;
      $data["description"] = $dao->description;
      $data["email_signup_group_id"] = $dao->email_signup_group_id;
      $data["size_variant"] = $dao->size_variant;
      $data["color_title"] = $dao->color_title;
      $data["color_title_bg"] = $dao->color_title_bg;
      $data["color_progress_bar"] = $dao->color_progress_bar;
      $data["color_progress_bar_bg"] = $dao->color_progress_bar_bg;
      $data["color_widget_bg"] = $dao->color_widget_bg;
      $data["color_description"] = $dao->color_description;
      $data["color_border"] = $dao->color_border;
      $data["color_button"] = $dao->color_button;
      $data["color_button_bg"] = $dao->color_button_bg;
      $data['style_rules'] = $dao->style_rules;
      $data["show_pb_perc"] = $dao->show_pb_perc;
      CRM_Wci_BAO_ProgressBar::getProgressbarData($dao->progress_bar_id, $data);
      $data["custom_template"] = $dao->custom_template;
      $data["widgetId"] = $widgetId;
      $data["override"] = $dao->override;
      $data["hide_title"] = $dao->hide_title;
      $data["hide_border"] = $dao->hide_border;
      $data["hide_pbcap"] = $dao->hide_pbcap;
      $data["color_bar"] = $dao->color_progress_bar;
      $defProf = civicrm_api3('setting', 'getValue', array('group' => 'Wci Preference', 'name' => 'default_wci_profile'));
      $data["emailSignupGroupFormURL"] = CRM_Utils_System::baseCMSURL() . '/civicrm/profile/create?reset=1&amp;gid=' . $defProf;
      $data["color_btn_newsletter"] = $dao->color_btn_newsletter;
      $data["color_btn_newsletter_bg"] = $dao->color_btn_newsletter_bg;
      $data["newsletter_text"] = $dao->newsletter_text;
      $data["color_newsletter_text"] = $dao->color_newsletter_text;
    }
    return $data;
  }
  /**
   * Returns array of widgets
   * Fields : id, name
   * @return widget array
   * @access public
   */
  public static function getWidgetList() {
    $query = "SELECT * FROM civicrm_wci_widget";
    $params = array();
    $widgList = array();

    $dao = CRM_Core_DAO::executeQuery($query, $params, TRUE, 'CRM_Wci_DAO_Widget');

    while ($dao->fetch()) {
      $widgList[$dao->id] = array();
      CRM_Core_DAO::storeValues($dao, $widgList[$dao->id]);
    }

    return $widgList;
  }
}
