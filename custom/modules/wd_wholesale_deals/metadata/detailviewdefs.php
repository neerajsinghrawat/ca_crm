<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$module_name = 'wd_wholesale_deals';
$viewdefs[$module_name]['DetailView'] = array(
    'templateMeta' => array(
        'form' => array(
            'buttons' => array(
                'EDIT',
                'DUPLICATE',
                'DELETE',
                array('customCode' => '<input type="button" class="button" value="{$MOD.LBL_SEND_AGREEMENT}" onclick="window.location.href=\'index.php?module=wd_wholesale_deals&action=sendAgreementViaDocusign&record={$fields.id.value}\'" />'),
                array('customCode' => '<input type="button" class="button" value="{$MOD.LBL_VIEW_INVENTORY}" onclick="window.location.href=\'index.php?module=AOS_Products&action=index\'" />'),
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(array('label' => '10', 'field' => '30'), array('label' => '10', 'field' => '30')),
    ),
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
