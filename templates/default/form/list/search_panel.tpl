<!-- search panel -->
{assign var=search_count value=0}
{foreach from=$fields item=fld}
    {php}
        $field = $this->_tpl_vars['fld'];
        $elementClass = str_replace('Label','Input',$field['element']);
        $field['element'] = $elementClass;
        $this->assign('fld', $field);
    {/php}
    {assign var=$fld.element value=str_replace('Label','Input',$fld.element) }
{if $fld.onSearch == true}

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
                 {if $fld.default }DefaultValue="{$fld.default}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if}
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
                 {if $fld.default }DefaultValue="{$fld.default}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if}
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
                 {if $fld.default }DefaultValue="{$fld.default}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if}  >
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
                 {if $fld.default }DefaultValue="{$fld.default}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if} >
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
                 {if $fld.default }DefaultValue="{$fld.default}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if}  >
    {elseif $fld.element == 'Textarea'}
        <Element Name="fld_{$fld.name}"
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}"
                 Class="{$fld.element}"
                 Width="630"
                 FieldName="{$fld.name}"
                 Label="{$fld.label}"
                 {if $fld.description }Description="{$fld.description}"{/if} >
    {elseif $fld.element == 'Listbox'}
        <Element Name="fld_{$fld.name}"
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 ElementSet="{$fld.elementSet}"
                 Class="Listbox"
                 SelectFrom="{$fld.lov}"
                 BlankOption="...Silahkan Pilih..."
                 FieldName="{$fld.name}"
                 Label="{$fld.label}"
                 AllowURLParam="N"
                 {if $fld.description }Description="{$fld.description}"{/if} >

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
                 AllowURLParam="N"
                 {if $fld.description }Description="{$fld.description}"{/if} >

    {elseif $fld.element == 'LabelText'}
        <Element Name="fld_{$fld.name}"
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}"
                 Class="LabelText"
                 FieldName="{$fld.name}"
                 Label="{$fld.label}"
                 AllowURLParam="N"
                 {if $fld.cssClass}CssClass="{$fld.cssClass}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if} >
    {else}
		<Element Name="fld_{$fld.name}"
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 {if $fld.enabled}Enabled="{$fld.enabled}"{/if}
                 {if $fld.hidden }Hidden="Y"{/if}
                 ElementSet="{$fld.elementSet}"
                 Class="{$fld.element}"
                 FieldName="{$fld.name}"
                 Label="{$fld.label}"
                 {if $fld.cssClass}CssClass="{$fld.cssClass}"{/if}
                 {if $fld.description }Description="{$fld.description}"{/if}  >
    {/if}
        </Element>
{assign var=search_count value=$search_count+1}
{/if}
{/foreach}
 
{if $search_count>0}
    
        <Element Name="btn_dosearch" 
                 Class="Button" 
                 Text="Search" 
                 CssClass="button_gray_l">
            <EventHandler Name="search_onclick" 
                          Event="onclick" 
                          Function="RunSearch()" 
                          ShortcutKey="Enter"/>
        </Element>	
{/if}