<?php
include_once dirname(__FILE__) . "/GenitCli.php";
include_once dirname(__FILE__) . "/GenitDebug.php";
include_once dirname(__FILE__) . "/GenitHelper.php";
include_once dirname(__FILE__) . "/GenitTableConfig.php";

// load interface
include_once dirname(__FILE__) . "/MetaGeneratorInterface.php";

// load base class
include_once dirname(__FILE__) . "/MetaGeneratorBase.php";
include_once dirname(__FILE__) . "/DOGeneratorAbstract.php";
include_once dirname(__FILE__) . "/FormGeneratorAbstract.php";
include_once dirname(__FILE__) . "/ViewGeneratorBase.php";
include_once dirname(__FILE__) . "/DashboardGeneratorBase.php";
include_once dirname(__FILE__) . "/ModGeneratorBase.php";

//include_once dirname(__FILE__) . "/MultiMetaGeneratorAbstract.php";
defined('GENIT_CONFIG_FIELD') or define('GENIT_CONFIG_FIELD', 'tableName');

class Genit
{
    public static $masterConfig;

    /**
     * Get directory of template file.
     * @return string
     */
    public static function getTemplateDirectory()
    {   
        return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'templates';
    }

    /**
     * Get directory of config file.
     * @return string
     */
    public static function getConfigDirectory()
    {
        return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'configs';
    }

    /**
     * Get master config file with full path
     * @param string $masterConfigName
     * @return string
     */
    public static function getMasterConfigFile($masterConfigName='main')
    {
        return self::getConfigDirectory() . DIRECTORY_SEPARATOR . $masterConfigName . '.php'; 
    }

    /**
     * Load master config file and store to local array.
     * @param string $masterConfigName
     */
    public static function loadMasterConfig($masterConfigName = 'main')
    {
        self::$masterConfig = require(self::getMasterConfigFile($masterConfigName));
    }

    /**
     * Run generator
     * 
     * @param string $masterConfigName
     */
    public static function run($masterConfigName = 'main')
    {
        GenitDebug::ShowMessage(__METHOD__);
        echo "==================================================================".PHP_EOL;
        echo "                S T A R T                                         ".PHP_EOL;
        echo "==================================================================".PHP_EOL;
     
        
        //echo GenitHelper::generatorNameToClassSufix("synfac_master");
        //echo PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;
        //exit;
        GenitDebug::$isDebug = false;

        self::loadMasterConfig();
        print_r(self::$masterConfig);
        //exit;
        foreach (self::$masterConfig as $masterConfigItem) {            
            echo "=========> $masterConfigItem <==========\n";
            $generator = self::getGenerator($masterConfigItem[GENIT_CONFIG_FIELD]);
            $generator->generate();
        }
    }

    /**
     * Factory get generator object
     * 
     * @param string $configName
     * @return MetaGeneratorBase
     */
    public static function getGenerator($configName)
    {
        GenitDebug::ShowMessage(__METHOD__);
        $config = new GenitTableConfig($configName);
        $generatorName = $config->getCodeGeneratorName();
        GenitDebug::ShowMessage($generatorName);
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);
        $metaGeneratorClass = self::getMetaGeneratorClass($classSufix);
        $generatorFIle = self::getGeneratorDirectory()
                . DIRECTORY_SEPARATOR . $generatorName
                . DIRECTORY_SEPARATOR . $metaGeneratorClass . '.php';
        
        GenitDebug::ShowMessage($generatorFIle);
        
        require_once $generatorFIle;
        
        $generator = new $metaGeneratorClass($config);
        return $generator;
    }

    /**
     * Get generator directory that contain list of code generator
     * @return type
     */
    public static function getGeneratorDirectory()
    {
        return dirname(__FILE__) .  '/generators' ;
    }    
    
    public static function getMetaGeneratorClass($sufix='')
    {
        return 'MetaGenerator'.$sufix;
    }
    
    public static function getDOGeneratorClass($sufix='')
    {
        return 'DOGenerator'.$sufix;
    }    
    
    public static function getDashboardGeneratorClass($sufix='')
    {
        return 'DashboardGenerator'.$sufix;
    }

    public static function getFormGeneratorClass($sufix='')
    {
        return 'FormGenerator'.$sufix;
    }
    
    public static function getModGeneratorClass($sufix='')
    {
        return 'ModGenerator'.$sufix;
    }
    
    public static function getViewGeneratorClass($sufix='')
    {
        return 'ViewGenerator'.$sufix;
    }
    
}

?>
