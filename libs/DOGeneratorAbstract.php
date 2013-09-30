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
 * DOGenerator class
 *
 * Generate DataObject (DO) metafile
 *
 * @package   cubi.bin.genit
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @access    public
 */
abstract class DOGeneratorAbstract
//implements DOGeneratorInterface
{

    abstract public function generate();

    //const DO_TEMPLATE = "/d_Template.xml";

    /**
     *
     * @var MetaGenerator
     */
    public $metaGen;

    /**
     * DataObject name with "do" namespace/package
     *    set by turunan
     * @var string
     */
    public $doName;
    public $id_identity;
    public $searchRule;
    public $sortRule;
    // internal
    protected $_tableIndex;
    protected $_uniqueness;
    protected $_fields = array();
    protected $_fieldsDisplay = array();
    protected $_isDataPrepared = false;

    /**
     * Initialize Object
     * @param MetaGenerator $metaGen
     */
    public function __construct($metaGen)
    {
        $this->metaGen = $metaGen;
        $config = $metaGen->config;
        $this->searchRule = '';
        $this->_isDataPrepared = false;
        $this->prepareData();
    }

    /**
     * Prepare Data
     * 
     * @return void
     */
    public function prepareData()
    {
        $config = $this->metaGen->config;
        $db = BizSystem::dbConnection($config->getDatabaseName());
        if (!$db)
        {
            GenitCli::showMessage("ERROR: Cannot connect to database " . $config->getDatabaseName());
            exit;
        }
        $this->_loadTableIndexAndUniqueness();
        $this->_loadDOFields();
        $this->_isDataPrepared = true;
    }

    /**
     * 
     */
    public function generateNoJoinDO()
    {
        $this->generateDO($this->getTemplateFileNameNoJoin());
    }

    /**
     * Generate single DataObject metafile
     * @return string
     */
    public function generateDO($templateFile = NULL)
    {
        if ($templateFile == NULL)
        {
            $templateFileName = self::getTemplateFileName();
        }
        /* @var $config GenitTableConfig */
        $config = $this->metaGen->config;

        GenitCli::showMessage("Start generate dataobject $this->doName.");

        $templateFile = $this->metaGen->getTemplatePath() . DIRECTORY_SEPARATOR . $templateFileName;
        $targetPath = $config->getPathOfPackage() . DIRECTORY_SEPARATOR . "do";

        // target file
        $targetFile = $targetPath . DIRECTORY_SEPARATOR . $this->doName . ".xml";

        if (!file_exists($targetPath))
        {
            GenitCli::showMessage("Create directory $targetPath");
            mkdir($targetPath, 0777, true);
        }

        $searchRule = $config->getSearchRule();


        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("code_generator", $config->getCodeGeneratorName());

        $smarty->assign_by_ref("do_name", $this->doName);
        //$smarty->assign_by_ref("do_short_name", $this->do_short_name);
        $smarty->assign_by_ref("comp", $config->getPackageName());

        $smarty->assign_by_ref("full_comp_name", $this->getFullCompName()); //dep

        $smarty->assign_by_ref("db_name", $config->getDatabaseName());
        $smarty->assign_by_ref("table_name", $config->getTableName());
        $smarty->assign_by_ref("fields", $this->getFields());
        $smarty->assign_by_ref("uniqueness", $this->getUniqueness());

        $hasIdIdentity = $this->metaGen->doGen->id_identity;
        if ($hasIdIdentity) {
            $idGeneration = 'Identity';
        } else {
            $idGeneration = $config->getIdGeneration();
            if ($idGeneration!='') {
                $hasIdIdentity = true;
            } else {
                $hasIdIdentity = false;
            }
        }

        $smarty->assign_by_ref("id_identity", $hasIdIdentity);
        $smarty->assign_by_ref("id_generation", $idGeneration);

        //$smarty->assign_by_ref("id_identity", $this->id_identity);

        $smarty->assign_by_ref("sort_rule", $this->sortRule);
        $smarty->assign_by_ref("search_rule", $searchRule);
        //$otherSqlRule = $config->getOtherSqlRule();
        $smarty->assign_by_ref("other_sql_rule", $config->getOtherSqlRule());

        $smarty->assign_by_ref("acl", $this->metaGen->options['acl']);

        $joins = $this->metaGen->config->getJoinList();
        $smarty->assign_by_ref("joins", $joins);
        $fieldsJoin = $this->metaGen->config->getFieldsJoin();
        $smarty->assign_by_ref("fields_join", $fieldsJoin);

        $smarty->assign_by_ref("refDO", $this->metaGen->config->getDoReferenceList());

        $smarty->assign_by_ref("eventObservers", $this->metaGen->config->getDoEvents());

        $content = $smarty->fetch($templateFile);
        file_put_contents($targetFile, $content);

        GenitCli::showMessage("\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated.");

        return $targetFile;
    }

    /**
     * Load DataObject Fields and stored in $this->fields
     *
     * @return void
     */
    protected function _loadDOFields()
    {
        $this->_loadDOPrimaryFields();
        $this->_loadDOJoinFields();
        $this->_loadDOExprFields();
       // echo '<pre>';
       // print_r($this->_fields);
    }

    /**
     * Load DataObject display fields 
     *
     * @return void
     */
    protected function _loadDOFieldsDisplay()
    {

        $config = $this->metaGen->config;
        $fieldsDisplayConfig = $config->getFieldDisplay();
        $fieldsDisplay = array();
        foreach ($fieldsDisplayConfig as $fieldName => $fieldStatus)
        {
            if ($fieldStatus == true)
            {
                $fieldsDisplay[$fieldName] = $this->_fields[$fieldName];
            }
        }

        $this->_fieldsDisplay = $fieldsDisplay;
    }

    /**
     * Load DataObject Fields and stored in $this->fields
     *
     * @return void
     */
    protected function _loadDOPrimaryFields()
    {
        GenitDebug::ShowMessage(__METHOD__);
        $config = $this->metaGen->config;
        $db = BizSystem::dbConnection($config->getDatabaseName());
        $tableColumns = $db->describeTable($config->getTableName());

        //echo '<pre>';
        //print_r($tableColumns);
        //exit;

        $i = 0;
        if (is_array($tableColumns["sort_order"]))
        {
            $this->sortRule = "sort_order";
        }

        $fields = array();
        foreach ($tableColumns as $fieldName => $columnAttributs)
        {
            $fieldInfo = $this->_getFieldInfo($fieldName, $columnAttributs);
            $fieldInfo['join'] = NULL;
            $fields[$i] = $fieldInfo;
            $i++;
        }

        $this->_fields = array_merge($this->_fields, $fields);
        
    }

    protected function _loadDOJoinFields()
    {
        /* @var $config GenitTableConfig */
        $config = $this->metaGen->config;

        $fieldsJoin = $config->getFieldsJoin();

        if (!$fieldsJoin)
            return;

        // read primary table column
        $db = BizSystem::dbConnection($config->getDatabaseName());

        $fields = array();
        $i = 0;

        foreach ($fieldsJoin as $fieldJoinValue)
        {
            //print_r($fieldJoinValue);            
            $joinName = $fieldJoinValue['join'];
            $fieldName = $fieldJoinValue['name'];
            $columnName = $fieldJoinValue['column'];
            //if (isset($fieldJoinValue['sqlExpr']))
            $sqlExpr = $fieldJoinValue['sqlExpr'];

            $join = $config->getJoin($joinName);
            //print_r($join);
            //continue;
            $tableName = $join['tableName'];
            $tableColumns = $db->describeTable($tableName);
            //echo "<pre>";
            //print_r($tableColumns);
            //exit;

            $columnAttributs = $tableColumns[$columnName];

            if ($columnName)
            {
                $fieldInfo = $this->_getFieldInfo($columnName, $columnAttributs);
            } else
            {
                $fieldInfo = $this->_getFieldInfo($fieldName, $columnAttributs);
            }
            $fieldInfo['join'] = $joinName;
            $fieldInfo['name'] = $fieldName;
            $fieldInfo['label'] = $config->getFieldLabel($fieldName);
            $fieldInfo['sqlExpr'] = $sqlExpr;

            if ($fieldName='arrival_datetime'||$fieldName=='ma_datetime') {
                     // print_r($fieldInfo);
                    //exit;
            }

            $fields[$i] = $fieldInfo;


            $i++;
        }
        //echo '<pre>';
        //print_r($fields);
        //exit;
        $this->_fields = array_merge($this->_fields, $fields);
    }

    protected function _loadDOExprFields()
    {
        /* @var $config GenitTableConfig */
        $config = $this->metaGen->config;

        $fieldsExpr = $config->getFieldsExpr();

        if (!$fieldsExpr)
            return;

        $fields = array();
        $i = 0;

        foreach ($fieldsExpr as $fieldExprValue)
        {
            //print_r($fieldJoinValue);            
            $fieldName = $fieldExprValue['name'];
            //$columnName = $fieldExprValue['column'];
            //if (isset($fieldJoinValue['sqlExpr']))
            $sqlExpr = $fieldExprValue['sqlExpr'];

            $fieldInfo = array();
            $fieldInfo['join'] = $joinName;
            $fieldInfo['name'] = $fieldName;
            $fieldInfo['label'] = $config->getFieldLabel($fieldName);
            $fieldInfo['sqlExpr'] = $sqlExpr;

            $fieldInfo['lov'] = $config->getFieldLOV($fieldName);
            $fieldInfo['format'] = $config->getFieldFormat($fieldName);
            $fieldInfo['label'] = $config->getFieldLabel($fieldName);
            $fieldInfo['description'] = $config->getFieldDescription($fieldName);
            $fieldInfo['event'] = $config->getFieldEvent($fieldName);
            $fieldInfo['elementSet'] = $config->getFieldElementSet($fieldName);
            $fieldInfo['tabSet'] = $config->getFieldTabSet($fieldName);
            $fieldInfo['cssClass'] = $config->getFieldCssClass($fieldName);
            $fieldInfo['onList'] = $config->isFieldOnList($fieldName);
            $fieldInfo['onSearch'] = $config->isFieldOnSearch($fieldName);
            $fieldInfo['default'] = $config->getFieldDefaultValue($fieldName);

            if ($fieldInfo['default'] == NULL)
            {
                if (!isset($fieldInfo['default']) && $fieldName == 'name')
                {
                    $fieldInfo['default'] = "New " . $config->getComponentName();
                }
            }
            if ($fieldInfo['onSearch'])
            {
                GenitDebug::ShowMessage($fieldInfo);
            }

            $fields[$i] = $fieldInfo;

            $i++;
        }

        $this->_fields = array_merge($this->_fields, $fields);
    }

    /**
     * Get field information
     * 
     * @param string $fieldName
     * @param array $columnAttributs
     * @return array
     */
    protected function _getFieldInfo($fieldName, $columnAttributs)
    {
        $config = $this->metaGen->config;
        $dbConfig = $config->getDbConfig();

        $fieldInfo = array();
        // special handling on the primary key column(s)
        // for simple, just consider simple primary key case
        if ($columnAttributs['PRIMARY'] == true)
        {
            $fieldInfo['name'] = 'Id';
            //$this->do['id_identity'] = $columnAttributs['IDENTITY'];
            if ($columnAttributs['IDENTITY'] == true)
            {
                $this->id_identity = true;
            } else
            {
                $this->id_identity = false;
            }
            //$this->id_identity = true;
        } else
        {
            $fieldInfo['name'] = $fieldName;
        }

        $fieldInfo['col'] = $fieldName;
        $fieldInfo['nullable'] = $columnAttributs['NULLABLE'];
        $fieldInfo['length'] = $columnAttributs['LENGTH'];

        // different db engine has different type name, but need to convert them to DO types.
        $fieldInfo['type'] = GenitHelper::convertDataType($columnAttributs['DATA_TYPE'], $dbConfig['Driver']);

        //if ($this->metaGen->config['fieldLabel'][''])
        //$fields[$i]['element'] = GenitHelper::getDataElement($colAttrs['DATA_TYPE'], $db_config['Driver']);
        $fieldInfo['element'] = $this->_getFieldElement($fieldName, $columnAttributs['DATA_TYPE'], $dbConfig['Driver']);
        $fieldInfo['lov'] = $config->getFieldLOV($fieldName);
        $fieldInfo['valuePicker'] = $config->getFieldValuePicker($fieldName);
        $fieldInfo['pickerMap'] = $config->getFieldPickerMap($fieldName);        

        $fieldInfo['format'] = $config->getFieldFormat($fieldName);
        $fieldInfo['label'] = $config->getFieldLabel($fieldName);
        $fieldInfo['description'] = $config->getFieldDescription($fieldName);

        $fieldInfo['enabled'] = $config->getFieldEnabled($fieldName);
        $fieldInfo['hidden']  = $config->getFieldHidden($fieldName);
        $fieldInfo['event'] = $config->getFieldEvent($fieldName);

        $fieldInfo['elementSet'] = $config->getFieldElementSet($fieldName);
        $fieldInfo['tabSet'] = $config->getFieldTabSet($fieldName);
        $fieldInfo['cssClass'] = $config->getFieldCssClass($fieldName);

        $fieldInfo['onList'] = $config->isFieldOnList($fieldName);

        $fieldInfo['onSearch'] = $config->isFieldOnSearch($fieldName);

        $fieldInfo['options'] = GenitHelper::getDataOptions($columnAttributs['DATA_TYPE'], $dbConfig['Driver']);

        $fieldInfo['raw_type'] = $columnAttributs['DATA_TYPE'];

        $fieldInfo['default'] = $config->getFieldDefaultValue($fieldName);

        if ($fieldInfo['default'] == NULL)
        {
            if ($columnAttributs['DEFAULT'] != "CURRENT_TIMESTAMP")
            {
                $fieldInfo['default'] = $columnAttributs['DEFAULT'];
            }

            if (!isset($fieldInfo['default']) && $fieldName == 'name')
            {
                $fieldInfo['default'] = "New " . $config->getComponentName();
            }
        }
        if ($fieldInfo['onSearch'])
        {
            GenitDebug::ShowMessage($fieldInfo);
        }

        /*
        if ($fieldName=='ma_datetime') {
            echo "<pre>".__LINE__;
            print_r($fieldInfo);
            exit;
        }
        */
        return $fieldInfo;
    }

    /**
     * Load table index and uniqueness information
     * @return void
     */
    protected function _loadTableIndexAndUniqueness()
    {
        $config = $this->metaGen->config;

        $db = BizSystem::dbConnection($config->getDatabaseName());
        $db_driver = $this->dbConfig['Driver'];
        switch (strtoupper($db_driver))
        {
            case 'PDO_MYSQL':
                $sql = "SHOW INDEX FROM " . $this->dbConfig["DBName"] . "." . $config->getTableName() . ";";
                $result = $db->query($sql);
                $tblIndexes = $result->fetchAll();
                break;
            default:
                break;
        }
        $tableIndex = array();
        if ($tblIndexes)
        {
            foreach ($tblIndexes as $colIndex)
            {
                $non_unique = $colIndex[1];
                $key_name = $colIndex[2];
                $col_name = $colIndex[4];
                if ($key_name != "PRIMARY" && $tblCols[$col_name]['DATA_TYPE'] != 'int')
                {
                    //$tableIndex[$key_name]=array();
                    $indexInfo = array("NON_UNIQUE" => $non_unique,
                        "KEY_NAME" => $key_name,
                        "COL_NAME" => $col_name);
                    if (!is_array($tableIndex[$key_name]))
                    {
                        $tableIndex[$key_name] = array();
                    }
                    array_push($tableIndex[$key_name], $indexInfo);
                }
            }
        }
        $this->_tableIndex = $tableIndex;

        $uniqueness = "";
        foreach ($tableIndex as $key_name => $key_index)
        {
            $key_uniqueness = "";
            foreach ($key_index as $indexInfo)
            {
                if ($indexInfo['NON_UNIQUE'] == "0")
                {
                    if ($key_uniqueness != "")
                    {
                        $key_uniqueness.=",";
                    }
                    $key_uniqueness .= $indexInfo['COL_NAME'];
                }
            }
            if ($key_uniqueness != "")
            {
                $uniqueness .= $key_uniqueness . ";";
            }
        }
        $this->_uniqueness = $uniqueness;
    }

    /**
     *
     * @return boolean
     */
    public function hasExternalAttachment()
    {
        $hasExternalAttachment = false;
        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->_fields as $fieldValue)
        {
            if ($fieldValue['name'] == 'external_attachment')
            {
                $hasExternalAttachment = true;
                break 1;
            }
        }
        return $hasExternalAttachment;
    }

    /**
     *
     * @return boolean
     */
    public function hasExternalPicture()
    {
        $hasExternalPicture = false;
        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->_fields as $fieldValue)
        {
            if ($fieldValue['name'] == 'external_attachment')
            {
                $hasExternalPicture = true;
                break 1;
            }
        }
        return $hasExternalPicture;
    }

    /**
     *
     * @return boolean
     */
    public function hasExternalChangelog()
    {
        $hasExternalChangelog = false;
        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->_fields as $fieldValue)
        {
            if ($fieldValue['name'] == 'external_changelog')
            {
                $hasExternalChangelog = true;
                break 1;
            }
        }
        return $hasExternalChangelog;
    }

    /**
     *
     * @return boolean
     */
    public function hasCheckProcess()
    {
        $hasCheckProcess = false;

        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->_fields as $fieldValue)
        {
            if ($fieldValue['name'] == 'is_checked')
            {
                $hasCheckProcess = true;
                break 1;
            }
        }

        return $hasCheckProcess;
    }

    /**
     *
     * @return boolean
     */
    public function hasApproveProcess()
    {
        $hasAproveProcess = false;
        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->_fields as $fieldValue)
        {
            if ($fieldValue['name'] == 'is_approved')
            {
                $hasAproveProcess = true;
                break 1;
            }
        }
        return $hasAproveProcess;
    }

    /**
     * Get field element depend database and data type
     * 
     * @param string $fieldName
     * @param string $dataType
     * @param string $dbDriver
     * @return Ambigous <string, multitype:, NULL, unknown>
     */
    protected function _getFieldElement($fieldName, $dataType, $dbDriver)
    {
        $element = $this->metaGen->config->getFieldElement($fieldName);
        if ($element == "" || $element == NULL)
        {
            $element = GenitHelper::getDataElement($dataType, $dbDriver);
        }
        GenitDebug::ShowMessage(__METHOD__ . " [$fieldName . $dataType . $dbDriver]: " . $element);
        return $element;
    }

    public function getFields()
    {
        if (!$this->_fields)
        {
            $this->_loadDOFields();
        }
        return $this->_fields;
    }

    public function getField($fieldName)
    {
        if (!$this->_fields)
        {
            $this->_loadDOFields();
        }
        //echo __METHOD__.PHP_EOL;
        //print_r($this->_fields);

        foreach ($this->_fields as $key => $field)
        {
            if ($field['name'] == $fieldName)
            {
                return $field;
            }
        }
        return null;
    }

    public function getListFields()
    {
        //echo __METHOD__.PHP_EOL;
        $config = $this->metaGen->config;
        $fields = $this->getFields();

        $fieldsOnList = $config->getFieldsOnList();

        //print_r($fieldsOnList);
        //exit;
        if ($fieldsOnList == NULL)
        {
            $fieldsOnList = $config->getFieldsDisplay();
        }

        if ($fieldsOnList != NULL)
        {
            $listFields = array();
            foreach ($fieldsOnList as $fieldName => $value)
            {
                //echo $fieldName . PHP_EOL;
                $fieldData = $this->getField($fieldName);
                if ($fieldData != null)
                {
                    //echo "field data $fieldName ada \n";
                    $listFields[] = $fieldData;
                }
            }
            //echo "listFields \n";
            //print_r($listFields);
            //exit;
            return $listFields;
        } else
        {
            return $fields;
        }
    }

    public function getEditFields()
    {
        $config = $this->metaGen->config;
        $fields = $this->getFields();

        $fieldsOnEdit = $config->getFieldsOnEdit();
        if ($fieldsOnEdit == NULL)
        {
            $fieldsOnEdit = $config->getFieldsDisplay();
        }

        if ($fieldsOnEdit != NULL)
        {
            $editFields = array();
            foreach ($fieldsOnEdit as $fieldName => $value)
            {
                $fieldData = $this->getField($fieldName);
                //if ($fieldName=='arrival_datetime'||$fieldName=='ma_datetime') {
                    //echo '<pre>';
                    //print_r($fieldData);
                    //exit;
                //}
                if ($fieldData != null)
                {
                    $editFields[] = $fieldData;
                }
            }
            return $editFields;
        } else
        {
            return $fields;
        }
    }

    public function getDetailFields()
    {
        $config = $this->metaGen->config;
        $fields = $this->getFields();

        $fieldsOnDetail = $config->getFieldsOnDetail();
        if ($fieldsOnDetail == NULL)
        {
            $fieldsOnDetail = $config->getFieldsDisplay();
        }

        if ($fieldsOnDetail != NULL)
        {
            $detailFields = array();
            foreach ($fieldsOnDetail as $fieldName => $value)
            {
                $fieldData = $this->getField($fieldName);
                if ($fieldData != null)
                {
                    $detailFields[] = $fieldData;
                }
            }
            return $detailFields;
        } else
        {
            return $fields;
        }
    }

    /**
     * Get Index information of table
     * @return type
     */
    public function getTableIndex()
    {
        if (!$this->_tableIndex)
            $this->_loadTableIndexAndUniqueness();

        return $this->_tableIndex;
    }

    /**
     * Get uniqueness info of table;
     * @return type
     */
    public function getUniqueness()
    {
        if (!$this->_uniqueness)
        {
            $this->_loadTableIndexAndUniqueness();
        }
        return $this->_uniqueness;
    }

    public function getTemplateFileName()
    {
        return "d_Template.xml";
    }

    public function getTemplateFileNameNoJoin()
    {
        return "d_TemplateNoJoin.xml";
    }

    public function getFullCompName()
    {
        $config = $this->metaGen->config;
        $fullCompName = $config->getPackageName() . ".do." . $this->doName;
        return $fullCompName;
    }

}

