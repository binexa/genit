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
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>
    {elseif $fld.name == 'create_time'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/> 
    {elseif $fld.name == 'create_host'}
        <Element Name="fld_create_host" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/>    
    {elseif $fld.name == 'update_by'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>       	
    {elseif $fld.name == 'update_time'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/>
    {elseif $fld.name == 'update_host'}    
        <Element Name="fld_update_host" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/>

    {elseif $fld.name == 'is_checked'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelBool" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>
    {elseif $fld.name == 'check_by'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>       	
    {elseif $fld.name == 'check_time'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}{if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/>

    {elseif $fld.name == 'is_approved'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelBool" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>
    {elseif $fld.name == 'approve_by'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" Text="{literal}{{/literal}BizSystem::GetProfileName(@:Elem[fld_{$fld.name}].Value){literal}}{/literal}" AllowURLParam="N"/>       	
    {elseif $fld.name == 'approve_time'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="N"/>

    {elseif $fld.name == 'external_attachment'}   
        <Element Name="fld_related_attachment" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 Access="attachment.access" 
                 ElementSet="Attachment" 
                 Class="FormElement" 
                 FormReference="attachment.widget.AttachmentListDetailForm" 
                 FieldName="" 
                 Label="" 
                 AllowURLParam="N"/>
        <Element Name="btn_manage_attachment" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 Access="attachment.access" 
                 Hidden="{literal}{@:m_CanUpdateRecord=='1'?'N':'Y'}{/literal}" 
                 ElementSet="Attachment" 
                 Style="color:#666666;margin-left:5px;margin-top:2px;" 
                 Class="Button" 
                 Text="Manage" 
                 CssClass="button_gray_w" 
                 Description="">
            <EventHandler Name="btn_manage_attachment_onclick" 
                          Event="onclick" 
                          Function="SwitchForm({$package}.form.{$base_object_name}EditAttachmentForm,{literal}{@:Elem[fld_Id].Value}{/literal})"/>
        </Element>
 
    {elseif $fld.name == 'external_picture'}
        <Element Name="fld_related_picture" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 Access="picture.access" 
                 ElementSet="Picture" 
                 Class="FormElement" 
                 FormReference="picture.widget.PictureListDetailForm" 
                 FieldName="" 
                 Label="" 
                 AllowURLParam="N"/>
        <Element Name="btn_manage_picture" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 Access="picture.access" 
                 Hidden="{literal}{@:m_CanUpdateRecord=='1'?'N':'Y'}{/literal}" 
                 ElementSet="Picture" 
                 Style="color:#666666;margin-left:5px;margin-top:2px;" 
                 Class="Button" 
                 Text="Manage" 
                 CssClass="button_gray_w" 
                 Description="">
                <EventHandler Name="btn_manage_picture_onclick" 
                          Event="onclick" 
                          Function="SwitchForm({$package}.form.{$base_object_name}EditPictureForm,{literal}{@:Elem[fld_Id].Value}{/literal})"/>
                </Element>    
    {elseif $fld.name == 'external_changelog'}
         		<Element Name="fld_changelog" 
                     {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                     Access="changelog.access"  
                     ElementSet="ChangeLog" 
                     Class="FormElement" 
                     FormReference="changelog.widget.ChangeLogWidgetForm" 
                     FieldName="" 
                     Label="" 
                     AllowURLParam="N" />    	
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
        {elseif $fld.element == 'Listbox' || $fld.element == 'LabelList' || $fld.element == 'common.lib.TypeSelector'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelList"  SelectFrom="{$fld.lov}" FieldName="{$fld.name}" Label="{$fld.label}"  AllowURLParam="N" />
        {elseif $fld.element == 'common.lib.TypeSelector'}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="common.lib.TypeSelector"  SelectFrom="{$fld.lov}" FieldName="{$fld.name}" Label="{$fld.label}"  AllowURLParam="N" />
        {elseif $fld.element == 'RichText'}
		<Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelTextarea"  width="640" height="300" FieldName="{$fld.name}" Label="{$fld.label}" {if $fld.default }DefaultValue="{$fld.default}"{/if}  />
        {elseif $fld.element == 'Textarea'}
   		<Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelTextarea" width="640" FieldName="{$fld.name}" Label="{$fld.label}" />        
        {elseif $fld.element == 'Hidden'}
   		<Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="Hidden" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        {else}
        <Element Name="fld_{$fld.name}" 
            {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
            ElementSet="{$fld.elementSet}"
            Class="LabelText"
            FieldName="{$fld.name}"
            Label="{$fld.label}"
            AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        {/if}
    {/if}
{/foreach}