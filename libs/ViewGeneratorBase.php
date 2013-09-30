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
 * ViewGenerator class
 *
 * Generate ViewObject metafile
 *
 * @package   cubi.bin.genit
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @access    public
 */
class ViewGeneratorBase
{
    const VIEW_TEMPLATE = "v_TemplateEasy.xml";
    const VIEW_CHECK_TEMPLATE = "v_TemplateCheckEasy.xml";
    const VIEW_APPROVE_TEMPLATE = "v_TemplateApproveEasy.xml";
    const VIEW_TPL = "v_TemplateView.tpl";

    /**
     * View name
     * @var string
     */
    public $view_name;
    public $check_view_name;
    public $approve_view_name;
    
    protected $_default_view;

    /**
     *
     * @var MetaGeneratorBase
     */
    public $metaGen;

    /**
     * 
     * @param type $metaGen
     */
    function __construct($metaGen)
    {
        $this->metaGen = $metaGen;
        $config = $this->metaGen->config;

        $this->view_name = $config->getComponentName() . 'ListView';
        $this->check_view_name = $config->getComponentName() . 'CheckListView';
        $this->approve_view_name = $config->getComponentName() . 'ApproveListView';
    }

    /**
     * generate View file
     * 
     * @param type $templateFileName nama template file
     * @param type $viewName nama view
     * @param type $defaultFormName default form
     * @param type $moreForm form tambahan di bawah default form
     * @return string
     */
    function generateView($templateFileName, $viewName, $defaultFormName, $moreForm = null)
    {
        $this->_default_view = $viewName;
        GenitDebug::ShowMessage(__METHOD__ . "[BEGIN]");
        GenitCli::showMessage("Start generate form object $viewName.");
        GenitCli::showMessage("Default form [$defaultFormName]");

        $content = $this->_createContent(
                $templateFileName, $viewName, $defaultFormName, $moreForm
        );

        $destinationViewPath = $this->metaGen->getModulePath() . DIRECTORY_SEPARATOR . "view";

        if (!file_exists($destinationViewPath)) {
            GenitCli::showMessage("Create directory $destinationViewPath");
            mkdir($destinationViewPath, 0777, true);
        }
        $destinationFile = $destinationViewPath . "/" . $viewName . ".xml";
        file_put_contents($destinationFile, $content);
        GenitCli::showMessage("\t" . str_replace(MODULE_PATH, "", $destinationFile) . " is generated.");
        GenitDebug::showMessage(__METHOD__ . "[END]");
        return $destinationFile;
    }

    protected function _createContent($templateFileName, $defaultViewName = NULL, $defaultFormName = NULL, $moreForm = NULL)
    {
        GenitDebug::ShowMessage(__METHOD__ . "[BEGIN]");
        
        $smarty = BizSystem::getSmartyTemplate();
        $this->_assignToSmarty($smarty, $defaultViewName, $defaultFormName, $moreForm);
        $templateFileWithPath = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . $templateFileName;
        $content = $smarty->fetch($templateFileWithPath);
        
        GenitDebug::ShowMessage(__METHOD__ . "[END]");
        return $content;
    }

    /**
     * 
     * @param Smarty $smarty
     */
    protected function _assignToSmarty($smarty, $defaultViewName = NULL, $defaultFormName = NULL, $moreForm = null)
    {
        GenitDebug::ShowMessage(__METHOD__ . "[BEGIN]");
        
        $config = $this->metaGen->config;
        $doGen = $this->metaGen->doGen;
        $formGen = $this->metaGen->formGen;
                
        $smarty->assign_by_ref("code_generator", $config->getCodeGeneratorName());
        
        // module & component
        $smarty->assign_by_ref("package_name", $config->getPackageName());
        $smarty->assign_by_ref("package", $config->getPackageName());
        // Module Info 
        $smarty->assign("do_package", $config->getPackageName() . ".do");
        $smarty->assign("form_package", $config->getPackageName() . ".form");

        $smarty->assign_by_ref("package_path", $config->getPackagePath());
        $smarty->assign_by_ref("module_name", $config->getModuleName());
        $smarty->assign_by_ref("module", $config->getModuleName());
        $smarty->assign_by_ref("comp_name", $config->getComponentName()); //dep
        $smarty->assign_by_ref("comp_desc", $config->getComponentDesc());
        
        $smarty->assign_by_ref("full_comp_name", $this->getFullCompName());//dep

        // view
        if ($defaultViewName == null) {
            $smarty->assign_by_ref("default_view_name", $this->view_name);
        } else {
            $smarty->assign_by_ref("default_view_name", $defaultViewName);
        }
        $smarty->assign_by_ref("view_name", $this->view_name);

        // form
        $smarty->assign_by_ref("list_form", $formGen->list_form);
        $smarty->assign_by_ref("new_form", $formGen->new_form);
        $smarty->assign_by_ref("copy_form", $formGen->copy_form);
        $smarty->assign_by_ref("edit_form", $formGen->edit_form);
        $smarty->assign_by_ref("detail_form", $formGen->detail_form);

        $smarty->assign_by_ref("check_list_form", $formGen->check_list_form);
        $smarty->assign_by_ref("approve_list_form", $formGen->approve_list_form);

        if ($defaultFormName == null) {
            $smarty->assign_by_ref("default_form", $formGen->list_form);
        } else {
            $smarty->assign_by_ref("default_form", $defaultFormName);
        }

        //$moreForm = $config->getMoreForms();
        $smarty->assign_by_ref("more_form", $moreForm);

        GenitDebug::ShowMessage($moreForm);

        // others
        $smarty->assign_by_ref("acl", $this->metaGen->options['acl']);
        $smarty->assign_by_ref("id_identity", $doGen->id_identity);

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_external_changelog", $doGen->hasExternalChangelog());

        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_aprove_process", $doGen->hasApproveProcess());
        GenitDebug::ShowMessage(__METHOD__ . "[END]" );
    }

    protected function _copyTemplateFileToModule()
    {
        $config = $this->metaGen->config;
        $templatePath = $config->getTemplatePath();
        $packageName = $config->getPackageName();

        GenitHelper::copyTemplateFile(
                "view.tpl", $templatePath . DIRECTORY_SEPARATOR . self::VIEW_TPL, $packageName
        );
    }

    public function getFormGenerator()
    {
        return $this->metaGen->formGen;
    }
    
    public function generate()
    {
        $this->_copyTemplateFileToModule();
    }
    
    public function getFullCompName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getModule() . ".view." . $this->_default_view;
        return $fullCompName;
    }
}