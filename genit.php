#!/usr/bin/env php
<?php
/**
 * GenIt, Code generator for Cubi Application Platform
 *
 * Based on gen_meta.php By Rocky Swen
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.lib
 * @copyright Copyright (c) 2005-2011, Rocky Swen, Agus Suhartono
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

include_once dirname(dirname(__FILE__)) . "/app_init.php";
include_once dirname(__FILE__) . "/libs/Genit.php";

if (!defined("CLI")) {
    exit;
}

Genit::run('main');
