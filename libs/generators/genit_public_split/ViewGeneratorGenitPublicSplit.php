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
 * ViewGenerator class
 *
 * Generate ViewObject metafile
 *
 * @package   cubi.bin.genit.libs
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2005-2010, Agus Suhartono
 * @access    public
 */
class ViewGeneratorGenitPublicSplit extends ViewGeneratorBase
{
    public $view_detail;
    public $view_detail_item;
    public $view_edit;
    public $view_new;
    public $view_manage;
    public $view_read_check;
    public $view_read_approve;
    

    public function __construct($metaGen)
    {
        parent::__construct($metaGen);
        $config = $this->metaGen->config;
        $this->view_new     = $config->getComponentName() . 'NewView'   ;
        $this->view_edit    = $config->getComponentName() . 'EditView'  ;
        $this->view_detail_item  = $config->getComponentName() . 'DetailItemView';
        $this->view_detail  = $config->getComponentName() . 'DetailView';
        $this->view_manage  = $config->getComponentName() . 'ManageView';
    }
    
    public function generate()
    {
        parent::generate();
        //$this->generateView($this->view_name, $this->formGen->list_form, self::VIEW_TEMPLATE, $moreForm);
        $this->generateView(
                    self::VIEW_TEMPLATE,
                    $this->view_name,
                    $this->getFormGenerator()->list_form
               );

        $this->generateView(
                    self::VIEW_TEMPLATE,
                    $this->view_new,
                    $this->getFormGenerator()->new_form
               );

        $this->generateView(
                    self::VIEW_TEMPLATE,
                    $this->view_edit,
                    $this->getFormGenerator()->edit_form
               );

        $moreForms = $this->metaGen->config->getMoreForms();
        $this->generateView(
                    self::VIEW_TEMPLATE,
                    $this->view_detail,
                    $this->getFormGenerator()->detail_form,
                    $moreForms
               );

        $moreForms = $this->metaGen->config->getMoreForms();
        $this->generateView(
                    self::VIEW_TEMPLATE,
                    $this->view_detail_item,
                    $this->getFormGenerator()->detail_item_form,
                    $moreForms
               );
        

    }

}
