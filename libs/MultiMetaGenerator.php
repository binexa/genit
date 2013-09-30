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
 * Description of GlobalMetaGenerator
 *
 * @author k6
 */
class MultiMetaGenerator
{

    public $masterConfig;

    public function __construct($configName = null)
    {
        $this->masterConfig = $this->_loadConfig($configName);
    }

    private function _loadConfig($configName = null)
    {
        if ($configName == null) {
            $configName = "main";
        }

        $configLocation = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . $configName . '.php';
        return require($configLocation);
    }

    public function run($configName = null)
    {
        GenitDebug::$isDebug = TRUE;

        if (!$configName == NULL) {
            $this->masterConfig = $this->_loadConfig($configName);
        }

        foreach ($this->masterConfig as $value) {
            $db_name = null;
            $table_name = $value['tableName'];
            $package_name = null;
            $options = null;

            $metaGen = new MetaGenerator($package_name, $db_name, $table_name, $options);

            echo "======================================================\n";
            echo " Table Name : " . $metaGen->config->getTableName() . "\n";
            echo "======================================================\n";


            if ($metaGen->config->isGenerateDO()) {
                echo "\nGenerate Data Object metadata file ..." . PHP_EOL;
                echo "--------------------------------------" . PHP_EOL;
                $metaGen->generateDO();
            }

            if ($metaGen->config->isGenerateForm()) {
                echo "\nGenerate Form Object metadata files ..." . PHP_EOL;
                echo "---------------------------------------" . PHP_EOL;
                $metaGen->generateForm();
            }

            if ($metaGen->config->isGenerateView()) {
                echo "\nGenerate view Object metadata files ..." . PHP_EOL;
                echo "---------------------------------------" . PHP_EOL;
                $metaGen->genViewMeta();
            }

            if ($metaGen->config->isGenerateDashboard()) {
                echo "\nGenerate Module Dashboard ..." . PHP_EOL;
                echo "---------------------------------------" . PHP_EOL;
                $metaGen->genDashboardXML();
            }

            if ($metaGen->config->isGenerateMod()) {
                
                GenitDebug::ShowMessage("=======IS_GENERERATE_MOD========");
                
                $modFolder = GenitHelper::getModuleName(strtolower($metaGen->options[3]));
                //$package_directory = packageToPath($packageName)
                $modFile = $package_directory = MODULE_PATH . "/" . $modFolder . "/mod.xml";
                if (file_exists($modFile)) {
                    echo "\nModify mod.xml ..." . PHP_EOL;
                    echo "---------------------------------------" . PHP_EOL;
                    $metaGen->modifyMod();
                } else {
                    echo "\nGenerate mod.xml ..." . PHP_EOL;
                    echo "---------------------------------------" . PHP_EOL;
                    $metaGen->generateMod();
                }
            }
        }
    }

}

?>
