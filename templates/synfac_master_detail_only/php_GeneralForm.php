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

    public function insertRecord()
    {
        parent::insertRecord();
        if ($this->hasCheckProcess || $this->hasApproveProcess) {
                $this->_saveCheckNotification();
        }
    }
    
    public function editRecord($id=null) {
        
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
		
        if (!isset($id))
        {
            BizSystem::clientProxy()->showClientAlert('Silahhkan pilih record data!');
            return;
        }
        
        $dataRec = $this->getDataObj()->fetchById($id);
        if ( ($dataRec['is_approved']==1) && ($dataRec['is_checked']==1) ) {
            BizSystem::clientProxy()->showClientAlert('Data Sudah di approve dan di check. Tidak boleh di edit!');
            return null;
        } elseif ($dataRec['is_checked']==1) {
            BizSystem::clientProxy()->showClientAlert('Data Sudah di check. Tidak boleh di edit!');
            return null;
        }

        // update the active record with new update record
        $this->getActiveRecord($id);

        $this->processPostAction();

    }

    public function deleteRecord($id=null) {
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
		
        if (!isset($id))
        {
            BizSystem::clientProxy()->showClientAlert('Silahhkan pilih record data!');
            return;
        }
        
        $dataRec = $this->getDataObj()->fetchById($id);
        if ( ($dataRec['is_approved']==1) && ($dataRec['is_checked']==1) ) {
            BizSystem::clientProxy()->showClientAlert('Data Sudah di approve dan di check. Tidak boleh di hapus!');
            return null;
        } elseif ($dataRec['is_checked']==1) {
            BizSystem::clientProxy()->showClientAlert('Data Sudah di check. Tidak boleh di hapus!');
            return null;
        }
        
        parent::deleteRecord($id);

    }
    

    private function _saveCheckNotification() {
            if ($this->hasCheckProcess && $this->hasApproveProcess) {
                    $redirectUri = $this->checkUri;
{/literal}
                    $subject = "New {$comp_desc} added and need checked and approved!";                
{literal}
            } else {
                if ($this->hasCheckProcess) {
                    $redirectUri = $this->checkUri;
{/literal}
                    $subject = "New {$comp_desc} added and need checked!";
{literal}                    
                } else {
                    $redirectUri = $this->approveUri;
{/literal}
                    $subject = "New {$comp_desc} added and need approved!";
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

    public function toggleCheckRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);
        $savedCount = 0;
        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            if ($dataRec['is_approved']==0) {
                if ($dataRec['is_checked']==0) {
                    $dataRec['is_checked'] = 1; 
                } else {
                    $dataRec['is_checked'] = 0; 
                }
                $dataRec['check_by'] = BizSystem::getUserProfile('Id');
                $dataRec['check_time'] = date('Y-m-d H:i:s');
                $dataRec->save();
                $savedCount++;
            }
        }
        if ($savedCount>0) {
            $this->_saveApproveNotification();
            //if (strtoupper($this->m_FormType) == "LIST")
                $this->rerender();
            //$this->_renderOtherForm();
        }
        
        $this->runEventLog();
        $this->processPostAction();
    }

    
    /**
     * Approve record that added and checked by other user.
     * @param <any> $id Single record Id that selected by user. 
     *              If null used multi selected.
     */    
    public function toggleApproveRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);
        $savedCount = 0;
        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            if ($dataRec['is_approved']==0) {
                $dataRec['is_approved'] = 1;
            } else {
                $dataRec['is_approved'] = 0;
            }
            $dataRec['approve_by'] = BizSystem::getUserProfile('Id');
            $dataRec['approve_time'] = date('Y-m-d H:i:s');
            $dataRec->save();
            $savedCount++;
        }
        if ($savedCount>0) {
            //if (strtoupper($this->m_FormType) == "LIST")
                $this->rerender();
            //$this->_renderOtherForm();
        }
        $this->runEventLog();
        $this->processPostAction();
    }

    
    private function _getSelectedIds($id = null)
    {
        if ($id == null || $id == '')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selectedIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);

        if ($selectedIds == null)
            $selectedIds[] = $id;

        return $selectedIds;
    }

    private function _renderOtherForm()
    {
        $formObj = BizSystem::GetObject($this->otherForm);
        $formObj->rerender();
    }
    
    private function _saveApproveNotification()
    {
{/literal}
        /* @var $svc checkerService */
        $svc = BizSystem::getService($this->_notificationService);
        
        $redirectUri = $this->approveUri;

        $subject = "New/update {$comp_desc} and need approved!";
        
        $pos = strpos($this->m_Name, ".");
        $modul = substr($this->m_Name, 0, $pos);

        $notificationData = array(
            "type" => $this->m_Name,
            "subject" => $subject,
            "message" => 'Please approve the record.',
            "goto_url" => APP_URL . '/index.php/' . $modul . '/' . $redirectUri,
            "read_access" => '',
            "update_access" => '',
            "read_state" => 0,
        ); 

        $notificationList = array($notificationData);
        $svc->saveNotificationList($notificationList);
{literal}
    }    

}
{/literal}