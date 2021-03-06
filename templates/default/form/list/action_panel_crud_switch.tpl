    <!-- {php}echo __FILE__;{/php} -->
    {if $has_add_form }
        <Element Name="btn_new" 
                 Class="Button"
                 Text="Add" 
                 CssClass="button_gray_m" 
                 Description="new record (Insert)" 
                 Access="{$acl.create}">
            <EventHandler Name="lnk_new_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="SwitchForm({$form_package}.{$new_form})"  
                          ShortcutKey="Insert" 
                          ContextMenu="New"/>
        </Element>
     {/if}
     
     {if $has_edit_form }
        <Element Name="btn_edit" 
                 Class="Button" Text="Edit" 
                 CssClass="button_gray_m" 
                 Description="edit record (Ctrl+E)" 
                 Access="{$acl.edit}">
            <EventHandler Name="btn_edit_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="EditRecord()" 
                          RedirectPage="form={$form_package}.{$edit_form}&amp;fld:Id={literal}{@:Elem[fld_Id].Value}{/literal}" 
                          ShortcutKey="Ctrl+E" 
                          ContextMenu="Edit" />
        </Element>
     {/if}
     
     {if $has_delete_form }
        <Element Name="btn_delete" 
                 Class="Button" 
                 Text="Delete" 
                 CssClass="button_gray_m" 
                 Access="{$acl.delete}">
            <EventHandler Name="del_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="DeleteRecord()" 
                          ShortcutKey="Ctrl+Delete" 
                          ContextMenu="Delete"/>
        </Element>
     {/if}

    {assign var=has_default value=false}
    {foreach from=$fields item=fld}
        {if $fld.name == 'is_default'}
            {assign var=has_default value=true}
        {/if}
    {/foreach}

    {if $has_default==true}
        <Element Name="btn_default" 
                 Class="Button" 
                 Text="Set Default" 
                 CssClass="button_gray_w" >
            <EventHandler Name="default_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="SetDefault()" />
        </Element>	
    {/if}
      
      {if $has_export_button }
        <Element Name="btn_excel" Class="Button" Text="Export" CssClass="button_gray_m">
            <EventHandler Name="exc_onclick" 
                          Event="onclick" EventLogMsg="" 
                          Function="CallService(excelService,renderCSV)" 
                          FunctionType="Popup" 
                          ShortcutKey="Ctrl+Shift+X" 
                          ContextMenu="Export"/>
        </Element>
       {/if}
       
    <!-- {php}echo __FILE__;{/php} -->
        {if $has_detail_item_form }
        <Element Name="btn_spacer0" Class="Spacer" Text="" >
        </Element>

        <Element Name="btn_detail_item" 
                 Class="Button" 
                 Text="Detail Item" 
                 CssClass="button_gray_l" >
            <EventHandler Name="btn_detail_item_onclick" 
                          Event="onclick"
                          EventLogMsg=""
                          Function="EditRecord()"
                          RedirectPage="{literal}{@home:url}{/literal}/{$module}/{$detailitemview_uri}/{literal}{@:Elem[fld_Id].Value}{/literal}"
                          ShortcutKey="Ctrl+L" 
                          ContextMenu="Default List"/>
        </Element>
       {/if}   