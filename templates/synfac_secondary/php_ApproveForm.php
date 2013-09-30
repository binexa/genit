<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once MODULE_PATH.'/changelog/form/ChangeLogNoCommentForm.php';

class {$php_approval_form} extends ChangeLogForm
{literal}
{   
{/literal}    
    public $otherForm;
    public $checkUri="{$listview_check_uri}";
    public $approveUri="{$listview_approve_uri}";
    public $hasCheckProcess={if $has_check_process==1}true{else}false{/if};
    public $hasApproveProcess={if $has_approve_process==1}true{else}false{/if};
{literal}    
    private $_notificationService = "notification.lib.checkerService";
    

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

    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->otherForm = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["OTHERFORM"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["OTHERFORM"] : null;
    }

    public function CheckRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);

        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            $dataRec['is_checked'] = 1; 
            $dataRec['check_by'] = BizSystem::getUserProfile('Id');
            $dataRec['check_time'] = date('Y-m-d H:i:s');
            $dataRec->save();            
        }
        $this->_saveNotification();

        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->_renderOtherForm();

        $this->runEventLog();
        $this->processPostAction();
    }

    public function UnCheckRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);

        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            $dataRec['is_checked'] = 0; 
            $dataRec['check_by'] = BizSystem::getUserProfile('Id');
            $dataRec['check_time'] = date('Y-m-d H:i:s');
            $dataRec->save();
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->_renderOtherForm();

        $this->runEventLog();
        $this->processPostAction();
    }

    /**
     * Approve record that added and checked by other user.
     * @param <any> $id Single record Id that selected by user. 
     *                  If null used multi selected.
     */    
    public function ApproveRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);

        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            $dataRec['is_approved'] = 1; 
            $dataRec['approve_by'] = BizSystem::getUserProfile('Id');
            $dataRec['approve_time'] = date('Y-m-d H:i:s');
            $dataRec->save();            
        }

        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->_renderOtherForm();

        $this->runEventLog();
        $this->processPostAction();
    }

    
    public function UnApproveRecord($id = null)
    {
        $selectedIds = $this->_getSelectedIds($id);

        foreach ($selectedIds as $id) {
            $dataRec = $this->getDataObj()->fetchById($id);
            $dataRec['is_approved'] = 0; 
            $dataRec['approve_by'] = BizSystem::getUserProfile('Id');
            $dataRec['approve_time'] = date('Y-m-d H:i:s');
            $dataRec->save();
        }
        
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->_renderOtherForm();

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
    
    
    private function _saveNotification() 
    {
{/literal}        
        /* @var $svc checkerService */
        $svc = BizSystem::getService($this->_notificationService);
        
        $redirectUri = $this->approveUri;
        $subject = "New/update {$comp_name} and need approved!";
        
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
{literal}
        $notificationList = array($notificationData);
        $svc->saveNotificationList($notificationList);

    }    
    

}
{/literal}
