<?php
$dictionary['iv_intrested_vehicle']['fields']['aos_product_id_c'] = array(
    'name' => 'aos_product_id_c',
    'rname' => 'id',
    'vname' => 'LBL_PRODUCT',
    'type' => 'id',
    'table' => 'aos_products',
    'isnull' => 'true',
    'module' => 'AOS_Products',
    'dbType' => 'id',
    'reportable' => false,
    'audited' => true,
    'comment' => 'Relate to AOS_Products'
);

$dictionary['iv_intrested_vehicle']['fields']['product_name_c'] = array(
    'name' => 'product_name_c',
    'rname' => 'name',
    'id_name' => 'aos_product_id_c',
    'vname' => 'LBL_PRODUCT',
    'type' => 'relate',
    'link' => 'aos_products_link',
    'table' => 'aos_products',
    'isnull' => 'true',
    'module' => 'AOS_Products',
    'dbType' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);
