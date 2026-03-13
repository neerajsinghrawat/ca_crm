<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['ac_dealers'] = array(
    'NAME' => array(
        'label'   => 'LBL_NAME',
        'width'   => '20%',
        'default' => true,
        'link'    => true,
    ),
    'EMAIL' => array(
        'label'   => 'LBL_EMAIL',
        'width'   => '20%',
        'default' => true,
    ),
    'REPRESENTATIVE' => array(
        'label'   => 'LBL_REPRESENTATIVE',
        'width'   => '15%',
        'default' => true,
    ),
    'IS_WHOLESALER' => array(
        'label'   => 'LBL_IS_WHOLESALER',
        'width'   => '10%',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'label'   => 'LBL_DATE_ENTERED',
        'width'   => '15%',
        'default' => true,
    ),
);