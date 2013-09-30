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
class FormGeneratorGenitMaster extends FormGeneratorAbstract
{

    const LIST_TEMPLATE = "f_TemplateList.xml";
    const DETAIL_TEMPLATE = "f_TemplateDetail.xml";
    const EDIT_TEMPLATE = "f_TemplateEdit.xml";
    const NEW_TEMPLATE = "f_TemplateNew.xml";
    const COPY_TEMPLATE = "f_TemplateCopy.xml";
    const EDIT_ATTACHMENT_TEMPLATE = "f_TemplateEditAttachment.xml";
    const EDIT_PICTURE_TEMPLATE = "f_TemplateEditPicture.xml";
    const CHECK_LIST_TEMPLATE = "f_TemplateCheckList.xml";
    const CHECK_DETAIL_TEMPLATE = "f_TemplateCheckDetail.xml";
    const NEED_CHECK_LIST_TEMPLATE = "f_TemplateNeedCheckList.xml";
    const NEED_CHECK_DETAIL_TEMPLATE = "f_TemplateNeedCheckDetail.xml";
    const APPROVE_LIST_TEMPLATE = "f_TemplateApproveList.xml";
    const APPROVE_DETAIL_TEMPLATE = "f_TemplateApproveDetail.xml";
    const NEED_APPROVE_LIST_TEMPLATE = "f_TemplateNeedApproveList.xml";
    const NEED_APPROVE_DETAIL_TEMPLATE = "f_TemplateNeedApproveDetail.xml";
    const READ_LIST_TEMPLATE = "f_TemplateReadList.xml";
    const READ_DETAIL_TEMPLATE = "f_TemplateReadDetail.xml";
    const READ_CHECK_LIST_TEMPLATE = "f_TemplateReadCheckList.xml";
    const READ_CHECK_DETAIL_TEMPLATE = "f_TemplateReadCheckDetail.xml";
    const READ_APPROVE_LIST_TEMPLATE = "f_TemplateReadApproveList.xml";
    const READ_APPROVE_DETAIL_TEMPLATE = "f_TemplateReadApproveDetail.xml";
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

        $formFiles[] = $this->generateForm($this->list_form, self::LIST_TEMPLATE);
        $formFiles[] = $this->generateForm($this->new_form, self::NEW_TEMPLATE);
        $formFiles[] = $this->generateForm($this->edit_form, self::EDIT_TEMPLATE);
        $formFiles[] = $this->generateForm($this->detail_form, self::DETAIL_TEMPLATE);

        $formFiles[] = $this->generateForm(
                $this->php_general_form, self::PHP_GENERAL_FORM_TEMPLATE);

        if ($this->metaGen->doGen->hasExternalAttachment()) {
            $formFiles[] = $this->generateForm($this->edit_attachment_form,
                    self::EDIT_ATTACHMENT_TEMPLATE);
        }

        if ($this->metaGen->doGen->hasExternalPicture()) {
            $formFiles[] = $this->generateForm($this->edit_picture_form,
                    self::EDIT_PICTURE_TEMPLATE);
        }

        return $formFiles;
    }

}
