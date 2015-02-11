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

class CRM_Wci_Form_PBSource {

  static function buildQuickForm(&$form, $blockId, $blockEdit = FALSE) {
      $form->add(
        'select', // field type
        'contribution_page_'.$blockId, // field name
        'Contribution page', // field label
        getContributionPageOptions(), // list of options
        true // is required
      );
      $form->add(
          'select', // field type
          'financial_type_'.$blockId, // field name
          'Financial type', // field label
          getFinancialTypes(), // list of options
          false // is required
        );
      $form->add(
        'text',
        'contribution_start_date_'.$blockId,
        ts('Start Date'), true
      );
      $form->add(
        'text',
        'contribution_end_date_'.$blockId,
        ts('End Date')
      );
      $form->add(
        'text', // field type
        'percentage_'.$blockId, // field name
        'Percentage of contribution taken', // field label
        array('value'=>'100'),
        true // is required
      );
  }
}
