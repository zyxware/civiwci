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
    {foreach from=$pbSrcs item=idsrc}
      {assign var=PBblockId value=$idsrc}
      {include file="CRM/Wci/Form/PBSource.tpl"}
    {/foreach}
    {if not $pbSrcs}
      {include file="CRM/Wci/Form/PBSource.tpl"}
    {/if}
  {else}
    {include file="CRM/Wci/Form/PBSource.tpl"}
  {/if}

    <div class="crm-section">
      <div class="label">{$form.addmore_link.label}</div>
      <div class="content">{$form.addmore_link.html}</div>
      <div class="clear"></div>
    </div>

  {* FOOTER *}

{if not $PBSource_block}
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
{/if}
