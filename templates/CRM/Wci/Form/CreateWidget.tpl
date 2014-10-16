{* HEADER *}

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
      $wid_id = $_REQUEST['id'];
      $data = CRM_Wci_BAO_Widget::getWidgetData($wid_id);
      $template = CRM_Core_Smarty::singleton();
      $template->assign('wciform', $data);
      $template->template_dir[] = getWciWidgetTemplatePath();
      $wcidata = $template->fetch('wciwidget.tpl');
    }
  {/php}

  <div class="crm-section">
    <div class="content">
    {include file="CRM/Wci/Page/wciwidget.tpl"}
    </div>
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

