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
 * Description of GenitTableConfig
 *
 * @author k6
 */
class GenitTableConfig {

    public $config;

    //put your code here
    public function __construct($configName) {
        echo "Config name : " . $configName . "\n";
        $configLocation = Genit::getConfigDirectory() . DIRECTORY_SEPARATOR . $configName . '.php';
        GenitDebug::ShowMessage($configLocation);
        $configs = require($configLocation);
        $this->config = $configs;
    }

    /**
     * Get template name.
     * Template name is directory under templates directory that contain template file.
     * @return string
     */
    public function getTemplateName() {
        return $this->config['template'];
    }

    /**
     * Get path of code gerator
     *    : genits/libs/generators/[dir-generator]
     * @return string
     */
    public function getTemplatePath() {
        $templateName = $this->getTemplateName();
        $templatePath = Genit::getTemplateDirectory() . DIRECTORY_SEPARATOR . $templateName;
        return $templatePath;
    }

    /**
     * Get code generator name.
     * Code generator name is directory under generators directory that contain generator class file for specific case.
     * If code generator not set, function getCodeGeneratorName return value that same with template name.
     * @return type
     */
    public function getGeneratorName() {
        if (isset($this->config['generator'])) {
            return $this->config['generator'];
        } else {
            return $this->getTemplateName();
        }
    }

    /**
     * Get code generator name.
     * Code generator name is directory under generators directory that contain generator class file for specific case.
     * If code generator not set, function getCodeGeneratorName return value that same with template name.
     * @return type
     */
    public function getCodeGeneratorName() {
        return $this->getGeneratorName();
    }

    /**
     * Get package name
     *    The return same with $options[3]
     * @return string
     */
    public function getPackageName() {
        return $this->config['packageName'];
    }

    /**
     * Get base of resource
     * @return string
     */
    public function getBaseResource() {
        return strtolower($this->getPackageName());  // same with options[3]
    }

    /**
     * Get path of package.
     *    This function replase "." of package with DIRECTORY_SEPARATOR using GenitHelper::packageToPath().
     *    The return same with $options[0]
     * @return string
     */
    public function getPackagePath() {
        return GenitHelper::packageToPath($this->getPackageName());
    }

    /**
     * Get path of package.
     *    This function replase "." of package with DIRECTORY_SEPARATOR using GenitHelper::packageToPath().
     *    The return same with $options[0]
     * @return string
     */
    public function getPathOfPackage() {
        return $this->getPackagePath();
    }

    /**
     * Get module name
     * @return string
     */
    public function getModuleName() {
        return $this->getModule();
    }

    /**
     * Get module name
     * @return string
     */
    public function getModule() {
        return GenitHelper::getModuleName($this->getPackageName());
    }

    /**
     * Get module title
     * @return string
     */
    public function getModuleTitle() {
        $moduleTitle = null;
        if (isset($this->config['moduleTitle'])) {
            $moduleTitle = $this->config['moduleTitle'];
        } else {
            $moduleTitle = GenitHelper::capitalize(GenitHelper::getModuleName($this->getPackageName()));
        }
        return $moduleTitle;
    }

    /**
     * Get component name
     * @return string string of component name
     */
    public function getComponentName() {
        return $this->config['compName'];
    }

    /**
     * Get Component path name (deprecated)
     * @return string string of component path name
     */
    public function getComponentPathName() {
        return $this->config['compPathName'];
    }

    /**
     * Get component description
     * @return string
     */
    public function getComponentDesc() {
        return $this->config['compDesc'];
    }

    /**
     * Get module name
     * @return string
     */
    /**
      public function getModulePath()

      return GenitHelper::packageToPath($this->getModule());
      }
     */

    /**
     * Get database name
     * @return string
     */
    public function getDatabaseName() {
        return $this->config['dbName'];
    }

    /**
     * Get table name
     * @return string
     */
    public function getTableName() {
        return $this->config['tableName'];
    }

