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
    'tableName'     => "perpus_buku",
    'packageName'   => "perpustakaan.buku",
    'moduleTitle'   => "Perpustakaan",
    'compName'      => "Buku",
    'compDesc'      => "Buku",
    'sort_rule'     => "judul_buku ASC",

    'fieldElement' => array(
        'cabang'    => 'Listbox',
        'jenis_buku' => 'Listbox',

    ),
    'fieldLOV' => array(
        'cabang' => 'perpustakaan.cabang.do.CabangSortDO[nama_cabang:Id]',
        'jenis_buku'  => 'perpustakaan.lov.PerpustakaanLOV(JenisBuku)',
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
        'judul_buku'  => true,
        'jenis_buku'   => TRUE,
        'pengarang' => true,
        'tahun_terbit' => true,
    ),
    'fieldsOnSearch' => array(
        'judul_buku' => true,
        'pengarang'  => true,
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