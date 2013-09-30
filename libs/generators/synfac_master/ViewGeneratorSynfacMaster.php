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
class ViewGeneratorSynfacMaster extends ViewGeneratorBase
{
    /**
     *
     * @var MetaGenerator
     */
    public $metaGen;

    public function generate()
    {
        parent::generate();
        //$this->generateView($this->view_name, $this->formGen->list_form, self::VIEW_TEMPLATE, $moreForm);
        $this->generateView(
                self::VIEW_TEMPLATE, $this->view_name, $this->getFormGenerator()->read_list_form);

        if ($this->metaGen->doGen->hasCheckProcess()) {
            $this->generateView(
                    self::VIEW_CHECK_TEMPLATE, $this->check_view_name, $this->getFormGenerator()->need_check_list_form, array($this->getFormGenerator()->check_list_form));
        }
        if ($this->metaGen->doGen->hasApproveProcess()) {
            $this->generateView(
                    self::VIEW_APPROVE_TEMPLATE, $this->approve_view_name, $this->getFormGenerator()->need_approve_list_form, array($this->getFormGenerator()->approve_list_form));
        }
    }
}
