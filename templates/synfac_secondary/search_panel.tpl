<!-- search panel -->
{assign var=search_count value=0}
{foreach from=$fields item=fld}
{$fld.name}.{$fld.element}
{if $fld.onSearch == true}
		<Element Name="qry_{$fld.name}"
                 Class="{$fld.element}"
                 FuzzySearch="Y"
                 FieldName="{$fld.name}"
                 Label="{$fld.label}" />
{assign var=search_count value=$search_count+1}
{/if}
{/foreach}
{if $search_count>0}
        <Element Name="btn_dosearch" 
                 Class="Button" 
                 Text="Search" 
                 CssClass="button_gray_l">
            <EventHandler Name="search_onclick" 
                          Event="onclick" 
                          Function="RunSearch()" 
                          ShortcutKey="Enter"/>
        </Element>	
{/if}