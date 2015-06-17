<?php
/**
 * 
 * global variable
 *      - database_name
 *      - table_name 
 *      - meta_tpl  : direktori template 
 */
return [
    
    'template'      => "synfac_master2", // template yg digunakan oleh generator, lokasi ada id "templates"
    'generator'     => "synfac_master2", // engine generator yg dipilih, berada di "libs/generators", 
                                         //    jika tidak ditetapkan akan menggunakan nilai dari "template"
    'packageName'   => "synprod.area",   // package dgn format "modulename.subpackage"
    'moduleTitle'   => "Produksi",       // Get module title
    'compName'      => "Area",           // Nama komponen
    'compDesc'      => "Area",           // deskripsi komponen
    
    'dbName'        => "Default",        // database alias name yg ada di Application.xml
    'tableName'     => "syn_area",       // nama table di database
    
    //'compPathName'  => "",                // component path name
    'sort_rule'     => "area_name ASC",  // pengurutan di tampilan table/grid

    'isGenerateDO'         => TRUE,  // apakah DataObject di-generate?
    
    /*
     *
      
    // field yg akan ditampldilkan dalam form, 
    //    jika tidak disebuktan semua field akan ditampilkan 
    //   format : 'fieldName' => TRUE,
    'fieldsDisplay' => array(  
    ),
     
     * 
     */

    // Label untuk field yg akan ditampilkan di form
    //    jika tidak disebuktan, maka menggunakan nama field diubah menjadi :
    //       - underscore diganti space
    //       - setiap kata diawali huruf besar
    //    contoh : "dim_length" akan diubah menjadi "Dim Length"
    'fieldLabel' => array(
        'syn_area_id'    => 'Id',
        'syn_plant_id'    => 'Plant',
        'dim_length'    => 'Dim Length (m)',
        'dim_width'    => 'Dim Width (m)',
    ),
    
    // Menetapkan jenis Element yg digunakan untuk field di form
    // jika tidak disebutkan akan disesuaikan tipe data di database
    'fieldElement' => array(
        'syn_plant_id'    => 'Listbox',
        'capacity_unit' => 'Listbox',
       // 'is_discontinue'=> 'B',
    ),
    
    // fieldLOV dipakai untuk menetapkan referensi (DataObject) 
    //    sebagai sumber data bagi Element berbentuk list.
    //    
    'fieldLOV' => array(
        'syn_plant_id' => 'syncommon.plant.do.PlantApproveSortDO[plant_name:Id]',
        //'capacity_unit'  => 'syncommon.lov.CustomerLOV(Manuf)',
    ),
    
    // Menetapkan object form yg akan ditampilkan ketika tombol di InputPicker ditekan
    //    format : 'nama_filed' => 'objectForm' ,
    //    nama_filed harus ditetapkan sebagai InputPicker pada bagian 'fieldElement'
    'fieldValuePicker' => array(
        //'syn_material_arrival_id' => 'synpcd.material.arrival.picker.form.MaterialArrivalPickerPickerListForm' ,
    ),

    // Memetakan data dari fieldValuePicker ke field lain di form utama
    // format : 'field_name' => 'mainform_element_name_1:pickerform_element_name_1,mainform_element_name_2:pickerform_element_name_2'
    'fieldPickerMap' => array(
        //'syn_material_arrival_id' => 'fld_syn_material_arrival_id:fld_Id,fld_po_no:fld_po_no,fld_arrival_date:fld_ma_datetime,fld_lot_no:fld_lot_no',
    ),
    
    // Menetapkan format tampilan dari element
    //   format : 'field_name' => 'format',
    'fieldFormat' => array(        
    ),
    
    // Menetapkan default value
    //   format : 'field_name' => 'default-value',
    'fieldDefaultValue' => array(        
    ),
    
    // Menetapkan event dan fungsi yg dipanggil ketika event tersebut terpicu
    //    fungsi yg dipanggil jika belum ada di form class, maka perlu dibuat setelahnya.
    'fieldEvent' => array(
        'syn_plant_id' => array(
                array(
                    'event' => 'onchange',
                    'function'  => 'onPlantChange()',
                ),
            ),
        ),   

    // Menetapkan apakah element dari field enabled atau tidak,
    //   default adalah enabled yg artinya bisa diedit isinya.
    //   format : 
    //      'nama_field' => 'N', // N => disabled
    'fieldEnabled'  => [
    ],
    
    // Menetapkan field yang akan di-hidden (di sembunyikan)
    'fieldHidden' => [        
    ],
    
    
    // Menetapkan ElementSet dari field/element
    //   format : 'fieldName' => 'ElementSet',
    //   default elementset (jika ada salah satu yang ditetapkan)
    //       - tidak disebutkan : 'Top Element'
    //       - field : create_by, create_time, create_host, 
    //                 update_by, update_time, update_host : 'Created &amp; Updated'
    //       - field : is_checked, check_by, check_time, 
    //                 is_approved, approve_by, approve_time : 'Check &amp; Aprove'
    //       - external_attachment : Attachment
    //       - external_picture    : Picture
    //       - external_changelog  : Change Log  
    'fieldElementSet' => [
        /**
        'address1_type' => 'Address 1',
        'address1_address' => 'Address 1',
        'address1_country' => 'Address 1',
        'address1_province' => 'Address 1',
        
        'address2_type' => 'Address 2',
        'address2_address' => 'Address 2',
        'address2_country' => 'Address 2',
        'address2_province' => 'Address 2',        
         * 
         */
    ],
    
    // Menetapkan TabsetSet dari field/element
    //   tabset bisa dianggap sub ElementSet dengan bentuk TAB
    //   format : 'fieldName' => 'TabSet',    
    //   default tabSet (jika ada salah satu yang ditetapkan)
    //       - field : create_by, create_time, create_host, 
    //                 update_by, update_time, update_host
    //                 is_checked, check_by, check_time, 
    //                 is_approved, approve_by, approve_time 
    //                 external_attachment 
    //                 external_picture    
    //                 external_changelog  : ''Extra Information''    
    'fieldTabSet' => [
        /*
        'address1_type'     => 'Address &amp; Contact',
        'address1_address'  => 'Address &amp; Contact',
         */
    ],    
    
    // Menetapkan field apa saja yang ditampilkan dalam daftar table/grid
    //   format 'nama_field' => true
    'fieldsOnList' => [
        'Id'    => true, 
        'area_name'  => true,        
        //'syn_plant_id'  => true,        
        'is_discontinue'  => true,
        'is_checked' => TRUE,
        'is_approved'   => TRUE,
    ],
    
    // Menetapkan field apa saja yang ditampilkan dalam daftar table/grid
    //   format 'nama_field' => true    
    'fieldsOnSearch' => [
        'area_name'  => true,
    ],    

    // Menetapkan field apa saja yang ditampilkan dalam format DETAIL
    //   format 'nama_field' => true
    //  jika tidak ada yang ditetapkan, maka semua field akan ditampilkan.
    'fieldsOnDetail' => [
        'Id'    => true, 
        'area_name'  => true,        
        'is_discontinue'  => true,
        'is_checked' => TRUE,
        'is_approved'   => TRUE,
    ],

    // Menetapkan field apa saja yang ditampilkan dalam format EDIT
    //   format 'nama_field' => true
    //  jika tidak ada yang ditetapkan, maka semua field akan ditampilkan.
    'fieldsOnEdit' => [
        'Id'    => true, 
        'area_name'  => true,        
        'is_discontinue'  => true,
        'is_checked' => TRUE,
        'is_approved'   => TRUE,
    ],

    
    'isAutoGenerate'    => true,     //  


    'isGenerateForm'       => TRUE,  // apakah Form di-generate?
    'isGenerateView'       => TRUE,  // apakah View di-generate?
    'isGenerateDashboard'  => TRUE,  // apakah Dashboard module di-generate?
    'isGenerateMod'        => TRUE,  // apakah file mod.xml (definisi module di-generate?
    'isGenerateMenu'       => FALSE, // apakah definisi menu di-generate?
    
    'isGenerateUserAccess' => FALSE, // apakah UserAccess di-generate?
    'accessLevel' => 2, // 1= Access, Manage ; 2 = Access, Create, Update, Delete ; 3 : no access level
    
];