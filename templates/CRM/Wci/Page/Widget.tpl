{literal}
<style>
    .crm-wci-widget {
        font-size:12px;
        font-family:Helvetica, Arial, sans;
        padding:6px;
        -moz-border-radius:       4px;
        -webkit-border-radius:   4px;
        -khtml-border-radius:   4px;
        border-radius:      4px;
        border:1px solid #96C0E7;
    }
    
    .crm-wci-widget.thin {
      width: 150px;
    }
    
    .crm-wci-widget.normal {
      width: 200px;
    }
    
    .crm-wci-widget.wide {
      width: 250px;
    }
    
    .crm-wci-widget h5 {
        font-size:14px;
        padding:3px;
        margin: 0px;
        text-align:center;
        -moz-border-radius:   4px;
        -webkit-border-radius:   4px;
        -khtml-border-radius:   4px;
        border-radius:      4px;
    }

    .crm-wci-widget .crm-amounts {
        height:1em;
        margin:.8em 0px;
        font-size:13px;
    }
    .crm-wci-widget .crm-amount-low {
        float:left;
    }
    .crm-wci-widget .crm-amount-high {
        float:right;
    }
    .crm-wci-widget .crm-percentage {
        margin:0px 30%;
        text-align:center;
    }
    .crm-wci-widget .crm-amount-bar {
        background-color:#FFF;
        width:100%;
        display:block;
        border:1px solid #CECECE;
        -moz-border-radius:   4px;
        -webkit-border-radius:   4px;
        -khtml-border-radius:   4px;
        border-radius:      4px;
        margin-bottom:.8em;
        text-align:left;
    }
    .crm-wci-widget .crm-amount-fill {
        background-color:#2786C2;
        height:1em;
        display:block;
        -moz-border-radius:   4px 0px 0px 4px;
        -webkit-border-radius:   4px 0px 0px 4px;
        -khtml-border-radius:   4px 0px 0px 4px;
        border-radius:      4px 0px 0px 4px;
        text-align:left;
        width: {/literal}{$form.pb_amount_fill.value}{literal}%; /* progress bar percentage */
    }
    .crm-wci-widget .crm-amount-raised-wrapper {
        margin-bottom:.8em;
    }
    .crm-wci-widget .crm-amount-raised {
        font-weight:bold;
    }

    .crm-wci-widget .crm-logo {
        text-align:center;
    }

    .crm-wci-widget .crm-comments,
    .crm-wci-widget .crm-donors,
    .crm-wci-widget .crm-campaign {
        font-size:11px;
        margin-bottom:.8em;
    }

    .crm-wci-widget .crm-wci-button {
        display:block;
        background-color:#CECECE;
        -moz-border-radius:       4px;
        -webkit-border-radius:   4px;
        -khtml-border-radius:   4px;
        border-radius:      4px;
        text-align:center;
        margin:0px 10% .8em 10%;
        text-decoration:none;
        color:#556C82;
        padding:2px;
        font-size:13px;
    }

    .crm-wci-widget .crm-home-url {
        text-decoration:none;
        border:0px;
    }

</style>
<style>
    .crm-wci-widget {
        background-color: {/literal}{$form.color_widget_bg.value}{literal}; /* background color */
        border-color:{/literal}{$form.color_border.value}{literal}; /* border color */
        background:  {/literal}{if $form.image.value}url('{$form.image.value}'){else}none{/if}{literal}; /* background image */
    }

    .crm-wci-widget h5 {
        color: {/literal}{$form.color_title.value}{literal};
        background-color: {/literal}{$form.color_title_bg.value}{literal};
    } /* title */

    .crm-wci-widget .crm-amount-raised { color:#000; }
    .crm-wci-widget .crm-amount-bar  /* progress bar */
        background-color:{/literal}{$form.color_bar.value}{literal};
        border-color:#CECECE;
    }
    .crm-wci-widget .crm-amount-fill { background-color:#2786C2; }

    .crm-wci-widget a.crm-wci-button { /* button color */
        background-color:{/literal}{$form.color_button_bg.value}{literal};
    }

    .crm-wci-widget .crm-wci-button-inner { /* button text color */
        padding:2px;
        display:block;
        color:{/literal}{$form.color_button.value}{literal};
    }

    .crm-wci-widget .crm-comments,
    .crm-wci-widget .crm-donors,
    .crm-wci-widget .crm-campaign {
        color:{/literal}{$form.color_description.value}{literal} /* other color*/
    }

    .crm-wci-widget .crm-home-url {
        color:{/literal}{$form.color_homepage_link.value}{literal} /* home page link color*/
    }

</style>
<style>
{/literal}
  {$form.style_rules.value}
{literal}
</style>
</literal>

<div id="crm_wid_{$widgetId}" class="crm-wci-widget {$form.size_variant.value}">
    <h5 id="crm_wid_{$widgetId}_title">
      {if $form.logo_image.value}
        <span class="crm-logo">
          <img src="{$form.logo_image.value}" alt={ts}Logo{/ts}>
        </span>
      {/if}
      {$form.title.value}
    </h5>
    <div class="crm-amounts">
        <div id="crm_wid_{$widgetId}_amt_hi" class="crm-amount-high"></div>
        <div id="crm_wid_{$widgetId}_amt_low" class="crm-amount-low"></div>
        <div id="crm_wid_{$widgetId}_percentage" class="crm-percentage"></div>
    </div>
    <div class="crm-amount-bar">
        <div class="crm-amount-fill" id="crm_wid_{$widgetId}_amt_fill"></div>
    </div>
    <div id="crm_wid_{$widgetId}_donors" class="crm-donors">
    </div>
    <div id="crm_wid_{$widgetId}_comments" class="crm-comments">
      {$form.description.value}
    </div>
    <div id="crm_wid_{$widgetId}_campaign" class="crm-campaign">
    </div>
    <div class="crm-wci-button-wrapper" id="crm_wid_{$widgetId}_button">
        <a href='{crmURL p="civicrm/contribute/transact" q="reset=1&id=$form.button_link_to.value" h=0 a=1 fe=1}' class="crm-wci-button"><span class="crm-wci-button-inner" id="crm_wid_{$widgetId}_btn_txt">{$form.button_title.value}</span></a>
    </div>
</div>