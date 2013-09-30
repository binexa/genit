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
    'tableName' => "kec_monografi_variabel",
    'packageName' => "master.monografi.variabel",
    'moduleTitle' => "Master",
    'compName' => "VariabelMonografi",
    'compDesc' => "Variabel Monografi",
    'sort_rule'     => "nama_variabel ASC",
    
    'fieldLabel' => array(
        'kec_monografi_kelompok_id'=>'Kelompok',
        'kec_monografi_kategori_id'=>'Kategori',
        'kec_monografi_variabel_id'=>'Id',
    ),
    'fieldElement' => array(
        'kec_monografi_kelompok_id' => 'Listbox',
        'kec_monografi_kategori_id' => 'Listbox',
        'level' => 'Listbox',
    ),
    
    'fieldLOV' => array(
        'kec_monografi_kelompok_id' => 'master.monografi.kelompok.do.KelompokMonografiDO[nama_kelompok:Id]',
        'kec_monografi_kategori_id' => "master.monografi.kategori.do.KategoriMonografiDO[nama_kategori:Id], kec_monografi_kelompok_id = '{@:Elem[fld_kec_monografi_kelompok_id].Value}'",
        'level' => "master.lov.CommonLOV(VariabelLevel)",
    ),    
    
    'fieldEvent' => array(
        'kec_monografi_kelompok_id' => array(
                array( 
                    'event' => 'onchange',
                    'function'  => 'UpdateForm()',
                ),
            ),        
    ),    
    
    'fieldElementSet' => array(
    ),
    'fieldTabSet' => array(
    ),    
    'fieldsOnList' => array(
        'Id' => TRUE,
        'nama_variabel'=> TRUE,
        'satuan'=> TRUE,
        'kec_monografi_kelompok_id'=> TRUE,
        'kec_monografi_kategori_id'=> TRUE,
    ),
    'fieldsOnSearch'   => array(
        //'kec_monografi_kategori_id'=> TRUE,
        'nama_variabel'=> TRUE,
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
