{* HEADER *}
<div class="crm-block crm-form-block">
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  {if $form.title.value != ""}
    {php} 
      if(isset($_REQUEST['id'])) {
        /*$wid_id = $_REQUEST['id'];
        $data = CRM_Wci_BAO_Widget::getWidgetData($wid_id);
        $template = CRM_Core_Smarty::singleton();
        $template->assign('wciform', $data);
        if($data["override"] == 0) {
          $template->template_dir[] = getWciWidgetTemplatePath();
          $wcidata = $template->fetch('wciwidget.tpl');
        } else {
          $wcidata = $template->fetch('string:' . $wid_page[$dao->id]['custom_template']);
        }*/
        $widget_controller_path = getWciWidgetControllerPath();
        $extension_root_path = getExtensionRootPath();
      }
    {/php}

    <div class="crm-section">
      <div class="label">Widget Preview</div>
        <div class="content">

        <div class="col1">
          <div class="description">
            Click <strong>Save &amp; Preview</strong> to save any changes to your settings, and preview the widget again on this page.
          </div>
<!--          <script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?widgetId={php}echo $wid_id;{/php}&preview=1&referalid=2442"></script></script> -->
          <script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?id={php}echo $_REQUEST['id'];{/php}&preview=1&referalid=2442"></script></script>
  <div id='widgetwci'></div>
        </div>
<!--        <div class="col2">
          <div class="description">
            Add this widget to any web page by copying and pasting the code below.
          </div>
          <textarea rows="8" cols="40" name="widget_code" id="widget_code"><script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?widgetId={php}echo $wid_id;{/php}&embed=1&referalId=2442"> </script> 
<div id='widgetwci'></div></textarea>
          <br>
          <strong>
            <a href="#" onclick="CreateWidget.widget_code.select(); return false;">» Select Code</a>
          </strong>
        </div> -->
    </div>
          <div class="clear"></div>
    </div>
  {/if}
  
  {* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

  {foreach from=$elementNames item=elementName}
    <div class="crm-section">
      <div class="label">{$form.$elementName.label}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
    </div>
  {/foreach}
  
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
