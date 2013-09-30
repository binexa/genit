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
 * DashboardGenerator class
 *
 * MetaGenerator generate module Dashboard
 *
 * @package   cubi.bin.tools.lib
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class DashboardGenerator {

    const DASHBOARD_TEMPLATE = "/dashboard_Template.xml";
    const DASHBOARDVIEW_TEMPLATE = "/dashboard_view_Template.xml";
    const LEFTMENU_TEMPLATE = "/leftmenu_Template.xml";

    /**
     *
     * @var MetaGenerator 
     */
    public $metaGenerator;

    /**
     * Module name
     * @var string
     */
    public $packageName;
    public $options;

    /**
     * Initialize
     *
     * @param string $packageName module name
     * @return void
     */
    function __construct($packageName, $options) {
        $this->packageName = $packageName;
        $this->options = $options;
    }

    public function generateDashboardWidget($table) {
        if (CLI) {
            echo "Start generate DashboardForm.xml ." . PHP_EOL;
        }
        $targetPath = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->packageName) . "/widget";
        $targetFile = $targetPath . "/DashboardForm.xml";

        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        if (file_exists($targetFile)) {
            if (CLI) {
                echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " exists skipped." . PHP_EOL . PHP_EOL;
            }
            return;
        }

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("module_name", GenitHelper::getModuleName($this->packageName));
        $smarty->assign_by_ref("module", $this->packageName);

        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::DASHBOARD_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file        
        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL . PHP_EOL;
        }
        return $targetFile;
    }

    /**
     * Generate Dashboard View
     * 
     * @param string $table
     * @return string
     */
    public function generateDashboardView($table) {
        if (CLI) {
            echo "Start generate DashboardView.xml ." . PHP_EOL;
        }
        $targetPath = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->packageName) . "/view";
        $targetFile = $targetPath . "/DashboardView.xml";
        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        if (file_exists($targetFile)) {
            if (CLI) {
                echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " exists and skipped." . PHP_EOL . PHP_EOL;
            }
            return;
        }

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("module_name", GenitHelper::getModuleName($this->packageName));
        $smarty->assign_by_ref("module", $this->packageName);

        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::DASHBOARDVIEW_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file        
        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL . PHP_EOL;
        }
        return $targetFile;
    }

    public function generateLeftmenu($table) {
        if (CLI) {
            echo "Start generate LeftMenu.xml ." . PHP_EOL;
        }
        $targetPath = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->packageName) . "/widget";
        $targetFile = $targetPath . "/LeftMenu.xml";
        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        if (file_exists($targetFile)) {
            if (CLI) {
                echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " exists and skipped." . PHP_EOL . PHP_EOL;
            }
            return;
        }

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("module_name", GenitHelper::getModuleName($this->packageName));
        $smarty->assign_by_ref("module", $this->packageName);

        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::LEFTMENU_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file

        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL . PHP_EOL;
        }
        return $targetFile;
    }

    public function modifyViewTpl() {
        if (CLI) {
            echo "Start modify view.tpl to enable module left menu supports ." . PHP_EOL;
        }
        $targetPath = $moduleDir = MODULE_PATH . "/" . GenitHelper::getModuleName($this->packageName) . "/template";
        $targetFile = $targetPath . "/view.tpl";

        $str = '
$left_menu = "' . strtolower(GenitHelper::getModuleName($this->packageName)) . '.widget.LeftMenu";
$this->assign("left_menu", $left_menu);
';

        $content = file_get_contents($targetFile);
        if (!preg_match("/widget\.LeftMenu/si", $content)) {
            $content = str_replace("{php}", "{php}" . $str, $content);
        } else {
            if (CLI) {
                echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " was modified and skipped." . PHP_EOL . PHP_EOL;
            }
            return;
        }


        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is modified." . PHP_EOL . PHP_EOL;
        }
        return $targetFile;
    }

    public function generateFiles($table) {
        $this->generateDashboardWidget($table);
        $this->generateDashboardView($table);
        $this->generateLeftmenu($table);
        $this->modifyViewTpl($table);
    }

}


?>
