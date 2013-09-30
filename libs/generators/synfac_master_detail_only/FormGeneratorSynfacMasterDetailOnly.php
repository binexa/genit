<?php

/**
 * Genit Openbiz Cubi Generator
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   cubi.bin.genit
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @license   http://www.opensource.org/licensess/bsd-license.php
 * @link      http://code.google.com/p/genit/
 * @version   $Id$
 */


/**
 * FormGenerator class
 *
 * Generate FormObject (DO) metafile
 *
 * @package   cubi.bin.tools
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class FormGeneratorSynfacMasterDetailOnly extends FormGeneratorAbstract
{
    const LIST_TEMPLATE = "f_TemplateList.xml";
    const DETAIL_TEMPLATE = "f_TemplateDetail.xml";    
    const DETAIL_ITEM_TEMPLATE = "f_TemplateDetailItem.xml";        
    const EDIT_TEMPLATE = "f_TemplateEdit.xml";
    const NEW_TEMPLATE = "f_TemplateNew.xml";
    const COPY_TEMPLATE = "f_TemplateCopy.xml";
    const EDIT_ATTACHMENT_TEMPLATE = "f_TemplateEditAttachment.xml";
    const EDIT_PICTURE_TEMPLATE = "f_TemplateEditPicture.xml";
    
    const DETAIL_TPL = "f_TemplateDetail.tpl";
    const DETAIL_ES_TPL = "f_TemplateDetailElementSet.tpl";
    const GRID_TPL = "f_TemplateGrid.tpl";
    
    const PHP_APPROVE_FORM_TEMPLATE = "php_ApproveForm.php";
    const PHP_GENERAL_FORM_TEMPLATE = "php_GeneralForm.php";

    /**
     * Generate all form metafiles
     *
     * @return array list of form file name
     */
    public function generate()
    {
        $this->_copyTemplateFileToModule();

        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_default;
        
        //$formFiles[] = $this->generateForm($this->list_form, self::LIST_TEMPLATE);
        //$formFiles[] = $this->generateForm($this->new_form, self::NEW_TEMPLATE);
        //$formFiles[] = $this->generateForm($this->edit_form, self::EDIT_TEMPLATE);
        //$formFiles[] = $this->generateForm($this->detail_form, self::DETAIL_TEMPLATE);
        $formFiles[] = $this->generateForm($this->detail_item_form, self::DETAIL_ITEM_TEMPLATE);
        //$formFiles[] = $this->generateForm($this->copy_form, self::COPY_TEMPLATE);
        
        $formFiles[] = $this->generateForm($this->php_general_form, self::PHP_GENERAL_FORM_TEMPLATE);

        //if ($this->metaGen->doGen->hasExternalAttachment()) {
        //    $formFiles[] = $this->generateForm($this->edit_attachment_form, self::EDIT_ATTACHMENT_TEMPLATE);
        //}

        //if ($this->metaGen->doGen->hasExternalPicture()) {
        //    $formFiles[] = $this->generateForm($this->edit_picture_form, self::EDIT_PICTURE_TEMPLATE);
        //}
        
        return $formFiles;
    }

    private function _generateCheckedListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_checked;
        return $this->generateForm($this->check_list_form, self::CHECK_LIST_TEMPLATE);
    }

    private function _generateReadCheckedListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_checked;
        return $this->generateForm($this->read_check_list_form, self::READ_CHECK_LIST_TEMPLATE);
    }
    
    private function _generateCheckedDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_checked;
        return $this->generateForm($this->check_detail_form, self::CHECK_DETAIL_TEMPLATE);
    }
    
    private function _generateReadCheckedDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_checked;
        return $this->generateForm($this->read_check_detail_form, self::READ_CHECK_DETAIL_TEMPLATE);
    }
    
    private function _generateNeedCheckListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_need_check;
        return $this->generateForm($this->need_check_list_form, self::NEED_CHECK_LIST_TEMPLATE);
    }

    private function _generateNeedCheckDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_need_check;
        return $this->generateForm($this->need_check_detail_form, self::NEED_CHECK_DETAIL_TEMPLATE);
    }
    
    private function _generateApprovedListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_approved;
        return $this->generateForm($this->approve_list_form, self::APPROVE_LIST_TEMPLATE);
    }
    
    private function _generateReadApprovedListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_approved;
        return $this->generateForm($this->read_approve_list_form, self::READ_APPROVE_LIST_TEMPLATE);
    }

    private function _generateApprovedDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_approved;
        return $this->generateForm($this->approve_detail_form, self::APPROVE_DETAIL_TEMPLATE);
    }
    
    private function _generateReadApprovedDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_approved;
        return $this->generateForm($this->read_approve_detail_form, self::READ_APPROVE_DETAIL_TEMPLATE);
    }    
    
    private function _generateNeedApproveListForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_need_approve;
        return $this->generateForm($this->need_approve_list_form, self::NEED_APPROVE_LIST_TEMPLATE);
    }

    private function _generateNeedApproveDetailForm()
    {
        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_need_approve;
        return $this->generateForm($this->need_approve_detail_form, self::NEED_APPROVE_DETAIL_TEMPLATE);
    }
    
    /*
    protected function _assignToSmarty($smarty)
    {
    }
     * 
     */

}
