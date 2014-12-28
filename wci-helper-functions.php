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

  function getContributionPageOptions() {
    $options = array(
      0 => ts('- select -'),
    );

    $result = civicrm_api3('contribution_page', 'get');
    foreach ($result['values'] as $contribution_page) {
      $options[$contribution_page['id']] = $contribution_page['title'];
    }

    return $options;
  }

  function getFinancialTypes() {
    $query = "SELECT id, name FROM civicrm_financial_type";
    $dao = CRM_Core_DAO::executeQuery($query);
    $options = array(
      0 => ts('- select -'),
    );

    while ($dao->fetch()) {
      $options[$dao->id] = $dao->name;
    }
    return $options;
  }
  function getWciWidgetTemplatePath() {
    $widget_tpl_path = __DIR__ . '/templates/CRM/Wci/Page';

    return $widget_tpl_path;
  }
