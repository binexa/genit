<!-- default/form/new/data_panel.tpl  -->

{foreach from=$edit_fields item=fld}
        ELEMENT : {$fld.name} . {$fld.element}
        ENABLED : {$fld.enabled}
        
        {php}
            $field = $this->_tpl_vars['fld'];
            if ( substr($field['name'], -4)=='logo' || $field['element']=="ImageUploader" ) {
                $is_image = true;
            } else {
                $is_image = false;
            }
            $this->assign('is_image', $is_image)
        {/php}
                
{if ( $fld.name != 'Id' || $fld.name == 'Id' && $id_identity==false ) && $fld.raw_type!='timestamp' && $fld.name != 'create_by' && $fld.name != 'create_time' && $fld.name != 'create_host' && $fld.name != 'update_by' && $fld.name != 'update_time' && $fld.name != 'update_host' && $fld.name != 'is_checked' && $fld.name != 'check_by' && $fld.name != 'check_time' && $fld.name != 'is_approved' && $fld.name != 'approve_by' && $fld.name != 'approve_time' && $fld.name != 'external_attachment' && $fld.name != 'external_picture' && $fld.name != 'external_changelog'}
	{if $fld.element == 'InputDate'}
		<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="{$fld.element}" 
                 DateFormat="%Y-%m-%d" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"
                 {if $fld.hidden }Hidden="Y"{/if} 
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if} 
                 CssClass="input_text" >
	{elseif $fld.element == 'InputDatetime'}
		<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="{$fld.element}" 
                 DateFormat="%Y-%m-%d %H:%M:%S" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if} 
                 CssClass="input_text" >
    {elseif $fld.element == 'RichText'}
		<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}"
                 Class="CKEditor"  
                 Mode="adv"  
                 Config="resize_maxWidth:640,resize_minWidth:640,resize_minHeight:300" 
                 Width="640" 
                 Height="300" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if} >
    {elseif $fld.element == 'Checkbox'}
		<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}"  
                 Class="{$fld.element}" 
                 SelectFrom="1" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if} >    
    {elseif $fld.element == 'Radio'}
		<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="{$fld.element}" 
                 SelectFrom="{$fld.options}"  
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if} >
    {elseif $fld.element == 'Textarea'}
    	<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="{$fld.element}" 
                 Width="640" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"  
                 AllowURLParam="N" >
    {elseif $fld.element == 'Listbox'}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="Listbox"  
                 BlankOption="...Silahkan Pilih..."
                 SelectFrom="{$fld.lov}" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"  
                 AllowURLParam="N" >
    {elseif $fld.element == 'InputPicker'}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="{$fld.element}"  
                 FieldName="{$fld.name}" 
                 ValuePicker="{$fld.valuePicker}"                  
                 PickerMap="{$fld.pickerMap}"
                 Label="{$fld.label}"  
                 AllowURLParam="N" >
    {elseif $fld.element == 'AutoSuggest'}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="AutoSuggest"  
                 SelectFrom="{$fld.lov}" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"  
                 AllowURLParam="N" >
    {elseif $fld.name =='sort_order'}
    	<Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="Listbox"  
                 SelectFrom="common.lov.CommLOV(Order)" 
                 DefaultValue="50" 
                 FieldName="{$fld.name}" 
                 Label="Ordering"  
                 AllowURLParam="N" >
    {elseif $is_image }
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="ImageUploader" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"                  
                 AllowURLParam="N" >    
    {else}
        <!--  Others Element -->
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" 
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 Class="{$fld.element}" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"
                 {if $fld.hidden }Hidden="Y"{/if}
                 {if $fld.lov}SelectFrom="{$fld.lov}"{/if}
                 {if $fld.default !='' }DefaultValue="{$fld.default}"{/if}  
                 AllowURLParam="N" >
    {/if}

{foreach from=$fld.event item=eventItem}
             <EventHandler Name="{$fld.name}_{$eventItem.event}"
                           Event="{$eventItem.event}"
                           Function="{$eventItem.function}" />
{/foreach}
        </Element>
        
{else}
{/if}
{/foreach}