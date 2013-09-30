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
abstract class FormGeneratorAbstract
{
    abstract public function generate();

    const LIST_TEMPLATE = "f_TemplateList.xml";
    const DETAIL_TEMPLATE = "f_TemplateDetail.xml";
    const DETAIL_ITEM_TEMPLATE = "f_TemplateDetailItem.xml";    
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
    
    const NEED_APPROVE_LIST_TEMPLATE    = "f_TemplateNeedApproveList.xml";
    const NEED_APPROVE_DETAIL_TEMPLATE  = "f_TemplateNeedApproveDetail.xml";
    
    const READ_LIST_TEMPLATE            = "f_TemplateReadList.xml";
    const READ_DETAIL_TEMPLATE          = "f_TemplateReadDetail.xml";
    const READ_CHECK_LIST_TEMPLATE      = "f_TemplateReadCheckList.xml";
    const READ_CHECK_DETAIL_TEMPLATE    = "f_TemplateReadCheckDetail.xml";
    const READ_APPROVE_LIST_TEMPLATE    = "f_TemplateReadApproveList.xml";
    const READ_APPROVE_DETAIL_TEMPLATE  = "f_TemplateReadApproveDetail.xml";
    
    const DETAIL_TPL    = "f_TemplateDetail.tpl";
    const DETAIL_ES_TPL = "f_TemplateDetailElementSet.tpl";
    const GRID_TPL      = "f_TemplateGrid.tpl";
    
    const PHP_APPROVE_FORM_TEMPLATE = "php_ApproveForm.php";
    const PHP_GENERAL_FORM_TEMPLATE = "php_GeneralForm.php";

    /**
     *
     * @var MetaGeneratorBase
     */
    public $metaGen;

    /**
     * Package name (path.path.path)
     * @var string
     */
    public $package_name;
    public $module_name;

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
    public $form_short_name;

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
    
    public $detail_item_form;

    /**
     * Form name of edit attachment form
     * @var string
     */
    public $edit_attachment_form;
    public $php_general_form;
    public $php_approval_form;

    /**
     * Form name of edit picture form
     * @var string
     */
    public $edit_picture_form;
    
    public $check_list_form;
    public $check_detail_form;
    
    public $need_check_list_form;
    public $need_check_detail_form;
    
    public $approve_list_form;
    public $approve_detail_form;
    
    public $need_approve_list_form;
    public $need_approve_detail_form;
    
    public $read_list_form;
    public $read_detail_form;
    public $read_check_list_form;
    public $read_check_detail_form;
    public $read_approve_list_form;
    public $read_approve_detail_form;

    /**
     * search columns
     * @var array
     */
    public $searchCols = array();

    /**
     * Message file name
     * @var string
     */
    public $messageFile = "";

    /**
     * Event name
     * @var string
     */
    public $eventName = "";

    /**
     * Form object class name, default is EasyForm
     * @var string
     */
    public $class_general_form;
    public $class_approval_form;

    /**
     * ACL name
     * @var string
     */
    public $acl_name = "";

