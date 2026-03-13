<?php
/**
 * List View Layout for iv_intrested_vehicle module
 * Path: custom/modules/iv_intrested_vehicle/metadata/listviewdefs.php
 */

$listViewDefs['iv_intrested_vehicle'] = array(
    'VEHICLE_C' => array(
        'label'   => 'LBL_VEHICLE',
        'vname'   => 'LBL_VEHICLE',
        'width'   => '15%',
        'default' => true,
        'link'    => true,
    ),/*
    'PRODUCT_NAME_C' => array(
        'label'=> 'LBL_PRODUCT',
        'width'=> '15%',
        'default'=> true,
        'link' => true,
        'relate'=> true,
        'module'=> 'AOS_Products',
        'id'=> 'AOS_PRODUCT_ID_C',
        'name'=> 'product_name_c',
        'rname'=> 'name',
        'id_name'=> 'aos_product_id_c',
        'related_fields'=> array('aos_product_id_c'),
    ),*/
    'ACCOUNT_NAME_C' => array(
        'width'          => '12%',
        'label'          => 'LBL_DEALERSHIP',
        'default'        => true,
        'link'           => true,
        'relate'         => true,
        'module'         => 'Accounts',
        'id'             => 'ACCOUNT_ID_C',
        'name'           => 'account_name_c',
        'rname'          => 'name',
        'id_name'        => 'account_id_c',
        'related_fields' => array('account_id_c'),
    ),
    'LEAD_NAME' => array(
        'width'          => '12%',
        'label'          => 'LBL_LEAD_NAME',
        'default'        => true,
        'link'           => true,
        'relate'         => true,
        'module'         => 'Leads',
        'id'             => 'LEAD_ID',
        'name'           => 'lead_name',
        'rname'          => 'full_name',
        'id_name'        => 'lead_id',
        'related_fields' => array('lead_id'),
    ),
    'STATUS' => array(
        'width'   => '8%',
        'label'   => 'LBL_STATUS',
        'default' => true,
    ),
    'LEAD_TYPE' => array(
        'width'   => '8%',
        'label'   => 'LBL_LEAD_TYPE',
        'default' => true,
    ),
    'LEAD_SOURCE' => array(
        'width'   => '8%',
        'label'   => 'LBL_LEAD_SOURCE',
        'default' => true,
    ),
    'INTERESTED_YEAR' => array(
        'width'   => '6%',
        'label'   => 'LBL_INTERESTED_YEAR',
        'default' => true,
    ),
    'INTERESTED_MAKE' => array(
        'width'   => '10%',
        'label'   => 'LBL_INTERESTED_MAKE',
        'default' => true,
    ),
    'INTERESTED_MODEL' => array(
        'width'   => '10%',
        'label'   => 'LBL_INTERESTED_MODEL',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'width'   => '10%',
        'label'   => 'LBL_DATE_ENTERED',
        'default' => true,
    ),
);