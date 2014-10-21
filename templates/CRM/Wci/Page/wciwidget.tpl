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
        background-color: {/literal}{$wciform.color_widget_bg}{literal}; /* background color */
        border-color:{/literal}{$wciform.color_border}{literal}; /* border color */
        background:  {/literal}{if $wciform.image}url('{$wciform.image}'){/if}{literal}; /* background image */
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
        color: {/literal}{$wciform.color_title}{literal};
        background-color: {/literal}{$wciform.color_title_bg}{literal};
    } /* title */

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
    .crm-wci-widget .crm-amount-bar { /* progress bar */
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
        
        background-color:{/literal}{$wciform.color_bar}{literal};
        border-color:#CECECE;
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
        width: {/literal}{$wciform.pb_percentage}{literal}%; /* progress bar percentage */
    }
    .crm-wci-widget .crm-amount-raised-wrapper {
        margin-bottom:.8em;
    }
    .crm-wci-widget .crm-amount-raised {
        font-weight:bold;
        color:#000;
    }

    .crm-wci-widget .crm-logo {
        text-align:center;
    }

    .crm-wci-widget .crm-comments,
    .crm-wci-widget .crm-donors,
    .crm-wci-widget .crm-campaign {
        font-size:11px;
        margin-bottom:.8em;
        color:{/literal}{$wciform.color_description}{literal} /* other color*/
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
        color:{/literal}{$wciform.color_homepage_link}{literal} /* home page link color*/
    }

    .crm-wci-widget a.crm-wci-button { /* button color */
        background-color:{/literal}{$wciform.color_button_bg}{literal};
    }

    .crm-wci-widget .crm-wci-button-inner { /* button text color */
        padding:2px;
        display:block;
        color:{/literal}{$wciform.color_button}{literal};
    }

</style>

<style>
{/literal}
  {$wciform.style_rules}
{literal}
</style>
{/literal}

<div id="crm_wid_{$wciform.widgetId}" class="crm-wci-widget {$wciform.size_variant}">
    <h5 id="crm_wid_{$wciform.widgetId}_title">
      {if $wciform.logo_image}
        <span class="crm-logo">
          <img src="{$wciform.logo_image}" alt={ts}Logo{/ts}>
        </span>
      {/if}
      {$wciform.title}
    </h5>
    <div class="crm-amounts">
        <div id="crm_wid_{$wciform.widgetId}_amt_hi" class="crm-amount-high"></div>
        <div id="crm_wid_{$wciform.widgetId}_amt_low" class="crm-amount-low"></div>
        <div id="crm_wid_{$wciform.widgetId}_percentage" class="crm-percentage"></div>
    </div>
    <div class="crm-amount-bar">
        <div class="crm-amount-fill" id="crm_wid_{$wciform.widgetId}_amt_fill"></div>
    </div>
    <div id="crm_wid_{$wciform.widgetId}_donors" class="crm-donors">
    </div>
    <div id="crm_wid_{$wciform.widgetId}_comments" class="crm-comments">
      {$wciform.description}
    </div>
    <div id="crm_wid_{$wciform.widgetId}_campaign" class="crm-campaign">
    </div>
    <div class="crm-wci-button-wrapper" id="crm_wid_{$wciform.widgetId}_button">
        <a href='{crmURL p="civicrm/contribute/transact" q="reset=1&id=$cpageId" h=0 a=1 fe=1}' class="crm-wci-button"><span class="crm-wci-button-inner" id="crm_wid_{$wciform.widgetId}_btn_txt">{$wciform.button_title}</span></a>
    </div>
</div>
