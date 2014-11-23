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
{* HEADER *}
<div class="crm-block crm-form-block">
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}
  {if $form.title.value != ""}
    {php}
      if(isset($_REQUEST['id'])) {
        $emb_id = $_REQUEST['id'];
        $wid_id = CRM_Wci_BAO_EmbedCode::getWidgetId($emb_id);
        $widget_controller_path = getWciWidgetControllerPath();
        $extension_root_path = getExtensionRootPath();
      }
    {/php}

    <div class="crm-section">
      <fieldset>
        <legend>
          Preview Widget and Get Code
        </legend>
        <div class="col1">
          <div class="description">
            Click <strong>Save &amp; Preview</strong> to save any changes to your settings, and preview the widget again on this page.
          </div>
          <script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?id={php}echo $wid_id;{/php}&preview=1"></script></script>
  <div id='widgetwci'></div>
        </div>
        <div class="col2">
          <div class="description">
            Add this widget to any web page by copying and pasting the code below.
          </div>
          <textarea rows="8" cols="40" name="widget_code" id="widget_code"><script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?id={php}echo $emb_id;{/php}&referal_id=2442"> </script>
<div id='widgetwci'></div></textarea>
          <br>
          <strong>
            <a href="#" onclick="NewEmbedCode.widget_code.select(); return false;">» Select Code</a>
          </strong>
        </div>
      </fieldset>
    </div>
  {/if}
{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)

  <div>
    <span>{$form.favorite_color.label}</span>
    <span>{$form.favorite_color.html}</span>
  </div>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
</div>
