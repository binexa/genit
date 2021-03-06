<!-- {php}echo __FILE__;{/php} -->
{assign var=col_counter value=0}  
{assign var=has_default value=false}
{foreach from=$fields item=fld}
{if $fld.name == 'Id' || $fld.onList == true}
        {php}
            $field = $this->_tpl_vars['fld'];
            if ( substr($field['name'], -4)=='logo' ) {
                $is_image = true;
            } else {
                $is_image = false;
            }
            $this->assign('is_image', $is_image);
        
            if ( substr($field['name'], -5)=='color' || $field['element']=="ColorPicker" ) {
                $is_color = true;
            } else {
                $is_color = false;
            }
            $this->assign('is_color', $is_color);
        
        {/php}    
        
{if $fld.name == 'is_default'}
        {assign var=has_default value=true}
{/if}          
        
{if $fld.name == 'Id'}
        <Element Name="row_selections" Class="RowCheckbox"  Label="" FieldName="{$fld.name}"/>
        <Element Name="fld_{$fld.name}" Class="common.element.ColumnTitle" Hidden="N" FieldName="{$fld.name}" Label="{$fld.label}" Sortable="Y" AllowURLParam="N" Link="javascript:">         
         	<EventHandler Name="fld_{$fld.name}_onclick" 
                          Event="onclick" 
                          Function="js:Openbiz.Net.loadPage('{literal}{@home:url}{/literal}/{$module}/{$detailview_uri}/Id_{literal}{@:Elem[fld_Id].Value}{/literal}')" />
                
        </Element>
{elseif $fld.element == 'Listbox'}
        <Element Name="fld_{$fld.name}" 
                 Class="ColumnList"  
                 SelectFrom="{$fld.lov}" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"  AllowURLParam="N" 
                 {if $col_counter==1}Link="javascript:"{/if}
                 >
                 {if $col_counter==1}
         		<EventHandler Name="fld_{$fld.name}_onclick"
                              Event="onclick" 
                              Function="js:Openbiz.Net.loadPage('{literal}{@home:url}{/literal}/{$module}/{$detailview_uri}/Id_{literal}{@:Elem[fld_Id].Value}{/literal}')"
                            />
                 {/if}
        </Element>    
        
{elseif $fld.name == 'sort_order' || $fld.name == 'priority'}
        <Element Name="fld_{$fld.name}" 
                 Class="ColumnSorting" 
                 FieldName="{$fld.name}" 
                 Label="{if $fld.name == 'sort_order'}Ordering{else}{$fld.label}{/if}"  
                 Sortable="Y" 
                 AllowURLParam="N" 
                 Translatable="N" 
                 OnEventLog="N" >
        	<EventHandler Name="fld_sortorder_up" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="decreaseSortOrder({literal}{@:Elem[fld_Id].Value}{/literal},{$fld.name})" />
        	<EventHandler Name="fld_sortorder_down" 
                          Event="onclick" 
                          EventLogMsg="" 
                          Function="increaseSortOrder({literal}{@:Elem[fld_Id].Value}{/literal},{$fld.name})" />           
        </Element>  
{elseif $is_color}
        <Element Name="fld_{$fld.name}" 
                 {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if}
                 ElementSet="{$fld.elementSet}" 
                 Class="ColorPicker"
                 Mode="viewOnly"           
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}" 
                 {if $fld.hidden }Hidden="Y"{/if}
                 AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>              	
{elseif $fld.name == 'is_checked' || $fld.name == 'is_approved' }
        <Element Name="fld_{$fld.name}" Class="ColumnBool" FieldName="{$fld.name}" Label="{$fld.label}" {if $fld.default }DefaultValue="{$fld.default}"{/if} Sortable="Y"/>
        
{elseif $is_image }   
{elseif $fld.element == 'RichText'}     
{elseif $fld.raw_type!='timestamp' 
    && $fld.name != 'create_by' 
    && $fld.name != 'create_time' 
    && $fld.name != 'create_host' 
    && $fld.name != 'update_by' 
    && $fld.name != 'update_time' 
    && $fld.name != 'update_host' 
    && $fld.name != 'check_by' 
    && $fld.name != 'check_time' 
    && $fld.name != 'approve_by' 
    && $fld.name != 'approve_time' 
    &&  $fld.name != 'external_attachment' 
    && $fld.name != 'external_picture' }
    {if $col_counter==1}        
        <Element Name="fld_{$fld.name}" {if $fld.tabSet}TabSet="{$fld.tabSet}"{/if} ElementSet="{$fld.elementSet}" Class="LabelBool" FieldName="{$fld.name}" Label="{$fld.label}" AllowURLParam="{if $fld.name eq 'Id'}Y{else}N{/if}"/>
        <Element Name="fld_{$fld.name}" 
                 Class="ColumnText" 
                 FieldName="{$fld.name}" 
                 Label="{$fld.label}"
                 {if $fld.hidden }Hidden="Y"{/if} 
                 {if $fld.default }DefaultValue="{$fld.default}"{/if} 
                 Sortable="Y" 
                 Link="javascript:"
                >
         		<EventHandler Name="fld_{$fld.name}_onclick"
                                      Event="onclick" 
                                      Function="js:Openbiz.Net.loadPage('{literal}{@home:url}{/literal}/{$module}/{$detailview_uri}/Id_{literal}{@:Elem[fld_Id].Value}{/literal}')" 
                                    />
        </Element>
    {else}
        {if $fld.element == 'Checkbox'}
            <Element Name="fld_{$fld.name}" Class="ColumnBool" FieldName="{$fld.name}" Label="{$fld.label}" {if $fld.default }DefaultValue="{$fld.default}"{/if} Sortable="Y"/>
        {else}
            <Element Name="fld_{$fld.name}" Class="ColumnText" FieldName="{$fld.name}" Label="{$fld.label}" {if $fld.default }DefaultValue="{$fld.default}"{/if} Sortable="Y"/>
        {/if}
    {/if}
    
{/if}
{assign var=col_counter value=$col_counter+1}
{/if}
{/foreach}