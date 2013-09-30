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
 * ModGenerator class
 *
 * Generate module information metafile
 *
 * @package   cubi.bin.tools
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class ModGenerator
{

    const MOD_TEMPLATE = "/mod_Template.xml";
    const MOD_RESOURCE = "/mod_Resource.xml";
    const MOD_ITEMMENU = "/mod_ItemMenu.xml";

    /**
     *
     * @var MetaGenerator 
     */
    public $metaGenerator;

    /**
     * Module name
     * @var string
     */
    public $package_name;
    public $options;
    public $dashboard_enable = 0;

    /**
     * Initialize
     *
     * @param string $package_name module name
     * @return void
     */
    function __construct($package_name, $options, $dashboard_enable = 0)
    {
        $this->package_name = $package_name;
        $this->options = $options;
        $this->dashboard_enable = $dashboard_enable;
    }

    // TODO: modify current mod.xml, acl and menu
    /**
     * Generate module information (mod.xml)
     *
     * @param string $table_name table name
     * @return string
     */
    function generateMod($table_name)
    {

        if (CLI) {
            echo "Start generate mod.xml." . PHP_EOL;
        }
        $module_name = GenitHelper::getModuleName($this->package_name);
        $targetPath = $moduleDir = MODULE_PATH . "/" . $module_name;
        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        $listview_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_list";
        $listview_check_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_approve_list";

        //$listview_uri = strtolower($this->opts[1]) . "_list";
        $module = $this->package_name;    //.".".$this->opts[1];
        $comp = $this->options[2];

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("module_name", $module_name);
        $smarty->assign_by_ref("module_title", $this->_getModuleTitle() );

        $smarty->assign_by_ref("module", $module);
        $smarty->assign_by_ref("comp", $comp);

        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);

        $smarty->assign_by_ref("acl", $this->options['acl']);
        $smarty->assign_by_ref("dashboard_enable", $this->dashboard_enable);

        $smarty->assign_by_ref("dashboard_enable", $this->dashboard_enable);

        $doGen = $this->metaGenerator->doGenerator;

        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());



        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::MOD_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file
        $targetFile = $targetPath . "/mod.xml";
        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL;
        }
        return $targetFile;
    }

    function modifyMod($table_name)
    {
        if (CLI) {
            echo "Start modify mod.xml." . PHP_EOL;
        }
        $module_name = GenitHelper::getModuleName($this->package_name);
        $targetFile = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->package_name) . "/mod.xml";

        $content = file_get_contents($targetFile);

        $smarty = BizSystem::getSmartyTemplate();

        $listview_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_list";
        $listview_check_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_check_list";
        $listview_approve_uri = strtolower(str_replace(" ", "_", $this->options[2])) . "_approve_list";
        //$listview_uri = strtolower(getSubModuleName($this->module)) . "_list";
        //$listview_uri = strtolower($this->opts[1]) . "_list";

        $module = $this->package_name;    //.".".$this->opts[1];
        $comp = $this->options[2];

        $smarty->assign_by_ref("module_name", $module_name);
        $smarty->assign_by_ref("module_title", $this->_getModuleTitle() );
        $smarty->assign_by_ref("module", $module);
        $smarty->assign_by_ref("comp", $comp);

        $smarty->assign_by_ref("listview_uri", $listview_uri);
        $smarty->assign_by_ref("listview_check_uri", $listview_check_uri);
        $smarty->assign_by_ref("listview_approve_uri", $listview_approve_uri);

        $smarty->assign_by_ref("acl", $this->options['acl']);

        $smarty->assign_by_ref("dashboard_enable", $this->dashboard_enable);

        $doGen = $this->metaGenerator->doGenerator;

        //print_r($doGen);
        echo "check :" . $doGen->hasCheckProcess() . "\n";
        echo "approve :" . $doGen->hasApproveProcess() . "\n";
        $smarty->assign_by_ref("has_external_attachment", $doGen->hasExternalAttachment());
        $smarty->assign_by_ref("has_external_picture", $doGen->hasExternalPicture());
        $smarty->assign_by_ref("has_check_process", $doGen->hasCheckProcess());
        $smarty->assign_by_ref("has_approve_process", $doGen->hasApproveProcess());

        //generate ACL sections
        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::MOD_RESOURCE;
        echo 'tpl_file:' . $templateFile . "\n";
        $str = $smarty->fetch($templateFile);
        //test if New ACL sections is exists
        $pattern = "/\<Resource Name=\"" . $this->options['acl'][resource] . "\"\>/si";

        if (!preg_match($pattern, $content)) {
            //do append new sections
            $content = preg_replace("/(<\/ACL\>)/si", $str . "\n</ACL>", $content);
        }

        //generate MenuItems sections
        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::MOD_ITEMMENU;
        $str = $smarty->fetch($templateFile);
        //test if New MenuItems is exists
        $pattern = "/\<MenuItem Name=\"" . ucwords($module) . "\"\>/si";

        if (!preg_match($pattern, $content)) {
            //do append new sections
            $content = preg_replace("/\<\/MenuItem\>\s*?\<\/Menu\>/si", $str . "\n</MenuItem>\n\t</Menu>", $content);
        }

        //save files
        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is modified." . PHP_EOL;
        }
        return $targetFile;
    }

    private function _getModuleTitle()
    {
        $moduleTitle = null;
        if (isset($this->metaGenerator->config['moduleTitle'])) {
            
            $moduleTitle = $this->metaGenerator->config['moduleTitle'];
            echo "MODULE-TITLE ada";
        } else {
            echo "MODULE-TITLE TIDAK ada";
            $moduleTitle = GenitHelper::capitalize( GenitHelper::getModuleName($this->package_name) );
        }
        echo ' MODULE TITLE : '.$moduleTitle;
        return $moduleTitle;
        
    }

}
