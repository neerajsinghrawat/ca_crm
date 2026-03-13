<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['ac_dealers'] = array(
    'NAME' => array('label' => 'LBL_NAME', 'width' => '18%', 'default' => true, 'link' => true),
    'COMPANY' => array('label' => 'LBL_COMPANY', 'width' => '12%', 'default' => true),
    'PHONE' => array('label' => 'LBL_PHONE', 'width' => '10%', 'default' => true),
    'EMAIL' => array('label' => 'LBL_EMAIL', 'width' => '14%', 'default' => true),
    'LICENSE_NUMBER' => array('label' => 'LBL_LICENSE_NUMBER', 'width' => '10%', 'default' => true),
    'DEALER_STATUS' => array('label' => 'LBL_DEALER_STATUS', 'width' => '10%', 'default' => true),
    'IS_WHOLESALER' => array('label' => 'LBL_IS_WHOLESALER', 'width' => '8%', 'default' => true),
);