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
 * Description of DebugPrint
 *
 * @author k6
 */
class GenitDebug
{
    static public $isDebug;
    //put your code here
    
    static public function ShowMessage($message)
    {        
        $isDebug = false; 
        if (!isset(self::$isDebug)) {
             $isDebug = false;  
             self::$isDebug = $isDebug;
        } else {
            $isDebug = self::$isDebug;
        }
        
        if ($isDebug) {
            if (is_array($message)) {
                echo "DEBUG: ".PHP_EOL;
                print_r($message);
                echo PHP_EOL;
            } else {
                echo "DEBUG: ".$message.PHP_EOL;
            }
        }
    }
    
}

?>
