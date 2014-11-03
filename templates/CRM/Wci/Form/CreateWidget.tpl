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

  {php} 
    if(isset($_REQUEST['id'])) {
      $wid_id = $_REQUEST['id'];
      $data = CRM_Wci_BAO_Widget::getWidgetData($wid_id);
      $template = CRM_Core_Smarty::singleton();
      $template->assign('wciform', $data);
      if($data["override"] == 0) {
        $template->template_dir[] = getWciWidgetTemplatePath();
        $wcidata = $template->fetch('wciwidget.tpl');
      } else {
        $wcidata = $template->fetch('string:' . base64_decode($wid_page[$dao->id]['custom_template']));
      }
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
          <textarea name="embd_code" id="embd_code" class="form-textarea textarea-processed">
<script type="text/javascript" src="{/literal}{php}echo $widget_controller_path;{/php}{literal}?widgetId={/literal}{php}echo $wid_id;{/php}{literal}"></script>
<script type="text/javascript">
// Cleanup functions for the document ready method
if ( document.addEventListener ) {
    DOMContentLoaded = function() {
        document.removeEventListener( "DOMContentLoaded", DOMContentLoaded, false );
        onReady();
    };
} else if ( document.attachEvent ) {
    DOMContentLoaded = function() {
        // Make sure body exists, at least, in case IE gets a little overzealous
        if ( document.readyState === "complete" ) {
            document.detachEvent( "onreadystatechange", DOMContentLoaded );
            onReady();
        }
    };
}
if ( document.readyState === "complete" ) {
    // Handle it asynchronously to allow scripts the opportunity to delay ready
    setTimeout( onReady, 1 );
}

// Mozilla, Opera and webkit support this event
if ( document.addEventListener ) {
    // Use the handy event callback
    document.addEventListener( "DOMContentLoaded", DOMContentLoaded, false );
    // A fallback to window.onload, that will always work
    window.addEventListener( "load", onReady, false );
    // If IE event model is used
} else if ( document.attachEvent ) {
    // ensure firing before onload,
    // maybe late but safe also for iframes
    document.attachEvent("onreadystatechange", DOMContentLoaded);

    // A fallback to window.onload, that will always work
    window.attachEvent( "onload", onReady );
}

function onReady( ) {
  document.getElementById('widgetwci').innerHTML = wciwidgetcode;
}
</script>
<div id='widgetwci'></div></textarea>{/literal}
          <div class="grippie" style="margin-right: 18px;"></div>
        </span>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="content">
   {* {include file="CRM/Wci/Page/wciwidget.tpl"} *}

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="{php}echo $widget_controller_path;{/php}?widgetId={php}echo $wid_id;{/php}"></script>
<script>
  $( document ).ready(function()  {ldelim} 
    $('#widgetwci').html(wciwidgetcode);
   {rdelim} );
</script>
<div id='widgetwci'></div>

    </div>
  </div>

{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)

  <div>
    <span>{$form.favorite_color.label}</span>
    <span>{$form.favorite_color.html}</span>
  </div>

{* FOOTER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

