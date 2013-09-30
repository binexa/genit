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
class ViewGeneratorSynfacMaster2 extends ViewGeneratorBase
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
                self::VIEW_TEMPLATE, $this->view_name, $this->getFormGenerator()->list_form);
    }
}
