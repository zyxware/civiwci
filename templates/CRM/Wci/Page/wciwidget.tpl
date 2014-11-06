{literal}
<style>
    .crm-wci-widget {
        font-size:12px;
        font-family:Helvetica, Arial, sans;
        padding:6px;
        -moz-border-radius: 12px;
        -webkit-border-radius: 12px;
        -khtml-border-radius: 12px;
        border-radius: 12px;
        {/literal}{if (0 == $wciform.hide_border)}{literal}
          border: 4px solid {/literal}{$wciform.color_border}{literal};
        {if (1 == $wciform.hide_border)}
          border: None;
        {/literal}{/if}{literal}
        background-color: {/literal}{$wciform.color_widget_bg}{literal}; /* background color */
        box-shadow: 3px 3px 6px;
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
    
    h5 {
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

    .crm-amounts {
        height:1em;
        margin:.8em 0px;
        font-size:13px;
    }
    .crm-amount-low {
        float:left;
    }
    .crm-amount-high {
        float:right;
    }
    .crm-percentage {
        margin:0px 30%;
        text-align:center;
    }
    .crm-amount-bar { /* progress bar */
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
        
        background-color: #FFFFFF;
        border-color:#CECECE;
    }
    .crm-amount-fill {
        background-color:{/literal}{$wciform.color_bar}{literal};
        height:1em;
        display:block;
        -moz-border-radius:   4px;
        -webkit-border-radius:   4px;
        -khtml-border-radius:   4px;
        border-radius:      4px;
        text-align:left;
        width: {/literal}{$wciform.pb_percentage}{literal}%; /* progress bar percentage */
    }
    .crm-amount-raised-wrapper {
        margin-bottom:.8em;
    }
    .crm-amount-raised {
        font-weight:bold;
        color:#000;
    }

    .crm-logo {
        text-align:center;
    }

    .crm-comments,
    .crm-donors,
    .crm-campaign {
        font-size:11px;
        margin-bottom:.8em;
        color:{/literal}{$wciform.color_description}{literal} /* other color*/
    }

    .crm-wci-button {
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

    .crm-home-url {
        text-decoration:none;
        border:0px;
        color:{/literal}{$wciform.color_homepage_link}{literal} /* home page link color*/
    }

    a.crm-wci-button { /* button color */
        background-color:{/literal}{$wciform.color_button_bg}{literal};
    }

    .crm-wci-button-inner { /* button text color */
        padding:2px;
        display:block;
        color:{/literal}{$wciform.color_button}{literal};
    }
    #crm_wci_image_container {
      text-align: center;
      padding: 10px 20px;
    }
    .thin #crm_wci_image {
      width: 100px;
    }
    .normal #crm_wci_image {
      width: 150px;
    }
    .wide #crm_wci_image {
      width: 200px;
    }
    #newsletter_msg, #newsletter_mail, #newsletter_submit {
      text-align: center;
      margin: 0 auto;
    }
</style>

<style>
{/literal}
  {$wciform.style_rules}
{literal}
</style>
{/literal}
<div id="crm_wid_{$wciform.widgetId}" class="crm-wci-widget {$wciform.size_variant}">
  {if $wciform.title && (false == $wciform.hide_title)}
    <h5 id="crm_wid_{$wciform.widgetId}_title">
      {if $wciform.logo_image}
        <span class="crm-logo">
          <img src="{$wciform.logo_image}" alt={ts}Logo{/ts}>
        </span>
      {/if}
      {$wciform.title}
    </h5>
  {/if}
    {if $wciform.image}
      <div id="crm_wci_image_container">
        <img id="crm_wci_image" src='{$wciform.image}'/>
      </div>
    {/if}
    {if (false == $wciform.hide_pbcap)}
    <div class="crm-amounts">
        <div id="crm_wid_{$wciform.widgetId}_amt_hi" class="crm-amount-high">${$wciform.goal_amount}</div>
        <div id="crm_wid_{$wciform.widgetId}_amt_low" class="crm-amount-low">${$wciform.starting_amount}</div>
        <div id="crm_wid_{$wciform.widgetId}_percentage" class="crm-percentage">{$wciform.pb_percentage}%</div>
    </div>
    {/if}
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
    {if $wciform.button_title}
    <div class="crm-wci-button-wrapper" id="crm_wid_{$wciform.widgetId}_button">
        <a href='{crmURL p="civicrm/contribute/transact" q="reset=1&id=$cpageId" h=0 a=1 fe=1}' class="crm-wci-button"><span class="crm-wci-button-inner" id="crm_wid_{$wciform.widgetId}_btn_txt">{$wciform.button_title}</span></a>
    </div>
    {/if}
    {if $wciform.email_signup_group_id}
      {if $embed eq 1 }
        <form action="{$wciform.emailSignupGroupFormURL}" method="post">
      {/if}
        <p id="newsletter_msg">
          Get the monthly newsletter
        </p>
        <p id="newsletter_mail">
          <input id="frmEmail" type="text" name="email-Primary" size="18" maxlength="80" placeholder="email address">
        </p>
        <p id="newsletter_submit">
          {if $embed eq 1 }
            <input type="submit" name="_qf_Edit_next" value="Subscribe me">
          {else}
            <input type="button" name="_qf_Edit_next" value="Subscribe me">
          {/if}
        </p>
        <div>
          <input name="postURL" type="hidden" value="">
          <input type="hidden" name="group[{$wciform.email_signup_group_id}]" value="1">
          <input name="_qf_default" type="hidden" value="Edit:cancel">
        </div>
      {if $embed eq 1 }
        </form>
      {/if}
    {/if}
</div>
