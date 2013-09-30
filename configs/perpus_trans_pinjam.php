<?php
/**
 * 
 * global variable
 *      - database_name
 *      - table_name 
 *      - meta_tpl  : direktori template 
 */
return array(
    'template'  => "synfac_trans_master",
    'generator' => "synfac_trans_master",
    
    'type'      => "CRUD",
    'dbName'    => "Default",
    'tableName' => "perpus_trans_pinjam",
    'packageName' => "perpustakaan.trans.pinjam",
    'moduleTitle' => "Perpustakaan",
    'compName'  => "TransaksiPinjam",
    'compDesc'  => "Transaksi Pinjam",
    
    //'sort_rule'     => "name ASC",
    
    'deleteForm'    => true,
    'editForm'      => true,
    'addForm'       => true,
    'exportButton'  => true,
    
    'fieldHidden' => array(          
    ),
    'fieldLabel' => array(
        //'syn_purchase_order_id'   => 'Id',
        //'syn_customer_id'       => 'Customer' ,
    ),
    'fieldElement'  => array(
        //'syn_customer_id' => 'Listbox' ,
    ),
    'fieldLOV' => array(
        //'syn_customer_id'  => 'synmkt.customer.do.CustomerApproveDO[name:Id]',
    ),
    'fieldElementSet' => array(
    ),
    'fieldTabSet' => array(
    ),
    'fieldsOnList' => array(
        'Id'    => true,
        'nama_peminjam' => true,
        'no_hp' => true,
        'tanggal_pinjam' => true,
    ),
    'fieldsOnSearch'   => array(
        'name'  => true,
    ),
    
    'moreForms' => array(
        'perpustakaan.trans.pinjam.item.form.TransaksiPinjamItemListForm',
    ),
    
    'refDO' => array(
        array(
            'name'      => 'perpustakaan.trans.pinjam.item.do.TransaksiPinjamItemDO',
            'description'      => '',
            'relationship'  => '1-M',
            'table' => 'perpus_trans_pinjam_detail',// nama table lain
            'column'    => 'transaksi_id', // nama field tabel lain
            'fieldRef'  => 'Id', // nama field tabel ini
        ),
    ),   
    
    'extraAction' => array(
    ),
    'accessLevel' => 2, // 1= Access, Manage ; 2 = Access, Create, Update, Delete ; 3 : no access level        

    'isAutoGenerate' => true,
    
    'isGenerateDO'         => TRUE,
    'isGenerateForm'       => TRUE,
    'isGenerateView'       => TRUE,
    'isGenerateDashboard'  => TRUE,
    'isGenerateMod'        => TRUE,
    'isGenerateMenu'       => TRUE,
    'isGenerateUserAccess' => TRUE,    
);

