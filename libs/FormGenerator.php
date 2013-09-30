<?php

/**
 * Cubi Application Platform
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
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
class FormGenerator {

    const LIST_TEMPLATE = "/f_TemplateList.xml";
    const DETAIL_TEMPLATE = "/f_TemplateDetail.xml";
    const EDIT_TEMPLATE = "/f_TemplateEdit.xml";
    const NEW_TEMPLATE = "/f_TemplateNew.xml";
    const COPY_TEMPLATE = "/f_TemplateCopy.xml";
    const EDIT_ATTACHMENT_TEMPLATE = "/f_TemplateEditAttachment.xml";
    const EDIT_PICTURE_TEMPLATE = "/f_TemplateEditPicture.xml";
    const CHECK_LIST_TEMPLATE = "/f_TemplateCheckList.xml";
    const NEED_CHECK_LIST_TEMPLATE = "/f_TemplateNeedCheckList.xml";
    const APPROVE_LIST_TEMPLATE = "/f_TemplateApproveList.xml";
    const NEED_APPROVE_LIST_TEMPLATE = "/f_TemplateNeedApproveList.xml";
    const DETAIL_TPL = "/f_TemplateDetail.tpl";
    const DETAIL_ES_TPL = "/f_TemplateDetailElementSet.tpl";
    const GRID_TPL = "/f_TemplateGrid.tpl";

    /**
     *
     * @var MetaGenerator 
     */
    public $metaGenerator;

    /**
     * Package name (path.path.path)
     * @var string
     */
    public $package_name;

    /**
     * view name
     * @var string
     */
    public $view_name;

    /**
     * More option parameters
     * @var array
     */
    public $options;

    /**
     * Form name of data list
     * @var string
     */
    public $list_form;

    /**
     * Form name of new entry form
     * @var string 
     */
    public $new_form;

    /**
     * Form name of edit entry form
     * @var <type>
     */
    public $edit_form;

    /**
     * Form name of copy entry form
     * @var string
     */
    public $copy_form;

    /**
     * Form name of detail form
     * @var string
     */
    public $detail_form;

    /**
     * Form name of edit attachment form
     * @var string
     */
    public $edit_attachment_form;

    /**
     * Form name of edit picture form
     * @var string
     */
    public $edit_picture_form;
    
    public $check_list_form;
    public $need_check_list_form;    
    public $need_approve_list_form;

    /**
     * DOGenerator object
     * @var DOGenerator
     */
    public $doGenerator;

    /**
     * search columns
     * @var array
     */
    public $search_cols = array();

    /**
     * Message file name
     * @var string
     */
    public $message_file = "";

    /**
     * Event name
     * @var string
     */
    public $event_name = "";

    /**
     * Form object class name, default is EasyForm
     * @var string
     */
    public $form_obj_class = "EasyForm";

    /**
     * ACL name
     * @var string
     */
    public $acl_name = "";

    /**
     * Initialize
     *
     * @param string $package_name module name
     * @param DOGenerator $doGenerator DOGenerator object
     * @param array $options
     * @return void
     */
    function __construct($package_name, $doGenerator, $options) {
        $this->package_name = $package_name;
        $this->doGenerator = $doGenerator;
        $table_name = $doGenerator->table_name;

        $this->options = $options;
        $this->view_name = 'view.' . $options[1] . 'View';
        $this->list_form = 'form.' . $options[1] . 'ListForm';
        $this->new_form = 'form.' . $options[1] . 'NewForm';
        $this->edit_form = 'form.' . $options[1] . 'EditForm';
        $this->copy_form = 'form.' . $options[1] . 'CopyForm';
        $this->detail_form = 'form.' . $options[1] . 'DetailForm';

        $this->edit_attachment_form = 'form.' . $options[1] . 'EditAttachmentForm';
        $this->edit_picture_form = 'form.' . $options[1] . 'EditPictureForm';

        $this->check_list_form = 'form.' . $options[1] . 'CheckListForm';
        $this->need_check_list_form = 'form.' . $options[1] . 'NeedCheckListForm';
        $this->approve_list_form = 'form.' . $options[1] . 'ApproveListForm';
        $this->need_approve_list_form = 'form.' . $options[1] . 'NeedApproveListForm';

        foreach ($doGenerator->tableIndex as $index) {
            foreach ($index as $search) {
                array_push($this->search_cols, $search);
            }
        }
    }

    /**
     * Generate all form metafiles
     *
     * @return array list of form file name
     */
    public function generateAllForms() {

        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';

        // copy templates file grid.tpl and detail.tpl
        GenitHelper::copyTemplateFile("detail.tpl", $templateDirectory . META_TPL . self::DETAIL_TPL, $this->package_name);
        GenitHelper::copyTemplateFile("detail_elementset.tpl", $templateDirectory . META_TPL . self::DETAIL_ES_TPL, $this->package_name);
        GenitHelper::copyTemplateFile("grid.tpl", $templateDirectory . META_TPL . self::GRID_TPL, $this->package_name);

        //print_r($this->doGenerator->fields);
        $formFiles[] = $this->generateForm($this->list_form, $templateDirectory . META_TPL . self::LIST_TEMPLATE);
        $formFiles[] = $this->generateForm($this->new_form, $templateDirectory . META_TPL . self::NEW_TEMPLATE);
        $formFiles[] = $this->generateForm($this->edit_form, $templateDirectory . META_TPL . self::EDIT_TEMPLATE);
        $formFiles[] = $this->generateForm($this->detail_form, $templateDirectory . META_TPL . self::DETAIL_TEMPLATE);
        $formFiles[] = $this->generateForm($this->copy_form, $templateDirectory . META_TPL . self::COPY_TEMPLATE);

        if ($this->doGenerator->hasExternalAttachment()) {

            $formFiles[] = $this->generateForm($this->edit_attachment_form, $templateDirectory . META_TPL . self::EDIT_ATTACHMENT_TEMPLATE);
        }
        
        if ($this->doGenerator->hasExternalPicture()) {
            $formFiles[] = $this->generateForm($this->edit_picture_form, $templateDirectory . META_TPL . self::EDIT_PICTURE_TEMPLATE);
        }

        if ($this->doGenerator->hasCheckProcess()) {
            $formFiles[] = $this->_generateNeedCheckForm();
            $formFiles[] = $this->_generateCheckedForm();
            
        }
        
        if ($this->doGenerator->hasApproveProcess()) {
            $formFiles[] = $this->_generateNeedApproveForm();
            $formFiles[] = $this->_generateApprovedForm();            
        }

        return $formFiles;
    }

    private function _generateCheckedForm() {
        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';
        $this->doGenerator->do_name = 'do.' . $this->doGenerator->do_short_name_checked;
        return $this->generateForm($this->check_list_form, $templateDirectory . META_TPL . self::CHECK_LIST_TEMPLATE);
    }

    /**
     * 
     */
    private function _generateNeedCheckForm() {
        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';
        $this->doGenerator->do_name = 'do.' . $this->doGenerator->do_short_name_need_check;
        return $this->generateForm($this->need_check_list_form, $templateDirectory . META_TPL . self::NEED_CHECK_LIST_TEMPLATE);
    }

    private function _generateApprovedForm() {
        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';
        $this->doGenerator->do_name = 'do.' . $this->doGenerator->do_short_name_approved;
        return $this->generateForm($this->approve_list_form, $templateDirectory . META_TPL . self::APPROVE_LIST_TEMPLATE);
    }

    /**
     * 
     */
    private function _generateNeedApproveForm() {
        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';
        $this->doGenerator->do_name = 'do.' . $this->doGenerator->do_short_name_need_approve;
        return $this->generateForm($this->need_approve_list_form, $templateDirectory . META_TPL . self::NEED_APPROVE_LIST_TEMPLATE);
    }

    /**
     * Generate form metafile
     *
     * @param string $form_name form name
     * @param string $templateFile name of template file
     * @return string
     */
    public function generateForm($form_name, $templateFile) {
        
        echo "\n\n\n\n\n DO NAME: " . $this->doGenerator->do_name . "\n\n\n\n\n";
        echo "\n TEMPLATE FILE : $templateFile \n";
        $do_short_name = $this->doGenerator->do_short_name;

        $form_short_name = str_replace("form.", "", $form_name);

        if (CLI) {
            echo "Start generate form object $form_short_name." . PHP_EOL;
        }
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $this->package_name) . "/form";
        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        $smarty = BizSystem::getSmartyTemplate();

        //print_r($this->opts);

        $package_path = $this->options[0];
        $base_object_name = $this->options[1];
        $module_name = $this->options[2];
        $package = $this->options[3];

        $smarty->assign_by_ref("do_name", $this->doGenerator->do_name);
        $smarty->assign_by_ref("do_short_name", $this->doGenerator->do_short_name);
        $smarty->assign_by_ref("comp", $this->package_name);
        $smarty->assign_by_ref("table_name", $this->doGenerator->table_name);
        $smarty->assign_by_ref("fields", $this->doGenerator->fields);
        $smarty->assign_by_ref("view_name", $this->view_name);
        $smarty->assign_by_ref("form_name", $form_name);
        $smarty->assign_by_ref("form_short_name", $form_short_name);
        
        // form variable
        $smarty->assign_by_ref("list_form", $this->list_form);
        $smarty->assign_by_ref("new_form", $this->new_form);
        $smarty->assign_by_ref("copy_form", $this->copy_form);
        $smarty->assign_by_ref("edit_form", $this->edit_form);
        $smarty->assign_by_ref("detail_form", $this->detail_form);
        
        $smarty->assign_by_ref("need_check_list_form", $this->need_check_list_form);
        $smarty->assign_by_ref("check_list_form", $this->check_list_form);
        
        $smarty->assign_by_ref("need_approve_list_form", $this->need_approve_list_form);
        $smarty->assign_by_ref("approve_list_form", $this->approve_list_form);
        
        $smarty->assign_by_ref("searchs", $this->search_cols);
        $smarty->assign_by_ref("acl_name", $this->acl_name);
        $smarty->assign_by_ref("event_name", $this->event_name);
        $smarty->assign_by_ref("message_file", $this->message_file);
        $smarty->assign_by_ref("form_obj_class", $this->form_obj_class);

        $smarty->assign_by_ref("id_identity", $this->doGenerator->id_identity);

        $smarty->assign_by_ref("package", $package);
        $smarty->assign_by_ref("package_path", $package_path);
        $smarty->assign_by_ref("module_name", $module_name);
        $smarty->assign_by_ref("base_object_name", $base_object_name);

        $smarty->assign_by_ref("acl", $this->options['acl']);

        $doGen = $this->doGenerator;

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());

        $content = $smarty->fetch($templateFile);

        // target file
        $targetFile = $targetPath . "/" . $form_short_name . ".xml";
        file_put_contents($targetFile, GenitHelper::trimEmptyLines($content));
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL . PHP_EOL;
        }
        return $targetFile;
    }

}

?>
