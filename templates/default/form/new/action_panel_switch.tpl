        <Element Name="btn_save" Class="Button" Text="Save" CssClass="button_gray_m">
            <EventHandler Name="save_onclick" 
                          Event="onclick" 
                          EventLogMsg=""  
                          Function="InsertRecord()" 
                          RedirectPage="form={$form_package}.{$list_form}" 
                          ShortcutKey="Ctrl+Enter" 
                          ContextMenu="Save" />
        </Element>
        <Element Name="btn_cancel" Class="Button" Text="Cancel" CssClass="button_gray_m">
            <EventHandler Name="btn_cancel_onclick" 
                          Event="onclick" 
                          Function="SwitchForm()"  
                          ShortcutKey="Escape" 
                          ContextMenu="Cancel" />
        </Element>