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
    'tableName' => "kec_monografi_kategori",
    'packageName' => "master.monografi.kategori",
    'moduleTitle' => "Master",
    'compName' => "KategoriMonografi",
    'compDesc' => "Kategori Monografi",
    'sort_rule'     => "nama_kategori ASC",
    
    'fieldLabel' => array(
        'kec_monografi_kategori_id'=>'Id',
        'kec_monografi_kelompok_id'=>'Kelompok',
    ),
    'fieldElement' => array(
        'kec_monografi_kelompok_id' => 'Listbox',
    ),
    'fieldLOV' => array(
        'kec_monografi_kelompok_id' => 'master.monografi.kelompok.do.KelompokMonografiDO[nama_kelompok:Id]',
    ),    
    'fieldEvent' => array(
    ),    
    'fieldElementSet' => array(
    ),
    'fieldTabSet' => array(
    ),    
    'fieldsOnList' => array(
        'Id' => TRUE,
        'nama_kategori'=> TRUE,
        'kec_monografi_kelompok_id'=>TRUE,
    ),
    'fieldsOnSearch'   => array(
        'nama_kategori'=> TRUE,
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
