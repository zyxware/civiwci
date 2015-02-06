{*
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
*}
{* This file provides the plugin for the phone block *}
{* @var $form Contains the array for the form elements and other form associated information assigned to the template by the controller*}
{* @var blockId Contains the current block id, and assigned in the CRM/Contact/Form/Location.php file *}

{if not $PBblockId}
  {assign var=PBblockId value=1}
{/if}
{assign var=contribution_page value=contribution_page_$PBblockId}
{assign var=financial_type value=financial_type_$PBblockId}
{assign var=contribution_start_date value=contribution_start_date_$PBblockId}
{assign var=contribution_end_date value=contribution_end_date_$PBblockId}
{assign var=percentage value=percentage_$PBblockId}
<div id="PBSource-{$PBblockId}">
      {if 1 < $PBblockId}
        <div class="crm-wci-pb"><hr></div>
      {/if}
    <div class="crm-section">
      <div class="label">{$form.$contribution_page.label}</div>
      <div class="content">{$form.$contribution_page.html}
      {if 1 < $PBblockId}
         <a id="remove_link" class="form-link" href="remove" name="remove_link-{$PBblockId}"> Remove</a>
      {/if}
      </div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.$financial_type.label}</div>
      <div class="content">{$form.$financial_type.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.$contribution_start_date.label}</div>
      <div class="content">{$form.$contribution_start_date.html}
          <span class="description">(Format YYYY-MM-DD)</span>
          <br>
          <span class="description">{ts}Date from which contributions to be added to this progressbar. Keep it empty to select contributions from the beginning.{/ts}</span>
      </div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.$contribution_end_date.label}</div>
      <div class="content">{$form.$contribution_end_date.html}
          <span class="description">(Format YYYY-MM-DD)</span>
          <br>
          <span class="description">{ts}Date to which contributions to be added to this progressbar. Keep it empty to select contributions up to today.{/ts}</span>
      </div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.$percentage.label}</div>
      <div class="content">{$form.$percentage.html}</div>
      <div class="clear"></div>
    </div>
</div>
