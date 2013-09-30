<?php
/**
 * 
 * global variable
 *      - database_name
 *      - table_name 
 *      - meta_tpl  : direktori template 
 */
return array(
    'generator' => "genit_detail",    
    'template' => "genit_detail",
    
    'dbName' => "Default",
    'tableName' => "kec_monografi_kelompok",
    'packageName' => "master.monografi.kelompok",
    'moduleTitle' => "Master",
    'compName' => "KelompokMonografi",
    'compDesc' => "Kelompok Monografi",
    'sort_rule'     => "nama_kelompok ASC",
    
    'fieldLabel' => array(
        'kec_monografi_kelompok_id'=>'Id',
    ),
    'fieldElement' => array(
    ),
    'fieldLOV' => array(
    ),
    
    'fieldEvent' => array(
    ),
    
    'fieldElementSet' => array(
    ),
    'fieldTabSet' => array(
    ),
    
    'fieldsOnList' => array(
        'Id' => TRUE,
        'nama_kelompok'=> TRUE,
    ),
    'fieldsOnSearch'   => array(
        'nama_kelompok'=> TRUE,
    ),
    
    'rowPerPage'=>10,
    
    'isAutoGenerate' => true,
    
    'isGenerateDO'         => TRUE,
    'isGenerateForm'       => TRUE,
    'isGenerateView'       => TRUE,
    'isGenerateDashboard'  => TRUE,
    'isGenerateMod'        => FALSE,
    'isGenerateMenu'       => FALSE,
    'isGenerateUserAccess' => FALSE,
    
    'accessLevel' => 1, // 1= Access, Manage ; 2 = Access, Create, Update, Delete ; 3 : no access level
);
