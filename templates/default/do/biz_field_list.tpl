{foreach from=$fields item=fld}
{if $fld.name=='timestamp'}
        <BizField Name="timestamp" Column="timestamp" />
{elseif $fld.name=='create_by'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}"/>
{elseif $fld.name=='create_time'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{elseif $fld.name=='create_host'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Text" {if $fld.length }Length="{$fld.length}"{/if} ValueOnCreate="{literal}{@service.serverVariablesService:REMOTE_ADDR}{/literal}" />
{elseif $fld.name=='update_by'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}" ValueOnUpdate="{literal}{@profile:Id}{/literal}"/>
{elseif $fld.name=='update_time'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}" ValueOnUpdate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{elseif $fld.name=='update_host'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Text" {if $fld.length }Length="{$fld.length}"{/if} ValueOnCreate="{literal}{@service.serverVariablesService:REMOTE_ADDR}{/literal}" ValueOnUpdate="{literal}{@service.serverVariablesService:REMOTE_ADDR}{/literal}" />
{elseif $fld.name=='color'}
        <BizField Name="{$fld.name}" Column="{$fld.col}" Type="Text" {if $fld.length }Length="{$fld.length}"{/if} Required="{if $fld.nullable }N{else}Y{/if}" {if $fld.join}Join="{$fld.join}"{/if}/>
{elseif $fld.name=='external_attachment'}
{elseif $fld.name=='external_picture'}
{elseif $fld.name=='external_changelog'}
{else}
        <BizField Name="{$fld.name}"
{if $fld.col}                  Column="{$fld.col}"{/if}
                  Type="{$fld.type}" 
{if $fld.length }                  Length="{$fld.length}"{/if}
{if $fld.name != "Id"}                  Required="{if $fld.join || $fld.sqlExpr}N{else}{if $fld.nullable }N{else}Y{/if}{/if}"{/if}
{if $fld.format }                  Format="{$fld.format}"{/if}
{if $fld.sqlExpr}                  SQLExpr="{$fld.sqlExpr}"{/if}
{if $fld.join}                  Join="{$fld.join}"{/if} />
{/if}
{/foreach}