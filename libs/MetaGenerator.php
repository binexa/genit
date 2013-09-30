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
 * MetaGenerator class
 *
 * MetaGenerator generate CRUD metadata and template from database table
 *
 * @package   cubi.bin.tools.lib
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class MetaGenerator {

    /**
     * array of config
     * @var array
     */
    public $config;
    /**
     * Package name
     *    example module.package.name
     *    <pre>
     *          module.package.name
     *    </pre>
     * 
     * @var string
     */
    public $packageName;

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

    
    public $templateDir;
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
     * @var DOGenerator
     */
    public $doGenerator;

    /**
     * Object that generate Form object metafile
     * @var FormGenerator
     */
    public $formGen;

    /**
     * Object that generate View object metafile
     * @var ViewGenerator
     */
    public $viewGen;
    public $acl;
    public $dashboard_enable = 0;

    /**
     * Initialize object
     * @param string $packageName module name
     * @param string $dbName database name alias in configuration file
     * @param string $tableName database table name
     * @param array $options more option
     * @return void
     */
    function __construct($packageName = null, $dbName = null, $tableName, $options = null) {

        $this->dbConfig = BizSystem::configuration()->getDatabaseInfo($dbName);
        $this->config = $this->_loadConfig($tableName);
                
               
        $this->packageName = $this->config['packageName'];
        $this->dbName = $this->config['dbName'];
        $this->tableName = $this->config['tableName'];
        
        $this->compName = $this->config['compName'];
        $this->compDesc = $this->config['compDesc'];
        $this->templateDir = $this->config['templateDir'];
        $this->isAutoGenerate = $this->config['isAutoGenerate'];

        // $opt[0] : package/module path (module/path/path
        $opt[0] = packageToPath($packageName);
        
        // $opt[1] : base Object name
        $opt[1] = $this->compName;
        
        //$opt[2] : module name / base Object description<br />
        $opt[2] = $this->compDesc;
        
        // $opt[3] : package/module name (module-name.path.path)
        $opt[3] = $this->packageName;

        $this->options = $opt;
    }

    private function _loadConfig($tableName) {
        $configLocation = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . $tableName . '.php';
        return require($configLocation);
    }

    /**
     * Generate DataObject metafile
     * @return string file name of data object metafile
     */
    public function genDOMeta() {
        $this->doGenerator = new DOGenerator($this->packageName, $this->dbName, $this->tableName, $this->dbConfig, $this->options);
        $this->doGenerator->metaGenerator = $this;
        $this->doGenerator->prepareData();
        $doFile = $this->doGenerator->generateAllDOs();

        return $doFile;
    }

    /**
     * Generate Form metafile
     * @return array array that contain file name of Form object metafile
     */
    public function genFormMeta() {
        if (!$this->doGenerator) {
            $this->doGenerator = new DOGenerator($this->packageName, $this->dbName, $this->tableName, $this->dbConfig, $this->options);
            $this->doGenerator->prepareData();
        }
        $this->formGen = new FormGenerator($this->packageName, $this->doGenerator, $this->options);
        $this->formGen->metaGenerator = $this;
        $formFiles = $this->formGen->generateAllForms();
        return $formFiles;
    }

    /**
     * Generate View object metafile
     * @return string file name of View object metafile
     */
    public function genViewMeta() {
        if (!$this->formGen) {
            $this->doGenerator = new DOGenerator($this->packageName, $this->dbName, $this->tableName, $this->dbConfig, $this->options);
            $this->doGenerator->metaGenerator = $this;
            $this->doGenerator->prepareData();
            $this->formGen = new FormGenerator($this->packageName, $this->doGenerator, $this->options);
        }
        $viewGen = new ViewGenerator($this->packageName, $this->formGen, $this->options);
        $viewGen->metaGenerator = $this;
        $viewFile = $viewGen->generateAllViews();
        return $viewFile;
    }

    /**
     * Generate module information metafile
     * @return string file name of module metafile
     */
    public function genModXML() {
        $modGen = new ModGenerator($this->packageName, $this->options, $this->dashboard_enable);
        $modGen->metaGenerator = $this;
        $modFile = $modGen->generateMod($this->tableName);
        return $modFile;
    }

    public function modifyModXML() {
        $modGen = new ModGenerator($this->packageName, $this->options, $this->dashboard_enable);
        $modGen->metaGenerator = $this;
        $modFile = $modGen->modifyMod($this->tableName);
        return $modFile;
    }

    public function genDashboardXML() {
        $this->dashboard_enable = 1;
        $modGen = new DashboardGenerator($this->packageName, $this->options);
        $modGen->metaGenerator = $this;
        $modFile = $modGen->generateFiles($this->tableName);
        return $modFile;
    }

    public function setACL($acl) {
        $resource = strtolower($this->options[3]); // strtolower($this->opts[3]).'.'.strtolower($this->opts[1]);
        switch ($acl) {
            case 1:
                $this->options['acl'] = array(
                    'access' => $resource . '.Access',
                    'manage' => $resource . '.Manage',
                    'create' => $resource . '.Manage',
                    'update' => $resource . '.Manage',
                    'delete' => $resource . '.Manage',
                    'check' => $resource . '.Check',
                    'approve' => $resource . '.Approve'
                );
                break;
            case 2:
                $this->options['acl'] = array(
                    'access' => $resource . '.Access',
                    'manage' => $resource . '.Manage',
                    'create' => $resource . '.Create',
                    'update' => $resource . '.Update',
                    'delete' => $resource . '.Delete',
                    'check' => $resource . '.Check',
                    'approve' => $resource . '.Approve'
                );
                break;
            case 3:
                $this->options['acl']['resource'] = '';
                $this->options['acl'] = array(
                    'access' => '',
                    'manage' => '',
                    'create' => '',
                    'update' => '',
                    'delete' => '',
                    'check' => '',
                    'approve' => ''
                );
                break;
        }
        $this->options['acl']['option'] = $acl;
        $this->options['acl']['resource'] = $resource;
    }
    
    
    public function getFieldLabel($fieldName) {
        $labelFromConfig = false;
        if ( isset($this->config['fieldLabel']) ) {
            if ( isset($this->config['fieldLabel'][$fieldName]) ) {
                $label = $this->config['fieldLabel'][$fieldName];
                $labelFromConfig = true;
            }
        }
        
        if (!$labelFromConfig) {
            $label = str_replace('_', ' ', $fieldName);
            $label = str_u;
        }
    }

}

?>
