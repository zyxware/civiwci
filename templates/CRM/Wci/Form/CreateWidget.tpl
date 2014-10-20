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
      $widget_controller_path = getWciWidgetControllerPath();
    }
  {/php}

  <div class="crm-section">
    <div class="label">
      <label for="embd_code">Code to embed:</label>
    </div>
    <div class="content">
      <div class="resizable-textarea">
        <span>{literal}
          <textarea name="embd_code" id="embd_code" class="form-textarea textarea-processed">&lt;script src="http://code.jquery.com/jquery-1.9.1.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="{/literal}{php}echo $widget_controller_path;{/php}{literal}?widgetId={/literal}{php}echo $wid_id;{/php}{literal}"&gt;&lt;/script&gt;
&lt;script&gt;
  $( document ).ready(function() {
    $('#widgetwci').html(wciwidgetcode);
  });
&lt;/script&gt;
&lt;div id='widgetwci'&gt;&lt;/div&gt;</textarea>{/literal}
          <div class="grippie" style="margin-right: 18px;"></div>
        </span>
      </div>
    </div>
    <div class="clear"></div>
  </div>
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

