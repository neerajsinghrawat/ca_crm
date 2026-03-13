<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$module_name = 'wd_wholesale_deals';
$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 'widths' => array(array('label' => '10', 'field' => '30'), array('label' => '10', 'field' => '30'))),
    'panels' => array(
        'default' => array(
            array('deal_id', 'wholesaler_name'),
            array('deal_date', 'status'),
            array('total_vehicle_count', 'total_amount'),
            array('agreement_status', 'docusign_status'),
            array('agreement_template', 'docusign_envelope_id'),
            array('wholesale_price'),
            array('notes'),
        ),
    ),
);
