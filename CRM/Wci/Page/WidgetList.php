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
    elseif ($action & CRM_Core_Action::COPY) {
      try {
        $sql = "INSERT INTO civicrm_wci_widget (title, logo_image, image,
        button_title, button_link_to, progress_bar_id, description,
        email_signup_group_id, size_variant, color_title, color_title_bg,
        color_progress_bar, color_progress_bar_bg, color_widget_bg, color_description, color_border,
        color_button, color_button_bg, hide_title, hide_border, hide_pbcap,
        color_btn_newsletter, color_btn_newsletter_bg, newsletter_text,
        color_newsletter_text, style_rules, override, custom_template, show_pb_perc)
        SELECT concat(title, '-', (SELECT MAX(id) FROM civicrm_wci_widget)), logo_image, image,
        button_title, button_link_to, progress_bar_id, description,
        email_signup_group_id, size_variant, color_title, color_title_bg,
        color_progress_bar, color_progress_bar_bg, color_widget_bg, color_description, color_border,
        color_button, color_button_bg, hide_title, hide_border, hide_pbcap,
        color_btn_newsletter, color_btn_newsletter_bg, newsletter_text,
        color_newsletter_text, style_rules, override, custom_template, show_pb_perc FROM civicrm_wci_widget WHERE id=%1";
        CRM_Core_DAO::executeQuery("SET foreign_key_checks = 0;");
        CRM_Core_DAO::executeQuery($sql,
              array(1=>array($id, 'Integer'),
        ));
        CRM_Core_DAO::executeQuery("SET foreign_key_checks = 1;");
      }
      catch (Exception $e) {
        CRM_Core_Session::setStatus(ts('Failed to create widget. ') .
        $e->getMessage(), '', 'error');
        $transaction->rollback();
      }
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
        CRM_Core_Session::setStatus(ts('Failed to delete widget. ') . $e->getMessage(), '', 'error');
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
        CRM_Core_Action::COPY => array(
          'name' => ts('Clone'),
          'url' => CRM_Utils_System::currentPath(),
          'qs' => 'action=copy&reset=1&id=%%id%%',
          'title' => ts('copy'),
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
