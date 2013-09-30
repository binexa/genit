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
 * Helper for echo in CLI mode
 *
 * Generate DataObject (DO) metafile
 *
 * @package   cubi.bin.genit
 * @author    Agus Suhartono
 * @copyright Copyright (c) 2005-2010, Agus Suhartono
 * @access    public
 */
 
class GenitCli
{
    /**
     * Show message if on CLI mode
     * @param type $message
     */
	public static function showMessage($message) {
	        if (CLI) {
                echo $message . PHP_EOL;
            }
	}
    
    /**
     * Print new line
     */
    public static function newLine()
    {
        echo PHP_EOL;
    }
}