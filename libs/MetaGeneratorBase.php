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
 * MetaGenerator class
 *
 * MetaGenerator generate CRUD metadata and template from database table
 *
 * @package   cubi.bin.genit.libs
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @access    public
 */
class MetaGeneratorBase implements MetaGeneratorInterface
{
    //abstract public function run();

    /**
     * config object
     * @var GenitTableConfig
     */
    public $config;

    /**
     * database name alias in Config.xml
     * 
     * @var string
     */
    public $dbName;

    /**
     * table name
     * 
     * @var string
     */
    public $tableName;

    /**
     * Component name
     * 
     * @var string
     */
    public $compName;

    /**
     * Component description
     * @var string
     */
    public $compDesc;
    public $templateName;

    /**
     * option
     * @var array
     */
    public $options;
    public $isAutoGenerate;

    /**
     * Database information that stored in Config.xml
     * @var array
     */
    public $dbConfig;

    /**
     * Object that generate Data object metafile
     * @var DOGeneratorAbstract
     */
    public $doGen;

    /**
     * Object that generate Form object metafile
     * @var FormGeneratorAbstract
     */
    public $formGen;

    /**
     * Object that generate View object metafile
     * @var ViewGeneratorAbstract
     */
    public $viewGen;

    /**
     * Object that generate dashboard file
     * @var DashboardGeneratorBase
     */
    public $dashGen;

    /**
     * Object that generate mod file
     * @var ModGeneratorBase
     */
    public $modGen;

    /**
     * Object that generate mod file
     * @var ModGeneratorAbstract
     */
    public $dashboard_enable = 0;

    /**
     * Initialize object
     * @param string $packageName module name
     * @param string $dbName database name alias in configuration file
     * @param string $tableName database table name
     * @param array $options more option
     * @return void
     */
    function __construct($config)
    {
        $this->_loadConfig($config);
        $this->loadGenerators();
    }

    protected function _loadConfig($config)
    {
        $this->config = $config;
        
        /* 
            option[0] => path of package
            option[1] => component name
            option[2] => component description
            option[3] => package name
        
         * 
         */
        $this->options = $config->getOptions();
        $this->options['acl'] = $config->getAcl();
        $this->options['acl']['resource'] = $config->getBaseResource();

        GenitDebug::ShowMessage($this->options);
    }

    public function getDbConfig()
    {
        return BizSystem::configuration()->getDatabaseInfo($this->config->getDatabaseName());
    }

    /**
     * Generate DataObject metafile
     * @return string file name of data object metafile
     */
    public function generateDO()
    {
        echo "\nGenerate Data Object metadata file ..." . PHP_EOL;
        echo "--------------------------------------" . PHP_EOL;
        $this->doGen->generate();
    }

    /**
     * Generate Form metafile
     * @return array array that contain file name of Form object metafile
     */
    public function generateForm()
    {
        echo "\nGenerate Form Object metadata files ..." . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;

        if (!$this->doGen) {
            $this->loadDOGenerator();
        }

        if (!$this->formGen) {
            $this->loadFormGenerator();
        }
        $this->formGen->generate();
    }

    /**
     * Generate View object metafile
     * @return string file name of View object metafile
     */
    public function generateView()
    {
        echo "\nGenerate view Object metadata files ..." . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;


        if (!$this->formGen) {
            $this->loadDOGenerator();
            $this->loadFormGenerator();
        }

        if (!$this->viewGen) {
            $this->loadViewGenerator();
        }
        $this->viewGen->generate();
    }

    /**
     * Generate module information metafile
     * @return string file name of module metafile
     */
    public function generateMod()
    {
        echo "\nGenerate mod.xml ..." . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;

        if (!$this->modGen) {
            $this->loadModGenerator();
        }
        $this->modGen->generateMod();

    }

    public function modifyMod()
    {
        echo "\nModify mod.xml ..." . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;

        if (!$this->modGen) {
            $this->loadModGenerator();
        }
        $this->modGen->modifyMod();
    }

    /**
     * 
     */
    public function generateDashboard()
    {
        echo "\nGenerate Module Dashboard ..." . PHP_EOL;
        echo "---------------------------------------" . PHP_EOL;
        $this->dashboard_enable = 1;
        if (!$this->dashGen) {
            $this->loadDashboardGenerator();
        }
        $this->dashGen->generate();
    }

