    <!-- action_panel_check_approve.tpl -->
    {if ($has_check_process==1 && $has_check_button) ||  ($has_approve_process==1 && $has_approve_button)}
        
        <Element Name="btn_spacer1" 
                 Class="Spacer" 
                 Text="" >
        </Element>
        
       {if $has_check_process==1 && $has_check_button}
        <Element Name="btn_check" 
                 Class="Button" 
                 Text="Check Y/N" 
                 CssClass="button_gray_l">
            <EventHandler Name="btn_check_onclick" 
                          Event="onclick"
                          EventLogMsg=""
                          Function="toggleCheckRecord()"
                          ShortcutKey="Ctrl+L" 
                          ContextMenu="Check Y/N" />
        </Element>
       {/if}
       
       {if $has_approve_process==1 && $has_approve_button}
        <Element Name="btn_approve" 
                 Class="Button" 
                 Text="Approve Y/N" 
                 CssClass="button_gray_l">
            <EventHandler Name="btn_approve_onclick" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="toggleApproveRecord()" 
                          ShortcutKey="Ctrl+C" 
                          ContextMenu="Approve Y/N"/>
        </Element>
        {/if}
      {/if}  
