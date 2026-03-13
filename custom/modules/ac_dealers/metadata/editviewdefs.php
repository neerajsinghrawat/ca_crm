<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'ac_dealers';
$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array(
        'includes' => array(
            array('file' => 'custom/modules/ac_dealers/js/wholesaler_toggle.js'),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array(
        'default' => array(

            array('name', 'company'),
            array('phone', 'email'),
            array('address', 'license_number'),
            array('dealer_status', 'is_wholesaler'),
            
           
            array(
                array('name' => 'wholesale_discount', 'displayParams' => array('class' => 'wholesaler-only')),
                array('name' => 'preferred_vehicle_types', 'displayParams' => array('class' => 'wholesaler-only')),
            ),
            array(
                array('name' => 'agreement_template', 'displayParams' => array('class' => 'wholesaler-only')),
                array('name' => 'docusign_email', 'displayParams' => array('class' => 'wholesaler-only')),
            ),
            array(
                'description',
            ),
        ),
    ),
);