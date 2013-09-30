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
class FormGeneratorGenitPublicSplit extends FormGeneratorAbstract
{
    const LIST_TEMPLATE = "f_TemplateList.xml";
    const DETAIL_TEMPLATE = "f_TemplateDetail.xml";    
    const DETAIL_ITEM_TEMPLATE = "f_TemplateDetailItem.xml";    
    const EDIT_TEMPLATE = "f_TemplateEdit.xml";
    const NEW_TEMPLATE = "f_TemplateNew.xml";
    const COPY_TEMPLATE = "f_TemplateCopy.xml";
    const EDIT_ATTACHMENT_TEMPLATE = "f_TemplateEditAttachment.xml";
    const EDIT_PICTURE_TEMPLATE = "f_TemplateEditPicture.xml";

    const DETAIL_TPL    = "f_TemplateDetail.tpl";
    const DETAIL_ES_TPL = "f_TemplateDetailElementSet.tpl";
    const GRID_TPL      = "f_TemplateGrid.tpl";
    
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
        
        $formFiles[] = $this->generateForm($this->read_list_form, self::READ_LIST_TEMPLATE);        
        $formFiles[] = $this->generateForm($this->read_detail_form, self::READ_DETAIL_TEMPLATE);

        $formFiles[] = $this->generateForm($this->list_form, self::LIST_TEMPLATE);
        $formFiles[] = $this->generateForm($this->new_form, self::NEW_TEMPLATE);
        $formFiles[] = $this->generateForm($this->edit_form, self::EDIT_TEMPLATE);
        $formFiles[] = $this->generateForm($this->detail_form, self::DETAIL_TEMPLATE);
        $formFiles[] = $this->generateForm($this->detail_item_form, self::DETAIL_ITEM_TEMPLATE);
        $formFiles[] = $this->generateForm($this->copy_form, self::COPY_TEMPLATE);
        
        $formFiles[] = $this->generateForm($this->php_general_form, self::PHP_GENERAL_FORM_TEMPLATE);

        if ($this->metaGen->doGen->hasExternalAttachment()) {
            $formFiles[] = $this->generateForm($this->edit_attachment_form, self::EDIT_ATTACHMENT_TEMPLATE);
        }

        if ($this->metaGen->doGen->hasExternalPicture()) {
            $formFiles[] = $this->generateForm($this->edit_picture_form, self::EDIT_PICTURE_TEMPLATE);
        }
            
        $formFiles[] = $this->generateForm($this->php_approval_form, self::PHP_APPROVE_FORM_TEMPLATE);
        
        return $formFiles;
    }
    
/*    
    protected function _assignToSmarty($smarty)
    {
        $this->_assignToSmarty($smarty);
        
        $config = $this->metaGen->config;
        $doGen = $this->metaGen->doGen;
        
        $listview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_list";
        $listview_check_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_approve_list";

        $detailview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_detail";

        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);
        $smarty->assign_by_ref("detailview_uri", $detailview_uri);
        
        
    }
*/
}
