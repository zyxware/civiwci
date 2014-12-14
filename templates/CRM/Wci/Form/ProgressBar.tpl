{*
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
*}
{literal}
<style>
    .crm-wci-pb hr {
      align:center;
      display: block; height: 1px;
      border: 0; border-top: 1px;
      margin: 1em 0; padding: 0;
    }
</style>
{/literal}
{* HEADER *}
<div class="crm-block crm-form-block">
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  {foreach from=$elementNames item=elementName}
    <div class="crm-section">
      <div class="label">{$form.$elementName.label}</div>
      {if substr($elementName, 0, 23)  eq 'contribution_start_date'}
        <div class="content">{$form.$elementName.html}
          <span class="description">(Format YYYY-MM-DD)</span>
          <br>
          <span class="description">{ts}Date from which contributions to be added to this progressbar. Keep it empty to select contributions from the beginning.{/ts}</span>
        </div>
      {elseif substr($elementName, 0, 21)  eq 'contribution_end_date'}
        <div class="content">{$form.$elementName.html}
          <span class="description">(Format YYYY-MM-DD)</span>
          <br>
          <span class="description">{ts}Date to which contributions to be added to this progressbar. Keep it empty to select contributions up to today{/ts}</span>
        </div>
      {else}
        <div class="content">{$form.$elementName.html}</div>
      {/if}
      <div class="clear"></div>
    </div>
  {/foreach}


  {* FOOTER *}
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
