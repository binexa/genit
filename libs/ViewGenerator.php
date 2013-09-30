<?php

/**
 * Cubi Application Platform
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.lib
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */


/**
 * ViewGenerator class
 *
 * Generate ViewObject metafile
 *
 * @package   cubi.bin.tools.lib
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class ViewGenerator {

    const VIEW_TEMPLATE = "/v_TemplateEasy.xml";    
    const VIEW_CHECK_TEMPLATE = "/v_TemplateCheckEasy.xml";
    const VIEW_APPROVE_TEMPLATE = "/v_TemplateApproveEasy.xml";
    
    const VIEW_TPL = "/v_TemplateView.tpl";

    /**
     * package name
     * @var string
     */
    public $package_name;

    /**
     * View name
     * @var string
     */
    public $view_name;
    public $check_view_name;
    public $approve_view_name;

    /**
     * More option parameter
     * @var string
     */
    public $options;

    /**
     * FormGenerator object
     * @var FormGenerator
     */
    public $formGenerator;
    public $metaGenerator;

    /**
     * Initialize
     *
     * @param string $packageName module name
     * @param FormGenerator $formGenerator
     * @param array $options more optional parameter
     */
    function __construct($packageName, $formGenerator, $options) {
        $this->package_name = $packageName;
        $this->formGenerator = $formGenerator;
        $table_name = $formGenerator->doGenerator->table_name;
        $this->options = $options;
        $this->view_name = 'view.' . $options[1] . 'ListView';
        $this->check_view_name = 'view.' . $options[1] . 'CheckListView';
        $this->approve_view_name = 'view.' . $options[1] . 'ApproveListView';
    }

    /**
     * Generate View
     *
     * @return string
     */
    function generateView($viewName = null, $defaultFormName = null, $templateName=null, $moreForm=null) {
        
        $templateDirectory = dirname(dirname(__FILE__)) . '/templates/';
        
        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . $templateName;        
        // copy templates file view.tpl
        GenitHelper::copyTemplateFile("view.tpl", $templateDirectory . META_TPL . self::VIEW_TPL, $this->package_name);

        if ($viewName == null)
            $shortViewtName = str_replace("view.", "", $this->view_name);
        else 
            $shortViewtName = str_replace("view.", "", $viewName);

        if (CLI) {
            echo "Start generate form object $shortViewtName." . PHP_EOL;
        }

        // location of view file
        $targetPath = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->package_name) . "/view";

        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        $package_path = $this->options[0];
        $base_object_name = $this->options[1];
        $module_name = $this->options[2];
        $package = $this->options[3];

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("view_name", $this->view_name);
        $smarty->assign_by_ref("view_short_name", $shortViewtName);
        $smarty->assign_by_ref("comp", $this->package_name);
        $smarty->assign_by_ref("list_form", $this->formGenerator->list_form);
        $smarty->assign_by_ref("new_form", $this->formGenerator->new_form);
        $smarty->assign_by_ref("copy_form", $this->formGenerator->copy_form);
        $smarty->assign_by_ref("edit_form", $this->formGenerator->edit_form);
        $smarty->assign_by_ref("detail_form", $this->formGenerator->detail_form);

        $smarty->assign_by_ref("check_list_form", $this->formGenerator->check_list_form);
        $smarty->assign_by_ref("approve_list_form", $this->formGenerator->approve_list_form);

        if ($defaultFormName == null) {
            $smarty->assign_by_ref("default_form", $this->formGenerator->list_form);
        } else {
            $smarty->assign_by_ref("default_form", $defaultFormName);            
        }
        
        if (isset($moreForm)) {
            $smarty->assign_by_ref("more_form", $moreForm);
        }

        $smarty->assign_by_ref("acl", $this->options['acl']);

        $smarty->assign_by_ref("id_identity", $this->doGenerator->id_identity);

        $smarty->assign_by_ref("package", $package);
        $smarty->assign_by_ref("package_path", $package_path);
        $smarty->assign_by_ref("module_name", $module_name);
        $smarty->assign_by_ref("base_object_name", $base_object_name);


        $doGen = $this->formGenerator->doGenerator;

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_aprove_process", $doGen->hasCheckProcess());

        
        $content = $smarty->fetch($templateFile);

        // target file
        $targetFile = $targetPath . "/" . $shortViewtName . ".xml";
        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL;
        }
        return $targetFile;
    }

    public function generateAllViews() {

        $this->generateView($this->view_name, $this->formGenerator->list_form, self::VIEW_TEMPLATE);

        if ($this->formGenerator->doGenerator->hasCheckProcess()) {
            $this->generateView($this->check_view_name, $this->formGenerator->need_check_list_form, self::VIEW_CHECK_TEMPLATE, array($this->formGenerator->check_list_form));
        }
        if ($this->formGenerator->doGenerator->hasApproveProcess()) {
            $this->generateView($this->approve_view_name, $this->formGenerator->need_approve_list_form, self::VIEW_APPROVE_TEMPLATE, array($this->formGenerator->approve_list_form));
        }
    }

}



?>
