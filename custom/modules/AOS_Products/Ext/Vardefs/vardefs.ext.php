<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2025-09-24 13:00:50
$dictionary["AOS_Products"]["fields"]["aos_products_documents_1"] = array (
  'name' => 'aos_products_documents_1',
  'type' => 'link',
  'relationship' => 'aos_products_documents_1',
  'source' => 'non-db',
  'module' => 'Documents',
  'bean_name' => 'Document',
  'side' => 'right',
  'vname' => 'LBL_AOS_PRODUCTS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
);


// Custom fields for AOS_Products

$dictionary['AOS_Products']['fields']['stocknumber_c'] = array(
    'name' => 'stocknumber_c',
    'vname' => 'LBL_STOCKNUMBER',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);



$dictionary['AOS_Products']['fields']['year_c'] = array(
    'name' => 'year_c',
    'vname' => 'LBL_YEAR',
    'type' => 'varchar',
    'len' => '4',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['make_c'] = array(
    'name' => 'make_c',
    'vname' => 'LBL_MAKE',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['model_c'] = array(
    'name' => 'model_c',
    'vname' => 'LBL_MODEL',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['trim_c'] = array(
    'name' => 'trim_c',
    'vname' => 'LBL_TRIM',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['odometer_c'] = array(
    'name' => 'odometer_c',
    'vname' => 'LBL_ODOMETER',
    'type' => 'int',
    'len' => '10',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);


$dictionary['AOS_Products']['fields']['exteriorcolor_c'] = array(
    'name' => 'exteriorcolor_c',
    'vname' => 'LBL_EXTERIORCOLOR',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['interiorcolor_c'] = array(
    'name' => 'interiorcolor_c',
    'vname' => 'LBL_INTERIORCOLOR',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['transmission_c'] = array(
    'name' => 'transmission_c',
    'vname' => 'LBL_TRANSMISSION',
    'type' => 'varchar',
    'len' => '100',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);


$dictionary['AOS_Products']['fields']['carlistingurl_c'] = array(
    'name' => 'carlistingurl_c',
    'vname' => 'LBL_LISTINGURL',
    'type' => 'varchar',
    'len' => '255',
     'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['AOS_Products']['fields']['status'] = array(
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'options' => 'status_list',
    'default' => 'active',
    'len' => 100,
    'audited' => true,
);
$dictionary['AOS_Products']['fields']['inventory_status_c'] = array(
    'name' => 'inventory_status_c',
    'vname' => 'LBL_INVENTORY_STATUS_C',
    'type' => 'enum',
    'options' => 'inventory_wholesale_status_list',
    'default' => 'available',
    'len' => 100,
    'audited' => true,
);
$dictionary['AOS_Products']['fields']['selling_price'] = array(
    'name' => 'selling_price',
    'vname' => 'LBL_SELLING_PRICE',
    'type' => 'decimal',
    'len' => '10,6',
    'audited' => true,
);
$dictionary['AOS_Products']['fields']['sold'] = array(
    'name' => 'sold',
    'vname' => 'LBL_SOLD',
    'type' => 'enum',
    'options' => 'sold_list',
    'default' => 'no',
    'len' => 100,
    'audited' => true,
);
$dictionary['AOS_Products']['fields']['sold_datetime'] = array(
    'name' => 'sold_datetime',
    'vname' => 'LBL_sold_datetime',
    'type' => 'datetime',
    'dbType' => 'datetime',
    'audited' => false,
    'massupdate' => false,
    'importable' => true,
    'reportable' => true,
    'unified_search' => false,
    'enable_range_search' => true,
    'studio' => 'visible',
);
$dictionary['AOS_Products']['fields']['photo_url'] = array(
    'name' => 'photo_url',
    'vname' => 'LBL_PHOTO_URL',
    'type' => 'text',
    'dbType' => 'longtext',
    'rows' => 6,
    'cols' => 80,
    'required' => false,
    'reportable' => true,
    'audited' => false,
    'comment' => 'Product photo URL or long image data',
);


// Filter-related vardef overrides for sold_datetime

$dictionary['AOS_Products']['fields']['sold_datetime']['audited'] = false;
$dictionary['AOS_Products']['fields']['sold_datetime']['inline_edit'] = '';
$dictionary['AOS_Products']['fields']['sold_datetime']['options'] = 'date_range_search_dom';

?>