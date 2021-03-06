<?php
/** 
 * Subak
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2012, CV. KiOSS Project
 * @license   
 * @link      
 * @version   $Id$
 */

include_once MODULE_PATH.'/changelog/form/ChangeLogNoCommentForm.php';

class {$php_general_form} extends ChangeLogForm
{literal}
{

{/literal}    
    public $otherForm;
    public $checkUri="{$listview_uri}";
    public $approveUri="{$listview_uri}";
    public $hasCheckProcess={if $has_check_process==1}true{else}false{/if};
    public $hasApproveProcess={if $has_approve_process==1}true{else}false{/if};
    private $_notificationService = "notification.lib.checkerService";
    
{literal}
    /**
     * Initialize BizForm with xml array
     *
     * @param array $xmlArr
     * @return void
     */
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
        $this->inheritParentObj();
    }

    public function xinsertRecord()
    {
        parent::insertRecord();
        if ($this->hasCheckProcess || $this->hasApproveProcess) {
                //$this->_saveNotification();
        }
    }
    
    private function _saveNotification() {
            if ($this->hasCheckProcess && $this->hasApproveProcess) {
                    $redirectUri = $this->checkUri;
{/literal}
                    $subject = "New {$comp_name} added and need checked and approved!";                
{literal}
            } else {
                if ($this->hasCheckProcess) {
                    $redirectUri = $this->checkUri;
{/literal}
                    $subject = "New {$comp_name} added and need checked!";
{literal}                    
                } else {
                    $redirectUri = $this->approveUri;
{/literal}
                    $subject = "New {$comp_name} added and need approved!";
{literal}
                }                
            }
        
            /* @var $svc checkerService */
            $svc = BizSystem::getService($this->_notificationService);
        
            $pos = strpos($this->m_Name, ".");
            $modul = substr($this->m_Name, 0, $pos);
{/literal}
            $notificationData = array(
                "type" => $this->m_Name,
                "subject" => $subject,
                "message" => 'Please check the new record.',
                "goto_url" => '/' . $modul . '/' . $redirectUri,
                "read_access" => '',
                "update_access" => '',
                "read_state" => 0,
            ); 
{literal}
        $notificationList = array($notificationData);
        $svc->saveNotificationList($notificationList);

    } 
{/literal}    
    
{literal}    
	public function SetDefault($link_id=null) {
		if ($link_id==null)
		{
			$link_id = (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}
{/literal}        
        // parentForm
		$parent_id = (int)BizSystem::objectFactory()->getObject("{$parent_form}")->m_RecordId;
		
        // linkDO
		$linkDo = BizSystem::getObject("{$link_do}",1);
		$linkDo->updateRecords("[is_default]=0","[{$link_do_parent_id}]='$parent_id'");
		$linkDo->updateRecords("[is_default]=1","[{$link_do_parent_id}]='$parent_id' and [{$link_do_child_id}]='$link_id'");
		
		$this->m_RecordId = $link_id;
		$this->UpdateForm();
{literal}
	}   
{/literal}    
    
{literal}
    public function increaseSortOrder($link_id=null)
    {
		if ($link_id==null)
		{
			$link_id = (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}        
{/literal}        
        // parentForm
		$parent_id = (int)BizSystem::objectFactory()->getObject("{$parent_form}")->m_RecordId;		
        // linkDO
		$linkDo = BizSystem::getObject("{$link_do}",1);        
        $linkDo->updateRecords("[sort_order]=[sort_order]+1","[{$link_do_parent_id}]='$parent_id' and [{$link_do_child_id}]='$link_id'");        
		$this->UpdateForm();
{literal}        
    }
{/literal}    
    
{literal}
    public function decreaseSortOrder($link_id=null)
    {
		if ($link_id==null)
		{
			$link_id = (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}        
{/literal}        
        // parentForm
		$parent_id = (int)BizSystem::objectFactory()->getObject("{$parent_form}")->m_RecordId;		
        // linkDO
		$linkDo = BizSystem::getObject("{$link_do}",1);        
        $linkDo->updateRecords("[sort_order]=[sort_order]-1","[{$link_do_parent_id}]='$parent_id' and [{$link_do_child_id}]='$link_id' and [sort_order] > 1");        
		$this->UpdateForm();
{literal}        
    }
{/literal}    
    
    
{literal} 
}
{/literal}