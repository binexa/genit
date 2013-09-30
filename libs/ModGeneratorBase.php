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
 * ModGenerator class
 *
 * Generate module information metafile
 *
 * @package   cubi.bin.tools
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class ModGeneratorBase
{

    const MOD_TEMPLATE = "mod_Template.xml";
    const MOD_RESOURCE = "mod_Resource.xml";
    const MOD_ITEMMENU = "mod_ItemMenu.xml";

    /**
     *
     * @var MetaGeneratorBase
     */
    public $metaGen;
    public $dashboard_enable = 0;

    /**
     * Initialize
     * @param MetaGeneratorAbstract $metaGen
     */
    function __construct($metaGen)
    {
        $this->metaGen = $metaGen;
    }

    // TODO: modify current mod.xml, acl and menu
    /**
     * Generate module information (mod.xml)
     *
     * @param string $tableName table name
     * @return string
     */
    function generateMod()
    {
        GenitCli::showMessage("...Start generate mod.xml.");
        $config=  $this->metaGen->config;
        $packageName = $config->getPackageName();
        $moduleName = $this->metaGen->config->getModuleName();
        $destinationPath = MODULE_PATH . DIRECTORY_SEPARATOR . $moduleName;
        if (!file_exists($destinationPath)) {
            GenitCli::showMessage("Create directory $destinationPath");
            mkdir($destinationPath, 0777, true);
        }
        $compDesc = $this->metaGen->config->getComponentDesc();
        $compName = $this->metaGen->config->getComponentName();
        
        $listview_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_list";
        $listview_check_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_approve_list";

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("code_generator", $config->getCodeGeneratorName());

        $smarty->assign_by_ref("package_name", $packageName);
        $smarty->assign_by_ref("module_name", $moduleName);
        $smarty->assign_by_ref("module", $moduleName);
        $smarty->assign_by_ref("module_title", $this->metaGen->config->getModuleTitle());

        $smarty->assign_by_ref("comp_name", $compName);
        $smarty->assign_by_ref("comp_desc", $compDesc);
        
        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);

        $smarty->assign_by_ref("acl", $this->metaGen->options['acl']);
        $smarty->assign_by_ref("dashboard_enable", $config->isGenerateDashboard());

        $doGen = $this->metaGen->doGen;

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_external_changelog", $doGen->hasExternalChangelog());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());

        $templateFile = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . self::MOD_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file
        $destinationFile = $destinationPath . DIRECTORY_SEPARATOR ."mod.xml";
        file_put_contents($destinationFile, $content);
        
        GenitCli::showMessage( "\t" . str_replace(MODULE_PATH, "", $destinationFile) . " is generated." );
        
        return $destinationFile;
    }

    function modifyMod()
    {
        GenitCli::showMessage( "...Start modify mod.xml." );        
        $config=  $this->metaGen->config;
        $packageName = $config->getPackageName();
        $moduleName = $config->getModuleName();
        $destinationPath = MODULE_PATH . DIRECTORY_SEPARATOR . $moduleName;
        $destinationFile = $destinationPath . DIRECTORY_SEPARATOR ."mod.xml";

        $content = file_get_contents($destinationFile);
        
        $smarty = BizSystem::getSmartyTemplate();

        $compDesc = $this->metaGen->config->getComponentDesc();
        $compName = $this->metaGen->config->getComponentName();
        
        $listview_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_list";
        $listview_check_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $compDesc)) . "_approve_list";
        
        $smarty->assign_by_ref("code_generator", $config->getCodeGeneratorName());

        $smarty->assign_by_ref("package_name", $packageName);
        $smarty->assign_by_ref("module_name", $moduleName);
        $smarty->assign_by_ref("module", $moduleName);
        $smarty->assign_by_ref("module_title", $this->metaGen->config->getModuleTitle());

        $smarty->assign_by_ref("comp_name", $compName);
        $smarty->assign_by_ref("comp_desc", $compDesc);
        
        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);

        $smarty->assign_by_ref("acl", $this->metaGen->options['acl']);
        $smarty->assign_by_ref("dashboard_enable", $config->isGenerateDashboard());

        $doGen = $this->metaGen->doGen;

        // external content
        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        
        // workflow
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());

        //GenitDebug::ShowMessage('$this->metaGen->config->isGenerateUserAccess()'.$this->metaGen->config->isGenerateUserAccess());
        
        if ($this->metaGen->config->isGenerateUserAccess()) {
            $templateFile = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . self::MOD_RESOURCE;
            
            $str = $smarty->fetch($templateFile);
            //test if New ACL sections is exists
            $pattern = "/\<Resource Name=\"" . $this->metaGen->options['acl'][resource] . "\"\>/si";

            if (!preg_match($pattern, $content)) {
                //do append new sections
                $content = preg_replace("/(<\/ACL\>)/si", $str . "\n</ACL>", $content);
            }
        }

        GenitDebug::ShowMessage('$this->metaGen->config->isGenerateMenu()'.$config->isGenerateMenu());
        if ($config->isGenerateMenu()) {
            //generate MenuItems sections
            $templateFile = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . self::MOD_ITEMMENU;            
            
            $str = $smarty->fetch($templateFile);
            //test if New MenuItems is exists
            $pattern = "/\<MenuItem Name=\"" . ucwords($moduleName) . "\"\>/si";

            if (!preg_match($pattern, $content)) {
                //do append new sections
                $content = preg_replace("/\<\/MenuItem\>\s*?\<\/Menu\>/si", $str . "\n</MenuItem>\n\t</Menu>", $content);
            }
        }
        //save files
        file_put_contents($destinationFile, $content);
        GenitCli::showMessage( "\t" . str_replace(MODULE_PATH, "", $destinationFile) . " is modified." );
        return $destinationFile;
    }

}
