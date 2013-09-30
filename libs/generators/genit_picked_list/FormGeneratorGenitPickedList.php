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
 * FormGenerator class
 *
 * Generate FormObject (DO) metafile
 *
 * @package   cubi.bin.tools
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2010, Rocky Swen
 * @access    public
 */
class FormGeneratorGenitPickedList extends FormGeneratorAbstract
{
    const LIST_TEMPLATE     = "f_TemplateList.xml";
    const DETAIL_TEMPLATE   = "f_TemplateDetail.xml";    
    
    const PICKER_LIST_TEMPLATE      = "f_TemplatePickerList.xml";
    const PICKER_DETAIL_TEMPLATE      = "f_TemplatePickerDetail.xml";
    
    const DETAIL_TPL    = "f_TemplateDetail.tpl";
    const DETAIL_ES_TPL = "f_TemplateDetailElementSet.tpl";
    const GRID_TPL      = "f_TemplateGrid.tpl";
    
    const PHP_APPROVE_FORM_TEMPLATE = "php_ApproveForm.php";
    const PHP_GENERAL_FORM_TEMPLATE = "php_GeneralForm.php";
    
    /**
     * Form name of data list
     * @var string
     */
    public $list_form;

    /**
     * Form name of detail form
     * @var string
     */
    public $detail_form;   
    
    /**
     * Form name of data list
     * @var string
     */
    public $picker_list_form;

    /**
     * Form name of detail form
     * @var string
     */
    public $picker_detail_form;
    
    /**
     * Generate all form metafiles
     *
     * @return array list of form file name
     */
    public function generate()
    {
        $this->_copyTemplateFileToModule();

        $this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_default;
        //$this->metaGen->doGen->doName = $this->metaGen->doGen->do_short_name_default_sort;
        
        $formFiles[] = $this->generateForm($this->list_form, self::LIST_TEMPLATE);        
        $formFiles[] = $this->generateForm($this->detail_form, self::DETAIL_TEMPLATE);
        
        $formFiles[] = $this->generateForm($this->php_general_form, self::PHP_GENERAL_FORM_TEMPLATE);
        
        return $formFiles;
    }
    
    protected function _setObjectNames()
    {
        $config = $this->metaGen->config;
        $componentName = $config->getComponentName();
        
        $this->list_form = $componentName . 'ListForm';
        $this->detail_form = $componentName . 'DetailForm';        
        
        $this->php_general_form = $componentName . 'Form';
        $this->class_general_form = $this->php_general_form;
        //$this->php_approval_form = $componentName . 'ApproveForm';
        
    }
            
}
