{foreach from=$fields item=fld}
        {php}
            $field = $this->_tpl_vars['fld'];
            if ( substr($field['name'], -4)=='logo' || $field['element']=="ImageUploader" ) {
                $is_image = true;
            } else {
                $is_image = false;
            }
            $this->assign('is_image', $is_image)
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

        <Element Name="fld_related_attachment" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 Access="attachment.access"  
                 ElementSet="Attachment" 
                 Class="FormElement" 
                 FormReference="attachment.widget.AttachmentListEditForm" 
                 FieldName="" 
                 Label="" 
                 AllowURLParam="N" />
        
        <Element Name="btn_manage_attachment" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} 
                 Access="attachment.access" 
                 Hidden="{literal}{@:m_CanUpdateRecord=='1'?'N':'Y'}{/literal}" 
                 ElementSet="Attachment" 
                 Style="color:#666666;margin-left:5px;margin-top:2px;" 
                 Class="Button" 
                 Text="Close" 
                 CssClass="button_gray_w" 
                 Description="">
                 <EventHandler Name="btn_manage_attachment_onclick" 
                               Event="onclick" 
                               Function="SwitchForm({$package}.form.{$base_object_name}DetailForm,{literal}{@:Elem[fld_Id].Value}{/literal})"/>
        </Element>
 
{elseif $fld.name == 'external_picture'}
{elseif $is_image }
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
        
        {else}
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelText" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        {/if}

{/if}
{/foreach}
