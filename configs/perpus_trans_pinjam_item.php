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
    'tableName' => "perpus_trans_pinjam_detail",
    'packageName' => "perpustakaan.trans.pinjam.item",
    'moduleTitle' => "Perpustakaan",
    'compName' => "TransaksiPinjamItem",
    'compDesc' => "Transaksi Pinjam Item",
    
    //'sort_rule'     => "sort_order ASC",
    'fieldHidden' => array(
        'transaksi_id',
    ),
    
    'fieldElement' => array(
        'nama_buku'=>'Listbox',
        'transaksi_id'=>'Hidden',
    ),
    
    'fieldLabel' => array(
    ),
    
    'fieldLOV' => array(
        'nama_buku'  => 'perpustakaan.buku.do.BukuSortDO[judul_buku:Id]',
    ),
    
    'fieldEvent' => array(
    ),

    'fieldDefaultValue' => array(
    ),
    
    'fieldElementSet' => array(
    ),
    
    'fieldTabSet' => array(
    ),
    
    'fieldsOnList' => array(
        'Id'=>true,
        'nama_buku' => true,
        'tanggal_kembali' => true,
    ),
    
    'fieldsOnSearch'   => array(
    ),
    
    //'moreForms' => NULL,
    
    'accessLevel' => 2, // 1= Access, Manage ; 2 = Access, Create, Update, Delete ; 3 : no access level
    
    'isAutoGenerate' => true,
    
    'isGenerateDO'         => TRUE,
    'isGenerateForm'       => TRUE,
    'isGenerateView'       => FALSE,
    'isGenerateDashboard'  => false,
    'isGenerateMod'        => TRUE,
    'isGenerateMenu'       => FALSE,
    'isGenerateUserAccess' => TRUE,
);