    public function getOptions() {
        // $opt[0] : package/module path (module/path/path
        $options[0] = $this->getPathOfPackage();

        // $opt[1] : base Object name
        $options[1] = $this->getComponentName();

        //$opt[2] : module name / base Object description<br />
        $options[2] = $this->getComponentDesc();

        // $opt[3] : package/module name (module-name.path.path)
        $options[3] = $this->getPackageName();
        return $options;
    }

    /**
     * Check is auto generate
     * @return boolean
     */
    public function isAutoGenerate() {
        $isAutoGenerate = TRUE;
        if (isset($this->config['isAutoGenerate'])) {
            $isAutoGenerate = $this->config['isAutoGenerate'];
        }
        return $isAutoGenerate;
    }

    /** ======================== DATABASE =========================== */

    /**
     * Check is generate DO
     * @return boolean
     */
    public function isGenerateDO() {
        return $this->getBoolStatus('isGenerateDO', TRUE);
    }

    public function getJoinList() {
        $join = NULL;
        if (isset($this->config['joinDO'])) {
            $join = $this->config['joinDO'];
        }
        return $join;
    }

    public function getJoin($joinName = NULL) {
        GenitDebug::ShowMessage(__METHOD__);

        if ($joinName == NULL) {
            return $this->getJoinList();
        }

        if (isset($this->config['joinDO'])) {
            foreach ($this->config['joinDO'] as $joinItem) {
                //print_r($joinItem);
                //continue;
                if (ucwords($joinName) == ucwords($joinItem['name'])) { // if join exist
                    return $joinItem;
                }
            }
        }
        return NULL;
    }

    public function getFieldsJoin() {
        $fieldsJoin = NULL;
        if (isset($this->config['fieldsJoin'])) {
            $fieldsJoin = $this->config['fieldsJoin'];
        }

        //print_r($fieldsJoin);
        return $fieldsJoin;
    }

    public function getFieldsExpr() {
        $fieldsExpr = NULL;
        if (isset($this->config['fieldsExpr'])) {
            $fieldsExpr = $this->config['fieldsExpr'];
        }

        return $fieldsExpr;
    }

    public function getDoReferenceList() {
        $join = NULL;
        if (isset($this->config['refDO'])) {
            $join = $this->config['refDO'];
        }
        return $join;
    }

    public function getSearchRule() {
        $search_rule = '';
        if (isset($this->config['search_rule'])) {
            $search_rule = $this->config['search_rule'];
        }
        //echo __METHOD__ . " " . $search_rule;
        return $search_rule;
    }

    public function getSortRule() {
        $sort_rule = '';
        if (isset($this->config['sort_rule'])) {
            $sort_rule = $this->config['sort_rule'];
        }
        return $sort_rule;
    }

    public function getOtherSqlRule() {
        $other_sql_rule = '';
        if (isset($this->config['other_sql_rule'])) {
            $other_sql_rule = $this->config['other_sql_rule'];
        }
        //echo __METHOD__ . " : " . $other_sql_rule;
        //exit;
        return $other_sql_rule;
    }

    public function getLinkDo() {
        if (isset($this->config['linkDo'])) {
            $linkDo = $this->config['linkDo'];
        } else {
            $linkDo = NULL;
        }
        return $linkDo;
    }

    public function getLinkDoParentId() {
        if (isset($this->config['linkDoParentId'])) {
            $linkDoParentId = $this->config['linkDoParentId'];
        } else {
            $linkDoParentId = NULL;
        }
        return $linkDoParentId;
    }

    public function getLinkDoChildId() {
        if (isset($this->config['linkDoChildId'])) {
            $linkDoChildId = $this->config['linkDoChildId'];
        } else {
            $linkDoChildId = NULL;
        }
        return $linkDoChildId;
    }

    /** ------------- DATA OBJECT ----------- * */
    /** ============= FORM ================== * */

