{literal}
<style>
    .crm-wci-pb hr {
      align:center;
      display: block; height: 1px;
      border: 0; border-top: 1px;
      margin: 1em 0; padding: 0;
    }
</style>
{/literal}
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
