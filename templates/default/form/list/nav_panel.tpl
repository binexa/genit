{literal}
        <!-- default/list/nav_panel.tpl -->
    
        <Element Name="txt_total_records" Class="LabelText"   Text="Total Recs : {@:m_TotalRecords}">
        </Element>        
        <Element Name="btn_spacer1" 
                 Class="Spacer" 
                 Text="" >
        </Element>    
    <!--
  	<Element Name="page_selector" Class="PageSelector" Text="{@:m_CurrentPage}" Label="Go to Page" CssClass="input_select" cssFocusClass="input_select_focus">
            <EventHandler Name="btn_page_selector_onchange" Event="onchange" Function="GotoSelectedPage(page_selector)"/>
        </Element>    
    -->
        <Element Name="pagesize_selector" Class="PagesizeSelector" Text="{@:m_Range}" Label="Show Rows" CssClass="input_select" cssFocusClass="input_select_focus">
            <EventHandler Name="btn_pagesize_selector_onchange" Event="onchange" Function="SetPageSize(pagesize_selector)"/>
        </Element>      
        <Element Name="btn_first" Class="Button" Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" Text="" CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'first_gray':'first'}">
            <EventHandler Name="first_onclick" Event="onclick" Function="GotoPage(1)"/>
        </Element>
        <Element Name="btn_prev" Class="Button" Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" Text="" CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'prev_gray':'prev'}">
            <EventHandler Name="prev_onclick" Event="onclick" Function="GotoPage({@:m_CurrentPage - 1})" ShortcutKey="Ctrl+Shift+Left"/>
        </Element>
        <Element Name="txt_page" Class="LabelText" Text="{'@:m_CurrentPage of @:m_TotalPages '}">
        </Element>
        <Element Name="btn_next" Class="Button" Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" Text="" CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'next_gray':'next'}">
            <EventHandler Name="next_onclick" Event="onclick" Function="GotoPage({@:m_CurrentPage + 1})" ShortcutKey="Ctrl+Shift+Right"/>
        </Element>
        <Element Name="btn_last" Class="Button" Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" Text="" CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'last_gray':'last'}">
            <EventHandler Name="last_onclick" Event="onclick" Function="GotoPage({@:m_TotalPages})"/>
        </Element>
{/literal}