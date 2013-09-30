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
    public $checkUri="{$listview_check_uri}";
    public $approveUri="{$listview_approve_uri}";
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
                $this->_saveNotification();
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

}
{/literal}