    /**
     * 
     *
     * @param string $package_name module name
     * @param DOGenerator $doGen DOGenerator object
     * @param array $options
     * @return void
     */

    
    /**
     * Initialize form generator
     * @param MetaGenerator $metaGen
     */
    public function __construct($metaGen)
    {
        $this->metaGen = $metaGen;
        
        foreach ($this->metaGen->doGen->getTableIndex() as $index) {
            foreach ($index as $search) {
                array_push($this->searchCols, $search);
            }
        }
        $this->_setObjectNames();
    }
    
    
    protected function _setObjectNames()
    {
        $config = $this->metaGen->config;
        $componentName = $config->getComponentName();
        
        $this->list_form = $componentName . 'ListForm';
        $this->new_form = $componentName . 'NewForm';
        $this->edit_form = $componentName . 'EditForm';
        $this->copy_form = $componentName . 'CopyForm';
        $this->detail_form = $componentName . 'DetailForm';
        $this->detail_item_form = $componentName . 'DetailItemForm';

        $this->edit_attachment_form = $componentName . 'EditAttachmentForm';
        $this->edit_picture_form = $componentName . 'EditPictureForm';

        $this->check_list_form = $componentName . 'CheckListForm';
        $this->check_detail_form = $componentName . 'CheckDetailForm';

        $this->need_check_list_form = $componentName . 'NeedCheckListForm';
        $this->need_check_detail_form = $componentName . 'NeedCheckDetailForm';

        $this->approve_list_form = $componentName . 'ApproveListForm';
        $this->approve_detail_form = $componentName . 'ApproveDetailForm';

        $this->need_approve_list_form = $componentName . 'NeedApproveListForm';
        $this->need_approve_detail_form = $componentName . 'NeedApproveDetailForm';

        $this->read_list_form = $componentName . 'ReadListForm';
        $this->read_detail_form = $componentName . 'ReadDetailForm';

        $this->read_check_list_form = $componentName . 'ReadCheckListForm';
        $this->read_check_detail_form = $componentName . 'ReadCheckDetailForm';

        $this->read_approve_list_form = $componentName . 'ReadApproveListForm';
        $this->read_approve_detail_form = $componentName . 'ReadApproveDetailForm';

        $this->php_general_form = $componentName . 'Form';
        $this->php_approval_form = $componentName . 'ApproveForm';
        
        $this->class_general_form = $this->php_general_form;
        $this->class_approval_form = $this->php_approval_form;        
    }

    /**
     * Generate form metafile
     *
     * @param string $formName form name
     * @param string $templateFile name of template file
     * @return string
     */
    public function generateForm($formName, $templateFile)
    {
        $templateFileWithPath = $this->metaGen->config->getTemplatePath() . DIRECTORY_SEPARATOR . $templateFile;
        
        $targetFormPath =  $this->metaGen->config->getPackagePath() . DIRECTORY_SEPARATOR . "form";

        $this->form_short_name = $formName;

        GenitCli::showMessage( "Start generate form object $this->form_short_name." );
        
        if (!file_exists($targetFormPath)) {
            GenitCli::showMessage( "Create directory $targetFormPath" );
            mkdir( $targetFormPath, 0777, true );
        }

        $content = $this->_createContent($templateFileWithPath);

        $targetFile = $targetFormPath . DIRECTORY_SEPARATOR . $this->form_short_name . "." . $this->_getExtension($templateFile);

        file_put_contents($targetFile, GenitHelper::trimEmptyLines($content));
        
        GenitCli::showMessage( "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." );
        GenitCli::newLine();
        
        return $targetFile;
    }
    
    protected function _createContent($templateFileWithPath)
    {
        $smarty = BizSystem::getSmartyTemplate();
        $this->_assignToSmarty($smarty);
        return $smarty->fetch($templateFileWithPath);
    }

