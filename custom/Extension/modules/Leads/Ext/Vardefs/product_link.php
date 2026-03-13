<?php
$dictionary['Lead']['relationships']['lead_aos_products'] = array(
    'lhs_module' => 'AOS_Products',
    'lhs_table'  => 'aos_products',
    'lhs_key'    => 'id',

    'rhs_module' => 'Leads',
    'rhs_table'  => 'leads',
    'rhs_key'    => 'aos_product_id_c',

    'relationship_type' => 'one-to-many',
);


$dictionary['Lead']['fields']['aos_products_link'] = array(
    'name' => 'aos_products_link',
    'type' => 'link',
    'relationship' => 'lead_aos_products',
    'module' => 'AOS_Products',
    'bean_name' => 'AOS_Products',
    'source' => 'non-db',
    'vname' => 'LBL_PRODUCT',
);

