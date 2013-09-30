<?php
/**
 * 
 * global variable
 *      - database_name
 *      - table_name 
 *      - meta_tpl  : direktori template 
 */
return array(
    
    'generator'     => "synfac_master2",
    'template'      => "synfac_master2",    
    'dbName'        => "Default",
    'tableName'     => "perpus_cabang",
    'packageName'   => "perpustakaan.cabang",
    'moduleTitle'   => "Perpustakaan",
    'compName'      => "Cabang",
    'compDesc'      => "Cabang",
    'sort_rule'     => "nama_cabang ASC",


    'fieldElement' => array(
    ),
    'fieldLOV' => array(
        //'syn_plant_id' => 'syncommon.plant.do.PlantApproveSortDO[plant_name:Id]',
        //'capacity_unit'  => 'syncommon.lov.CustomerLOV(Manuf)',
    ),
    
    'fieldEvent' => array(
        ),
    'fieldLabel' => array(
    ),
    'fieldElementSet' => array(
    ),
    'fieldTabSet' => array(
    ),    
    'fieldsOnList' => array(
        'Id'    => true, 
        'nama_cabang'  => true,
        'alamat'   => TRUE,
    ),
    'fieldsOnSearch' => array(
        'nama_cabang'  => true,
    ),
    
    'accessLevel' => 2, // 1= Access, Manage ; 2 = Access, Create, Update, Delete ; 3 : no access level
    
    'isAutoGenerate'    => true,

    'isGenerateDO'         => TRUE,
    'isGenerateForm'       => TRUE,
    'isGenerateView'       => TRUE,
    'isGenerateDashboard'  => TRUE,
    'isGenerateMod'        => TRUE,
    'isGenerateMenu'       => true,
    'isGenerateUserAccess' => true,
);