    <!-- {php}echo __FILE__;{/php} -->
        <Element Name="lnk_new" Class="Button" Text="Add" CssClass="button_gray_m" Description="new record (Insert)" Access="{$acl.create}">
            <EventHandler Name="lnk_new_onclick" 
                          Event="onclick" 
                          EventLogMsg=""                           
                          Function="LoadDialog({$form_package}.{$new_form})"  
                          ShortcutKey="Insert" 
                          ContextMenu="New"/>
        </Element>
        <Element Name="btn_edit" Class="Button" Text="Edit" CssClass="button_gray_m" Description="edit record (Ctrl+E)" Access="{$acl.update}">
            <EventHandler Name="btn_edit_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="LoadDialog({$form_package}.{$edit_form},,1)"/>
                          ShortcutKey="Ctrl+E" 
                          ContextMenu="Edit" />
        </Element>
        <Element Name="btn_delete" Class="Button" Text="Delete" CssClass="button_gray_m" Access="{$acl.delete}">
            <EventHandler Name="del_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="DeleteRecord()" 
                          ShortcutKey="Ctrl+Delete" 
                          ContextMenu="Delete"/>
        </Element>
        <Element Name="btn_excel" Class="Button" Text="Export" CssClass="button_gray_m">
            <EventHandler Name="exc_onclick" 
                          Event="onclick" EventLogMsg="" 
                          Function="CallService(excelService,renderCSV)" 
                          FunctionType="Popup" 
                          ShortcutKey="Ctrl+Shift+X" 
                          ContextMenu="Export"/>
        </Element>
