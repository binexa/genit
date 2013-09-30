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
 * DOGenerator class
 *
 * Generate DataObject (DO) metafile
 *
 * @package   cubi.bin.tools
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class DOGenerator
{

    const DO_TEMPLATE = "/d_Template.xml";

    /**
     *
     * @var MetaGenerator 
     */
    public $metaGenerator;

    /**
     * module name
     * @var string
     */
    public $package_name;

    /**
     * database name that configured in Config.xml
     * @var string
     */
    public $db_name;

    /**
     * table name
     * @var string
     */
    public $table_name;

    /**
     * database configuration that store in Config.xml
     * @var array
     */
    public $db_config;

    /**
     * Option
     * @var array
     */
    public $options;

    /**
     * DataObject name with "do" namespace/package
     * @var string 
     */
    public $do_name;

    /**
     * DataObject name without "do" namespace/package
     * @var string
     */
    public $do_short_name;
    public $do_short_name_default;
    public $do_short_name_checked;
    public $do_short_name_need_check;
    public $do_short_name_approved;
    public $do_short_name_need_approve;
    public $tableIndex;
    public $uniqueness, $fields, $id_identity;
    public $search_rule;
    private $_isDataPrepared = false;

    /**
     * Initialize Object
     * @param string $package_name module name
     * @param string $db_name database name alias in Config.xml
     * @param string $table_name table name
     * @param array $db_config database config
     * @param array $opts optional
     */
    function __construct($package_name, $db_name, $table_name, $db_config, $opts)
    {
        $this->package_name = $package_name;
        $this->db_name = $db_name;
        $this->table_name = $table_name;
        $this->db_config = $db_config;
        $this->options = $opts;

        $this->do_name = "do." . $opts[1] . "DO";

        $this->do_short_name_default = $opts[1] . "DO";
        $this->do_short_name_checked = $opts[1] . "CheckDO";
        $this->do_short_name_need_check = $opts[1] . "NeedCheckDO";
        $this->do_short_name_approved = $opts[1] . "ApproveDO";
        $this->do_short_name_need_approve = $opts[1] . "NeedApproveDO";

        $this->do_short_name = $this->do_short_name_default;

        $this->_isDataPrepared = false;
        $this->search_rule = '';
    }

    /**
     * Prepare Data
     * @return void
     */
    public function prepareData()
    {
        $db = BizSystem::dbConnection($this->db_name);
        if (!$db) {
            if (CLI) {
                echo "ERROR: Cannot connect to database $this->db_name" . PHP_EOL;
            }
            exit;
        }
        $this->getTableIndex();
        $this->getDOFields();
        $this->_isDataPrepared = true;
    }

    /**
     * Generate DataObject metafile
     * @return string
     */
    public function generateDO()
    {
        if (CLI) {
            echo "Start generate dataobject $this->do_short_name." . PHP_EOL;
        }

        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $this->package_name) . "/do";
        if (!file_exists($targetPath)) {
            if (CLI) {
                echo "Create directory $targetPath" . PHP_EOL;
            }
            mkdir($targetPath, 0777, true);
        }

        $smarty = BizSystem::getSmartyTemplate();

        $smarty->assign_by_ref("do_name", $this->do_name);
        $smarty->assign_by_ref("do_short_name", $this->do_short_name);
        $smarty->assign_by_ref("comp", $this->package_name);
        $smarty->assign_by_ref("db_name", $this->db_name);
        $smarty->assign_by_ref("table_name", $this->table_name);
        $smarty->assign_by_ref("fields", $this->fields);
        $smarty->assign_by_ref("uniqueness", $this->uniqueness);
        $smarty->assign_by_ref("id_identity", $this->id_identity);
        $smarty->assign_by_ref("sort_column", $this->sort_column);
        $smarty->assign_by_ref("acl", $this->options['acl']);

        $smarty->assign_by_ref("search_rule", $this->search_rule);

        $templateFile = dirname(dirname(__FILE__)) . '/templates/' . META_TPL . self::DO_TEMPLATE;
        $content = $smarty->fetch($templateFile);

        // target file
        $targetFile = $targetPath . "/" . $this->do_short_name . ".xml";

        file_put_contents($targetFile, $content);
        if (CLI) {
            echo "\t" . str_replace(MODULE_PATH, "", $targetFile) . " is generated." . PHP_EOL;
        }
        return $targetFile;
    }

    public function generateAllDOs()
    {
        $this->_generateDefaultDO();
        if ($this->hasCheckProcess()) {
            $this->_generateNeedCheckDO();
            $this->_generateCheckedDO();
        }
        if ($this->hasApproveProcess()) {
            $this->_generateNeedApproveDO();
            $this->_generateApprovedDO();
        }
    }

    private function _generateDefaultDO()
    {
        $this->do_short_name = $this->do_short_name_default;
        $this->search_rule = "";
        $this->generateDO();
    }

    private function _generateCheckedDO()
    {
        $this->do_short_name = $this->do_short_name_checked;
        $this->search_rule = "(is_checked = true) AND (is_approved = false)";
        $this->generateDO();
    }

    private function _generateNeedCheckDO()
    {
        $this->do_short_name = $this->do_short_name_need_check;
        $this->search_rule = "is_checked = false";
        $this->generateDO();
    }

    private function _generateApprovedDO()
    {
        $this->do_short_name = $this->do_short_name_approved;
        $this->search_rule = "(is_approved = true) AND (is_checked = true)";
        $this->generateDO();
    }

    private function _generateNeedApproveDO()
    {
        $this->do_short_name = $this->do_short_name_need_approve;
        $this->search_rule = "(is_approved = false) AND (is_checked = true)";
        $this->generateDO();
    }

    /**
     * Get DataObject Fields
     * @return void
     */
    protected function getDOFields()
    {
        $db = BizSystem::dbConnection($this->db_name);
        $tblCols = $db->describeTable($this->table_name);

        //$fullTblCol = $db->query("SHOW FULL $this->table_name");
        // print_r($tblCols);

        $db_config = $this->db_config;
        $i = 0;
        if (is_array($tblCols["sort_order"])) {
            $this->sort_column = "sort_order";
        }
        foreach ($tblCols as $fieldName => $colAttrs) {
            // special handling on the primary key column(s)
            // for simple, just consider simple primary key case
            if ($colAttrs['PRIMARY'] == true) {
                $fields[$i]['name'] = 'Id';
                $this->do['id_identity'] = $colAttrs['IDENTITY'];
                if ($colAttrs['IDENTITY'] == true) {
                    $this->id_identity = true;
                } else {
                    $this->id_identity = false;
                }
            }
            else
                $fields[$i]['name'] = $fieldName;

            $fields[$i]['col'] = $fieldName;
            $fields[$i]['nullable'] = $colAttrs['NULLABLE'];
            $fields[$i]['length'] = $colAttrs['LENGTH'];
            // different db engine has different type name, but need to convert them to DO types.
            $fields[$i]['type'] = GenitHelper::convertDataType($colAttrs['DATA_TYPE'], $db_config['Driver']);

            //if ($this->metaGenerator->config['fieldLabel'][''])
            //$fields[$i]['element'] = GenitHelper::getDataElement($colAttrs['DATA_TYPE'], $db_config['Driver']);
            $fields[$i]['element'] = $this->_getFieldElement($fieldName, $colAttrs['DATA_TYPE'], $db_config['Driver']);
            $fields[$i]['lov'] = $this->_getFieldLOV($fieldName);
            $fields[$i]['label'] = $this->_getFieldLabel($fieldName);

            $fields[$i]['options'] = GenitHelper::getDataOptions($colAttrs['DATA_TYPE'], $db_config['Driver']);
            $fields[$i]['raw_type'] = $colAttrs['DATA_TYPE'];
            if ($colAttrs['DEFAULT'] != "CURRENT_TIMESTAMP") {
                $fields[$i]['default'] = $colAttrs['DEFAULT'];
            }
            if (!isset($fields[$i]['default']) && $fieldName == 'name') {
                $fields[$i]['default'] = "New " . $this->options[2];
            }
            $i++;
        }
        // print_r($fields);
        $this->fields = $fields;
    }

    /**
     * Load table index and uniqueness information
     * @return void
     */
    protected function getTableIndex()
    {
        $db = BizSystem::dbConnection($this->db_name);
        $db_driver = $this->db_config['Driver'];
        switch (strtoupper($db_driver)) {
            case 'PDO_MYSQL':
                $sql = "SHOW INDEX FROM " . $this->db_config["DBName"] . "." . "$this->table_name;";
                $result = $db->query($sql);
                $tblIndexes = $result->fetchAll();
                break;
            default:
                break;
        }
        $tableIndex = array();
        if ($tblIndexes) {
            foreach ($tblIndexes as $colIndex) {
                $non_unique = $colIndex[1];
                $key_name = $colIndex[2];
                $col_name = $colIndex[4];
                if ($key_name != "PRIMARY" && $tblCols[$col_name]['DATA_TYPE'] != 'int') {
                    //$tableIndex[$key_name]=array();
                    $indexInfo = array("NON_UNIQUE" => $non_unique,
                        "KEY_NAME" => $key_name,
                        "COL_NAME" => $col_name);
                    if (!is_array($tableIndex[$key_name])) {
                        $tableIndex[$key_name] = array();
                    }
                    array_push($tableIndex[$key_name], $indexInfo);
                }
            }
        }
        $this->tableIndex = $tableIndex;

        $uniqueness = "";
        foreach ($tableIndex as $key_name => $key_index) {
            $key_uniqueness = "";
            foreach ($key_index as $indexInfo) {
                if ($indexInfo['NON_UNIQUE'] == "0") {
                    if ($key_uniqueness != "") {
                        $key_uniqueness.=",";
                    }
                    $key_uniqueness .= $indexInfo['COL_NAME'];
                }
            }
            if ($key_uniqueness != "") {
                $uniqueness .= $key_uniqueness . ";";
            }
        }
        $this->uniqueness = $uniqueness;
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

        foreach ($this->fields as $fieldKey => $fieldValue) {
            if ($fieldValue['name'] == 'external_attachment') {
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

        foreach ($this->fields as $fieldKey => $fieldValue) {
            if ($fieldValue['name'] == 'external_attachment') {
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
    public function hasCheckProcess()
    {
        $hasCheckProcess = false;
        if (!$this->_isDataPrepared)
            $this->prepareData();

        foreach ($this->fields as $fieldKey => $fieldValue) {
            if ($fieldValue['name'] == 'is_checked') {
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

        foreach ($this->fields as $fieldKey => $fieldValue) {
            if ($fieldValue['name'] == 'is_approved') {
                $hasAproveProcess = true;
                break 1;
            }
        }
        return $hasAproveProcess;
    }

    private function _getFieldLabel($fieldName)
    {
        $label = "";
        if (isset($this->metaGenerator->config['fieldLabel'])) {
            if (isset($this->metaGenerator->config['fieldLabel'][$fieldName])) {
                $label = $this->metaGenerator->config['fieldLabel'][$fieldName];
            }
        }
        if ($label == "") {
            $label = GenitHelper::capitalize($fieldName);
        }
        return $label;
    }

    private function _getFieldElement($fieldName, $dataType, $dbDriver)
    {
        $element = "";
        if (isset($this->metaGenerator->config['fieldElement'])) {
            if (isset($this->metaGenerator->config['fieldElement'][$fieldName])) {
                $element = $this->metaGenerator->config['fieldElement'][$fieldName];
            }
        }
        if ($element == "") {
            $element = GenitHelper::getDataElement($dataType, $dbDriver);
        }
        return $element;
    }

    private function _getFieldLOV($fieldName)
    {
        $lov = null;
        if (isset($this->metaGenerator->config['fieldLOV'])) {
            if (isset($this->metaGenerator->config['fieldLOV'][$fieldName])) {
                $lov = $this->metaGenerator->config['fieldLOV'][$fieldName];
            }
        }
        return $lov;
    }
    
}

?>