    protected function _assignToSmarty($smarty)
    {
        $config = $this->metaGen->config;
        $doGen = $this->metaGen->doGen;

        //echo __METHOD__."\n";
        //print_r( $doGen->getEditFields() );
        //exit;
        
        $smarty->assign_by_ref( "code_generator", $config->getCodeGeneratorName() );
        
        // Module Info 
        $smarty->assign_by_ref( "package_name", $config->getPackageName() );
        $smarty->assign_by_ref("package", $config->getPackageName());        
        $smarty->assign("do_package", $config->getPackageName() . ".do" );
        $smarty->assign("form_package", $config->getPackageName() . ".form" );

        $fullCompName = 
        $smarty->assign_by_ref("module", $config->getModuleName());
        $smarty->assign_by_ref("module_name", $config->getComponentDesc());
        
        $smarty->assign_by_ref("comp_name", $config->getComponentName());//dep        
        $smarty->assign_by_ref("comp_desc", $config->getComponentDesc());
        $smarty->assign_by_ref("base_object_name", $config->getComponentName());//dep
        $smarty->assign_by_ref("full_comp_name", $this->getFullCompName());//dep

        $smarty->assign_by_ref("table_name", $config->getTableName());
        $smarty->assign_by_ref("fields", $doGen->getFields());
        
        $smarty->assign_by_ref("list_fields", $doGen->getListFields());
        $smarty->assign_by_ref("detail_fields", $doGen->getDetailFields());       
        $smarty->assign_by_ref("edit_fields", $doGen->getEditFields());

        foreach ($doGen->getEditFields() as $key => $value)
        {
            if ($value['name']=='arrival_datetime'||$value['name']=='ma_datetime' ) {
                //echo __LINE__;
                //print_r($value);
                //exit;
            }
        }
        
        $fieldsJoin = $this->metaGen->config->getFieldsJoin();
        $smarty->assign_by_ref("fields_join", $fieldsJoin);
        
        
        /* Data Object */
        $smarty->assign_by_ref("do_name", $doGen->doName);
        $smarty->assign_by_ref("do_short_name", $doGen->do_short_name);        
        
        $smarty->assign_by_ref("form_name", $this->form_short_name);
        $smarty->assign_by_ref("form_short_name", $this->form_short_name);

        // form variable
        $smarty->assign_by_ref("list_form", $this->list_form);
        $smarty->assign_by_ref("new_form", $this->new_form);
        $smarty->assign_by_ref("copy_form", $this->copy_form);
        $smarty->assign_by_ref("edit_form", $this->edit_form);
        $smarty->assign_by_ref("detail_form", $this->detail_form);
        $smarty->assign_by_ref("detail_item_form", $this->detail_item_form);

        $smarty->assign_by_ref("php_general_form", $this->php_general_form);

        $smarty->assign_by_ref("need_check_list_form", $this->need_check_list_form);
        $smarty->assign_by_ref("need_check_detail_form", $this->need_check_detail_form);

        $smarty->assign_by_ref("check_list_form", $this->check_list_form);
        $smarty->assign_by_ref("check_detail_form", $this->check_detail_form);

        $smarty->assign_by_ref("need_approve_list_form", $this->need_approve_list_form);
        $smarty->assign_by_ref("need_approve_detail_form", $this->need_approve_detail_form);

        $smarty->assign_by_ref("approve_list_form", $this->approve_list_form);
        $smarty->assign_by_ref("approve_detail_form", $this->approve_detail_form);

        $smarty->assign_by_ref("read_list_form", $this->read_list_form);
        $smarty->assign_by_ref("read_detail_form", $this->read_detail_form);
        $smarty->assign_by_ref("read_check_list_form", $this->read_check_list_form);
        $smarty->assign_by_ref("read_check_detail_form", $this->read_check_detail_form);
        $smarty->assign_by_ref("read_approve_list_form", $this->read_approve_list_form);
        $smarty->assign_by_ref("read_approve_detail_form", $this->read_approve_detail_form);

        $smarty->assign_by_ref("php_approval_form", $this->php_approval_form);

        $smarty->assign_by_ref("searchs", $this->searchCols);
        $smarty->assign_by_ref("acl_name", $this->acl_name);
        $smarty->assign_by_ref("event_name", $this->eventName);
        $smarty->assign_by_ref("message_file", $this->messageFile);

        $smarty->assign_by_ref("class_general_form", $this->class_general_form);
        $smarty->assign_by_ref("class_approval_form", $this->class_approval_form);


        $hasIdIdentity = $this->metaGen->doGen->id_identity;
        if ($hasIdIdentity) {
            $idGeneration = 'Identity';
        } else {
            $idGeneration = $config->getIdGeneration();
            if ($idGeneration!='') {
                $hasIdIdentity = true;
            } else {
                $hasIdIdentity = false;
            }
        }
        echo __METHOD__;
        echo 'hasIdentity  : '.$hasIdIdentity."\n";
        echo 'idGeneration : '.$idGeneration."\n";
        
        //exit;
        $smarty->assign_by_ref("id_identity", $hasIdIdentity);
        $smarty->assign_by_ref("id_generation", $idGeneration);
        $smarty->assign_by_ref("use_detail_view", $this->metaGen->config->useDetailView());

        $smarty->assign_by_ref("acl", $this->metaGen->options['acl']);

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_external_changelog", $doGen->hasExternalChangelog());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());

        $listview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_list";
        $listview_manage_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_manage";
        $listview_read_check_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_read_check";
        $listview_read_approve_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_read_approve";
        
        $listview_check_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_approve_list";

        $detailview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_detail";
        $detailitemview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_detail_item";
        $newview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_new";
        $editview_uri = strtolower(str_replace(" ", "_", $config->getComponentDesc())) . "_edit";

        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_manage_uri", $listview_manage_uri);
        $smarty->assign_by_ref("listview_read_check_uri", $listview_read_check_uri);
        $smarty->assign_by_ref("listview_read_approve_uri", $listview_read_approve_uri);
        
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);
        $smarty->assign_by_ref("detailview_uri", $detailview_uri);
        $smarty->assign_by_ref("detailitemview_uri", $detailitemview_uri);
        $smarty->assign_by_ref("newview_uri", $newview_uri);
        $smarty->assign_by_ref("editview_uri", $editview_uri);
        
