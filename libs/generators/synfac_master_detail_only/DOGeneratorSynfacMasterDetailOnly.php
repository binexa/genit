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
class DOGeneratorSynfacMasterDetailOnly extends DOGeneratorAbstract
{
	/**
	 * DataObject name without "do" namespace/package
	 * @var string
	 */
	public $do_short_name;
	public $do_short_name_sort;
	public $do_short_name_default;
	public $do_short_name_default_sort;
	public $do_short_name_checked;
	public $do_short_name_checked_sort;
	public $do_short_name_need_check;
	public $do_short_name_need_check_sort;
	public $do_short_name_approved;
	public $do_short_name_approved_sort;
	public $do_short_name_need_approve;
	public $do_short_name_need_approve_sort;

	/**
	 * Initialize Object
	 * @param MetaGenerator $metaGen
	 */
	function __construct( $metaGen )
	{
        parent::__construct($metaGen);

        $config = $metaGen->config;
		$componentName = $config->getComponentName();

		$this->do_short_name_default = $componentName . "DO";
		$this->do_short_name_default_sort = $componentName . "SortDO";

		$this->do_short_name_checked = $componentName . "CheckDO";
		$this->do_short_name_checked_sort = $componentName . "CheckSortDO";

		$this->do_short_name_need_check = $componentName . "NeedCheckDO";
		$this->do_short_name_need_check_sort = $componentName . "NeedCheckSortDO";

		$this->do_short_name_approved = $componentName . "ApproveDO";
		$this->do_short_name_approved_sort = $componentName . "ApproveSortDO";

		$this->do_short_name_need_approve = $componentName . "NeedApproveDO";
		$this->do_short_name_need_approve_sort = $componentName . "NeedApproveSortDO";

		$this->do_short_name = $this->do_short_name_default;
        $this->doName = $this->do_short_name_default;
	}

    
    public function generate()
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

    /**
	 * Generate default DataObject
	 */
	private function _generateDefaultDO()
	{
		$this->searchRule = "";
		$this->sortRule = "";
		$this->doName = $this->do_short_name_default;
		$this->generateDO();

		$this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_default_sort;
		$this->generateDO();
	}

	private function _generateCheckedDO()
	{
		$this->sortRule = "";
		$this->searchRule = "(is_checked = true) AND (NOT (is_approved = true) )";
		$this->doName = $this->do_short_name_checked;
		$this->generateDO();
		
		$this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_checked_sort;
		$this->generateDO();
	}

	private function _generateNeedCheckDO()
	{
		$this->sortRule = "";
		$this->searchRule = " NOT (is_checked = true) ";
		$this->doName = $this->do_short_name_need_check;
		$this->generateDO();

		$this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_need_check_sort;
		$this->generateDO();
	}

	private function _generateApprovedDO()
	{
		$this->sortRule = "";
		$this->searchRule = "(is_approved = true) AND (is_checked = true)";
		$this->doName = $this->do_short_name_approved;
		$this->generateDO();

		$this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_approved_sort;
		$this->generateDO();
	}

	private function _generateNeedApproveDO()
	{
		$this->sortRule = "";
		$this->searchRule = "( NOT (is_approved = true) ) AND (is_checked = true)";
		$this->doName = $this->do_short_name_need_approve;
		$this->generateDO();

		$this->sortRule = $this->metaGen->config->getSortRule();
		$this->doName = $this->do_short_name_need_approve_sort;
		$this->generateDO();

	}


}

