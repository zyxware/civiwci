{* HEADER *}
<div class="crm-block crm-form-block">
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  {if $form.title.value != ""}
    {php} 
      if(isset($_REQUEST['id'])) {
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
          <script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?id={php}echo $_REQUEST['id'];{/php}&preview=1"></script>
  <div id='widgetwci'></div>
        </div>
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
