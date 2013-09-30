     <!-- {php}echo __FILE__;{/php} -->
        <Element Name="lnk_new" Class="Button" Text="Add" CssClass="button_gray_m" Description="new record (Insert)" Access="{$acl.create}">
            <EventHandler Name="lnk_new_onclick" 
                          Event="onclick" 
                          EventLogMsg=""                           
                          Function="LoadDialog({$picker_form})"
                          ShortcutKey="Insert"
                          ContextMenu="New" />
        </Element>
        <Element Name="btn_delete" 
                 Class="Button" 
                 Text="Remove" 
                 CssClass="button_gray_m" 
                 Access="{$acl.delete}">
            <EventHandler Name="del_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="RemoveRecord()" 
                          ShortcutKey="Ctrl+Delete" 
                          ContextMenu="Remove"/>
        </Element>
            --------------
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
