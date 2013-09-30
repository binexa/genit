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
class DOGeneratorGenitPickedList extends DOGeneratorAbstract
{
	/**
	 * DataObject name without "do" namespace/package
	 * @var string
	 */
	public $do_short_name;
	public $do_short_name_sort;
    
	public $do_short_name_default;
	public $do_short_name_default_sort;
    
	public $do_short_name_picker;
	public $do_short_name_picker_sort;

	/**
	 * Initialize Object
	 * @param MetaGenerator $metaGen
	 */
	function __construct( $metaGen )
	{
        parent::__construct( $metaGen );

        $config = $metaGen->config;
		$componentName = $config->getComponentName();

		$this->do_short_name_default = $componentName . "DO";
		$this->do_short_name_default_sort = $componentName . "SortDO";

		$this->do_short_name = $this->do_short_name_default;
        $this->doName = $this->do_short_name_default;
	}

    
    public function generate()
    {
		$this->searchRule = "";
		//$this->sortRule = "";
        $this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_default;
		$this->generateDO();
        
		//$this->sortRule = $this->metaGen->config->getSortRule();
		//$this->doName = $this->do_short_name_default_sort;
		//$this->generateDO();
        
    }

}

