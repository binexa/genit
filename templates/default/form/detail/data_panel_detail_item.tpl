{foreach from=$detail_fields item=fld}
        {php}
            $field = $this->_tpl_vars['fld'];
            if ( substr($field['name'], -4)=='logo' || $field['element']=="ImageUploader" ) {
                $is_image = true;
            } else {
                $is_image = false;
            }
            $this->assign('is_image', $is_image);
        
            if ( substr($field['name'], -5)=='color' || $field['element']=="ColorPicker" ) {
                $is_color = true;
            } else {
                $is_color = false;
            }
            $this->assign('is_color', $is_color);
        
        {/php}
    {if $fld.name == 'create_by'}
    {elseif $fld.name == 'create_time'}
    {elseif $fld.name == 'create_host'}
    {elseif $fld.name == 'update_by'}
    {elseif $fld.name == 'update_time'}
    {elseif $fld.name == 'update_host'}    
    {elseif $fld.name == 'is_checked'}
    {elseif $fld.name == 'check_by'}
    {elseif $fld.name == 'check_time'}
    {elseif $fld.name == 'is_approved'}
    {elseif $fld.name == 'approve_by'}
    {elseif $fld.name == 'approve_time'}
    {elseif $fld.name == 'external_attachment'}   
    {elseif $fld.name == 'external_picture'}
    {elseif $fld.name == 'external_changelog'}
    {elseif $is_color}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="ColorPicker"
                 Mode="viewOnly"           
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
    {elseif $is_image}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="LabelImage" 
                 UrlPrefix="{literal}{APP_URL}{/literal}"
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
                 
    {elseif $fld.name == 'Id' }
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Hidden="{if $id_identity}Y{else}N{/if}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>    
    {else}
        {if $fld.element == 'Checkbox'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelBool" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        {elseif $fld.element == 'Listbox'}        
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelList"  SelectFrom="{$fld.lov}" FieldName="{$fld.name}" Label="{$fld.label}"  AllowURLParam="N" />
        {elseif $fld.element == 'RichText'}
		<Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelTextarea"  width="640" height="300" FieldName="{$fld.name}" Label="{$fld.label}" {if $fld.default }DefaultValue="{$fld.default}"{/if}  />
        {elseif $fld.element == 'Textarea'}
   		<Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelTextarea" width="640" FieldName="{$fld.name}" Label="{$fld.label}" />
        
        {else}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        {/if}
    {/if}
{/foreach}