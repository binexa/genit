{foreach from=$joins key=joinName item=joinItem}
        <Join Name="{$joinItem.name}"
              Table ="{$joinItem.tableName}"
              Column="{$joinItem.column}"
              ColumnRef="{$joinItem.columnRef}"
{if $joinItem.joinRef}              JoinRef="{$joinItem.joinRef}"{/if}
              JoinType="{$joinItem.type}"/>
{/foreach}