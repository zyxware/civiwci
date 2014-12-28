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
    {if $rows}
      <div id="configure_contribution_page">
             {strip}

       {include file="CRM/common/pager.tpl" location="top"}
             {include file="CRM/common/pagerAToZ.tpl"}
       {include file="CRM/common/jsortable.tpl"}
       <a class="button" href="progress-bar/add"><span><div class="icon add-icon"></div>New Progress Bar</span></a>
             <table id="options" class="display">
               <thead>
               <tr>
                 <th id="sortable">{ts}Name{/ts}</th>
               <th>{ts}Goal Amout{/ts}</th>
            <th></th>
               </tr>
               </thead>
               {foreach from=$rows item=row}
                 <tr id="row_{$row.id}" >   {* class="{if NOT $row.is_active} disabled{/if}" *}
                     <td><strong>{$row.name}</strong></td>
                     <td>{$row.goal_amount}</td>
          <td class="crm-contribution-page-actions right nowrap">

       {if $row.configureActionLinks}
         <div class="crm-contribution-page-configure-actions">
                  {$row.configureActionLinks|replace:'xx':$row.id}
         </div>
             {/if}

            {if $row.contributionLinks}
        <div class="crm-contribution-online-contribution-actions">
                  {$row.contributionLinks|replace:'xx':$row.id}
        </div>
        {/if}

        {if $row.onlineContributionLinks}
        <div class="crm-contribution-search-contribution-actions">
                  {$row.onlineContributionLinks|replace:'xx':$row.id}
        </div>
        {/if}

        <div class="crm-contribution-page-more">
                    {$row.action|replace:'xx':$row.id}
        </div>
      </td>
         </tr>
         {/foreach}
      </table>

        {/strip}
      </div>
       <div class="description">
         To use a progress bar, <a accesskey="N" href='widget/add'>create</a> a widget and associate it with the progressbar.
       </div>
    {else}
      <div class="messages status no-popup">
             <div class="icon inform-icon"></div> &nbsp;
             {ts 1=$newPageURL}No Progressbars have been created yet. Click <a accesskey="N" href='progress-bar/add'>here</a> to create a new Progressbar.{/ts}
      </div>

    {/if}
