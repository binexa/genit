     <!-- {php}echo __FILE__;{/php} -->
        <Element Name="btn_select" 
                 Class="Button" Text="Select" 
                 CssClass="button_gray_m">
            <EventHandler Name="btn_select_onclick" 
                          Event="onclick" 
                          Function="PickToParent()"/>
        </Element>
        <Element Name="btn_close" 
                 Class="Button" 
                 Text="Close" 
                 CssClass="button_gray_m">
            <EventHandler Name="onclick" 
                          Event="onclick" 
                          Function="js:Openbiz.Window.closeDialog()"/>
        </Element>
