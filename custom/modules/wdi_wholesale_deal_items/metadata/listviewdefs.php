<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$listViewDefs['wdi_wholesale_deal_items'] = array(
    'DEAL_NAME' => array('label' => 'LBL_DEAL_NAME', 'width' => '20%', 'default' => true),
    'VEHICLE_NAME' => array('label' => 'LBL_VEHICLE_NAME', 'width' => '18%', 'default' => true),
    'VIN' => array('label' => 'LBL_VIN', 'width' => '12%', 'default' => true),
    'STOCK_NUMBER' => array('label' => 'LBL_STOCK_NUMBER', 'width' => '12%', 'default' => true),
    'MAKE' => array('label' => 'LBL_MAKE', 'width' => '10%', 'default' => true),
    'MODEL' => array('label' => 'LBL_MODEL', 'width' => '10%', 'default' => true),
    'YEAR' => array('label' => 'LBL_YEAR', 'width' => '8%', 'default' => true),
    'PRICE' => array('label' => 'LBL_PRICE', 'width' => '10%', 'default' => true),
);
