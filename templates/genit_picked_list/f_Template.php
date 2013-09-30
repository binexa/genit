{literal}<?php 
class {/literal}{$class_general_form}{literal} extends EasyForm
{
 
{literal}    
	public function SetDefault($link_id=null) {
		if ($link_id==null)
		{
			$link_id = (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}
{/literal}        
        // parentForm
		$parent_id = (int)BizSystem::objectFactory()->getObject({$parent_form})->m_RecordId;
		
        // linkDO
		$linkDo = BizSystem::getObject("{$link_do},1);
		$linkDo->updateRecords("[is_default]=0","[{$parent_field_id}]='$parent_id'");
		$linkDo->updateRecords("[is_default]=1","[{$parent_field_id}]='$parent_id' and [role_id]='$role_id'");
		
		$this->m_RecordId = $link_id;
		$this->UpdateForm();
	}    
}
?>
{/literal}