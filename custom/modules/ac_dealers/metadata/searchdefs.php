<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'ac_dealers';
$searchdefs[$module_name] = array(
    'templateMeta' => array(
        'maxColumns'      => '3',
        'maxColumnsBasic' => '4',
        'widths'          => array('label' => '10', 'field' => '30'),
    ),
    'layout' => array(
        'basic_search' => array(
            'name',
            'email',                                                          // ✅ email
            array('name' => 'current_user_only', 'label' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'),
        ),
        'advanced_search' => array(
            'name',
            'email',                                                          // ✅ email
            array(
                'name'  => 'is_wholesaler',
                'label' => 'LBL_IS_WHOLESALER',
                'type'  => 'bool',
            ),
            array(
                'name'     => 'assigned_user_id',
                'label'    => 'LBL_ASSIGNED_TO',
                'type'     => 'enum',
                'function' => array('name' => 'get_user_array', 'params' => array(false))
            ),
        ),
    ),
);