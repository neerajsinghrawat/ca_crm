{literal}
    <script type="text/javascript" src="custom/modules/Leads/js/click_to_call.js"></script>
{/literal}
{capture name=getPhone assign=phone}{sugar_fetch object=$parentFieldArray key=$col}{/capture}
{assign var="phone_value" value=$phone|trim}
{if $phone_value neq ''}
    {* Check if module is Leads - check displayParams.module, $module, or parentFieldArray *}
    {assign var="current_module" value=""}
    {if !empty($displayParams.module)}
        {assign var="current_module" value=$displayParams.module}
    {elseif !empty($module)}
        {assign var="current_module" value=$module}
    {elseif !empty($parentFieldArray.MODULE)}
        {assign var="current_module" value=$parentFieldArray.MODULE}
    {elseif !empty($smarty.request.module)}
        {assign var="current_module" value=$smarty.request.module}
    {/if}
    
    {* Only show Click to Call icon if module is Leads *}
    {if $current_module == 'Leads'}
        <img src="custom/modules/Leads/images/click_to_call_icon.png" onclick="showClickToCallAlert('{$phone_value}','{$parentFieldArray.ID}');" style="cursor: pointer; margin-right: 5px;" title="Click to Call"> 
    {/if}
{/if}
{sugar_phone value=$phone usa_format=$usa_format}