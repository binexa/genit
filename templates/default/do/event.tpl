{foreach from=$eventObservers  item=eventItem}

        <Observer Name="{$eventItem.name}"
{foreach from=$eventItem key=itemKey item=itemValue}
{if !($itemKey=='name' || $itemKey=='Name' || $itemKey=='NAME') }
                {$itemKey|capitalize}="{$itemValue}"
{/if}
{/foreach}
        />
{/foreach}