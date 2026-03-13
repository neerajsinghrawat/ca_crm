<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$listViewDefs['wd_wholesale_deals'] = array(
    'DEAL_ID' => array('label' => 'LBL_DEAL_ID', 'width' => '10%', 'default' => true, 'link' => true),
    'WHOLESALER_NAME' => array('label' => 'LBL_WHOLESALER_NAME', 'width' => '16%', 'default' => true),
    'TOTAL_VEHICLE_COUNT' => array('label' => 'LBL_TOTAL_VEHICLES', 'width' => '8%', 'default' => true),
    'TOTAL_AMOUNT' => array('label' => 'LBL_TOTAL_AMOUNT', 'width' => '10%', 'default' => true),
    'AGREEMENT_STATUS' => array('label' => 'LBL_AGREEMENT_STATUS', 'width' => '10%', 'default' => true),
    'DOCUSIGN_STATUS' => array('label' => 'LBL_DOCUSIGN_STATUS', 'width' => '10%', 'default' => true),
    'DEAL_DATE' => array('label' => 'LBL_DEAL_DATE', 'width' => '10%', 'default' => true),
    'STATUS' => array('label' => 'LBL_STATUS', 'width' => '10%', 'default' => true),
);
