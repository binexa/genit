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
 * DashboardGenerator class
 *
 * MetaGenerator generate module Dashboard
 *
 * @package   cubi.bin.genit.libs
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2005-2010, Agus Suhartono
 * @access    public
 */
abstract class DashboardGeneratorBase
{
    const DASHBOARD_TEMPLATE = "dashboard_Template.xml";
    const DASHBOARDVIEW_TEMPLATE = "dashboard_view_Template.xml";
    const LEFTMENU_TEMPLATE = "leftmenu_Template.xml";

    /**
     *
     * @var MetaGenerator 
     */
    public $metaGen;

    /**
     * Initialize
     *
     * @param string $packageName module name
     * @return void
     */

    /**
     * 
     * @param MetaGenerator $metaGen
     */
    function __construct($metaGen)
    {
        $this->metaGen = $metaGen;
    }

    /**
     * Generate dashboard widget
     *  
     * @param unknown $table
     * @return Ambigous <void, string>
     */
    public function generateDashboardWidget()
    {
        GenitCli::showMessage("Start generate DashboardForm.xml .");
        $targetPath = $this->metaGen->getModulePath() . DIRECTORY_SEPARATOR . "widget";
        $this->setFullCompName($this->getFullDashboardWidgetName());
        return $this->_generateFileFromTemplate($targetPath, 'DashboardForm.xml', self::DASHBOARD_TEMPLATE);
    }

    /**
     * Generate dashboard view
     * 
     * @param string $table
     * @return string
     */
    public function generateDashboardView()
    {
        GenitDebug::ShowMessage("Start generate DashboardView.xml .");
        $moduleViewPath = $this->metaGen->getModulePath() . DIRECTORY_SEPARATOR . "view";
        $this->setFullCompName($this->getFullDashboardViewName());
        return $this->_generateFileFromTemplate($moduleViewPath, 'DashboardView.xml', self::DASHBOARDVIEW_TEMPLATE);
    }

    /**
     * Generate LeftMenu.xml
     * @return Ambigous <void, string>
     */
    public function generateLeftMenu()
    {
        GenitCli::showMessage("Start generate LeftMenu.xml .");
        $moduleWidgedPath = $this->metaGen->getModulePath() . DIRECTORY_SEPARATOR . "widget";
        $this->setFullCompName($this->getFullLeftMenuWidgetName());
        return $this->_generateFileFromTemplate($moduleWidgedPath, 'LeftMenu.xml', self::LEFTMENU_TEMPLATE);
    }

    /**
     * Modify view.tpl to enable module left menu supports
     * @return string
     */
    public function modifyViewTpl()
    {
        GenitCli::showMessage( "Start modify view.tpl to enable module left menu supports ." );
        
        $targetPath = $this->metaGen->getModulePath() . DIRECTORY_SEPARATOR . "template";
        $targetFile = $targetPath . DIRECTORY_SEPARATOR . "view.tpl";

        $str = '
$left_menu = "' . strtolower(GenitHelper::getModuleName($this->metaGen->config->getPackageName())) . '.widget.LeftMenu";
$this->assign("left_menu", $left_menu);
';

        $content = file_get_contents($targetFile);
        if (!preg_match("/widget\.LeftMenu/si", $content)) {
            $content = str_replace("{php}", "{php}" . $str, $content);
        } else {
            GenitCli::showMessage("\t" . str_replace(MODULE_PATH, "", $targetFile) . " was modified and skipped.");
            return NULL;
        }

        file_put_contents($targetFile, $content);
        GenitCli::showMessage("\t" . str_replace(MODULE_PATH, "", $targetFile) . " is modified.");
        return $targetFile;
    }

    /**
     * Generate files
     */
    public function generate()
    {
        $this->generateDashboardWidget();
        $this->generateDashboardView();
        $this->generateLeftmenu();
        $this->modifyViewTpl();
    }

    /**
     * Generate file from template
     * 
     * @param string $targetPath
     * @param string $targetFile
     * @param string $templateFile
     * @return void|string
     */
    private function _generateFileFromTemplate($targetPath, $targetFile, $templateFile)
    {
        GenitDebug::ShowMessage(__METHOD__);
        $config = $this->metaGen->config;
        $fullTargetFile = $targetPath . DIRECTORY_SEPARATOR . $targetFile;
        $fullTemplateFile = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . $templateFile;
        
        GenitDebug::ShowMessage($fullTargetFile);
        GenitDebug::ShowMessage($fullTemplateFile);
        
        GenitHelper::createDirectory($targetPath, TRUE);

        // create file
        if (file_exists($fullTargetFile)) {
            GenitCli::showMessage( "\t" . str_replace(MODULE_PATH, "", $fullTargetFile) . " exists and skipped." );
            return NULL;
        }

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("module_name", GenitHelper::getModuleName($config->getPackageName()));
        $smarty->assign_by_ref("module_title", $config->getModuleTitle());
        $smarty->assign_by_ref("module", $config->getPackageName());
        
        $smarty->assign_by_ref("full_comp_name", $this->getFullCompName());

        $content = $smarty->fetch($fullTemplateFile);

        file_put_contents( $fullTargetFile, $content );
        GenitCli::showMessage( "\t" . str_replace( MODULE_PATH, "", $fullTargetFile ) . " is generated." );
        return $fullTargetFile;
    }
    
    public function getFullDashboardViewName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getModule() . ".view.DashboardView";
        return $fullCompName;
    }

    public function getFullDashboardWidgetName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getModule() . ".widget.DashboardForm";
        return $fullCompName;
    }

    public function getFullLeftMenuWidgetName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getModule() . ".widget.LeftMenu";
        return $fullCompName;
    }
    
    public function getFullCompName()
    {
        return $this->_fullCompName;
    }
    
    public function setFullCompName($name)
    {
        $this->_fullCompName = $name;
    }
    

}