    /**
     * Check is generate Form
     * @return boolean
     */
    public function isGenerateForm() {
        return $this->getBoolStatus('isGenerateForm', TRUE);
    }

    /**
     *  Get field list that want to displayed
     * @return array
     */
    public function getFieldsDisplay() {
        $fieldsDisplay = NULL;
        if (isset($this->config['fieldsDisplay'])) {
            $fieldsDisplay = $this->config['fieldsDisplay'];
        }
        return $fieldsDisplay;
    }

    /**
     * Get list of field label
     * @param string $fieldName
     * @return string|array|null
     */
    public function getFieldLabel($fieldName = NULL) {
        if ($fieldName == NULL) {
            return $this->getAllFieldLabel();
        }
        $label = "";
        if (isset($this->config['fieldLabel'])) {
            if (isset($this->config['fieldLabel'][$fieldName])) {
                $label = $this->config['fieldLabel'][$fieldName];
            }
        }
        if ($label == "") {
            $label = GenitHelper::capitalize(
                            str_replace("_", " ", $fieldName)
            );
        }
        return $label;
    }

    private function getAllFieldLabel() {
        if (isset($this->config['fieldLabel'])) {
            return $this->config['fieldLabel'];
        } else {
            return NULL;
        }
    }

    /**
     * Get field element
     * @param string $fieldName
     * @return string|array
     */
    public function getFieldElement($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldElement'])) {
                return $this->config['fieldElement'];
            } else {
                return NULL;
            }
        } else {
            $element = NULL;
            if (isset($this->config['fieldElement'])) {
                if (isset($this->config['fieldElement'][$fieldName])) {
                    $element = $this->config['fieldElement'][$fieldName];
                }
            }
            return $element;
        }
    }

    /**
     * Get field LOV
     * @param type $fieldName
     * @return string
     */
    public function getFieldLOV($fieldName = NULL) {
        if ($fieldName == NULL) {
            return $this->config['fieldLOV'];
        } else {
            $lov = NULL;
            if (isset($this->config['fieldLOV'])) {
                if (isset($this->config['fieldLOV'][$fieldName])) {
                    $lov = $this->config['fieldLOV'][$fieldName];
                }
            }
            return $lov;
        }
    }

    /**
     * Get field valuePicker
     * @param type $fieldName
     * @return string
     */
    public function getFieldValuePicker($fieldName = NULL) {
        if ($fieldName == NULL) {
            return $this->config['fieldValuePicker'];
        } else {
            $valuePicker = NULL;
            if (isset($this->config['fieldValuePicker'])) {
                if (isset($this->config['fieldValuePicker'][$fieldName])) {
                    $valuePicker = $this->config['fieldValuePicker'][$fieldName];
                }
            }
            return $valuePicker;
        }
    }

    /**
     * Get field valuePicker
     * @param type $fieldName
     * @return string
     */
    public function getFieldPickerMap($fieldName = NULL) {
        if ($fieldName == NULL) {
            return $this->config['fieldPickerMap'];
        } else {
            $pickerMap = NULL;
            if (isset($this->config['fieldPickerMap'])) {
                if (isset($this->config['fieldPickerMap'][$fieldName])) {
                    $pickerMap = $this->config['fieldPickerMap'][$fieldName];
                }
            }
            return $pickerMap;
        }
    }

    /**
     * Get field format
     * @param string $fieldFormat
     * @return string|array
     */
    public function getFieldFormat($fieldFormat = NULL) {
        if ($fieldFormat == NULL) {
            if (isset($this->config['fieldFormat'])) {
                return $this->config['fieldFormat'];
            } else {
                return NULL;
            }
        } else {
            $element = NULL;
            if (isset($this->config['fieldFormat'])) {
                if (isset($this->config['fieldFormat'][$fieldFormat])) {
                    $element = $this->config['fieldFormat'][$fieldFormat];
                }
            }
            return $element;
        }
    }

    /**
     * Get field Default Value
     * @param string $fieldDefaultValue
     * @return string|array
     */
    public function getFieldDefaultValue($fieldDefaultValue = NULL) {
        if ($fieldDefaultValue == NULL) {
            if (isset($this->config['fieldDefaultValue'])) {
                return $this->config['fieldDefaultValue'];
            } else {
                return NULL;
            }
        } else {
            $element = NULL;
            if (isset($this->config['fieldDefaultValue'])) {
                if (isset($this->config['fieldDefaultValue'][$fieldDefaultValue])) {
                    $element = $this->config['fieldDefaultValue'][$fieldDefaultValue];
                }
            }
            return $element;
        }
    }

    public function getFieldEvent($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldEvent'])) {
                return $this->config['fieldEvent'];
            } else {
                return NULL;
            }
        } else {
            $event = NULL;
            if (isset($this->config['fieldEvent'])) {
                if (isset($this->config['fieldEvent'][$fieldName])) {
                    $event = $this->config['fieldEvent'][$fieldName];
                }
            }
            return $event;
        }
    }

    /**
     * 
     * @param type $fieldName
     * @return type
     */
    public function getFieldEnabled($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldEnabled'])) {
                return $this->config['fieldEnabled'];
            } else {
                return NULL;
            }
        } else {
            $event = NULL;
            if (isset($this->config['fieldEnabled'])) {
                if (isset($this->config['fieldEnabled'][$fieldName])) {
                    $event = $this->config['fieldEnabled'][$fieldName];
                }
            }
            return $event;
        }
    }

    /**
     * 
     * @param string $fieldName
     * @return array|boolean|null
     */
    public function getFieldHidden($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldHidden'])) {
                return $this->config['fieldHidden'];
            } else {
                return NULL;
            }
        } else {
            $hidden = NULL;
            if (isset($this->config['fieldHidden'])) {
                if (isset($this->config['fieldHidden'][$fieldName])) {
                    $hidden = $this->config['fieldHidden'][$fieldName];
                }
            }
            return $hidden;
        }
    }

    /**
     * Get field ElementSet
     * @param string $fieldName
     * @return string
     */
    public function getFieldElementSet($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldElementSet'])) {
                return $this->config['fieldElementSet'];
            } else {
                return NULL;
            }
        } else {
            $elementSet = NULL;
            if (isset($this->config['fieldElementSet'])) {
                if (isset($this->config['fieldElementSet'][$fieldName])) {
                    $elementSet = $this->config['fieldElementSet'][$fieldName];
                }
            }
            if ($elementSet == NULL) {
                $elementSet = $this->getDefaultElementSet($fieldName);
            }
            return $elementSet;
        }
    }

    /**
     * Get default element set if not set.
     * @param string $fieldName
     * @return string
     */
    private function getDefaultElementSet($fieldName) {
        $elementSet = "Top Element";
        if (($fieldName == 'create_by') || ($fieldName == 'create_time') || ($fieldName == 'create_host')) {
            $elementSet = "Created &amp; Updated";
        } elseif (($fieldName == 'update_by') || ($fieldName == 'update_time') || ($fieldName == 'update_host')) {
            $elementSet = "Created &amp; Updated";
        } elseif (($fieldName == 'is_checked') || ($fieldName == 'check_by') || ($fieldName == 'check_time')) {
            $elementSet = 'Check &amp; Aprove';
        } elseif (($fieldName == 'is_approved') || ($fieldName == 'approve_by') || ($fieldName == 'approve_time')) {
            $elementSet = 'Check &amp; Aprove';
        } elseif ($fieldName == 'external_attachment') {
            $elementSet = 'Attachment';
        } elseif ($fieldName == 'external_picture') {
            $elementSet = 'Picture';
        } elseif ($fieldName == 'external_changelog') {
            $elementSet = 'Change Log';
        }
        return $elementSet;
    }

    /**
     * Get TabSet of field
     * @param string $fieldName
     * @return string
     */
    public function getFieldTabSet($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldTabSet'])) {
                return $this->config['fieldTabSet'];
            } else {
                return NULL;
            }
        } else {
            $tabSet = NULL;
            if (isset($this->config['fieldTabSet'])) {
                if (isset($this->config['fieldTabSet'][$fieldName])) {
                    $tabSet = $this->config['fieldTabSet'][$fieldName];
                }
            }
            if ($tabSet == NULL) {
                $tabSet = $this->getDefaultTabSet($fieldName);
            }
            return $tabSet;
        }
    }

    /**
     * Get default tabset of field
     * @param type $fieldName
     * @return string
     */
    private function getDefaultTabSet($fieldName) {
        $tabSet = NULL;
        if (($fieldName == 'create_by') || ($fieldName == 'create_time') || ($fieldName == 'create_host')) {
            $tabSet = "Extra Information";
        } elseif (($fieldName == 'update_by') || ($fieldName == 'update_time') || ($fieldName == 'update_host')) {
            $tabSet = "Extra Information";
        } elseif (($fieldName == 'is_checked') || ($fieldName == 'check_by') || ($fieldName == 'check_time')) {
            $tabSet = 'Extra Information';
        } elseif (($fieldName == 'is_approved') || ($fieldName == 'approve_by') || ($fieldName == 'approve_time')) {
            $tabSet = 'Extra Information';
        } elseif ($fieldName == 'external_attachment') {
            $tabSet = 'Extra Information';
        } elseif ($fieldName == 'external_picture') {
            $tabSet = 'Extra Information';
        } elseif ($fieldName == 'external_changelog') {
            $tabSet = 'Extra Information';
        }
        return $tabSet;
    }

    /**
     * Check is field display on list form
     * @param type $fieldName
     * @return boolean
     */
    public function isFieldOnList($fieldName) {
        $fieldsOnList = false;
        if (isset($this->config['fieldsOnList'])) {
            if (isset($this->config['fieldsOnList'][$fieldName])) {
                $fieldsOnList = $this->config['fieldsOnList'][$fieldName];
            }
        } else {
            $fieldsOnList = true;
        }
        return $fieldsOnList;
    }

    /**
     * Get all field list that will be display on list form
     * @return array
     */
    public function getFieldsOnList() {
        $fieldsOnList = NULL;
        if (isset($this->config['fieldsOnList'])) {
            $fieldsOnList = $this->config['fieldsOnList'];
        }
        return $fieldsOnList;
    }

    /**
     * Get Fields that will be display on Detail form
     * @return NULL|array
     */
    public function getFieldsOnDetail() {
        $fieldsOnDetail = NULL;
        if (isset($this->config['fieldsOnDetail'])) {
            $fieldsOnDetail = $this->config['fieldsOnDetail'];
        }
        return $fieldsOnDetail;
    }

    /**
     * Get Fields that will be display on Edit form
     * @return type
     */
    public function getFieldsOnEdit() {
        if (isset($this->config['fieldsOnEdit'])) {
            $fieldsOnEdit = $this->config['fieldsOnEdit'];
        } else {
            $fieldsOnEdit = $this->getFieldsOnDetail();
        }
        return $fieldsOnEdit;
    }

    /**
     * Get Fields that will be display on Serach panel of List form
     * @param type $fieldName
     * @return boolean
     */
    public function isFieldOnSearch($fieldName) {
        $fieldsOnSearch = false;
        if (isset($this->config['fieldsOnSearch'])) {
            if (isset($this->config['fieldsOnSearch'][$fieldName])) {
                $fieldsOnSearch = $this->config['fieldsOnSearch'][$fieldName];
            }
        } else {
            $fieldsOnSearch = true;
        }
        return $fieldsOnSearch;
    }

    /**
     * Get fielad description
     *
     * @param type $fieldName
     * @return null
     */
    public function getFieldDescription($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldDescription'])) {
                return $this->config['fieldDescription'];
            } else {
                return NULL;
            }
        } else {
            $elementSet = NULL;
            if (isset($this->config['fieldDescription'])) {
                if (isset($this->config['fieldDescription'][$fieldName])) {
                    $elementSet = $this->config['fieldDescription'][$fieldName];
                }
            }
            return $elementSet;
        }
    }

    /**
     * Mengambil form lain untuk disertakan dalam Reference di View
     * @return type
     */
    public function getMoreForms() {
        $moreForms = NULL;
        if (isset($this->config['moreForms'])) {
            $moreForms = $this->config['moreForms'];
        }
        return $moreForms;
    }

    /**
     * 
     * @return type
     */
    public function getPickerForm() {
        $pickerForm = NULL;
        if (isset($this->config['pickerForm'])) {
            $pickerForm = $this->config['pickerForm'];
        }
        return $pickerForm;
    }

    /**
     * Memastikan apakah ada form lain sebagai referensi
     * @return boolean
     */
    public function hasMoreForms() {
        $hasMoreForms = FALSE;
        if (isset($this->config['moreForms'])) {
            $hasMoreForms = TRUE;
        }
        return $hasMoreForms;
    }

    /**
     * Get External method
     * @return type
     */
    public function getExternalMethods() {
        $fieldsOnDetail = NULL;
        if (isset($this->config['externalMethods'])) {
            $fieldsOnDetail = $this->config['externalMethods'];
        }
        return $fieldsOnDetail;
    }

    /**
     * Get CssClass for element
     * @param string $fieldName
     * @return string
     */
    public function getFieldCssClass($fieldName = NULL) {
        if ($fieldName == NULL) {
            if (isset($this->config['fieldCssClass'])) {
                return $this->config['fieldCssClass'];
            } else {
                return NULL;
            }
        } else {
            $elementSet = NULL;
            if (isset($this->config['fieldCssClass'])) {
                if (isset($this->config['fieldCssClass'][$fieldName])) {
                    $elementSet = $this->config['fieldCssClass'][$fieldName];
                }
            }
            return $elementSet;
        }
    }

    public function getRowPerPage() {
        if (isset($this->config['rowPerPage'])) {
            $rowPerPage = $this->config['rowPerPage'];
        } else {
            $rowPerPage = 10;
        }
        return $rowPerPage;
    }

    public function getExtraAction() {
        if (isset($this->config['extraAction'])) {
            $extraAction = $this->config['extraAction'];
        } else {
            $extraAction = NULL;
        }
        return $extraAction;
    }

    public function getDetailBankLink() {
        if (isset($this->config['detailBackLink'])) {
            $detailBackLink = $this->config['detailBackLink'];
        } else {
            $detailBackLink = NULL;
        }
        return $detailBackLink;
    }

    public function getParentForm() {
        if (isset($this->config['parentForm'])) {
            $parentForm = $this->config['parentForm'];
        } else {
            $parentForm = NULL;
        }
        return $parentForm;
    }

    /** -------------------------- FORM END -------------------------------  * */
    /** ========================= ACL ========================= * */

    /**
     * Check is generate User Access
     * @return boolean
     */
    public function isGenerateUserAccess() {
        return $this->getBoolStatus('isGenerateUserAccess', TRUE);
    }

    public function getAccessLevel() {
        $accessLevel = 2;
        if (isset($this->config['accessLevel'])) {
            $accessLevel = $this->config['accessLevel'];
        }
        return $accessLevel;
    }

    /**
     * Get ACL
     */
    public function getAcl() {
        $resource = $this->getBaseResource();
        $acl = $this->getAccessLevel();
        switch ($acl) {
            case 1:
                $aclList = array(
                    'level' => $acl,
                    'access' => $resource . '.Access',
                    'manage' => $resource . '.Manage',
                    'create' => $resource . '.Manage',
                    'update' => $resource . '.Manage',
                    'edit' => $resource . '.Manage',
                    'delete' => $resource . '.Manage',
                    'check' => $resource . '.Check',
                    'approve' => $resource . '.Approve'
                );
                break;
            case 2:
                $aclList = array(
                    'level' => $acl,
                    'access' => $resource . '.Access',
                    'manage' => $resource . '.Manage',
                    'create' => $resource . '.Create',
                    'update' => $resource . '.Update',
                    'edit' => $resource . '.Edit',
                    'delete' => $resource . '.Delete',
                    'check' => $resource . '.Check',
                    'approve' => $resource . '.Approve'
                );
                break;
            case 3:

                $this->options['acl']['resource'] = '';
                $aclList = array(
                    'level' => $acl,
                    'access' => '',
                    'manage' => '',
                    'create' => '',
                    'update' => '',
                    'edit' => '',
                    'delete' => '',
                    'check' => '',
                    'approve' => ''
                );
                break;
        }
        //$this->options['acl']['option'] = $acl;
        //$this->options['acl']['resource'] = $resource;

        return $aclList;
    }

    // --------------------------------


    public function hasDeleteForm() {
        return $this->hasValue('deleteForm');
    }

    public function hasEditForm() {
        return $this->hasValue('editForm');
    }

    public function hasDetailForm() {
        return $this->hasValue('detailForm');
    }

    public function hasDetailItemForm() {
        return $this->hasValue('detailItemForm', false);
    }

    public function hasAddForm() {
        return $this->hasValue('addForm');
    }

    public function hasExportButton() {
        return $this->hasValue('exportButton');
    }

    public function hasCheckButton() {
        return $this->hasValue('checkButton');
    }

    /**
     * approveButton
     * @return boolean
     */
    public function hasApproveButton() {
        return $this->hasValue('approveButton');
    }

    public function hasValidateCheckOnUpdate() {
        return $this->hasValue('validateCheckOnUpdate');
    }

    /**
     * Check is generate View
     * @return boolean
     */
    public function isGenerateView() {
        return $this->getBoolStatus('isGenerateView', TRUE);
    }

    /**
     * Check is generate DO
     * @return boolean
     * INI APA YA
     */
    public function useDetailView() {
        return $this->getBoolStatus('useDetailView', TRUE);
    }

    /**
     * Check is generate Dashboard
     * @return boolean
     */
    public function isGenerateDashboard() {
        return $this->getBoolStatus('isGenerateDashboard', TRUE);
    }

    /** ========================= OTHER ================================== */

    /**
     * Check is generate Modul file
     * @return boolean
     */
    public function isGenerateMod() {
        return $this->getBoolStatus('isGenerateMod', TRUE);
    }

    /**
     * Check is generate Menu
     * @return boolean
     */
    public function isGenerateMenu() {
        return $this->getBoolStatus('isGenerateMenu', TRUE);
    }

    /** ========================= HELPER ================================== */

    /**
     * Get database configuration on Application.xml
     */
    public function getDbConfig() {
        return BizSystem::configuration()->getDatabaseInfo($this->getDatabaseName());
    }

    /**
     * check has value confic
     * @param string $key
     * @param boolean $default
     * @return boolean
     */
    public function hasValue($key, $default = true) {
        if (isset($this->config[$key])) {
            $hasValue = $this->config[$key];
        } else {
            $hasValue = $default;
        }
        return $hasValue;
    }

    private function getBoolStatus($paramName, $defaultValue = TRUE) {
        $boolValue = $defaultValue;
        if (isset($this->config[$paramName])) {
            $boolValue = $this->config[$paramName];
        }
        return $boolValue;
    }

    /**
     * Convert
     * @param array $itemList
     * @return array
     */
    public function fieldOnValue2OnKey($itemList) {
        $newItemList = [];
        foreach ($itemList as $fieldName => $value) {
            if ($value==true) {
                $newItemList[$fieldName] = true;
            } elseif (is_string($value)) {
                $newItemList[$value] = true;
            }
        }
        return $newItemList;
    }

}
