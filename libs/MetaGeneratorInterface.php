<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author k6
 */
interface MetaGeneratorInterface
{
    
    public function getModulePath();
    
    public function loadDOGenerator();
    public function loadFormGenerator();
    public function loadViewGenerator();
    public function loadDashboardGenerator();
    public function loadModGenerator();
            
    public function generate();
}

?>