    /**
     * Get path of code gerator
     *    : genits/libs/generators/[dir-generator]
     * @return string
     */
    public function getGeneratorPath()
    {
        $generatorName = $this->config->getGeneratorName();
        $generatorPath = Genit::getGeneratorDirectory()
                . DIRECTORY_SEPARATOR . $generatorName;
        return $generatorPath;
    }

    /**
     * Get path of code gerator
     *    : genits/libs/generators/[dir-generator]
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->config->getTemplatePath();
    }

    public function getPackagePath()
    {
        return $this->config->getPackagePath();
    }

    /**
     * Load DO generator object and store in $this->formGen
     */
    public function loadDOGenerator()
    {
        $generatorName = $this->config->getCodeGeneratorName();        
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);       
        $doClassName = Genit::getDOGeneratorClass($classSufix);
        $doGeneratorFIle = $this->getGeneratorPath() . DIRECTORY_SEPARATOR . $doClassName . '.php';
        include_once $doGeneratorFIle;
        $this->doGen = new $doClassName($this);
    }

    /**
     * Load form generator object and store in $this->viewGen
     */
    public function loadFormGenerator()
    {
        $generatorName = $this->config->getCodeGeneratorName();        
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);
        $formGeneratorClassName = Genit::getFormGeneratorClass($classSufix);
        $formGeneratorFIle = $this->getGeneratorPath()
                . DIRECTORY_SEPARATOR . $formGeneratorClassName . '.php';
        include_once $formGeneratorFIle;
        $this->formGen = new $formGeneratorClassName($this);
    }

    /**
     * Load view generator object and store in $this->viewGen
     */
    public function loadViewGenerator()
    {
        $generatorName = $this->config->getCodeGeneratorName();        
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);        
        $viewGeneratorClassName = Genit::getViewGeneratorClass($classSufix);
        $viewGeneratorFIle = $this->getGeneratorPath()
                . DIRECTORY_SEPARATOR . $viewGeneratorClassName . '.php';
        include_once $viewGeneratorFIle;
        $this->viewGen = new $viewGeneratorClassName($this);
    }

    /**
     * Load dashboard generator object and store in $this->viewGen
     */
    public function loadDashboardGenerator()
    {
        $generatorName = $this->config->getCodeGeneratorName();        
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);        
        $dashboardGeneratorClassName = Genit::getDashboardGeneratorClass($classSufix);
        $dashboardGeneratorFIle = $this->getGeneratorPath()
                . DIRECTORY_SEPARATOR . $dashboardGeneratorClassName . '.php';
        include_once $dashboardGeneratorFIle;
        $this->dashGen = new $dashboardGeneratorClassName($this);
    }

    /**
     * Load dashboard generator object and store in $this->viewGen
     */
    public function loadModGenerator()
    {
        $generatorName = $this->config->getCodeGeneratorName();        
        $classSufix = GenitHelper::generatorNameToClassSufix($generatorName);        
        $modGeneratorClassName = Genit::getModGeneratorClass($classSufix);
        $modGeneratorFIle = $this->getGeneratorPath()
                . DIRECTORY_SEPARATOR . $modGeneratorClassName . '.php';
        include_once $modGeneratorFIle;
        $this->modGen = new $modGeneratorClassName($this);
    }

    public function loadGenerators()
    {
        $this->loadDOGenerator();
        $this->loadFormGenerator();
        $this->loadViewGenerator();
        $this->loadDashboardGenerator();
        $this->loadModGenerator();
    }

    public function generate()
    {
        echo "======================================================\n";
        echo " Table Name : " . $this->config->getTableName() . "\n";
        echo "======================================================\n";

        if ($this->config->isGenerateDO()) {
            $this->generateDO();
        }
        if ($this->config->isGenerateForm()) {
            $this->generateForm();
        }
        if ($this->config->isGenerateView()) {
            $this->generateView();
        }
        if ($this->config->isGenerateDashboard()) {
            $this->generateDashboard();
        }
        if ($this->config->isGenerateMod()) {
            $modFileWithPath = $this->getModulePath() . DIRECTORY_SEPARATOR . "mod.xml";
            if (file_exists($modFileWithPath)) {
                $this->modifyMod();
            } else {
                $this->generateMod();
            }
        }
    }

    public function getModulePath()
    {
        $modFolder = GenitHelper::getModuleName(strtolower($this->config->getModuleName()));
        return MODULE_PATH . DIRECTORY_SEPARATOR . $modFolder;
    }

}