        $smarty->assign_by_ref("picker_form", $config->getPickerForm());
        $smarty->assign_by_ref("row_per_page", $config->getRowPerPage());
        $smarty->assign_by_ref("extra_action", $config->getExtraAction());
        $smarty->assign_by_ref("detail_back_link", $config->getDetailBankLink());
        
        $smarty->assign_by_ref("parent_form", $config->getParentForm());
        $smarty->assign_by_ref("link_do", $config->getLinkDo());
        $smarty->assign_by_ref("link_do_parent_id", $config->getLinkDoParentId());
        $smarty->assign_by_ref("link_do_child_id", $config->getLinkDoChildId());
        
        $smarty->assign_by_ref("has_add_form", $config->hasAddForm());
        $smarty->assign_by_ref("has_edit_form", $config->hasEditForm());
        $smarty->assign_by_ref("has_detail_form", $config->hasDetailForm());
        $smarty->assign_by_ref("has_detail_item_form", $config->hasDetailItemForm());
        $smarty->assign_by_ref("has_delete_form", $config->hasDeleteForm());
        $smarty->assign_by_ref("has_export_button", $config->hasExportButton());
        $smarty->assign_by_ref("has_check_button", $config->hasCheckButton());
        $smarty->assign_by_ref("has_approve_button", $config->hasApproveButton());
        
        $smarty->assign_by_ref("has_validate_check_on_update", $config->hasValidateCheckOnUpdate());
        
        $smarty->assign_by_ref("external_methods", $config->getExternalMethods());
    }

    protected function _getExtension($fileName)
    {
        $ext = substr($fileName, -3);
        return $ext;
    }

    protected function _copyTemplateFileToModule()
    {
        $config = $this->metaGen->config;
        $templatePath = $config->getTemplatePath();
        $packageName = $config->getPackageName();
        
        GenitHelper::copyTemplateFile("detail.tpl", $templatePath . DIRECTORY_SEPARATOR . self::DETAIL_TPL, $packageName);
        GenitHelper::copyTemplateFile("detail_elementset.tpl", $templatePath . DIRECTORY_SEPARATOR . self::DETAIL_ES_TPL, $packageName);
        GenitHelper::copyTemplateFile("grid.tpl", $templatePath . DIRECTORY_SEPARATOR . self::GRID_TPL, $packageName);
    }
    
    public function getFullCompName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getPackageName() . ".form." . $this->form_short_name;
        return $fullCompName;
    }
}
