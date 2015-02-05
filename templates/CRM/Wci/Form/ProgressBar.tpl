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

{if not $PBSource_block}
<div class="crm-block crm-form-block">
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

    <div class="crm-section">
      <div class="label">{$form.progressbar_name.label}</div>
      <div class="content">{$form.progressbar_name.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.starting_amount.label}</div>
      <div class="content">{$form.starting_amount.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.goal_amount.label}</div>
      <div class="content">{$form.goal_amount.html}</div>
      <div class="clear"></div>
    </div>
    <div class="crm-wci-pb"><hr></div>
    <label><SMALL>
    Progressbar shows the sum of percentage of contributions done on each selected contribution page or financial type.
    </SMALL></label>
    {include file="CRM/Wci/Form/PBSource.tpl"}
{else}
    {include file="CRM/Wci/Form/PBSource.tpl"}
{/if}

    <div class="crm-section">
      <div class="label">{$form.addmore_link.label}</div>
      <div class="content">{$form.addmore_link.html}</div>
      <div class="clear"></div>
    </div>


<!--
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
          <span class="description">{ts}Date to which contributions to be added to this progressbar. Keep it empty to select contributions up to today.{/ts}</span>
        </div>
      {else}
        {if substr($form.$elementName.id, 0, 18) eq 'contribution_page_'}
          <div id="crm-section-con-{$form.$elementName.id|substr:18}">
          <div class="content">{$form.$elementName.html}
          <a id="remove_link" class="form-link" href="remove" name="remove_link-{$form.$elementName.id|substr:18}"> Remove</a>
        {else}
          <div class="content">{$form.$elementName.html}
        {/if}
        </div>
      {/if}
      <div class="clear"></div>
        {if substr($form.$elementName.id, 0, 11) eq 'percentage_'}
          </div>
      {/if}
    </div>

  {/foreach}
-->
  {* FOOTER *}

{if not $PBSource_block}
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
{/if}
