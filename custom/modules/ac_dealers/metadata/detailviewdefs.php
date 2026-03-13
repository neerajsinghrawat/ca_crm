<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'ac_dealers';
$viewdefs[$module_name]['DetailView'] = array(
    'templateMeta' => array(
        'form' => array(
            'buttons' => array(
                'EDIT',
                'DUPLICATE',
                'DELETE',
                array(
                    'customCode' => '{if $fields.is_wholesaler.value == 1}<input type="button" class="button" value="{$MOD.LBL_CREATE_WHOLESALE_DEAL}" onclick="window.open(\'index.php?module=ac_dealers&action=createWholesaleDealPopup&record={$fields.id.value}\', \'createWholesaleDeal\', \'width=1200,height=700,resizable=yes,scrollbars=yes\');" />{/if}',
                ),
            )
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
                array('name' => 'wholesale_discount', 'customCode' => '{if $fields.is_wholesaler.value == 1}{$fields.wholesale_discount.value}{/if}'),
                array('name' => 'preferred_vehicle_types', 'customCode' => '{if $fields.is_wholesaler.value == 1}{$fields.preferred_vehicle_types.value}{/if}'),
            ),
            array(
                array('name' => 'agreement_template', 'customCode' => '{if $fields.is_wholesaler.value == 1}{$fields.agreement_template.value}{/if}'),
                array('name' => 'docusign_email', 'customCode' => '{if $fields.is_wholesaler.value == 1}{$fields.docusign_email.value}{/if}'),
            ),
            array(
                array(
                    'name'=> 'date_entered',
                    'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    'label'=> 'LBL_DATE_ENTERED',
                ),
                array(
                    'name'       => 'date_modified',
                    'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    'label'      => 'LBL_DATE_MODIFIED',
                ),
            ),
            array('description'),
        )
    )
);