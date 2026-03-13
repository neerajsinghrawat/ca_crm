{literal}
    <script type="text/javascript" src="custom/modules/Leads/js/click_to_call.js"></script>
{/literal}
{if !empty({{sugarvar key='value' string=true}})}
{assign var="phone_value" value={{sugarvar key='value' string=true}} }
{if $phone_value neq ''}
    {* Check if module is Leads - check displayParams.module, $module, or parentFieldArray *}
    {assign var="current_module" value=""}
    {if !empty($displayParams.module)}
        {assign var="current_module" value=$displayParams.module}
    {elseif !empty($module)}
        {assign var="current_module" value=$module}
    {elseif !empty($parentFieldArray.MODULE)}
        {assign var="current_module" value=$parentFieldArray.MODULE}
    {/if}
    
    {* Only show Click to Call icon if module is Leads *}
    {if $current_module == 'Leads'}
        <img src="custom/modules/Leads/images/click_to_call_icon.png" onclick="showClickToCallAlert('{$phone_value}','{$id}');" style="cursor: pointer; margin-right: 5px;" title="Click to Call"> 
    {/if}
{/if}
{sugar_phone value=$phone_value usa_format="{{if !empty($vardef.validate_usa_format)}}1{{else}}0{{/if}}"}
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}}
{{/if}}
{/if}