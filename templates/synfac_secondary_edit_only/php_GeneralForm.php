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
    public $hasCheckProcess={if $has_check_process==1}true{else}false{/if};
    public $hasApproveProcess={if $has_approve_process==1}true{else}false{/if};
    private $_notificationService = "notification.lib.checkerService";
    
{literal}
}
{/literal}