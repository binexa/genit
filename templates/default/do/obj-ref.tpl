{foreach from=$fields item=fld}
{if $fld.name=='external_attachment'}
        <Object Name="attachment.do.AttachmentDO"
                Description="Reference to Attachment Records"
                Relationship="1-M"
                Table="attachment"
                CondColumn="type"
                CondValue="{$table_name}"
                Column="foreign_id"
                FieldRef="Id"
                onDelete="Cascade" />
{elseif $fld.name=='external_picture'}
        <Object Name="picture.do.PictureDO"
                Description="Reference to Picture Records"
                Relationship="1-M"
                Table="picture"
                CondColumn="type"
                CondValue="{$table_name}"
                Column="foreign_id"
                FieldRef="Id"
                onDelete="Cascade" />
{elseif $fld.name=='external_changelog'}
    	<Object Name="changelog.do.ChangeLogDO"
                Description=""
                Relationship="1-M"
                Table="changelog"
                CondColumn='type'
                CondValue='{$table_name}'
                Column="foreign_id"
                FieldRef="Id" 
                onDelete="Cascade" />
{else}
{/if}
{/foreach}
        
{foreach from=$refDO  item=refItem}
        <Object Name="{$refItem.name}"
{foreach from=$refItem key=itemKey item=itemValue}
{if !($itemKey=='name' || $itemKey=='Name' || $itemKey=='NAME') }
                {$itemKey|capitalize}="{$itemValue}"
{/if}
{/foreach}
                onDelete="Cascade" />
{/foreach}