      {if $has_add_form }
        <Element Name="btn_new"
                 Class="Button" 
                 Text="Add" 
                 CssClass="button_gray_add" 
                 Description="new record (Insert)">
			<EventHandler Name="btn_new_onclick" 
                          Event="onclick" 
                          Function="SwitchForm({$form_package}.{$new_form})"  
                          ShortcutKey="Insert" 
                          ContextMenu="New" />
        </Element>
      {/if}
      {if $has_edit_form }
        <Element Name="btn_edit" 
                 Class="Button" 
                 Text="Edit" 
                 CssClass="button_gray_m" 
                 Description="edit record (Ctrl+E)">
			<EventHandler Name="btn_new_onclick" 
                          Event="onclick" 
                          Function="SwitchForm({$form_package}.{$edit_form},{literal}{@:Elem[fld_Id].Value}{/literal})"  
                          ShortcutKey="Ctrl+E" 
                          ContextMenu="Edit" />
        </Element>
      {/if}
      {if $has_delete_form }
        <Element Name="btn_delete" 
                 Class="Button" 
                 Text="Delete" 
                 CssClass="button_gray_m" 
                 Description="delete record (Delete)">
            <EventHandler Name="del_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="DeleteRecord({literal}{@:Elem[fld_Id].Value}{/literal})"  
                          RedirectPage="form={$form_package}.{$list_form}" 
                          ShortcutKey="Ctrl+Delete" 
                          ContextMenu="Delete" />
        </Element>
      {/if}
        <Element Name="btn_cancel" 
                 Class="Button" 
                 Text="List" 
                 CssClass="button_gray_m">
            <EventHandler Name="btn_cancel_onclick" 
                          Event="onclick" 
                          Function="SwitchForm()"  
                          ShortcutKey="Escape" 
                          ContextMenu="Back" />
        </Element>