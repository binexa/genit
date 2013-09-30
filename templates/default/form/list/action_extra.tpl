<!-- action_extra.tpl -->
{foreach from=$extra_action  item=eaItem}
        <Element Name="{$eaItem.name}"
{assign var=arr_counter value=0}            
{foreach from=$eaItem key=itemKey item=itemValue}
{if !($itemKey=='name' || $itemKey=='Name' || $itemKey=='NAME') }
{if is_array($itemValue) }
                 >
{foreach from=$itemValue key=subItemKey item=subItemValue}
            <EventHandler Name="{$subItemValue.name}"
{foreach from=$subItemValue key=subItemKey2 item=subItemValue2}
{if !($subItemKey2=='name' || $subItemKey2=='Name' || $subItemKey2=='NAME') }
                          {$subItemKey2|capitalize}="{$subItemValue2}"
{/if}
{/foreach}
                          /> 
{/foreach}             
{else}
                {$itemKey|capitalize}="{$itemValue}"
{/if}
{/if}
{/foreach}
                </Element>
{/foreach}       